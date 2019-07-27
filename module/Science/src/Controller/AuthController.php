<?php

namespace Science\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Zend\Authentication\Result;
use Zend\Uri\Uri;
use Science\Form\Auth\LoginForm;
use Science\Form\Auth\RegisterForm;
use Science\Form\Auth\PasswordResetForm;
use Science\Form\Auth\SetPasswordForm;
use Science\Entity\User;

/**
 * This controller is responsible for letting the user to log in and log out.
 */
class AuthController extends AbstractActionController
{
    /**
     * Entity manager.
     * @var Doctrine\ORM\EntityManager
     */
    private $entityManager;

    /**
     * Auth manager.
     * @var User\Service\AuthManager
     */
    private $authManager;

    private $userManager;

    /**
     * Constructor.
     */
    public function __construct($entityManager, $authManager,$userManager)
    {
        $this->entityManager = $entityManager;
        $this->authManager = $authManager;
        $this->userManager = $userManager;
    }

    public function setPasswordAction()
    {
        $email = $this->params()->fromQuery('email', null);
        $token = $this->params()->fromQuery('token', null);

        if($token===null ||
           !$this->userManager->validatePasswordResetToken($email, $token)) {
            //return $this->redirect()->toRoute('home');
        }
        // Create form
        $form = new SetPasswordForm;

        // Check if user has submitted the form
        if ($this->getRequest()->isPost()) {

            // Fill in the form with POST data
            $data = $this->params()->fromPost();

            $form->setData($data);

            // Validate form
            if($form->isValid()) {

                $data = $form->getData();

                // Set new password for the user.
                $this->userManager->setNewPasswordByToken($email, $token, $data['new_password']);
                return $this->redirect()->toRoute('login');
            }
        }

        return ['form' => $form];
    }

    public function registerAction()
    {
        $form = new RegisterForm($this->entityManager);
        $request = $this->getRequest();

        if (!$request->isPost()) {
            return ['form' => $form];
        }

        $form->setData($request->getPost());

        if (!$form->isValid()) {
            return ['form' => $form];
        }

        $data = $form->getData();

        $this->userManager->newUser($data);
        return $this->redirect()->toRoute('login');
    }

    public function resetPasswordAction()
    {
        // Create form
        $form = new PasswordResetForm($this->entityManager);

        // Check if user has submitted the form
        if ($this->getRequest()->isPost()) {

            // Fill in the form with POST data
            $data = $this->params()->fromPost();

            $form->setData($data);

            // Validate form
            if($form->isValid()) {

                // Look for the user with such email.

                $user = $this->entityManager->getRepository(User::class)
                        ->findOneByEmail($data['email']);

                //email does not exist
                if($user === null)
                    return ['form' => $form,'error' => true];

                $this->userManager->generatePasswordResetToken($user);

                return [
                    'form' => $form,
                    'send' => true,
                ];
            }
        }

        return ['form' => $form];
    }

    /**
     * Authenticates user given email address and password credentials.
     */
    public function loginAction()
    {
        // Retrieve the redirect URL (if passed). We will redirect the user to this
        // URL after successfull login.
        $redirectUrl = (string)$this->params()->fromQuery('redirectUrl', '');
        if (strlen($redirectUrl)>2048) {
            throw new \Exception("Too long redirectUrl argument passed");
        }

        // Create login form
        $form = new LoginForm();
        $form->get('redirect_url')->setValue($redirectUrl);

        // Store login status.
        $isLoginError = false;

        // Check if user has submitted the form
        if ($this->getRequest()->isPost()) {

            // Fill in the form with POST data
            $data = $this->params()->fromPost();

            $form->setData($data);

            // Validate form
            if($form->isValid()) {

                // Get filtered and validated data
                $data = $form->getData();

                // Perform login attempt.
                $result = $this->authManager->login($data['email'],
                        $data['password'], $data['remember_me']);

                // Check result.
                if ($result->getCode() == Result::SUCCESS) {

                    // Get redirect URL.
                    $redirectUrl = $this->params()->fromPost('redirect_url', '');

                    if (!empty($redirectUrl)) {
                        // The below check is to prevent possible redirect attack
                        // (if someone tries to redirect user to another domain).
                        $uri = new Uri($redirectUrl);
                        if (!$uri->isValid() || $uri->getHost()!=null)
                            throw new \Exception('Incorrect redirect URL: ' . $redirectUrl);
                    }

                    // If redirect URL is provided, redirect the user to that URL;
                    // otherwise redirect to Home page.
                    if(empty($redirectUrl)) {
                        return $this->redirect()->toRoute('home');
                    } else {
                        $this->redirect()->toUrl($redirectUrl);
                    }
                } else {
                    $isLoginError = true;
                }
            } else {
                $isLoginError = true;
            }
        }

        return new ViewModel([
            'form' => $form,
            'isLoginError' => $isLoginError,
            'redirectUrl' => $redirectUrl
        ]);
    }

    /**
     * The "logout" action performs logout operation.
     */
    public function logoutAction()
    {
        $this->authManager->logout();

        return $this->redirect()->toRoute('home');
    }
}
