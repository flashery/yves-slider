<?php
	$home_url = 'http://' . $_SERVER['HTTP_HOST'] . dirname($_SERVER['PHP_SELF']);
  	define('HOME_URL', $home_url);
	define('MM_UPLOADPATH', HOME_URL.'/upload/');
	define('MM_MAXFILESIZE', 702768);      // 32 KB
	define('MM_MAXIMGWIDTH', 1200);        // 1200 pixels
	define('MM_MAXIMGHEIGHT', 920);       // 920 pixels
?>