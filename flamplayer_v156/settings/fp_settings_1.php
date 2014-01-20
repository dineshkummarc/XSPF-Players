<?php
/************************************************************************************************
 * FLAM Player SETTINGS - Basic Databse / User / Password configuration                         *
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
// MySQL Connection parameters for FLAM Player
//----------------------------------------------------------------------------------------------------------------------------
# Type="MYSQL"
# HTTP="true"

// REQUIRED !!!
// Enter here the setting for your MySQL Database connection : Hostname / Database name / Username / Password
// OBLIGATOIRE !!!
// Entrez ici les paramètres pour la connexion à la base de données MySQL : Nom d'hôte / Nom de la base / Utilisateur / Mot de passe

$hostname_fp_mysql = "localhost";
$database_fp_mysql = "database_name";
$username_fp_mysql = "database_username";
$password_fp_mysql = "database_password";

//----------------------------------------------------------------------------------------------------------------------------
// FLAM Player Admin settings
//----------------------------------------------------------------------------------------------------------------------------
// REQUIRED !!!
// Enter here the Username / Password / Language for the FLAM Player Administration
// OBLIGATOIRE !!!
// Entrez ici les Nom d'utilisateur / Mot de passe / Langue pour l'administration de FLAM Player

// Enter here "yes" or "no" to enable / disable login - Entrez ici "yes" ou "no" pour activer / désactiver l'authentification
$login_enable = "yes";
// Choose user / password - Choisissez un nom d'utilisateur / mot de passe
$admin_user = "admin";
$admin_pass = "admin";
// Language can only be "fr" or "en" - La langue ne peut être que "fr" ou "en"
$admin_default_lang = "en";
// Demo mode ("yes" / "no"), enable or disable limited version - Mode démo ("yes" / "no"), active ou désactive une version bridée
$demo_mode = "no";

//----------------------------------------------------------------------------------------------------------------------------
// FLAM Player table names
//----------------------------------------------------------------------------------------------------------------------------
// OPTIONAL
// These are the two tables that will be created in your database, you can change their names
// FACULTATIF
// Ce sont les deux tables qui seront créées dans votre base de données, vous pouvez changer leurs noms

// Musics table name / Nom de la table des musiques
$fp_musics_table = "flamplayer_musics";
// Artists table name / Nom de la table des artistes
$fp_artists_table = "flamplayer_artists";

?>
