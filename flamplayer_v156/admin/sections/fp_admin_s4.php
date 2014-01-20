<?php if ($master_page == true) { ?>

<?php
/************************************************************************************************
 * FLAM Player ADMINISTRATION - Section 4                                                       *
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

/********************************************
 * This is the Section 4 : Manage Playlists *
 ********************************************/
// ADD - DELETE Section
//	Mode 100 : Waiting for a Task
// Mode 101 : Request for a new playlist -> playlist creation
// Mode 102 : Request playlist deletion -> playlist deletion

// Mode 110 : Playlist creation done -> successfull
// Mode 111 : Playlist creation done -> ERROR : No name entered for new playlist
// Mode 112 : Playlist creation done -> ERROR : Playlist already exist
// Mode 113 : Playlist deletion done -> successfull
// Mode 114 : Forbidden - Demo mode limitation

// MOVE CONTENT Section
// Mode 200 : Waiting for a Task
// Mode 201 : Request for a playlist move -> Moving process

// Mode 210 : Moving process done -> successfull
// Mode 211 : Moving process done -> ERROR : No track(s) selected
// Mode 212 : Moving process done -> ERROR : No destination playlist selected
// Mode 213 : Forbidden - Demo mode limitation

// ************ ADD - DELETE ***********************************************************************************************
if ($mode[1] == 101) {
	if ($demo_mode == "yes") { $mode[1] = 114; }
	else {
		if (trim($_POST['new_playlist']) != "") {								// If new playlist name is spaces, do nothing
				$playlist2add = remove_specialsc(remove_accents(strtolower($_POST['new_playlist'])));	// User asked for a new playlist (all special characters removed)
				$playlists_list = GetEnumValues($fp_musics_table, "playlist_music"); // Existing playLists extraction
				foreach($playlists_list as $playlist){										// Is it really a new one ?
					if($playlist2add == $playlist){
						$playlist_exist = true;													// It is not a new one -> no addition
						$mode[1] = 112;
						break;
					}
				}
				if(!$playlist_exist) {															// It is a new one -> add it
						$enum_list = "(";
	
						foreach($playlists_list as $playlist){	$enum_list .= "'".$playlist."',"; }
						$enum_list .= "'".$playlist2add."')";
						$db->query("ALTER TABLE ".$fp_musics_table." MODIFY playlist_music enum ".$enum_list." not null");
						$mode[1] = 110;
				}
		} else { $mode[1] = 111; }
	}
	
	header("Location: ".set_url($current_url, $langage, $section, $playlist, $author, $order, $direction, $active, $mode, $record));
	exit;
}

if ($mode[1] == 102) {
	if ($demo_mode == "yes") { $mode[1] = 114; }
	else {
		$playlist2del = $_POST['playlist2del'];
		$playlists_list = GetEnumValues($fp_musics_table, "playlist_music");
		
		$enum_list = "('default_playlist'";
		foreach($playlists_list as $playlist){	
			if ($playlist != "default_playlist" && $playlist != $playlist2del) {
				$enum_list .= ",'".$playlist."'";
			}
		}
		$enum_list .= ")";
	
		$db->query("ALTER TABLE ".$fp_musics_table." MODIFY playlist_music enum ".$enum_list." not null");
		
		$mode[1] = 113;
	}
	
	header("Location: ".set_url($current_url, $langage, $section, $playlist, $author, $order, $direction, $active, $mode, $record));
	exit;
}

// ************ MOVE CONTENT ***********************************************************************************************
if ($mode[2] == 201){
	
	if (!isset($_POST['moving_tracks'])){
		$mode[2] = 211;
		header("Location: ".set_url($current_url, $langage, $section, $playlist, $author, $order, $direction, $active, $mode, $record));exit;}
	
	elseif (!isset($_POST['dest_pl'])){
		$mode[2] = 212;
		header("Location: ".set_url($current_url, $langage, $section, $playlist, $author, $order, $direction, $active, $mode, $record));exit;}
	
	else {
		if ($demo_mode == "yes") { $mode[2] = 213; }
		else {
			foreach ($_POST['moving_tracks'] as $moving_track){
				$query = "UPDATE ".$fp_musics_table." SET playlist_music='".$_POST['dest_pl']."' WHERE id_music=".$moving_track;
				$db->query($query);			
			}
			$mode[2] = 210;
		}
		
		header("Location: ".set_url($current_url, $langage, $section, $playlist, $author, $order, $direction, $active, $mode, $record));
		exit;
	}
}

// ************ NORMAL MODE ***********************************************************************************************
	
	// PlayLists extraction
	$playlists_list = GetEnumValues($fp_musics_table, "playlist_music");
	// Content of each playlist extraction
	foreach ($playlists_list as $playlist){
		// !!!!!! A OPTIMISER !!!!!!		
		$query = "SELECT * FROM ".$fp_musics_table." INNER JOIN ".$fp_artists_table." ON ".$fp_musics_table.".fk_artist = ".$fp_artists_table.".id_artist"." WHERE playlist_music='".$playlist."'"." ORDER BY name_artist ASC";
		$playlists_content[$playlist] = $db->get_results($query);
	}
	// Determining how many playlists are empty except for default_playlist
	$pl_empty=0;
	foreach ($playlists_list as $playlist){
		if ($playlist != "default_playlist" && count($playlists_content[$playlist]) == 0){ $pl_empty++; }
	}
		
	// Determining origin list
	foreach ($playlists_list as $playlist){
		if (count($playlists_content[$playlist]) > 0){ $playlists_not_empty[] = $playlist; }
	}	
	// Setting default origin selection
	if ($record == "none" || count($playlists_content[$record]) == 0) { $record = $playlists_not_empty[0]; }
	// Setting select vertical size
	$select_vsize = max( count($playlists_not_empty), count($playlists_content[$record]), count($playlists_list)-1 )+2;
	
// ************ MESSAGES *******************************************************************************************
$mde = "</div>";
$mhs = "<div id=\"message_head_w\">";
$mb = "<div id=\"message_body\">";
$ms1 = "<div id=\"message_spec1\">";
$ms2 = "<div id=\"message_spec2\">";
$mhee = "<div id=\"message_head_e\">ERROR: ".$mde;
$mhef = "<div id=\"message_head_e\">ERREUR: ".$mde;

$message[110]['en'] = $mhs."Playlist creation successfull".$mde;
$message[110]['fr'] = $mhs."Nouvelle playlist cr&eacute;&eacute;e".$mde;
$message[111]['en'] = $mhee.$mb."No name entered for this new playlist".$mde;
$message[111]['fr'] = $mhef.$mb."Pas de nom entr&eacute; pour cette nouvelle playlist".$mde;
$message[112]['en'] = $mhee.$mb."This playlist already exists".$mde;
$message[112]['fr'] = $mhef.$mb."Cette playlist existe d&eacute;j&agrave;".$mde;
$message[113]['en'] = $mhs."Playlist deletion successfull".$mde;
$message[113]['fr'] = $mhs."Playlist supprim&eacute;e".$mde;
$message[114]['en'] = $mhee.$mb."Forbidden - Demo mode limitation";
$message[114]['fr'] = $mhef.$mb."Interdit - Limitation mode démo";

$message[210]['en'] = $mhs."Update successfull".$mde;
$message[210]['fr'] = $mhs."Mise &agrave; jour effectu&eacute;e".$mde;
$message[211]['en'] = $mhee.$mb."No track selected".$mde;
$message[211]['fr'] = $mhef.$mb."Aucun morceau s&eacute;lectionn&eacute;".$mde;
$message[212]['en'] = $mhee.$mb."No destination playlist selected".$mde;
$message[212]['fr'] = $mhef.$mb."Aucune playlist de destination s&eacute;lectionn&eacute;e".$mde;
$message[213]['en'] = $mhee.$mb."Forbidden - Demo mode limitation";
$message[213]['fr'] = $mhef.$mb."Interdit - Limitation mode démo";

?>
<!-- ************** ADD - DELETE BLOCK -->
<?php require_once('sections/fp_admin_s411.php'); ?>
<!-- ************** ADD - DELETE BLOCK END-->
<!-- ************** MOVE CONTENT BLOCK -->
<?php require_once('sections/fp_admin_s421.php'); ?>
<!-- ************** MOVE CONTENT BLOCK END -->

<?php } else { echo "<font color=\"#FF0000\" size=\"7\">Forbidden</font>"; } ?>