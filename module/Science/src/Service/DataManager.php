<?php
namespace Science\Service;

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

    public function prepareDomaineStats($sort,$order = "asc")
    {
        $domaines = $this->entityManager->getRepository(Domaine::class)->findAll();

        $data = [];
        $cpt = 0;
        foreach ($domaines as $domaine) {
            $vulgaCount = $domaine->getVulga()->count();
            if($vulgaCount == 0)
                continue;

            $domaineName   = $domaine->getNom();
            $follower      = 0;
            $totalVue      = 0;
            $totalLike     = 0;
            $totalVideo    = 0;
            $totalDislike  = 0;
            $totalDuration = 0;
            $watchTime     = 0;
            $name          = [];

            foreach ($domaine->getVulga() as $vulga) {
                $follower += $vulga->getMainstats()->last()->getFollower();
                $totalVue += $vulga->getMainstats()->last()->getTotalVue();
                $totalLike += $vulga->getMainstats()->last()->getTotalLike();
                $totalDislike += $vulga->getMainstats()->last()->getTotalDislike();
                $name[] = $vulga->getNom();

                foreach ($vulga->getPosts() as $post) {
                    $totalDuration += $post->getDuree();
                    $watchTime += $post->getDuree() * $post->getVue();
                    $totalVideo++;
                }
            }
            //convert duration in minutes
            $totalDuration /= 60;

            $data[$cpt]['domaine'] = $domaineName;
            $data[$cpt]['name'] = $name;
            $data[$cpt]['abo'] = $follower;
            $data[$cpt]['vue'] = $totalVue;
            $data[$cpt]['vid'] = $totalVideo;
            $data[$cpt]['like'] = $follower;
            $data[$cpt]['dislike'] = $totalDislike;
            $data[$cpt]['minutes'] = $totalDuration;
            $data[$cpt]['watch'] = $watchTime;
            $data[$cpt]['min_v'] = $totalDuration / $totalVideo;
            $cpt++;
        }

        return $this->sortArray($data,$sort,$order);
    }

    public function prepareVulgaStats($sort = "nom",$order = "asc")
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

        return $this->sortArray($data,$sort,$order);
    }

    private function sortArray($array,$sort,$order)
    {
        switch ($sort) {
            case 'nom':
                usort($array,function($a, $b) {
                    return strnatcmp($a['name'], $b['name']);
                });
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
                usort($array, function($a, $b) use ($sort) {
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
            return array_reverse($array);
        else
            return $array;
    }
}
