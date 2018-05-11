<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
set_time_limit(0);
ini_set('memory_limit', '-1');
require '../Client/controller/Functions.php';


$query=isset($_GET['q'])?$_GET['q']:"";
$functions = new Functions();
header('Content-Type: application/json');

switch ($query) {
	case 'songs':
	if (isset($_GET['file'])) {
		$notification=$functions->deleteMusicByFilename($_GET['file']);
	}

	echo $functions->getMusicList(true);

	break;

	default:
	break;
}