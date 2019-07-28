<?php
namespace Science\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Zend\View\Model\JsonModel;
use Science\Form\Manage\LangueForm;
use Science\Form\Manage\PaysForm;
use Science\Form\Manage\DomaineForm;
use Science\Form\Manage\PlateForm;
use Science\Entity\Plateforme;

class ManageController extends AbstractActionController
{
    private $dbManager;
    private $entityManager;

    public function __construct($dbManager,$entityManager)
    {
        $this->dbManager = $dbManager;
        $this->entityManager = $entityManager;
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
                    $result = $this->dbManager->delLangue($paramList);
                    break;
                case 'pays':
                    $result = $this->dbManager->delPays($paramList);
                    break;
                case 'domaine':
                    $result = $this->dbManager->delDomaine($paramList);
                    break;
                case 'plateforme':
                    $result = $this->dbManager->delPlateforme($paramList);
                    break;
                case 'vulga':
                    $result = $this->dbManager->delVulga($paramList);
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

        $this->dbManager->addLangue($data);

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
        $this->dbManager->addPays($data);

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
        $this->dbManager->addDomaine($data);

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
            $this->dbManager->addPlateforme($data);
        else
            $this->dbManager->editPlateforme($data);

        return $this->redirect()->toRoute('manage', ['action' => 'plateforme']);
    }
}
