<?php
namespace Science\Form\Manage;

use Zend\Form\Form;
use Zend\Form\Fieldset;
use Zend\InputFilter\InputFilter;
use Zend\Validator\StringLength;
use Zend\Filter\StringTrim;
use Zend\Filter\StripTags;

class LangueForm extends Form
{
    /**
     * Constructor.
     */
    public function __construct()
    {
        // Define form name
        parent::__construct('langue-form');

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
        $this->add([
            'type'  => 'text',
            'name' => 'langue',
            'options' => [
                'label' => 'Langue',
            ],
        ]);
        $this->add([
            'type'  => 'text',
            'name' => 'drapeau',
            'options' => [
                'label' => 'Drapeau',
            ],
        ]);
        $this->add([
            'type'  => 'text',
            'name' => 'code',
            'options' => [
                'label' => 'Code de la langue',
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
                'value' => 'Nouvelle langue',
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

        $inputFilter->add([
            'name'     => 'langue',
            'required' => true,
            'filters'  => [
                [
                    'name' => StringTrim::class,
                    'name' => StripTags::class,
                ],
            ],
            'validators' => [
                [
                    'name' => StringLength::class,
                    'options' => [
                        'encoding' => 'UTF-8',
                        'min' => 1,
                        'max' => 100,
                    ],
                ],
            ],
        ]);
        $inputFilter->add([
            'name'     => 'code',
            'required' => true,
            'filters'  => [
                [
                    'name' => StringTrim::class,
                    'name' => StripTags::class,
                ],
            ],
            'validators' => [
                [
                    'name' => StringLength::class,
                    'options' => [
                        'encoding' => 'UTF-8',
                        'min' => 1,
                        'max' => 10,
                    ],
                ],
            ],
        ]);
        $inputFilter->add([
            'name'     => 'drapeau',
            'required' => true,
            'filters'  => [
                [
                    'name' => StringTrim::class,
                    'name' => StripTags::class,
                ],
            ],
            'validators' => [
                [
                    'name' => StringLength::class,
                    'options' => [
                        'encoding' => 'UTF-8',
                        'min' => 1,
                        'max' => 5,
                    ],
                ],
            ],
        ]);
    }
}
