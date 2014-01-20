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




// Register




?>

<!-- -->
<link rel='stylesheet' href='admin.css' type='text/css' />

<div class="wrap">
	<table width="100%" border="0" cellspacing="40" cellpadding="0">
		<tr>
			<td width="56%" align="left" valign="top"><h2>Rave Player plugin for Wordpress</h2>
			<p>Rave is a unique internet-based media player, which allows you to play both audio and video content directly within a web page.</p>
			<p>Rave was designed to allow for maximum flexability&nbsp;in both functionality and &quot;look and feel.&quot;</p>
			<p>This plugin allows you to leverage nearly all of the possabilities contained within Rave, inlcuding custom playlists and custom skins. All with the click of a few buttons.</p>
			<h3>The main &quot;Rave Player&quot; menu contains three sections:</h3>
			<p><b>Players</b><br />
				Here is where you'll setup players. Once you've completed a player setup, you'll see a &quot;Short Code&quot; listed underneath the preview.	Copy	and	paste the shortcode into your page or post.</p>
			<p><b>Playlists</b><br />
				Here you can create custom playlists based on media files in your Wordpress Media Library.
			</p>
			<p><b>Register</b><br />
				Here is where you enter your registration code you recieved after purchasing a license for Wimyp Rave.
			</p>
			<table width="100%" border="0" cellspacing="5" cellpadding="0">
				<tr>
					<td width="13%" align="left" valign="top"><a href="http://www.wimpyplayer.com/docs/rave/skin_machine.html" target="wimpy_rave_window"><img src="<?php echo $this->CONF['path_url_plugin_folder']; ?>images/easymoblog.png" width="50" height="50" border="0" /></a></td>
					<td width="87%" align="left" valign="top"><h3>Documentation</h3></td>
				</tr>
				<tr>
					<td align="left" valign="top">&nbsp;</td>
					<td align="left" valign="top"><p>For more information on using this plugin, visit the Rave Plugin for Wordpress Documentation page at wimpyplayer.com</p>
						<p><a href="http://www.wimpyplayer.com/docs/rave/skin_machine.html" target="wimpy_rave_window"><img src="<?php echo $this->CONF['path_url_plugin_folder']; ?>images/learn_more.jpg" width="91" height="17" border="0" /></a></p></td>
				</tr>
			</table>
			<p>&nbsp;</p></td>
			<td width="44%" align="left" valign="top"><h2>Tools &amp; Resources</h2>
				<table width="100%" border="0" cellspacing="0" cellpadding="0">
				
				<tr>
					<td width="16%" align="left" valign="top">&nbsp;</td>
					<td width="84%" align="left" valign="top"><h3>Version</h3>
						<?php
						$ravePluginVersionInfo = $this->getVersionInfo();
						?>
						<p>Installed Version:	<?php print ($ravePluginVersionInfo['me']);		?>
						<br />Latest Version:		<?php print ($ravePluginVersionInfo['latest']); ?>
						<br />						<?php print ($ravePluginVersionInfo['status']); ?></p>
						<p>&nbsp;</p></td>
				</tr>
				<tr>
					<td width="16%" align="left" valign="top"><a href="http://www.wimpyplayer.com/docs/rave/skin_machine.html" target="wimpy_rave_window"></a><a href="http://www.wimpyplayer.com/buy/" target="wimpy_rave_window"><img src="<?php echo $this->CONF['path_url_plugin_folder']; ?>images/password.png" width="50" height="50" border="0" /></a></td>
					<td width="84%" align="left" valign="top"><h3>Registration &amp; Licensing</h3>
						<p>How to register your product and general licensing information. </p>
						<p><a href="http://www.wimpyplayer.com/docs/rave/skin_machine.html" target="wimpy_rave_window"><img src="<?php echo $this->CONF['path_url_plugin_folder']; ?>images/learn_more.jpg" width="91" height="17" border="0" /></a></p>
						<p>&nbsp;</p></td>
				</tr>
				<tr>
					<td align="left" valign="top"><a href="http://www.wimpyplayer.com/docs/rave/skin_machine.html" target="wimpy_rave_window"><img src="<?php echo $this->CONF['path_url_plugin_folder']; ?>images/skin_machine_50.png" width="50" height="50" border="0" /></a></td>
					<td align="left" valign="top"><h3>Skin Machine</h3>
						<p>Use Skin Machine to create your own custom skin.</p>
						<p><a href="http://www.wimpyplayer.com/docs/rave/skin_machine.html" target="wimpy_rave_window"><img src="<?php echo $this->CONF['path_url_plugin_folder']; ?>images/learn_more.jpg" width="91" height="17" border="0" /></a></p>
						<p>&nbsp;</p></td>
				</tr>
				<tr>
					<td align="left" valign="top"><a href="http://www.wimpyplayer.com/products/wimpy_rave.html" target="wimpy_rave_window"><img src="<?php echo $this->CONF['path_url_plugin_folder']; ?>images/glass-rave03-45.jpg" width="45" height="48" border="0" /></a></td>
					<td align="left" valign="top"><h3>Wimpy Rave</h3>
						<p>Get the full scoop on Wimpy Rave.</p>
						<p><a href="http://www.wimpyplayer.com/products/wimpy_rave.html" target="wimpy_rave_window"><img src="<?php echo $this->CONF['path_url_plugin_folder']; ?>images/learn_more.jpg" width="91" height="17" border="0" /></a></p>
						<p>&nbsp;</p></td>
				</tr>
				<tr>
					<td align="left" valign="top"><a href="http://www.wimpyplayer.com" target="wimpy_rave_window"><img src="<?php echo $this->CONF['path_url_plugin_folder'] ?>images/glass.w_45.png" width="45" height="45" border="0" /></a></td>
					<td align="left" valign="top"><h3>Wimpy Player</h3>
						<p>Learn more about the entire collection of Wimpy Media players at <a href="http://www.wimpyplayer.com">www.wimpyplayer.com</a></p>
						<p><a href="http://www.wimpyplayer.com/products/wimpy_rave.html" target="wimpy_rave_window"><img src="<?php echo $this->CONF['path_url_plugin_folder'] ?>images/learn_more.jpg" width="91" height="17" border="0" /></a></p></td>
				</tr>
			</table></td>
		</tr>
		<tr>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
		</tr>
	</table>
	<p>&nbsp;</p>
</div>
<p>&nbsp;</p>
<script language="JavaScript" type="text/javascript">

//<![CDATA[

<?php print $this->conf_to_js(); ?>

jQuery(document).ready(function(){
  RAVE.init("reg");
});

//]]>
</script> 
