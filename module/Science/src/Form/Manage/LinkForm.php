<?php
namespace Science\Form\Manage;

use Zend\Form\Form;
use Zend\Form\Fieldset;
use Zend\InputFilter\InputFilter;
use Zend\Validator\StringLength;
use Zend\Filter\StringTrim;
use Zend\Filter\StripTags;
use Science\Entity\Vulga;
use Science\Entity\Plateforme;

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
            'type'  => 'text',
            'name' => 'link',
            'options' => [
                'label' => 'lien de la plateforme',
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
            'name'     => 'link',
            'required' => true,
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
                        'max' => 256,
                    ],
                ],
            ],
        ]);
    }
}
