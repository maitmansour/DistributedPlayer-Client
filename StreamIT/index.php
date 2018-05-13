<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
set_time_limit(0);
ini_set('memory_limit', '-1');
require '../Client/controller/Functions.php';
$functions = new Functions();
$songs="";
?>

<!DOCTYPE html>
<html>
<head>
  <title>AmplitudeJS Testing</title>
  <meta name=viewport content="width=device-width, initial-scale=1">

  <!-- Include Resource Stylesheets -->
  <link rel="stylesheet" type="text/css" href="resources/css/foundation.min.css"/>

  <!-- Include font -->
  <link href="https://fonts.googleapis.com/css?family=Lato:400,400i" rel="stylesheet">

    <!--
      Include Resource Javascript

      NOTE: These are for handling things outside of the scope of AmplitudeJS
    -->
    <script type="text/javascript" src="resources/js/jquery.js"></script>
    <script type="text/javascript" src="resources/js/foundation.min.js"></script>

    <!-- Include Amplitude JS -->
    <script type="text/javascript" src="dist/amplitude.js"></script>

    <!-- Include Artyom JS -->
    <script ype="text/javascript" src="resources/artyom/artyom.window.min.js"></script>

    <!--
      Include UX functions JS

      NOTE: These are for handling things outside of the scope of AmplitudeJS
    -->
    <script type="text/javascript" src="js/functions.js"></script>
    <style type="text/css">
    .cornerimage {
      border: 0;
      position: absolute;
      top: 0;
      right: 0;
      height: 100px;
      padding-top: 10px;
      fill:#000;
    } 
  </style>
  <!-- Include Style Sheet -->
  <link rel="stylesheet" type="text/css" href="css/styles.css"/>
</head>
<body>
  <div class="row">
    <div class="large-12 medium-12 small-12 large-centered medium-centered columns">
      <div id="flat-black-player-container">
        <div id="list-screen" class="slide-in-top">

          <div id="list-screen-header" class="hide-playlist">
            <img id="up-arrow" src="img/up.svg"/>
            Hide Playlist
          </div>

          <div id="list">
            <?php
            $music_list=$functions->getMusicList();
            $songs="[";
            $artyom_play_commands='';
            foreach ($music_list as $music_key => $music_value) {
              $songs.='{
                "name" : "'.$music_value['title'].'",
                "artist"  : "'.$music_value['artist'].'",
                "album"       : "'.$music_value['album'].'",
                "url"       : "'.$functions->listenMusicByFilename($music_value['filename']).'",
                "cover_art_url"       : "'.$music_value['image'].'"
              },';

              $artyom_play_commands.='
              {
                indexes: ["play '.$music_value['artist'].' '.$music_value['title'].'","play'.$music_value['title'].'","Please Play '.$music_value['title'].'"],
                action: (i) => {
                  Amplitude.playNow({
                    "name" : "'.$music_value['title'].'",
                    "artist"  : "'.$music_value['artist'].'",
                    "album"       : "'.$music_value['album'].'",
                    "url"       : "'.$functions->listenMusicByFilename($music_value['filename']).'",
                    "cover_art_url"       : "'.$music_value['image'].'"
                  });
                }
              },';

              echo ' 
              <div class="song amplitude-song-container amplitude-play-pause" amplitude-song-index="'.$music_key.'">
              <span class="song-number-now-playing">
              <span class="number">'.($music_key+1).'</span>
              <img class="now-playing" src="img/now-playing.svg"/>
              </span>

              <div class="song-meta-container">
              <span class="song-name">'.$music_value['title'].'</span>
              <span class="song-artist-album">'.$music_value['album'].'</span>
              </div>
              <span class="song-duration">
              '.$functions->listenMusicByFilename($music_value['filename']).'
              </span>
              </div>
              ';
            }
            $songs=substr($songs, 0,-1);
            $songs.="]";

            ?>
          </div>

          <div id="list-screen-footer">
            <div id="list-screen-meta-container">
              <span amplitude-song-info="name" amplitude-main-song-info="true" class="song-name"></span>

              <div class="song-artist-album">
                <span amplitude-song-info="artist" amplitude-main-song-info="true"></span>
              </div>
            </div>
            <div class="list-controls">
              <div class="list-previous amplitude-prev"></div>
              <div class="list-play-pause amplitude-play-pause" amplitude-main-play-pause="true"></div>
              <div class="list-next amplitude-next"></div>
            </div>
          </div>
        </div>
        <div id="player-screen">
          <div class="player-header down-header">
            <img id="down" src="img/down.svg"/>
            Show Playlist
          </div>
          <div id="player-top">
            <img amplitude-song-info="cover_art_url" amplitude-main-song-info="true"/>
            <img class="cornerimage" src="img/microphone-0.svg" onclick="toggleRecognition()">
          </div>
          <div id="player-progress-bar-container">
            <progress id="song-played-progress" class="amplitude-song-played-progress" amplitude-main-song-played-progress="true"></progress>
            <progress id="song-buffered-progress" class="amplitude-buffered-progress" value="0"></progress>
          </div>
          <div id="player-middle">
            <div id="time-container">
              <span class="amplitude-current-time time-container" amplitude-main-current-time="true"></span>
              <span class="amplitude-duration-time time-container" amplitude-main-duration-time="true"></span>
            </div>
            <div id="meta-container">
              <span amplitude-song-info="name" amplitude-main-song-info="true" class="song-name"></span>

              <div class="song-artist-album">
                <span amplitude-song-info="artist" amplitude-main-song-info="true"></span>
              </div>
            </div>
          </div>
          <div id="player-bottom" style="
    position: relative;
">
            <div id="control-container">

              <div id="shuffle-container">
                <div class="amplitude-shuffle amplitude-shuffle-off" id="shuffle"></div>
              </div>

              <div id="prev-container">
                <div class="amplitude-prev" id="previous"></div>
              </div>

              <div id="play-pause-container">
                <div class="amplitude-play-pause" amplitude-main-play-pause="true" id="play-pause"></div>
              </div>

              <div id="next-container">
                <div class="amplitude-next" id="next"></div>
              </div>

              <div id="repeat-container">
                <div class="amplitude-repeat" id="repeat"></div>
              </div>

            </div>

            <div id="volume-container">
              <img src="img/volume.svg"/><input type="range" class="amplitude-volume-slider" step=".1"/>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
</body>
</html>

<script type="text/javascript">
  Amplitude.init({
    "bindings": {
      "37": "prev",
      "39": "next",
      "32": "play_pause"
    },
    "songs": <?=$songs?>
  });

</script>

<script type="text/javascript">
/*// Create a variable that stores your instance
var artyom = new Artyom();
// Start the commands !
artyom.initialize({
    lang: "en-GB", // GreatBritain english
    continuous: true, // Listen forever
    soundex: true,// Use the soundex algorithm to increase accuracy
    debug: true, // Show messages in the console
    executionKeyword: "and do it now",
    listen: true, // Start to listen commands !
    speed:1 // talk normally

    // If providen, you can only trigger a command if you say its name
    // e.g to trigger Good Morning, you need to say "Jarvis Good Morning"
   // name: "Jarvis" 
 }).then(() => {
  console.log("Artyom has been succesfully initialized");
}).catch((err) => {
  console.error("Artyom couldn't be initialized: ", err);
});*/
function initArtyom(artyom){

  artyom.addCommands([
  {
    indexes: ['start','Play music'],
    action: (i) => {
      Amplitude.play();
    }
  },{
    indexes: ['stop listening','stop voice recognition','end voice recognition'],
    action: (i) => {
      stopArtyom();
    }
  },
  {
    indexes: ['stop','Pause','Hold On','Stop music'],
    action: (i) => {
      Amplitude.pause();
    }
  },
  {
    indexes: ['next','Go on'],
    action: (i) => {
      Amplitude.next();
    }
  },
  <?=$artyom_play_commands?>
  {
    indexes: ['previous','Go back'],
    action: (i) => {
      Amplitude.prev();
    }
  },
    // The smart commands support regular expressions
    {
      indexes: [/Good Morning/i],
      smart:true,
      action: (i,wildcard) => {
        artyom.say("You've said : "+ wildcard);
      }
    },
    ]);
}
console.log("ok");
</script>