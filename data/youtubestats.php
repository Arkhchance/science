#!/usr/bin/php
<?php
require_once "config.php";
//require_once "../vendor/autoload.php";

$id = 'https://www.youtube.com/channel/'.$argv[1];
$pf = $argv[2];
$vulga = $argv[3];
$subscriber = $argv[4];

$rand = rand();
mkdir("./data/$rand");
$vidLink = 'https://www.youtube.com/watch?v=';
$cmdVideo = "cd ./data/$rand && youtube-dl --skip-download --write-info-json ";

$ids = shell_exec("youtube-dl --get-id $id");

$idList = explode("\n", $ids);

$videoCount = 0;
$viewCount = 0;
$videoData = [];
$totalLike = 0;
$totalDislike = 0;

foreach ($idList as $videoId) {
    if($videoId == "")
        continue;

    exec("$cmdVideo $videoId");
    $file = shell_exec("ls ./data/$rand/*.json");
    $file = trim($file, "\n");
    $strJsonFileContents = file_get_contents($file);
    $array = json_decode($strJsonFileContents, true);

    $videoData[$videoCount]['dislike'] = $array['dislike_count'];
    $videoData[$videoCount]['like']    = $array['like_count'];
    $videoData[$videoCount]['vue']     = $array['view_count'];
    $videoData[$videoCount]['titre']   = $array['title'];
    $videoData[$videoCount]['desc']    = $array['description'];
    $videoData[$videoCount]['duree']   = $array['duration'];
    $videoData[$videoCount]['id']      = $videoId;

    $viewCount += $array['view_count'];
    $totalLike += $videoData[$videoCount]['like'];
    $totalDislike += $videoData[$videoCount]['dislike'];
    $videoCount++;

    unlink($file);
}

rmdir("./data/$rand");

$sql = 'INSERT INTO `posts` (`post_id`, `plateforme`, `vulga`, `vue`, `titre`, `description`, `nb_like`, `nb_dislike`, `duree`) ';
$sql .= 'VALUES (?,?,?,?,?,?,?,?,?)';

$bdd = connect_db();
$req = $bdd->prepare($sql);

foreach ($videoData as $data) {
    $req->execute([$data['id'],$pf,$vulga,$data['vue'],$data['titre'],$data['desc'],$data['like'],$data['dislike'],$data['duree']]);
}


$sql = 'INSERT INTO `main_stats` (`plateforme`, `vulga`, `link`, `follower`, `nb_posts`, `total_like`, `total_dislike`, `total_vue`) ';
$sql .= 'VALUES (?,?,?,?,?,?,?,?)';
$req = $bdd->prepare($sql);
$req->execute([$pf,$vulga,$id,$subscriber,$videoCount,$totalLike,$totalDislike,$viewCount]);

$bdd = null;
