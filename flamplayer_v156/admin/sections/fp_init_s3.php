<?php if ($master_page == true) { ?>

<?php
/************************************************************************************************
 * FLAM Player INITIALIZATION - Section 1: Admin logged / others settings                       *
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

/****************************************************
 * This is the FLAM Player initialization Section 2 *
 ****************************************************/
require_once('includes/ez_sql.php');

	
	// Write Musics URL
	$success += write_fp_setting( "../settings/fp_settings_2.xml", 2, "fp_parameter", "URL", $_POST['musics_url']);
	// Write Musics LOCAL PATH
	$success += write_fp_setting( "../settings/fp_settings_2.xml", 14, "fp_parameter", "URL", $_POST['musics_local_path']);
	// Write Default color
	if($_POST['color'] != "custom") {
		$success += write_fp_setting( "../settings/fp_settings_2.xml", 0, "fp_parameter", "NORMAL", "0x".$_POST['color']);}
	else {
		$success += write_fp_setting( "../settings/fp_settings_2.xml", 0, "fp_parameter", "NORMAL", "0x".$_POST['Custom_R'].$_POST['Custom_G'].$_POST['Custom_B']);}
	// Write Default language
	$success += write_fp_setting( "../settings/fp_settings_2.xml", 1, "fp_parameter", "NORMAL", $_POST['langage']);
	// Write Default Buffer time
	$success += write_fp_setting( "../settings/fp_settings_2.xml", 4, "fp_parameter", "NORMAL", $_POST['buffer']);
	// Write Default autoplay mode
	$success += write_fp_setting( "../settings/fp_settings_2.xml", 10, "fp_parameter", "NORMAL", $_POST['autoplay']);
	// Write Default loop playlist mode
	$success += write_fp_setting( "../settings/fp_settings_2.xml", 11, "fp_parameter", "NORMAL", $_POST['loop_playlist']);
	// Write Default loop tracks mode
	$success += write_fp_setting( "../settings/fp_settings_2.xml", 12, "fp_parameter", "NORMAL", $_POST['loop_tracks']);
	// Write Default shuffle mode
	$success += write_fp_setting( "../settings/fp_settings_2.xml", 13, "fp_parameter", "NORMAL", $_POST['shuffle']);		
	
	if ($success == 9) {
		echo "<div id=\"block_init\">";
		echo $text[11][$langage];
		echo $text[14][$langage];
		echo "<br><div id=\"div_w\">".$_POST['musics_url']."<br>(".$_POST['musics_local_path'].")</div>";
		
		echo $text[12][$langage];
		if($_POST['color'] != "custom") { echo "<div id=\"div_w\">#".$_POST['color']."</div>"; }
		else { echo "<div id=\"div_w\">#".$_POST['Custom_R'].$_POST['Custom_G'].$_POST['Custom_B']."</div>"; }
		
		echo $text[13][$langage];
		echo "<div id=\"div_w\">".$_POST['langage']."</div>";
		
		echo $text[104][$langage];
		if ($_POST['autoplay'] == 1) { echo "<br>&nbsp;&nbsp;&nbsp;".$text[97][$langage]."<div id=\"div_w\"> : ".$text[101][$langage]."</div>"; }		
		else { echo "<br>&nbsp;&nbsp;&nbsp;".$text[97][$langage]."<div id=\"div_w\"> : ".$text[102][$langage]."</div>"; }

		if ($_POST['loop_playlist'] == 1) { echo "<br>&nbsp;&nbsp;&nbsp;".$text[98][$langage]."<div id=\"div_w\"> : ".$text[101][$langage]."</div>"; }		
		else { echo "<br>&nbsp;&nbsp;&nbsp;".$text[98][$langage]."<div id=\"div_w\"> : ".$text[102][$langage]."</div>"; }

		if ($_POST['loop_tracks'] == 1) { echo "<br>&nbsp;&nbsp;&nbsp;".$text[99][$langage]."<div id=\"div_w\"> : ".$text[101][$langage]."</div>"; }		
		else { echo "<br>&nbsp;&nbsp;&nbsp;".$text[99][$langage]."<div id=\"div_w\"> : ".$text[102][$langage]."</div>"; }
		
		if ($_POST['shuffle'] == 1) { echo "<br>&nbsp;&nbsp;&nbsp;".$text[100][$langage]."<div id=\"div_w\"> : ".$text[101][$langage]."</div>"; }		
		else { echo "<br>&nbsp;&nbsp;&nbsp;".$text[100][$langage]."<div id=\"div_w\"> : ".$text[102][$langage]."</div>"; }		
		
		echo $text[15][$langage];
		echo "<div id=\"div_w\">".$_POST['buffer']."&nbsp;Sec</div>";
		
		echo "<br><br><br><a href=\"".$current_url."\">".$text[16][$langage]."</a>";
		echo "<br><a href=\"fp_admin.php\">".$text[17][$langage]."</a>";
		echo "</div>";
	}
	else { echo $text[18][$langage]; }
	

// Body DIV End
echo "</div>";

?>

<?php } else { echo "<font color=\"#FF0000\" size=\"7\">Forbidden</font>"; } ?>