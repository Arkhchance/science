<?php
namespace Science\Repository;

use Doctrine\ORM\EntityRepository;
use Science\Entity\Vulga;
use Science\Entity\Domaine
;
/**
 * This is the custom repository class for Domaine entity.
 */
class DomaineRepository extends EntityRepository
{
    public function findAll()
    {
        $em = $this->getEntityManager();
        $queryBuilder = $em->createQueryBuilder();

        $queryBuilder->select('d')
            ->from(Domaine::class,'d')
            ->leftJoin('d.vulga','v')
            ->where('v.private = ?1')
            ->setParameter('1', Vulga::STATE_PUBLIC);

        return $queryBuilder->getQuery()->getResult();
    }
}
