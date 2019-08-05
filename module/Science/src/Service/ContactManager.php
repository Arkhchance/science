<?php
namespace Science\Service;

use Science\Entity\Messages;
use Science\Entity\Vulga;
use Science\Entity\Domaine;

/**
 * This service is responsible for adding/editing users
 * and changing user password.
 */
class ContactManager
{
    /**
     * Doctrine entity manager.
     * @var Doctrine\ORM\EntityManager
     */
    private $entityManager;

    /**
     * Constructs the service.
     */
    public function __construct($entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function addMessage($data)
    {
        $vulga = $this->entityManager->getRepository(Vulga::class)
                      ->findOneByid($data['vulga']);

        if($vulga === null) {
            $message = "Nvulga ?: >".$data['nvulga']."< Null vulga\n";
        } else {
            $message = "Nvulga ?: >".$data['nvulga']."< Vulga ".$vulga->getNom()."\n";
        }
        $message .= "Sexe New : ".Vulga::getSexeAsString($data['sexe'])."\n";
        $message .= "Pays New : ".$data['pays']."\n";
        $message .= "Langue  New : ".$data['langue']."\n";
        $message .= "Nouveau Dom : ".$data['ndomaine']."\n";
        $message .= "old domaine : ";

        foreach ($data['domaine'] as $dom) {
            $domaine = $this->entityManager->getRepository(Domaine::class)
                          ->findOneByid($dom);
            $message .= " ".$domaine->getNom();
        }

        $message .= "\n";
        $message .= "Note : ".$data['note'];

        $myMessage = new Messages();
        $myMessage->setMessage($message);

        $this->entityManager->persist($myMessage);
        $this->entityManager->flush();
    }

}
