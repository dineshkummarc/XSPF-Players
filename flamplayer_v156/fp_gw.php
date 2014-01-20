<?php
/************************************************************************************************
 * FLAM Player - GateWay Script                                                                 *
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

//----------------------------------------------------------------------------------------------------------------------------
// Database connection file
//----------------------------------------------------------------------------------------------------------------------------
require_once('settings/fp_settings_1.php');
require_once('admin/includes/fp_admin_functions.php');

// Database connection
$fp_mysql = mysql_connect($hostname_fp_mysql, $username_fp_mysql, $password_fp_mysql) or die(mysql_error());
mysql_select_db($database_fp_mysql, $fp_mysql) or die('Could not select database.');

// Check for existence of the new $GLOBALS array, If its found get the raw wddx packet from the array or Else get it from the variable $HTTP_RAW_POST_DATA

if($GLOBALS['HTTP_RAW_POST_DATA']) {
        handleWDDX($GLOBALS['HTTP_RAW_POST_DATA']);
} 
elseif ($HTTP_RAW_POST_DATA) {
        handleWDDX($HTTP_RAW_POST_DATA);
}
else {
		handleWDDX(file_get_contents('php://input'));
}

//handleWDDX("<wddxPacket version=\"1.0\"><header /><data><struct><var name=\"parameters\"><struct><var name=\"order_direction\"><string>DESC</string></var><var name=\"order\"><string>date_music</string></var><var name=\"author\"><string>12</string></var><var name=\"playlist\"><string>toto</string></var><var name=\"fields\"><array length=\"3\"><string>id_music</string><string>name_artist</string><string>title_music</string></array></var></struct></var><var name=\"funcName\"><string>get_music_list</string></var></struct></data></wddxPacket>");
//handleWDDX("<wddxPacket version=\"1.0\"><header /><data><struct><var name=\"parameters\"><struct><var name=\"order_direction\"><string>DESC</string></var><var name=\"order\"><string>date_music</string></var><var name=\"fields\"><array length=\"3\"><string>id_music</string><string>name_artist</string><string>title_music</string></array></var></struct></var><var name=\"funcName\"><string>get_music_list</string></var></struct></data></wddxPacket>");
//handleWDDX("<wddxPacket version=\"1.0\"><header /><data><struct><var name=\"parameters\"><struct><var name=\"order_direction\"><string>DESC</string></var><var name=\"order\"><string>date_music</string></var><var name=\"playlist\"><string>default_playlist</string></var><var name=\"fields\"><array length=\"3\"><string>id_music</string><string>name_artist</string><string>title_music</string></array></var></struct></var><var name=\"funcName\"><string>get_music_list</string></var></struct></data></wddxPacket>");
//handleWDDX("<wddxPacket version=\"1.0\"><header /><data><struct><var name=\"parameters\"><struct><var name=\"id_music\"><string>201</string></var></struct></var><var name=\"funcName\"><string>get_music_details</string></var></struct></data></wddxPacket>");

//----------------------------------------------------------------------------------------------------------------------------
// Deserialize the wddx packet and run the function specified Passing the parameters from flash.
//----------------------------------------------------------------------------------------------------------------------------
function handleWDDX($arg) {
        $tempo = new XmlC();			// New object
		$tempo->Set_XML_data($arg);		// Deserialize in an array		
		$result = $tempo->obj_data;		// Get result
		$function_name = $result->wddxPacket[0]->data[0]->struct[0]->var[1]->string[0];		// Get function name
		
		if ($function_name == "get_music_list") { // Load parameters for get_music_list function

			foreach ($result->wddxPacket[0]->data[0]->struct[0]->var[0]->struct[0]->var as $parameter) {
				if ($parameter->name == "order_direction") {$function_parameters["order_direction"] = $parameter->string[0];}
				if ($parameter->name == "order") {$function_parameters["order"] = $parameter->string[0];}
				if ($parameter->name == "playlist") {$function_parameters["playlist"] = $parameter->string[0];}
				if ($parameter->name == "author") {$function_parameters["author"] = $parameter->string[0];}
				if ($parameter->name == "fields") {
					$function_parameters["fields"][0] = $parameter->array[0]->string[0];
					$function_parameters["fields"][1] = $parameter->array[0]->string[1];
					$function_parameters["fields"][2] = $parameter->array[0]->string[2];
				}
			}
		}
		
		if ($function_name == "get_music_details") { // Load parameters for get_music_list function
			$function_parameters["id_music"] = $result->wddxPacket[0]->data[0]->struct[0]->var[0]->struct[0]->var[0]->string[0];
		}
		
		$function_name($function_parameters);	// Launch function
}

//----------------------------------------------------------------------------------------------------------------------------
// Class that deserialise the XML packet in an array
//----------------------------------------------------------------------------------------------------------------------------
class XmlC
{
  var $xml_data;
  var $obj_data;
  var $pointer;

  function XmlC()
  {
  }

  function Set_xml_data( &$xml_data )
  {
   $this->index = 0;
   $this->pointer[] = &$this->obj_data;

   $this->xml_data = $xml_data;
   $this->xml_parser = xml_parser_create( "UTF-8" );

   xml_parser_set_option( $this->xml_parser, XML_OPTION_CASE_FOLDING, false );
   xml_set_object( $this->xml_parser, $this );
   xml_set_element_handler( $this->xml_parser, "_startElement", "_endElement");
   xml_set_character_data_handler( $this->xml_parser, "_cData" );

   xml_parse( $this->xml_parser, $this->xml_data, true );
   xml_parser_free( $this->xml_parser );
  }

  function _startElement( $parser, $tag, $attributeList )
  {
   foreach( $attributeList as $name => $value )
   {
     $value = $this->_cleanString( $value );
     $object->$name = $value;
   }
   eval( "\$this->pointer[\$this->index]->" . $tag . "[] = \$object;" );
   eval( "\$size = sizeof( \$this->pointer[\$this->index]->" . $tag . " );" );
   eval( "\$this->pointer[] = &\$this->pointer[\$this->index]->" . $tag . "[\$size-1];" );
   
   $this->index++;
  }

  function _endElement( $parser, $tag )
  {
   array_pop( $this->pointer );
   $this->index--;
  }

  function _cData( $parser, $data )
  {
   if( trim( $data ) )
   {
     $this->pointer[$this->index] = trim( $data );
   }
  }

  function _cleanString( $string )
  {
   return utf8_decode( trim( $string ) );
  }

}

//----------------------------------------------------------------------------------------------------------------------------
// Retrieves details of the selected music
//----------------------------------------------------------------------------------------------------------------------------
function get_music_details($args) {
	
	global $database_fp_mysql; // Connection variables (fp_settings.php)
	global $fp_mysql;
	global $fp_musics_table; // Tablenames variables (fp_settings.php)
	global $fp_artists_table;
		
	mysql_select_db($database_fp_mysql, $fp_mysql); // Database selection
	$query = "SELECT * FROM ".$fp_musics_table;
	$query .= " INNER JOIN ".$fp_artists_table." ON ".$fp_musics_table.".fk_artist = ".$fp_artists_table.".id_artist";
	$query .= " WHERE id_music = ".$args['id_music'];
	
	$result = mysql_query($query, $fp_mysql) or die(mysql_error());
	$row = mysql_fetch_assoc($result);
	$music = $row;
	
	// Try to reach the link
	if ( strlen(trim($music["filename_music"])) == 0 ) { $file_reachable = false; }
	else {

			$link_start = strtolower(substr($music["filename_music"], 0, 6));
			// If this is an external mp3 link
			if ($link_start == "http:/" || $link_start == "ftp://" || $link_start == "https:") {
				$link_filename = substr(strrchr($music["filename_music"],"/"), 1);
				$link_filename_url = rawurldecode(stripslashes($link_filename));
				$link_base = substr($music["filename_music"], 0, strlen($music["filename_music"]) - strlen($link_filename));

				if ( @fopen($link_base.rawurlencode($link_filename_url), "rb")) { @fclose($link_base.rawurlencode($link_filename_url)); $file_reachable = true;}
				else { $file_reachable = false; }				
			}
			// If it is a local mp3 file
			else {
				// Music location extraction from the XML settings file
				$musics_url = read_fp_setting( "settings/fp_settings_2.xml", 2, "fp_parameter", "URL" );
				$musics_local_path = read_fp_setting( "settings/fp_settings_2.xml", 14, "fp_parameter", "URL" );
				$musics_dir = $musics_local_path;
				
				if ( @fopen($musics_dir.$music["filename_music"], "rb")) { @fclose($musics_dir.$music["filename_music"]); $file_reachable = true;}
				else { $file_reachable = false; }				
			}
				


	}
	
	// If mp3 file is not reachable -> change music title
	if ($file_reachable == false) { $music["title_music"] = "fp_error_file_unavailable"; }

	// Simulate WDDX packet construction (no WDDX Library needed)
		// wddx_packet_start		
		$packet =  "<wddxPacket version='1.0'>".
						"<header/>".
						"<data>".
							"<struct>".
								"<var name='music'>".
									"<struct>";

		// wddx_add_vars
		$packet .= "<var name='id_music'><string>".$music["id_music"]."</string></var>";
		$packet .= "<var name='fk_artist'><string>".$music["fk_artist"]."</string></var>";
		$packet .= "<var name='title_music'><string>".rawurlencode($music["title_music"])."</string></var>";
		$packet .= "<var name='filename_music'><string>".rawurlencode($music["filename_music"])."</string></var>";
		$packet .= "<var name='playlist_music'><string>".rawurlencode($music["playlist_music"])."</string></var>";
		$packet .= "<var name='date_music'><string>".$music["date_music"]."</string></var>";
		$packet .= "<var name='active_music'><string>".$music["active_music"]."</string></var>";
		$packet .= "<var name='id_artist'><string>".$music["id_artist"]."</string></var>";
		$packet .= "<var name='name_artist'><string>".rawurlencode($music["name_artist"])."</string></var>";
		$packet .= "<var name='email_artist'><string>".rawurlencode($music["email_artist"])."</string></var>";
		$packet .= "<var name='website_artist'><string>".rawurlencode($music["website_artist"])."</string></var>";
					
		// wddx_packet_end							
		$packet .= "</struct></var></struct></data></wddxPacket>";

	print $packet;
}

//----------------------------------------------------------------------------------------------------------------------------
// Retrieves list of musics
//----------------------------------------------------------------------------------------------------------------------------
function get_music_list($args) {

	global $database_fp_mysql; // Connection variables (fp_settings.php)
	global $fp_mysql;
	global $fp_musics_table; // Tablenames variables (fp_settings.php)
	global $fp_artists_table;
		
	mysql_select_db($database_fp_mysql, $fp_mysql); // Database selection
	$query = "SELECT "; // Query base
	if (isset($args['fields'])) { $query .= implode(",", $args['fields']);} else { $query .= "*"; } // Query Fields if defined else *
	$query .= " FROM ".$fp_musics_table; // From musics table
	$query .= " INNER JOIN ".$fp_artists_table." ON ".$fp_musics_table.".fk_artist = ".$fp_artists_table.".id_artist"; // Join Musics & Artists tables to retrieve artist name
	$query .= " WHERE active_music = 'active'"; // Select only active musics
	if (isset($args['playlist'])) { $query .= " && playlist_music = '".$args['playlist']."'";} // Add playlist condition if defined
	if (isset($args['author'])) { $query .= " && fk_artist = '".$args['author']."'";} // Add author condition if defined
	if (isset($args['order'])) { $query .= " ORDER BY ".$args['order']." ".$args['order_direction'].",id_music ".$args['order_direction'];} // Add order if defined
	
	$result = mysql_query($query, $fp_mysql) or die(mysql_error()); // Query launching
	
   $musics = array();
   $i=0;
   while($row = mysql_fetch_assoc($result)) {
		if($i == 0) { $cNames = array_keys($row); }
		$i++;
		$out = array();
		foreach($row as $key => $val) { $out[] = $val; }
		array_push($musics, $out);
	}
   
	// Simulate WDDX packet construction (no WDDX Library needed)
		// wddx_packet_start
		$packet =  "<wddxPacket version='1.0'>".
						"<header/>".
						"<data>".
							"<struct>".
								"<var name='cNames'>".
									"<array length='3'>".
										"<string>id_music</string>".
										"<string>name_artist</string>".
										"<string>title_music</string>".
									"</array>".
								"</var>".
			
								"<var name='musics'>".
									"<array length='".count($musics)."'>";
		// wddx_add_vars
		foreach ($musics as $music) {
			$packet .= "<array length='3'>";
				$packet .= "<string>".$music[0]."</string>";
				$packet .= "<string>".rawurlencode($music[1])."</string>";
				$packet .= "<string>".rawurlencode($music[2])."</string>";
			$packet .= "</array>";
		}
		
		// wddx_packet_end							
		$packet .= "</array></array></var></struct></data></wddxPacket>";
		
		print $packet;
}
?>