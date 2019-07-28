<?php
namespace Science\Repository;

use Doctrine\ORM\EntityRepository;

/**
 * This is the custom repository class for pays entity.
 */
class PaysRepository extends EntityRepository
{
    public function findAll()
    {
        return $this->findBy([], ['nom' => 'ASC']);
    }
}
