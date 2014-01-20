<?php
/*
Plugin Name: Flash MP3 Player JW2.3
Plugin URI: http://sexywp.com/flash-player-widget.htm
Description: This is a mp3 player made by flash. You can add this to your sidebar as a Widget, and you can edit the playlist through the options page. It's a very user friendly widget.
Version: 10.0.4
Author: Charles Tang
Author URI: http://sexywp.com/
*/
if ( !defined('WP_CONTENT_URL') )
	define( 'WP_CONTENT_URL', get_option('siteurl') . '/wp-content');
if ( !defined('WP_CONTENT_DIR') )
	define( 'WP_CONTENT_DIR', ABSPATH . 'wp-content' );

if ( !defined('WP_PLUGIN_URL') )
	define( 'WP_PLUGIN_URL', WP_CONTENT_URL . '/plugins' );
if ( !defined('WP_PLUGIN_DIR') )
	define( 'WP_PLUGIN_DIR', WP_CONTENT_DIR . '/plugins' );

$fmp_jw_dir = WP_PLUGIN_DIR . '/flash-mp3-player';
$fmp_jw_url = WP_PLUGIN_URL . '/flash-mp3-player';
$fmp_jw_files_dir = WP_CONTENT_DIR . '/fmp-jw-files';
$fmp_jw_files_url = WP_CONTENT_URL . '/fmp-jw-files';

require_once($fmp_jw_dir . '/inc/widget.php');
require_once($fmp_jw_dir . '/inc/class.utils.php');
require_once($fmp_jw_dir . '/inc/class.config_editor.php');
require_once($fmp_jw_dir . '/inc/class.playlist_editor.php');

function flash_mp3_player_init(){
    global $fmp_jw_dir, $fmp_jw_files_dir;
    global $fmp_jw_util;

    if (!file_exists($fmp_jw_files_dir)) if (!wp_mkdir_p($fmp_jw_files_dir . '/')) return;
    if (!file_exists($fmp_jw_files_dir . '/configs/')) if (!wp_mkdir_p($fmp_jw_files_dir . '/configs/')) return;
    if (!file_exists($fmp_jw_files_dir . '/playlists/')) if (!wp_mkdir_p($fmp_jw_files_dir . '/playlists/')) return;

    if (!file_exists($fmp_jw_files_dir . '/configs/fmp_jw_widget_config.xml')){
        if (!copy($fmp_jw_dir . '/player/configs/config.xml', $fmp_jw_files_dir . '/configs/fmp_jw_widget_config.xml'))
            return;
    }
    if (!file_exists($fmp_jw_files_dir . '/playlists/fmp_jw_widget_playlist.xml')){
        if (!copy($fmp_jw_dir . '/player/playlists/playlist.xml', $fmp_jw_files_dir . '/playlists/fmp_jw_widget_playlist.xml'))
            return;
    }

    $fmp_jw_util = new FMP_Utils();
    //register widget
    add_action('widgets_init', 'fmp_jw_widget_init');
    add_action('media_buttons', array(&$fmp_jw_util, 'add_media_button'), 30);
    add_shortcode('mp3player', array(&$fmp_jw_util, 'player_shortcode'));

    if(is_admin()){
        $fmp_config_editor = new FMP_Config_Editor();
        add_action('admin_menu', array(&$fmp_config_editor, 'add_menu_item'));
        $fmp_playlist_editor = new FMP_Playlist_Editor();
        add_action('admin_menu', array(&$fmp_playlist_editor, 'add_menu_item'));
    }
}
add_action('plugins_loaded', 'flash_mp3_player_init');
?>
