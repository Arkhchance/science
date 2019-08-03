<?php
namespace Science\Form\Graph;

use Zend\Form\Form;
use Zend\Form\Fieldset;
use Science\Entity\Vulga;
use Science\Entity\Domaine;
use Zend\InputFilter\OptionalInputFilter;

class GraphForm extends Form
{

    private $entityManager;
    private $elementCount;
    /**
     * Constructor.
     */
    public function __construct($entityManager = null,$elements = 2)
    {

        $this->entityManager = $entityManager;
        $this->elementCount = -1;
        // Define form name
        parent::__construct('graph-form');

        // Set get method for this form
        $this->setAttribute('method', 'get');

        for($i = 0; $i < $elements; $i++)
            $this->newElements();

        $this->addElements();
    }

    public function getElementCount()
    {
        return $this->elementCount;
    }

    private function getArrayVulga()
    {
        $myVulgas = [];
        $vulgas = $this->entityManager->getRepository(Vulga::class)->findAll();

        $myVulgas[-1] = "Tout le monde";
        $myVulgas[0] = "Selectionnez un vulgarisateur.trice";
        foreach ($vulgas as $vulga) {
            $myVulgas[$vulga->getId()] = $vulga->getNom();
        }

        return $myVulgas;
    }

    private function getArrayDomaine()
    {
        $myDomaines = [];

        $myDomaines[0] = "Selectionnez un domaine";
        $domaines = $this->entityManager->getRepository(Domaine::class)->findAll();

        foreach ($domaines as $domaine) {
            $myDomaines[$domaine->getId()] = $domaine->getNom();
        }

        return $myDomaines;
    }

    private function getArraySexe()
    {
        $mySexes = [];
        $mySexes[0] = "Selectionnez un genre";
        $mySexes = array_merge($mySexes,Vulga::getSexeList());

        return $mySexes;
    }

    private function newElements()
    {
        $this->elementCount++;
        if($this->elementCount > 10)
            return;
        $this->add([
            'type' => 'select',
            'name' => 'sexe'.$this->elementCount,
            'options' => [
                'label' => 'Genre ?',
                'value_options' => $this->getArraySexe(),
            ],
        ]);
        $this->add([
            'type' => 'select',
            'name' => 'domaine'.$this->elementCount,
            'options' => [
                'label' => 'Quel domaine',
                'value_options' => $this->getArrayDomaine(),
            ],
        ]);
        $this->add([
            'type' => 'select',
            'name' => 'vulga'.$this->elementCount,
            'attributes' =>  [
                'multiple' => true,
            ],
            'options' => [
                'label' => 'Quel Vulgarisateur.trice',
                'value_options' => $this->getArrayVulga(),
            ],
        ]);
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
                'value' => 'Valider',
                'id' => 'submit',
            ],
        ]);
        $this->add([
            'type'  => 'hidden',
            'name' => 'elements',
            'attributes' => [
                'value' => $this->elementCount + 1,
            ],
        ]);
    }
}
