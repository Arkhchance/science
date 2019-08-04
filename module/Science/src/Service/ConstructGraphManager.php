<?php
namespace Science\Service;

use Science\Entity\Domaine;
use Science\Entity\Vulga;
use Science\Service\DataManager;

class ConstructGraphManager
{
    /**
     * Doctrine entity manager.
     * @var Doctrine\ORM\entityManager
     */
    private $entityManager;

    //to avoid recompute
    private $vulgaData;
    private $domaineData;
    private $genreData;

    /**
     * Constructs the service.
     */
    public function __construct($entityManager)
    {
        $this->entityManager = $entityManager;
        $this->vulgaData = [];
        $this->domaineData = [];
        $this->genreData = [];
    }

    public function constructGraph($data)
    {
        $graphToBuild = $this->dataParser($data);

        if($graphToBuild === false)
            return false;

        $cpt = 0;
        $graphData = [];

        foreach ($graphToBuild as $value) {
            if($value['type'] == "vulga")
                $graphData[$cpt] = $this->buildVulgaData($value['values']);
            elseif($value['type'] == "sexe")
                $graphData[$cpt] = $this->buildGenreData($value['values']);
            else
                $graphData[$cpt] = $this->buildDomaineData($value['values']);

            //check if everything worked
            if($graphData[$cpt] === false)
                return false;

            $cpt++;
        }

        return $graphData;
    }

    private function buildDomaineData($value)
    {
        $data = new DataManager();

        $domaine = $this->entityManager->getRepository(Domaine::class)
                       ->findOneByid($value);
        if($domaine === null)
            return false;

        //check if we already process the value and return it
        if(array_key_exists($value,$this->domaineData))
            return $this->genreData[$value];

        //no vulga in this domaine return 0
        if($domaine->getVulga()->count() == 0) {
            $data->computeData();
            $data->setLabel($domaine->getNom());
            return $data->getData();
        }
        $cpt = 0;
        foreach ($domaine->getVulga() as $vulga) {
            if(array_key_exists($vulga->getId(),$this->vulgaData)) {
                $stats = $this->vulgaData[$vulga->getId()];
            } else {
                $stats = $this->getVulgaStats($vulga);

                //save it in case of reuse
                $this->vulgaData[$stats['id']] = $stats;
            }
            $data->addData($stats);
            $cpt++;
        }

        $data->computeData($cpt);
        $data->setLabel($domaine->getNom());
        $this->genreData[$domaine->getId()] = $data->getData();
        return $data->getData();
    }

    private function buildVulgaData($value)
    {
        $data = new DataManager();
        $name = "";
        //if all are selected
        if(in_array(-1,$value)) {
            $vulgas = $this->entityManager->getRepository(Vulga::class)
                           ->findAll();
           foreach ($vulgas as $vulga) {
               if(array_key_exists($vulga->getId(),$this->vulgaData)) {
                   $stats = $this->vulgaData[$vulga->getId()];
               } else {
                   $stats = $this->getVulgaStats($vulga);

                   //save it in case of reuse
                   $this->vulgaData[$stats['id']] = $stats;
               }
               $data->addData($stats);
           }
           $data->computeData(count($vulgas));
           $data->setLabel("Tout le monde");
           return $data->getData();
        }

        //keep number of person involved
        $cpt = 0;
        foreach ($value as $val) {
            //skip if user checked default value
            if($val == 0)
                continue;
            $vulga = $this->entityManager->getRepository(Vulga::class)
                           ->findOneByid($val);
            //wrong input
            if($vulga === null)
                return false;

            if(array_key_exists($vulga->getId(),$this->vulgaData)) {
                $stats = $this->vulgaData[$vulga->getId()];
            } else {
                $stats = $this->getVulgaStats($vulga);

                //save it in case of reuse
                $this->vulgaData[$stats['id']] = $stats;
            }
            $data->addData($stats);

            $name .= $vulga->getNom()."\n";
            $cpt++;
        }

        $data->computeData($cpt);
        $data->setLabel($name);
        return $data->getData();
    }

    //construct data based on sexe
    private function buildGenreData($value)
    {
        $data = new DataManager();

        $genreList = Vulga::getSexeList();

        //corect shift due to form construction
        $value--;

        //wrong data
        if(!array_key_exists($value,$genreList))
            return false;

        //check if we already process the value and return it
        if(array_key_exists($value,$this->genreData))
            return $this->genreData[$value];

        $vulgas = $this->entityManager->getRepository(Vulga::class)
                       ->findGenre($value);

        if($vulgas === null)
            return false;

        $cpt = 0;
        foreach ($vulgas as $vulga) {
            if(array_key_exists($vulga->getId(),$this->vulgaData)) {
                $stats = $this->vulgaData[$vulga->getId()];
            } else {
                $stats = $this->getVulgaStats($vulga);

                //save it in case of reuse
                $this->vulgaData[$stats['id']] = $stats;
            }

            $data->addData($stats);
            $cpt++;
        }

        //all data is gathered, compute stats
        $data->computeData($cpt);

        $data->setLabel(Vulga::getSexeAsString($value));

        //save in case of reuse
        $this->genreData[$value] = $data->getData();
        return $data->getData();
    }

    //data linked to Vulga
    private function getVulgaStats($vulga)
    {
        $data = [];

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
        //convert duration & watch time in hours
        $totalDuration /= 60;
        $watchTime /= 60;

        //prevent 0 division
        $totalPost = $totalPost != 0 ? $totalPost : 1;
        $totalDislike = $totalDislike != 0 ? $totalDislike : 1;

        $data['id']      = $vulga->getId();
        $data['nom']     = $vulga->getNom();
        $data['abo']     = $follower;
        $data['vid']     = $totalPost;
        $data['vue']     = $totalVue;
        $data['vue_v']   = $totalVue / $totalPost;
        $data['like']    = $totalLike;
        $data['dislike'] = $totalDislike;
        $data['likeDis'] = $totalLike / $totalDislike;
        $data['like_v']  = $totalLike / $totalPost;
        $data['dis_v']   = $totalDislike / $totalPost;
        $data['minutes'] = $totalDuration;
        $data['min_v']   = $totalDuration / $totalPost;
        $data['watch']   = $watchTime;

        return $data;
    }

    //parse form data result
    private function dataParser($data)
    {
        $graph = [];
        $cpt = 0;
        foreach ($data as $key => $value) {
            if($key == 'elements' || $key == 'submit')
                continue;
            if($key == "vulga$cpt") {
                if(count($value) == 1){
                    if($value != 0) {
                        $graph[$cpt]['type'] = "vulga";
                        $graph[$cpt]['values'] = $value;
                    } else {
                        continue;
                    }
                } else {
                    $graph[$cpt]['type'] = "vulga";
                    $graph[$cpt]['values'] = $value;
                }
            }
            if($key == "sexe$cpt") {
                if($value == 0)
                    continue;
                $graph[$cpt]['type'] = "sexe";
                $graph[$cpt]['values'] = $value;
            }
            if($key == "domaine$cpt") {
                if($value == 0)
                    continue;
                $graph[$cpt]['type'] = "domaine";
                $graph[$cpt]['values'] = $value;
            }
            if($key != 'elements' && $key != 'submit' && !isset($graph[$cpt]['type'])) {
                //something is wrong in form completion
                return false;
            }
            $cpt++;
        }

        return $graph;
    }
}
