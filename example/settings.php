<?php

//To prevent direct access if placed in a public directory
if (!defined('CTBASIC_INCLUDE')) {
	header ( "HTTP/1.0 404 Not found" );
	exit ();
}

define ('CTBASIC_MERCHANTID', 1111);
define ('CTBASIC_APIKEY', "AAAABBBBCCCCDDDDEEEEFFFFGGGGHHHH");

define ('CTBASIC_SHOPURL', "http".($_SERVER['HTTPS']?"s":"")."://".$_SERVER['HTTP_HOST'].dirname($_SERVER['PHP_SELF']));
define ('CTBASIC_CALLBACKURL', CTBASIC_SHOPURL."/callback.php");
define ('CTBASIC_RETURNURL', CTBASIC_SHOPURL."/return.php");

define ('CTBASIC_LOGFILE', 'callback_log.txt');

