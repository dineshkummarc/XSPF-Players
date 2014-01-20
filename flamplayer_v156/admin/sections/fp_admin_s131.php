<?php if ($master_page == true) { ?>

<?php
/************************************************************************************************
 * FLAM Player ADMINISTRATION - Section 1: External link addition                               *
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
?>

<div id="block_add_upload">
	<div id="block_title">
		<h2><?php echo $text[93][$langage]; ?></h2><h3> <?php echo $text[94][$langage]; ?></h3>
		<div id="help">
			<a href=<?php echo "\"javascript:doc_popup('../doc/fp_doc_".$langage.".html#add_link','2000','740')\""; ?>><?php echo $text[91][$langage]; ?></a>
		</div>
	</div>
		<form name="form_external_add" action=<?php echo "\"".set_url($current_url, $langage, $section, $playlist, $author, $order, $direction, $active, array(0, $mode[1], $mode[2], 301), $record)."\"" ?> method="POST">
			<table width="730" border="0" align="center" cellspacing="2" cellpadding="0" id="add_form_table">
					<tr height="10"><td colspan="2"></td></tr>
					<tr>
							<th><?php echo $text[95][$langage]; ?></th>
							<td align="right" width="1"><input type="text" name="ext_link" size="100" class="TEXT"></td>
					</tr>
			</table>
			<table width="730" border="0" align="center" cellpadding="0" cellspacing="0" id="add_form_table">
					<tr><td height="5"></td></tr>
					<tr>
						<td>
							<?php echo $text[97][$langage]; ?>
							<select name="ext_link_playlist" class="LIST" tabindex="7">
											<?php
											foreach( $playlists_list as $playlist_item ) {
													echo "<option value=\"".$playlist_item."\">".dots($playlist_item, 20, "...")."</option>";
											}
											?>
							</select>
							<?php echo $text[37][$langage]; ?>
							<input name="ext_link_newpl" type="text" size="20" maxlength="25" class="TEXT">
						</td>					
					</tr>
					<tr>
						<td height="35" align="center" valign="bottom"><input type="submit" class="SUBMIT4" value="<?php echo $text[96][$langage]; ?>"></td>
					</tr>					
					<tr>
						<td align="center" height="25">
							<?php if ($message[$mode[3]]) {echo $message[$mode[3]][$langage];} ?>
						</td>
					</tr>
			</table>
		</form>
</div>

<?php } else { echo "<font color=\"#FF0000\" size=\"7\">Forbidden</font>"; } ?>