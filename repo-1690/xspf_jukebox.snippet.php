<?php
/**
 * XSPF Jukebox Media Player
 * Skinnable MODx Flash Music Player
 * @category MODx Snippet
 * @version 0.1.1
 * @date 2007/10/24
 * @author João Peixoto, joeindio@gmail.com
 * 
 * @uses XSPF player by Fabricio Zuardi, customized by Lacy Morrow
 * @link http://blog.lacymorrow.com/projects/xspf-jukebox/
 * @license http://www.gnu.org/copyleft/gpl.html GPL
 * 
 * @file xspf_jukebox.snippet.php
 * @desc Main Snippet File
 * 
 * Installation:
 * * copy this file's contents to a new MODx snippet named XSPFjukebox
 * * copy all files in the package to the assets/snippets/xspf_jukebox folder
 * * copy as many mp3 files as you wish to the assets/media/ folder
 * * call the snippet anywhere on you page, e.g. [!XSPFjukebox!]
 * 
 * (this minimal call returns player with default skin and plays mp3 files
 * inside assets/media/ )
 * 
 * SET PATH - change this to suit your MODx install
 */
$snipPath = 'assets/snippets/xspf_jukebox/';
/*
 * BASE PLAYER PARAMETERS - set these on your snippet call, e.g.
 * 
 * [!XSPFjukebox?skin=`iPodBlack`] (returns player with iPodBlack skin applied)
 * 
 * &embed - player
 * js = embed player using SWFobject method (default)
 * swf = embed player using classic <object><embed> tag
 */
$embed = isset($embed) ? $embed : 'js';
/*
 * &id - unique id of player HTML element
 */
$id = isset($id) ? $id : 'XSPFjukebox';
/*
 * &replaceID - ID of element to replace using SWFobject
 */
$replaceID = isset($replaceID) ? $replaceID : 'XSPFreplace';
/*
 * &skin - skin to use in Player (skins in xspf_jukebox/skins folder)
 * default = iTunes
 */
$skin = isset($skin) ? $skin : 'iTunes';
/*
 * WHAT TO PLAY - each of these parameters has precedence over the next
 * (e.g. if you set &track_url and &playlist_url, a single track will be played)
 * 
 * &track_title : title of the single song file to play
 */
$track_title = isset($track_title) ? $track_title : '';
/*
 * &track_url : url to a single song file to play
 */
$track_url = isset($track_url) ? $track_url : '';
/*
 * &playlist_url : url to a XSPF xml playlist of songs to play
 */
$playlist_url = isset($playlist_url) ? $playlist_url : ''; 
/*
 * &folder : path to a folder with .mp3 files to play
 * When set, the snippet generates a XSPF xml playlist file inside that folder
 * Folder must have write permissions!
 * default = assets/media/
 */
$folder = isset($folder) ? $folder : 'assets/media/';

/* 
 * ADDITIONAL PLAYER PARAMETERS
 * 
 * BOOLEAN parameters - set these as: 0 = false, 1 = true
 */	
$boolean_params = array(
/*
 * &activeDownload : allow or disallow direct downloads of tracks
 * default = false
 */
	'activeDownload',
/*
 * &alphabetize : alphabetize playlist
 * default = false
 */
	'alphabetize',
/*
 * &autoload : makes the playlist load without the initial user click
 * default = false
 */
	'autoload',
/*
 * &autoplay : loads playlist and starts music without a user click
 * default = false
 */
	'autoplay',
/*
 * &autoresume : autoresume music as a user browses pages
 * default = false
 */
	'autoresume',
/*
 * &findImage : retrieve images from Amazon when none set in playlist
 * default = false
 */
	'findImage',
/*
 * &forceAlphabetize : force alphabetizing, including 'the' in artist title
 * default = false
 */
	'forceAlphabetize',
/*
 * &gotoany : forces travel to unknown URLs
 * default = false
 */
	'gotoany',
/*
 * &no_continue : turn off automatic song changing
 * default = false
 */
	'no_continue',
/*
 * &repeat : repeat track
 * default = false
 */
	'repeat',
/*
 * &repeat_playlist : repeat the playlist
 * default = true
 */
	'repeat_playlist',
/*
 * &shuffle : shuffle playlist tracks
 * default = false
 */
	'shuffle',
/*
 * &trackNumber : add track numbers to labels
 * default = false
 */
	'trackNumber',
);

/*
 * INTEGER parameters
 */
$integer_params = array(
/*
 * &buffer : seconds to preload video before playing
 * don't set for automatic
 */
	'buffer',
/*
 * &start_track : track number for beginning track
 * default = 1
 */
	'start_track',
/*
 * &timedisplay : track time display
 * 0 =	off
 * 1 = all
 * 2 = elapsed
 * 3 = duration
 * 4 = countdown (default)
 */
	'timedisplay',
/*
 * &volume_level : starting volume level (%)
 * default = 100
 */
	'volume_level',
/*
 * &crossFade : crossfade duration between playlist tracks (1-12 seconds)
 * default = 6 / no crossfading = 0
 */
	'crossFade' 
);

/*
 * STRING parameters
 */
$string_params = array(
/*
 * &format : text to format track label, use -creator", "-title", "-location",
 * and "- annotation"
 * default = "-creator : -title"
 */
	'format',
/*
 * &image : url for a jpg image that is shown when autoplay is off
 */
	'image',
/*
 * &infourl : global info url for all songs, fills absent playlist info urls
 */
	'infourl',
/*
 * &load_message : message displayed after autoload
 */
	'load_message',
/*
 * &main_image : global image url, fills absent playlist images
 */
	'main_image',
/*
 * &main_url : right-click >> "about" url
 */
	'mainurl',
/*
 * &midChar : character placed to separate creator and title values for tracks,
 * overwritten by format, default = ":"
 */
	'midChar',
/*
 * &player_title : player title text
 * default = "Xspf Jukebox"
 */
	'player_title',
/*
 * &statsurl : url to an external script that can collect POST values. Can
 * collect playSong and annotation
 */
	'statsurl'
);

/*
 * GENERATED PLAYLISTS parameters
 * 
 * &useID3 : force id3 tag use
 * default = false
 */
$useID3 = isset($useID3) ? true : false;
/*
 * &ID3version : mp3 files ID3 version (1 or 2)
 * default = 2
 */
$ID3version = isset($ID3version) ? $ID3version : 2;
/*
 * &use_images : display individual images (jpg/bmp/gif/png) for each track.
 * Image filename must be the same as the track name
 * default = false
 */
$use_images = isset($use_images) ? true : false;

include_once($snipPath.'xspf_jukebox.inc.php');

return $xspf->output();
?>