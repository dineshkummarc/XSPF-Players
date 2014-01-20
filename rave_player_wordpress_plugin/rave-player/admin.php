<?php
/*
Plugin Name: Rave Player
Version: v1.0.14
Plugin URI: http://www.wimpyplayer.com
Author: Mike Gieson
Author URI: http://www.wimpyplayer.com/
Description: A highly customizable and skinable media player, which displays and plays collections of audio and/or video. Perfect for musicians, bands and anyone that needs to control the look and feel of their player to fit with their site design. Rave also offers custom playlist creation and editing, or you can manage what appears in the player by directing Rave to a folder full of media files on your site. 
*/

/*
    This program is free software; you can redistribute it
    under the terms of the GNU General Public License version 2,
    as published by the Free Software Foundation.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.
*/

///////////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////
//                                                      ///////
//          Rave Player Plugin for Wordpress            ///////
//                   Version 1.0.14                     ///////
//                                                      ///////
//        Available at http://www.wimpyplayer.com       ///////
//            Copyright 2002-2012 Plaino LLC            ///////
//                                                      ///////
///////////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////
//                                                      ///////
//                USE AT YOUR OWN RISK                  ///////
//                                                      ///////
///////////////////////////////////////////////////////////////


define('WIMPY_DB_TABLE_NAME', 'wimpy_rave');

$RavePlugin = new WimpyRave();
$RavePlugin->init();



class WimpyRave {

	var $CONF;


	/***********************************************************************************************************


																										INIT


	***********************************************************************************************************/


	function __construct(){


		$this->init();


	}
	
	function init(){
		$slash = "/";
		if(!stristr (__FILE__, "/")){
			$slash = "\\";
		}

		$this->CONF = array();

		/**************************
		
		NOTE:	- playlist_url_id
				- transient_prefix 
				These must be at the top!!!

		**************************/

		// Used to retrieve playlist
		// e.g. http;//www/path/to/wordpress/?wimpyraveplaylist
		$this->CONF['playlist_url_id']		= "wimpyraveplaylist";

		// Transient Prefix
		// Used to avoid collitions.
		$this->CONF['transient_prefix']		= "wimpy_rave_data_";


		$this->CONF['js_startup_data'] = array(	"plugin_version", 
											"swf_filename", 
											"fallback_player_name",
											"fallback_plist_name",
											"prefix_unique", 
											"playlist_url_id", 
											"path_url_plugin_folder", 
											"path_url_wp_folder",
											'player_list_data',
											'playlist_list_data',
											'default_player',
											'reg_code'
											);



		$this->CONF['slash']				= $slash;
		$this->CONF['newline']				= "\n";
		$this->CONF['plugin_version']		= "1.0.14";
		$this->CONF['flashversion']			= "8.0.0.0";
		$this->CONF['swf_filename']			= "rave.swf";
		$this->CONF['fallback_player_name']	= "default";
		$this->CONF['fallback_plist_name']	= "auto";
		$this->CONF['reg_code']				= $this->getRegCode();






		// URLs
		

		$AthisPluginFolderName = explode($slash, dirname(__FILE__));
		$thisPluginFolderName = array_pop($AthisPluginFolderName);

		$this->CONF['path_url_plugin_folder']	= plugins_url("", __FILE__) . "/";
		$this->CONF['path_url_wp_folder']		= site_url() . "/";

		// System Paths
		$this->CONF['path_sys_plugin_folder']	= dirname(__FILE__) . $slash;
		array_pop($AthisPluginFolderName);
		array_pop($AthisPluginFolderName);
		$this->CONF['path_sys_wp_folder']		= implode($slash, $AthisPluginFolderName) . $slash;

		// Used during startup (which is set at the bottom of respective pages.
		// NOTE: default_player must be ABOVE the getPlay* functions so that they can be populated properly.
		$this->CONF['default_player']		= $this->getDefaultPlayer();;
		$this->CONF['player_list_data']		= $this->getPlayerListInfo();
		$this->CONF['playlist_list_data']		= $this->getPlaylistListInfo();


		/*
		http://codex.wordpress.org/Function_Reference/home_url
		home_url() 	Home URL 	http://www.example.com
		site_url() 	Site directory URL 	http://www.example.com OR http://www.example.com/wordpress
		admin_url() 	Admin directory URL 	http://www.example.com/wp-admin/
		includes_url() 	Includes directory URL 	http://www.example.com/wp-includes/
		content_url() 	Content directory URL 	http://www.example.com/wp-content/
		plugins_url() 	Plugins directory URL 	http://www.example.com/wp-content/plugins/
		*/



		$this->CONF['defaultPlayerOptions'] = array();

		$this->CONF['defaultPlayerOptions']['playerID']			= "player1";
		$this->CONF['defaultPlayerOptions']['wimpySkin']		= $this->CONF['path_url_plugin_folder']."skins/itunes7/skin_itunes7.xml";
		
			// PLAYLIST
		$this->CONF['defaultPlayerOptions']['playlistType']			= "wp_auto";
		$this->CONF['defaultPlayerOptions']['playlist_wp_auto']		= "auto";
		$this->CONF['defaultPlayerOptions']['playlist_wp_plist']	= "";
		$this->CONF['defaultPlayerOptions']['playlist_url']			= "";
		$this->CONF['defaultPlayerOptions']['playlist_file']		= "";
		$this->CONF['defaultPlayerOptions']['wimpyApp']				= "";
		$this->CONF['defaultPlayerOptions']['playlist']				= "";

		// APPEARENCE
		$this->CONF['defaultPlayerOptions']['set_size']				= "auto";
		$this->CONF['defaultPlayerOptions']['wimpyWidth']			= "277";
		$this->CONF['defaultPlayerOptions']['wimpyHeight']			= "284";
		$this->CONF['defaultPlayerOptions']['bkgdColor']			= "#F8F8F8";
		$this->CONF['defaultPlayerOptions']['tptBkgd']				= "";
	
		// OPTIONS
		$this->CONF['defaultPlayerOptions']['theVolume']			= "100";
		$this->CONF['defaultPlayerOptions']['loopTrack']			= "";
		$this->CONF['defaultPlayerOptions']['randomPlayback']		= "";
		$this->CONF['defaultPlayerOptions']['repeatPlaylist']		= "";
		$this->CONF['defaultPlayerOptions']['randomOnLoad']			= "";
		$this->CONF['defaultPlayerOptions']['startPlayingOnload']	= "";
		$this->CONF['defaultPlayerOptions']['autoAdvance']			= "yes";
		$this->CONF['defaultPlayerOptions']['popUpHelp']			= "yes";
		$this->CONF['defaultPlayerOptions']['bufferSeconds']		= "10";
		$this->CONF['defaultPlayerOptions']['enableDownloads']		= "";
		$this->CONF['defaultPlayerOptions']['infoDisplaySpeed']		= "3";
		$this->CONF['defaultPlayerOptions']['scrollFormat']			= "";
		$this->CONF['defaultPlayerOptions']['timeFormat']			= "";
	
		$this->CONF['defaultPlayerOptions']['sortField']			= "title";
		$this->CONF['defaultPlayerOptions']['sortOrder']			= "asc";
		
		$this->CONF['defaultPlayerOptions']['fsMode']				= "";
		$this->CONF['defaultPlayerOptions']['setAspectRatio']		= "maintain";

		$this->CONF['defaultPlayerOptions']['infoButtonAction']		= "link";
		$this->CONF['defaultPlayerOptions']['clickWindowAction']	= "playPause";
		$this->CONF['defaultPlayerOptions']['linkToWindow']			= "_blank";

		$this->CONF['defaultPlayerOptions']['use_onTrackComplete']	= "";
		$this->CONF['defaultPlayerOptions']['onTrackComplete']		= "";
		$this->CONF['defaultPlayerOptions']['onTrackCompleteURL']	= "";

		$this->CONF['defaultPlayerOptions']['use_plugPlaylist']		= "";
		$this->CONF['defaultPlayerOptions']['plugPlaylist']			= "";
		$this->CONF['defaultPlayerOptions']['plugEvery']			= "";

		$this->CONF['defaultPlayerOptions']['use_startOnTrack']		= "";
		$this->CONF['defaultPlayerOptions']['startOnTrack']			= "4";
		
		$this->CONF['defaultPlayerOptions']['use_startupLogo']		= "";
		$this->CONF['defaultPlayerOptions']['startupLogo']			= "";

		$this->CONF['defaultPlayerOptions']['use_defaultImage']		= "";
		$this->CONF['defaultPlayerOptions']['defaultImage']			= "";

		$this->CONF['defaultPlayerOptions']['use_videoOverlay']		= "";
		$this->CONF['defaultPlayerOptions']['videoOverlay']			= "";

		$this->CONF['defaultPlayerOptions']['use_limitPlaytime']	= "";
		$this->CONF['defaultPlayerOptions']['limitPlaytime']		= "";

		$this->CONF['defaultPlayerOptions']['use_resume']			= "";
		$this->CONF['defaultPlayerOptions']['resume']				= "";


		
		
		if ( false == ( $this->checkForWimpyAppRequest() )		) {
			
			add_shortcode( 'rave', array(&$this, 'wimpy_parse_sc'));

			if (is_admin()) {
				add_action('wp_ajax_RAVE_AJAX', array(&$this, 'ajax_callback'));
				add_action( 'admin_init', array(&$this, 'init_admin_init'));
				add_action( 'admin_menu', array(&$this, 'init_admin_menu'));

				register_activation_hook(__FILE__, array (&$this,'create_table'));
				register_deactivation_hook(__FILE__, array (&$this,'drop_table'));
			} else {
				//add_action('user_init', 'init_user_init');
				//add_action( 'user_init', array(&$this, 'init_user_init'));
				add_action('wp_enqueue_scripts', array(&$this, 'init_user_init'));
			}

		}	
	}
	

	function getVersionInfo() {

		$retval = array();
		$retval['me'] = $this->CONF['plugin_version'];
		$retval['latest'] = @file_get_contents('http://www.wimpyplayer.com/version_info_rave_wordpress.php');

		if ($retval['latest'] === false) {
		   $retval['latest'] = $retval['me'];
		}

		/*
		version_compare:
		-1	if 1st < 2nd
		0	if 1st == 2nd
		1	if 1st > 2nd
		*/

		$printRaveVersionUpdateText = "";

		if(@version_compare($retval['me'], $retval['latest']) == -1){
			$retval['status'] = 'A newer version of this plugin is available. <a href="http://www.wimpyplayer.com/products/wimpy_rave_wordpress_plugin.html" target=_blank">Click here for more info.</a>';
		} else {
			$retval['status'] = "Plugin is up to date.";
		}
		return $retval;
	}

	function init_admin_init() {
		
		//wp_register_script ( $handle, $src, $deps = array(), $ver = false, $in_footer = false )

		$pluginPath = $this->CONF['path_url_plugin_folder'];
		
		// STYLESHEETS
		wp_register_style( 'wimpy_rave_stylesheet',			$pluginPath . 'admin.css'			);

		// SCRIPTS
		wp_register_script('wimpy_rave_script_ajax_hook',	$pluginPath . 'admin.js'			);
		wp_register_script('wimpy_rave_script_colorpicker', $pluginPath . 'wimpy-colorpicker.js');
		wp_register_script('wimpy_rave_script_dragsort',	$pluginPath . 'jquery.dragsort.js'	);
		//wp_register_script('wimpy_rave_script_ravemain',	$pluginPath . 'rave.js'	);
		
		// Same as in init_user_init() below (Don't know why we just can't call it?)
		wp_deregister_script( 'wp_rave_js_loader' );
	    wp_register_script( 'wp_rave_js_loader', $pluginPath . 'rave.js');
	    wp_enqueue_script( 'wp_rave_js_loader' );

	}
	
	
	function init_user_init(){
		$pluginPath = $this->CONF['path_url_plugin_folder'];
		
		wp_deregister_script( 'wp_rave_js_loader' );
	    wp_register_script( 'wp_rave_js_loader', $pluginPath . 'rave.js');
	    wp_enqueue_script( 'wp_rave_js_loader' );
	
	}
	
	/*
	function init_user_init() {
		
		//wp_register_script ( $handle, $src, $deps = array(), $ver = false, $in_footer = false )

		$pluginPath = $this->CONF['path_url_plugin_folder'];
		
		wp_deregister_script( 'wimpy_rave_main_script' );
	    wp_register_script( 'wimpy_rave_main_script', 'http://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js');
	    wp_enqueue_script( 'wimpy_rave_main_script' );

	}
	*/
	


	function wimpy_rave_admin_styles(){
		// STYLESHEETS
		wp_enqueue_style ('wimpy_rave_stylesheet');
		// SCRIPTS
		wp_enqueue_script ('wimpy_rave_script_ajax_hook');
		wp_enqueue_script ('wimpy_rave_script_colorpicker');
	}

	function wimpy_rave_admin_styles_playlist(){
		// STYLESHEETS
		wp_enqueue_style ('wimpy_rave_stylesheet');
		// SCRIPTS
		wp_enqueue_script ('wimpy_rave_script_ajax_hook');
		wp_enqueue_script ('wimpy_rave_script_dragsort');
	}

	function init_admin_menu() {

		//  add_menu_page( $page_title,	$menu_title, $capability, $menu_slug, $function, $icon_url, $position );
		
		// MAIN MENU
		$me = __FILE__;
		
		$page_home		= add_menu_page('Rave Player - Getting Started',	'Rave Player',	'administrator',	$me,						array(&$this, 'wimpy_choose_renderer' ) );
		$page_player	= add_submenu_page( $me, 'Rave Player - Players',	'Players',		'manage_options',	'rave_player_players',		array(&$this, 'wimpy_choose_renderer' )	);
		$page_playlist	= add_submenu_page( $me, 'Rave Player - Playlists',	'Playlists',	'manage_options',	'rave_player_playlists',	array(&$this, 'wimpy_choose_renderer' )	);
		$page_register	= add_submenu_page( $me, 'Rave Player - Register',	'Register',		'manage_options',	'rave_player_register',		array(&$this, 'wimpy_choose_renderer' )	);
		//$page_help		= add_submenu_page( $me, 'Rave Player - Help',		'Help',			'manage_options',	'rave_player_help',			array(&$this, 'wimpy_choose_renderer' )	);


		// Page specific head content (styles and scripts).

		add_action('admin_print_styles-' . $page_home,		array(&$this, 'wimpy_rave_admin_styles')			);
		add_action('admin_print_styles-' . $page_player,	array(&$this, 'wimpy_rave_admin_styles')			);
		add_action('admin_print_styles-' . $page_playlist,	array(&$this, 'wimpy_rave_admin_styles_playlist')	);
		add_action('admin_print_styles-' . $page_register,	array(&$this, 'wimpy_rave_admin_styles')			);

		//add_action('admin_print_styles-' . $page_help,		array(&$this, 'wimpy_rave_admin_styles')			);


	}

	function wimpy_choose_renderer(){

		/*
		print "<b>path_url_plugin_folder:</b> "	. $this->CONF['path_url_plugin_folder']	. '<br>';
		print "<b>path_url_wp_folder:</b> "		. $this->CONF['path_url_wp_folder']		. '<br>';

		print "<b>path_sys_plugin_folder:</b> "	. $this->CONF['path_sys_plugin_folder']		. '<br>';
		print "<b>path_sys_wp_folder:</b> "		. $this->CONF['path_sys_wp_folder']		. '<br>';
	
		print "<pre>";
		print_r($GLOBALS['menu']);
		print "</pre>";
		*/

		$qs = $this->getQueryString();
		$page = $qs['page'];

		if($page == 'rave_player_players'){
			require_once("raveplayer_customizer.php");
		
		} else if($page == 'rave_player_playlists'){
			require_once("raveplayer_playlister.php");
			
		} else if($page == 'rave_player_register'){
			require_once("raveplayer_register.php");
			
		} else if($page == 'rave_player_help'){
			
		} else {
			require_once("raveplayer_about.php");
		}

	}

	/***********************************************************************************************************


																									GET PLAYLIST


	***********************************************************************************************************/
	// http://gieson.com/press/?wimpyraveplaylist=playlist3
	function checkForWimpyAppRequest(){
		if (isset($_GET[$this->CONF['playlist_url_id']])) {
			
			$pl_id = $_GET[$this->CONF['playlist_url_id']];
			
			header("Pragma: public", false);
			header("Expires: Thu, 19 Nov 1981 08:52:00 GMT", false);
			header("Cache-Control: must-revalidate, post-check=0, pre-check=0", false);
			header("Cache-Control: no-store, no-cache, must-revalidate", false);
			header("Content-Type: text/xml");


			print_r ($this->getPlaylist($pl_id));
			
			//exit();
			die();

		} else {
			return false;
		}
	}


	/***********************************************************************************************************


																									SHORT CODE

	EXAMPLE:
	[rave 
		player:myPlayer1 
		playlist:myplaylist1 
		files:http://www/path/to/file.mp3 
		playlist_url:http://www/path/to/file.xml
	]
	***********************************************************************************************************/

	function wimpy_parse_sc( $atts ) {
		
		extract( shortcode_atts( array(
			'player' => false,
			'playlist' => false,
			'files' => false,
			'playlist_url' => false
		), $atts ) );

		$player = "{$player}";
		$playlist = "{$playlist}";
		
		if($player && !$playlist){
			$plid = $player;
			$data = $this->getPlayerData($player);
		} else if(!$player && ($playlist || $files || $playlist_url)){
			$data = $this->getPlayerData();
			// playlistType: "wp_auto","wp_plist","url","file");
			if($playlist){
				$data['playlistType'] = "wp_plist";
				$data['wimpyApp'] = $playlist;
				$data['playlist'] = "";
			} else if($files){
				$data['playlistType'] = "file";
				$data['wimpyApp'] = "";
				$data['playlist'] = $files;
			} else if($playlist_url){
				$data['playlistType'] = "url";
				$data['wimpyApp'] = $playlist_url;
				$data['playlist'] = "";
			}
			
		} else {
			$data = $this->getPlayerData();
			$plid = $data['playerID'];
		}
		
		
		return $this->makeWimpyPlayer($plid, $data);

		
		
		
	}



	/***********************************************************************************************************


																									AJAX HOOK


	***********************************************************************************************************/

	function conf_to_js(){

		$Aret = array();
		for($i=0; $i<sizeof($this->CONF['js_startup_data']); $i++) {
			$key = $this->CONF['js_startup_data'][$i];
			$Aret[$key] = $this->CONF[$key];
		}
		$foo = "";
		return rawurldecode($this->arrayPHPtoJS($Aret, "RAVE_CONF", $foo));
	}

	function ajax_callback() {

		/*****************
		
		PLAYLIST

		*****************/
		if($_POST['wimpy_action'] == "load_media_files"){
			$foo = "";
			echo $this->arrayPHPtoJS($this->getMediaArray(), "RAVE_MEDIA_FILES_SOURCE", $foo); 

		} else if($_POST['wimpy_action'] == "save_playlist"){
			$retval = $this->addPlaylist($_POST['playlist_name'], $_POST['playlist_data']);
			echo $this->getPlaylistListInfo();
		
		
		} else if($_POST['wimpy_action'] == "get_playlist_list_info"){
			echo $this->getPlaylistListInfo();
		

		} else if($_POST['wimpy_action'] == "delete_playlist"){
			$retval = $this->deletePlaylist($_POST['playlist_name']);
			echo $retval;
		

		} else if($_POST['wimpy_action'] == "get_playlist"){
			$temp = $this->db_get_pl("plist", $_POST['playlist_name']);
			echo $temp['config'];
		
		/*****************
		
		PLAYERS

		******************/
		} else if($_POST['wimpy_action'] == "save_player"){
			$retval = $this->savePlayer($_POST['player_name'], $_POST['player_data']);
			echo $this->getPlayerListInfo();
		
		
		} else if($_POST['wimpy_action'] == "get_player_list_info"){
			echo $this->getPlayerListInfo();
		

		} else if($_POST['wimpy_action'] == "delete_player"){
			$retval = $this->deletePlayer($_POST['player_name']);
			echo $retval;
		

		} else if($_POST['wimpy_action'] == "set_default_player"){
			$this->setDefaultPlayer($_POST['player_name']);
			$theName = $_POST['player_name'];
			$list = $this->db_get_pl_list("player");
			echo ($theName . "^" . implode("|", $list));
		

		} else if($_POST['wimpy_action'] == "get_player"){
			$data = $this->db_get_pl("player", $_POST['player_name']);
			$retval = $data['config'];
			echo $retval;

		/*****************
		
		SKIN

		******************/
		} else if($_POST['wimpy_action'] == "get_skin_list"){
			$foo = "";
			$retval = $this->arrayPHPtoJS($this->getSkinList(), "RAVE_SKIN_LIST", $foo);
			echo $retval;


		/*****************
		
		REGISTRATION

		******************/
		} else if($_POST['wimpy_action'] == "get_reg_code"){
			$retval = $this->getRegCode();
			echo $retval;

		} else if($_POST['wimpy_action'] == "set_reg_code"){
			$retval = $this->setRegCode($_POST['data']);
			echo $retval;

		} else {

			return "hello";
		}


		

		// this is required to return a proper result
		die();
	}

	function getRegCode(){
		return $this->getWimpyTransient("reg_code");
	}

	function setRegCode($theData){
		$this->setWimpyTransient("reg_code", $theData);
		return "ok";
	}

	/***********************************************************************************************************


																									DATABASE


	***********************************************************************************************************/


	function create_table() {
		global $wpdb;
		$table_name = $wpdb->prefix.WIMPY_DB_TABLE_NAME;
		if ($wpdb->get_var("show tables like '$table_name'") != $table_name) {
			$sql = "CREATE TABLE ".$table_name." (
				id mediumint(9) NOT NULL AUTO_INCREMENT,
				kind text NOT NULL,
				plid text NOT NULL,
				config text,
				html text,
				label text,
				UNIQUE KEY id (id)
				);";
			require_once ($this->CONF['path_sys_wp_folder'].'wp-admin'.$this->CONF['slash'].'includes'.$this->CONF['slash'].'upgrade.php');
			dbDelta($sql);        
		}
		$defid = $this->CONF['defaultPlayerOptions']['playerID'];
		$foo = $this->savePlayer($defid, $this->CONF['defaultPlayerOptions']);
		$foo = $this->setDefaultPlayer($defid);
	}

	function drop_table($plugin) {
		//global $wpdb;
		//$wpdb->query("DROP TABLE " . $wpdb->prefix . WIMPY_DB_TABLE_NAME);
	}

	function store_pl($data){
		global $wpdb;

		$exists = $wpdb->get_results("SELECT plid FROM " . $wpdb->prefix . WIMPY_DB_TABLE_NAME. " WHERE kind = '" . $data['kind'] . "' AND plid = '".$data['plid']."'");

		// UPDATE
		if($exists){

			$where	= array();
			$where['kind'] = $data['kind'];
			$where['plid'] = $data['plid'];

			$wpdb->update( $wpdb->prefix.WIMPY_DB_TABLE_NAME, $data, $where );

		// INSERT
		} else {

			$wpdb->insert($wpdb->prefix . WIMPY_DB_TABLE_NAME, $data);
		}

	}

	function db_delete_pl($kind, $id){
		global $wpdb;

		return $wpdb->query("DELETE FROM " . $wpdb->prefix . WIMPY_DB_TABLE_NAME . " WHERE kind = '" . $kind . "' AND plid = '" . $id . "'");

		//return $wpdb->get_results("DELETE ".$sel." FROM " . $wpdb->prefix . WIMPY_DB_TABLE_NAME . " WHERE kind = '" . $theKind . "'");
	}

	function db_get_pl($theKind, $theID){
		global $wpdb;
		$Alist = $wpdb->get_results("SELECT * FROM " . $wpdb->prefix . WIMPY_DB_TABLE_NAME . " WHERE kind = '" . $theKind . "' AND plid='" . $theID . "'", ARRAY_A);
		return $Alist[0];

	}


	function db_get_pl_list($theKind){
		global $wpdb;
		$Alist = $wpdb->get_results("SELECT plid FROM " . $wpdb->prefix . WIMPY_DB_TABLE_NAME . " WHERE kind = '" . $theKind . "'", ARRAY_N);
		$Aret = array();
		for($i=0;$i<sizeof($Alist);$i++){
			$Aret[] = $Alist[$i][0];
		}
		return $Aret;

	}

	



	/***********************************************************************************************************


																									TRANSIENTS


	***********************************************************************************************************/


	function WimpyDeleteData($theID){
		delete_transient( $theID );
		return true;
	}

	function setWimpyTransient($theName, $theData){
		// 1 year = 31556926 seconds
		set_transient( $this->CONF['transient_prefix'].$theName, $theData, 315569260 );
	}

	function getWimpyTransient($theName){
		if ( false === ( $thedata = get_transient( $this->CONF['transient_prefix'].$theName) ) ) {
			// this code runs when there is no valid transient set
			return false;
		}
		return $thedata;
	}

	function setDefaultPlayer($theID){
		$this->CONF['default_player'] = $theID;
		$this->setWimpyTransient("default_player", $theID);
	}

	function getDefaultPlayer(){
		return $this->getWimpyTransient("default_player");
	}




	/***********************************************************************************************************


																										PLAYLIST


	***********************************************************************************************************/

	function getPlaylist($theID, $theKind="av"){

		$retval = "";

		if($theID == "auto" || $theID == "audio" || $theID == "video"){
			
			if($theID == "audio"){
				$theKind = "a";
			} else if($theID == "video"){
				$theKind = "v";
			} else {
				$theKind = "av";
			}

			$mediaFiles = $this->getMediaArray($theKind);

		} else {
			$temp = $this->db_get_pl("plist", $theID);
			$list = $temp['config'];

			// Create array from list
			$Alist = explode("|", $list);

			// Returned list is not in the proper order. 
			// getMediaArray simply runs down the list of existing files and if "in_array" 
			// pushes them into the returning list.... so the order is not in accordance 
			// with the user's defined order.
			$rawList = $this->getMediaArray('av', $Alist);

			$mediaFiles = array();
			
			for($i=0; $i<sizeof($Alist); $i++){
				$val = $Alist[$i];

				for($k=0; $k<sizeof($rawList); $k++){
					if($val == $rawList[$k]['id']){
						$mediaFiles[] = $rawList[$k];
					}
				}

			}

			//$mediaFiles = $this->getMediaArray('av', $Alist);

		}

		$retval .= "<playlist>";
		foreach ( $mediaFiles as $key => $val) {
			$retval .= "<item>";
			/*
			[post_content] => My Description
			[post_title] => My Song
			[post_excerpt] => My Caption
			[guid] => http://localhost/cargoville/wp-content/uploads/2011/05/example2.mp3
			[post_modified] => 2011-05-01 02:02:35
			[post_parent] => 39 //e.g. wpordpress-url/?page=39
			*/
			$retval .= "<id>".$val['id']."</id>";
			
			if(substr($val['description'], 0, 4) == "http"){
				$retval .= "<link>".$val['description']."</link>";
			} else {
				$retval .= "<description>".$val['description']."</description>";
			}	
			$retval .= "<description>".$val['description']."</description>";
			$retval .= "<artist>".$val['artist']."</artist>";
			$retval .= "<title>".$val['title']."</title>";
			$retval .= "<filename>".$val['filename']."</filename>";
			$retval .= "<image>".$val['image']."</image>";
			$retval .= "<date>".date("U", strtotime(rawurldecode($val['date'])))."</date>";
			$retval .= "</item>";
		}

		$retval .= "</playlist>";
			


		return rawurldecode($retval);
	}

	// same as function preparePlaylist() in customizer.js
	function preparePlaylist($theString){
		if(substr($theString, 0, 9) == "<playlist"){
			return $theString;
		} else {
			$AasString = implode('__n__', explode("\r\n", $theString));
			$asString = implode('__n__', explode("\n", $AasString));
			$BasString = explode("__n__", $asString);
			$Alines = array();

			foreach ($BasString as $prop) {
				
				$theLine = preg_replace("{[\t\r\n]+}","",$prop);
				if ($theLine != '') {
					$Alines[] = $theLine;
				}
			}
			return (implode('|', $Alines));
		}
	}

	function cleanSpecials($theString){
		if(!$this->isNull($theString)){
			$retval = $theString;
			$retval = str_replace(" ", "%20", $retval);
			$retval = str_replace("'", "%27", $retval);
			$retval = str_replace("\\", "", $retval);
			$retval = str_replace("-", "%2D", $retval);
			$retval = str_replace("&", "%26", $retval);
			return $retval;
		} else {
			return "";
		}
	}



	function getMediaArray($theKind="av", $playlist=false){
		
		$printKind = 'audio,video';

		if($theKind == "a"){
			$printKind = 'audio';
		} else if($theKind == "v"){
			$printKind = 'video';
		}

		$query_images_args = array(
			'post_type' => 'attachment', 'post_mime_type' =>$printKind, 'post_status' => 'inherit', 'posts_per_page' => -1,
		);

		$query_images = new WP_Query( $query_images_args );
		$mediaFiles = array();

		foreach ( $query_images->posts as $image) {

			$useit = true;
			if($playlist != false){
				if(!in_array ($image->ID , $playlist)){
					$useit = false;
				}
			}

			if($useit){
				$item = array();
				/*
				[post_content] => My Description
				[post_title] => My Song
				[post_excerpt] => My Caption
				[guid] => http://localhost/cargoville/wp-content/uploads/2011/05/example2.mp3
				[post_modified] => 2011-05-01 02:02:35
				[post_parent] => 39 //e.g. wpordpress-url/?page=39
				*/
				$item['id'] = rawurlencode($image->ID);
				$item['description'] = rawurlencode($image->post_content);
				$item['artist'] = rawurlencode($image->post_excerpt);
				$item['title'] = rawurlencode($image->post_title);

				$item['filename'] = $image->guid;
				//$item['image'] = wp_get_attachment_thumb_url( $image->ID );
				//*
				$fn = $image->guid;
				$Afn = explode(".", $fn);
				array_pop($Afn);
				$fn2 = implode(".", $Afn);
				$fn2 = $fn2.".jpg";
				//if (file_exists($fn2)) {
				if (file_exists( $this->URLtoSYS($fn2) )) {
					$item['image'] = $fn2;
				} else {
					$item['image'] = "";
				}
				//*/
				$item['date'] = rawurlencode($image->post_modified);
				$mediaFiles[] = $item;
			}
		}


		return $mediaFiles;
	}

	function addPlaylist($plName, $plData){
		$data = array(
			'kind'	=> "plist",
			'plid'	=> $this->alpha_numeric($plName),
			'config'=> $plData,
			'html'	=> '',
			'label'	=> ''
		);
		$this->store_pl($data);
		return true;
	}

	function getPlaylistListInfo(){
		return (implode("|", $this->db_get_pl_list("plist")));
	}

	function deletePlaylist($theID){
		$temp = $this->db_delete_pl("plist", $theID);
		$list = $this->db_get_pl_list("plist");
		return (implode("|", $list));
	}




	/***********************************************************************************************************


																										PLAYER


	***********************************************************************************************************/

	

	function getPlayerData($playerID=false){

		/*
		- get the default player if:
			- arg = false (no argument sent in)
			- playerID doesn't exist
		- get fallback player if:
			- no data returned
		*/
		
		$usefallback = 0;
		$data = "";
		$retval = "";

		// No arg
		if($playerID == false){

			// Get default player name
			$defplr = $this->getDefaultPlayer();
			
			// Check if player config data code exists
			if ( false === (   $data = $this->db_get_pl( "player", $defplr )   ) ){
				$usefallback = 1;
			}
			
		
		// Check if player config data code exists
		} else if ( false === (   $data = $this->db_get_pl( "player", $playerID )   ) ){
			$usefallback = 1;
		}

		// Can't find player config data
		if($usefallback == 1){
			$retval = $this->CONF['defaultPlayerOptions'];

		// Get player config data
		} else {
		
			$retval = $this->unCompactArray($data['config']);
			
		}
		

		return $retval;

		
	}

	function compactArray($theArray){
		$Aretval = array();
		foreach($theArray as $key => $val){
			$Aretval[] = $key . "__:__" . $val;
		}
		$retval  = implode("__^__", $Aretval);
		return $retval;
	}

	function unCompactArray($data){
		$retval = array();
		$Adata = explode("__^__", rawurldecode($data));
		for($i=0; $i<sizeof($Adata); $i++){
			$Apair = explode("__:__", $Adata[$i]);
			if( !$this->isNull($Apair[0]) && !$this->isNull($Apair[1]) ){
				$retval[$Apair[0]] = $Apair[1];
			}
		}
		return $retval;
	}

	function savePlayer($plName, $plData){
		$cleanName = $this->alpha_numeric($plName);
		
		// If it is array, then this is internal to PHP, otherwise it's from JS.
		// So we have to compact it if internal PHP.
		$rawdata = $plData;
		if(is_array ($plData) == true){
			$rawdata = $this->compactArray($plData);
		}

		$data = array(
			'kind'	=> "player",
			'plid'	=> $cleanName,
			'config'=> $rawdata,
			'html'	=> rawurlencode($this->makeWimpyPlayer($cleanName, $this->unCompactArray($rawdata))),
			'label'	=> ''
		);
		$temp = $this->store_pl($data);
		$list = $this->db_get_pl_list("player");
		return $list;

	}
	

	function getPlayerListInfo(){
		$default = $this->getDefaultPlayer();
		if(!$default){
			$default = $this->CONF['fallback_player_name'];
			$this->setDefaultPlayer($this->CONF['fallback_player_name']);
		}
		$list = $this->db_get_pl_list("player");
		
		return ($default . "^" . implode("|", $list));
	}


	function deletePlayer($theName){
		$this->db_delete_pl("player", $theName);
		$list = $this->db_get_pl_list("player");
		$default = $this->getDefaultPlayer();
		return ($default . "^" . implode("|", $list));
	}


	function makeWimpyPlayer($playerID, $localData=false){
		
		if(!$localData){
			$playerConfigs = $this->getPlayerData($playerID);
		} else {
			$playerConfigs = $localData;
		}


		$Aflashvars = array();

		// reg
		$Aflashvars[] = "wimpyReg=" . $this->getRegCode();

		// player id
		$playerID = $playerConfigs['playerID'];

		// swf
		$wimpySWF = $this->CONF['path_url_plugin_folder'].$this->CONF['swf_filename'];
		
		// JS
		//$wimpyJS = $this->CONF['path_url_plugin_folder']."rave.js";

		// app
		/*
		RAVE.configsDefault.playlistType		=	[ wp_auto ]
													[ wp_plist ]
													[ url ]
													[ file ]

		RAVE.configsDefault.playlist_wp_auto	=	[ auto ]
													[ audio ]
													[ video ]

		RAVE.configsDefault.playlist_wp_plist	=	[ existing ]

		RAVE.configsDefault.playlist_url		=	[ url ];

		RAVE.configsDefault.playlist_file		=	[ url(s) ];
		*/

		if($playerConfigs['playlistType'] == "wp_auto"){
			$Aflashvars[] = "wimpyApp=" . $this->CONF['path_url_wp_folder'] . "?" . $this->CONF['playlist_url_id'] . "=" . $playerConfigs['playlist_wp_auto'];

		} else if($playerConfigs['playlistType'] == "wp_plist"){
			$Aflashvars[] = "wimpyApp=" . $this->CONF['path_url_wp_folder'] . "?" . $this->CONF['playlist_url_id'] . "=" . $playerConfigs['playlist_wp_plist'];
		
		} else if($playerConfigs['playlistType'] == "url"){
			$Aflashvars[] = "wimpyApp=" . $playerConfigs['playlist_url'];
		
		} else if($playerConfigs['playlistType'] == "file"){
			$Aflashvars[] = "playlist=" . $this->preparePlaylist($playerConfigs['playlist_file']);
		}

		

		// skin
		$Aflashvars[] = "wimpySkin=" . $playerConfigs['wimpySkin'];


		// width and height
		$width = $playerConfigs['wimpyWidth'];
		$height = $playerConfigs['wimpyHeight'];

		// background color
		$bkgdColor = $playerConfigs['bkgdColor'];


		// Transparent background
		$useTpt_param = "opaque";
		if ($playerConfigs['tptBkgd'] == "yes") {
			$useTpt_param = 'transparent';
		}


		// checkboxes
		$Atodo = array("loopTrack","randomPlayback","repeatPlaylist","randomOnLoad","startPlayingOnload","autoAdvance","popUpHelp", "bufferSeconds", "enableDownloads");

		for($i=0;$i<sizeof($Atodo);$i++){
			$key = $Atodo[$i];
			if($playerConfigs[$key]){
				$val = $playerConfigs[$key];
				if(!$this->isNull($val) && $val != $this->CONF['defaultPlayerOptions'][$key]){
					$Aflashvars[] = $key . "=yes" ;
				}
			}
		}

		
		// strings
		
		$Atodo = array("theVolume","infoDisplaySpeed","scrollFormat","timeFormat","sortField","sortOrder","fsMode","setAspectRatio","infoButtonAction","clickWindowAction","linkToWindow");
		
		for($i=0;$i<sizeof($Atodo);$i++){
			$key = $Atodo[$i];
			$val = $playerConfigs[$key];
			if(!$this->isNull($val) && $val != $this->CONF['defaultPlayerOptions'][$key]){
				$Aflashvars[] = $key . "=" . $val;
			}
		}


		// use
		
		$Atodo = array("startOnTrack","startupLogo","defaultImage","videoOverlay","limitPlaytime","resume", "onTrackComplete", "plugPlaylist");
		
		for($i=0;$i<sizeof($Atodo);$i++){
			$key = $Atodo[$i];
			$val = $playerConfigs[$key];
			$use = $playerConfigs["use_" . $key];
			if(!$this->isNull($use)){
				if(!$this->isNull($val)){
					$Aflashvars[] = $key . "=" . $val;
				}
				if($key == "onTrackComplete" && !$this->isNull($playerConfigs['onTrackCompleteURL'])){
					//$Aflashvars[] = $key . "onTrackCompleteURL=" . $playerConfigs['onTrackCompleteURL'];
					$Aflashvars[] = "onTrackCompleteURL=" . $playerConfigs['onTrackCompleteURL'];
				}
				if($key == "plugPlaylist" && !$this->isNull($playerConfigs['plugEvery'])){
					//$Aflashvars[] = $key . "plugEvery=" . $playerConfigs['plugEvery'];
					$Aflashvars[] = "plugEvery=" . $playerConfigs['plugEvery'];
				}
			}
		}
		
		$printFlashVars = implode("&", $Aflashvars);
		
		$outText = "";

		$mynewline = $this->CONF['newline'];
		
		//$outText .= '<script language="javascript" src="'.$wimpyJS.'"></script>"' . $mynewline;

		$outText .= '	<object id="' . $playerID . '" classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000" width="' . $width . '" height="' . $height . '">' . $mynewline;
		$outText .= '		<param name="movie" value="' . $wimpySWF . '" />' . $mynewline;
		$outText .= '		<param name="quality" value="high" />' . $mynewline;
		$outText .= '		<param name="scale" value="noscale" />' . $mynewline;
		$outText .= '		<param name="salign" value="lt" />' . $mynewline;
		$outText .= '		<param name="wmode" value="' . $useTpt_param . '" />' . $mynewline;
		$outText .= '		<param name="bgcolor" value="' . $bkgdColor . '" />' . $mynewline;
		$outText .= '		<param name="swfversion" value="' . $this->CONF['flashversion'] . '" />' . $mynewline;
		$outText .= '		<param name="allowScriptAccess" value="always" />' . $mynewline;
		$outText .= '		<param name="flashvars" value="' . $printFlashVars . '" />' . $mynewline;
		$outText .= '		<!-- Next object tag is for non-IE browsers, so hide it from IE using IECC -->' . $mynewline;
		$outText .= '		<!--[if !IE]>-->' . $mynewline;
		$outText .= '		<object type="application/x-shockwave-flash" id="' . $playerID . '" data="' . $wimpySWF . '" width="' . $width . '" height="' . $height . '">' . $mynewline;
		$outText .= '			<!--<![endif]-->' . $mynewline;
		$outText .= '			<param name="quality" value="high" />' . $mynewline;
		$outText .= '			<param name="wmode" value="' . $useTpt_param . '" />' . $mynewline;
		$outText .= '			<param name="scale" value="noscale" />' . $mynewline;
		$outText .= '			<param name="salign" value="lt" />' . $mynewline;
		$outText .= '			<param name="bgcolor" value="' . $bkgdColor . '" />' . $mynewline;
		$outText .= '			<param name="swfversion" value="' . $this->CONF['flashversion'] . '" />' . $mynewline;
		$outText .= '			<param name="allowScriptAccess" value="always" />' . $mynewline;
		$outText .= '			<param name="flashvars" value="' . $printFlashVars . '" />' . $mynewline;
		$outText .= '			<div>' . $mynewline;
		$outText .= '				<h4>Content on this page requires a newer version of Adobe Flash Player.</h4>' . $mynewline;
		$outText .= '				<p><a href="http://www.adobe.com/go/getflashplayer"><img src="http://www.adobe.com/images/shared/download_buttons/get_flash_player.gif" alt="Get Adobe Flash player" width="112" height="33" /></a></p>' . $mynewline;
		$outText .= '			</div>' . $mynewline;
		$outText .= '			<!--[if !IE]>-->' . $mynewline;
		$outText .= '		</object>' . $mynewline;
		$outText .= '		<!--<![endif]-->' . $mynewline;
		$outText .= '	</object>' . $mynewline;

		//$outText .= '<textarea name="textarea" id="textarea" cols="45" rows="5">' . $outText . '</textarea>' . $mynewline;

		return $outText;
		
	}



	/***********************************************************************************************************


																										SKIN


	***********************************************************************************************************/

	function getSkinList(){

		$AskinDir = $this->GetDirArray( $this->CONF['path_sys_plugin_folder'].'skins');

		$skinList = array();
		foreach ($AskinDir['dirs'] as $key => $val){
			$list = $this->GetDirArray($val);

			$xmlFound = false;
			$previewFound = false;
			$basename = "";

			foreach ($list['files'] as $keyA => $valA){
				$pathinfo = $this->path_parts($valA);
				if($pathinfo['ext'] == "xml"){
					$xmlFound = $valA;
					$basename = $pathinfo['parentFolderName'];
				} else if($pathinfo['basename'] == "_thumb"){
					$previewFound = $valA;
				}
			}
			if($xmlFound){

				$width = 0;
				$height = 0;

				if($data = @file_get_contents($xmlFound)){
					$xml_parser = xml_parser_create('');
					xml_parse_into_struct($xml_parser, $data, $vals, $index);
					xml_parser_free($xml_parser);
					$width = $vals[$index['BKGD_MAIN'][0]]['attributes']['WIDTH'];
					$height = $vals[$index['BKGD_MAIN'][0]]['attributes']['HEIGHT'];
					
				}

				if($width > 1){
					$item = array();

					$item['width'] = $width;
					$item['height'] = $height;
					$item['xml'] = $this->sysToAbsURL($xmlFound);
					$item['name'] = $basename;
					

					if($previewFound){
						$item['prev'] = $this->sysToAbsURL($previewFound);
					} else {
						$item['prev'] = "__none__";
					}
					$skinList[] = $item;
				}
			}
		}

		return $skinList;
	}








	/***********************************************************************************************************


																									UTILITIES


	***********************************************************************************************************/

	function isNull($theValue){
		if ($theValue == "" || $theValue == "undefined" || $theValue == null || $theValue == "null") {
		//if ($theValue == "" || $theValue == "undefined" || $theValue == null || (!$theValue && $theValue !== false)) {
			return true;
		} else {
			return false;
		}
	}

	function GetDirArray($dir){

		$ret = array();
		$ret['dirs'] = array ();
		$ret['files'] = array ();
		$handle=@opendir($dir);
		if($dir){
			while (false !== ($entry = @readdir($handle))){
				if($entry != '.' && $entry != '..' && substr ($entry, 0, 1 ) != "..") {
					$path = $dir.$this->CONF['slash'].$entry;
					if(is_dir($path)) {
							$ret['dirs'][] = $path;
					} else {
							$ret['files'][] = $path;
					}
				}
			}
			@closedir($handle);
		}
		
		return $ret;
	}


	function checkKeyWords($Ahaystack, $needle){
		foreach($Ahaystack as $value){
			if(@stristr(strtolower($needle), strtolower($value))){
				return true;
			}
		}
		return false;
	}

	function path_parts($thePath) {

		$thePath = str_replace("\\", "/", $thePath);
		$filepathA = explode("/", $thePath);
		$filename = array_pop($filepathA);
		
		$filepathB = explode(".", $filename);
		$extension = array_pop($filepathB);
		$basename = implode(".", $filepathB);
		$basePath = join($this->CONF['slash'], $filepathA);

		$filepathC = explode($this->CONF['slash'], $basePath);
		$parentFolderName = array_pop($filepathC);

		$Aret = array();
		$Aret['filename'] = $filename;
		$Aret['ext'] = $extension;
		$Aret['basename'] = $basename;
		$Aret['basepath'] = $basePath;
		$Aret['parentFolderName'] = $parentFolderName;
		return $Aret;
	}


	function printArray($theArray, $exit=false){
		print "<pre>";
		print_r($theArray);
		print "</pre>";
		if($exit){
			exit;
		}
	}

	function alpha_numeric($str){
		return preg_replace("/[^a-z0-9]/i", "", $str);
	}

	function arrayPHPtoJS($phpArray, $jsArrayName, &$html) {
	
		$html .= $jsArrayName . " = new Object(); \r\n ";
		foreach ($phpArray as $key => $value) {
				$outKey = (is_int($key)) ? '[' . $key . ']' : "['" . $key . "']";

				if (is_array($value)) {
						$this->arrayPHPtoJS($value, $jsArrayName . $outKey, $html);
						continue;
				}
				$html .= $jsArrayName . $outKey . " = ";
				if (is_string($value)) {
						$html .= "'" . rawurlencode($value) . "'; \r\n ";
				} else if ($value === false) {
						$html .= "false; \r\n";
				} else if ($value === NULL) {
						$html .= "null; \r\n";
				} else if ($value === true) {
						$html .= "true; \r\n";
				} else {
						$html .= $value . "; \r\n";
				}
		}
	   
		return $html;
	}


	function getQueryString(){
		$qs = $_SERVER['QUERY_STRING'];
		$Aqs = explode("&", $qs);
		$retval = array();
		foreach($Aqs as $key => $val){
			$pair = explode("=", $val);
			$retval[@$pair[0]] = @$pair[1];
		}
		return $retval;
	}

	// /cargoville/wp-content/plugins/wimpy-player/wp-content/plugins/wimpy-player/skins/aiwa/skin_aiwa.xml

	function sysToAbsURL($theSysPath){

		$ret = str_replace($this->CONF['slash'], "/", str_replace($this->CONF['path_sys_wp_folder'], $this->CONF['path_url_wp_folder'], $theSysPath));
		$protocol = "http";
		if(substr($ret, 0,5) == "https"){
			$protocol = "https";
		}
		$Aret = explode($protocol."://", $ret);
		$Bret = explode("/", $Aret[1]);
		array_shift($Bret);

		return "/".implode("/", $Bret);
	}


	function URLtoSYS($theURL){
		$ret = str_replace($this->CONF['path_url_wp_folder'], $this->CONF['path_sys_wp_folder'], $theURL);
		return str_replace("/", $this->CONF['slash'], $ret);
	}



}



/***********************************************************************************************************


																								WIDGET


***********************************************************************************************************/

class WimpyRaveWidget extends WP_Widget{
	/**
	* Declares the HelloWorldWidget class.
	*
	*/
	function WimpyRaveWidget(){
		$widget_ops = array('classname' => 'widget_wimpy_rave', 'description' => __( "Rave Player Widget") );
		$control_ops = array('width' => 300, 'height' => 300);
		$this->WP_Widget('wimpyrave', __('Rave Player Widget'), $widget_ops, $control_ops);
	}

	/**
	* Displays the Widget
	*
	*/
	function widget($args, $instance){
		extract($args);
		$title = apply_filters('widget_title', empty($instance['title']) ? '&nbsp;' : $instance['title']);
		$player = empty($instance['player']) ? 'World' : $instance['player'];

		$playerData = $this->db_get_pl('player', $player);

		$playerHTML = rawurldecode($playerData['html']);

		# Before the widget
		echo $before_widget;

		# The title
		if ( $title )
		echo $before_title . $title . $after_title;

		# Make the Hello World Example widget
		echo $playerHTML;

		# After the widget
		echo $after_widget;
	}


	
	function db_get_pl($theKind, $theID){
		global $wpdb;
		$Alist = $wpdb->get_results("SELECT * FROM " . $wpdb->prefix . WIMPY_DB_TABLE_NAME . " WHERE kind = '" . $theKind . "' AND plid='" . $theID . "'", ARRAY_A);
		return $Alist[0];

	}


	function db_get_pl_list($theKind){
		global $wpdb;
		$Alist = $wpdb->get_results("SELECT plid FROM " . $wpdb->prefix . WIMPY_DB_TABLE_NAME . " WHERE kind = '" . $theKind . "'", ARRAY_N);
		$Aret = array();
		for($i=0;$i<sizeof($Alist);$i++){
			$Aret[] = $Alist[$i][0];
		}
		return $Aret;

	}

	/**
	* Saves the widgets settings.
	*
	*/
	function update($new_instance, $old_instance){
		$instance = $old_instance;
		$instance['title'] = strip_tags(stripslashes($new_instance['title']));
		$instance['player'] = strip_tags(stripslashes($new_instance['player']));

		return $instance;
	}

	/**
	* Creates the edit form for the widget.
	*
	*/
	function form($instance){
		//Defaults
		$instance = wp_parse_args( (array) $instance, array('title'=>'', 'player'=>'yo') );

		$title = htmlspecialchars($instance['title']);
		$player = htmlspecialchars($instance['player']);

		$playerlist		= $this->db_get_pl_list("player");

		$playerlistDropDown = '<select id="' . $this->get_field_id( 'player' ) . '" name="' . $this->get_field_name( 'player' ) . '">' . "\n";
		for ($i=0; $i < sizeof($playerlist); $i++){
			$val = $playerlist[$i];
			$playerlistDropDown .= '<option value="' . $val . '">' . $val . '</option>' . "\n";
		}
		$playerlistDropDown .= '</select>' . "\n";

		# Output the options
		echo '<p style="text-align:right;"><label for="' . $this->get_field_name('title') . '">' . __('Title:');
		echo ' <input style="width: 250px;" id="' . $this->get_field_id('title') . '" name="';
		echo $this->get_field_name('title') . '" type="text" value="' . $title . '" /></label></p>';

		echo '<p>' . $playerlistDropDown . '</p>';
	}

}

/**
* Register Hello World widget.
*
* Calls 'widgets_init' action after the Hello World widget has been registered.
*/
function WimpyRaveWidgetInit() {
register_widget('WimpyRaveWidget');
}
add_action('widgets_init', 'WimpyRaveWidgetInit');


?>