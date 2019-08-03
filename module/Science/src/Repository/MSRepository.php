<?php
namespace Science\Repository;

use Doctrine\ORM\EntityRepository;
use Science\Entity\MainStats;
use Science\Entity\Vulga;

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

    public function findByOrder($order,$sens){
        $em = $this->getEntityManager();
        $queryBuilder = $em->createQueryBuilder();

        $direction = $sens == 'asc' ? "ASC" : "DESC";
        switch ($order) {
            case 'abo':
                $orderBy = 'follower';
                break;
            case 'vid':
                $orderBy = 'posts';
                break;
            case 'vue':
                $orderBy = 'totalVue';
                break;
            case 'like':
                $orderBy = 'totalLike';
                break;
            case 'dislike':
                $orderBy = 'totalDislike';
                break;
            case 'com':
                $orderBy = 'totalComment';
                break;
            default:
                $orderBy = 'nom';
                break;
        }
        $queryBuilder->select('s')
            ->from(MainStats::class, 's')
            ->leftJoin('s.vulga','v')
            ->where('v.private = ?1')
            ->setParameter('1', Vulga::STATE_PUBLIC);

        if($orderBy == 'nom')
            $queryBuilder->orderBy('v.'.$orderBy, $direction);
        else
            $queryBuilder->orderBy('s.'.$orderBy, $direction);



        return $queryBuilder->getQuery();
    }
}
