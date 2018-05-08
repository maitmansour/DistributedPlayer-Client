
<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
ini_set('memory_limit', '-1');

require 'Ice.php';
require 'app/Player.php';
 
$ic = null;
try
{
    $ic = Ice\initialize();
    $base = $ic->stringToProxy("DistributedPlayer:default -p 10000");
    $player = Mp3Player\PlayerPrxHelper::checkedCast($base);
    if(!$player)
    {
        throw new RuntimeException("Invalid proxy");
    }
    
$my_place = "music/"; // directory of your file 
$my_file = "bensound.mp3"; // your file

$my_path = $my_place.$my_file;
$array=null;


//SENDING
$handle = fopen($my_path, "rb");
$contents = fread($handle, filesize($my_path));
fclose($handle);
$byte_array = unpack('C*', $contents);

//Chunk Array
$byte_parts=array_chunk($byte_array, 100000);
$date = date_create();
$name= date_timestamp_get($date);
$size=count($byte_parts)-1;
foreach ($byte_parts as $keyArray => $valueArray) {
$player->setFile($name."",$valueArray,$keyArray."",$size."");
}



//READING
/*
$file = 'music/streamed.mp3';
$contents=$player->getFile();
$fp = fopen($file, 'wb');
foreach ($contents as $key => $value) {
fwrite($fp,pack('C*', $value));
}
fclose($fp);

*/
echo "ok"; die;

    if ($argc>1) {
        
    $functionChoice = $argv[1];

            switch ($functionChoice) {
                case 'addNewFile':
            echo $player->addNewFile($argv[2],$argv[3],$argv[4],$argv[5],$argv[6],$argv[7]);
                    break;
                
                case 'findByFeature':
            echo $player->findByFeature($argv[2],$argv[3]);
                    break;
                
                case 'deleteFile':
            echo $player->deleteFile($argv[2]);
                    break;

                default :
            echo "Function <".$functionChoice."> not defined, please use : \n-addNewFile [title, path, artist, album,  year, rating]\n-findByFeature [featureName, featureValue]\n-deleteFile [path]\n";
                    break;
            }
    }else{
            echo "Syntaxe error : please use php -f Client.php <Function name> [param1,param2,...]\n";

    }

}
catch(Exception $ex)
{
    echo $ex;
}
 
if($ic)
{
    $ic->destroy(); // Clean up
}
?>
