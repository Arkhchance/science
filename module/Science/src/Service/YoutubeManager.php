<?php
namespace Science\Service;

use Science\Entity\Posts;
use Science\Entity\Plateforme;
use Science\Entity\Vulga;
use Science\Entity\MainStats;
use Google_Client;
use Google_Service_YouTube;

class YoutubeManager
{
    /**
     * Doctrine entity manager.
     * @var Doctrine\ORM\EntityManager
     */
    private $entityManager;
    private $config;

    private $client;
    private $service;

    /**
     * Constructs the service.
     */
    public function __construct($entityManager,$config)
    {
        $this->entityManager = $entityManager;
        $this->config = $config;

        $this->client = new Google_Client();

        $this->client->setApplicationName($this->config['YouTube']['AppName']);
        $this->client->setDeveloperKey($this->config['YouTube']['key']);
        $this->service = new Google_Service_YouTube($this->client);

    }

    public function getChannelStats($channelId)
    {
        $queryParams = ['id' => $channelId];
        $result = $this->service->channels->listChannels('statistics', $queryParams);

        $channelStats['id'] = $channelId;
        $channelStats['videoCount'] = $result->getItems()[0]->getStatistics()->getVideoCount();
        $channelStats['viewCount'] = $result->getItems()[0]->getStatistics()->getViewCount();
        $channelStats['follower'] = $result->getItems()[0]->getStatistics()->getSubscriberCount();

        return $channelStats;
    }

    public function addVideoChannel($channelId,$plateforme,$vulga)
    {
        $videoIds = $this->extractVideosIdFromChannel($channelId);

        foreach ($videoIds as $videoId) {
            if($videoId == "")
                continue;
            $data = $this->getVideoStats($videoId);

            //search if alreay in db and if so update
            $exist = $this->entityManager->getRepository(Posts::class)
                                    ->findOneBypostid($videoId);
            if($exist == null) {
                $post = new Posts();
                $post->setPostId($videoId);
            } else {
                $post = $exist;
            }

            $post->setVue($data['vue']);
            $post->setTitre($data['titre']);
            $post->setDescription($data['desc']);
            $post->setNbLike($data['like']);
            $post->setNbDislike($data['dislike']);
            $post->setComments($data['comments']);
            $post->setPlateforme($plateforme);
            $post->setVulga($vulga);

            $this->entityManager->persist($post);
        }

        $this->entityManager->flush();
    }

    private function getVideoStats($videoId)
    {
        $queryParams = ['id' => $videoId];
        $result = $this->service->videos->listVideos('snippet,statistics', $queryParams);

        $video['comments'] = $result->getItems()[0]->getStatistics()->getCommentCount();
        $video['dislike'] = $result->getItems()[0]->getStatistics()->getDislikeCount();
        $video['like'] = $result->getItems()[0]->getStatistics()->getLikeCount();
        $video['vue'] = $result->getItems()[0]->getStatistics()->getViewCount();
        $video['titre'] = $result->getItems()[0]->getSnippet()->getTitle();
        $video['desc'] = $result->getItems()[0]->getSnippet()->getDescription();

        return $video;
    }

    /* Warning this method generate a lot of api request !
    * it is not recommended for big channel as it will eat
    * all of of the api quota for the day
    * /!\ BEWARE /!\
    */
    private function extractVideosIdFromChannel($channelId)
    {
        $videosId = [];
        $queryParams = ['channelId' => $channelId, 'maxResults' => 50];
        $result = $this->service->search->listSearch('snippet', $queryParams);

        // get first result
        foreach ($result->getItems() as $items) {
            $videosId[] = $items->getId()->getVideoId();
        }

        //loop to get next page if nessessary
        $stay = $result->getNextPageToken()!= null ? true : false;
        $lastTurn = false;

        while($stay) {
            $queryParams = ['channelId' => $channelId,'maxResults' => 50,'pageToken'=> $result->getNextPageToken()];
            $result = $this->service->search->listSearch('snippet', $queryParams);

            foreach ($result->getItems() as $items) {
                $videosId[] = $items->getId()->getVideoId();
            }
            if($lastTurn)
                $stay = false;
            if($result->getNextPageToken() == null)
                $lastTurn = true;
        }

        return $videosId;
    }
}
