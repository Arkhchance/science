<?php
namespace Science\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Zend\View\Model\JsonModel;
use Science\Entity\Vulga;
use Science\Entity\Plateforme;
use Science\Entity\Posts;
use Science\Entity\MainStats;

class ScienceController extends AbstractActionController
{

    private $entityManager;
    private $dataService;

    public function __construct($entityManager,$dataService)
    {
        $this->entityManager = $entityManager;
        $this->dataService = $dataService;
    }

    public function indexAction()
    {
        $type = $this->params()->fromQuery('order', 'id');
        $sens = $this->params()->fromQuery('by', 'asc');

        $query = $this->entityManager->getRepository(MainStats::class)
            ->findByOrder($type,$sens)->getResult();

        return  [
            'stats' => $query,
        ];
    }

    public function chartAction()
    {
        $datas = $this->dataService->prepareStats();

        return ['datas' => $datas];
    }

    public function statsAction()
    {
        $datas = $this->dataService->prepareVulgaStats();
        return ['datas' => $datas];
    }

    public function vulgastatsAction()
    {
        $order = $this->params()->fromQuery('order', 'nom');
        $sens = $this->params()->fromQuery('by', 'asc');

        $datas = $this->dataService->prepareVulgaStats($order,$sens);

        return ['datas' => $datas];
    }

    public function domainestatsAction()
    {
        $order = $this->params()->fromQuery('order', 'vid');
        $sens = $this->params()->fromQuery('by', 'asc');

        $datas = $this->dataService->prepareDomaineStats($order,$sens);

        return ['datas' => $datas];
    }
}
