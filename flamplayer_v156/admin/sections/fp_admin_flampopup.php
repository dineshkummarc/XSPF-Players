<?php
/************************************************************************************************
 * FLAM Player ADMINISTRATION - Section 2: Preview filter in popup                              *
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

// Url Racine de FLAM Player
if (dirname(dirname(dirname($_SERVER['PHP_SELF']))) == "/" || dirname(dirname(dirname($_SERVER['PHP_SELF']))) == "\\") {
	$fp_root_url = "http://".$_SERVER['HTTP_HOST']."/"; } // FLAM Player installed on the root of the HTTP server
else {
	$fp_root_url = "http://".$_SERVER['HTTP_HOST'].dirname(dirname(dirname($_SERVER['PHP_SELF'])))."/"; } // FLAM Player installed in a subdirectory of the HTTP server


$langage = $_GET['lang'];
$playlist = $_GET['p'];
$author = $_GET['a'];
$order = $_GET['o'];
$direction = $_GET['d'];

$flashVars =	"\"fp_root_url=".$fp_root_url.
					"&ovr_langage=".$langage.
					"&ovr_playlist=".urlencode($playlist).
					"&ovr_author=".$author.
					"&ovr_order=".$order.
					"&ovr_order_direction=".$direction.
					"\"";
?>
<HTML>
<HEAD>
<meta http-equiv=Content-Type content="text/html;  charset=ISO-8859-1">
<TITLE>FLAM Player - FILTER TEST</TITLE>

<style type="text/css" media="all">
h5, h4, h3, h2 { 
	margin: 0px 0px 0px 0px;
	font-size: 9px;
	font-weight: normal;
	display: inline;
}

h2 { 
	color: #383838;
	font-size: 10px;
}
h3 { color: #FFCC66; }
h4 { color: #FFDF9A; }
h5 { color: #B0B0B0; }

#flashvars {
	color: #F0F0F0;
	width: 300px;
	font-family: Verdana, Geneva, Arial, Helvetica, sans-serif;
	font-size: 9px;
	overflow: hidden;
	line-height: 12px;
}
</style>

</HEAD>
<BODY leftmargin="5" topmargin="5" bgcolor="#898989">

<table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
<tr>
<td valign="top">
		<table width="300" height="315" border="0" align="center" cellpadding="0" cellspacing="0">
              	<tr>
               	<td>
							<object classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000"
				 				codebase="http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=6,0,0,0"
				 				width="300" 
				 				height="315">
				                		<param name=movie value="../../flam-player.swf">
				                		<param name=flashVars value=<?php echo $flashVars; ?> >
				                		<param name=menu value=false>
				                		<param name=quality value=best>
				                		<param name=wmode value=transparent>
				                		<param name=bgcolor value=#898989>
				                	
				                	<embed src="../../flam-player.swf"
				                		flashVars=<?php echo $flashVars; ?>
				                		menu=false
				                		quality=best
				                		wmode=transparent
				                		bgcolor=#898989
				                		width="300"
				                		height="315"
				 							type="application/x-shockwave-flash"
							 				pluginspage="http://www.macromedia.com/go/getflashplayer">
				 						</embed>
							</object>
               	</td>
   				</tr>
					<tr height="5"><td></td></tr>
					<tr>
						<td>
							<div id="flashvars">
								<h2>> flashVars ---------------------------------------------</h2><br>
								<h3>&</h3><h4>fp_root_url<h5>=</h5></h4><?php echo wordwrap($fp_root_url, 40, "\n", 1); ?><br>
								<h3>&</h3><h4>ovr_langage<h5>=</h5></h4><?php echo $langage; ?><br>
								<h3>&</h3><h4>ovr_playlist<h5>=</h5></h4><?php echo $playlist; ?><br>
								<h3>&</h3><h4>ovr_author<h5>=</h5></h4><?php echo $author; ?><br>
								<h3>&</h3><h4>ovr_order<h5>=</h5></h4><?php echo $order; ?><br>
								<h3>&</h3><h4>ovr_order_direction<h5>=</h5></h4><?php echo $direction; ?>
							</div>
						</td>
					</tr>
		</table>
</td>
</tr>
</table>
</BODY>
</HTML>