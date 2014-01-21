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
 * @file xspf_jukebox.class.php
 * @desc XSPFjukebox Class Descriptor
 */

class XSPFjukebox {
	var $id;
	var $path;
	var $base_folder;
	var $base_url;
	var $skin;
	var $target;
	var $URLvars;
	var $debug;

	function XSPFjukebox($embedMode,$id,$replaceID){
		global $modx;
		$this->id = $id;
		$this->path = 'assets/snippets/xspf_jukebox/';
		$this->base_folder = $modx->config['base_path'].$this->path;
		$this->base_url = $modx->config['site_url'].$this->path;
		switch ($embedMode){
			case 'swf':
				$this->tag = $this->SWFtag();
				break;
			default:
				$this->tag = $this->JStag($replaceID);
				break;	
		}
		$this->skin = array();
		$this->target = '';
		$this->URLvars = '';
		$this->debug = '';
	}

	function output(){
	//output player tag to page
    	$settings = array(
    		'[+id+]' => $this->id,
			'[+url+]' => $this->base_url.'xspf_jukebox.swf',
			'[+skin_url+]' => $this->skin['url'],			
			'[+width+]' => $this->skin['width'],
			'[+height+]' => $this->skin['height'],
			'[+target+]' => $this->target,
			'[+vars+]' => $this->URLvars
		);
		$tag = $this->tag;
		foreach ($settings as $setting => $value){
			$tag = str_replace($setting,$value,$tag); 
		}
		if ($this->debug != ''){
			return $this->debug;
		} else{
			return $tag;	
		}		
	}

	function JStag($replaceID){
		$tag = '';
		if ($replaceID == 'XSPFreplace') $tag .= '<div id="'.$replaceID.'">
			XSPFjukebox player: please enable javascript or use embed=`swf`
			</div>';
		$tag .= '<script type="text/javascript">
				<!--
					var so = new SWFObject("[+url+]?[+target+]&skin_url=[+skin_url+][+vars+]",';
		$tag .= '"[+id+]","[+width+]","[+height+]", "7", "ffffff", true);';
		$tag .= 'so.addParam("wmode", "transparent");
					so.write("'.$replaceID.'");
				-->
				</script>';
		return $tag;
	}
	
	function SWFtag(){
		$tag = '<object id="[+id+]" width="[+width+]" height="[+height+]" align="middle">
		<param name="movie" value="[+url+]?[+target+]&skin_url=[+skin_url+][+vars+]" />
		<param name="wmode" value="transparent" />
		<embed src="[+url+]?skin_url=[+skin_url+][+target+][+vars+]"
					wmode="transparent"
					width="[+width+]"
					height="[+height+]"
					name="[+id+]"
					align="middle"
					type="application/x-shockwave-flash"
					pluginspage="http://www.macromedia.com/go/getflashplayer" />
		</object>';
		return $tag;
	}

	function readSkin($skin_name){
		$skin_file = $this->base_folder.'skins/'.$skin_name.'/skin.xml';
		if (file_exists($skin_file)){
			$doc = file_get_contents($skin_file);
			$parser = xml_parser_create('UTF-8');
			xml_parser_set_option($parser, XML_OPTION_SKIP_WHITE, 1); 
			xml_parse_into_struct($parser, $doc, $tags, $index); 
			$skin = array();
			foreach ($tags as $tag){
				$skin[$tag['tag']] = $tag['value'];
			}
			$this->skin['url'] = $this->base_url.'skins/'.$skin_name.'/';
			$this->skin['name'] = $skin['NAME'];
			$this->skin['width'] = $skin['WIDTH'];
			$this->skin['height'] = $skin['HEIGHT'];
		}else{
			$this->debug .= '<p>Unable to read '.$skin_name.' skin. Check your skins/ folder</p>';
		}
	}

	function encodeVars($varsArray){
	//encode set variables to URL string
    	$vars = '';
    	if (count($varsArray) > 0){
    		foreach ($varsArray as $var => $value){
    			$vars .= '&'.$var.'='.$value;
    		}
    	}
    	return $vars;
	}

	function readFiles($media_path){
	//read mp3 files inside a folder
		if ($h = opendir($media_path)){
			$i = 0;
			while (false !== ($f = readdir($h))){
				if($f == '.' || $f == '..'){
					$f = '';	
				}elseif (is_dir($media_path.$f)){
					foreach (glob($media_path.$f."/*.mp3") as $filename){
						if (strpos($filename, '.mp3')){
							$audiofiles[$i] = str_replace("$media_path", "", $filename);
							$i++;
						}
					}
				}elseif (strpos($f, '.mp3')){
					$audiofiles[$i] = $f;
					$i++;
				}
			}
		}
		closedir($h);
		if(count($audiofiles) > 0){
			sort($audiofiles);
			reset($audiofiles);
		}else{
			$this->debug .= '<p>Nothing to play! Check for audio files in media folder.</p>';
			$audiofiles = false;									
		}		
		return $audiofiles;
	}

	function XSPFplaylist($tracks,$dir,$url,$getID3,$ID3version,$use_images){
	/*
	 * Code Adapted from Automatic XSPF Playlist generator PHP Script v2.0
	 * dreden http://www.dreden.com
	 */
		$i = 0;
		//Generate playlist header
		$output .= "<?xml version=\"1.0\" encoding=\"UTF-8\"?>\n<playlist version=\"0\" xmlns = \"http://xspf.org/ns/0/\">\n";
		$output .= "<trackList>\n";
		//Generate playlist items
		for($j = 0; $j < count($tracks); $j++){
			$filename = "$dir" . "$tracks[$j]";
			$tempname = substr($filename, strrpos($filename, '/')+1);
			if ($use_images) {
				foreach (glob(dirname($filename)."/".substr($tempname, 0, strpos($tempname, '.mp3')).".*") as $tempfile) {
					if (strpos($tempfile, '.jpg') || strpos($tempfile, '.bmp') || strpos($tempfile, '.gif') || strpos($tempfile, '.png')) {
						$audioimage[$j] = str_replace($dir,$url,$tempfile);
					}
				}
			}
			if($getID3){
				$fileinfo = $getID3->analyze($filename);
				if (!$fileinfo['tags']['id3v'.$ID3version]['title']['0']){
					$filetitle = substr($tempname, 0, strpos($tempname, '.mp3'));
				} else {
					$filetitle = $fileinfo['tags']['id3v'.$ID3version]['title']['0'];
				}
			}
			$output .= "<track><location>" . $url . $tracks[$j] . "</location>";
			if ($getID3){
				$output .= "<creator>" . $fileinfo['tags']['id3v'.$ID3version]['artist']['0'] . "</creator><title>" . $filetitle . "</title>";
				if ($audioimage[$j]){
					$output .= "<image>" . $audioimage[$j] . "</image>";
				}
				$output .= "</track>\n";
			} else {
				if (!strrpos(dirname($filename), '/')){		
					$tempcreator = substr(dirname($filename), 0);
				} else {
					$tempcreator = substr(dirname($filename), strrpos(dirname($filename), '/')+1);
				}
				$output.= "<creator>" . $tempcreator . "</creator><title>" . substr($tempname, 0, strpos($tempname, '.mp3')) . "</title>";
				if ($audioimage[$j]){
					$output .= "<image>" . $audioimage[$j] . "</image>";
				}
				$output .= "</track>\n";
			}
		}
		return $output;
	}

}
?>
