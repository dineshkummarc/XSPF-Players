<?php
/**
 * Embed a flash Jukebox
 *
 * @license    GPL 2 (http://www.gnu.org/licenses/gpl.html)
 * @author     Andreas Gohr <andi@splitbrain.org>
 */

if(!defined('DOKU_INC')) define('DOKU_INC',realpath(dirname(__FILE__).'/../../').'/');
if(!defined('DOKU_PLUGIN')) define('DOKU_PLUGIN',DOKU_INC.'lib/plugins/');
require_once(DOKU_PLUGIN.'syntax.php');

class syntax_plugin_jukebox extends DokuWiki_Syntax_Plugin {

    /**
     * What kind of syntax are we?
     */
    function getType(){
        return 'substition';
    }

    /**
     * What about paragraphs?
     */
    function getPType(){
        return 'block';
    }

    /**
     * Where to sort in?
     */
    function getSort(){
        return 301;
    }


    /**
     * Connect pattern to lexer
     */
    function connectTo($mode) {
        $this->Lexer->addSpecialPattern('\{\{jukebox>[^}]*\}\}',$mode,'plugin_jukebox');
    }

    /**
     * Handle the match
     */
    function handle($match, $state, $pos, &$handler){
        global $ID;
        $match = substr($match,10,-2); //strip markup from start and end

        $data = array();

        // extract params
        list($ns,$params) = explode(' ',$match,2);
        $ns = trim($ns);

        // namespace (including resolving relatives)
        $data['ns'] = resolve_id(getNS($ID),$ns);
        $data['skin'] = 'original';

        // alignment
        $data['align'] = 'left';
        if(preg_match('/\bleft\b/i',$params)){
            $data['align'] = 'left';
            $params = preg_replace('/\bleft\b/i','',$params);
        }
        if(preg_match('/\bcenter\b/i',$params)){
            $data['align'] = 'center';
            $params = preg_replace('/\bcenter\b/i','',$params);
        }
        if(preg_match('/\bright\b/i',$params)){
            $data['align'] = 'right';
            $params = preg_replace('/\bright\b/i','',$params);
        }

        $data['shuffle'] = false;
        if(preg_match('/\bshuffle\b/i',$params)){
            $data['shuffle'] = true;
            $params = preg_replace('/\bshuffle\b/i','',$params);
        }

        $data['repeat'] = false;
        if(preg_match('/\brepeat\b/i',$params)){
            $data['repeat'] = true;
            $params = preg_replace('/\brepeat\b/i','',$params);
        }

        $data['autoplay'] = false;
        if(preg_match('/\bautoplay\b/i',$params)){
            $data['autoplay'] = true;
            $params = preg_replace('/\bautoplay\b/i','',$params);
        }



        // the rest is the skin
        $data['skin'] = trim($params);

        list($data['skin'],$data['width'],$data['height']) = $this->_skininfo($data['skin']);

        return $data;
    }

    /**
     * Create output
     */
    function render($mode, &$R, $data) {
        if($mode != 'xhtml') return false;

        $att = array();
        $att['class'] = 'media'.$data['align'];
        if($data['align'] == 'right') $att['align'] = 'right';
        if($data['align'] == 'left')  $att['align'] = 'left';

        $params = array(
            'skin_url'     => DOKU_REL.'lib/plugins/jukebox/skins/'.$data['skin'].'/',
            'playlist_url' => DOKU_REL.'lib/plugins/jukebox/list.php?ns='.$data['ns'].'&t=',
            'mainurl'      => 'http://www.dokuwiki.org/plugin:jukebox',
            'infourl'      => 'http://www.dokuwiki.org/plugin:jukebox',
            'autoload'     => 'true',
            'findImage'    => 'true',
            'useId3'       => 'true'
        );
        if($data['shuffle']) $params['shuffle'] = 'true';
        if($data['autoplay']) $params['autoplay'] = 'true';
        if($data['repeat']) $params['repeat'] = 'true';

        $swf = DOKU_REL.'lib/plugins/jukebox/xspf_jukebox.swf';

        $R->doc .= html_flashobject($swf,$data['width'],$data['height'],null,$params,$att);
        return true;
    }

    function _skininfo($skin){
        $skin = strtolower($skin);
        $skin = preg_replace('/[^a-z]+/','',$skin);
        if(!$skin) $skin = 'original';
        if(@file_exists(dirname(__FILE__).'/skins/'.$skin.'/skin.xml')){
            $data = @file_get_contents(dirname(__FILE__).'/skins/'.$skin.'/skin.xml');
        }else{
            return array('original',400,170);
        }
        if(preg_match('/<width>(\d+)<\/width>/',$data,$match)){
            $width = $match[1];
        }else{
            $width = 400;
        }
        if(preg_match('/<height>(\d+)<\/height>/',$data,$match)){
            $height = $match[1];
        }else{
            $height = 170;
        }

        return array($skin,$width,$height);
    }

}

//Setup VIM: ex: et ts=4 enc=utf-8 :
