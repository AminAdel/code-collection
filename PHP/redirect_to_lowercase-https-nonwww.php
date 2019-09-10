<?php
// redirect to lowercase, https and non-www :

$redirect = false;
$domain = $_SERVER['HTTP_HOST'];
if(empty($_SERVER['HTTPS']) || $_SERVER['HTTPS'] == "off") $redirect = true;
if (substr($_SERVER['HTTP_HOST'], 0, 4) === 'www.') {
	$redirect = true;
	$domain = substr($_SERVER['HTTP_HOST'], 4);
}

if ($redirect) {
	$location = 'https://' . $domain . $_SERVER['REQUEST_URI'];
	// header('HTTP/1.1 301 Moved Permanently');
	header('Location: ' . $location);
}
