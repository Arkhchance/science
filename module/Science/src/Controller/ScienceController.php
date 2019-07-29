<?php
namespace Science\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Zend\View\Model\JsonModel;
use Science\Entity\Vulga;
use Science\Entity\Plateforme;
use Science\Entity\Posts;
use Science\Entity\MainStats;

class ScienceController extends AbstractActionController
{

    private $entityManager;

    public function __construct($entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function indexAction()
    {
        //macroscopie
        $vulga = $this->entityManager->getRepository(Vulga::class)
                        ->findOneById(23);

        $pf = $this->entityManager->getRepository(Plateforme::class)
                        ->findOneByid(3);

        $posts = $this->entityManager->getRepository(Posts::class)
                      ->findByOwner($pf,$vulga);

        $stats = $this->entityManager->getRepository(MainStats::class)
                    ->findByOwner($pf,$vulga);

        return  [
            'posts' => $posts,
            'stats' => $stats
        ];
    }
}
