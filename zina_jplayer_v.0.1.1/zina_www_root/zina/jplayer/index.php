<?php
/*
 * xpsf Playlist parser for JPlayer (http://www.happyworm.com/jquery/jplayer/) by Nick Chapman of Chapman IT and Cornbread Web Development
 *	base page from JPlayer Demo page (with playlist and downloadable content) -- modifications mostly in php, with a few in HTML/JS
 *
 * 	This page demonstrates the use of the JPlayer xpsf Playlist Parser which looks in a playlist and generates a playlist based on it.
 *	A few capabilities have been added:
 *		1- The list can be randomized based on user request // $randomaail must be set to true
 *	
 *	__this page makes use of [zina root]/jp_rand.php for randomization of existing playlist
 * *
 *	__helpful in parsing the XML was the following page
 *	http://devzone.zend.com/article/688
  */

/*
 * set configuration vars -- in theory, changing these should be change or break the jplayer playlist generator
 */

$randomavail = true; //set to false if randomize playlist should not be available (playlist can still be re-called)

//$debug=true;

//END CONFIGURATION
//show if playing specific user playlist, or if playing cumulative playlist

//set temp vars
$playlisttracks=array();

//check for randomization request
if($randomavail==true)
	$random=$_GET['random']; //set to 'true' for random playlist order

?>

<!DOCTYPE html PUBLIC '-//W3C//DTD XHTML 1.0 Transitional//EN' 'http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd'>
<html xmlns='http://www.w3.org/1999/xhtml' lang='en' xml:lang='en'>
<head>
<!-- Website Design By: www.happyworm.com | and being used by Nick Chapman for a JPlayer Audio Playlist Generator-->
<title>JPlayer XSPF Playlist Parser by CBWD</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />

<link href="zina/jplayer/skin/jplayer.blue.monday.css" rel="stylesheet" type="text/css" />

<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.4/jquery.min.js"></script>
<script type="text/javascript" src="zina/jplayer/js/jquery.jplayer.min.js"></script>
<script type="text/javascript">
<!--
$(document).ready(function(){

	var playItem = 0;

	var myPlayList = [
		
		/* REFERENCE Playlist used in demo -- which much of this code came from
		{name:"Tempered Song",mp3:"http://www.miaowmusic.com/audio/mp3/Miaow-01-Tempered-song.mp3",ogg:"http://www.miaowmusic.com/audio/ogg/Miaow-01-Tempered-song.ogg"},
		{name:"Hidden",mp3:"http://www.miaowmusic.com/audio/mp3/Miaow-02-Hidden.mp3",ogg:"http://www.miaowmusic.com/audio/ogg/Miaow-02-Hidden.ogg"},
		{name:"Lentement",mp3:"http://www.miaowmusic.com/audio/mp3/Miaow-03-Lentement.mp3",ogg:"http://www.miaowmusic.com/audio/ogg/Miaow-03-Lentement.ogg"},
		{name:"Lismore",mp3:"http://www.miaowmusic.com/audio/mp3/Miaow-04-Lismore.mp3",ogg:"http://www.miaowmusic.com/audio/ogg/Miaow-04-Lismore.ogg"},
		{name:"The Separation",mp3:"http://www.miaowmusic.com/audio/mp3/Miaow-05-The-separation.mp3",ogg:"http://www.miaowmusic.com/audio/ogg/Miaow-05-The-separation.ogg"},
		{name:"Beside Me",mp3:"http://www.miaowmusic.com/audio/mp3/Miaow-06-Beside-me.mp3",ogg:"http://www.miaowmusic.com/audio/ogg/Miaow-06-Beside-me.ogg"},
		{name:"Bubble",mp3:"http://www.miaowmusic.com/audio/mp3/Miaow-07-Bubble.mp3",ogg:"http://www.miaowmusic.com/audio/ogg/Miaow-07-Bubble.ogg"},
		{name:"Stirring of a Fool",mp3:"http://www.miaowmusic.com/audio/mp3/Miaow-08-Stirring-of-a-fool.mp3",ogg:"http://www.miaowmusic.com/audio/ogg/Miaow-08-Stirring-of-a-fool.ogg"},
		{name:"Partir",mp3:"http://www.miaowmusic.com/audio/mp3/Miaow-09-Partir.mp3",ogg:"http://www.miaowmusic.com/audio/ogg/Miaow-09-Partir.ogg"},
		{name:"Thin Ice",mp3:"http://www.miaowmusic.com/audio/mp3/Miaow-10-Thin-ice.mp3",ogg:"http://www.miaowmusic.com/audio/ogg/Miaow-10-Thin-ice.ogg"}
		*/
		
<?php

//if $random !='true', get playlist from passed content
if($random!='true'){

	//clear session 'back' count
	$_SESSION['backcount']=0;

	//set shuffle link option
	if ($randomavail==true)
		$shuffleoption='<a href="./jp_rand.php?random=true">Shuffle Playlist &raquo;</a>';

	//fix problem with some escaped and some non escaped ampersands (simplexml php page)
	$fixedcontent = preg_replace('/&[^; ]{0,6}.?/e', "((substr('\\0',-1) == ';') ? '\\0' : '&amp;'.substr('\\0',1))", $content);

	$xpsfxml=simplexml_load_string($fixedcontent);

	//debug
	if($debug==true){

		//echo$content;
		var_dump($xpsfxml);
	}

	//make JPlayer Playlist from xml
	foreach ($xpsfxml->trackList as $tracklist) { 
		
		//set counter
		$i=0;
		
		foreach ($tracklist->track as $track) { 
		  //printf("Artist: %s\n", $track->creator); 
		  echo$comma.'{name: "'.$track->creator.' - '.$track->title.'",mp3:"'.$track->location.'"}'; 
		  $debugtext.=$comma.'{name: "'.$track->creator.' - '.$track->title.'",mp3:"'.$track->location.'"}'; 
		  $comma=','."\n\t\t";
		  
		  //store in array
		  $playlisttracks[$i]['creator']=(string)$track->creator;
		  $playlisttracks[$i]['title']=(string)$track->title;
		  $playlisttracks[$i]['location']=(string)$track->location;
		  
		  //inc counter
		  $i++;
		} 
		
	}
	
	//regardless, save playlist just in case	
	if($randomavail==true)
		$_SESSION['playlist']=$playlisttracks;
	
}

else if($randomavail==true){
	
	//assuming $random=true
	
	//inc session 'back' count
	$_SESSION['backcount']=1;
	
	//randomize array if requested
	shuffle($_SESSION[playlist]);
	
	foreach ($_SESSION[playlist] as $track) { 
	  //printf("Artist: %s\n", $track->creator); 
	  echo$comma.'{name: "'.$track['creator'].' - '.$track['title'].'",mp3:"'.$track['location'].'"}'; 
	  $comma=','."\n\t\t";
	}
	
	//set shuffle link option
	$shuffleoption='<a href="./jp_rand.php?random=true">Shuffle Again &raquo;</a>';

}

?>
		
	];

	// Local copy of jQuery selectors, for performance.
	var jpPlayTime = $("#jplayer_play_time");
	var jpTotalTime = $("#jplayer_total_time");

	$("#jquery_jplayer").jPlayer({
		ready: function() {
			displayPlayList();
			playListInit(true); // Parameter is a boolean for autoplay.
		},
		oggSupport: false
	})
	.jPlayer("onProgressChange", function(loadPercent, playedPercentRelative, playedPercentAbsolute, playedTime, totalTime) {
		jpPlayTime.text($.jPlayer.convertTime(playedTime));
		jpTotalTime.text($.jPlayer.convertTime(totalTime));
	})
	.jPlayer("onSoundComplete", function() {
		playListNext();
	});

	$("#jplayer_previous").click( function() {
		playListPrev();
		$(this).blur();
		return false;
	});

	$("#jplayer_next").click( function() {
		playListNext();
		$(this).blur();
		return false;
	});

	function displayPlayList() {
		$("#jplayer_playlist ul").empty();
		for (i=0; i < myPlayList.length; i++) {
			var listItem = (i == myPlayList.length-1) ? "<li class='jplayer_playlist_item_last'>" : "<li>";
			listItem += "<a href='#' id='jplayer_playlist_item_"+i+"' tabindex='1'>"+ myPlayList[i].name +"</a> (<a id='jplayer_playlist_get_mp3_"+i+"' href='" + myPlayList[i].mp3 + "' tabindex='1'>mp3</a>)</li>";
			$("#jplayer_playlist ul").append(listItem);
			$("#jplayer_playlist_item_"+i).data( "index", i ).click( function() {
				var index = $(this).data("index");
				if (playItem != index) {
					playListChange( index );
				} else {
					$("#jquery_jplayer").jPlayer("play");
				}
				$(this).blur();
				return false;
			});
			$("#jplayer_playlist_get_mp3_"+i).data( "index", i ).click( function() {
				var index = $(this).data("index");
				$("#jplayer_playlist_item_"+index).trigger("click");
				$(this).blur();
				return false;
			});
		}
	}

	function playListInit(autoplay) {
		if(autoplay) {
			playListChange( playItem );
		} else {
			playListConfig( playItem );
		}
	}

	function playListConfig( index ) {
		$("#jplayer_playlist_item_"+playItem).removeClass("jplayer_playlist_current").parent().removeClass("jplayer_playlist_current");
		$("#jplayer_playlist_item_"+index).addClass("jplayer_playlist_current").parent().addClass("jplayer_playlist_current");
		playItem = index;
		$("#jquery_jplayer").jPlayer("setFile", myPlayList[playItem].mp3, myPlayList[playItem].ogg);
	}

	function playListChange( index ) {
		playListConfig( index );
		$("#jquery_jplayer").jPlayer("play");
	}

	function playListNext() {
		var index = (playItem+1 < myPlayList.length) ? playItem+1 : 0;
		playListChange( index );
	}

	function playListPrev() {
		var index = (playItem-1 >= 0) ? playItem-1 : myPlayList.length-1;
		playListChange( index );
	}
});
-->
</script>

</head>
<body>

<?php if(($debug==true) AND ($randomavail==true)){var_dump($_SESSION[playlist]); echo'<div>'.$debugtext.'</div>';} ?>

<div style="text-align: center;"><h1>JPlayer XPSF Playlist Player<br /><span style="font-size: 70%; color: #AAA;"> for Zina</span></h1></div>

<?php 

//echo the following to show a floating right column with helpful information

$unusedcontent=<<<UUC
<div style="float:right; width: 400px; padding: 15px; background-color: #EEE;"><h2>JPlayer Audio Playlist Generator<br />[JPlayer Playlister] v. 0.2</h2>
	<h2>Change Log</h2>
	The only noticeable change from version 0.1 is that the JPlayer Playlister, when pointed at a directory, now has the ability to load songs in that directory and one level of subdirectories.  Truly recursive loading may come in the future.
	<h2>Source / Download</h2>
	<ul><li><a href="http://chapmanit.thruhere.net/nick/source/JPlayer_Playlister_0.2.zip">Source</a> (version 0.2)</li></ul>
	<h2>Implementations</h2>
	<ul><li><a href="http://demo.chapmanit.com/jplayerPlaylist">Initial Use - MP3 CD Playback and Distro</a> (version 0.1)</li>
	<li><a href="http://chapmanit.thruhere.net/nick/source/v_0.2/">Version 0.2 Demo</a> (this page)</li>
	<li><a href="http://chapmanit.thruhere.net/nick/dev/birthday.php">Birthday Implementation</a> (click 'Listen to All')</li>
	<li><a href="http://chapmanit.thruhere.net/nick/sendmemusic.zip">'Send Me Music' source derived from Birthday implementation above</a> (<a href="http://chapmanit.thruhere.net/nick/tarran/">Demo</a>)</li></ul>
	<h2>Bio</h2>
	This page demonstrates the JPlayer Audio Playlist Generator, by Cornbread Web Design (A division of <a href="http://chapmanit.com">Chapman IT</a>).
	The original use of this code can be seen <a href="http://demo.chapmanit.com/jplayerPlaylist">here</a>.  Backstory can be found there, as well.
	<br /><br />
	_Props_
	<br />
	I implemented this player, and coded the PHP Playlist Generator...but couldn't have done it without lots of help:
	<br /><br />
	<a href="http://www.happyworm.com/jquery/jplayer/">JPlayer</a> &raquo; Awesome HTML5 (flash fallback) Audio/Video player with playlist capability which is the foundation upon which this project was built; and the bricks comprising the walls, for that matter.
	<br />
	<a href="http://getid3.sourceforge.net/">getID3</a> &raquo; PHP Class allowing the easy access to ID3 information for various audio files.
	<br /><br />
	_Using the Code_
	<br />
	A basic grasp of PHP will help, if not be necessary, to use this code.  You may be able to scrape by if you don't know Javascript (like me).
	<br /><br />
	Basically, though, assuming you are running a web server with PHP installed and configured, you will need to 
	extract the contents of the JPlayer Playlist Generator (JPlayer Playlister) by CBD (download from links above) 
	and drop some mp3 files or folders (others audio types weren't tested, but should work...may require a little code work) into the 
	'songs' folder.  Load up the page and you should be all set.  Currently, the JPlayer Playlister only plays songs in target directory
	'root' and one subfolder deep.  The code may go deeper soon.
	<br /><br />
	There are a couple of configuration options at the top of 'index.php' which you can change to little end.  Or, you can get fancy and
	click 'shuffle' to randomize the playlist.  Let me know if you have any trouble.  Email me(thenickchapmanATgmail.com) or post to 
	the <a href="http://groups.google.com/group/jplayer/">JPlayer Google Group</a>'s 
	<a href="http://groups.google.com/group/jplayer/browse_thread/thread/a17290db2599e98b">PHP Playlist Generator<a> page. 
	<br /><br />
	-<a href="http://nick.chapmanit.com">nc</a>
UUC;
?>
	
</div>

<div id="jquery_jplayer"></div>

<div class="jp-playlist-player"><?php echo'<h3><a href="#" onclick="history.go('.(-1-$_SESSION['backcount']).');return false;">Back to Zina</a> 
</h3>'.$shuffleoption;?>
	<div class="jp-interface">
		<ul class="jp-controls">
			<li><a href="#" id="jplayer_play" class="jp-play" tabindex="1">play</a></li>
			<li><a href="#" id="jplayer_pause" class="jp-pause" tabindex="1">pause</a></li>
			<li><a href="#" id="jplayer_stop" class="jp-stop" tabindex="1">stop</a></li>
			<li><a href="#" id="jplayer_volume_min" class="jp-volume-min" tabindex="1">min volume</a></li>
			<li><a href="#" id="jplayer_volume_max" class="jp-volume-max" tabindex="1">max volume</a></li>
			<li><a href="#" id="jplayer_previous" class="jp-previous" tabindex="1">previous</a></li>
			<li><a href="#" id="jplayer_next" class="jp-next" tabindex="1">next</a></li>
		</ul>
		<div class="jp-progress">
			<div id="jplayer_load_bar" class="jp-load-bar">
				<div id="jplayer_play_bar" class="jp-play-bar"></div>
			</div>
		</div>
		<div id="jplayer_volume_bar" class="jp-volume-bar">
			<div id="jplayer_volume_bar_value" class="jp-volume-bar-value"></div>
		</div>
		<div id="jplayer_play_time" class="jp-play-time"></div>
		<div id="jplayer_total_time" class="jp-total-time"></div>
	</div>
	<div id="jplayer_playlist" class="jp-playlist">
		<ul>
			<!-- The function displayPlayList() uses this unordered list -->
			<li></li>
		</ul>
	</div>
</div>

</body>
</html>
