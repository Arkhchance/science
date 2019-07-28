<?php
namespace Science\Form\Manage;

use Zend\Form\Form;
use Zend\Form\Fieldset;
use Zend\InputFilter\InputFilter;
use Zend\Validator\StringLength;
use Zend\Filter\StringTrim;
use Zend\Filter\StripTags;
use Zend\Validator\Uri;
use Zend\Filter\ToInt;
use DoctrineModule\Validator\ObjectExists as ObjectExistsValidator;
use Science\Entity\Plateforme;

class PlateForm extends Form
{
    private $edit;
    private $entityManager;
    /**
     * Constructor.
     */
    public function __construct($entityManager = null, $edit = false)
    {
        $this->edit = $edit;
        $this->entityManager = $entityManager;

        // Define form name
        parent::__construct('plate-form');

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
        if($this->edit) {
            $this->add([
                'type'  => 'hidden',
                'name' => 'id',
                'options' => [
                    'label' => 'id',
                ],
            ]);
            // Add the Submit button
            $this->add([
                'type'  => 'submit',
                'name' => 'submit',
                'attributes' => [
                    'value' => 'Envoyer les modifs',
                    'id' => 'submit',
                ],
            ]);
        } else {
            // Add the Submit button
            $this->add([
                'type'  => 'submit',
                'name' => 'submit',
                'attributes' => [
                    'value' => 'Nouvelle plateforme',
                    'id' => 'submit',
                ],
            ]);
        }
        $this->add([
            'type'  => 'text',
            'name' => 'nom',
            'options' => [
                'label' => 'Nom de la plateforme',
            ],
        ]);
        $this->add([
            'type'  => 'text',
            'name' => 'adresse',
            'options' => [
                'label' => 'Adresse ',
            ],
        ]);
        $this->add([
            'type'  => 'text',
            'name' => 'pname',
            'options' => [
                'label' => 'Nom d\'une publication',
            ],
        ]);
        $this->add([
            'type'  => 'text',
            'name' => 'idregex',
            'options' => [
                'label' => 'Regex extraction id',
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
    }

    /**
     * This method creates input filter (used for form filtering/validation).
     */
    private function addInputFilter()
    {
        // Create main input filter
        $inputFilter = $this->getInputFilter();

        if($this->edit) {
            $inputFilter->add([
                'name'     => 'id',
                'required' => true,
                'filters'  => [
                    [
                        'name' => ToInt::class,
                    ],
                ],
                'validators' => [
                    [
                        'name' => ObjectExistsValidator::class,
                        'options' => [
                            'object_repository' => $this->entityManager->getRepository(Plateforme::class),
                            'fields' => 'id',
                            'messages' => [
                                'noObjectFound' => 'id not found',
                            ],
                        ],
                    ],
                ],
            ]);
        }

        $inputFilter->add([
            'name'     => 'nom',
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
                        'max' => 128,
                    ],
                ],
            ],
        ]);
        $inputFilter->add([
            'name'     => 'adresse',
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
                        'max' => 128,
                    ],
                ],
                [
                    'name' => Uri::class,
                ],
            ],
        ]);
        $inputFilter->add([
            'name'     => 'pname',
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
                        'max' => 255,
                    ],
                ],
            ],
        ]);
        $inputFilter->add([
            'name'     => 'idregex',
            'required' => false,
            'filters'  => [
                [
                    'name' => StringTrim::class,
                ],
            ],
            'validators' => [
                [
                    'name' => StringLength::class,
                    'options' => [
                        'encoding' => 'UTF-8',
                        'min' => 1,
                        'max' => 512,
                    ],
                ],
            ],
        ]);
    }
}
