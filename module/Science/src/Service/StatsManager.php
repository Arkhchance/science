<?php
namespace Science\Service;

use Science\Entity\Domaine;
use Science\Entity\Plateforme;
use Science\Entity\Vulga;

class StatsManager
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
            $watchTime /= 60;

            $data[$cpt]['domaine'] = $domaineName;
            $data[$cpt]['nom'] = $name;
            $data[$cpt]['abo'] = $follower;
            $data[$cpt]['vue'] = $totalVue;
            $data[$cpt]['vid'] = $totalVideo;
            $data[$cpt]['like'] = $totalLike;
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
            //convert duration & watch time in minutes
            $totalDuration /= 60;
            $watchTime /= 60;

            //prevent 0 division
            $totalPost = $totalPost != 0 ? $totalPost : 1;
            $totalDislike = $totalDislike != 0 ? $totalDislike : 1;

            $data[$cpt]['nom']    = $vulga->getNom();
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
                    return strnatcmp($a['nom'], $b['nom']);
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
                    return $a[$sort] <=> $b[$sort];
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

    public function prepareVulgaGraph()
    {
        $vulgas = $this->entityManager->getRepository(Vulga::class)->findAll();

        $data = [];
        $abo = [];
        $vue = [];
        $like = [];
        $dislike = [];
        $cpt = 0;

        foreach ($vulgas as $vulga) {
            if($vulga->getMainstats()->count() < 1)
                continue;


            $abo[$cpt]['nom']  = $vulga->getNom();
            $vue[$cpt]['nom']  = $vulga->getNom();
            $like[$cpt]['nom'] = $vulga->getNom();
            $dislike[$cpt]['nom'] = $vulga->getNom();

            $abo[$cpt]['abo']   = $vulga->getMainstats()->last()->getFollower();
            $vue[$cpt]['vue']   = $vulga->getMainstats()->last()->getTotalVue();
            $like[$cpt]['like'] = $vulga->getMainstats()->last()->getTotalLike();
            $dislike[$cpt]['dislike'] = $vulga->getMainstats()->last()->getTotalDislike();

            $cpt++;
        }

        $data['Abonnements'] = $this->sortArray($abo,'abo','desc');
        $data['Vues'] = $this->sortArray($vue,'vue','desc');
        $data['Like'] = $this->sortArray($like,'like','desc');
        $data['Dislike'] = $this->sortArray($dislike,'dislike','desc');

        return $data;
    }

    public function prepareDomaineGraph()
    {
        $domaines = $this->entityManager->getRepository(Domaine::class)->findAll();

        $data = [];
        $abo = [];
        $vue = [];
        $like = [];
        $dislike = [];
        $duration = [];
        $watchTime = [];
        $video = [];
        $cpt = 0;

        foreach ($domaines as $domaine) {
            if($domaine->getVulga()->count() < 1)
                continue;

            $abo[$cpt]['nom']  = $domaine->getNom();
            $vue[$cpt]['nom']  = $domaine->getNom();
            $like[$cpt]['nom'] = $domaine->getNom();
            $dislike[$cpt]['nom'] = $domaine->getNom();
            $duration[$cpt]['nom'] = $domaine->getNom();
            $watchTime[$cpt]['nom'] = $domaine->getNom();
            $video[$cpt]['nom'] = $domaine->getNom();

            $abo[$cpt]['abo'] = 0;
            $vue[$cpt]['vue'] = 0;
            $like[$cpt]['like'] = 0;
            $dislike[$cpt]['dislike'] = 0;
            $duration[$cpt]['minutes'] = 0;
            $watchTime[$cpt]['watch'] = 0;
            $video[$cpt]['vid'] = 0;

            foreach ($domaine->getVulga() as $vulga) {

                $abo[$cpt]['abo']   += $vulga->getMainstats()->last()->getFollower();
                $vue[$cpt]['vue']   += $vulga->getMainstats()->last()->getTotalVue();
                $like[$cpt]['like'] += $vulga->getMainstats()->last()->getTotalLike();
                $dislike[$cpt]['dislike'] += $vulga->getMainstats()->last()->getTotalDislike();

                foreach ($vulga->getPosts() as $post) {
                    $duration[$cpt]['minutes'] += $post->getDuree();
                    $watchTime[$cpt]['watch'] += $post->getDuree() * $post->getVue();
                    $video[$cpt]['vid']++;
                }
            }

            //convert to hour
            $watchTime[$cpt]['watch'] /= (60*60);
            $duration[$cpt]['minutes'] /= (60*60);

            $cpt++;
        }

        $data['Abonnements'] = $this->sortArray($abo,'abo','desc');
        $data['Vues'] = $this->sortArray($vue,'vue','desc');
        $data['Like'] = $this->sortArray($like,'like','desc');
        $data['Dislike'] = $this->sortArray($dislike,'dislike','desc');
        $data['Watch_Time_en_heure'] = $this->sortArray($watchTime,'watch','desc');
        $data['Duree_en_heure'] = $this->sortArray($duration,'minutes','desc');
        $data['Videos'] = $this->sortArray($video,'vid','desc');

        return $data;
    }
}
