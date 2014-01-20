<?php if ($master_page == true) { ?>

<?php
/************************************************************************************************
 * FLAM Player ADMINISTRATION - Section 1: File to upload already exists REPLACE / CANCEL       *
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
		<h2><?php echo $text[22][$langage]; ?></h2><h3> <?php echo $text[23][$langage]; ?></h3>
	</div>
		<table width="730" border="0" align="center" cellspacing="2" cellpadding="0" id="add_form_table">
					<tr>
						<td width="730" height="10"></td>
						<td width="1"></td>
					</tr>
					<tr>
							<th colspan="2"><?php echo $text[33][$langage].$mde.tempname_to_name(rawurldecode($record)).$text[34][$langage]; ?></th>
					</tr>
					<tr>
						<td align="right">
							<form name="form_overwrite" action=<?php echo "\"".set_url($current_url, $langage, $section, $playlist, $author, $order, $direction, $active, array(0, 116, $mode[2], $mode[3]), $record)."\"" ?> method="POST">		
								<input name="ok" type="submit" class="SUBMIT" value=<?php echo "\"".$text[31][$langage]."\""; ?>>
							</form>
						</td>
						<td align="right">
							<form name="form_overwrite" action=<?php echo "\"".set_url($current_url, $langage, $section, $playlist, $author, $order, $direction, $active, array(0, 117, $mode[2], $mode[3]), $record)."\"" ?> method="POST">		
								<input name="cancel" type="submit" class="SUBMIT" value=<?php echo "\"".$text[32][$langage]."\""; ?>>
							</form>
						</td>
					</tr>
		</table>
</div>

<?php } else { echo "<font color=\"#FF0000\" size=\"7\">Forbidden</font>"; } ?>