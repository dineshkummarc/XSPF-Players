<?php if ($master_page == true) { ?>

<?php
/************************************************************************************************
 * FLAM Player ADMINISTRATION - Section 3: Author Deletion confirm                              *
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

<table id="add_form_table" align="center" border="0" cellpadding="0" cellspacing="2">
	<tr><td height="10"></td><td></td></tr>
	<tr>
		<td colspan="2" align="center"><?php echo $mhs.$text[75][$langage].$mde; ?></td>
	</tr>
	<tr><td height="10" colspan="2"></td></tr>
	<tr>
		<th><?php echo $text[40][$langage]; ?></th>
		<td>&nbsp;&nbsp;<?php echo htmlentities($author2del->name_artist); ?></td>
	</tr>
	<tr>
		<th><?php echo $text[41][$langage]; ?></th>
		<td>&nbsp;&nbsp;<?php 	if($author2del->email_artist != "") {
											echo htmlentities($author2del->email_artist);}
										else { echo $text[76][$langage]; }
							 ?></td>
	</tr>
	<tr>
		<th><?php echo $text[42][$langage]; ?></th>
		<td>&nbsp;&nbsp;<?php 	if($author2del->website_artist != "") {
											echo htmlentities($author2del->website_artist);}
										else { echo $text[76][$langage]; }
							 ?></td>
	</tr>
	<tr><td height="20" colspan="2"></td></tr>
	<tr>
		<td height="20" colspan="2" align="center">
			<form action=<?php echo "\"".set_url($current_url, $langage, $section, $playlist, $author, $order, $direction, $active, array(0, 112, $mode[2], $mode[3]), $record)."\"" ?> method="POST">
				<input type="submit" class="SUBMIT4" value=<?php echo "\"".$text[47][$langage]."\""; ?>>
				<input name="author2del" type="hidden" value=<?php echo "\"".$author2del->id_artist."\""; ?>>
			</form>
		</td>
	</tr>
	<tr>
		<td height="20" colspan="2" align="center">
			<form action=<?php echo "\"".set_url($current_url, $langage, $section, $playlist, $author, $order, $direction, $active, array(0, 114, $mode[2], $mode[3]), $record)."\"" ?> method="POST">
				<input type="submit" class="SUBMIT4" value=<?php echo "\"".$text[32][$langage]."\""; ?>>
			</form>
		</td>
	</tr>	
</table>
</div>

<?php } else { echo "<font color=\"#FF0000\" size=\"7\">Forbidden</font>"; } ?>