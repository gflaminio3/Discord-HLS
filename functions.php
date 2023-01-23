<?php

function timeDebug() {
    $timestamp = microtime(true);
    $dateTime = new DateTime("@$timestamp");
    $formattedTime = $dateTime->format('d/m/Y - H:i:s');
    return "$formattedTime\n";
}

function folderCheck($folder) {
    if (!is_dir($folder))
        die('(Error) Folder not Found, quitting!');
    else
        return array_slice(scandir($folder, SCANDIR_SORT_NONE, NULL), 2);
}

function getDuration($file) {
    // Read the entire file into a string
    $contents = file_get_contents($file);

    // Extract the 128 bytes containing the metadata from the end of the file
    $metadata = substr($contents, -128);

    // Extract the duration from the metadata
    $duration = unpack('V', substr($metadata, 4, 4))[1];

    //nanosecond to seconds = 10^-9
    return $duration / 1000000000;
}

function uploadFile($webhook, $fileName, $spoofedName) {
    static $curl;
    if (!$curl) {
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, TRUE);
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, FALSE);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, FALSE);
        curl_setopt($curl, CURLOPT_HTTPHEADER, array('Content-Type: multipart/form-data'));
    }

    $json_data = [
        'tts' => 'false',
        'file' => curl_file_create($fileName, '', $spoofedName)
    ];

    curl_setopt($curl, CURLOPT_URL, "https://discord.com/api/webhooks/$webhook");
    curl_setopt($curl, CURLOPT_POST, TRUE);
    curl_setopt($curl, CURLOPT_POSTFIELDS, $json_data);

    $result = json_decode(curl_exec($curl));
    if (!$result->id)
        die('Webhook Not Working');
    else
        return $result->attachments[0]->url;
}

function generateM3U8Playlist($segmentLength, $files, $playlistName) {
    $targetDuration = $segmentLength * sizeof($files);
    $playlistContent = "#EXTM3U\n#EXT-X-VERSION:3\n#EXT-X-ALLOW-CACHE:NO\n#EXT-X-MEDIA-SEQUENCE:0\n#EXT-X-TARGETDURATION:$targetDuration\n#EXT-X-DISCONTINUITY\n";
    for ($i = 0; $i < sizeof($files); $i++) {
        $playlistContent .= "#EXTINF:$segmentLength,\n" . $files[$i] . "\n";
    }

    file_put_contents($playlistName, $playlistContent);
}