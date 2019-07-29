<?php
namespace Science\Repository;

use Doctrine\ORM\EntityRepository;
use Science\Entity\Posts;

/**
 * This is the custom repository class for pays entity.
 */
class PostsRepository extends EntityRepository
{
    public function findByOwner($pf,$vulga)
    {
        return $this->getEntityManager()->getRepository(Posts::class)
                      ->findBy(['plateforme' => $pf->getId(),'vulga' => $vulga->getId()]);
    }

}
