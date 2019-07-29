<?php
namespace Science\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Zend\View\Model\JsonModel;


class ScienceController extends AbstractActionController
{

    private $entityManager;

    public function __construct($entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function indexAction()
    {
        //macroscopie
        $vulga = $this->entityManager->getRepository(Vulga::class)
                        ->findOneById(23);

        $ytchannel =
    }
}
