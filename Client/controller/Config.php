<?php
/**
* Configuration Class
*/
class Config
{
	
	  const LAST_FM_API_KEY = 'LAST_FM_API_KEY';
	  const MUSIC_FOLDER_PATH = __DIR__.'/../music/';
	  const IMAGES_FOLDER_PATH = __DIR__.'/../images/';
	  const NOCOVER_IMAGE_PATH ="/music/no_cover.jpg" ;

	 static function getFullUrl($filename='')
	 {
	  return (isset($_SERVER['HTTPS']) ? "https" : "http") . "://$_SERVER[HTTP_HOST]".dirname($_SERVER['PHP_SELF']).$filename;
	 }

}