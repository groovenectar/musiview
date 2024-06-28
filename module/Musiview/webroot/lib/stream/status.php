<?php

$vidURL = 'https://stream.dup.bz:4443/hls/stream.m3u8';

$streamDataBefore = file_get_contents($vidURL);
sleep(5);
$streamDataAfter = file_get_contents($vidURL);

header('Content-type: text/plain');
echo $streamDataBefore === $streamDataAfter ? 'no' : 'yes';
