<?php
/************************************************************************************************
 * FLAM Player ADMINISTRATION - Update Playlist without admin module - EXAMPLE                  *
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

// Include FLAM Player required files
	require_once('includes/fp_admin_functions.php');
	require_once('../settings/fp_settings_1.php');
	require_once('includes/ez_sql.php');

// Example table that the function must receive
//
// Table structure :
//
// Table_Name_Of_Your_Choice [0 -> Track quantity] ['artist_name']
//                                                 ['artist_email']
//                                                 ['artist_website']
//                                                 ['music_title']
//                                                 ['music_link']
//

// Example track data #1
$tracks_array[0] = array( 	"artist_name" => "John Doe",
							"artist_email" => "johndoe@test.com",
							"artist_website" => "http://www.johndoesite.com",
							"music_title" => "The John Doe theme",
							"music_link" => "http://www.johndoe.com/musics/John Doe - Theme 01.mp3" );
// Example track data #2							
$tracks_array[1] = array( 	"artist_name" => "Just4Test",
							"artist_email" => "just4test@test.com",
							"artist_website" => "www.just4testsite.com",
							"music_title" => "The just4test theme",
							"music_link" => "http://www.just4testsite.com/musics/just4test - Theme 01.mp3" );
// Example track data #3
$tracks_array[2] = array( 	"artist_name" => "ALastOne",
							"artist_email" => "alastone@test.com",
							"artist_website" => "http://www.alastone.com",
							"music_title" => "The alastone theme",
							"music_link" => "http://www.alastone.com/musics/alastone - Theme 01.mp3" );

// Example track data #4
$tracks_array[3] = array( 	"artist_name" => "HasNoEmail&Website",
							"artist_email" => "",
							"artist_website" => "",
							"music_title" => "HasNoEmail&Website theme",
							"music_link" => "http://www.HasNoEmailWebsite.com/musics/HasNoEmailWebsite - Theme 01.mp3" );

// Example track data #5
$tracks_array[4] = array( 	"music_link" => "http://www.onlythelink.com/musics/onlythelink - Theme 01.mp3" );

// Example track data #6
$tracks_array[5] = array( 	"music_title" => "Not an external file",	
							"music_link" => "local file in MUSICS_REP.mp3" );
							

// Update the database with this new playlist

// For securiry reasons, the main update function is commented, uncomment the following line if you want to try this demo
// Note the demo links don't exists in reality, so if you can't ear anything with the player, that's normal :)

	// flam_update_playlist ( "playlist_test2", $tracks_array );

?>