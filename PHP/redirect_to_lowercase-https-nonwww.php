<?php
// redirect to lowercase, https and non-www :

/* START OF REDIRECTION */
$redirect = false;
$domain = $_SERVER['HTTP_HOST'];

// is it https? :
if(empty($_SERVER['HTTPS']) || $_SERVER['HTTPS'] == "off") {
	$redirect = true;
}

// does it have 'www'? :
if (substr($_SERVER['HTTP_HOST'], 0, 4) === 'www.') {
	$domain = substr($_SERVER['HTTP_HOST'], 4);
	$redirect = true;
}

if ($redirect) {
	$location = 'https://' . $domain . $_SERVER['REQUEST_URI'];
	// header('HTTP/1.1 301 Moved Permanently');
	header('Location: ' . $location);
}
/* END OF REDIRECTION */
