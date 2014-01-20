<?php
/************************************************************************************************
 * FLAM Player ADMINISTRATION - Main Container                                                  *
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
 
/******************************
 * This is the main container *
 ******************************/
// Section 1 : Add Tracks
// Section 2 : Edit existing Tracks
// Section 3 : Add - Edit - Remove Authors
// Section 4 : Add - Edit - Remove Playlists

// This is master page (to forbid direct access to section pages)
$master_page = true;

// Include functions library
	require_once('includes/fp_admin_functions.php');
	require_once('../settings/fp_settings_1.php');
	require_once('includes/ez_sql.php');
	require_once('includes/upload_files.php');
	require_once('includes/id3v1x.php');
	require_once('includes/id3v2.php');

// Version
$version = "1.56";
	
// Texts
$text[1]['en'] = "Last version";
$text[1]['fr'] = "Derni&egrave;re version";
$text[2]['en'] = "Created by";
$text[2]['fr'] = "Cr&eacute;&eacute; par";
$text[3]['en'] = "&nbsp;Edit Tracks";
$text[3]['fr'] = "&nbsp;Editer les Morceaux";
$text[4]['en'] = "&nbsp;Manage Authors";
$text[4]['fr'] = "&nbsp;G&eacute;rer les Auteurs";
$text[5]['en'] = "&nbsp;Manage Playlists";
$text[5]['fr'] = "&nbsp;G&eacute;rer les Playlists";
$text[6]['en'] = "Manual mode";
$text[6]['fr'] = "Mode manuel";
$text[7]['en'] = "manual track record";
$text[7]['fr'] = "enregistrement manuel d'un morceau";
$text[8]['en'] = "Edit - Delete";
$text[8]['fr'] = "Editer - Supprimer";
$text[9]['en'] = "a track";
$text[9]['fr'] = "un morceau";
$text[10]['en'] = "Playlist";
$text[10]['fr'] = "Playlist";
$text[11]['en'] = "Author";
$text[11]['fr'] = "Auteur";
$text[12]['en'] = "Track title";
$text[12]['fr'] = "Titre du morceau";
$text[13]['en'] = "Filename";
$text[13]['fr'] = "Nom du fichier";
$text[14]['en'] = "------- ALL -------";
$text[14]['fr'] = "------- TOUT -------";
$text[15]['en'] = "On/off filter";
$text[15]['fr'] = "Filtre on/off";
$text[16]['en'] = "Playlists filter";
$text[16]['fr'] = "Filtre playlists";
$text[17]['en'] = "Authors filter";
$text[17]['fr'] = "Filtre auteurs";
$text[18]['en'] = "Order by";
$text[18]['fr'] = "Classer par";
$text[19]['en'] = "Direction";
$text[19]['fr'] = "Sens";
$text[20]['en'] = "Launch FLAM Player with this filter (active tracks only)";
$text[20]['fr'] = "Lancer FLAM Player avec ce filtre (morceaux actifs seulement)";
$text[21]['en'] = "&nbsp;Add Tracks";
$text[21]['fr'] = "&nbsp;Ajouter des Morceaux";
$text[22]['en'] = "Upload";
$text[22]['fr'] = "Transfert";
$text[23]['en'] = "MP3 file";
$text[23]['fr'] = "d'un fichier MP3";
$text[24]['en'] = "How";
$text[24]['fr'] = "Comment";
$text[25]['en'] = "does it work ?";
$text[25]['fr'] = "ça fonctionne ?";
$text[26]['en'] = "Integration";
$text[26]['fr'] = "Integration";
$text[27]['en'] = "automatic tracks recording";
$text[27]['fr'] = "enregistrement automatique des morceaux";
$text[28]['en'] = "Integrate FLAM Player";
$text[28]['fr'] = "Int&eacute;grer FLAM Player";
$text[29]['en'] = "Select a MP3 file";
$text[29]['fr'] = "S&eacute;lectionnez un fichier MP3";
$text[30]['en'] = "Upload";
$text[30]['fr'] = "Transf&eacute;rer";
$text[31]['en'] = "Replace";
$text[31]['fr'] = "Remplacer";
$text[32]['en'] = "Cancel";
$text[32]['fr'] = "Annuler";
$text[33]['en'] = "<div id=\"message_head_w\">WARNING: ";
$text[33]['fr'] = "<div id=\"message_head_w\">ATTENTION: ";
$text[34]['en'] = "&nbsp;already exists";
$text[34]['fr'] = "&nbsp;existe d&eacute;j&agrave;";
$text[35]['en'] = "These files have not been recorded in the database:";
$text[35]['fr'] = "Ces fichiers n'ont pas &eacute;t&eacute; enregistr&eacute;s dans la base de donn&eacute;es:";
$text[36]['en'] = "&nbsp;Select file(s), and assign them a playlist: ";
$text[36]['fr'] = "&nbsp;S&eacute;lectionnez le(s) fichier(s), et affectez-leur une playlist: ";
$text[37]['en'] = " or create a new one: ";
$text[37]['fr'] = " ou cr&eacute;ez-en une nouvelle: ";
$text[38]['en'] = "Title";
$text[38]['fr'] = "Titre";
$text[39]['en'] = "Active / inactive";
$text[39]['fr'] = "Actif / inactif";
$text[40]['en'] = "Name";
$text[40]['fr'] = "Nom";
$text[41]['en'] = "Email";
$text[41]['fr'] = "Email";
$text[42]['en'] = "Website";
$text[42]['fr'] = "Site Web";
$text[43]['en'] = "or insert a new author ->&nbsp;&nbsp;";
$text[43]['fr'] = "ou ins&eacute;rez un nouvel auteur ->&nbsp;&nbsp;";
$text[44]['en'] = "Create a new playlist";
$text[44]['fr'] = "Cr&eacute;er une nouvelle playlist";
$text[45]['en'] = "Check/uncheck all";
$text[45]['fr'] = "Cocher/d&eacute;cocher tout";
$text[47]['en'] = "Delete";
$text[47]['fr'] = "Supprimer";
$text[48]['en'] = "You are about to delete these tracks";
$text[48]['fr'] = "Vous &ecirc;tes sur le point de supprimer ces morceaux";
$text[49]['en'] = "Delete records only";
$text[49]['fr'] = "Suppression des enregistrements seulement";
$text[50]['en'] = "Delete mp3 files and records";
$text[50]['fr'] = "Suppression des fichiers mp3 et des enregistrements";
$text[51]['en'] = "Edit";
$text[51]['fr'] = "Edit";
$text[52]['en'] = "Del";
$text[52]['fr'] = "Sup";
$text[53]['en'] = "Update";
$text[53]['fr'] = "Mettre &agrave; jour";
$text[54]['en'] = "Move";
$text[54]['fr'] = "Deplacer";
$text[55]['en'] = "playlists content";
$text[55]['fr'] = "le contenu des playlists";
$text[56]['en'] = "playlists";
$text[56]['fr'] = "des playlists";
$text[57]['en'] = "Add - Delete";
$text[57]['fr'] = "Ajouter - Supprimer";
$text[58]['en'] = "Edit";
$text[58]['fr'] = "Editer";
$text[59]['en'] = "Only empty playlists can be deleted, here is the list :";
$text[59]['fr'] = "Seules les playlists vides peuvent &ecirc;tre supprim&eacute;es, en voici la liste :";
$text[60]['en'] = "Origin playlist";
$text[60]['fr'] = "Playlist d'origine";
$text[61]['en'] = "Tracks into";
$text[61]['fr'] = "Morceaux dans";
$text[62]['en'] = "Destination playlist";
$text[62]['fr'] = "Playlist de destination";
$text[63]['en'] = "Add - Edit - Delete";
$text[63]['fr'] = "Ajouter - Editer - Supprimer";
$text[64]['en'] = "authors";
$text[64]['fr'] = "des auteurs";
$text[65]['en'] = "Only unused authors can be deleted";
$text[65]['fr'] = "Seuls les auteurs inutilis&eacute;s peuvent &ecirc;tre supprim&eacute;s";
$text[66]['en'] = "Change";
$text[66]['fr'] = "Changer";
$text[67]['en'] = "tracks authors";
$text[67]['fr'] = "les auteurs des morceaux";
$text[68]['en'] = "Origin author";
$text[68]['fr'] = "Auteur d'origine";
$text[69]['en'] = "Tracks by";
$text[69]['fr'] = "Morceaux par";
$text[70]['en'] = "Destination author";
$text[70]['fr'] = "Auteur de destination";
$text[71]['en'] = "Create a new author";
$text[71]['fr'] = "Cr&eacute;er un nouvel auteur";
$text[72]['en'] = "------ Reduced view ------";
$text[72]['fr'] = "------ Vue r&eacute;duite ------";
$text[73]['en'] = "Reduce";
$text[73]['fr'] = "R&eacute;duire";
$text[74]['en'] = "Expand";
$text[74]['fr'] = "Agrandir";
$text[75]['en'] = "You are about to delete this author";
$text[75]['fr'] = "Vous &ecirc;tes sur le point de supprimer cet auteur";
$text[76]['en'] = "None";
$text[76]['fr'] = "Aucun";
$text[77]['en'] = "Edition of ";
$text[77]['fr'] = "Edition de ";
$text[78]['en'] = "Adjust";
$text[78]['fr'] = "Ajuster";
$text[79]['en'] = "FLAM Player's settings";
$text[79]['fr'] = "les param&egrave;tres de FLAM Player";
$text[80]['en'] = "Integrate";
$text[80]['fr'] = "Int&eacute;grer";
$text[81]['en'] = "FLAM Player in a page";
$text[81]['fr'] = "FLAM Player dans une page";
$text[82]['en'] = "Custom";
$text[82]['fr'] = "Personnalis&eacute;e";
$text[83]['en'] = "\"Update display\"";
$text[83]['fr'] = "\"Mettre &agrave; jour l'affichage\"";
$text[84]['en'] = "Player's color";
$text[84]['fr'] = "Couleur du lecteur";
$text[85]['en'] = "Playler's background color<br><h5>(corners color, set your future page background color to hide these corners)&nbsp;</h5>";
$text[85]['fr'] = "Couleur de fond du lecteur<br><h5>(couleur des coins, mettez la couleur de votre futur page pour cacher ces coins)&nbsp;</h5>";
$text[86]['en'] = "Player's language";
$text[86]['fr'] = "Langue du lecteur";
$text[87]['en'] = "Created file: ";
$text[87]['fr'] = "Fichier cr&eacute;&eacute;: ";
$text[88]['en'] = "User";
$text[88]['fr'] = "Utilisateur";
$text[89]['en'] = "Password";
$text[89]['fr'] = "Mot de passe";
$text[90]['en'] = "Bad Login / Password";
$text[90]['fr'] = "Mauvais Utilisateur / Mot de passe";
$text[91]['en'] = "Help";
$text[91]['fr'] = "Aide";
$text[92]['en'] = "Import the files into the playlist !";
$text[92]['fr'] = "Importer les fichiers dans la playlist !";
$text[93]['en'] = "External link addition";
$text[93]['fr'] = "Ajout d'un lien externe";
$text[94]['en'] = "manual addition of an external mp3 link";
$text[94]['fr'] = "ajout manuel d'un lien externe vers un mp3";
$text[95]['en'] = "External mp3 link";
$text[95]['fr'] = "Lien externe vers un mp3";
$text[96]['en'] = "Import the link into the playlist !";
$text[96]['fr'] = "Importer le lien dans la playlist !";
$text[97]['en'] = "&nbsp;Assign an existing playlist for this external link: ";
$text[97]['fr'] = "&nbsp;Assignez une playlist existante pour ce lien externe: ";
$text[98]['en'] = "Auto Play";
$text[98]['fr'] = "Lecture automatique";
$text[99]['en'] = "Loop playlist";
$text[99]['fr'] = "Playlist en boucle";
$text[100]['en'] = "Loop tracks";
$text[100]['fr'] = "Morceaux en boucle";
$text[101]['en'] = "Yes";
$text[101]['fr'] = "Oui";
$text[102]['en'] = "No";
$text[102]['fr'] = "Non";
$text[103]['en'] = "Shuffle";
$text[103]['fr'] = "Lecture aléatoire";
$text[104]['en'] = "&nbsp;Composers, Get Listed !";
$text[104]['fr'] = "&nbsp;Compositeurs, Soyez Référencés !";
$text[105]['en'] = "Player's Style";
$text[105]['fr'] = "Style du lecteur";

// Querystring variables
if (isset($_GET['lang'])) { $langage = $_GET['lang']; } else { $langage = $admin_default_lang; }			// Langage demandé
if (isset($_GET['s'])) { $section = $_GET['s']; } else { $section = 1; }						// Section demandée
if (isset($_GET['p'])) { $playlist = $_GET['p']; } else { $playlist = "all"; }				// Playlist demandée
if (isset($_GET['a'])) { $author = $_GET['a']; } else { $author = "all"; }						// Auteur demandé
if (isset($_GET['o'])) { $order = $_GET['o']; } else { $order = "date_music"; }				// Ordre demandé
if (isset($_GET['d'])) { $direction = $_GET['d']; } else { $direction = "DESC"; }			// Sens de l'ordre demandé
if (isset($_GET['ac'])) { $active = $_GET['ac']; } else { $active = "all"; }					// Active statut demandé
if (isset($_GET['m'])) { $mode_concat = $_GET['m']; } else { $mode_concat = 100200300; }	// Active statut demandé
if (isset($_GET['r'])) { $record = $_GET['r']; } else { $record = "none"; }					// Active statut demandé

// Réorganisation du mode pour les sous modes
$mode[1] = intval( substr( $mode_concat, 0,3 ));
$mode[2] = intval( substr( $mode_concat, 3,3 ));
$mode[3] = intval( substr( $mode_concat, 6,3 ));

// Current Url
$current_url = $_SERVER['PHP_SELF'];
// Music location extraction from the XML settings file
$musics_url = read_fp_setting( "../settings/fp_settings_2.xml", 2, "fp_parameter", "URL" );
$musics_local_path = read_fp_setting( "../settings/fp_settings_2.xml", 14, "fp_parameter", "URL" );
$musics_dir = $musics_local_path;

// Post Limitation in PHP.INI
$post_max_size = ini_get('post_max_size');
// Max file size Limitation directive in PHP.INI
$upload_max_filesize = ini_get('upload_max_filesize');

session_start();

$user_logged = false;
if (isset($_SESSION['logged']) || $login_enable == "no") {
	$user_logged = true;
					
} else {
	$bad_log_pass = false;
	if (isset($_POST['login'])){
		if ($_POST['login'] == $admin_user && $_POST['password'] == $admin_pass){
			$_SESSION['logged'] = true;
			header("Location: ".set_url($current_url, $langage, $section, $playlist, $author, $order, $direction, $active, $mode, $record));
			exit;
		}
		else { 
			$bad_log_pass = true;
		}		
	}
}

// Output Buffering
ob_start();

?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<title>FLAM Player Administration</title>

<meta name="robots" content="noindex,nofollow">

<?php //if ($section != 9) { ?>
<style type="text/css" media="all">@import "css/fp_admin.css";</style>
<?php //} ?>

<script language="JavaScript" type="text/JavaScript">
<!--
function jumpMenu(targ,selObj,restore){
  eval(targ+".location='"+selObj.options[selObj.selectedIndex].value+"'");
  if (restore) selObj.selectedIndex=0;
}

function open_popup(page, height, width) {
    var size = "height=" + height + ",width=" + width;
    window_handle = window.open(page,"fp_filter_test","toolbar=no,location=no,directories=no,status=no,menubar=no,scrollbars=no,resizable=yes," + size);
}

function doc_popup(page, height, width) {
    var size = "height=" + height + ",width=" + width;
    window_handle = window.open(page,"fp_doc","toolbar=no,location=no,directories=no,status=no,menubar=no,scrollbars=yes,resizable=yes," + size + ",left=0,top=0");
}

var checkflag = "false";
function check(form_name, cb_name, size) {
	if (checkflag == "false") {
		for (i = 0; i < size; i++) {
			eval("document."+form_name+"."+cb_name+i).checked = true;}
		checkflag = "true"; }
		
	else {
		for (i = 0; i < size; i++) {
			eval("document."+form_name+"."+cb_name+i).checked = false;}
		checkflag = "false"; }
}

function autoSUBMIT() {
	document.build_page.submit();
}
//-->
</script>

</head>

<body onload="window.defaultStatus='FLAM Player Administration';" id="fp_admin">
<!-- **************************************************************************************** Main Container -->
	<div id="container">
<!-- **************************************************************************************** Head -->	
		<div id="block_head">
			<div id="langage">
				<?php
					if ($langage == "fr") {	echo set_link($current_url, "en", $section, $playlist, $author, $order, $direction, $active, $mode, $record, "English"); }
					if ($langage == "en") {	echo set_link($current_url, "fr", $section, $playlist, $author, $order, $direction, $active, $mode, $record, "Français"); }
				?>
			</div>		
			<div id="head_dyna_news"><h4><a href="fp_admin.php?s=9">(i)</a> - </h4>
				<?php  
					if (isset($_SESSION['dynanews'])) { echo $_SESSION['dynanews'][$langage]; }
					else { 
						$_SESSION['dynanews'] = load_dynanews($langage, $version, "http://www.stimulab.net/fp_dyna_news.txt");
						echo $_SESSION['dynanews'][$langage];
					}
				?>
			</div>
			<div id="head_version">Version <?php echo $version; ?></div>
			<div id="head_author">
				<p><?php echo $text[2][$langage]; ?> STIMULAB</p>
				<p><a href="http://www.stimulab.net" target="_blank">www.stimulab.net</a></p>
			</div>
			
			<?php if ( $user_logged == true ) { ?>
			<div id="main_menu">
				<ul>
					<?php 
							if ( $section == 1 ) { echo "<li class=\"main_menu_active\">".$text[21][$langage]."</li>"; 
							} else { echo "<li class=\"main_menu_inactive\">".set_link($current_url, $langage, 1, $playlist, $author, $order, $direction, $active, array(0,100,200,300), "none", $text[21][$langage]); } ?></li>
					<?php	
							if ( $section == 2 ) { echo "<li class=\"main_menu_active\">".$text[3][$langage]."</li>"; 
							} else { echo "<li class=\"main_menu_inactive\">".set_link($current_url, $langage, 2, "all", "all", $order, $direction, $active, array(0,100,200,300), "none", $text[3][$langage]); } ?></li>
					<?php	
							if ( $section == 3 ) { echo "<li class=\"main_menu_active\">".$text[4][$langage]."</li>"; 
							} else { echo "<li class=\"main_menu_inactive\">".set_link($current_url, $langage, 3, $playlist, $author, $order, $direction, $active, array(0,100,200,300), "none", $text[4][$langage]); } ?></li>
					<?php	
							if ( $section == 4 ) { echo "<li class=\"main_menu_active\">".$text[5][$langage]."</li>"; 
							} else { echo "<li class=\"main_menu_inactive\">".set_link($current_url, $langage, 4, $playlist, $author, $order, $direction, $active, array(0,100,200,300), "none", $text[5][$langage]); } ?></li>
					<?php	
							if ( $section == 5 ) { echo "<li class=\"main_menu_active\">".$text[28][$langage]."</li>"; 
							} else { echo "<li class=\"main_menu_inactive\">".set_link($current_url, $langage, 5, $playlist, $author, $order, $direction, $active, array(0,100,200,300), "none", $text[28][$langage]); } ?></li>
							
							<li class="main_menu_inactive"><a href="http://account.flamplayer.com" target="_blank"><?php echo $text[104][$langage]; ?></a></li>						
				</ul>
			</div>					
			
		</div>
<!-- **************************************************************************************** Head END -->
<!-- **************************************************************************************** Add Tracks -->
		<?php if ($section == "1") { require_once('sections/fp_admin_s1.php'); } ?>
<!-- **************************************************************************************** Add Tracks END-->
<!-- **************************************************************************************** Edit Tracks -->
		<?php if ($section == "2") { require_once('sections/fp_admin_s2.php'); } ?>
<!-- **************************************************************************************** Edit Tracks END-->
<!-- **************************************************************************************** Manage Authors -->
		<?php if ($section == "3") { require_once('sections/fp_admin_s3.php'); } ?>
<!-- **************************************************************************************** Manage Authors END-->	
<!-- **************************************************************************************** Manage Playlists -->
		<?php if ($section == "4") { require_once('sections/fp_admin_s4.php'); } ?>
<!-- **************************************************************************************** Manage Playlists END-->
<!-- **************************************************************************************** Manage Playlists -->
		<?php if ($section == "5") { require_once('sections/fp_admin_s5.php'); } ?>
<!-- **************************************************************************************** Manage Playlists END-->
<!-- **************************************************************************************** Debug infos -->
		<?php if ($section == "9") { require_once('sections/fp_admin_s9.php'); } ?>
<!-- **************************************************************************************** Debug infos END-->
		<?php } else { require_once('sections/fp_admin_login.php'); }

		?>
				
	</div>
<!-- **************************************************************************************** Main Container END-->	
</body>
</html>