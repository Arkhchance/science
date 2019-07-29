<?php
namespace Science\Repository;

use Doctrine\ORM\EntityRepository;
use Science\Entity\Vulga;

/**
 * This is the custom repository class for pays entity.
 */
class VulgaRepository extends EntityRepository
{
    public function findVulga()
    {
        $entityManager = $this->getEntityManager();
        $queryBuilder = $entityManager->createQueryBuilder();

        $queryBuilder->select('v')->from(Vulga::class, 'v');
        $queryBuilder->orderBy('v.nom', 'ASC');

        return $queryBuilder->getQuery();
    }
    
    public function findAll()
    {
        return $this->findBy([], ['nom' => 'ASC']);
    }
}
