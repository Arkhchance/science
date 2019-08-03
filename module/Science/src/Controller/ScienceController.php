<?php
namespace Science\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Science\Entity\MainStats;
use Science\Form\Graph\GraphForm;

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

        return  ['stats' => $query];
    }

    public function getformAction()
    {
        $request = $this->getRequest();
        if ($request->isXmlHttpRequest()) {
            $view = new ViewModel();
            $view->setTerminal(true);

            $elements = $this->params()->fromPost('elements', 2);

            $form = new GraphForm($this->entityManager,$elements);

            $htmlView = new ViewModel();
            $htmlOutput = $htmlView
                 ->setTerminal(true)
                 ->setTemplate("science/science/getform")
                 ->setVariable('elements', $elements)
                 ->setVariable('form', $form);

            return $htmlOutput;

        } else {
            return $this->redirect()->toRoute('science', ['action' => 'graphperso']);
        }
    }

    public function graphpersoAction()
    {
        $request = $this->getRequest();
        $data = $request->getQuery();
        $data = $data->toArray();
        
        if(isset($data['elements'])) {
            return ['valid' => true];
        } else {
            return;
        }

    }

    public function graphsAction()
    {
        $datas = $this->dataService->prepareVulgaGraph();
        return ['datas' => $datas];
    }

    public function catgraphAction()
    {
        $datas = $this->dataService->prepareDomaineGraph();
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
