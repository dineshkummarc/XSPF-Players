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
 * @file xspf_jukebox.inc.php
 * @desc Snippet Processor File
 */
include_once($snipPath.'xspf_jukebox.class.php');

//Instantiate XSPFjukebox Class Object
switch ($embed){
	case 'swf':
		$xspf = new XSPFjukebox('swf',$id);
		break;
	default:
		$xspf = isset($replaceID) ? new XSPFjukebox('js',$id,$replaceID) : new XSPFjukebox('js',$id);
		//include needed SWFobject library on page header
		$modx->regClientStartupScript($snipPath.'swfobject.js');
		break;
}

//Apply Skin
$xspf->readSkin($skin);

//Set URL variables according to Snippet call parameters
$vars = array();
foreach ($boolean_params as $param){
	if (isset(${$param})){
 		if(${$param} == 0){
 			$vars[$param] = 'false';
 		}else{
 			$vars[$param] = 'true';
 		}
 	}	
}
foreach ($integer_params as $param){
	if (isset(${$param})){
		if (is_numeric(${$param})) $vars[$param] = ${$param};
	}
}
foreach ($string_params as $param){
	if (isset(${$param})) $vars[$param] = ${$param};
}
$xspf->URLvars = $xspf->encodeVars($vars);

//ID3 Settings
if ($useID3){
	$xspf->URLvars .= "&useId3=true";
	//load ID3 handling library
	require_once($this->base_folder.'id3/getid3.php');
	$getID3 = new getID3;	
}

//Select what to play
if ($track_url != ''){
//Play a single track
	$xspf->target = 'track_url='.$track_url;
	if ($track_title != ''){
		$xspf->target .= '&track_title='.urlencode($track_title);	
	}elseif(isset($useId3) && $useId3 == '1'){
		//Use ID3
		if($vars['useId3'] == 'true'){
			$xspf->target .= '&track_title='.$ID3title;
		}
	}

}elseif($playlist_url != ''){
//Play a remote XSPF playlist
	
	$xspf->target .= '&playlist_url='.$playlist_url;
	
}elseif($folder != ''){
//Play files from a folder - generate playlist
	$generate = false;
	$dir = $modx->config['base_path'].$folder;
	$url =  $modx->config['site_url'].$folder;
	$playlist_file = "xspf_generated_playlist.xml";
	if(file_exists($dir.$playlist_file)){
	//check if playlist needs to be generated
		if((date("z")-date("z", filemtime($dir.$playlist_file)) >= 7) || date("z") < 7){
			$tracks = $xspf->readFiles($dir);//generate
		} else {
			$playlist = $url.$playlist_file;//don't generate - file exists and is recent
		}
	} else {
		$tracks = $xspf->readFiles($dir);//generate
	}
	if ($tracks){
		if ($useID3){
			$content = $xspf->XSPFplaylist($tracks,$dir,$url,$getID3,$ID3version,$use_images);
		}else{
			$content = $xspf->XSPFplaylist($tracks,$dir,$url,false,$ID3version,$use_images);
		}
		$fh = fopen($dir.$playlist_file, 'w') or die("can't open file");
		fwrite($fh, $content);
		fclose($fh);	
	}
	$xspf->target .= '&playlist_url='.$url.$playlist_file;
}else{
	$xspf->debug .= '<p>Nothing to play! Check your track_url, playlist_url or media parameters';
}
?>
