<?php if ($master_page == true) { ?>

<?php
/************************************************************************************************
 * FLAM Player ADMINISTRATION - Section 5                                                       *
 * Copyright (C) 2007 - STIMULAB                                                                *
 ************************************************************************************************
 * Author:  STIMULAB                                                                            *
 * Email:   info@stimulab.net                                                                   *
 * Website: http://www.stimulab.net                                                             *
 ************************************************************************************************
 * FLAM Player is not Open Source, FLA and PHP codes are copyrighted and cannot be sold         *
 *                                                                                              *
 * YOU CAN :                                                                                    *
 * - Install FLAM Player where you want, for personal or commercial use                         *
 *   (The FLAM Player footer with links must stay visible)                                      *
 *                                                                                              *
 * YOU CANNOT :                                                                                 *
 * - Sell FLAM Player or any portion of it, as a product or a service                           *
 * - Copy / Modify / Rename / Decompile SWF / Redistribute FLAM Player's files wihout           *
 *   prior authorisation of STIMULAB                                                            *
 * - Use FLAM Player to broadcast illegal MP3 files                                             *
 ************************************************************************************************/

/*************************************************
 * This is the Section 5 : Integrate FLAM Player *
 *************************************************/
// ADJUST SETTINGS Section
//	Mode 100 : Waiting for a Task

// INTEGRATE FLAM PLAYER Section
// Mode 200 : Waiting for a Task

// ************ ADJUST SETTINGS ************************************************************************************

// ************ NORMAL MODE ****************************************************************************************
// Set color or Read default color
if (isset($_POST['ovr_color'])){ 
	if ($_POST['ovr_color'] == "custom"){
		$ovr_color = $_POST['Custom_R'].$_POST['Custom_G'].$_POST['Custom_B'];}
	else { $ovr_color = $_POST['ovr_color']; }	
}
else { 
	$ovr_color = read_fp_setting( "../settings/fp_settings_2.xml", 0, "fp_parameter", "NORMAL" );
	$ovr_color = substr( $ovr_color, 2,6 );
	$_POST['ovr_color'] = "custom";
}

// Set BG color
if (isset($_POST['BG_R'])){ $bgcolor = $_POST['BG_R'].$_POST['BG_G'].$_POST['BG_B']; }
else { $bgcolor = "383838"; }

// Set Player style
if (isset($_POST['fp_style'])){ $fp_style = $_POST['fp_style']; }
else { $fp_style = "flam-player"; }

// Set Player Height
if ($fp_style == "flam-player") { $fp_height = 315; }
if ($fp_style == "flam-player-npl") { $fp_height = 125; }

// Set language or Read default language
if (isset($_POST['ovr_langage'])){ $ovr_langage = $_POST['ovr_langage']; }
else { $ovr_langage = read_fp_setting( "../settings/fp_settings_2.xml", 1, "fp_parameter", "NORMAL" ); }

// Set Playlist filter or Read default playlist filter
if (isset($_POST['ovr_playlist'])){ $ovr_playlist = $_POST['ovr_playlist']; }
else { $ovr_playlist = read_fp_setting( "../settings/fp_settings_2.xml", 5, "fp_parameter", "NORMAL" ); }

// Set author filter or Read default author filter
if (isset($_POST['ovr_author'])){ $ovr_author = $_POST['ovr_author']; }
else { $ovr_author = read_fp_setting( "../settings/fp_settings_2.xml", 6, "fp_parameter", "NORMAL" ); }

// Set display order or Read default display order
if (isset($_POST['ovr_order'])){ $ovr_order = $_POST['ovr_order']; }
else { $ovr_order = read_fp_setting( "../settings/fp_settings_2.xml", 7, "fp_parameter", "NORMAL" ); }

// Set order direction or Read default display order direction
if (isset($_POST['ovr_order_direction'])){ $ovr_order_direction = $_POST['ovr_order_direction']; }
else { $ovr_order_direction = read_fp_setting( "../settings/fp_settings_2.xml", 8, "fp_parameter", "NORMAL" ); }

// Set Auto play mode or Read default Auto play mode
if (isset($_POST['ovr_autoplay'])){ $ovr_autoplay = $_POST['ovr_autoplay']; }
else { $ovr_autoplay = read_fp_setting( "../settings/fp_settings_2.xml", 10, "fp_parameter", "NORMAL" ); }

// Set Loop playlist mode or Read default loop playlist mode
if (isset($_POST['ovr_loop_playlist'])){ $ovr_loop_playlist = $_POST['ovr_loop_playlist']; }
else { $ovr_loop_playlist = read_fp_setting( "../settings/fp_settings_2.xml", 11, "fp_parameter", "NORMAL" ); }

// Set Loop tracks mode or Read default loop tracks mode
if (isset($_POST['ovr_loop_tracks'])){ $ovr_loop_tracks = $_POST['ovr_loop_tracks']; }
else { $ovr_loop_tracks = read_fp_setting( "../settings/fp_settings_2.xml", 12, "fp_parameter", "NORMAL" ); }

// Set Shuffle mode or Read default Shuffle mode
if (isset($_POST['ovr_shuffle'])){ $ovr_shuffle = $_POST['ovr_shuffle']; }
else { $ovr_shuffle = read_fp_setting( "../settings/fp_settings_2.xml", 13, "fp_parameter", "NORMAL" ); }

// FLAM Player root URL
if (dirname(dirname($_SERVER['PHP_SELF'])) == "/" || dirname(dirname($_SERVER['PHP_SELF'])) == "\\") {
	$fp_root_url = "http://".$_SERVER['HTTP_HOST']."/"; } // FLAM Player installed on the root of the HTTP server
else {
	$fp_root_url = "http://".$_SERVER['HTTP_HOST'].dirname(dirname($_SERVER['PHP_SELF']))."/"; } // FLAM Player installed in a subdirectory of the HTTP server

// Color presets
$colors = read_fp_setting( "../settings/fp_settings_2.xml", 9, "fp_parameter", "NORMAL" );
$colors = explode (",", $colors);
$color_presets = array(trim($colors[0]),trim($colors[1]),trim($colors[2]),trim($colors[3]),trim($colors[4]),trim($colors[5]),trim($colors[6]),trim($colors[7]),trim($colors[8]),trim($colors[9]), 'custom');

// PlayLists extraction
$playlists_list = GetEnumValues($fp_musics_table, "playlist_music");

// Author extraction
$authors_list = $db->get_results("SELECT id_artist, name_artist FROM ".$fp_artists_table." ORDER BY name_artist ASC");

// Orders list creation
$orders_list = array(array('texten' => 'Id', 'textfr' => 'Id', 'value' => 'id_music'), array('texten' => 'Author', 'textfr' => 'Auteur', 'value' => 'name_artist'), array('texten' => 'Playlist', 'textfr' => 'Playlist', 'value' => 'CONCAT(playlist_music)'), array('texten' => 'Title', 'textfr' => 'Titre', 'value' => 'title_music'), array('texten' => 'Date', 'textfr' => 'Date', 'value' => 'date_music'), array('texten' => 'Filename', 'textfr' => 'Nom du fichier', 'value' => 'filename_music'));

// Directions list creation
$directions_list = array(array('texten' => 'Ascending', 'textfr' => 'Ascendant', 'value' => 'ASC'), array('texten' => 'Descending', 'textfr' => 'Descendant', 'value' => 'DESC'));

// langages list creation
$langages_list = array(array('texten' => 'English', 'textfr' => 'Anglais', 'value' => 'en'), array('texten' => 'French', 'textfr' => 'Français', 'value' => 'fr'));

// Styles list creation
$style_list = array(array('texten' => 'With playlist', 'textfr' => 'Avec la playlist', 'value' => 'flam-player'), array('texten' => 'Without playlist', 'textfr' => 'Sans la playlist', 'value' => 'flam-player-npl'));

// flashVars creation
$flashVars =	"\"fp_root_url=".$fp_root_url.
					"&ovr_color=0x".$ovr_color.
					"&ovr_langage=".$ovr_langage.
					"&ovr_playlist=".urlencode($ovr_playlist).
					"&ovr_author=".$ovr_author.
					"&ovr_order=".$ovr_order.
					"&ovr_order_direction=".$ovr_order_direction.
					"&ovr_autoplay=".$ovr_autoplay.
					"&ovr_loop_playlist=".$ovr_loop_playlist.
					"&ovr_loop_tracks=".$ovr_loop_tracks.
					"&ovr_shuffle=".$ovr_shuffle.
					"\"";
					
// Player Code
$player_code = "<object classid=\"clsid:D27CDB6E-AE6D-11cf-96B8-444553540000\" codebase=\"http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=6,0,0,0\"	width=\"300\" height=\"".$fp_height."\"><param name=movie value=\"".$fp_root_url.$fp_style.".swf\"><param name=flashVars value=".$flashVars."><param name=menu value=false><param name=quality value=best><param name=bgcolor value=#".$bgcolor."><embed src=\"".$fp_root_url.$fp_style.".swf\" flashVars=".$flashVars." menu=false quality=best bgcolor=#".$bgcolor." width=\"300\" height=\"".$fp_height."\" type=\"application/x-shockwave-flash\" pluginspage=\"http://www.macromedia.com/go/getflashplayer\"></embed></object>";

// Player Code with transparency
$player_code_trans = "<object classid=\"clsid:D27CDB6E-AE6D-11cf-96B8-444553540000\" codebase=\"http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=6,0,0,0\" width=\"300\" height=\"".$fp_height."\"><param name=movie value=\"".$fp_root_url.$fp_style.".swf\"><param name=flashVars value=".$flashVars."><param name=menu value=false><param name=quality value=best><param name=wmode value=transparent><param name=bgcolor value=#".$bgcolor."><embed src=\"".$fp_root_url.$fp_style.".swf\" flashVars=".$flashVars." menu=false quality=best wmode=transparent bgcolor=#".$bgcolor." width=\"300\" height=\"".$fp_height."\" type=\"application/x-shockwave-flash\" pluginspage=\"http://www.macromedia.com/go/getflashplayer\"></embed></object>";

// ************ INTEGRATE FLAM PLAYER ******************************************************************************
// Build basic page
if ($mode[2] == 201) {
	if ($demo_mode == "yes") {
		$mode[2] = 211;
		header("Location: ".set_url($current_url, $langage, $section, $playlist, $author, $order, $direction, $active, $mode, $record));
		exit;
		
	} else {
		//create pages dir if not exist
		$pages_dir_exist = @opendir("../pages/");
		if ($pages_dir_exist) { closedir($pages_dir_exist);
		} else { mkdir("../pages"); }
		$unique_name = time();
		$new_page = fopen("../pages/flamplayer_".$unique_name.".html", "wb");
		fwrite( $new_page, "<!DOCTYPE HTML PUBLIC \"-//W3C//DTD HTML 4.01 Transitional//EN\">
<html>
<head><title>FLAM Player</title></head>
<body bgcolor=\"#".$bgcolor."\">
<table width=\"100%\" height=\"100%\" border=\"0\" cellpadding=\"0\" cellspacing=\"0\">
<tr>
<td align=\"center\" valign=\"middle\">
".$player_code_trans."
</td>
</tr>
</table>
</body>
</html>");
		fclose($new_page);
		// Set the rights for the created file (not only for "nobody" if the server is configured like that)
		chmod("../pages/flamplayer_".$unique_name.".html", 0666);
	}
}

// ************ MESSAGES *******************************************************************************************
$mde = "</div>";
$mhs = "<div id=\"message_head_w\">";
$mb = "<div id=\"message_body\">";
$ms1 = "<div id=\"message_spec1\">";
$ms2 = "<div id=\"message_spec2\">";
$mhee = "<div id=\"message_head_e\">ERROR: ".$mde;
$mhef = "<div id=\"message_head_e\">ERREUR: ".$mde;

$message[101]['en'] = "When you are satisfied with your choices, you can either<br><br>";
$message[101]['fr'] = "Quand vous &ecirc;tes safisfait de vos choix, vous pouvez<br><br>";
$message[102]['en'] = "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;- 'copy / paste' the code below in your favourite page !<br>";
$message[102]['fr'] = "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;- soit 'copier / coller' le code ci-dessous dans votre page favorite !<br>";
$message[103]['en'] = "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;- or create a basic page with the player in";
$message[103]['fr'] = "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;- soit cr&eacute;er une page basique contenant le lecteur";
$message[104]['en'] = $mhee.$mb."Forbidden - Demo mode limitation";
$message[104]['fr'] = $mhef.$mb."Interdit - Limitation mode démo";

?>

<?php if ($mode[2] == 201) { ?>
<form class="buildpage" name= "build_page" action=<?php echo "\"".set_url($current_url, $langage, $section, $playlist, $author, $order, $direction, $active, array(0, $mode[1], 210, $mode[3]), $record)."\"" ?> method="post">
		<input name="ovr_color" type="hidden" value=<?php echo "\"".$_POST['ovr_color']."\""; ?>>
		<input name="BG_R" type="hidden" value=<?php echo "\"".substr( $bgcolor, 0,2 )."\""; ?>>
		<input name="BG_G" type="hidden" value=<?php echo "\"".substr( $bgcolor, 2,2 )."\""; ?>>
		<input name="BG_B" type="hidden" value=<?php echo "\"".substr( $bgcolor, 4,2 )."\""; ?>>
		<input name="Custom_R" type="hidden" value=<?php echo "\"".substr( $ovr_color, 0,2 )."\""; ?>>
		<input name="Custom_G" type="hidden" value=<?php echo "\"".substr( $ovr_color, 2,2 )."\""; ?>>
		<input name="Custom_B" type="hidden" value=<?php echo "\"".substr( $ovr_color, 4,2 )."\""; ?>>
		<input name="fp_style" type="hidden" value=<?php echo "\"".$fp_style."\""; ?>>
		<input name="ovr_langage" type="hidden" value=<?php echo "\"".$ovr_langage."\""; ?>>
		<input name="ovr_playlist" type="hidden" value=<?php echo "\"".$ovr_playlist."\""; ?>>
		<input name="ovr_author" type="hidden" value=<?php echo "\"".$ovr_author."\""; ?>>
		<input name="ovr_order" type="hidden" value=<?php echo "\"".$ovr_order."\""; ?>>
		<input name="ovr_order_direction" type="hidden" value=<?php echo "\"".$ovr_order_direction."\""; ?>>
		<input name="created_file" type="hidden" value=<?php echo "\""."flamplayer_".$unique_name.".html"."\""; ?>>
		<input name="ovr_autoplay" type="hidden" value=<?php echo "\"".$ovr_autoplay."\""; ?>>
		<input name="ovr_loop_playlist" type="hidden" value=<?php echo "\"".$ovr_loop_playlist."\""; ?>>
		<input name="ovr_loop_tracks" type="hidden" value=<?php echo "\"".$ovr_loop_tracks."\""; ?>>
		<input name="ovr_shuffle" type="hidden" value=<?php echo "\"".$ovr_shuffle."\""; ?>>
		
		<script language="JavaScript" type="text/JavaScript">
			autoSUBMIT();
		</script>

</form>

<?php } ?>

<!-- ************** ADJUST SETTINGS BLOCK -->
<?php require_once('sections/fp_admin_s511.php'); ?>
<!-- ************** ADJUST SETTINGS BLOCK END-->
<!-- ************** INTEGRATE FLAM PLAYER BLOCK -->
<?php require_once('sections/fp_admin_s521.php'); ?>
<!-- ************** INTEGRATE FLAM PLAYER BLOCK END -->

<?php } else { echo "<font color=\"#FF0000\" size=\"7\">Forbidden</font>"; } ?>