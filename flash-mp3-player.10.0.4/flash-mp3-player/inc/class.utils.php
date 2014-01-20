<?php
class FMP_Utils{
    function FMP_Utils(){}
    function print_player($args){
        $defaults = array(
            'player_url'        => '',
            'config_url'        => '',
            'playlist_url'      => '',
            'width'             => 230,
            'height'            => 350,
            'id'                => '',
            'class'             => '',
            'transparent'       => false,
            'autostart'         => false,
            'file'              => ''
        );
        $r = wp_parse_args($args, $defaults);
        extract($r,EXTR_SKIP);
        
        $flashvars = '';
        if(!empty($config_url))
            $flashvars .= 'config=' . $config_url . '?' . rand() . '&amp;';

        if(!empty($playlist_url))
            $flashvars .= 'file=' . $playlist_url . '?' . rand();
        else if(!empty($file))
            $flashvars .= 'file=' . $file;
        else
            return;

        if(!empty($autostart))
            $flashvars .= '&amp;autostart=' . $autostart;

        if ($id != '') $id = ' id="' . $id . '" ';
        if ($class != '') $class = ' class="' . $class . '" ';
        if ($transparent) $wmode = 'Transparent'; else $wmode = 'Window';

        $player_url .= '?' . $flashvars;
        ?>

<div<?php echo $id, $class;?>>
    <object classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000" width="<?php echo $width;?>" height="<?php echo $height;?>">
        <param name="movie" value="<?php echo $player_url;?>" />
    <!--[if !IE]>-->
    <object type="application/x-shockwave-flash" data="<?php echo $player_url;?>" width="<?php echo $width;?>" height="<?php echo $height;?>">
    <!--<![endif]-->
        <param name="wmode" value="<?php echo $wmode;?>"/>
        <param name="quality" value="high" />
        <param name="allowFullScreen" value="true" />
        <param name="allowScriptAccess" value="always" />
        <param name="flashvars" value="<?php echo $flashvars;?>" />
        <p>Here is the Music Player. You need to installl flash player to show this cool thing!</p>
    <!--[if !IE]>-->
    </object>
    <!--<![endif]-->
    </object>
</div>

        <?php
    }

    function player_shortcode($atts){
        global $fmp_jw_url, $fmp_jw_files_url;
    	extract(shortcode_atts(array(
            'width' => '177',
            'height' => '280',
            'config' => '',
            'playlist' => '',
            'file' => '',
            'id'    => '',
            'class' => ''
        ), $atts));
        $args = array(
            'player_url'        => $fmp_jw_url . '/player/player.swf',
            'config_url'        => $fmp_jw_files_url . '/configs/' . $config,
            'playlist_url'      => empty($playlist)?'':$fmp_jw_files_url . '/playlists/' . $playlist,
            'width'             => $width,
            'height'            => $height,
            'file'              => empty($file)?'':$file,
            'id'                => $id,
            'class'             => $class
        );
        ob_start();
        $this->print_player($args);
        $player = ob_get_contents();
        ob_end_clean();
        return $player;
    }

    function add_media_button(){
        global $fmp_jw_url, $fmp_jw_files_dir;
        $wizard_url = $fmp_jw_url . '/inc/shortcode_wizard.php';
        $config_dir = $fmp_jw_files_dir . '/configs';
        $playlist_dir = $fmp_jw_files_dir .'/playlists';
        $button_src = $fmp_jw_url . '/inc/images/playerbutton.gif';
        $button_tip = 'Insert a Flash MP3 Player';
        echo '<a title="Add a MP3 player" href="'.$wizard_url.'?config=' .urlencode($config_dir). '&playlist='.urlencode($playlist_dir).'&KeepThis=true&TB_iframe=true" class="thickbox" ><img src="' . $button_src . '" alt="' . $button_tip . '" /></a>';
    }
}
?>
