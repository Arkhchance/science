<?php
namespace Science\Service;

use Science\Entity\Posts;
use Science\Entity\Plateforme;
use Science\Entity\Vulga;
use Science\Entity\MainStats;

class ApiManager
{
    /**
     * Doctrine entity manager.
     * @var Doctrine\ORM\EntityManager
     */
    private $entityManager;
    private $youtubeService;

    /**
     * Constructs the service.
     */
    public function __construct($entityManager,$youtubeService)
    {
        $this->entityManager = $entityManager;
        $this->youtubeService = $youtubeService;
    }

    public function addPlateformeStat($data)
    {

        $pf = $this->entityManager->getRepository(Plateforme::class)
                   ->findOneByid($data['pf']);
        $vulga = $this->entityManager->getRepository(Vulga::class)
                      ->findOneByid($data['vulga']);

        if(!preg_match($pf->getIdExtractPattern(),$data['link'],$match))
            return false;

        $linkId = $match[1];

        switch ($pf->getNom()) {
            case 'Youtube':
                $stats = $this->youtubeService->getChannelStats($linkId);
                $this->youtubeService->addVideoChannel($linkId,$pf,$vulga);
                $this->addYoutubeStats($stats,$pf,$vulga,$linkId);
                break;

            default:
                // code...
                break;
        }
        return true; 
    }

    private function addYoutubeStats($initStats,$pf,$vulga,$channelId)
    {
        $posts = $this->entityManager->getRepository(Posts::class)
                      ->findByOwner($pf,$vulga);

        $totalCom = 0;
        $totalLike = 0;
        $totalDislike = 0;

        //get stats from videos
        foreach ($posts as $post) {
            $totalLike += $post->getNbLike();
            $totalDislike += $post->getNbDislike();
            $totalCom += $post->getComments();
        }

        $mainStat = new MainStats();
        $mainStat->setFollower($initStats['follower']);
        $mainStat->setLink('https://www.youtube.com/channel/'.$channelId);
        $mainStat->setPosts($initStats['videoCount']);
        $mainStat->setTotalLike($totalLike);
        $mainStat->setTotalDislike($totalDislike);
        $mainStat->setTotalVue($initStats['viewCount']);
        $mainStat->setTotalComment($totalCom);
        $mainStat->setPlateformeId($channelId);
        $mainStat->setPlateforme($pf);
        $mainStat->setVulga($vulga);

        //save to db
        $this->entityManager->persist($mainStat);
        $this->entityManager->flush();

    }
}
