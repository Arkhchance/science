<?php
use Google_Client;
use Google_Service_YouTube;

$client = new Google_Client();
$client->setApplicationName('API code samples');
$client->setDeveloperKey();

// Define service object for making API requests.
$service = new Google_Service_YouTube($client);



$queryParams = [
    'id' => 'UC1g4lZctFqTpZDrJEiw9Qug'
];

$response = $service->channels->listChannels('snippet,contentDetails,statistics', $queryParams);



/*
$response->getItems()[0]->getStatistics()->
Array => channel
(
    [0] => setCommentCount
    [1] => getCommentCount
    [2] => setHiddenSubscriberCount
    [3] => getHiddenSubscriberCount
    [4] => setSubscriberCount
    [5] => getSubscriberCount
    [6] => setVideoCount
    [7] => getVideoCount
    [8] => setViewCount
    [9] => getViewCount
    [10] => __construct
    [11] => __get
    [12] => toSimpleObject
    [13] => assertIsArray
    [14] => offsetExists
    [15] => offsetGet
    [16] => offsetSet
    [17] => offsetUnset
    [18] => __isset
    [19] => __unset
)

Array => video
(
    [0] => setCommentCount
    [1] => getCommentCount
    [2] => setDislikeCount
    [3] => getDislikeCount
    [4] => setFavoriteCount
    [5] => getFavoriteCount
    [6] => setLikeCount
    [7] => getLikeCount
    [8] => setViewCount
    [9] => getViewCount
    [10] => __construct
    [11] => __get
    [12] => toSimpleObject
    [13] => assertIsArray
    [14] => offsetExists
    [15] => offsetGet
    [16] => offsetSet
    [17] => offsetUnset
    [18] => __isset
    [19] => __unset
)

$result->getItems()[0]->getSnippet()
Array
(
    [0] => setCategoryId
    [1] => getCategoryId
    [2] => setChannelId
    [3] => getChannelId
    [4] => setChannelTitle
    [5] => getChannelTitle
    [6] => setDefaultAudioLanguage
    [7] => getDefaultAudioLanguage
    [8] => setDefaultLanguage
    [9] => getDefaultLanguage
    [10] => setDescription
    [11] => getDescription
    [12] => setLiveBroadcastContent
    [13] => getLiveBroadcastContent
    [14] => setLocalized
    [15] => getLocalized
    [16] => setPublishedAt
    [17] => getPublishedAt
    [18] => setTags
    [19] => getTags
    [20] => setThumbnails
    [21] => getThumbnails
    [22] => setTitle
    [23] => getTitle
    [24] => rewind
    [25] => current
    [26] => key
    [27] => next
    [28] => valid
    [29] => count
    [30] => offsetExists
    [31] => offsetGet
    [32] => offsetSet
    [33] => offsetUnset
    [34] => __construct
    [35] => __get
    [36] => toSimpleObject
    [37] => assertIsArray
    [38] => __isset
    [39] => __unset
)
