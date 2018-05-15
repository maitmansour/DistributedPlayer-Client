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
     * get Machine IP
     */
public function getCurrentHostIp()
{
	$ip = exec('ifconfig wlp1s0 | grep "inet addr"', $full_output);
	$addr=explode(" ", $ip);
	$ip=explode(":", $addr[11]);
	$ip=$ip[1];
	return $ip;
}
    /**
     * add new music
     */
    public function addNewMusic()
    {
    	if ( $this->client->getPlayer()==null) {
    		return "0";
    	}
    	
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
			return "0";
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

	 /**
     * get All Music
     */
	 public function getMusicList($ajax=false)
	 {
	 	if ( $this->client->getPlayer()==null) {
	 		return "0";
	 	}
	 	$result = $this->client->getPlayer()->getAllMusic();
	 	if ($ajax) {
	 		return $result;
	 	}
	 	return json_decode($result,TRUE);

	 }

	 /**
     * get a  Music by filename
     */
	 public function getMusicByFilename($filename)
	 {
	 	$result = $this->client->getPlayer()->findByFeature("filename",$filename);
	 	return json_decode($result,TRUE);

	 }

	 /**
     * delete file by filename
     */
	 public function deleteMusicByFilename($filename)
	 {
	 	$result = $this->client->getPlayer()->deleteFile($filename);
	 	return json_decode($result,TRUE);

	 }

	 /**
     * delete file by filename
     */
	 public function downloadMusicByFilename($filename)
	 {
	 	$file = Config::MUSIC_FOLDER_PATH.$filename.'.mp3';
	 	if (!file_exists($file)) {
	 		$fp = fopen($file, 'wb+');

	 		for ($i=1; true; $i++) { 
	 			$contents=$this->client->getPlayer()->getFile($filename,"".$i);
	 			foreach ($contents as $key => $value) {
	 				fwrite($fp,pack('C*', $value));
	 			}
	 			if (count($contents)<Config::BYTES_BY_MESSAGE) {
	 				break;
	 			}
	 		}
	 		fclose($fp);
	 	}
	 	return  Config::getFullUrl("/Client/music/".$filename.".mp3");

	 }


	 /**
     * listen file by filename FOR APP ONLY
     */
	 public function listenMusicByFilename($filename)
	 {
	 	$file = Config::MUSIC_FOLDER_PATH.$filename.'.mp3';
	 	if (!file_exists($file)) {
	 		$fp = fopen($file, 'wb+');

	 		for ($i=1; true; $i++) { 
	 			$contents=$this->client->getPlayer()->getFile($filename,"".$i);
	 			foreach ($contents as $key => $value) {
	 				fwrite($fp,pack('C*', $value));
	 			}
	 			if (count($contents)<Config::BYTES_BY_MESSAGE) {
	 				break;
	 			}
	 		}
	 		fclose($fp);
	 	}
	 	return  Config::getFullUrl("/DistributedPlayer-Client/Client/music/".$filename.".mp3");

	 }


	}