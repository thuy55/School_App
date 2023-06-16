<?php
	define('JATBI', true);
	ini_set('display_errors', 0);
	ini_set('display_startup_errors', 0);
	error_reporting(E_ALL);
	header("Content-Type: text/html; charset=utf8");
	date_default_timezone_set('Asia/Ho_Chi_Minh');
	ob_start();
	session_start();
	require_once 'controllers/includes/config.php';

?>