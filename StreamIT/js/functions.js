var recongnition=0;
var cornerimage;
var artyom = new Artyom();

window.onkeydown = function(e) {
  return !(e.keyCode == 32);
};

$(document).on('ready', function(){
  updateDuration();
  cornerimage= $( ".cornerimage" );
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


$(window).on('resize', function(){
  $('img[amplitude-song-info="cover_art_url"]').css('height', $('img[amplitude-song-info="cover_art_url"]').width() + 'px' );
});

//Secondes to minutes
function fmtMSS(s){var tmpTime= (s-(s%=60))/60+(9<s?':':':0')+s;
var newPosition = tmpTime.indexOf(":")+3;
return tmpTime.substring(0, newPosition); }

function updateDuration(){
  $(".song-duration").each(function() {
    var duration_div = $( this );
    var musicUrl = duration_div.text();
    duration_div.text('');
    var sound      = document.createElement('audio');
    sound.id       = 'audio-player';
    sound.controls = 'controls';
    sound.src      = musicUrl;
    sound.type     = 'audio/mpeg';
    var secondes;
    sound.onloadedmetadata = function() {
      secondes=sound.duration;
      duration_div.text(fmtMSS(secondes));
    }
    delete sound;
  });
}

function toggleRecognition(){
  if (recongnition==0) {
    //Active recognition for 5 sec
    setTimeout(function(){
      stopArtyom();
    }, 5000);
    startArtyom();
  }else{
    stopArtyom();      
  }

}

function startArtyom(){

  cornerimage.attr('src', "img/microphone-1.svg");
  recongnition=1;

// Start the commands !
artyom.initialize({
    lang: "en-GB", // GreatBritain english
    continuous: false, // Listen forever
    soundex: true,// Use the soundex algorithm to increase accuracy
    debug: true, // Show messages in the console
    listen: true, // Start to listen commands !
    speed:0.9 // talk normally

    // If providen, you can only trigger a command if you say its name
    // e.g to trigger Good Morning, you need to say "Jarvis Good Morning"
   // name: "Jarvis" 
 }).then(() => {
  console.log("Artyom initialized succesfully");
 // artyom.say("Voice recongnition started  now !");
}).catch((err) => {
  console.error("Artyom couldn't be initialized: ", err);
});
initArtyom(artyom);
}


function stopArtyom()
{
  cornerimage.attr('src', "img/microphone-0.svg");
  recongnition=0;  
 // artyom.say("Voice recongnition will stopped now !");
 artyom.fatality().then(() => {
  console.log("Artyom succesfully stopped");
});
}

