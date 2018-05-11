var queryUrl="http://192.168.1.59/DistributedPlayer-Client/admin/ajax.php?q=";
var musicUrl="http://192.168.1.59/DistributedPlayer-Client/Client/music/";

window.onkeydown = function(e) {
  return !(e.keyCode == 32);
};
$(document).on('ready', function(){
  initMusicList();

    /*
    Handles a click on the down button to slide down the playlist.
    */
    $('.down-header').on('click', function(){
    /*
      Sets the list's height;
      */
      $('#list').css('height', ( parseInt( $('#flat-black-player-container').height() ) - 135 )+ 'px' );

    /*
      Slides down the playlist.
      */
      $('#list-screen').slideDown(500, function(){
        $(this).show();
      });
    });

  /*
    Handles a click on the up arrow to hide the list screen.
    */
    $('.hide-playlist').on('click', function(){
      $('#list-screen').slideUp( 500, function(){
        $(this).hide();
      });
    });

  /*
    Handles a click on the song played progress bar.
    */
    document.getElementById('song-played-progress').addEventListener('click', function( e ){
      var offset = this.getBoundingClientRect();
      var x = e.pageX - offset.left;

      Amplitude.setSongPlayedPercentage( ( parseFloat( x ) / parseFloat( this.offsetWidth) ) * 100 );
    });

    $('img[amplitude-song-info="cover_art_url"]').css('height', $('img[amplitude-song-info="cover_art_url"]').width() + 'px' );
  });

function initMusicList() {
  var musicList="";
  var secondes=0;
  $.ajax({url: queryUrl+"songs", success: function(result){
    initAmplitudeList(result);
    $.each(result, function (key, value) {
      var sound      = document.createElement('audio');
      sound.id       = 'audio-player';
      sound.controls = 'controls';
      sound.src      = musicUrl+value['filename']+'.mp3';
      sound.type     = 'audio/mpeg';
      sound.onloadedmetadata = function() {
        secondes=sound.duration
        musicList= '<div class="song amplitude-song-container amplitude-play-pause" amplitude-song-index="0">'+
        '                  <span class="song-number-now-playing">'+
        '                    <span class="number">'+(key+1)+'</span>'+
        '                    <img class="now-playing" src="img/now-playing.svg"/>'+
        '                  </span>'+
        ''+
        '                  <div class="song-meta-container">'+
        '                    <span class="song-name">'+value['title']+'</span>'+
        '                    <span class="song-artist-album">'+value['album']+'</span>'+
        '                  </div>'+
        ''+
        '                  <span class="song-duration">'+
        '                    '+fmtMSS(secondes)+''+
        '                  <span>'+
        '                </div>'+
        '';
        $( "#list" ).append( musicList);
        delete sound;
      };// End Of onloadmetadata

    });// End of Each

  }});//initMusicList End

}

function initAmplitudeList(result) {
  var songs = [];

  $.each(result, function (key, value) {
    songs.push({ 
      "name" : value['title'],
      "artist"  : value['artist'],
      "album"       : value['album'],
      "url"       : musicUrl+value['filename']+'.mp3',
      "cover_art_url"       : value['image']
    });
  });
  Amplitude.init({
    "bindings": {
      37: 'prev',
      39: 'next',
      32: 'play_pause'
    },
    "songs": songs
  });


}


//Secondes to minutes
function fmtMSS(s){var tmpTime= (s-(s%=60))/60+(9<s?':':':0')+s;
var newPosition = tmpTime.indexOf(":")+3;
return tmpTime.substring(0, newPosition); }


$(window).on('resize', function(){
  $('img[amplitude-song-info="cover_art_url"]').css('height', $('img[amplitude-song-info="cover_art_url"]').width() + 'px' );
});
