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
		$title=addslashes($_POST['title']);
		$artist=addslashes($_POST['artist']);
		$album=addslashes($_POST['album']);
		$year=addslashes($_POST['year']);
		if($this->uploader->uploadFile('file')){   
		    $generated_name  =   $this->uploader->getUploadName(); 
		    $generated_name = strstr($generated_name,".mp3",true);
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

		$result = $this->client->getPlayer()->addNewFile($title,$artist,$album,$year,$generated_name,$music_img);

		if ($result=='1') {
			$uploaded_music_path=$this->music_path."/".$generated_name.".mp3";
			$file_ptr = fopen($uploaded_music_path, "rb");
			$file_contents = fread($file_ptr, filesize($uploaded_music_path));
			fclose($file_ptr);
			$file_bytes = unpack('C*', $file_contents);
			
			//Chunk Array
			$file_bytes_arrays=array_chunk($file_bytes, Config::BYTES_BY_MESSAGE);
			$size=count($file_bytes_arrays)-1;
			foreach ($file_bytes_arrays as $bytes_array_key => $bytes_array_value) {
			$this->client->getPlayer()->setFile($generated_name."",$bytes_array_value,$bytes_array_key."",$size."");
			}
		}
			$this->uploader->deleteUploaded();

		return $result;
	}
}