<?php
namespace Science\Service;

use Science\Entity\User;
use Zend\Math\Rand;
use Zend\Mail;
use Zend\Mail\Transport\Smtp as SmtpTransport;
use Zend\Mail\Transport\SmtpOptions;
use Zend\Mime\Message as MimeMessage;
use Zend\Mime\Part as MimePart;

/**
 * This service is responsible for adding/editing users
 * and changing user password.
 */
class UserManager
{
    /**
     * Doctrine entity manager.
     * @var Doctrine\ORM\EntityManager
     */
    private $entityManager;

    /**
     * PHP template renderer.
     * @var type
     */
    private $viewRenderer;

    /**
     * Application config.
     * @var type
     */
    private $config;

    /**
     * Constructs the service.
     */
    public function __construct($entityManager, $viewRenderer, $config)
    {
        $this->entityManager = $entityManager;
        $this->viewRenderer = $viewRenderer;
        $this->config = $config;
    }
    protected function hashPass($pass)
    {
        $pepper = $this->config['pepper'];
        $algo = PASSWORD_ARGON2ID;
        $options = [
            'memory_cost' => 1<<17, // 128 Mb
            'time_cost'   => 16,
            'threads'     => 4,
        ];

        return password_hash($pass.$pepper,$algo,$options);
    }

    /**
     * This method adds a new user.
     */
     public function newUser($data)
     {
         //check if username exist
         if($this->checkUserExists($data['email'])) {
             return false;
         }

         $user = new User();
         $user->setEmail($data['email']);
         $user->setName($data['name']);

         $hashpass = $this->hashPass($data['pass']);
         $user->setPassword($hashpass);

         $currentDate = date('Y-m-d H:i:s');
         $user->setDateCreated($currentDate);

         // Add the entity to the entity manager.
         $this->entityManager->persist($user);

         // Apply changes to database.
         $this->entityManager->flush();
         return true;

     }

    /**
     * Checks whether an active user with given email address already exists in the database.
     */
    public function checkUserExists($email) {

        $user = $this->entityManager->getRepository(User::class)
                ->findOneByEmail($email);

        return $user !== null;
    }

    /**
     * Generates a password reset token for the user. This token is then stored in database and
     * sent to the user's E-mail address. When the user clicks the link in E-mail message, he is
     * directed to the Set Password page.
     */
    public function generatePasswordResetToken($user)
    {

        // Generate a token.
        $token = Rand::getString(32, '0123456789abcdefghijklmnopqrstuvwxyz', true);

        // Encrypt the token before storing it in DB.
        $tokenHash = $this->hashPass($token);

        // Save token to DB
        $user->setPasswordResetToken($tokenHash);

        // Save token creation date to DB.
        $currentDate = date('Y-m-d H:i:s');
        $user->setPasswordResetTokenCreationDate($currentDate);

        // Apply changes to DB.
        $this->entityManager->flush();

        // Send an email to user.
        $subject = 'Password Reset';

        $httpHost = isset($_SERVER['HTTP_HOST'])?$_SERVER['HTTP_HOST']:'localhost';
        $passwordResetUrl = 'http://' . $httpHost . '/set-password?token=' . $token . "&email=" . $user->getEmail();

        // Produce HTML of password reset email
        $bodyHtml = $this->viewRenderer->render(
                'user/email/reset-password-email',
                [
                    'passwordResetUrl' => $passwordResetUrl,
                ]);

        $html = new MimePart($bodyHtml);
        $html->type = "text/html";

        $body = new MimeMessage();
        $body->addPart($html);

        $mail = new Mail\Message();
        $mail->setEncoding('UTF-8');
        $mail->setBody($body);
        $mail->setFrom('no-reply@arkhchance.ovh', 'Science Stats');
        $mail->addTo($user->getEmail(), $user->getName());
        $mail->setSubject($subject);

        // Setup SMTP transport
        $transport = new SmtpTransport();
        $options   = new SmtpOptions();
        $transport->setOptions($options);

        $transport->send($mail);
    }

    /**
     * Checks whether the given password reset token is a valid one.
     */
    public function validatePasswordResetToken($email, $passwordResetToken)
    {
        // Find user by email.
        $user = $this->entityManager->getRepository(User::class)
                ->findOneByEmail($email);

        if($user==null) {
            return false;
        }

        // Check that token hash matches the token hash in our DB.
        $tokenHash = $user->getPasswordResetToken();

        $match = password_verify($passwordResetToken.$this->config['pepper'], $tokenHash);

        if (!$match)) {
            return false; // mismatch
        }

        // Check that token was created not too long ago.
        $tokenCreationDate = $user->getPasswordResetTokenCreationDate();
        $tokenCreationDate = strtotime($tokenCreationDate);

        $currentDate = strtotime('now');

        if ($currentDate - $tokenCreationDate > 24*60*60) {
            return false; // expired
        }

        return true;
    }

    /**
     * This method sets new password by password reset token.
     */
    public function setNewPasswordByToken($email, $passwordResetToken, $newPassword)
    {
        if (!$this->validatePasswordResetToken($email, $passwordResetToken)) {
           return false;
        }

        // Find user with the given email.
        $user = $this->entityManager->getRepository(User::class)
                ->findOneByEmail($email);

        if ($user==null || $user->getStatus() != User::STATUS_ACTIVE) {
            return false;
        }

        // Set new password for user
        $user->setPassword($this->hashPass($newPassword));

        // Remove password reset token
        $user->setPasswordResetToken(null);
        $user->setPasswordResetTokenCreationDate(null);

        $this->entityManager->flush();

        return true;
    }

}
