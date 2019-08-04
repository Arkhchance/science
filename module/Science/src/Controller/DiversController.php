<?php
namespace Science\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Science\Entity\MainStats;
use Science\Form\Divers\ContactForm;

class DiversController extends AbstractActionController
{

    private $entityManager;

    public function __construct($entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function aproposAction()
    {
        return;
    }

    public function erreurAction()
    {
        $request = $this->getRequest();
        if ($request->isXmlHttpRequest()) {

        } else {
            $form = new ContactForm($this->entityManager);
            if (!$request->isPost()) {
                return ['form' => $form];
            }
            $data = $request->getPost();
            $data = $data->toArray();
            //process data
        }
        return ;
    }
}
