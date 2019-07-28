<?php
namespace Science\Service;

use Science\Entity\Langue;
use Science\Entity\Pays;


/**
 * This service is responsible for adding/editing users
 * and changing user password.
 */
class DbManager
{
    /**
     * Doctrine entity manager.
     * @var Doctrine\ORM\EntityManager
     */
    private $entityManager;

    /**
     * Application config.
     * @var type
     */
    private $config;

    /**
     * Constructs the service.
     */
    public function __construct($entityManager, $config)
    {
        $this->entityManager = $entityManager;
        $this->config = $config;
    }

    /**
    * Partie Langue  add/del no edit
    */

    public function addLangue($data)
    {
        $langue = new Langue();

        $langue->setNom($data['langue']);
        $langue->setCode($data['code']);
        $langue->setDrapeau($data['drapeau']);

        //apply to db
        $this->entityManager->persist($langue);
        $this->entityManager->flush();

        return true;
    }

    public function delLangue($languelist)
    {
        $result = true; //total result

        $langues = $this->entityManager->getRepository(Langue::class)
                            ->findById($languelist);

        foreach ($langues as $langue) {
            if($langue->getVulga()->count() > 0) {
                $result = false; // partial delete
                continue; // skip this one don't delete it, it's under use
            }
            $this->entityManager->remove($langue); // delete it
        }
        //apply to db
        $this->entityManager->flush();

        return $result;
    }

    /**
    * Partie Pays  add/del no edit
    */

    public function addPays($data)
    {
        $pays = new Pays();

        $pays->setNom($data['pays']);
        $pays->setCode($data['code']);
        $pays->setDrapeau($data['drapeau']);

        //apply to db
        $this->entityManager->persist($pays);
        $this->entityManager->flush();

        return true;
    }

    public function delPays($payslist)
    {
        $result = true; //total result

        $payss = $this->entityManager->getRepository(Pays::class)
                            ->findById($payslist);

        foreach ($payss as $pays) {
            if($pays->getVulga()->count() > 0) {
                $result = false; // partial delete
                continue; // skip this one don't delete it, it's under use
            }
            $this->entityManager->remove($pays); // delete it
        }
        //apply to db
        $this->entityManager->flush();

        return $result;
    }
}
