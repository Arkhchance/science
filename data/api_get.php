<?php
use Google_Client;
use Google_Service_YouTube;

$client = new Google_Client();
$client->setApplicationName('API code samples');
$client->setDeveloperKey('AIzaSyCZoljD0kaGZkAwaUsVC18z2sNbGyviywQ');

// Define service object for making API requests.
$service = new Google_Service_YouTube($client);



$queryParams = [
    'id' => 'UC1g4lZctFqTpZDrJEiw9Qug'
];

$response = $service->channels->listChannels('snippet,contentDetails,statistics', $queryParams);
