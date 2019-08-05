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
$vidLink = 'http://www.youtube.com/watch?v=';
$cmdVideo = "cd ./data/$rand && youtube-dl --skip-download --write-info-json --ignore-errors";

$ids = shell_exec("youtube-dl --get-id --ignore-errors $id");

$idList = explode("\n", $ids);

$videoCount = 0;
$viewCount = 0;
$videoData = [];
$totalLike = 0;
$totalDislike = 0;
sleep(1); // to avoid flooding youtube

foreach ($idList as $videoId) {
    if($videoId == "" || strlen($videoId) > 13)
        continue;

    exec($cmdVideo." ".$vidLink.$videoId);
    $files = scandir("data/$rand");
    sleep(1); // to avoid flooding youtube
    foreach ($files as $file) {
        if($file == "." || $file == "..")
            continue;
        $strJsonFileContents = file_get_contents("data/$rand/$file");
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

        unlink("data/$rand/$file");
    }
}

rmdir("./data/$rand");

$sqlInsert = 'INSERT INTO `posts` (`post_id`, `plateforme`, `vulga`, `vue`, `titre`, `description`, `nb_like`, `nb_dislike`, `duree`) ';
$sqlInsert .= 'VALUES (?,?,?,?,?,?,?,?,?)';

$sqlUpdate = 'UPDATE `posts` SET `plateforme` = ?, `vulga` = ?, `vue` = ?, `titre` = ?, `description` = ?, `nb_like` = ?, `nb_dislike` = ?, `duree` = ? ';
$sqlUpdate .= ' WHERE `post_id` = ?';

$sqlSearch = 'SELECT 1 FROM `posts` WHERE `post_id`=?';

$bdd = connect_db();
$reqInsert = $bdd->prepare($sqlInsert);
$reqUpdate = $bdd->prepare($sqlUpdate);
$reqSearch = $bdd->prepare($sqlSearch);

foreach ($videoData as $data) {
    $reqSearch->execute([$data['id']]);
    $userExists = $reqSearch->fetchColumn();

    if($userExists)
        $reqUpdate->execute([$pf,$vulga,$data['vue'],$data['titre'],$data['desc'],$data['like'],$data['dislike'],$data['duree'],$data['id']]);
    else
        $reqInsert->execute([$data['id'],$pf,$vulga,$data['vue'],$data['titre'],$data['desc'],$data['like'],$data['dislike'],$data['duree']]);
}


$sql = 'INSERT INTO `main_stats` (`plateforme`, `vulga`, `link`, `follower`, `nb_posts`, `total_like`, `total_dislike`, `total_vue`) ';
$sql .= 'VALUES (?,?,?,?,?,?,?,?)';
$req = $bdd->prepare($sql);
$req->execute([$pf,$vulga,$id,$subscriber,$videoCount,$totalLike,$totalDislike,$viewCount]);

$bdd = null;
