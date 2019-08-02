<?php
namespace Science\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Zend\View\Model\JsonModel;
use Science\Entity\Vulga;
use Science\Entity\Plateforme;
use Science\Entity\Posts;
use Science\Entity\MainStats;
use DoctrineORMModule\Paginator\Adapter\DoctrinePaginator as DoctrineAdapter;
use Doctrine\ORM\Tools\Pagination\Paginator as ORMPaginator;
use Zend\Paginator\Paginator;

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
        $page = $this->params()->fromQuery('page', 1);
        $type = $this->params()->fromQuery('order', 'id');
        $sens = $this->params()->fromQuery('by', 'asc');

        $query = $this->entityManager->getRepository(MainStats::class)
            ->findByOrder($type,$sens)->getResult();
        /*
        $adapter = new DoctrineAdapter(new ORMPaginator($query, false));
        $paginator = new Paginator($adapter);
        $paginator->setDefaultItemCountPerPage(35);
        $paginator->setCurrentPageNumber($page);
        */
        return  [
            'stats' => $query,
            'type' => $type,
            'sens' => $sens
        ];
    }
    public function chartAction()
    {
        $datas = $this->dataService->prepareStats();

        return ['datas' => $datas];
    }
    public function statsAction()
    {
        $datas = $this->dataService->prepareStats();
        return ['datas' => $datas];
    }

    public function vulgastatsAction()
    {
        $order = $this->params()->fromQuery('order', 'nom');
        $sens = $this->params()->fromQuery('by', 'asc');

        $datas = $this->dataService->prepareStats($order,$sens);

        return ['datas' => $datas];
    }
}
