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


// Customizer

?>

<!-- -->
<link rel='stylesheet' href='admin.css' type='text/css' />

<div class="wrap">
	<h2>Players
		<div id="thinker" class="thinker"></div>
	</h2>
	<br />
	<table width="100%" border="0" cellspacing="0" cellpadding="0">
		<tr>
			<td width="48%" align="left" valign="top"><div id="playerTableDiv"> 
					<!-- PLAYER LIST --> 
				</div>
				<table width="100%" border="0" cellspacing="0" cellpadding="0">
					<tr>
						<td width="90%" nowrap="nowrap" valign="middle"><div class="actionBox" id="actionBoxDiv">Starting Up...</div></td>
						<td width="10%" align="right" valign="middle"><div class="submit">
								<input type="button" value="Add New Player" onclick="RAVE.startNewPlayer()" />
						</div></td>
					</tr>
				</table>
				<div id="customizer" style="visibility:visible;clear:both;">
					<table width="100%" border="0" cellspacing="0" cellpadding="0">
						<tr>
							<td width="83%" valign="baseline"><div id="editPlayerTitle"></div></td>
							<td width="17%" valign="baseline"><div class="submit">
									<input name="saveButton" type="button" id="saveButton" value="Save Player" onclick="RAVE.savePlayer();" />
							</div></td>
						</tr>
					</table>
					<form name="form1" id="form1" >
						<table width="100%" border="0" cellspacing="0" cellpadding="0">
							<tr>
								<td width="90%" nowrap="nowrap"><h3 class="nav-tab-wrapper"> <a id="rave_page_tab_setup" class = "nav-tab nav-tab-active" href="javascript:RAVE.doPlayerTab('setup');" >Setup</a> <a id="rave_page_tab_skin" class = "nav-tab" href="javascript:RAVE.doPlayerTab('skin');">Appearance</a> <a id="rave_page_tab_options" class = "nav-tab" href="javascript:RAVE.doPlayerTab('options');">Options</a> </h3></td>
							</tr>
						</table>
						<div class="rave_inline_page_wrapper"> 
							
							<!--
							
							
						SETUP
							
								 
						-->
							<div class="rave_inline_page" id="rave_page_setup">
								<h3>Player Name	</h3>
<div class="playlistTypeBox">
	<input name="playerID" type="text" id="playerID" value="player1" class="textLineURL" onblur="RAVE.updatePlayerNameDisplay();"/>
</div>
<p>&nbsp;</p>
<h3>Playlist	</h3>
<div class="playlistTypeBox">
	<p>
		<select name="playlistType" id="playlistType" onchange="RAVE.changePlaylistType();">
			<option value="wp_auto" selected="selected">Wordpress Automatic</option>
			<option value="wp_plist">Wordpress Playlist</option>
			<option value="url">Playlist URL</option>
			<option value="file">Media File URL(s)</option>
		</select>
</p>
</div>
<div class="playlistTypeBox" id="playlistType_wp_auto">
	<p>
		<select name="playlist_wp_auto" id="playlist_wp_auto" onchange="RAVE.updatePreview();">
			<option value="auto">All Audio + Video</option>
			<option value="audio">All Audio</option>
			<option value="video">All Video</option>
	</select>
	</p>
	<p><b>All Audio&nbsp;+ Video</b> will display all  audio and video you've uploaded to your Media Libray.<b> All Audio </b> will  display all audio files in you Media Library. <b>All Video</b> will only display all video files in you Media Library.	</p>
</div>
								<div class="playlistTypeBox" id="playlistType_wp_plist">
									<p>
										<select name="playlist_wp_plist" id="playlist_wp_plist" onchange="RAVE.updatePreview();">
											<option value="" selected="selected">-- Select --</option>
										</select>
									</p>
									<p>&nbsp;</p>
								</div>
								<div class="playlistTypeBox" id="playlistType_url">
									<p>Enter the URL to an XML, TXT, RSS / Podcast, or rave.php file:									</p>
									<p>
										<input name="playlist_url" type="text" class="textLine100" id="playlist_url" /><div class="submit">
							<input type="button" value="Test" onclick="RAVE.updatePreview()" />
						</div>
									</p>
								</div>
								<div class="playlistTypeBox" id="playlistType_file">
									<p>Enter each media file on a seperate line, or copy and paste XML data into the box:									</p>
									<p>
										<textarea name="textarea" cols="45" rows="5" id="playlist_file" class="textAreaPlaylist" wrap="off"></textarea><div class="submit">
							<input type="button" value="Test" onclick="RAVE.updatePreview()" />
						</div>
									</p>
									<p>&nbsp; </p>
								</div>
							</div>
							
							<!--
							
							
						SKIN
							
								 
						-->
							<div class="rave_inline_page" id="rave_page_skin">
								<h3><a href="http://www.wimpyplayer.com/docs/rave/api/size.html" target="helpWindow">Player Size</a></h3>
								<table width="206" border="0" cellpadding="0" cellspacing="0">
									<tr>
										<td width="22" align="left" valign="middle"><input name="set_size" id="set_size" type="radio" value="auto" checked="checked" /></td>
										<td width="108" align="left" valign="middle">Auto</td>
										<td width="34" align="left" valign="middle">width</td>
										<td width="42" align="left" valign="middle"><input name="wimpyWidth" type="text" id="wimpyWidth" value="250" class="textLineValSmall" /></td>
									</tr>
									<tr>
										<td align="left" valign="middle"><input name="set_size" id="set_size2" type="radio" value="man" /></td>
										<td align="left" valign="middle">Manual</td>
										<td align="left" valign="middle">height</td>
										<td align="left" valign="middle"><input name="wimpyHeight" type="text" id="wimpyHeight" value="290" class="textLineValSmall" /></td>
									</tr>
								</table>
								<p>&nbsp;</p>
								<h3>Background</h3>
								<p>Color:
									<input name="bkgdColor" type="text" id="bkgdColor" value="#6A7A95" class="textLineVal"/>
									<a href="javascript:RAVE.ColorPickerOpen()">choose</a></p>
								<div id="divColorPicker"> 
									<!-- COLOR PICKER --> 
								</div>
								<p>
									<input name="tptBkgd" type="checkbox" id="tptBkgd" value="yes" />
									Transparent</p>
								<p>&nbsp;</p>
								<h3>Skin </h3>
								<br />
								<div id="divSkinDropdown" class="skin_dropdown"> 
									<!-- SKIN DROP DOWN --> 
								</div>
								<div id="divSkinPreview"> 
									<!-- SKIN PREVIEW --> 
								</div>
								<input name="wimpySkin" type="text" id="wimpySkin" value="" class="textLineURL" />
								<a href="javascript:RAVE.setSkinFromURL();">reload</a>
								<p>&nbsp;</p>
							</div>
							<!--
						
						
						OPTIONS
						
						
						-->
							
							<div class="rave_inline_page" id="rave_page_options">
								<table width="100%" border="0" cellpadding="0" cellspacing="0" class="tableA">
									<tr bgcolor="#FFFFFF">
										<td width="6%" height="5%" align="left" valign="middle" class="tableCells">&nbsp;</td>
										<td width="94%" align="left" valign="middle" nowrap="nowrap" class="tableCells"><a href="http://www.wimpyplayer.com/docs/rave/api/theVolume.html" target="helpWindow">Start up volume</a>:
											<input name="theVolume" type="text" id="theVolume" value="100" class="textLineValSmall" maxlength="3" /></td>
									</tr>
									<tr bgcolor="#F4F9FF">
										<td height="5%" align="left" valign="middle" class="tableCells"><input name="loopTrack" type="checkbox" id="loopTrack" onclick="RAVE.checkButtonState('loopTrack')" value="off" /></td>
										<td align="left" valign="middle" nowrap="nowrap" class="tableCells"><a href="http://www.wimpyplayer.com/docs/rave/api/loopTrack.html" target="helpWindow">Turn on &quot;Loop Track&quot; button</a></td>
									</tr>
									<tr bgcolor="#FFFFFF">
										<td height="5%" align="left" valign="middle" class="tableCells"><input name="randomPlayback" type="checkbox" id="randomPlayback" onclick="RAVE.checkButtonState('randomPlayback');" value="off" /></td>
										<td align="left" valign="middle" nowrap="nowrap" class="tableCells"><a href="http://www.wimpyplayer.com/docs/rave/api/randomPlayback.html" target="helpWindow">Turn on &quot;Random&quot; button</a></td>
									</tr>
									<tr bgcolor="#F4F9FF">
										<td height="5%" align="left" valign="middle" class="tableCells"><input name="repeatPlaylist" type="checkbox" id="repeatPlaylist" value="off" /></td>
										<td align="left" valign="middle" nowrap="nowrap" class="tableCells"><a href="http://www.wimpyplayer.com/docs/rave/api/repeatPlaylist.html" target="helpWindow">Turn on &quot;Repeat Playlist&quot; button</a></td>
									</tr>
									<tr bgcolor="#FFFFFF">
										<td height="5%" align="left" valign="middle" class="tableCells"><input name="randomOnLoad" type="checkbox" id="randomOnLoad" value="yes" /></td>
										<td align="left" valign="middle" nowrap="nowrap" class="tableCells"><a href="http://www.wimpyplayer.com/docs/rave/api/randomOnLoad.html" target="helpWindow">Select random track at startup</a></td>
									</tr>
									<tr bgcolor="#F4F9FF">
										<td height="5%" align="left" valign="middle" class="tableCells"><input name="startPlayingOnload" type="checkbox" id="startPlayingOnload" value="yes" /></td>
										<td align="left" valign="middle" nowrap="nowrap" class="tableCells"><a href="http://www.wimpyplayer.com/docs/rave/api/startPlayingOnload.html" target="helpWindow">Start playing immediately</a></td>
									</tr>
									<tr bgcolor="#F4F9FF">
										<td height="5%" align="left" valign="middle" class="tableCells"><input name="autoAdvance" type="checkbox" id="autoAdvance" value="yes" /></td>
										<td align="left" valign="middle" nowrap="nowrap" class="tableCells"><a href="http://www.wimpyplayer.com/docs/rave/api/autoAdvance.html" target="helpWindow">Auto advance to next track</a></td>
									</tr>
									<tr bgcolor="#FFFFFF">
										<td height="5%" align="left" valign="middle" class="tableCells"><input name="popUpHelp" type="checkbox" id="popUpHelp" value="yes" /></td>
										<td align="left" valign="middle" nowrap="nowrap" class="tableCells"><a href="http://www.wimpyplayer.com/docs/rave/api/popUpHelp.html" target="helpWindow">Pop Up help enabled </a></td>
									</tr>
									<tr bgcolor="#FFFFFF">
										<td height="5%" align="left" valign="middle" class="tableCells"><input name="use_startOnTrack" type="checkbox" id="use_startOnTrack" value="yes" /></td>
										<td align="left" valign="middle" nowrap="nowrap" class="tableCells"><a href="http://www.wimpyplayer.com/docs/rave/api/startOnTrack.html" target="helpWindow">Play this track at startup</a>:
											<input name="startOnTrack" type="text" id="startOnTrack" value="4" class="textLineValSmall" maxlength="4" /></td>
									</tr>
									<tr bgcolor="#FFFFFF">
										<td height="5%" align="left" valign="middle" class="tableCells">&nbsp;</td>
										<td align="left" valign="middle" nowrap="nowrap" class="tableCells"><a href="http://www.wimpyplayer.com/docs/rave/api/infoDisplaySpeed.html" target="helpWindow">Info Scroller Speed</a>:
											<input name="infoDisplaySpeed" type="text" id="infoDisplaySpeed" value="3" class="textLineValSmall" /></td>
									</tr>
									<tr bgcolor="#F4F9FF">
										<td height="5%" align="left" valign="middle" class="tableCells">&nbsp;</td>
										<td align="left" valign="middle" nowrap="nowrap" class="tableCells"><a href="http://www.wimpyplayer.com/docs/rave/api/scrollFormat.html" target="helpWindow">Info Scroller Format</a>::
											<input name="scrollFormat" type="text" id="scrollFormat" value="1 - 2" class="textLineVal" /></td>
									</tr>
									<tr bgcolor="#FFFFFF">
										<td align="left" valign="middle" class="tableCells">&nbsp;</td>
										<td align="left" valign="middle" class="tableCells"><a href="http://www.wimpyplayer.com/docs/rave/api/timeFormat.html" target="helpWindow">Time Display Format</a>:
											<input name="timeFormat" type="text" id="timeFormat" value="1" class="textLineVal" /></td>
									</tr>
									<tr bgcolor="#FFFFFF">
										<td height="5%" align="left" valign="middle" class="tableCells">&nbsp;</td>
										<td align="left" valign="middle" nowrap="nowrap" class="tableCells"><table width="100%" border="0" cellspacing="0" cellpadding="0">
												<tr>
													<td width="27%"><a href="http://www.wimpyplayer.com/docs/rave/api/sortField.html" target="helpWindow">Sort Playlist By</a>: </td>
													<td width="73%"><select name="sortField" id="sortField" class="dropdownList">
															<option value="none" selected="selected">Don't Sort (default)</option>
															<option value="title">Title</option>
															<option value="filename">File Name</option>
															<option value="date">Date</option>
														</select></td>
												</tr>
												<tr>
													<td>&nbsp;</td>
													<td><input name="sortOrder" type="radio" id="sortOrder" value="asc" checked="checked" />
														Ascending (A - Z)<br />
														<input name="sortOrder" type="radio" id="sortOrder" value="des" />
														Descending (Z - A)</td>
												</tr>
											</table></td>
									</tr>
									<tr bgcolor="#FFFFFF">
										<td height="5%" align="left" valign="middle" class="tableCells">&nbsp;</td>
										<td align="left" valign="middle" nowrap="nowrap" class="tableCells"><a href="http://www.wimpyplayer.com/docs/rave/api/fsMode.html" target="helpWindow">Fullscreen Button Action</a>::
											<select name="fsMode" id="fsMode" onchange="RAVE.changeSortField()" class="dropdownList">
												<option value="detach">Detach Player</option>
												<option value="fullscreen" selected="selected">Fullscreen</option>
											</select></td>
									</tr>
									<tr bgcolor="#FFFFFF">
										<td align="left" valign="middle" class="tableCells">&nbsp;</td>
										<td align="left" valign="middle" class="tableCells"><a href="http://www.wimpyplayer.com/docs/rave/api/setAspectRatio.html" target="helpWindow">Video Aspect Ratio</a>:</span>
											<select name="setAspectRatio" class="dropdownList" id="setAspectRatio" onchange="RAVE.changeSortField()">
												<option value="maintain" selected="selected">Maintain Dimensions</option>
												<option value="fit">Fit To Window</option>
											</select></td>
									</tr>
								</table>
								<table width="100%" border="0" cellpadding="0" cellspacing="0" class="tableA">
									<tr bgcolor="#FFFFFF">
										<td width="4%" height="5%" valign="middle" class="tableCells">&nbsp;</td>
										<td width="96%" align="left" valign="middle" nowrap="nowrap" class="tableCells"><a href="http://www.wimpyplayer.com/docs/rave/api/infoButtonAction.html" target="helpWindow">Info Button Action</a>:
											<select name="infoButtonAction" id="infoButtonAction" onchange="RAVE.changeSortField()" class="dropdownList" >
												<option value="link">Link to Page</option>
												<option value="info">Show Info</option>
											</select>
											<br />
											</p></td>
									</tr>
									<tr bgcolor="#F4F9FF">
										<td height="5%" valign="middle" class="tableCells">&nbsp;</td>
										<td align="left" valign="middle" nowrap="nowrap" class="tableCells"><a href="http://www.wimpyplayer.com/docs/rave/api/clickWindowAction.html" target="helpWindow">Click Image / Video Window Action</a>:
											<select name="clickWindowAction" id="clickWindowAction" class="dropdownList">
												<option value="playPause" selected="selected">Play / Pause</option>
												<option value="playPauseNoIcon">Play / Pause (no icon)</option>
												<option value="controls">Show Controls</option>
												<option value="info">Show Info</option>
												<option value="link">Link to Page</option>
												<option value="nothing">Do Nothing</option>
											</select></td>
									</tr>
									<tr bgcolor="#FFFFFF">
										<td height="5%" valign="middle" class="tableCells">&nbsp;</td>
										<td align="left" valign="middle" nowrap="nowrap" class="tableCells"><a href="http://www.wimpyplayer.com/docs/rave/api/linkToWindow.html" target="helpWindow">External Link-to Window:
											<input name="linkToWindow" type="text" id="linkToWindow" value="_blank" class="textLineVal" />
											</a></td>
									</tr>
									<tr bgcolor="#F4F9FF">
										<td height="5%" valign="top" class="tableCells"><input name="use_onTrackComplete" type="checkbox" id="use_onTrackComplete" value="yes" /></td>
										<td align="left" valign="middle" class="tableCells"><a href="http://www.wimpyplayer.com/docs/rave/api/onTrackComplete.html" target="helpWindow">On Track Complete</a>
											<select name="onTrackComplete" id="onTrackComplete" onchange="RAVE.changeSortField()" class="dropdownList">
												<option value="gotoURL" selected="selected">Go to Page</option>
												<option value="loadClip">Load Movie</option>
											</select>
											<br />
											<input name="onTrackCompleteURL" type="text" id="onTrackCompleteURL" value="" class="textLineURL" /></td>
									</tr>
									<tr bgcolor="#FFFFFF">
										<td valign="top" class="tableCells"><input name="use_plugPlaylist" type="checkbox" id="use_plugPlaylist" value="yes" /></td>
										<td align="left" valign="top" class="tableCells"><a href="http://www.wimpyplayer.com/docs/rave/api/plugPlaylist.html" target="helpWindow">Plug Playlist:</a><br />
											<input name="plugPlaylist" type="text" id="plugPlaylist" value="" class="textLineURL"/>
											<br />
											Plug Every:
											<input name="plugEvery" type="text" id="plugEvery" value="2" size="3" /></td>
									</tr>
									<tr bgcolor="#F4F9FF">
										<td height="5%" valign="top" class="tableCells"><input name="use_startupLogo" type="checkbox" id="use_startupLogo" value="yes" /></td>
										<td align="left" valign="top" nowrap="nowrap" class="tableCells"><a href="http://www.wimpyplayer.com/docs/rave/api/startupLogo.html" target="helpWindow">Startup Logo</a>: <br />
											<input name="startupLogo" type="text" id="startupLogo" value="" class="textLineURL" /></td>
									</tr>
									<tr bgcolor="#FFFFFF">
										<td height="5%" valign="top" class="tableCells"><input name="use_defaultImage" type="checkbox" id="use_defaultImage" value="yes" /></td>
										<td align="left" valign="top" nowrap="nowrap" class="tableCells"><a href="http://www.wimpyplayer.com/docs/rave/api/defaultImage.html" target="helpWindow">Default Cover Art</a>:<br />
											<input name="defaultImage" type="text" id="defaultImage" value="" class="textLineURL" /></td>
									</tr>
									<tr bgcolor="#FFFFFF">
										<td height="5%" valign="top" class="tableCells"><input name="use_videoOverlay" type="checkbox" id="use_videoOverlay" value="yes" /></td>
										<td align="left" valign="top" nowrap="nowrap" class="tableCells"><a href="http://www.wimpyplayer.com/docs/rave/api/videoOverlay.html" target="helpWindow">Video Overlay</a>:<br />
											<input name="videoOverlay" type="text" id="videoOverlay" value="" class="textLineURL" /></td>
									</tr>
									<tr bgcolor="#F4F9FF">
										<td valign="middle" class="tableCells"><input name="use_limitPlaytime" type="checkbox" id="use_limitPlaytime" value="yes" /></td>
										<td align="left" valign="middle" class="tableCells"><a href="http://www.wimpyplayer.com/docs/rave/api/limitPlaytime.html" target="helpWindow">Limit track playback time</a> to&nbsp;
											<input name="limitPlaytime" type="text" id="limitPlaytime" value="4" size="4" maxlength="4" />
											seconds </td>
									</tr>
									<!-- memory -->
									<tr bgcolor="#FFFFFF">
										<td height="5%" align="left" valign="middle" class="tableCells"><input name="use_resume" type="checkbox" id="use_resume" value="yes" /></td>
										<td align="left" valign="middle" nowrap="nowrap" class="tableCells"><a href="http://www.wimpyplayer.com/docs/rave/api/resume.html" target="helpWindow">Enable Memory</a>:
											<input name="resume" type="text" id="resume" value="4" class="textLineValSmall" maxlength="4" /></td>
									</tr>
									<tr bgcolor="#F4F9FF">
										<td height="5%" valign="middle" class="tableCells">&nbsp;</td>
										<td align="left" valign="middle" nowrap="nowrap" class="tableCells"><a href="http://www.wimpyplayer.com/docs/rave/api/bufferSeconds.html" target="helpWindow">Buffer Seconds</a>:
											<input name="bufferSeconds" type="text" id="bufferSeconds" value="10" class="textLineValSmall" /></td>
									</tr>
									<tr bgcolor="#FFFFFF">
										<td height="0%" valign="middle" class="tableCells"><input name="enableDownloads" type="checkbox" id="enableDownloads" value="yes" /></td>
										<td align="left" valign="middle" nowrap="nowrap" class="tableCells"><a href="http://www.wimpyplayer.com/docs/rave/api/enableDownloads.html" target="helpWindow">Enable Downloads</a></td>
									</tr>
								</table>
							</div>
							<p>&nbsp;</p>
							<p>&nbsp;</p>
							<p>&nbsp;</p>
							
							<!-- end page_wrapper block --> 
						</div>
					</form>
					
					<!-- end customizer block --> 
				</div></td>
			<td width="52%" align="center" valign="top"><div id="playerDisplayName"> 
					<!-- PLAYER NAME --> 
				</div>
				<table width="200" height="200" border="0" cellpadding="0" cellspacing="20" id="previewWindow">
					<tr>
						<td><div id="wimpyRavePreview"> 
								<!-- PREVIEW PLAYER--> 
							</div></td>
					</tr>
					<tr>
						<td align="left" valign="top">
						<div id="displayShortCode" class="shortCodeInfoBox"></div>
						<p>&nbsp;</p>
						<div class="submit">
							<input type="button" value="Refresh Preview" onclick="RAVE.updatePreview()" />
						</div></td>
					</tr>
				</table></td>
		</tr>
	</table>
	<p>&nbsp;</p>
	<p>&nbsp;</p>
	<p>&nbsp;</p>
	
	<!-- end main "wrap" block --> 
</div>
<p>&nbsp;</p>
<p>&nbsp;</p>
<p>&nbsp;</p>
<p>&nbsp;</p>
<p>&nbsp;</p>
<script language="JavaScript" type="text/javascript">

//<![CDATA[

<?php print $this->conf_to_js(); ?>

jQuery(document).ready(function(){
  RAVE.init("player");
});

//]]>
</script> 
