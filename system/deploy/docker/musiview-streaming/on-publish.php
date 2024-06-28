<?php

// Thanks to https://gitlab.com/cyberpnkz/nginx-php
//Server Example: rtmp://192.168.1.1/stream
//Key Example: user1?name=user1&key=xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx

// Get variables
$get_name = filter_input(INPUT_GET, 'name', FILTER_SANITIZE_SPECIAL_CHARS);
$get_key = filter_input(INPUT_GET, 'key', FILTER_SANITIZE_SPECIAL_CHARS);

if (!$get_name || !$get_key) {
	throw new Exception('Input error');
}

// Only alphanumeric
$get_name = preg_replace('/[^a-zA-Z0-9]/', '', $get_name);
$get_key = preg_replace('/[^a-zA-Z0-9]/', '', $get_key);

$skey = file_get_contents('/run/secrets/skey');

$accounts = [
	[
		'name' => 'groovenectar',
		'key' => $skey
	],
	[
		'name' => 'insomniscene',
		'key' => $skey
	],
];

foreach ($accounts as $key => $id) {
	if (($id['name'] === $get_name) && ($id['key'] === $get_key)) {
		http_response_code(200);
		break;
	}
	http_response_code(403);
}
