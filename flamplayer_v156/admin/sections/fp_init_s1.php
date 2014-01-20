<?php if ($master_page == true) { ?>

<?php
/************************************************************************************************
 * FLAM Player INITIALIZATION - Section 1: Admin logged / musics directory configuration        *
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
 * This is the FLAM Player initialization Section 1 *
 ****************************************************/
require_once('includes/ez_sql.php');

/****************************************************
 * Artists Table Structure                          *
 ****************************************************/

$artists_crea_query =
"CREATE TABLE ".$fp_artists_table." (
  id_artist int(11) NOT NULL auto_increment,
  name_artist varchar(40) NOT NULL default '',
  email_artist varchar(100) default '',
  website_artist varchar(200) default '',
  PRIMARY KEY  (id_artist)
) TYPE=MyISAM";

/****************************************************
 * Musics Table Structure                           *
 ****************************************************/

$musics_crea_query =
"CREATE TABLE ".$fp_musics_table." (
  id_music int(11) NOT NULL auto_increment,
  fk_artist int(11) NOT NULL default '0',
  title_music varchar(200) NOT NULL default '',
  filename_music varchar(255) NOT NULL default '.mp3',
  playlist_music enum('default_playlist') NOT NULL default 'default_playlist',
  date_music datetime NOT NULL default '0000-00-00 00:00:00',
  active_music enum('active','inactive') NOT NULL default 'active',
  PRIMARY KEY  (id_music)
) TYPE=MyISAM"; 


// Body DIV Start
echo "<div id=\"block_init\">";	

// Tables creation
$artists_tab_exists = $db->query("SHOW tables LIKE '".$fp_artists_table."'");
$musics_tab_exists = $db->query("SHOW tables LIKE '".$fp_musics_table."'");

																			// Artists Table
if (strlen($artists_tab_exists) > 0) {											// If ERROR -> Do Nothing
	if ($artists_tab_exists == 0) {												// No Error and Table doesn't exists
		$artists_crea_tab = $db->query($artists_crea_query);					// Table creation
		$artists_tab_exists = 1;
		echo 	"<div id=\"div_y\">".$text[5][$langage]."</div>".				// Display message "Doesn't exists -> Creation"
				"<div id=\"div_r\">".$fp_artists_table."</div>".
				"<div id=\"div_y\">".$text[6][$langage]."</div>";
	}
	elseif ($artists_tab_exists == 1) {											// No Error and Table already exists
		echo 	"<div id=\"div_y\">".$text[5][$langage]."</div>".				// Display message "Already exists -> No creation"
				"<div id=\"div_r\">".$fp_artists_table."</div>".
				"<div id=\"div_y\">".$text[4][$langage]."</div>";
	}
}
																			// Musics Table
if (strlen($musics_tab_exists) > 0) {											// If ERROR -> Do Nothing
	if ($musics_tab_exists == 0) {												// No Error and Table doesn't exists
		$musics_crea_tab = $db->query($musics_crea_query);						// Table creation
		$musics_tab_exists = 1;
		echo 	"<div id=\"div_y\">".$text[5][$langage]."</div>".				// Display message "Doesn't exists -> Creation"
				"<div id=\"div_r\">".$fp_musics_table."</div>".
				"<div id=\"div_y\">".$text[6][$langage]."</div>";
	}
	elseif ($musics_tab_exists == 1) {											// No Error and Table already exists
		echo 	"<div id=\"div_y\">".$text[5][$langage]."</div>".				// Display message "Already exists -> No creation"
				"<div id=\"div_r\">".$fp_musics_table."</div>".
				"<div id=\"div_y\">".$text[4][$langage]."</div>";
	}
}


if ($artists_tab_exists == 1 && $musics_tab_exists == 1) { ?>
	
	<form action=<?php echo "\"".$current_url."\"" ?> method="post">
	<table width="730" border="0" align="center" cellspacing="1" cellpadding="0" id="add_form_table">
		<tr><td height="10" colspan="2"></td></tr>
		<tr><th height="30" colspan="2"><?php echo $text[9][$langage]; ?></th></tr>
		<tr>
			<td>HTTP&nbsp;PATH:</td>
			<td height="30">
				&nbsp;<input class="TEXT3" style="width:630px;" name="musics_url" value=<?php echo "\"".$musics_url."\""?>>
			</td>
		</tr>
		<tr>
			<td>ABSOLUTE&nbsp;PATH:</td>
			<td height="30">
				&nbsp;<input class="TEXT3" style="width:630px;" name="musics_local_path" value=<?php echo "\"".$musics_local_path."\""?>>
			</td>
		</tr>
		<tr><td height="20" colspan="2"></td></tr>
		<tr>
			<td align="center" colspan="2">
				<input type="submit" class="SUBMIT4" value=<?php echo "\"".$text[92][$langage]."\""; ?>>
			</td>
		</tr>
	</table>
	</form>
<?php 
}

// Body DIV End
echo "</div>";

?>

<?php } else { echo "<font color=\"#FF0000\" size=\"7\">Forbidden</font>"; } ?>