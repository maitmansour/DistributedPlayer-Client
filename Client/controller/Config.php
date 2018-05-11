<?php
/**
* Configuration Class
*/
class Config
{
	
	  const LAST_FM_API_KEY = '2f244252a7630eb51bc03e7f561b3108';
	  const MUSIC_FOLDER_PATH = __DIR__.'/../music/';
	  const IMAGES_FOLDER_PATH = __DIR__.'/../images/';
	  const NOCOVER_IMAGE_PATH ="/Client/images/no_cover.jpg" ;
	  const BYTES_BY_MESSAGE =100000 ;


	 static function getFullUrl($filename='')
	 {
	  return (isset($_SERVER['HTTPS']) ? "https" : "http") . "://$_SERVER[HTTP_HOST]".strstr(dirname($_SERVER['PHP_SELF']), "/admi",true).$filename;
	 }

}