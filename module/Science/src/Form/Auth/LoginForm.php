<?php
namespace Science\Form\Auth;

use Zend\Form\Form;
use Zend\Form\Fieldset;
use Zend\InputFilter\InputFilter;
use Zend\Validator\StringLength;
use Zend\Validator\EmailAddress;
use Zend\Validator\InArray;
use Zend\Filter\StringTrim;
/**
 * This form is used to collect user's login, password and 'Remember Me' flag.
 */
class LoginForm extends Form
{
    /**
     * Constructor.
     */
    public function __construct()
    {
        // Define form name
        parent::__construct('login-form');

        // Set POST method for this form
        $this->setAttribute('method', 'post');

        $this->addElements();
        $this->addInputFilter();
    }

    /**
     * This method adds elements to form (input fields and submit button).
     */
    protected function addElements()
    {
        // Add "email" field
        $this->add([
            'type'  => 'text',
            'name' => 'email',
            'options' => [
                'label' => 'Your E-mail',
            ],
        ]);

        // Add "password" field
        $this->add([
            'type'  => 'password',
            'name' => 'password',
            'options' => [
                'label' => 'Password',
            ],
        ]);

        // Add "remember_me" field
        $this->add([
            'type'  => 'checkbox',
            'name' => 'remember_me',
            'options' => [
                'label' => 'Remember me',
            ],
        ]);

        // Add "redirect_url" field
        $this->add([
            'type'  => 'hidden',
            'name' => 'redirect_url'
        ]);

        // Add the CSRF field
        $this->add([
            'type' => 'csrf',
            'name' => 'csrf',
            'options' => [
                'csrf_options' => [
                'timeout' => 600
                ]
            ],
        ]);

        // Add the Submit button
        $this->add([
            'type'  => 'submit',
            'name' => 'submit',
            'attributes' => [
                'value' => 'Sign in',
                'id' => 'submit',
            ],
        ]);
    }

    /**
     * This method creates input filter (used for form filtering/validation).
     */
    private function addInputFilter()
    {
        // Create main input filter
        $inputFilter = $this->getInputFilter();

        // Add input for "email" field
        $inputFilter->add([
                'name'     => 'email',
                'required' => true,
                'filters'  => [
                    ['name' => StringTrim::class],
                ],
                'validators' => [
                    [
                        'name' => EmailAddress::class,
                        'options' => [
                            'allow' => \Zend\Validator\Hostname::ALLOW_DNS,
                            'useMxCheck' => false,
                        ],
                    ],
                ],
            ]);

        // Add input for "password" field
        $inputFilter->add([
                'name'     => 'password',
                'required' => true,
                'filters'  => [
                ],
                'validators' => [
                    [
                        'name'    => StringLength::class,
                        'options' => [
                            'min' => 6,
                            'max' => 1024
                        ],
                    ],
                ],
            ]);

        // Add input for "remember_me" field
        $inputFilter->add([
                'name'     => 'remember_me',
                'required' => false,
                'filters'  => [
                ],
                'validators' => [
                    [
                        'name'    => InArray::class,
                        'options' => [
                            'haystack' => [0, 1],
                        ]
                    ],
                ],
            ]);

        // Add input for "redirect_url" field
        $inputFilter->add([
                'name'     => 'redirect_url',
                'required' => false,
                'filters'  => [
                    ['name' => StringTrim::class]
                ],
                'validators' => [
                    [
                        'name'    => StringLength::class,
                        'options' => [
                            'min' => 0,
                            'max' => 2048
                        ]
                    ],
                ],
            ]);
    }
}
