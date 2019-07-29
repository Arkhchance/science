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
use DoctrineModule\Validator\NoObjectExists as NoObjectExistsValidator;
use Science\Entity\Vulga;
use Science\Entity\Langue;
use Science\Entity\Pays;
use Science\Entity\Domaine;

class VulgaForm extends Form
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
        parent::__construct('Vulga-form');

        // Set POST method for this form
        $this->setAttribute('method', 'post');

        $this->addElements();
        $this->addInputFilter();
    }

    private function getArrayLangue()
    {
        $myLangues = [];

        $langues = $this->entityManager->getRepository(Langue::class)->findAll();

        foreach ($langues as $langue) {
            $myLangues[$langue->getId()] = $langue->getDrapeau()." ".$langue->getNom();
        }

        return $myLangues;
    }

    private function getArrayDomaine()
    {
        $myDomaines = [];

        $domaines = $this->entityManager->getRepository(Domaine::class)->findAll();

        foreach ($domaines as $domaine) {
            $myDomaines[$domaine->getId()] = $domaine->getNom();
        }

        return $myDomaines;
    }

    private function getArrayPays()
    {
        $myPays = [];

        $payss = $this->entityManager->getRepository(Pays::class)->findAll();

        foreach ($payss as $pays) {
            $myPays[$pays->getId()] = $pays->getDrapeau()." ".$pays->getNom();
        }

        return $myPays;
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
                    'value' => 'Nouveau Vulgarisateur',
                    'id' => 'submit',
                ],
            ]);
        }
        $this->add([
            'type'  => 'text',
            'name' => 'nom',
            'options' => [
                'label' => 'Nom du vulgarisateur.trice',
            ],
        ]);
        $this->add([
            'type' => 'select',
            'name' => 'sexe',
            'options' => [
                'label' => 'Sexe ?',
                'value_options' => Vulga::getSexeList(),
            ],
        ]);
        $this->add([
            'type'  => 'select',
            'name' => 'langue',
            'options' => [
                'label' => 'Langue la plus utilisé',
                'value_options' => $this->getArrayLangue(),
            ],
        ]);
        $this->add([
            'type'  => 'select',
            'name' => 'pays',
            'options' => [
                'label' => 'Pays du vulgarisateur',
                'value_options' => $this->getArrayPays(),
            ],
        ]);
        $this->add([
            'type' => 'select',
            'name' => 'domaine',
            'attributes' =>  [
                'multiple' => true,
            ],
            'options' => [
                'label' => 'Dans quel domaine iel vulgarise',
                'value_options' => $this->getArrayDomaine(),
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
                            'object_repository' => $this->entityManager->getRepository(Vulga::class),
                            'fields' => 'id',
                            'messages' => [
                                'noObjectFound' => 'id not found',
                            ],
                        ],
                    ],
                ],
            ]);
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
                            'max' => 512,
                        ],
                    ],
                ],
            ]);
        } else {
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
                            'max' => 512,
                        ],
                    ],
                    [
                        'name' => NoObjectExistsValidator::class,
                        'options' => [
                            'object_repository' => $this->entityManager->getRepository(Vulga::class),
                            'fields' => 'nom',
                            'messages' => [
                                'objectFound' => 'ce nom existe déjà',
                            ],
                        ],
                    ],
                ],
            ]);
        }
    }
}
