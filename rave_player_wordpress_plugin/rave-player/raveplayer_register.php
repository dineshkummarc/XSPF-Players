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
	<h2>Register</h2>
	<div class="playlistTypeBox">
		<table width="338" border="0" cellspacing="0" cellpadding="0">
			<tr>
				<td><div id="regisrationText">
					<p>Wimpy Rave is free to try  for 15 days, after which time it will expire. You can &quot;unlock&quot; the demo and remove the 15 day expiration limit at any time by <a href="http://www.wimpyplayer.com/buy/">purchasing a license</a>. </p>
					<p>If you do not have a registration code, leave this field blank </p>
				</div></td>
			</tr>
		</table>
		<p>
		Enter your&nbsp;Rave registration code below:</p>
		<p>
			<input name="reg_code" type="text" id="reg_code" class="textLineURL"/>
		</p>
		<div class="submit">
			<p>
				<input type="button" value="Save" onclick="RAVE.setRegCode()" />
			</p>
			<p>&nbsp; </p>
			<div class="actionBox" id="actionBoxDiv">Starting Up...</div>
		</div>
	</div>
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
