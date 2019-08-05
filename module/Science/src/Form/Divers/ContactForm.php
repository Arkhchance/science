<?php
namespace Science\Form\Divers;

use Zend\Form\Form;
use Zend\Form\Fieldset;
use Zend\Captcha;
use Zend\Filter\StringTrim;
use Zend\Filter\StripTags;
use Zend\Validator\StringLength;
use Science\Entity\Vulga;
use Science\Entity\Langue;
use Science\Entity\Pays;
use Science\Entity\Domaine;

class ContactForm extends Form
{
    private $entityManager;
    /**
     * Constructor.
     */
    public function __construct($entityManager = null)
    {
        $this->entityManager = $entityManager;

        // Define form name
        parent::__construct('Vulga-form');

        // Set POST method for this form
        $this->setAttribute('method', 'post');

        $this->addElements();
        $this->addInputFilter();
    }

    private function getArrayVulga()
    {
        $myVulgas = [];
        $vulgas = $this->entityManager->getRepository(Vulga::class)->findAll();

        foreach ($vulgas as $vulga) {
            $myVulgas[$vulga->getId()] = $vulga->getNom();
        }

        return $myVulgas;
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

        $myDomaines[-1] = "Aucun de la liste";
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

        // Add the Submit button
        $this->add([
            'type'  => 'submit',
            'name' => 'submit',
            'attributes' => [
                'value' => 'Envoyer',
                'id' => 'submit',
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
        $this->add([
            'type'  => 'text',
            'name' => 'ndomaine',
            'options' => [
                'label' => 'Nouvelle catégorie',
            ],
        ]);
        $this->add([
            'type'  => 'text',
            'name' => 'nvulga',
            'options' => [
                'label' => 'Nouvelle chaîne',
            ],
        ]);
        $this->add([
            'type' => 'select',
            'name' => 'sexe',
            'options' => [
                'label' => 'Votre genre',
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
                'label' => 'Selectionnez les catégories',
                'value_options' => $this->getArrayDomaine(),
            ],
        ]);
        $this->add([
            'type' => 'select',
            'name' => 'vulga',
            'options' => [
                'label' => 'Selectionner une chaîne',
                'value_options' => $this->getArrayVulga(),
            ],
        ]);
        $this->add([
            'type'  => 'textarea',
            'name' => 'note',
            'options' => [
                'label' => 'note :',
            ],
        ]);
        $this->add([
            'type' => 'Zend\Form\Element\Captcha',
            'name' => 'captcha',
            'options' => [
                'label' => 'Humain ?',
                'captcha' => new Captcha\Dumb(),
            ],
        ]);
    }
    private function addInputFilter()
    {
        // Create main input filter
        $inputFilter = $this->getInputFilter();

        $inputFilter->add([
            'name'     => 'ndomaine',
            'required' => false,
            'filters'  => [
                ['name' => StringTrim::class],
                ['name' => StripTags::class]
            ],
            'validators' => [
                [
                    'name'    => StringLength::class,
                    'options' => [
                        'max' => 1024
                    ],
                ],
            ],
        ]);
        $inputFilter->add([
            'name'     => 'nvulga',
            'required' => false,
            'filters'  => [
                ['name' => StringTrim::class],
                ['name' => StripTags::class]
            ],
            'validators' => [
                [
                    'name'    => StringLength::class,
                    'options' => [
                        'max' => 1024
                    ],
                ],
            ],
        ]);
    }
}
