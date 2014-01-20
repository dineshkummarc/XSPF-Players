<?php if ($master_page == true) { ?>

<?php
/************************************************************************************************
 * FLAM Player ADMINISTRATION - Section 1                                                       *
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

/**************************************
 * This is the Section 1 : Add Tracks *
 **************************************/
// UPLOAD Section
// Mode 100 : Waiting for a Task -> Warning message
// Mode 101 : Upload Form Submitted -> Launching upload process
// Mode 102 : Upload Form Submitted and File already exist -> Launching "Overwrite / Cancel" ?

// Mode 110 : Upload process launched -> Upload Successfull
// Mode 111 : Upload process launched -> File extension not allowed
// Mode 112 : Upload process launched -> Cannot reach upload directory
// Mode 113 : Upload process launched -> Cannot reach upload logs directory
// Mode 114 : Upload process launched -> Upload failed - perhaps your file is bigger than MAX POST size
// Mode 115 : Upload process launched -> Upload failed - unknown reason
// Mode 116 : "Overwrite / Cancel" launched Replace choice -> Launching Overwrite process
// Mode 117 : "Overwrite / Cancel" launched Cancel choice -> Launching Cancel process
// Mode 118 : Overwrite launched -> File replaced
// Mode 119 : Cancel launched -> Action cancelled
// Mode 120 : Upload process launched -> Upload failed - upload_max_filesize overflow
// Mode 121 : Forbidden - Demo mode limitation

// QUICKSCAN Section
// Mode 200 : Generate file list -> Waiting for a Task
// Mode 201 : Form submitted -> Launching record proccess
// Mode 210 : File list generation failed -> There is no file that isn't recorded
// Mode 211 : File list generation failed -> Cannot reach musics directory
// Mode 220 : Record process launched -> Record successfull : Files added to the database
// Mode 221 : Record process launched -> Record Failed : No files were selected
// Mode 222 : Forbidden - Demo mode limitation

// EXTERNAL LINK ADDITION Section
// Mode 300 : Waiting for a Task -> Example message
// Mode 301 : Form Submitted -> Launching database update
// Mode 310 : Database update done -> Update Successfull
// Mode 321 : Forbidden - Demo mode limitation

// ************ UPLOAD ***********************************************************************************************
// Upload requested
if ($mode[1] == 101) {
	if ($demo_mode == "yes") { $mode[1] = 121; }
	else {
		// Upload Class initalization
		$upload_class = new Upload_Files; 
		$upload_class->temp_file_name = trim($_FILES['upload']['tmp_name']); 
		$upload_class->file_name = stripslashes($_FILES['upload']['name']);

		$upload_class->upload_dir = $musics_dir; 
		$upload_class->upload_log_dir = $musics_dir."upload_logs/"; 
		$upload_class->max_file_size = 524288000;											// 512 Mo
		$upload_class->banned_array = array(""); 											// Ex : 192.168.0.2-HOSTNAME
		$upload_class->ext_array = array(".mp3"); 
	
		// Upload Check some things
		$valid_ext = $upload_class->validate_extension(); 									// Good extension ?
		$upl_dir_exists = $upload_class->get_upload_directory();							// Upload directory exist ?
		if ($upload_class->get_upload_log_directory() == "ERROR") { mkdir($musics_dir."upload_logs", 0777); chmod($musics_dir."upload_logs", 0777);}	// Logs directory creation if not exist
		
		$temp_exist = @opendir($musics_dir."temp/");
		if ($temp_exist) { closedir($temp_exist);
		} else { mkdir($musics_dir."temp", 0777); chmod($musics_dir."temp", 0777);}			// Temp directory creation if not exist
	
		$file_exists = $upload_class->existing_file();										// File to upload already exist ?
		
		// Upload actions
		if (!isset($_FILES['upload']['error'])){ $mode[1] = 114;}					// Filesize probably > max_post_size
		elseif (!$valid_ext) { $mode[1] = 111; } 											// Extension not allowed
		elseif ($upl_dir_exists == "ERROR") { $mode[1] = 112;}								// Upload dir unreachable
		elseif ($file_exists){ 																// File to upload already exist
				$mode[1] = 102;
				$uniq_file = time();
				$upload_class->upload_dir = $musics_dir."temp/";							// Change upload Dir to temp dir
				$upload_class->file_name = $uniq_file.".".$upload_class->file_name;			// Rename file to timestamp.filename
				$record = rawurlencode($upload_class->file_name);								// Store Filename in Querystring
				$upload_file = $upload_class->upload_file_with_validation();}				// upload file to temp dir
		else {
				$upload_file = $upload_class->upload_file_with_validation(); 				// Until here no problem, try to upload file
				if (!$upload_file) { 
					if ( $_FILES['upload']['error'] == 1 ){ $mode[1] = 120; }		// Filesize > upload_max_filesize
					else { $mode[1] = 115; }												// Upload Failed - unknown reason
				} else { 
					$mode[1] = 110;															// No problem - File uploaded
				}
		}
	}
	
	//header("Location: ".set_url($current_url, $langage, $section, $playlist, $author, $order, $direction, $active, $mode, $record));
	//exit;
}

// "Overwrite / Cancel" process - REPLACE
if ($mode[1] == 116) {
	unlink($musics_dir.tempname_to_name(stripslashes($record))) or die("failed to delete: ".$musics_dir.tempname_to_name(stripslashes($record)));
	rename($musics_dir."temp/".stripslashes($record), $musics_dir.tempname_to_name(stripslashes($record))) or die("failed to rename: ".$musics_dir."temp/".$record);
	$mode[1] = 118;
	$record = "none";
	header("Location: ".set_url($current_url, $langage, $section, $playlist, $author, $order, $direction, $active, $mode, $record));
	exit;
}

// "Overwrite / Cancel" process - CANCELLED
if ($mode[1] == 117) {
	unlink($musics_dir."temp/".stripslashes($record));
	$mode[1] = 119;
	$record = "none";
	header("Location: ".set_url($current_url, $langage, $section, $playlist, $author, $order, $direction, $active, $mode, $record));
	exit;
}

// ************ QUICKSCAN MODE ***********************************************************************************************
// Quickscan integration requested
if ($mode[2] == 201) {
	if ($demo_mode == "yes") {
		$mode[2] = 222; // Forbidden - Demo mode limitation
		header("Location: ".set_url($current_url, $langage, $section, $playlist, $author, $order, $direction, $active, $mode, $record));
		exit;
	
	} else {
		if (isset($_POST['fadd_qs_files'])) {
			$files2add = $_POST['fadd_qs_files'];								// Selected Files LIST
			$titles2add = get_id3_info($files2add, $musics_dir, "Title");			// Titles LIST creation
			$artists2add = get_id3_info($files2add, $musics_dir, "Artist");		// Artists LIST creation
			$id_artists2add = check_add_artists($artists2add);							// ID_Artists LIST creation
			if (trim($_POST['fadd_qs_newpl']) != "") {						// Define the assigned playlist
				$playlist2add = remove_specialsc(remove_accents(strtolower($_POST['fadd_qs_newpl'])));	// User asked for a new playlist (all special characters removed)
				$playlists_list = GetEnumValues($fp_musics_table, "playlist_music"); // Existing playLists extraction
				foreach($playlists_list as $playlist){										// Is it really a new one ?
					if($playlist2add == $playlist){
						$playlist_exist = true;													// It is not a new one -> no addition
						break;
					}
				}
				if(!$playlist_exist) {															// It is a new one -> add it
						$enum_list = "(";
						foreach($playlists_list as $playlist){	$enum_list .= "'".$playlist."',"; }
						$enum_list .= "'".$playlist2add."')";
						$db->query("ALTER TABLE ".$fp_musics_table." MODIFY playlist_music enum ".$enum_list." not null");
				}
				
				
			} else {	$playlist2add = $_POST['fadd_qs_playlist']; }		// User asked for an existing playlist
			
			for($i=0; $i<count($files2add); $i++) { 										// Record loop
				if ($titles2add[$i] == "Unknown / Inconnu") { $titles2add[$i] = substr($files2add[$i], 0, strlen($files2add[$i])-4); } // in case of unknown title -> put file name as title
				$db->query("INSERT INTO ".$fp_musics_table." (id_music, fk_artist, title_music, filename_music, playlist_music, date_music, active_music) VALUES (NULL,".$id_artists2add[$i].",'".mysql_real_escape_string(stripslashes($titles2add[$i]))."','".mysql_real_escape_string(stripslashes($files2add[$i]))."','".$playlist2add."',NOW(),'active')");		
			}
			
			$mode[2] = 220; // Ok, record successfull
			header("Location: ".set_url($current_url, $langage, $section, $playlist, $author, $order, $direction, $active, $mode, $record));
			exit;
			
		} else {
			$mode[2] = 221; // No file selected
			header("Location: ".set_url($current_url, $langage, $section, $playlist, $author, $order, $direction, $active, $mode, $record));
			exit;
		}
	}	
}

// ************ EXTERNAL ADDITION MODE ***********************************************************************************************
// External link addition requested
if ($mode[3] == 301) {
	if ($demo_mode == "yes") {
		$mode[3] = 322; // Forbidden - Demo mode limitation
		header("Location: ".set_url($current_url, $langage, $section, $playlist, $author, $order, $direction, $active, $mode, $record));
		exit;
	
	} else {
		if (trim($_POST['ext_link']) != "") {
		
				// Extract URL filename
				$link_filename = substr(strrchr($_POST['ext_link'],"/"), 1);
				$link_filename_url = rawurldecode(stripslashes($link_filename));
				// Extract URL base
				$link_base = substr($_POST['ext_link'], 0, strlen($_POST['ext_link']) - strlen($link_filename));
				// Is it a mp3 file ?
				$file_ext = strtolower(strrchr($_POST['ext_link'],"."));
				if ($file_ext != ".mp3") {
					$mode[3] = 324; // This is not a link to a mp3 file !
					header("Location: ".set_url($current_url, $langage, $section, $playlist, $author, $order, $direction, $active, $mode, $record));
					exit;				
				}
				// Try to reach the link
				if ( @fopen($link_base.rawurlencode($link_filename_url), "rb")) { @fclose($link_base.rawurlencode($link_filename_url)); }
				else {
					$mode[3] = 323; // Cannot reach the link
					header("Location: ".set_url($current_url, $langage, $section, $playlist, $author, $order, $direction, $active, $mode, $record));
					exit;			
				}
				
				$files2add[0] = rawurlencode($link_filename_url);				// Selected Files LIST (in this case, just one)
				$titles2add = get_id3_info($files2add, $link_base, "Title");			// Titles LIST creation
				$artists2add = get_id3_info($files2add, $link_base, "Artist");			// Artists LIST creation
				$id_artists2add = check_add_artists($artists2add);						// ID_Artists LIST creation
				if (trim($_POST['ext_link_newpl']) != "") {					// Define the assigned playlist
					$playlist2add = remove_specialsc(remove_accents(strtolower($_POST['ext_link_newpl'])));	// User asked for a new playlist (all special characters removed)
					$playlists_list = GetEnumValues($fp_musics_table, "playlist_music"); // Existing playLists extraction
					foreach($playlists_list as $playlist){								// Is it really a new one ?
						if($playlist2add == $playlist){
							$playlist_exist = true;										// It is not a new one -> no addition
							break;
						}
					}
					if(!$playlist_exist) {												// It is a new one -> add it
							$enum_list = "(";
							foreach($playlists_list as $playlist){	$enum_list .= "'".$playlist."',"; }
							$enum_list .= "'".$playlist2add."')";
							$db->query("ALTER TABLE ".$fp_musics_table." MODIFY playlist_music enum ".$enum_list." not null");
					}
					
					
				} else {	$playlist2add = $_POST['ext_link_playlist']; }		// User asked for an existing playlist
				
				// Record link
				if ($titles2add[0] == "Unknown / Inconnu") { $titles2add[0] = substr($link_filename_url, 0, strlen($link_filename_url)-4); } // in case of unknown title -> put file name as title
				$db->query("INSERT INTO ".$fp_musics_table." (id_music, fk_artist, title_music, filename_music, playlist_music, date_music, active_music) VALUES (NULL,".$id_artists2add[0].",'".mysql_real_escape_string($titles2add[0])."','".check_url_http(mysql_real_escape_string($link_base.$link_filename_url))."','".$playlist2add."',NOW(),'active')");
			
				$mode[3] = 310; // Update successful
				header("Location: ".set_url($current_url, $langage, $section, $playlist, $author, $order, $direction, $active, $mode, $record));
				exit;

		}
		else {
			$mode[3] = 321; // Link empty
			header("Location: ".set_url($current_url, $langage, $section, $playlist, $author, $order, $direction, $active, $mode, $record));
			exit;
		}
	
	}
}

// ************ NORMAL MODE ***********************************************************************************************
if ($mode[1] != 102){
	// Author extraction
	$authors_list = $db->get_results("SELECT id_artist, name_artist FROM ".$fp_artists_table." ORDER BY name_artist ASC");
	// PlayLists extraction
	$playlists_list = GetEnumValues($fp_musics_table, "playlist_music");
	// Active list creation
	$active_list = array(array('texten' => 'Active', 'textfr' => 'Actif', 'value' => 'active'), array('texten' => 'Inactive', 'textfr' => 'Inactif', 'value' => 'inactive'));
	
	// Try to reach musics dir	
	if ( $musics_reachable = @opendir($musics_dir) && $mode[2] != 211) { @closedir($musics_reachable); }
	// Music dir was unreachable, but now it is -> return to normal mode
	elseif ( $musics_reachable = @opendir($musics_dir) && $mode[2] == 211) { 
		closedir($musics_reachable); 
		$mode[2] = 200;
		header("Location: ".set_url($current_url, $langage, $section, $playlist, $author, $order, $direction, $active, $mode, $record));exit;}
	elseif ( $mode[2] != 211 ) {
		$mode[2] = 211;
		header("Location: ".set_url($current_url, $langage, $section, $playlist, $author, $order, $direction, $active, $mode, $record));exit;}
	
	if ($musics_reachable){
		// Clean temp dir	
		unlink_wc($musics_dir."temp/", "*.mp3");
		// Tracks filenames extraction
		$tracks = $db->get_results("SELECT filename_music FROM ".$fp_musics_table);
		// Rename with safe name files that are in the musics directory
		//safe_filenames(".mp3", $musics_dir);
		// List of the files which are in the musics directory and that have no record
		$filelist['filename'] = filter_scan_dir($tracks, "filename_music", ".mp3", $musics_dir );
		// There is no file that isn't recorded or musics dir empty
		if (count($filelist['filename']) == 0 && $mode[2] != 210) { 
			$mode[2] = 210;
			header("Location: ".set_url($current_url, $langage, $section, $playlist, $author, $order, $direction, $active, $mode, $record));exit;}
		// There is something new in the musics dir -> return to normal mode
		elseif (count($filelist['filename']) > 0 && $mode[2] == 210) {
			$mode[2] = 200;
			header("Location: ".set_url($current_url, $langage, $section, $playlist, $author, $order, $direction, $active, $mode, $record));exit;}
		// ID3 v2 & v1x Extraction
		$filelist['id3_title'] = get_id3_info($filelist['filename'], $musics_dir, "Title");
		$filelist['id3_artist'] = get_id3_info($filelist['filename'], $musics_dir, "Artist");
	}
}

// ************ MESSAGES *******************************************************************************************
$mde = "</div>";
$mhs = "<div id=\"message_head_w\">";
$mhse = "<div id=\"message_head_w\">Upload successfull".$mde;
$mhsf = "<div id=\"message_head_w\">Transfert reussi".$mde;
$mhae = "<div id=\"message_head_w\">Record successfull: ".$mde;
$mhaf = "<div id=\"message_head_w\">Enregistrement reussi: ".$mde;
$mhre = "<div id=\"message_head_w\">File replaced".$mde;
$mhrf = "<div id=\"message_head_w\">Fichier remplac&eacute;".$mde;
$mhce = "<div id=\"message_head_w\">Action cancelled".$mde;
$mhcf = "<div id=\"message_head_w\">Action annul&eacute;e".$mde;
$mhwe = "<div id=\"message_head_w\">Warning: ".$mde;
$mhwf = "<div id=\"message_head_w\">Attention: ".$mde;
$mhee = "<div id=\"message_head_e\">ERROR: ".$mde;
$mhef = "<div id=\"message_head_e\">ERREUR: ".$mde;
$mb = "<div id=\"message_body\">";
$ms1 = "<div id=\"message_spec1\">";
$ms2 = "<div id=\"message_spec2\">";
$message[100]['en'] = $mhwe.$mb."Your file must be smaller than the two following server directives, ".$mde.$ms1."upload_max_filesize:".$mde.$ms2.$upload_max_filesize.$mde.$ms1."&nbsp;post_max_size:".$mde.$ms2.$post_max_size.$mde.$mhs."<br>&nbsp;&nbsp;Use this tool only with small files or if you have a very high bandwidth, otherwise use your favourite FTP client to upload your files".$mde;
$message[100]['fr'] = $mhwf.$mb."La taille de votre fichier doit &ecirc;tre inf&eacute;rieure aux deux directives suivantes du serveur, ".$mde.$ms1."upload_max_filesize:".$mde.$ms2.$upload_max_filesize.$mde.$ms1."&nbsp;post_max_size:".$mde.$ms2.$post_max_size.$mde.$mhs."<br>&nbsp;&nbsp;N'utilisez cet outil que dans le cas de petits fichiers ou de tr&eacute;s haut d&eacute;bit, sinon utilisez votre client FTP favori pour transf&eacute;rer vos fichiers".$mde;
$message[110]['en'] = $mhse;
$message[110]['fr'] = $mhsf;

$message[111]['en'] = $mhee.$mb."File type not allowed, only mp3".$mde;
$message[111]['fr'] = $mhef.$mb."Mauvais type de fichier, mp3 seulement".$mde;
$message[112]['en'] = wordwrap($mhee.$mb."Cannot reach music directory: ".$mde.$ms1.$musics_dir.$mde, 130, "\n", 1);
$message[112]['fr'] = wordwrap($mhef.$mb."Impossible d'acc&eacute;der au r&eacute;pertoire des morceaux: ".$mde.$ms1.$musics_dir.$mde, 130, "\n", 1);
$message[113]['en'] = wordwrap($mhee.$mb."Cannot reach upload logs directory: ".$mde.$ms1.$musics_dir."upload_logs/".$mde, 130, "\n", 1);
$message[113]['fr'] = wordwrap($mhef.$mb."Impossible d'acc&eacute;der au r&eacute;pertoire des logs pour les transferts: ".$mde.$ms1.$musics_dir."upload_logs/".$mde, 130, "\n", 1);
$message[114]['en'] = $mhee.$mb."Your file could not be uploaded - Perhaps your files is bigger than ".$ms1.$upload_max_filesize.$mde;
$message[114]['fr'] = $mhef.$mb."Le transfert de votre fichier a &eacute;chou&eacute; - Peut-&ecirc;tre que votre fichier est plus gros que ".$ms1.$upload_max_filesize.$mde;
$message[115]['en'] = $mhee.$mb."Your file could not be uploaded - Unknown reason";
$message[115]['fr'] = $mhef.$mb."Le transfert de votre fichier a &eacute;chou&eacute; - Raison inconnue";
$message[118]['en'] = $mhre;
$message[118]['fr'] = $mhrf;
$message[119]['en'] = $mhce;
$message[119]['fr'] = $mhcf;
$message[120]['en'] = $mhee.$mb."Your file could not be uploaded - The server don't allow files bigger than ".$ms1.$upload_max_filesize.$mde;
$message[120]['fr'] = $mhef.$mb."Le transfert de votre fichier a &eacute;chou&eacute; - Le serveur n'accepte pas des fichiers plus gros que ".$ms1.$upload_max_filesize.$mde;
$message[121]['en'] = $mhee.$mb."Forbidden - Demo mode limitation";
$message[121]['fr'] = $mhef.$mb."Interdit - Limitation mode démo";
$message[210]['en'] = "<div id=\"message_head_w\">There is no file that isn't already recorded in the database<br>or the musics directory is empty".$mde;
$message[210]['fr'] = "<div id=\"message_head_w\">Il n'y a pas de fichier qui ne soit d&eacute;j&agrave; enregistr&eacute; dans la base de donn&eacute;es<br>ou le r&eacute;pertoire des musiques est vide".$mde;
$message[211]['en'] = wordwrap($mhee.$mb."Cannot reach music directory: ".$mde.$ms1.$musics_dir.$mde, 130, "\n", 1);
$message[211]['fr'] = wordwrap($mhef.$mb."Impossible d'acc&eacute;der au r&eacute;pertoire des morceaux: ".$mde.$ms1.$musics_dir.$mde, 130, "\n", 1);
$message[212]['en'] = wordwrap($mhee.$mb."Cannot reach music directory: ".$mde.$ms1.$musics_url.$mde, 130, "\n", 1)."<br><br>".$mhs."Musics directory must be on the same site than FLAM Player".$mde;
$message[212]['fr'] = wordwrap($mhef.$mb."Impossible d'acc&eacute;der au r&eacute;pertoire des morceaux: ".$mde.$ms1.$musics_url.$mde, 130, "\n", 1)."<br><br>".$mhs."Le r&eacute;pertoire des musiques doit &ecirc;tre sur le m&ecirc;me site que FLAM Player".$mde;
$message[220]['en'] = $mhae.$mb."Files added into the database".$mde;
$message[220]['fr'] = $mhaf.$mb."Les fichiers ont &eacute;t&eacute; ajout&eacute;s &agrave; la base de donn&eacute;es".$mde;
$message[221]['en'] = $mhee.$mb."No files were selected, please try again".$mde;
$message[221]['fr'] = $mhef.$mb."Aucun fichier n'a &eacute;t&eacute; s&eacute;lectionn&eacute;, recommencez s.v.p".$mde;
$message[222]['en'] = $mhee.$mb."Forbidden - Demo mode limitation";
$message[222]['fr'] = $mhef.$mb."Interdit - Limitation mode démo";

$message[300]['en'] = $ms2."&nbsp;Example:".$mde.$ms1."&nbsp;&nbsp;http://www.another-server.com/musics/track.mp3".$mde;
$message[300]['fr'] = $ms2."&nbsp;Exemple:".$mde.$ms1."&nbsp;&nbsp;http://www.autre-serveur.com/musiques/morceau.mp3".$mde;
$message[310]['en'] = $mhae.$mb."Link added into the database".$mde;
$message[310]['fr'] = $mhaf.$mb."Le lien a &eacute;t&eacute; ajout&eacute; &agrave; la base de donn&eacute;es".$mde;
$message[321]['en'] = $mhee.$mb."Link empty - Please try again";
$message[321]['fr'] = $mhef.$mb."Lien vide - Recommencez s.v.p";
$message[322]['en'] = $mhee.$mb."Forbidden - Demo mode limitation";
$message[322]['fr'] = $mhef.$mb."Interdit - Limitation mode démo";
$message[323]['en'] = $mhee.$mb."Cannot reach the link";
$message[323]['fr'] = $mhef.$mb."Impossible d'atteindre le lien";
$message[324]['en'] = $mhee.$mb."This is not a link to a mp3 file !";
$message[324]['fr'] = $mhef.$mb."Ce n'est pas un lien vers un fichier mp3 !";

?>
<!-- ************** UPLOAD BLOCK -->
<?php if ($mode[1] != 102 && $mode[2] != 211) { require_once('sections/fp_admin_s111.php'); } /* Mode normal  */ ?>
<?php if ($mode[1] == 102) { require_once('sections/fp_admin_s112.php'); } /* Mode overwrite / cancel */ ?>
<!-- ************** UPLOAD BLOCK END-->
<!-- ************** QUICKSCAN BLOCK -->
<?php if ($mode[2] != 210 && $mode[2] != 211 && $mode[1] != 102) { require_once('sections/fp_admin_s121.php'); } /* Mode normal  */ ?>
<?php if ($mode[2] == 210 || $mode[2] == 211) { require_once('sections/fp_admin_s122.php'); } /* Mode Error  */ ?>
<!-- ************** QUICKSCAN BLOCK END -->
<!-- ************** MANUAL ADDITION BLOCK -->
<?php if ($mode[1] != 102 && $mode[2] != 211) { require_once('sections/fp_admin_s131.php'); } /* Mode normal  */ ?>
<!-- ************** MANUAL ADDITION BLOCK END-->

<?php } else { echo "<font color=\"#FF0000\" size=\"7\">Forbidden</font>"; } ?>