<?php
namespace Science\Repository;

use Doctrine\ORM\EntityRepository;
use Science\Entity\MainStats;

/**
 * This is the custom repository class for pays entity.
 */
class MSRepository extends EntityRepository
{
    public function findByOwner($pf,$vulga)
    {
        return $this->getEntityManager()->getRepository(MainStats::class)
                      ->findBy(['plateforme' => $pf->getId(),'vulga' => $vulga->getId()]);
    }

}
