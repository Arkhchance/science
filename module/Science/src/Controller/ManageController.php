<?php
namespace Science\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Zend\View\Model\JsonModel;
use Science\Form\Manage\LangueForm;

class ManageController extends AbstractActionController
{
    public function __construct()
    {
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

        //$this->trickManager->newTrick($data);

        return $this->redirect()->toRoute('manage', ['action' => 'langue']);
    }
}
