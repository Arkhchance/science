<?php
namespace Science\Form\Auth;

use Zend\Form\Form;
use Zend\InputFilter\InputFilter;
use DoctrineModule\Validator\ObjectExists as ObjectExistsValidator;
use Science\Entity\User;

class PasswordResetForm extends Form
{
    /**
     * Entity manager.
     * @var Doctrine\ORM\EntityManager
     */
    private $entityManager = null;

    /**
     * Constructor.
     */
    public function __construct($entityManager = null)
    {
        $this->entityManager = $entityManager;

        // Define form name
        parent::__construct('password-reset-form');

        // Set POST method for this form
        $this->setAttribute('method', 'post');

        $this->addElements();
        $this->addInputFilter();
    }

    protected function addElements()
    {
        // "email" field
        $this->add([
            'type'  => 'email',
            'name' => 'email',
            'options' => [
                'label' => 'Your E-mail',
            ],
        ]);

        // CAPTCHA field
        $this->add([
            'type' => 'captcha',
            'name' => 'captcha',
            'options' => [
                'label' => 'Human check',
                'captcha' => [
                    'class' => 'Image',
                    'imgDir' => 'public/img/captcha',
                    'suffix' => '.png',
                    'imgUrl' => '/img/captcha/',
                    'imgAlt' => 'CAPTCHA Image',
                    'font' => './data/font/thorne_shaded.ttf',
                    'fsize' => 24,
                    'width' => 350,
                    'height' => 100,
                    'expiration' => 600,
                    'dotNoiseLevel' => 40,
                    'lineNoiseLevel' => 3
                ],
            ],
        ]);

        $this->add([
            'type' => 'csrf',
            'name' => 'csrf',
            'options' => [
                'csrf_options' => [
                'timeout' => 600
                ]
            ],
        ]);

        $this->add([
            'type'  => 'submit',
            'name' => 'submit',
            'attributes' => [
                'value' => 'Reset Password',
                'id' => 'submit',
            ],
        ]);
    }

    private function addInputFilter()
    {
        // Create main input filter
        $inputFilter = $this->getInputFilter();

        // Add input for "email" field
        $inputFilter->add([
            'name'     => 'email',
            'required' => true,
            'filters'  => [
                ['name' => 'StringTrim'],
            ],
            'validators' => [
                [
                    'name' => 'EmailAddress',
                    'options' => [
                        'allow' => \Zend\Validator\Hostname::ALLOW_DNS,
                        'useMxCheck'    => false,
                    ],
                ],
                [
                    'name' => ObjectExistsValidator::class,
                    'options' => [
                        'object_repository' => $this->entityManager->getRepository(User::class),
                        'fields' => 'email',
                        'messages' => [
                            'noObjectFound' => 'Email is not registered',
                        ],
                    ],
                ],
            ],
        ]);
    }
}
