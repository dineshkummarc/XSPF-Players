<?php


///////////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////
//                                                      ///////
//          Rave Player Plugin for Wordpress            ///////
//                   Version 1.0.14                     ///////
//                                                      ///////
//        Available at http://www.wimpyplayer.com       ///////
//            Copyright 2002-2012 Plaino LLC            ///////
//                                                      ///////
///////////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////
//                                                      ///////
//                USE AT YOUR OWN RISK                  ///////
//                                                      ///////
///////////////////////////////////////////////////////////////


// Playlister

?>

<!--  
<link rel='stylesheet' href='customize.css' type='text/css' /> 
<link rel='stylesheet' href='<?php print $RavePlugin->$CONF['path_url_plugin_folder'] ?>customize.css' type='text/css' />

<script type="text/javascript" src="<?php print $CONF['path_url_plugin_folder'] ?>wimpy-ajax-hook.js"></script>
<script type="text/javascript" src="<?php print $CONF['path_url_plugin_folder'] ?>jquery.dragsort-0.4.2.min.js"></script>
-->

<div class="wrap">
	<h2>Playlists</h2> <br />
	
	<table width="100%" border="0" cellspacing="0" cellpadding="0">
		<tr>
			<td width="45%" align="left" valign="top"><div id="playlistTableDiv"> 
					<!-- playlist list goes here --> 
				</div>
				<table width="100%" border="0" cellspacing="0" cellpadding="0">
					<tr>
						<td width="90%" nowrap="nowrap" valign="middle"><div class="actionBox" id="actionBoxDiv">Starting Up...</div></td>
						<td width="10%" align="right" valign="middle"><div class="submit">
								<input type="button" value="Add New Playlist" onclick="RAVE.startMakingPlaylist()" />
							</div></td>
					</tr>
				</table></td>
			<td width="55%" align="center" valign="middle">&nbsp;</td>
		</tr>
	</table>

	<div id="customizer" style="visibility:visible;clear:both;">
	<!-- START CUSTOMIZER -->
		<form action="<?php print THIS_URI ?>" method="post" name="form1" id="form1" >
			<table width="100%" border="0" cellpadding="0" cellspacing="0">
				<tr>
					<td width="46%" align="left" valign="top"><h2>Playlist ID</h2>
						<table width="100%" border="0" cellspacing="0" cellpadding="0">
							<tr>
								<td width="75%"><input name="playlist_make_name" type="text" class="textLineURL" id="playlist_make_name" value="playlist1" /></td>
								<td width="25%" align="right"><div class="submit">
										<input name="playlist_make_save" type="button" class="bigButton" id="playlist_make_save" value="Save Playlist" onclick="RAVE.savePlaylist();"/>
									</div></td>
							</tr>
						</table>
						<ul class="playlistListWrapperEditing" id="playlist_editing">
							<!-- EDIT PLAYLIST GOES HERE -->
						</ul>
						<p align="left">Drag and drop to re-order your playlist.</p></td>
					<td width="4%" align="left" valign="top" nowrap="nowrap">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
					<td width="50%" align="left" valign="top"><h2><a href="javascript:RAVE.refreshMediaLibrary();"><img src="<?php print $CONF['path_url_plugin_folder'] ?>images/refresh.png" width="19" height="20" border="0" align="absmiddle" /></a> Available Files
							<div id="thinker" class="thinker"></div>
						</h2>
						<ul class="playlistListWrapperSource" id="playlist_source">
							<!--
										<div class="playlistItem"><a href="javascript:add();">add</a> List item</div>
										<div class="playlistItem">+ List item </div>
										-->
						</ul>
						<p>&nbsp;</p></td>
				</tr>
			</table>
			<p>&nbsp;</p>
		</form>
		
		<!-- end customizer block --> 
	</div>
<!-- END CUSTOMIZER -->










	
	<!-- end main "wrap" block --> 
</div>
<script language="JavaScript" type="text/javascript">

//<![CDATA[

<?php print $this->conf_to_js(); ?>

jQuery(document).ready(function(){
  RAVE.init("playlist");
  // RAVE.initPlaylistPage("<?php print $CONF['path_url_plugin_folder']; ?>");
});

//]]>

</script> 
