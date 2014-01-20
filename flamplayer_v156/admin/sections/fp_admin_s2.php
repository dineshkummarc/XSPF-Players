<?php if ($master_page == true) { ?>

<?php
/************************************************************************************************
 * FLAM Player ADMINISTRATION - Section 2                                                       *
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

/************************************************
 * This is the Section 2 : Edit existing Tracks *
 ************************************************/
//	Mode 100 : Waiting for a Task
//	Mode 101 : Delete form submitted -> Display Choice "Delete records / records + files"
//	Mode 201 : Edit track requested -> Display Edit track form
//	Mode 110 : Choice Delete records submitted -> Records Deleted
//	Mode 111 : Choice Delete files + records submitted -> Files + Records Deleted
//	Mode 210 : Edit track form submitted -> Launch Record update
//	Mode 112 : Record update done -> display "record updated"
//	Mode 113 : Edit track form cancelled or Display Choice "Delete records / records + files" cancelled -> Action cancelled
//	Mode 114 : Delete form submitted -> No file selected
//  Mode 115 : Forbidden - Demo mode limitation
// ************ EDIT TRACK MODE *******************************************************************************
if ($mode[2] == 201) {
	$query = "SELECT * FROM ".$fp_musics_table." INNER JOIN ".$fp_artists_table." ON ".$fp_musics_table.".fk_artist = ".$fp_artists_table.".id_artist"." WHERE id_music=".$record;
	$record2edit = $db->get_row($query);
	// Active list creation
	$active_list = array(array('texten' => 'Active', 'textfr' => 'Actifs', 'value' => 'active'), array('texten' => 'Inactive', 'textfr' => 'Inactifs', 'value' => 'inactive'));	
}

if ($mode[2] == 210) {
	if ($demo_mode == "yes") { $mode[1] = 115; $mode[2] = 200; }
	else {
		if (trim($_POST['edit_title']) == ""){ // If title is empty -> Change nothing for title
			$title2update = "";}
		else { $title2update = "title_music='".$_POST['edit_title']."',"; }
		
		$query = "UPDATE ".$fp_musics_table." SET fk_artist=".$_POST['edit_author'].",".$title2update."playlist_music='".$_POST['edit_playlist']."',active_music='".$_POST['edit_active']."' WHERE id_music=".$record;
		$db->query($query);
		
		$mode[1] = 112;
		$mode[2] = 200;
	}
	header("Location: ".set_url($current_url, $langage, $section, $playlist, $author, $order, $direction, $active, $mode, $record));
	exit;
}
// ************ DELETE REQUEST MODE *******************************************************************************
if ($mode[1] == 101){
	if (count($_POST) > 0) {
		foreach ($_POST as $record2del){ 
			$query = "SELECT id_music, name_artist, title_music, filename_music FROM ".$fp_musics_table." INNER JOIN ".$fp_artists_table." ON ".$fp_musics_table.".fk_artist = ".$fp_artists_table.".id_artist"." WHERE id_music=".$record2del;
			$records2del[] = $db->get_row($query);
		}
	
	} else {
		$mode[1] = 114;
		header("Location: ".set_url($current_url, $langage, $section, $playlist, $author, $order, $direction, $active, $mode, $record));
		exit;
	}
}

if ($mode[1] == 110){
	if ($demo_mode == "yes") { 
		$mode[1] = 115;
		$mode[2] = 200;
		header("Location: ".set_url($current_url, $langage, $section, $playlist, $author, $order, $direction, $active, $mode, $record));
		exit;
		
	} else {
		foreach ($_POST as $record2del){ 
				$query = "DELETE FROM ".$fp_musics_table." WHERE id_music=".$record2del;
				$db->query($query);
		}
	}
}

if ($mode[1] == 111){
	if ($demo_mode == "yes") { 
		$mode[1] = 115;
		$mode[2] = 200;
		header("Location: ".set_url($current_url, $langage, $section, $playlist, $author, $order, $direction, $active, $mode, $record));
		exit;
		
	} else {
			for ($i=0; $i<count($_POST)/2; $i++){
				$query = "DELETE FROM ".$fp_musics_table." WHERE id_music=".$_POST['id2del'.$i];
				$db->query($query);
				
			  	$link_start = strtolower(substr(stripslashes($_POST['file2del'.$i]), 0, 6));
			  	if ($link_start != "http:/" && $link_start != "ftp://" && $link_start != "https:") {
					unlink($musics_dir.stripslashes($_POST['file2del'.$i]));
				}
			}
	}
}

// ************ NORMAL MODE ****************************************************************************************
if ($mode[1] != 101) {
	// Author extraction
	$authors_list = $db->get_results("SELECT id_artist, name_artist FROM ".$fp_artists_table." ORDER BY name_artist ASC");
	// PlayLists extraction
	$playlists_list = GetEnumValues($fp_musics_table, "playlist_music");

	if ($mode[2] != 201){
		// Active list creation
		$active_list = array(array('texten' => '- ALL -', 'textfr' => '- TOUT -', 'value' => 'all'), array('texten' => 'Active', 'textfr' => 'Actifs', 'value' => 'active'), array('texten' => 'Inactive', 'textfr' => 'Inactifs', 'value' => 'inactive'));	
		// Orders list creation
		$orders_list = array(array('texten' => 'Id', 'textfr' => 'Id', 'value' => 'id_music'), array('texten' => 'Author', 'textfr' => 'Auteur', 'value' => 'name_artist'), array('texten' => 'Playlist', 'textfr' => 'Playlist', 'value' => 'CONCAT(playlist_music)'), array('texten' => 'Title', 'textfr' => 'Titre', 'value' => 'title_music'), array('texten' => 'Date', 'textfr' => 'Date', 'value' => 'date_music'), array('texten' => 'Filename', 'textfr' => 'Nom du fichier', 'value' => 'filename_music'));
		// Directions list creation
		$directions_list = array(array('texten' => 'Ascending', 'textfr' => 'Ascendant', 'value' => 'ASC'), array('texten' => 'Descending', 'textfr' => 'Descendant', 'value' => 'DESC'));
		// Tracks extraction with filter
		$tracks = $db->get_results(tracks_filter_query());
	}
}

// ************ MESSAGES *******************************************************************************************
$mde = "</div>";
$mhs = "<div id=\"message_head_w\">";
$mhce = "<div id=\"message_head_w\">Action cancelled".$mde;
$mhcf = "<div id=\"message_head_w\">Action annul&eacute;e".$mde;
$mhwe = "<div id=\"message_head_w\">Warning: ".$mde;
$mhwf = "<div id=\"message_head_w\">Attention: ".$mde;
$mhee = "<div id=\"message_head_e\">ERROR: ".$mde;
$mhef = "<div id=\"message_head_e\">ERREUR: ".$mde;
$mb = "<div id=\"message_body\">";
$ms1 = "<div id=\"message_spec1\">";
$ms2 = "<div id=\"message_spec2\">";
$message[100]['en'] = $mb."This filter display ".$mde.$ms2.count($tracks).$mde."&nbsp;Tracks";
$message[100]['fr'] = $mb."Ce filtre affiche ".$mde.$ms2.count($tracks).$mde."&nbsp;Morceaux";

$message[110]['en'] = $mhs."Database records deleted".$mde;
$message[110]['fr'] = $mhs."Enregistrements de la base de donn&eacute;es supprim&eacute;s".$mde;
$message[111]['en'] = $mhs."Files and Database records deleted".$mde;
$message[111]['fr'] = $mhs."Fichiers et Enregistrements de la base de donn&eacute;es supprim&eacute;s".$mde;
$message[112]['en'] = $mhs."Record updated".$mde;
$message[112]['fr'] = $mhs."Enregistrement mis &agrave; jour".$mde;
$message[113]['en'] = $mhce;
$message[113]['fr'] = $mhcf;
$message[114]['en'] = $mhee.$mb."No files were selected, please try again".$mde;
$message[114]['fr'] = $mhef.$mb."Aucun fichier n'a &eacute;t&eacute; s&eacute;lectionn&eacute;, recommencez s.v.p".$mde;
$message[115]['en'] = $mhee.$mb."Forbidden - Demo mode limitation";
$message[115]['fr'] = $mhef.$mb."Interdit - Limitation mode démo";

?>
<!-- ************** EDIT - DELETE Title -->
<div id="block_edit_del">
	<div id="block_title">	
		<h2><?php echo $text[8][$langage]; ?></h2><h3> <?php echo $text[9][$langage]; ?></h3>
		<div id="help">
			<a href=<?php echo "\"javascript:doc_popup('../doc/fp_doc_".$langage.".html#edit_tracks','2000','740')\""; ?>><?php echo $text[91][$langage]; ?></a>
		</div>
	</div>
<!-- ************** EDIT - DELETE Title END-->
<?php if ($mode[1] != 101 && $mode[2] != 201) { require_once('sections/fp_admin_s211.php'); } /* Mode normal  */ ?>
<?php if ($mode[1] == 101) { require_once('sections/fp_admin_s212.php'); } /* Mode Display Choice "Delete records / records + files"  */ ?>
<?php if ($mode[2] == 201) { require_once('sections/fp_admin_s221.php'); } /* Mode Edit track  */ ?>
</div>

<?php } else { echo "<font color=\"#FF0000\" size=\"7\">Forbidden</font>"; } ?>