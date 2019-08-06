<?php
namespace Science\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Zend\View\Model\JsonModel;
use Science\Entity\Vulga;
use Science\Entity\Domaine;
use Science\Form\Vulga\VulgaForm;

class VulgaController extends AbstractActionController
{

    private $entityManager;
    private $contactService;

    public function __construct($entityManager,$contactService)
    {
        $this->entityManager = $entityManager;
        $this->contactService = $contactService;
    }

    public function displayAction()
    {
        $vulgas = $this->entityManager->getRepository(Vulga::class)->findAll();
        return ['vulgas' => $vulgas];
    }

    public function refreshAction()
    {
        $request = $this->getRequest();
        if ($request->isXmlHttpRequest()) {

            $id = $this->params()->fromRoute('id', null);
            if($id === null) {
                return new JsonModel(['sucess' => 'Error']);
            }
            $this->contactService->addRefresh($id);
            return new JsonModel(['sucess' => 'Ok']);
        } else {
            return $this->redirect()->toRoute('vulgarisateurs', ['action' => 'display']);
        }
    }
    public function detailsAction()
    {
        $id = $this->params()->fromRoute('id', null);

        if($id === null)
            return $this->redirect()->toRoute('vulgarisateurs', ['action' => 'display']);

        $vulga = $this->entityManager->getRepository(Vulga::class)
                      ->findOneById($id);

        if($vulga === null)
            return $this->redirect()->toRoute('vulgarisateurs', ['action' => 'display']);

        $form = new VulgaForm();

        $request = $this->getRequest();
        if (!$request->isPost()) {
            return ['form' => $form,'vulga' => $vulga];
        }

        $form->setData($request->getPost());
        if (!$form->isValid()) {
            return ['form' => $form,'vulga' => $vulga];
        }
        $data = $form->getData();
        $this->contactService->addMessageVulga($data,$id);

        return ['vulga' => $vulga,'success' => true,'form' => $form,];
    }
}
