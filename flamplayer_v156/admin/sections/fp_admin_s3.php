<?php if ($master_page == true) { ?>

<?php
/************************************************************************************************
 * FLAM Player ADMINISTRATION - Section 3                                                       *
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
 * This is the Section 3 : Manage Authors *
 ********************************************/
// ADD - EDIT - DELETE Section
//	Mode 100 : Waiting for a Task
// Mode 101 : Request for a new Author -> Author creation
// Mode 102 : Request Author deletion -> Author deletion  -> confirm
// Mode 103 : Request Author edition -> Author edition

// Mode 150 : Author creation done -> successfull
// Mode 151 : Author creation done -> ERROR : No name entered for new author
// Mode 152 : Author creation done -> ERROR : Author already exist
// Mode 112 : Author deletion confirm done -> Author Deletion
// Mode 113 : Author deletion done -> successfull
// Mode 114 : Author deletion confirm done -> Action cancelled
// Mode 115 : Author edition done -> update author
// Mode 116 : Author update done -> successfull
// Mode 117 : Forbidden - Demo mode limitation

// MOVE CONTENT Section
// Mode 200 : Waiting for a Task
// Mode 201 : Request for an Author move -> Moving process

// Mode 210 : Moving process done -> successfull
// Mode 211 : Moving process done -> ERROR : No track(s) selected
// Mode 212 : Moving process done -> ERROR : No destination author selected
// Mode 213 : Forbidden - Demo mode limitation

// ************ ADD - EDIT - DELETE ***********************************************************************************************
if ($mode[1] == 101) {
	if ($demo_mode == "yes") { $mode[1] = 117; }
	else {
		if (trim(stripslashes($_POST['new_name_au'])) != "") {								// If new author name is spaces, do nothing
				$author2add = stripslashes($_POST['new_name_au']);							// User asked for a new Author
				$author2add_clean = clean_2_compare($author2add);
				$authors_list = $db->get_results("SELECT name_artist FROM ".$fp_artists_table); 	// Existing authors extraction
				foreach($authors_list as $author){													// Is it really a new one ?
					if($author2add_clean == clean_2_compare($author->name_artist)){
						$author_exist = true;														// It is not a new one -> no addition
						$mode[1] = 152;
						break;
					}
				}
				if(!$author_exist) {																// It is a new one -> add it
						if(trim($_POST['new_email_au']) == ""){ 
							$email2add = NULL;} else { $email2add = trim($_POST['new_email_au']); }
						if(trim($_POST['new_website_au']) == ""){ 
							$website2add = NULL;} else { $website2add = check_url_http(trim($_POST['new_website_au'])); }
						
						$db->query("INSERT INTO ".$fp_artists_table." (id_artist, name_artist, email_artist, website_artist) VALUES (NULL,'".mysql_real_escape_string(stripslashes($author2add))."','".mysql_real_escape_string(stripslashes($email2add))."','".mysql_real_escape_string(stripslashes($website2add))."')");
						$mode[1] = 150;
				}
		} else { $mode[1] = 151; }
	}
	
	header("Location: ".set_url($current_url, $langage, $section, $playlist, $author, $order, $direction, $active, $mode, $record));
	exit;
}

if ($mode[1] == 102) {	
	$query = "SELECT * FROM ".$fp_artists_table." WHERE id_artist=".$_POST['author2del'];
	$author2del = $db->get_row($query);
}

if ($mode[1] == 103) {	
	$query = "SELECT * FROM ".$fp_artists_table." WHERE id_artist=".$_POST['author2edit'];
	$author2edit = $db->get_row($query);
}

if ($mode[1] == 112){
	if ($demo_mode == "yes") { $mode[1] = 117; }
	else {
		$query = "DELETE FROM ".$fp_artists_table." WHERE id_artist=".$_POST['author2del'];
		$db->query($query);
		$mode[1] = 113;
	}
		
	header("Location: ".set_url($current_url, $langage, $section, $playlist, $author, $order, $direction, $active, $mode, $record));
	exit;
}

if ($mode[1] == 115) {
	if ($demo_mode == "yes") { $mode[1] = 117; }
	else {
		if (trim($_POST['new_name_au']) == ""){ // If Author name is empty -> Change nothing for author name
			$name2update = "";}
		else { $name2update = "name_artist='".mysql_real_escape_string(stripslashes($_POST['new_name_au']))."',"; }
		
		$query = "UPDATE ".$fp_artists_table." SET ".$name2update."email_artist='".mysql_real_escape_string(stripslashes($_POST['new_email_au']))."',website_artist='".mysql_real_escape_string(check_url_http(stripslashes($_POST['new_website_au'])))."' WHERE id_artist=".$_POST['author2upd'];
		$db->query($query);
		
		$mode[1] = 116;
	}
	
	header("Location: ".set_url($current_url, $langage, $section, $playlist, $author, $order, $direction, $active, $mode, $record));
	exit;
}

// ************ MOVE CONTENT ***********************************************************************************************
if ($mode[2] == 201){
	
	if (!isset($_POST['moving_tracks'])){
		$mode[2] = 211;
		header("Location: ".set_url($current_url, $langage, $section, $playlist, $author, $order, $direction, $active, $mode, $record));exit;}
	
	elseif (!isset($_POST['dest_au'])){
		$mode[2] = 212;
		header("Location: ".set_url($current_url, $langage, $section, $playlist, $author, $order, $direction, $active, $mode, $record));exit;}
	
	else {
		if ($demo_mode == "yes") { $mode[2] = 213; }
		else {
			foreach ($_POST['moving_tracks'] as $moving_track){
				$query = "UPDATE ".$fp_musics_table." SET fk_artist=".$_POST['dest_au']." WHERE id_music=".$moving_track;
				$db->query($query);
			}
			$mode[2] = 210;
		}
		
		header("Location: ".set_url($current_url, $langage, $section, $playlist, $author, $order, $direction, $active, $mode, $record));
		exit;
	}
}

// ************ NORMAL MODE ***********************************************************************************************
	
	// Author extraction
	$authors_list = $db->get_results("SELECT * FROM ".$fp_artists_table." ORDER BY name_artist ASC");
	// Content of each playlist extraction
	if (count($authors_list) > 0){
		foreach ($authors_list as $author){
			$query = "SELECT * FROM ".$fp_musics_table." INNER JOIN ".$fp_artists_table." ON ".$fp_musics_table.".fk_artist = ".$fp_artists_table.".id_artist"." WHERE fk_artist='".$author->id_artist."'"." ORDER BY name_artist ASC";
			$authors_content[$author->id_artist] = $db->get_results($query);
		}
	}
	
	// Determining origin list
	if (count($authors_list) > 0){
		foreach ($authors_list as $author){
			if (count($authors_content[$author->id_artist]) > 0){ $authors_not_empty[] = $author; }
		}
	}
	// Setting default origin selection
	if ($record == "none" || count($authors_content[$record]) == 0) { $record = $authors_not_empty[0]->id_artist; }
	// Setting select vertical size
	$select_vsize = max( count($authors_not_empty), count($authors_content[$record]), count($authors_list)-1 )+2;

	
// ************ MESSAGES *******************************************************************************************
$mde = "</div>";
$mhs = "<div id=\"message_head_w\">";
$mb = "<div id=\"message_body\">";
$ms1 = "<div id=\"message_spec1\">";
$ms2 = "<div id=\"message_spec2\">";
$mhee = "<div id=\"message_head_e\">ERROR: ".$mde;
$mhef = "<div id=\"message_head_e\">ERREUR: ".$mde;

$message[150]['en'] = $mhs."Author creation successfull".$mde;
$message[150]['fr'] = $mhs."Nouvel auteur cr&eacute;&eacute;".$mde;
$message[151]['en'] = $mhee.$mb."No name entered for this new author".$mde;
$message[151]['fr'] = $mhef.$mb."Pas de nom entr&eacute; pour ce nouvel auteur".$mde;
$message[152]['en'] = $mhee.$mb."This author already exists".$mde;
$message[152]['fr'] = $mhef.$mb."Cet auteur existe d&eacute;j&agrave;".$mde;
$message[113]['en'] = $mhs."Author deletion successfull".$mde;
$message[113]['fr'] = $mhs."Auteur supprim&eacute;".$mde;
$message[114]['en'] = $mhs."Action cancelled".$mde;
$message[114]['fr'] = $mhs."Action annul&eacute;e".$mde;
$message[116]['en'] = $mhs."Update successfull".$mde;
$message[116]['fr'] = $mhs."Mise &agrave; jour effectu&eacute;e".$mde;
$message[117]['en'] = $mhee.$mb."Forbidden - Demo mode limitation";
$message[117]['fr'] = $mhef.$mb."Interdit - Limitation mode démo";

$message[210]['en'] = $mhs."Update successfull".$mde;
$message[210]['fr'] = $mhs."Mise &agrave; jour effectu&eacute;e".$mde;
$message[211]['en'] = $mhee.$mb."No track selected".$mde;
$message[211]['fr'] = $mhef.$mb."Aucun morceau s&eacute;lectionn&eacute;".$mde;
$message[212]['en'] = $mhee.$mb."No destination author selected".$mde;
$message[212]['fr'] = $mhef.$mb."Aucun auteur de destination s&eacute;lectionn&eacute;".$mde;
$message[213]['en'] = $mhee.$mb."Forbidden - Demo mode limitation";
$message[213]['fr'] = $mhef.$mb."Interdit - Limitation mode démo";

?>
<!-- ************** ADD - EDIT - DELETE BLOCK -->
<?php 
	if ($mode[1] != 102 && $mode[1] != 103){ require_once('sections/fp_admin_s311.php'); }
	if ($mode[1] == 102){ require_once('sections/fp_admin_s312.php'); }
	if ($mode[1] == 103){ require_once('sections/fp_admin_s313.php'); }
?>
<!-- ************** ADD - EDIT - DELETE BLOCK END-->
<!-- ************** MOVE CONTENT BLOCK -->
<?php 
	if ($mode[1] != 102 && $mode[1] != 103){ require_once('sections/fp_admin_s321.php'); }
?>
<!-- ************** MOVE CONTENT BLOCK END -->

<?php } else { echo "<font color=\"#FF0000\" size=\"7\">Forbidden</font>"; } ?>