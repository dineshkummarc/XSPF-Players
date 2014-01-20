<?php if ($master_page == true) { ?>

<?php
/************************************************************************************************
 * FLAM Player ADMINISTRATION - Section 6                                                       *
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

/*************************************************
 * This is the Section 6 : Debug infos           *
 *************************************************/
// ADJUST SETTINGS Section
//	Mode 100 : Waiting for a Task

// INTEGRATE FLAM PLAYER Section
// Mode 200 : Waiting for a Task

// ************ ADJUST SETTINGS ************************************************************************************

// ************ NORMAL MODE ****************************************************************************************
?>
<div id="block_init">
<style type="text/css" media="all">
#block_init .e { font-size: 11px; color: #999999; font-weight: bold; background-color: #444444; }
#block_init .v { font-size: 10px; color: #DDDDDD; background-color: #3c3c3c;}
#block_init th { font-size: 11px; background-color: #666666; }
#block_init h1 { color: #ffffff; font-size: 12px; }
#block_init h2 { color: #ff6633; font-size: 16px;}
#block_init img { display: none; }
#block_init table { width: 100%; }
</style>

<?php 

ob_start();
   
   phpinfo();
   $php_info .= ob_get_contents();
       
ob_end_clean();

$php_info    = str_replace(" width=\"600\"", " width=\"786\"", $php_info);
$php_info    = str_replace("</body></html>", "", $php_info);

$php_info    = str_replace(";", "; ", $php_info);
$php_info    = str_replace(",", ", ", $php_info);

$offset          = strpos($php_info, "<table");

print substr($php_info, $offset);

?>
</div>
<?php } else { echo "<font color=\"#FF0000\" size=\"7\">Forbidden</font>"; } ?>