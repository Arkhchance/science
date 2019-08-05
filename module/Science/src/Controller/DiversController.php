<?php
namespace Science\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Zend\View\Model\JsonModel;
use Science\Entity\MainStats;
use Science\Form\Divers\ContactForm;
use Science\Entity\Vulga;

class DiversController extends AbstractActionController
{

    private $entityManager;
    private $contactService;

    public function __construct($entityManager,$contactService)
    {
        $this->entityManager = $entityManager;
        $this->contactService = $contactService;
    }

    public function aproposAction()
    {
        return;
    }

    public function erreurAction()
    {
        $request = $this->getRequest();
        if ($request->isXmlHttpRequest()) {
            $view = new JsonModel();
            $view->setTerminal(true);
            $id = $this->params()->fromPost('id', null);
            if($id === null) {
                $view->setVariable('SUCCES','Error');
                return $view;
            }
            $vulga = $this->entityManager->getRepository(Vulga::class)
                          ->findOneByid($id);
            if($vulga === null) {
                $view->setVariable('SUCCES','Error');
                return $view;
            }
            $dom = [];
            foreach ($vulga->getDomaine() as $domaine) {
                $dom['id'][] = $domaine->getId();
                $dom['name'][] = $domaine->getNom();
            }
            $view->setVariable('SUCCES','Ok');
            $view->setVariable('sexe',$vulga->getSexe());
            $view->setVariable('langue',$vulga->getLangue()->getId());
            $view->setVariable('pays',$vulga->getPays()->getId());
            $view->setVariable('domaine',$dom);
            return $view;

        } else {
            $form = new ContactForm($this->entityManager);
            if (!$request->isPost()) {
                return ['form' => $form];
            }
            $form->setData($request->getPost());
            if (!$form->isValid()) {
                return ['form' => $form];
            }
            $data = $form->getData();

            $this->contactService->addMessage($data); 
            //process data
            return ['form' => $form, 'success' => true];
        }
        return ;
    }
}
