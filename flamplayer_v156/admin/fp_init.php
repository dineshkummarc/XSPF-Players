<?php
/************************************************************************************************
 * FLAM Player INITIALIZATION - Main Container                                                  *
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

/***************************************************
 * This is the initialization of FLAM Player *
 ***************************************************/

// This is master page (to forbid direct access to section pages)
$master_page = true;

// Version
$version = "1.56";

// Include functions library
	require_once('includes/fp_admin_functions.php');
	require_once('../settings/fp_settings_1.php');
	
// Texts
$text[2]['en'] = "Created by";
$text[2]['fr'] = "Cr&eacute;&eacute; par";
$text[3]['en'] = "FLAM Player initialization";
$text[3]['fr'] = "Initialisation de FLAM Player";
$text[4]['en'] = "&nbsp;already exists -&gt; No creation<br>";
$text[4]['fr'] = "&nbsp;existe d&eacute;j&agrave; -&gt; Pas de cr&eacute;ation<br>";
$text[5]['en'] = "The table&nbsp;";
$text[5]['fr'] = "La table&nbsp;";
$text[6]['en'] = "&nbsp;doesn't exists -&gt; Creation<br>";
$text[6]['fr'] = "&nbsp;n'existe pas -&gt; Cr&eacute;ation<br>";
$text[7]['en'] = "<div id=\"div_w\">Default player color</div><br>It is just the default color, you'll be able to change it for each page";
$text[7]['fr'] = "<div id=\"div_w\">Couleur par d&eacute;faut du lecteur</div><br>C'est juste la couleur par d&eacute;faut, vous aurez la possibilit&eacute; de la changer pour chaque page";
$text[8]['en'] = "<div id=\"div_w\">Default player language</div><br>It is just the default language, you'll be able to change it for each page</div>";
$text[8]['fr'] = "<div id=\"div_w\">Langue par d&eacute;faut du lecteur</div><br>C'est juste la langue par d&eacute;faut, vous aurez la possibilit&eacute; de la changer pour chaque page";
$text[9]['en'] = "<div id=\"div_w\">Musics location</div><br>The default musics directory is '<strong>mp3</strong>' located under your FLAM Player installation directory.<br>If you wish to change it, you need to change both HTTP path and absolute path (server path).";
$text[9]['fr'] = "<div id=\"div_w\">Emplacement des musiques</div><br>Le répertoire par défaut des musiques est '<strong>mp3</strong>' situé dans le répertoire d'installation de FLAM Player.<br>Si vous souhaitez le modifier, vous devez changer le chemin HTTP et le chemin absolu (local au serveur).";
$text[10]['en'] = "<div id=\"div_w\">Default player buffer time (0-99)</div><br>Number of seconds before the player starts playing while a track is loading";
$text[10]['fr'] = "<div id=\"div_w\">M&eacute;moire tampon par d&eacute;faut du lecteur (0-99)</div><br>Nombre de secondes avant que le lecteur commence &agrave; lire lorsqu'un morceau est en cours de chargement";
$text[11]['en'] = "<div id=\"div_y\">Settings have been written successfully: </div>";
$text[11]['fr'] = "<div id=\"div_y\">Les param&egrave;tres ont &eacute;t&eacute; inscrits correctement: </div>";
$text[12]['en'] = "<br><br><div id=\"div_g\">Default player color: </div>";
$text[12]['fr'] = "<br><br><div id=\"div_g\">Couleur par d&eacute;faut du lecteur: </div>";
$text[13]['en'] = "<br><br><div id=\"div_g\">Default player language: </div>";
$text[13]['fr'] = "<br><br><div id=\"div_g\">Langue par d&eacute;faut du lecteur: </div>";
$text[14]['en'] = "<br><br><div id=\"div_g\">Musics location: </div>";
$text[14]['fr'] = "<br><br><div id=\"div_g\">Emplacement des musiques: </div>";
$text[15]['en'] = "<br><br><div id=\"div_g\">Default player buffer time: </div>";
$text[15]['fr'] = "<br><br><div id=\"div_g\">M&eacute;moire tampon par d&eacute;faut du lecteur: </div>";
$text[16]['en'] = "&gt;&gt; Return to Configuration";
$text[16]['fr'] = "&gt;&gt; Retourner &agrave; la configuration";
$text[17]['en'] = "&gt;&gt; Launch FLAM Player administration";
$text[17]['fr'] = "&gt;&gt; Lancer l'administration de FLAM Player";
$text[18]['en'] = "<br><br><div id=\"div_r\">Error while attempt to write into fp_settings_2.xml</div>";
$text[18]['fr'] = "<br><br><div id=\"div_r\">Erreur lors de la tentative d'&eacute;criture dans fp_settings_2.xml</div>";
$text[82]['en'] = "Custom";
$text[82]['fr'] = "Personnalis&eacute;e";
$text[83]['en'] = "Save settings";
$text[83]['fr'] = "Sauvegarder les param&egrave;tres";
$text[88]['en'] = "User";
$text[88]['fr'] = "Utilisateur";
$text[89]['en'] = "Password";
$text[89]['fr'] = "Mot de passe";
$text[90]['en'] = "Bad Login / Password";
$text[90]['fr'] = "Mauvais Utilisateur / Mot de passe";
$text[91]['en'] = "Forbidden - Demo mode limitation";
$text[91]['fr'] = "Interdit - Limitation mode démo";
$text[92]['en'] = "Next step";
$text[92]['fr'] = "Etape suivante";
$text[93]['en'] = "<div id=\"div_g\"><b>Musics directory</b></div>";
$text[93]['fr'] = "<div id=\"div_g\"><b>R&eacute;pertoire des musiques</b></div>";
$text[94]['en'] = "<div id=\"div_w\">Permissions and accessibility</div><br>Ensure that all the following lines are green otherwise you won't be able to go to the next step";
$text[94]['fr'] = "<div id=\"div_w\">Permissions et accessibilité</div><br>Assurez-vous que toutes les lignes suivantes sont vertes sinon vous ne pourrez pas passer &agrave; l'&eacute;tape suivante";
$text[95]['en'] = "<div id=\"div_g\"><b>Configuration file</b></div>";
$text[95]['fr'] = "<div id=\"div_g\"><b>Fichier de configuration</b></div>";
$text[96]['en'] = "<div id=\"div_g\"><b>Pages directory</b></div>";
$text[96]['fr'] = "<div id=\"div_g\"><b>R&eacute;pertoire des pages</b></div>";
$text[97]['en'] = "<div id=\"div_w\">Autoplay</div>";
$text[97]['fr'] = "<div id=\"div_w\">Lecture automatique</div>";
$text[98]['en'] = "<div id=\"div_w\">Loop playlist</div>";
$text[98]['fr'] = "<div id=\"div_w\">Lecture en boucle de la playlist</div>";
$text[99]['en'] = "<div id=\"div_w\">Loop tracks</div>";
$text[99]['fr'] = "<div id=\"div_w\">Lecture en boucle des morceaux</div>";
$text[100]['en'] = "<div id=\"div_w\">Shuffle</div>";
$text[100]['fr'] = "<div id=\"div_w\">Lecture al&eacute;atoire</div>";
$text[101]['en'] = "Yes";
$text[101]['fr'] = "Oui";
$text[102]['en'] = "No";
$text[102]['fr'] = "Non";
$text[103]['en'] = "<div id=\"div_w\">Default playing modes</div><br>The following parameters are just the default playing modes, you'll be able to change them for each page</div>";
$text[103]['fr'] = "<div id=\"div_w\">Modes de lecture par d&eacute;faut</div><br>Ce sont juste les modes de lecture par d&eacute;faut, vous aurez la possibilit&eacute; de les changer pour chaque page";
$text[104]['en'] = "<br><br><div id=\"div_g\">Default playing modes</div>";
$text[104]['fr'] = "<br><br><div id=\"div_g\">Modes de lecture par d&eacute;faut</div>";
$text[105]['en'] = "Local musics path : MANUAL MODE";
$text[105]['fr'] = "Chemin local des musiques : MODE MANUEL";

$text[200]['en'] = "<div id=\"div_gr\"><b>Writable -> OK</b></div>";
$text[200]['fr'] = "<div id=\"div_gr\"><b>Inscriptible -> OK</b></div>";
$text[201]['en'] = "<div id=\"div_r\"><b>Unwritable !</b><br>Change permissions and retry</div>";
$text[201]['fr'] = "<div id=\"div_r\"><b>Lecture seule !</b><br>Changez les permissions et recommencez</div>";
$text[202]['en'] = "<div id=\"div_r\"><b>Unreachable !</b><br>Change location and retry</div>";
$text[202]['fr'] = "<div id=\"div_r\"><b>Inaccessible !</b><br>Changez l'emplacement et recommencez</div>";

// Current Url
$current_url = $_SERVER['PHP_SELF'];
// Default player color extraction from the XML settings file
$color = read_fp_setting( "../settings/fp_settings_2.xml", 0, "fp_parameter", "NORMAL" );
$color = substr( $color, 2,6 );
// Color presets
$colors = read_fp_setting( "../settings/fp_settings_2.xml", 9, "fp_parameter", "NORMAL" );
$colors = explode (",", $colors);
$color_presets = array(trim($colors[0]),trim($colors[1]),trim($colors[2]),trim($colors[3]),trim($colors[4]),trim($colors[5]),trim($colors[6]),trim($colors[7]),trim($colors[8]),trim($colors[9]), 'custom');
// Player default language extraction from the XML settings file
$default_langage = read_fp_setting( "../settings/fp_settings_2.xml", 1, "fp_parameter", "NORMAL" );
// langages list creation
$langages_list = array(array('texten' => 'English', 'textfr' => 'Anglais', 'value' => 'en'), array('texten' => 'French', 'textfr' => 'Français', 'value' => 'fr'));
// Music location extraction from the XML settings file
$musics_url = read_fp_setting( "../settings/fp_settings_2.xml", 2, "fp_parameter", "URL" );
// Default player buffer time extraction from the XML settings file
$buffer_time = read_fp_setting( "../settings/fp_settings_2.xml", 4, "fp_parameter", "NORMAL" );
// Default Autoplay mode extraction from the XML settings file
$autoplay = read_fp_setting( "../settings/fp_settings_2.xml", 10, "fp_parameter", "NORMAL" );
// Default Loop playlist mode extraction from the XML settings file
$loop_playlist = read_fp_setting( "../settings/fp_settings_2.xml", 11, "fp_parameter", "NORMAL" );
// Default Loop tracks mode extraction from the XML settings file
$loop_tracks = read_fp_setting( "../settings/fp_settings_2.xml", 12, "fp_parameter", "NORMAL" );
// Default Shuffle mode extraction from the XML settings file
$shuffle = read_fp_setting( "../settings/fp_settings_2.xml", 13, "fp_parameter", "NORMAL" );
// Musics local path extraction from the XML settings file
$musics_local_path = read_fp_setting( "../settings/fp_settings_2.xml", 14, "fp_parameter", "URL" );

// S'il s'agit d'une premiere installation => evaluation du default music path
if(substr($musics_url,0,7) == "default") { $musics_url = find_default_music_http(); }
if(substr($musics_local_path,0,7) == "default") { $musics_local_path = find_default_music_local(); }

$langage = $admin_default_lang;

session_start();

$user_logged = false;
if (isset($_SESSION['logged']) || $login_enable == "no") {
	$user_logged = true;
					
} else {
	$bad_log_pass = false;
	if (isset($_POST['login'])){
		if ($_POST['login'] == $admin_user && $_POST['password'] == $admin_pass){
			$_SESSION['logged'] = true;
			header("Location: ".$current_url);
			exit;
		}
		else { 
			$bad_log_pass = true;
		}		
	}
}

?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<title>FLAM Player Initialization</title>

<meta name="robots" content="noindex,nofollow">

<style type="text/css" media="all">@import "css/fp_admin.css";</style>

<script language="JavaScript" type="text/JavaScript">
<!--
function autoSUBMIT() {
	document.build_page.submit();
}
//-->
</script>

</head>

<body onload="window.defaultStatus='FLAM Player Initialization';" id="fp_admin">
<!-- **************************************************************************************** Main Container -->
	<div id="container">
<!-- **************************************************************************************** Head -->	
		<div id="block_head">
			<div id="langage">&nbsp;</div>
			<div id="head_dyna_news">
				<h4><?php echo $text[3][$langage]; ?></h4>
			</div>	
			<div id="head_version">Version <?php echo $version; ?></div>
			<div id="head_author">
				<p><?php echo $text[2][$langage]; ?> STIMULAB</p>
				<p><a href="http://www.stimulab.net" target="_blank">www.stimulab.net</a></p>
			</div>
		</div>
<!-- **************************************************************************************** Head END -->
		
		<?php 
			if ( $demo_mode == "yes" ) { echo "<table width=\"100%\"><tr><td align=\"center\"><div id=\"message_head_e\">".$text[91][$langage]."</div></td></tr></table>"; }
			else {
				if ( $user_logged == true ) { 
					if (!isset($_POST['musics_url'])) {
						require_once('sections/fp_init_s1.php'); }						
					else {
						if (!isset($_POST['langage'])) {
							require_once('sections/fp_init_s2.php'); }
						else {
							require_once('sections/fp_init_s3.php'); }
					}
				}
				else { require_once('sections/fp_init_login.php'); }
			}
		?>
				
	</div>
<!-- **************************************************************************************** Main Container END-->	
</body>
</html>