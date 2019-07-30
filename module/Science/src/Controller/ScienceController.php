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

    public function __construct($entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function indexAction()
    {
        $page = $this->params()->fromQuery('page', 1);
        $type = $this->params()->fromQuery('order', 'id');
        $sens = $this->params()->fromQuery('by', 'asc');

        $query = $this->entityManager->getRepository(MainStats::class)
            ->findByOrder($type,$sens);

        $adapter = new DoctrineAdapter(new ORMPaginator($query, false));
        $paginator = new Paginator($adapter);
        $paginator->setDefaultItemCountPerPage(15);
        $paginator->setCurrentPageNumber($page);

        return  [
            'stats' => $paginator,
            'type' => $type,
            'sens' => $sens
        ];
    }
    public function testAction()
    {
        $id = 'https://www.youtube.com/channel/UCfO4BQD5_S1272GVmuXmTxA';

        $ids = shell_exec("youtube-dl --get-id $id");

        return ['ids' => $ids];
    }
}
