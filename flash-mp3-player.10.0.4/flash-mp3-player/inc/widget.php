<?php
/**
 * Flash Player Widget Init Function for WP under 2.8
 */
function fmp_jw_widget_init(){
    
    function fmp_jw_widget_body($args, $widget_args = 1){
        global $fmp_jw_url, $fmp_jw_files_url, $fmp_jw_files_dir, $fmp_jw_util;
        extract($args, EXTR_SKIP);
        if (is_numeric($widget_args))
            $widget_args = array('number' => $widget_args);
        $widget_args = wp_parse_args($widget_args, array('number' => -1));
        extract($widget_args, EXTR_SKIP);

        $options = get_option('fmp-jw-widget-options');

        if(!isset($options[$number]))
            return;
        $title = $options[$number]['title'];

        $tag_args = array(
            'player_url'        => $fmp_jw_url . '/player/player.swf',
            'config_url'        => $fmp_jw_files_url . '/configs/'. $options[$number]['config_url'],
            'playlist_url'      => $fmp_jw_files_url . '/playlists/'. $options[$number]['playlist_url'],
            'width'             => $options[$number]['width'],
            'height'            => $options[$number]['height'],
            'id'                => $options[$number]['container_id'],
            'class'             => $options[$number]['container_class'],
            'transparent'       => false
        );

        echo $before_widget, $before_title, $title, $after_title;
        $fmp_jw_util->print_player($tag_args);
        echo $after_widget;
    }

    function fmp_jw_widget_control($widget_args){
        global $fmp_jw_url, $fmp_jw_files_url, $fmp_jw_files_dir, $fmp_jw_util;
        global $wp_registered_widgets;

        $config_files = array();
        $playlist_files = array();
        $temp = array();
        $temp = scandir($fmp_jw_files_dir . '/configs');
        foreach($temp as $name){
            if(strpos($name, '.xml') !== false)
                $config_files[] = $name;
        }
        $temp = array();
        $temp = scandir($fmp_jw_files_dir . '/playlists');
        foreach($temp as $name){
            if(strpos($name, '.xml') !== false)
                $playlist_files[] = $name;
        }
        unset($temp,$name);

        static $update = false;
        if(is_numeric($widget_args))
            $widget_args = array('number' => $widget_args);

        $widget_args = wp_parse_args($widget_args, array('number' => -1));

        extract($widget_args, EXTR_SKIP);

        $options = get_option('fmp-jw-widget-options');

        if(!is_array($options))
            $options = array();

        if(!$update && !empty($_POST['sidebar'])){
            $sidebar = (string) $_POST['sidebar'];
            $sidebars_widgets = wp_get_sidebars_widgets();
            if(isset($sidebars_widgets[$sidebar])){
                $this_sidebar =& $sidebars_widgets[$sidebar];
            }else{
                $this_sidebar = array();
            }
            foreach ($this_sidebar as $_widget_id){
                if ('fmp_jw_widget_body' == $wp_registered_widgets[$_widget_id]['callback'] && isset($wp_registered_widgets[$_widget_id]['params'][0]['number'])){
                    $widget_number = $wp_registered_widgets[$_widget_id]['params'][0]['number'];
                    if (!in_array("fmp-jw-widget-$widget_number",$_POST['widget-id'])){
                        unset($options[$widget_number]);
                    }
                }
            }

            foreach((array)$_POST['fmp-jw-widget'] as $widget_number => $posted){
                $options_this['title'] = strip_tags(stripslashes($posted['title']));
                $options_this['config_url'] = stripslashes($posted['config_url']);
                $options_this['playlist_url'] = stripslashes($posted['playlist_url']);
                $options_this['width'] = intval($posted['width']);
                $options_this['height'] = intval($posted['height']);
                $options_this['container_id'] = stripslashes($posted['container_id']);
                $options_this['container_class'] = stripslashes($posted['container_class']);
                $options[$widget_number] = $options_this;
            }
            update_option('fmp-jw-widget-options',$options);
            $update = true;
        }
        if ($number == -1){
            $title = 'Flash MP3 Player JW';
            $width = 177;
            $height = 280;
            $config_url = 'fmp_jw_widget_config.xml';
            $playlist_url = 'fmp_jw_widget_playlist.xml';
            $container_id = '';
            $container_class = '';
            $number = '%i%';
        }else{
            $title = attribute_escape($options[$number]['title']);
            $width = $options[$number]['width'];
            $height = $options[$number]['height'];
            $config_url = attribute_escape($options[$number]['config_url']);
            $playlist_url = attribute_escape($options[$number]['playlist_url']);
            $container_id = $options[$number]['container_id'];
            $container_class = $options[$number]['container_class'];
        }
        if (count($config_files) > 0 && !in_array($config_url, $config_files))
            $config_url = $config_files[0];
        if (count($playlist_files) > 0 && !in_array($playlist_url, $playlist_files))
            $playlist_url = $playlist_files[0];

        $admin_url = get_option('siteurl') . '/wp-admin';
        ?>

        <p>
            <label for="fmp-jw-widget-title-<?php echo $number;?>">
                Title:<input id="fmp-jw-widget-title-<?php echo $number;?>" name="fmp-jw-widget[<?php echo $number;?>][title]" type="text" value="<?php echo $title;?>" class="widefat" />
            </label>
        </p>
        <p>
            <label for="fmp-jw-widget-width-<?php echo $number;?>">
                Width:<input id="fmp-jw-widget-width-<?php echo $number;?>" name="fmp-jw-widget[<?php echo $number;?>][width]" type="text" value="<?php echo $width;?>" class="widefat" />
                <br/><small>Just input the number, the unit is pixel.</small>
            </label>
        </p>
        <p>
            <label for="fmp-jw-widget-height-<?php echo $number;?>">
                Height:<input id="fmp-jw-widget-height-<?php echo $number;?>" name="fmp-jw-widget[<?php echo $number;?>][height]" type="text" value="<?php echo $height;?>" class="widefat" />
                <br/><small>Just input the number, the unit is pixel.</small>
            </label>
        </p>
        <p>
            <label for="fmp-jw-widget-config-<?php echo $number;?>">
                Choose a config file:
                <select id="fmp-jw-widget-config-<?php echo $number;?>" name="fmp-jw-widget[<?php echo $number;?>][config_url]" >
                    <?php foreach($config_files as $config_file) :?>
                    <option value="<?php echo $config_file;?>" <?php if($config_file == $config_url) echo ' selected="selected" ';?>><?php echo $config_file;?></option>
                    <?php endforeach;?>
                </select>
                <br/><small>You can CREATE or EDIT a config file <a href="<?php echo $admin_url;?>/options-general.php?page=fmp_config_editor">here</a>.</small>
            </label>
        </p>
        <p>
            <label for="fmp-jw-widget-playlist-<?php echo $number;?>">
                Choose a playlist:
                <select id="fmp-jw-widget-playlist-<?php echo $number;?>" name="fmp-jw-widget[<?php echo $number;?>][playlist_url]" >
                    <?php foreach($playlist_files as $playlist_file) :?>
                    <option value="<?php echo $playlist_file;?>" <?php if($playlist_file == $playlist_url) echo ' selected="selected" ';?>><?php echo $playlist_file;?></option>
                    <?php endforeach;?>
                </select>
                <br/><small>You can CREATE or EDIT a playlist <a href="<?php echo $admin_url;?>/options-general.php?page=fmp_playlist_editor">here</a>.</small>
            </label>
        </p>
        <p>
            <label for="fmp-jw-widget-id-<?php echo $number;?>">
                Container <code>id</code>:<input id="fmp-jw-widget-id-<?php echo $number;?>" name="fmp-jw-widget[<?php echo $number;?>][container_id]" type="text" value="<?php echo $container_id;?>" class="widefat" />
            </label>
        </p>
        <p>
            <label for="fmp-jw-widget-class-<?php echo $number;?>">
                Container <code>class</code>:<input type="text" id="fmp-jw-widget-class-<?php echo $number;?>" name="fmp-jw-widget[<?php echo $number;?>][container_class]" value="<?php echo $container_class?>"  class="widefat" />
            </label>
        </p>
        <input id="fmp-jw-widget-submit-<?php echo $number;?>" name="fmp-jw-widget-submit-<?php echo $number;?>" type="hidden" value="1"/>
        <?php
    }

    $options = get_option('fmp-jw-widget-options');
    if (!$options){
        $options = array();
    }
    $widget_ops =  array(
        'classname'     => 'fmp-jw-widget',
        'description'   => 'Print a graceful mp3 player on your sidebar.'
    );
    $control_ops = array(
       // 'width'     => 400,
       // 'height'    => 200,
        'id_base'   => 'fmp-jw-widget'
    );

    $name   = 'Flash MP3 Player JW';
    $widget_cb  = 'fmp_jw_widget_body';
    $control_cb = 'fmp_jw_widget_control';
	// Register Widgets
    $registerd = false;
    foreach(array_keys($options) as $o){
        if(!isset($options[$o]['title'])){
            continue;
        }
        $id = "fmp-jw-widget-$o";
        $registerd = true;
        wp_register_sidebar_widget($id, $name, $widget_cb, $widget_ops, array('number'=>$o));
        wp_register_widget_control($id, $name, $control_cb, $control_ops, array('number'=>$o));
    }
	if(!$registered){
        wp_register_sidebar_widget("fmp-jw-widget-1", $name, $widget_cb, $widget_ops, array('number'=>-1));
        wp_register_widget_control("fmp-jw-widget-1", $name, $control_cb, $control_ops, array('number'=>-1));
    }
}



?>
