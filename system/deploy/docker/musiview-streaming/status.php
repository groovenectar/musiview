<?php

header('Content-type: text/plain');

if (empty($_GET['c'])) exit('No collection specified');

if (!preg_match('#^[a-zA-Z0-9_-]+$#', $_GET['c'])) exit('Bad format');

$playlistFile = '/tmp/hls/' . $_GET['c'] . '.m3u8';

if (!file_exists($playlistFile)) exit('offline');

$secondsThreshold = 20;

echo ((time() - filemtime($playlistFile)) < $secondsThreshold) ? 'online' : 'offline';
