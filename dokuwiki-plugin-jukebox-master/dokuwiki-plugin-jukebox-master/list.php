<?php
/**
 * @license    GPL 2 (http://www.gnu.org/licenses/gpl.html)
 * @author     Andreas Gohr <gohr@cosmocode.de>
 */

if(!defined('DOKU_INC')) define('DOKU_INC',realpath(dirname(__FILE__).'/../../../').'/');
if(!defined('NL')) define('NL',"\n");
require_once(DOKU_INC.'inc/init.php');
require_once(DOKU_INC.'inc/auth.php');
session_write_close();
require_once(DOKU_INC.'inc/search.php');
require_once(dirname(__FILE__).'/id3/getid3.php');

// get namespace and check permission
$ns  = $_REQUEST['ns'];
if(auth_quickaclcheck("$ns:*") < AUTH_READ){
    header("HTTP/1.0 401 Unauthorized");
    echo 'not authorized';
    exit;
}

if(!$ns){
    header("HTTP/1.0 400 Bad Request");
    echo 'bad request';
    exit;
}


// get a list of files
$dir = utf8_encodeFN(str_replace(':','/',$ns));
$files = array();
search($files,$conf['mediadir'],'search_media',array(),$dir);

$id3 = new getID3();
$id3->encoding           = 'UTF-8';
$id3->option_tag_lyrics3 = false;
$id3->option_tag_apetag  = false;
$id3->option_tags_html   = false;
$id3->option_extra_info  = false;

// output a list
header('Content-Type: text/xml; charset=utf-8');
echo '<?xml version="1.0" encoding="UTF-8"?>'.NL;
echo '<playlist version="0" xmlns="http://xspf.org/ns/0/">'.NL;
echo '  <trackList>'.NL;
foreach($files as $file){
    if(!preg_match('/\.(flv|mp3)$/',$file['id'])) continue;

    $info = $id3->analyze(mediaFN($file['id']));
    getid3_lib::CopyTagsToComments($info);

    echo '    <track>'.NL;
    echo '      <location>'.ml($file['id']).'</location>'.NL;

    if(isset($info['comments']['artist'][0]))
        echo '      <creator>'.hsc($info['comments']['artist'][0]).'</creator>'.NL;
    if(isset($info['comments']['title'][0]))
        echo '      <title>'.hsc($info['comments']['title'][0]).'</title>'.NL;
    if(isset($info['comments']['length'][0]))
        echo '      <duration>'.hsc($info['comments']['length'][0]*1000).'</duration>'.NL;
    if($info['fileformat'] == 'mp3')
        echo '      <meta rel="http://geekkid.net/type">audio</meta>'.NL;

    echo '      <annotation>'.hsc(noNS($file['id'])).'</annotation>'.NL;
    echo '    </track>'.NL;
}
echo '  </trackList>'.NL;
echo '</playlist>'.NL;




//Setup VIM: ex: et ts=4 enc=utf-8 :
