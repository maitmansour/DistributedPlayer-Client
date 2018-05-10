<?php
require 'Config.php';
require 'Uploader.php';
require 'Client.php';
require 'LastFmInvoker.php';

/**
* all Functions
*/
class Functions
{
	private $client;
	private $uploader;
	private $lastFm;
	private $music_path;

	/**
* init project
*/
function __construct()
{
	$this->client=new Client();
	$this->uploader=new Uploader();
	$this->lastFm=new LastFmInvoker();
	$this->music_path=Config::MUSIC_FOLDER_PATH;
}

    /**
     * add new music
     */
    public function addNewMusic()
    {
    	$this->uploader->setDir($this->music_path);
		$this->uploader->setExtensions(array('mp3'));  //allowed extensions list//
		$this->uploader->setMaxSize(10);     
		$this->uploader->sameName(false);
		$generated_name = "";
		if($this->uploader->uploadFile('file')){   
		    $generated_name  =   $this->uploader->getUploadName(); 
		}else{//upload failed
		  echo  $this->uploader->getMessage(); //get upload error message 
		}


		$data = array (
		    'artist' => $_POST['artist'],
		    'track' => $_POST['title']
		);

		$this->lastFm->prepare($data);
		$music_img=$this->lastFm->getAlbumImage($data);
		if ($music_img==false) {
		$music_img=Config::getFullUrl(Config::NOCOVER_IMAGE_PATH);
				}

echo $music_img;
die;
	}
}