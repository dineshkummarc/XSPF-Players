<?php if ($master_page == true) { ?>

<?php
/************************************************************************************************
 * FLAM Player ADMINISTRATION - Sestion 3: Author Edition                                       *
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

<div id="block_edit_del">
	<div id="block_title">
		<h2><?php echo $text[63][$langage]; ?></h2><h3> <?php echo $text[64][$langage]; ?></h3>
		<div id="help">
			<a href=<?php echo "\"javascript:doc_popup('../doc/fp_doc_".$langage.".html#add_edit_del_authors','2000','740')\""; ?>><?php echo $text[91][$langage]; ?></a>
		</div>
	</div>
	
	<table width="730" border="0" align="center" cellspacing="2" cellpadding="0" id="add_form_table">
		<tr><td height="10" colspan="3"></td></tr>
		<form action=<?php echo "\"".set_url($current_url, $langage, $section, $playlist, $author, $order, $direction, $active, array(0, 115, $mode[2], $mode[3]), $record)."\"" ?> method="post">
		<tr>
			<th width="386"><?php echo $text[77][$langage].$mhs.htmlentities($author2edit->name_artist).$mde; ?></th>
			<th width="70"><?php echo $text[40][$langage]; ?></th>
			<td class="last_col"><input name="new_name_au" type="text" size="65" maxlength="40" class="TEXT" value=<?php echo "\"".htmlentities($author2edit->name_artist)."\""; ?>></td>	
		</tr>
		<tr>
			<td><?php if ($message[$mode[1]] && $mode[1]>149) {echo $message[$mode[1]][$langage];} ?></td>
			<th><?php echo $text[41][$langage]; ?></th>
			<td class="last_col"><input name="new_email_au" type="text" size="65" maxlength="100" class="TEXT" value=<?php echo "\"".htmlentities($author2edit->email_artist)."\""; ?>></td>
		</tr>
		<tr>
			<td></td>
			<th><?php echo $text[42][$langage]; ?></th>
			<td class="last_col"><input name="new_website_au" type="text" size="65" maxlength="200" class="TEXT" value=<?php echo "\"".htmlentities($author2edit->website_artist)."\""; ?>></td>
		</tr>
		<tr><td height="10" colspan="3"></td></tr>
		<tr>
			<td></td>
			<td></td>
			<td align="right" valign="middle"><input type="submit" class="SUBMIT3" value=<?php echo "\"".$text[53][$langage]."\""; ?>>
															<input name="author2upd" type="hidden" value=<?php echo "\"".$author2edit->id_artist."\""; ?>>
															</form>
			</td>
		</tr>
		<tr>
			<td></td>
			<td></td>
			<td align="right" valign="middle">
				<form action=<?php echo "\"".set_url($current_url, $langage, $section, $playlist, $author, $order, $direction, $active, array(0, 114, $mode[2], $mode[3]), $record)."\"" ?> method="POST">
					<input type="submit" class="SUBMIT3" value=<?php echo "\"".$text[32][$langage]."\""; ?>>
				</form>
			</td>
		</tr>
	</table>
	
</div>

<?php } else { echo "<font color=\"#FF0000\" size=\"7\">Forbidden</font>"; } ?>