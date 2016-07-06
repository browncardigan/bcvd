<?php
	
// file path
define("DEV", $_SERVER['HTTP_HOST']=='localhost');
define("PATH_ADDON", DEV ? '/bcvd/' : '/');
define("ROOT_PATH", $_SERVER['DOCUMENT_ROOT'] . PATH_ADDON);
define("WWW_PATH", "http://" . $_SERVER['HTTP_HOST'] . PATH_ADDON);
define("TEMPLATE_PATH", ROOT_PATH . 'templates/');
define("VIDEO_PATH", WWW_PATH . 'assets/temp/vid/'); // temp
define("IMAGE_PATH", WWW_PATH . 'assets/farm/local/');

if (DEV) {
	error_reporting(E_ALL);
	ini_set('display_errors', 1);
}

include('_conf_db.php');

// routes
$routes = array();
$routes['video/*'] = array('video', 'post');
$routes['video/*/vote'] = array('video', 'vote');
$routes['channel/*'] = array('channel');
$GLOBALS['routes'] = $routes;

// start
include(ROOT_PATH . 'classes/Site.php');
include(ROOT_PATH . 'classes/SiteRender.php');
$site = new SiteRender;
$site->init();

?>