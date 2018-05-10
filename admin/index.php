<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
set_time_limit(0);
ini_set('memory_limit', '-1');
require '../Client/controller/Functions.php';
include 'templates/header.php';


$query=isset($_GET['q'])?$_GET['q']:"";
$notification="-1";
$functions = new Functions();

switch ($query) {
	case 'dashboard':
	include 'templates/dashboard.php';
	break;

	case 'music':
	case 'find':
	if (isset($_GET['file'])) {
		$notification=$functions->deleteMusicByFilename($_GET['file']);
	}

	$music_list=$functions->getMusicList();
	include 'templates/find.php';
	break;

	case 'add':
	if (isset($_POST['submit'])) {
		$notification=$functions->addNewMusic();
	}
	include 'templates/add.php';

	break;

	case 'download':
	if (isset($_GET['file'])) {
		$link=$functions->downloadMusicByFilename($_GET['file']);
		$notification="1";
	}else{
		$notification="0";
	}
	include 'templates/download.php';
	break;

	case 'login':
	echo "login";
	break;

	
	default:
	include 'templates/index.php';
	break;
}
include 'templates/footer.php';