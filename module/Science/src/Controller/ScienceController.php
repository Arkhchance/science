<?php
namespace Science\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Science\Entity\Vulga;
use Science\Entity\Domaine;
use Science\Form\Graph\GraphForm;

class ScienceController extends AbstractActionController
{

    private $entityManager;
    private $statsService;
    private $graphService;

    public function __construct($entityManager,$statsService,$graphService)
    {
        $this->entityManager = $entityManager;
        $this->statsService = $statsService;
        $this->graphService = $graphService;
    }

    public function indexAction()
    {

        $query = $this->entityManager->getRepository(Vulga::class)
                      ->findAll();

        return  ['stats' => $query];
    }

    public function domaineAction()
    {
        $domaines = $this->entityManager->getRepository(Domaine::class)
                      ->findAll();

        return  ['domaines' => $domaines];
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
            $graphData = $this->graphService->constructGraph($data);
            return ['valid' => true,'graphData'=>$graphData,'data' => $data];
        } else {
            return;
        }

    }

    public function graphsAction()
    {
        $datas = $this->statsService->prepareVulgaGraph();
        return ['datas' => $datas];
    }

    public function catgraphAction()
    {
        $datas = $this->statsService->prepareDomaineGraph();
        return ['datas' => $datas];
    }

    public function statsAction()
    {
        $datas = $this->statsService->prepareVulgaStats();
        return ['datas' => $datas];
    }

    public function vulgastatsAction()
    {
        $order = $this->params()->fromQuery('order', 'nom');
        $sens = $this->params()->fromQuery('by', 'asc');

        $datas = $this->statsService->prepareVulgaStats($order,$sens);
        return ['datas' => $datas];
    }

    public function domainestatsAction()
    {
        $order = $this->params()->fromQuery('order', 'vid');
        $sens = $this->params()->fromQuery('by', 'asc');

        $datas = $this->statsService->prepareDomaineStats($order,$sens);
        return ['datas' => $datas];
    }
}
