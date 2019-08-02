<?php
namespace Science\Service;

use Science\Entity\Langue;
use Science\Entity\Pays;
use Science\Entity\Domaine;
use Science\Entity\Plateforme;
use Science\Entity\Vulga;


class DataManager
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

    public function prepareStats($sort = "nom",$order = "asc")
    {
        //get all vulga
        $vulgas = $this->entityManager->getRepository(Vulga::class)->findAll();

        $data = [];
        $cpt = 0;
        foreach ($vulgas as $vulga) {

            $totalPost    = $vulga->getPosts()->count();
            $follower     = 0;
            $totalVue     = 1;
            $totalLike    = 1;
            $totalDislike = 1;

            if($vulga->getMainstats()->count() > 0) {
                $follower     = $vulga->getMainstats()->last()->getFollower();
                $totalVue     = $vulga->getMainstats()->last()->getTotalVue();
                $totalLike    = $vulga->getMainstats()->last()->getTotalLike();
                $totalDislike = $vulga->getMainstats()->last()->getTotalDislike();
            }

            $totalDuration = 0;
            $watchTime = 0;
            if($totalPost > 0) {
                foreach ($vulga->getPosts() as $post) {
                    $totalDuration += $post->getDuree();
                    $watchTime += $post->getDuree() * $post->getVue();
                }
            }
            //convert duration in minutes
            $totalDuration /= 60;

            //prevent 0 division
            $totalPost = $totalPost != 0 ? $totalPost : 1;
            $totalDislike = $totalDislike != 0 ? $totalDislike : 1;

            $data[$cpt]['name']    = $vulga->getNom();
            $data[$cpt]['abo']     = $follower;
            $data[$cpt]['vid']     = $totalPost;
            $data[$cpt]['vue']     = $totalVue;
            $data[$cpt]['vue_v']   = $totalVue / $totalPost;
            $data[$cpt]['like']    = $totalLike;
            $data[$cpt]['dislike'] = $totalDislike;
            $data[$cpt]['likeDis'] = $totalLike / $totalDislike;
            $data[$cpt]['like_v']  = $totalLike / $totalPost;
            $data[$cpt]['dis_v']   = $totalDislike / $totalPost;
            $data[$cpt]['minutes'] = $totalDuration;
            $data[$cpt]['min_v']   = $totalDuration / $totalPost;
            $data[$cpt]['watch']   = $watchTime;

            $cpt++;
        }
        switch ($sort) {
            case 'nom':
                usort($data,[$this,'compareName']);
                break;
            case 'abo':
            case 'vue':
            case 'vid':
            case 'vue_v':
            case 'like':
            case 'dislike':
            case 'likeDis':
            case 'like_v':
            case 'dis_v':
            case 'minutes':
            case 'watch':
            case 'min_v':
                usort($data, function($a, $b) use ($sort) {
                    if($a[$sort] == $b[$sort])
                        return 0;
                    return ($a[$sort] < $b[$sort]) ? -1 : 1;
                });
                break;
            default:
                // no sort
                break;
        }

        if($order == "desc")
            $data = array_reverse($data);

        return $data;
    }

    //comp function
    private function compareName($a,$b)
    {
        return strnatcmp($a['name'], $b['name']);
    }
}
