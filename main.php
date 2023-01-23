<?php
require_once 'functions.php';

//Variables Setting
$folder = 'segments';
$chName = 'index.m3u8';
$webhook = 'YOUR_WEBHOOK_HERE';
$spoofName = 'segment.png';
$segmentLenght = 4; //time in seconds as integer

foreach (folderCheck($folder) as $singleFile) {
    $uploadedFiles[] = uploadFile($webhook, "$folder/$singleFile", $spoofName);
    generateM3U8Playlist($segmentLenght, $uploadedFiles, $chName);
    echo '[INFO] Playlist File Created on ' . timeDebug();
    sleep(2);
}
