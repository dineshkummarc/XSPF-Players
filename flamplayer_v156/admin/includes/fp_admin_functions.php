<?php
/************************************************************************************************
 * FLAM Player ADMINISTRATION - FUNCTIONS                                                       *
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

//$HTTP_POST_VARS = $_POST;
//$HTTP_GET_VARS = $_GET;

	
	//----------------------------------------------------------------------
	// Fonctions permettant la construction d'une URL avec ses paramètres
	//----------------------------------------------------------------------
	function set_link ( $base_url, $langage, $section, $playlist, $author, $order, $direction, $active, $mode, $record, $text ) {
		$mode_concat = $mode[1].$mode[2].$mode[3];
		if (is_object($author)) { $author = "all"; }
		if (is_object($playlist)) { $playlist = "all"; }
		return "<a href=\"".$base_url."?lang=".$langage."&s=".$section."&p=".urlencode($playlist)."&a=".$author."&o=".$order."&d=".$direction."&ac=".$active."&m=".$mode_concat."&r=".$record."\">".$text."</a>";
	}
	
	function set_url ( $base_url, $langage, $section, $playlist, $author, $order, $direction, $active, $mode, $record) {
		$mode_concat = $mode[1].$mode[2].$mode[3];
		if (is_object($author)) { $author = "all"; }
		if (is_object($playlist)) { $playlist = "all"; }
		return $base_url."?lang=".$langage."&s=".$section."&p=".urlencode($playlist)."&a=".$author."&o=".$order."&d=".$direction."&ac=".$active."&m=".$mode_concat."&r=".$record;
	}
	
	//----------------------------------------------------------------------
	// Fonction permettant l'extraction des valeur d'un champ ENUM
	//----------------------------------------------------------------------
	function GetEnumValues($Table,$Column) {
	   $dbSQL = "SHOW COLUMNS FROM ".$Table." LIKE '".$Column."'";
	   $dbQuery = mysql_query($dbSQL);
	
	   $dbRow = mysql_fetch_assoc($dbQuery);
	   $EnumValues = $dbRow["Type"];
	
	   $EnumValues = substr($EnumValues, 6, strlen($EnumValues)-8); 
	   $EnumValues = str_replace("','",",",$EnumValues);
		$result = explode(",",$EnumValues);
		sort($result, SORT_STRING);
		
	   return $result;
	}
	
	//---------------------------------------------------------------------------------
	// Fonction permettant la construction de la requete pour le filtrage des morceaux
	//---------------------------------------------------------------------------------
	function tracks_filter_query() {
		
		global $fp_musics_table;
		global $fp_artists_table;
		global $playlist;
		global $author;
		global $active;
		global $order;
		global $direction;
		
		$query = "SELECT * FROM ".$fp_musics_table." INNER JOIN ".$fp_artists_table." ON ".$fp_musics_table.".fk_artist = ".$fp_artists_table.".id_artist";
		
		if ($playlist != "all") {
			$query .= " WHERE playlist_music = '".$playlist."'";
			if ($author != "all") {
				$query .= " AND id_artist = '".$author."'";
			}
			if ($active != "all") {
				$query .= " AND active_music = '".$active."'";
			}
		}
		
		if ($author != "all" && $playlist == "all") {
			$query .= " WHERE id_artist = '".$author."'";
			if ($active != "all") {
				$query .= " AND active_music = '".$active."'";
			}
		}
		
		if ($active != "all" && $playlist == "all" && $author == "all") {
			$query .= " WHERE active_music = '".$active."'";
		}
		
		$query .= " ORDER BY ".$order." ".$direction.",id_music ".$direction;
		
		return $query;
	}
	
	//---------------------------------------------------------------------------------
	// Fonction permettant de rechercher l'existence d'une valeur dans un champ
	//---------------------------------------------------------------------------------
	function record_exist($record_list, $record_item, $value) {
		if(count($record_list) > 0){
			foreach ( $record_list as $record ) {
				if ($record->$record_item == $value) { return true; }
			}
		}
		return false;
	}
	
	//---------------------------------------------------------------------------------
	// Fonction permettant de vérifier le nom des fichiers d'un répertoire 
	// et de les renommer de manière a obtenir des noms sans caractères spéciaux
	// Vérifie également les permissions et supprime les eventuels 'Read only'
	//---------------------------------------------------------------------------------
	function safe_filenames($file_ext_concerned, $directory) {
		$strings = new strings;
		if ($dir = @opendir($directory)) {
			while (($file = readdir($dir)) !== false) {
				$file_ext = strtolower(strrchr($file,"."));
				
				if($file != ".." && $file != "." && $file_ext == $file_ext_concerned) {

					$temp_name = strtolower($strings->normal($file));
					$ideal_name = $strings->rem_spechar3(trim($temp_name));
					if ($ideal_name != $file){
						rename($directory.$file, $directory.$ideal_name) or die("failed to rename: ".$directory.$file);
					}
				}			
			}
			closedir($dir);
		}
	}
	
	//---------------------------------------------------------------------------------
	// Fonction permettant l'extraction des permissions actuelles d'un fichier
	// Octal ex: 666 (444 lecture seule pour windows)
	//---------------------------------------------------------------------------------
	function view_perms($file) {
		$decperms = fileperms($file);
		$octalperms = sprintf("%o",$decperms);
		return $perms=(substr($octalperms,-3));
	}
	
	//---------------------------------------------------------------------------------
	// Fonction permettant l'extraction des noms de fichiers d'un répertoire 
	// Les fichiers comportant uniquement l'extension $file_ext_allowed sont filtrés
	// Les fichiers présents dans la liste $record_list sont filtrés
	// Les fichiers en lecture seule sont filtrés
	//---------------------------------------------------------------------------------
	function filter_scan_dir($record_list, $record_item, $file_ext_allowed, $directory) {
		if ($dir = @opendir($directory)) {
			while (($file = readdir($dir)) !== false) {
				
				$file_ext = strtolower(strrchr($file,"."));

				if($file != ".." && $file != "." && $file_ext == $file_ext_allowed && !record_exist($record_list, $record_item, $file)) {
					
					$filelist[] = $file;
				
				}
			}
			closedir($dir);
		}
		return $filelist;
	}
	
	//---------------------------------------------------------------------------------
	// Fonction permettant la lecture d'un element de la config XML de FLAM Player 
	// Ex: read_fp_setting( "../settings/fp_settings_2.xml", 2, "fp_parameter", "URL" );
	// Note : Le type "URL" permet l'ajout du "/" s'il est absent
	//---------------------------------------------------------------------------------
	function read_fp_setting( $xml_file, $index, $param_name, $type) {
		if (!($f=fopen($xml_file, "r"))) 
		exit("Unable to open ".$xml_file." file.");
		while (!feof($f)) { 
			$content .= fgetc($f); 
		}
		
		$result = stripfromtextarray($content, "<".$param_name.">", "</".$param_name.">", $myarray=array());
		$result[$index] = trim($result[$index]);
		
		if ($type == "URL") {
			$last_slash = substr($result[$index],strlen($result[$index])-1,1); 
			if ($last_slash <> "/") { 
				$result[$index] .= "/"; 
			}
		}
				
		return $result[$index];
		fclose($f);
	}
	
	//---------------------------------------------------------------------------------
	// Fonction permettant l'extraction d'un element contenu entre 2 balises dans un string
	// Ex: $result = stripfromtextarray($content, "<".$param_name.">", "</".$param_name.">");
	// Note : La fonction renvoie un tableau contenant toutes les occurences
	//---------------------------------------------------------------------------------
	function &stripfromtextarray($haystack, $bfstarttext, $endsection, &$myarray, $offset=0) {
		$startpostext = $bfstarttext;
		$startposlen = strlen($startpostext);
		$startpos = strpos($haystack, $startpostext, $offset);
		$endpostext = $endsection;
		$endposlen = strlen($endpostext);
		$endpos = strpos($haystack, $endpostext, $startpos);
		$myarray[] = substr($haystack, $startpos + $startposlen, $endpos - ($startpos + $startposlen));
		$offset = $endpos;
		if (is_numeric(strpos($haystack, $startpostext, $offset))) {
			return stripfromtextarray($haystack,$startpostext, $endpostext, $myarray, $offset);
		} else {
			return $myarray;
		}
	}
	
	//---------------------------------------------------------------------------------
	// Fonction permettant l'ecriture d'un element dans la config XML de FLAM Player 
	// Ex: write_fp_setting( "../settings/fp_settings_2.xml", 2, "fp_parameter", "URL", "http://mysite/mydir/");
	// Note : Le type "URL" permet l'ajout du "/" s'il est absent
	//---------------------------------------------------------------------------------
	function write_fp_setting( $xml_file, $index, $param_name, $type, $value) {
		if (!($f=fopen($xml_file, "r"))) 
		exit("Unable to open ".$xml_file." file.");
		while (!feof($f)) { 
			$content .= fgetc($f); 
		}
		
		$value = trim($value);
		if ($type == "URL") {
			$last_slash = substr($value,strlen($value)-1,1); 
			if ($last_slash <> "/") { 
				$value .= "/"; 
			}
		}		
		
		$content_splited = explode("<".$param_name.">", $content);
		$remainder = strstr($content_splited[$index+1], "</".$param_name.">");
		$content_splited[$index+1] = $value.$remainder;
		$result = implode("<".$param_name.">", $content_splited);
		fclose($f);
		
		if (!($f=fopen($xml_file, "wb"))) {return false;}
		else {
			fwrite($f, $result);
			fclose($f);
			return true;
		}
	}	
	
	//---------------------------------------------------------------------------------
	// Fonction permettant de trouver le chemin http par defaut des musiques
	//---------------------------------------------------------------------------------
	function find_default_music_http() {
			$result = pathinfo("http://".$_SERVER['HTTP_HOST'].$_SERVER['PHP_SELF']);
			$result = $result['dirname'];
			$result = substr($result, 0, strlen($result) - 5)."mp3/";
			return $result;
	}
	
	//---------------------------------------------------------------------------------
	// Fonction permettant de trouver le chemin local par defaut des musiques
	//---------------------------------------------------------------------------------
	function find_default_music_local() {
			$result = getcwd();
			$result = substr($result, 0, strlen($result) - 5)."mp3/";
			// Fix for Windows
			$result = str_replace("\\","/", $result);
			return $result;
	}
	
	//---------------------------------------------------------------------------------
	// Fonction permettant de repasser du nom temporaire
	// du fichier mp3 s'il existe déjà au nom original
	//---------------------------------------------------------------------------------
	function tempname_to_name($temp_name) {
		$lenght = strpos($temp_name, ".");
		$result = substr( $temp_name, $lenght+1);		
		return $result;
	}
	
	//---------------------------------------------------------------------------------
	// Fonction permettant de tronquer avec des points un string trop long
	//---------------------------------------------------------------------------------
	function dots($string, $max, $rep = '') {
   	if (strlen($string) > $max) {
			$leave = $max - strlen ($rep);
   		return substr_replace($string, $rep, $leave);
		} else { return $string; }
	}
	
	//---------------------------------------------------------------------------------
	// Fonction permettant de reccupérer les infos ID3 d'un liste de mp3
	//---------------------------------------------------------------------------------
	function get_id3_info($filelist, $files_dir, $item) {
		if (count($filelist) > 0) {
			foreach( $filelist as $file ) {
				$file = $files_dir.stripslashes($file);
				
				$myId3 = new ID3($file);
				$item_adapt = "get".$item;
				if ($myId3->getInfo() && $myId3->$item_adapt()!=""){ $result[] = $myId3->$item_adapt(); }
				else { 
					$myId3 = new ID3v1x($file);
					$item_adapt = strtolower($item);
					$myId3->read_tag();
					if($myId3->tag != "noid3v1.x" && $myId3->$item_adapt != ""){
						$result[] = $myId3->$item_adapt; }
					else { $result[] = "Unknown / Inconnu";}
				}
				
			}
			return $result;
		}
	}
	
	//---------------------------------------------------------------------------------
	// Fonction permettant de supprimer les accents d'un string
	//---------------------------------------------------------------------------------
	function remove_accents($text) {
   	$strings = new strings;
		$result = $strings->normal($text);
   	return $result;
	}
	
	//---------------------------------------------------------------------------------
	// Fonction permettant de supprimer tout les caractères non standard d'un string
	// nom nouvelle playlist : remove_accents + remove_specialsc
	//---------------------------------------------------------------------------------
	function remove_specialsc($text) {
		$strings = new strings;
		$result = $strings->rem_spechar($text);
   	return $result;
	}
	
	//---------------------------------------------------------------------------------
	// Fonction permettant de supprimer tout les caractères dangeureux d'un string pour les requêtes
	// Affichage des titres et noms d'artistes extrait de l'ID3 du mp3 dans les SELECT
	// Pour l'enregistrement dans la DB, est ajouté "mysql_real_escape_string"
	//---------------------------------------------------------------------------------
	function safe_string($text) {
		$strings = new strings;
		$result = $strings->rem_spechar2($text);
		$result = remove_accents($result);
   	return $result;
	}
	
	//---------------------------------------------------------------------------------
	// Fonction permettant de retransformer les "_" en " " d'un string
	//---------------------------------------------------------------------------------
	function us2space($text) {
		$strings = new strings;
		$result = $strings->uscore2space($text);
   	return $result;
	}
	
	//---------------------------------------------------------------------------------
	// Fonction permettant de nettoyer un string pour en garder l'information essentielle :
	// + transfo en minuscules
	// + Suppression des accents
	// + Suppression des pronoms de début de string
	// + concaténation des mots
	//---------------------------------------------------------------------------------
	function clean_2_compare ($text) {
		$text = substr($text, 0, 40); // Limitation à 40c (database)
		$result = split( " ", strtolower($text)); // séparation des mots & miniscules
		if ($result[0] == "le" || $result[0] == "la" || $result[0] == "les" || $result[0] == "the"){ $result[0] = ""; }
		$result = implode ("", $result);
		$result = remove_accents($result);
		return $result;
	}
	
	//---------------------------------------------------------------------------------
	// Fonction prenant en argument un tableau contenant des noms d'artistes et
	// renvoyant un tableau contenant les ids existant correspondants ou les nouveaux
	// ids créés au besoin
	//---------------------------------------------------------------------------------
	function check_add_artists($artists2add){
		global $db;
		global $fp_artists_table;
		
		foreach ($artists2add as $artist2add) {
			$artist2add_clean = clean_2_compare($artist2add);
			$artists = $db->get_results("SELECT id_artist, name_artist FROM ".$fp_artists_table);
			$found = false;
			if (count($artists) > 0) {
				foreach ($artists as $artist){
					$artist_clean = clean_2_compare($artist->name_artist);
					if($artist2add_clean == $artist_clean){ 
						$result[] = $artist->id_artist;
						$found = true;
						break;
					}
				}
			}
			
			if ($found == false) { 
				$db->query("INSERT INTO ".$fp_artists_table." (id_artist, name_artist, email_artist, website_artist) VALUES (NULL,'".mysql_real_escape_string(stripslashes($artist2add))."', '', '')");
				$result[] = $db->insert_id;
			}
		}
		
		return $result;
	}
	
	//---------------------------------------------------------------------------------
	// Fonction recevant un nom d'artiste et une liste d'artistes et renvoyant
	// l'index du tableau où le nom est présent (pour la préselection de l'artiste
	// dans l'edition de morceaux)
	//---------------------------------------------------------------------------------	
	function check_artist($artist2check, $artists) {
		$artist2check_clean = clean_2_compare($artist2check);
		foreach ($artists as $artist){
			$artists_clean[] = clean_2_compare($artist->name_artist);
		}
		$result = array_search($artist2check_clean, $artists_clean); 
		return $result;
	}
	
	//---------------------------------------------------------------------------------	
	// Fonction effectuant des suppression avec prise en charge de Wildcards (* et ?)
	// Author: Pablo Rosciani, but i added some corrections
	//---------------------------------------------------------------------------------	
	function unlink_wc($dir, $pattern){
		if ($dh = @opendir($dir)) { 
			
			while (false !== ($file = readdir($dh))){
				if ($file != "." && $file != "..") {
					$files[] = $file;
				}
			}
			closedir($dh);

			if (is_array($files)){
			
				if(strpos($pattern,".")) {
					$baseexp=substr($pattern,0,strpos($pattern,"."));
					$typeexp=substr($pattern,strpos($pattern,".")+1,strlen($pattern));

				}else{ 
					$baseexp=$pattern;
					$typeexp="";
				} 
				
				$baseexp=preg_quote($baseexp); 
				$typeexp=preg_quote($typeexp); 

				$baseexp=str_replace(array("\*","\?"), array(".*","."), $baseexp);
				$typeexp=str_replace(array("\*","\?"), array(".*","."), $typeexp);

				$i=0;
				foreach($files as $file) {
					$filename=basename($file);
					if(strpos($filename,".")) {
						$base=substr($filename,0,strrpos($filename,"."));	// !!! use strrpos instead of strpos
						$type=substr($filename,strrpos($filename,".")+1,strlen($filename)); // !!! use strrpos instead of strpos
					}else{
						$base=$filename;
						$type="";
					}
				
					if(preg_match("/^".$baseexp."$/i",$base) && preg_match("/^".$typeexp."$/i",$type))  {
						$matches[$i]=$file;
						$i++;
					}
				}
				if (count($matches) > 0){
					while(list($idx,$val) = each($matches)){
						if (substr($dir,-1) == "/"){
							unlink($dir.$val);
						}else{
							unlink($dir."/".$val);
						}
					}
				}
			}
		}
	}
	
	//---------------------------------------------------------------------------------
	// Classe permettant d'effectuer certaines manipulations sur les strings
	//---------------------------------------------------------------------------------	
	class strings {
		var $locale = "PT_BR";
		
		function strings() {
		setlocale (LC_CTYPE, $this->locale);
		}
		
		// Tout les caractères accentués -> catactères normaux
		function normal($p) {
		$ts = array("/[À-Å]/","/Æ/","/Ç/","/[È-Ë]/","/[Ì-Ï]/","/Ð/","/Ñ/","/[Ò-ÖØ]/","/×/","/[Ù-Ü]/","/[Ý-ß]/","/[à-å]/","/æ/","/ç/","/[è-ë]/","/[ì-ï]/","/ð/","/ñ/","/[ò-öø]/","/÷/","/[ù-ü]/","/[ý-ÿ]/");
		$tn = array("A","AE","C","E","I","D","N","O","X","U","Y","a","ae","c","e","i","d","n","o","x","u","y");
		return preg_replace($ts,$tn, $p);
		}
		
		// Conversion de
		// !"#$%&'()*+,-./ -------------> -
		// :;<=>?@ ---------------------> 
		// [\]^_` ----------------------> _
		// tout les autres symboles ou caractères accentuées supprimés
		function rem_spechar($p) {
		$ts = array("/[!-\/]/","/[:-@]/","/[[-`]/","/[{-ÿ]/");
		$tn = array("-","","_","");
		return preg_replace($ts,$tn, $p);
		}
		
		// Conservation de 
		// !"'()*+,-.?@_ et de tout les caractères accentuées
		function rem_spechar2($p) {
		$ts = array("/[#-&]/","/[\/]/", "/[[-^]/","/[:->]/","/`/", "/[{-¿]/");
		$tn = array("", "", "", "", "", "");
		return preg_replace($ts,$tn, $p);
		}
		
		// Transformation des espaces en underscore
		// Conservation de
		// -._
		function rem_spechar3($p) {
		$ts = array("/[ ]/","/[!-,]/","/[\/]/","/[:-@]/","/[[-^]/","/[`]/","/[{-ÿ]/");
		$tn = array("_","","","","","","");
		return preg_replace($ts,$tn, $p);
		}
		
		// Transformation des underscores en espaces
		function uscore2space($p) {
		$ts = array("/[_]/");
		$tn = array(" ");
		return preg_replace($ts,$tn, $p);
		}
	}
	
	//---------------------------------------------------------------------------------	
	// Fonction permettant de réafficher le login tenté en cas d'echec
	//---------------------------------------------------------------------------------	
	function get_login(){
		global $_POST;
		if(isset($_POST['login'])){ 
			return "value=\"".$_POST['login']."\""; 
		}
	}
	
	//---------------------------------------------------------------------------------	
	// Fonction chargeant la ligne de news du site officiel de FLAM Player
	//---------------------------------------------------------------------------------
	function load_dynanews($langage, $actual_version, $dynanews_file) {
		if (!($f=@fopen($dynanews_file, "r"))) { 
			$r['en'] = $r['fr'] = "<h4>ADMINISTRATION</h4>";
			return $r; }
		else {
			while (!feof($f)) { $content .= fgetc($f); }
			fclose($f);
			
			$result = stripfromtextarray($content, "<DYNANEWS>", "</DYNANEWS>", $myarray=array());
			if ($result[0] == $actual_version) { 
				$r['en'] = $r['fr'] = "<h4>ADMINISTRATION</h4>";
				return $r; }
			else { 
				$value2return['en'] = $result[1];
				$value2return['fr'] = $result[2];
				return $value2return;
			}
		}		
	}

	//---------------------------------------------------------------------------------	
	// Fonction vérifiant si http:// a été ajouté sur une URL, sinon l'ajoute
	//---------------------------------------------------------------------------------
	function check_url_http($url) {
		if (strlen(trim($url)) > 0) {
			$link_start = strtolower(substr($url, 0, 7));
			if ($link_start != "http://") {
				return "http://".trim($url);
			}
			else { return trim($url); }
		}
	}
	
	//---------------------------------------------------------------------------------	
	// Fonction permettant la mise à jour / création d'une playlist sans utiliser le module d'administration
	//---------------------------------------------------------------------------------
	function flam_update_playlist ( $playlist, $tracks_array ) {

		global $db;
		global $fp_musics_table;
		global $fp_artists_table;
		$tracks_done[0] = "false";
	
		// Some verifications
		if (!is_string($playlist)) { echo "ERROR : The first argument of FLAM_UPDATE_PLAYLIST function is not a STRING -> Record aborted"; return false; }
		if (!is_array($tracks_array)) { echo "ERROR : The second argument of FLAM_UPDATE_PLAYLIST function is not an ARRAY -> Record aborted"; return false; }
		if (strlen(trim($playlist)) == 0) { echo "ERROR : You must enter a playlist name as the first argument of FLAM_UPDATE_PLAYLIST function -> Record aborted"; return false; }
		if (count($tracks_array) == 0) { echo "ERROR : You must enter a tracks array that is not empty as the second argument of FLAM_UPDATE_PLAYLIST function -> Record aborted"; return false; }
		for ($i=0; $i<count($tracks_array); $i++) {
			if (strlen(trim($tracks_array[$i]['music_link'])) == 0) { echo "ERROR : The track #".$i." has no link provided ! -> Record aborted"; return false; }
		}
					
		// Check if the playlist need to be created
		$playlist2add = remove_specialsc(remove_accents(strtolower($playlist)));
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
		else { 																// It is not a new one -> exctract it
				$existing_tracks = $db->get_results("SELECT * FROM ".$fp_musics_table." WHERE playlist_music = '".$playlist2add."'");
		} 
		
		// MAIN RECORD LOOP
		foreach ($tracks_array as $track) {

			// No author entered
			if (strlen(trim($track['artist_name'])) == 0) { $track['artist_name'] = "Unknown / Inconnu"; }
			
			// Is this an existing author ?
			$artist2add_clean = clean_2_compare($track['artist_name']);
			$artists = $db->get_results("SELECT id_artist, name_artist FROM ".$fp_artists_table);
			$found = false;
			if (count($artists) > 0) {
				foreach ($artists as $artist){
					$artist_clean = clean_2_compare($artist->name_artist);
					if($artist2add_clean == $artist_clean){ 
						$found_id = $artist->id_artist;
						$found = true;
						break;
					}
				}
			}
			
			if ($found == false) { // New author -> Insert IT
				$db->query("INSERT INTO ".$fp_artists_table." (id_artist, name_artist, email_artist, website_artist) VALUES (NULL,'".mysql_real_escape_string(stripslashes($track['artist_name']))."', '".mysql_real_escape_string(stripslashes($track['artist_email']))."', '".mysql_real_escape_string(check_url_http(stripslashes($track['artist_website'])))."')");
				$found_id = $db->insert_id;
			}
			if ($found == true ) { // Existing author -> Update IT
				$db->query("UPDATE ".$fp_artists_table." SET name_artist='".mysql_real_escape_string(stripslashes($track['artist_name']))."', email_artist='".mysql_real_escape_string(stripslashes($track['artist_email']))."', website_artist='".mysql_real_escape_string(check_url_http(stripslashes($track['artist_website'])))."' WHERE id_artist=".$found_id);
			}
			
			// Record track
				// Extract URL filename
				$link_filename = substr(strrchr($track['music_link'],"/"), 1);
				$link_filename_clean = rawurldecode(stripslashes($link_filename));
				// Extract URL base
				$link_base = substr($track['music_link'], 0, strlen($track['music_link']) - strlen($link_filename));			
				// No title entered -> Use file name as title
				if (strlen(trim($track['music_title'])) == 0) {
					$title2add = substr($link_filename_clean, 0, strlen($link_filename_clean)-4);
				}
				else { $title2add = trim($track['music_title']); }
				
				// Record track
				if (!$playlist_exist) { // New playlist -> INSERT 
					$db->query("INSERT INTO ".$fp_musics_table." (id_music, fk_artist, title_music, filename_music, playlist_music, date_music, active_music) VALUES (NULL,".$found_id.",'".mysql_real_escape_string($title2add)."','".mysql_real_escape_string($link_base.$link_filename_clean)."','".$playlist2add."',NOW(),'active')");
				}
				else { // Existing playlist -> NEED TO CHECK
					$track_found = false;
					foreach($existing_tracks as $existing_track) {
						if ( $existing_track->filename_music == $link_base.$link_filename_clean ) { // Search track
							$track_found = true;
							$tracks_done[] = $existing_track->id_music;
							if ( $existing_track->fk_artist != $found_id || $existing_track->title_music != $title2add ) { // Track found - if something has change, update
								
								$query = "UPDATE ".$fp_musics_table." SET fk_artist=".$found_id.", title_music='".$title2add."' WHERE id_music=".$existing_track->id_music;
								$db->query($query);
								break;
							} else { break; }
						}
					}
					if (!$track_found) { // This a new track -> INSERT
						$db->query("INSERT INTO ".$fp_musics_table." (id_music, fk_artist, title_music, filename_music, playlist_music, date_music, active_music) VALUES (NULL,".$found_id.",'".mysql_real_escape_string($title2add)."','".mysql_real_escape_string($link_base.$link_filename_clean)."','".$playlist2add."',NOW(),'active')");
						$tracks_done[] = $db->insert_id;
					}
				}
		}
		// If it was an existing playlist -> delete tracks that wasn't provided
		if ($playlist_exist) {
			foreach($existing_tracks as $existing_track) {
				if (!array_search($existing_track->id_music, $tracks_done)) { 
					$db->query("DELETE FROM ".$fp_musics_table." WHERE id_music=".$existing_track->id_music);
				}
			}
		}

		return true;		
	}	
?>