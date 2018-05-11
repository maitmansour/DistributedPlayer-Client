<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
set_time_limit(0);
ini_set('memory_limit', '-1');
require '../Client/controller/Functions.php';


$query=isset($_GET['q'])?$_GET['q']:"";
$notification="-1";
$functions = new Functions();
switch ($query) {
	case 'playlist':
	
	# code...
	break;

	default:
	break;
}