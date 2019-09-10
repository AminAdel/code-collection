<?php
$url = explode('?', $_SERVER['REQUEST_URI']);
if (preg_match('/[A-Z]/', $url[0])) {
	$url[0] = strtolower($url[0]); //print_r($url); exit();
	$url_new =
		$_SERVER['REQUEST_SCHEME']
		. '://'
		. $_SERVER['SERVER_NAME'] . ($_SERVER['SERVER_PORT'] != 80 ? ':' . $_SERVER['SERVER_PORT'] : '')
		. implode('?', $url); //print_r($url_new); exit();
	header("location: " . $url_new); exit();
}
