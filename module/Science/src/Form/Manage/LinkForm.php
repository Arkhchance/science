<?php
namespace Science\Form\Manage;

use Zend\Form\Form;
use Zend\Form\Fieldset;
use Zend\InputFilter\InputFilter;
use Zend\Validator\StringLength;
use Zend\Filter\StringTrim;
use Zend\Filter\StripTags;
use Science\Entity\Vulga;

class LinkForm extends Form
{
    private $entityManager;
    /**
     * Constructor.
     */
    public function __construct($entityManager = null)
    {
        $this->entityManager = $entityManager;

        // Define form name
        parent::__construct('link-form');

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

    private function getArrayPlateforme()
    {
        $myPfs = [];
        $pfs = $this->entityManager->getRepository(Plateforme::class)->findAll();

        foreach ($pfs as $pf) {
            $myPfs[$pf->getId()] = $pf->getNom();
        }

        return $myPfs;
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
                'value' => 'Nouveau lien de plateforme',
                'id' => 'submit',
            ],
        ]);
        $this->add([
            'type' => 'select',
            'name' => 'vulga',
            'options' => [
                'label' => 'Vulgarisateur',
                'value_options' => $this->getArrayVulga(),
            ],
        ]);
        $this->add([
            'type'  => 'select',
            'name' => 'pf',
            'options' => [
                'label' => 'Plateforme',
                'value_options' => $this->getArrayPlateforme(),
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
