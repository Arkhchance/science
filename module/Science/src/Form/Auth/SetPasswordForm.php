<?php
namespace Science\Form\Auth;

use Zend\Form\Form;
use Zend\InputFilter\InputFilter;
use Zend\Validator\StringLength;
use Zend\Validator\Identical;

class SetPasswordForm extends Form
{
    /**
     * Constructor.
     */
    public function __construct()
    {
        // Define form name
        parent::__construct('set-password-form');

        // Set POST method for this form
        $this->setAttribute('method', 'post');

        $this->addElements();
        $this->addInputFilter();
    }

    protected function addElements()
    {
        // Add "new_password" field
            $this->add([
                'type'  => 'password',
                'name' => 'new_password',
                'options' => [
                    'label' => 'New Password',
                ],
            ]);

            // Add "confirm_new_password" field
            $this->add([
                'type'  => 'password',
                'name' => 'confirm_new_password',
                'options' => [
                    'label' => 'Confirm new password',
                ],
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
                    'value' => 'Change Password'
                ],
            ]);
    }

    private function addInputFilter()
    {
        // Create main input filter
        $inputFilter = $this->getInputFilter();

        // Add input for "new_password" field
        $inputFilter->add([
                'name'     => 'new_password',
                'required' => true,
                'filters'  => [
                ],
                'validators' => [
                    [
                        'name'    => StringLength::class,
                        'options' => [
                            'min' => 8,
                            'max' => 1024
                        ],
                    ],
                ],
            ]);

        // Add input for "confirm_new_password" field
        $inputFilter->add([
                'name'     => 'confirm_new_password',
                'required' => true,
                'filters'  => [
                ],
                'validators' => [
                    [
                        'name'    => Identical::class,
                        'options' => [
                            'token' => 'new_password',
                        ],
                    ],
                ],
            ]);
    }
}
