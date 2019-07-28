<?php
namespace Science\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Zend\View\Model\JsonModel;
use Science\Form\Manage\LangueForm;

class ManageController extends AbstractActionController
{
    private $dbManager;

    public function __construct($dbManager)
    {
        $this->dbManager = $dbManager;
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
           return $this->redirect()->toRoute('manage', ['action' => 'langue']);
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
}
