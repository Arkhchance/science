#!/usr/bin/php
<?php

require_once "../vendor/autoload.php";

$id = $argv[1];
$pf = $argv[2];
$vulga = $argv[3]; 

$ids = shell_exec("youtube-dl --get-id $id");

$listing = explode("\n", $ids);
