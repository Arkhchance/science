<?php
namespace Science\Form\Auth;

use Zend\Form\Form;
use Zend\Captcha;
use Zend\InputFilter\InputFilter;
use Zend\Validator\StringLength;
use Zend\Validator\EmailAddress;
use Zend\Validator\Identical;
use Zend\Filter\StringTrim;
use Zend\Filter\StripTags;
use Zend\Filter\ToInt;
use Mth\Validator\UserExistsValidator;
use DoctrineModule\Validator\ObjectExists as ObjectExistsValidator;
use DoctrineModule\Validator\NoObjectExists as NoObjectExistsValidator;
use Science\Entity\User;
use Science\Entity\Regkey;

class RegisterForm extends Form
{
    /**
     * Entity manager.
     * @var Doctrine\ORM\EntityManager
     */
    private $entityManager = null;

    /**
     * Current user.
     * @var Mth\Entity\User
     */
    private $user = null;

    public function __construct($entityManager = null, $user = null)
    {
        $this->entityManager = $entityManager;
        $this->user = $user;

        parent::__construct('user');

        $this->add([
            'name' => 'name',
            'type' => 'text',
            'options' => [
                'label' => 'Username',
            ],
        ]);
        $this->add([
            'name' => 'regkey',
            'type' => 'text',
            'options' => [
                'label' => 'your registration key',
            ],
        ]);
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
            'name' => 'pass',
            'type' => 'password',
            'options' => [
                'label' => 'Password',
            ],
        ]);
        $this->add([
            'name' => 'pass2',
            'type' => 'password',
            'options' => [
                'label' => 'Confirm your password',
            ],
        ]);
        $this->add([
            'name' => 'email',
            'type' => 'email',
            'options' => [
                'label' => 'Email',
            ],
        ]);
        $this->add([
            'name' => 'submit',
            'type' => 'submit',
            'attributes' => [
                'value' => 'Register',
                'id'    => 'submitbutton',
            ],
        ]);
        $this->addInputFilter();
    }

    private function addInputFilter()
    {
        // Create main input filter
        $inputFilter = $this->getInputFilter();

        $inputFilter->add([
            'name' => 'email',
            'required' => true,
            'filters' => [
                ['name' => StringTrim::class],
            ],
            'validators' => [
                [
                    'name' => EmailAddress::class,
                    'options' => [
                        'useMxCheck' => true,
                        'allow' => \Zend\Validator\Hostname::ALLOW_DNS,
                    ],
                ],
                [
                    'name' => NoObjectExistsValidator::class,
                    'options' => [
                        'object_repository' => $this->entityManager->getRepository(User::class),
                        'fields' => 'email',
                        'messages' => [
                            'objectFound' => 'This email is already registered',
                        ],
                    ],
                ],
            ],
        ]);
        $inputFilter->add([
            'name' => 'name',
            'required' => true,
            'filters' => [
                ['name' => StripTags::class],
                ['name' => StringTrim::class],
            ],
            'validators' => [
                [
                    'name' => StringLength::class,
                    'options' => [
                        'encoding' => 'UTF-8',
                        'min' => 1,
                        'max' => 25,
                    ],
                ],
                [
                    'name' => NoObjectExistsValidator::class,
                    'options' => [
                        'object_repository' => $this->entityManager->getRepository(User::class),
                        'fields' => 'name',
                        'messages' => [
                            'objectFound' => 'This name is already taken',
                        ],
                    ],
                ],
            ],
        ]);
        $inputFilter->add([
            'name' => 'regkey',
            'required' => true,
            'filters' => [
                ['name' => StringTrim::class],
            ],
            'validators' => [
                [
                    'name' => ObjectExistsValidator::class,
                    'options' => [
                        'object_repository' => $this->entityManager->getRepository(Regkey::class),
                        'fields' => 'key',
                        'messages' => [
                            'noObjectFound' => 'This key is invalid',
                        ],
                    ],
                ],
            ],
        ]);
        $inputFilter->add([
            'name' => 'pass',
            'required' => true,
            'validators' => [
                [
                    'name' => StringLength::class,
                    'options' => [
                        'encoding' => 'UTF-8',
                        'min' => 8,
                        'max' => 1024,
                    ],
                ],
            ],
        ]);
        $inputFilter->add([
            'name' => 'pass2',
            'required' => true,
            'validators' => [
                [
                    'name' => Identical::class,
                    'options' => [
                        'token' => 'pass',
                    ],
                ],
            ],
        ]);
    }
}
