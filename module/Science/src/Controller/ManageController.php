<?php
namespace Science\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Zend\View\Model\JsonModel;
use Science\Form\Manage\LangueForm;
use Science\Form\Manage\PaysForm;
use Science\Form\Manage\DomaineForm;
use Science\Form\Manage\PlateForm;
use Science\Form\Manage\VulgaForm;
use Science\Form\Manage\LinkForm;
use Science\Entity\Plateforme;
use Science\Entity\Vulga;

class ManageController extends AbstractActionController
{
    private $dbService;
    private $entityManager;

    public function __construct($dbService,$entityManager)
    {
        $this->dbService = $dbService;
        $this->entityManager = $entityManager;
    }

    public function vulgastateAction()
    {
        $request = $this->getRequest();
        if ($request->isXmlHttpRequest()) {
            $view = new JsonModel();
            $view->setTerminal(true);


            $key = $this->params()->fromPost('lid', null);
            $state = $this->params()->fromPost('state', null);
            if($key === null || $state === null) {
                $view->setVariable('SUCCES','Error');
                return $view;
            }
            $success = $this->dbService->changeState($key,$state);
            if($success) {
                $view->setVariable('SUCCES','OK');
                return $view;
            } else {
                $view->setVariable('SUCCES','Error');
                return $view;
            }

            $view->setVariable('SUCCES','Error');
            return $view;
        } else {
            return $this->redirect()->toRoute('manage');
        }
    }
    public function delAction()
    {
        $request = $this->getRequest();
        if ($request->isXmlHttpRequest()) {

            $view = new JsonModel();
            $view->setTerminal(true);
            $toDel = $this->params()->fromPost('type', null);
            $paramList = $this->params()->fromPost('id', null);

            if($paramList == null) {
                $view->setVariable('SUCCES','Incorrect Input');
                return $view;
            }

            switch ($toDel) {
                case 'langue':
                    $result = $this->dbService->delLangue($paramList);
                    break;
                case 'pays':
                    $result = $this->dbService->delPays($paramList);
                    break;
                case 'domaine':
                    $result = $this->dbService->delDomaine($paramList);
                    break;
                case 'plateforme':
                    $result = $this->dbService->delPlateforme($paramList);
                    break;
                case 'vulga':
                    $result = $this->dbService->delVulga($paramList);
                    break;
                case 'pfvulga':
                    $pf = $this->params()->fromPost('pfid', null);
                    $vulga = $this->params()->fromPost('vulgaid', null);
                    $result = $this->dbService->delPlateformeVulga($pf,$vulga);
                    break;
                default:
                    $view->setVariable('SUCCES','Incorrect Input');
                    return $view;
                    break;
            }

            if($result)  //all is delete
                $view->setVariable('SUCCES','OK');
            else
                $view->setVariable('SUCCES','PARTIAL');

            return $view;

        } else {
           return $this->redirect()->toRoute('home');
        }
    }

    public function langueAction()
    {
        $form = new LangueForm();

        $request = $this->getRequest();

        if (!$request->isPost()) {
            return ['form' => $form];
        }

        $form->setData($request->getPost());

        if (!$form->isValid()) {
            return ['form' => $form];
        }

        $data = $form->getData();

        $this->dbService->addLangue($data);

        return $this->redirect()->toRoute('manage', ['action' => 'langue']);
    }

    public function paysAction()
    {
        $form = new PaysForm();

        $request = $this->getRequest();

        if (!$request->isPost()) {
            return ['form' => $form];
        }

        $form->setData($request->getPost());

        if (!$form->isValid()) {
            return ['form' => $form];
        }

        $data = $form->getData();
        $this->dbService->addPays($data);

        return $this->redirect()->toRoute('manage', ['action' => 'pays']);
    }

    public function domaineAction()
    {
        $form = new DomaineForm();

        $request = $this->getRequest();

        if (!$request->isPost()) {
            return ['form' => $form];
        }

        $form->setData($request->getPost());

        if (!$form->isValid()) {
            return ['form' => $form];
        }

        $data = $form->getData();
        $this->dbService->addDomaine($data);

        return $this->redirect()->toRoute('manage', ['action' => 'domaine']);
    }

    public function plateformeAction()
    {
        $id = $this->params()->fromRoute('id', null);

        if($id === null) {
            $form = new PlateForm();
            $pf = null;
        } else {
            $pf = $this->entityManager->getRepository(Plateforme::class)
                            ->findOneById($id);
            //sanity check
            if($pf === null)
                return $this->redirect()->toRoute('manage');

            $form = new PlateForm($this->entityManager,true);
        }

        $request = $this->getRequest();

        if (!$request->isPost()) {
            return ['form' => $form, 'pf' => $pf];
        }

        $form->setData($request->getPost());

        if (!$form->isValid()) {
            return ['form' => $form,'pf' => $pf];
        }

        $data = $form->getData();
        if($id === null)
            $this->dbService->addPlateforme($data);
        else
            $this->dbService->editPlateforme($data);

        return $this->redirect()->toRoute('manage', ['action' => 'plateforme']);
    }

    public function vulgaAction()
    {
        $page = $this->params()->fromQuery('page', 1);
        $id = $this->params()->fromRoute('id', null);

        if($id === null) {
            $form = new VulgaForm($this->entityManager);
            $vulga = null;
        } else {
            $vulga = $this->entityManager->getRepository(Vulga::class)
                            ->findOneById($id);
            //sanity check
            if($vulga === null)
                return $this->redirect()->toRoute('manage');

            $form = new VulgaForm($this->entityManager,true);
        }

        $request = $this->getRequest();

        if (!$request->isPost()) {
            return ['form' => $form, 'vulga' => $vulga, 'page' => $page];
        }

        $form->setData($request->getPost());

        if (!$form->isValid()) {
            return ['form' => $form,'vulga' => $vulga, 'page' => $page];
        }

        $data = $form->getData();
        if($id === null)
            $this->dbService->addVulga($data);
        else
            $this->dbService->editVulga($data);

        return $this->redirect()->toRoute('manage', ['action' => 'vulga']);
    }

    public function linkAction()
    {
        $page = $this->params()->fromQuery('page', 1);

        $form = new LinkForm($this->entityManager);

        $request = $this->getRequest();

        if (!$request->isPost()) {
            return ['form' => $form, 'page' => $page];
        }

        $form->setData($request->getPost());

        if (!$form->isValid()) {
            return ['form' => $form, 'page' => $page];
        }

        $data = $form->getData();
        $this->dbService->addPlateformeVulga($data);

        return $this->redirect()->toRoute('manage', ['action' => 'link']);
    }
}
