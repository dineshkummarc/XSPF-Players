<?php if ($master_page == true) { ?>

<?php
/************************************************************************************************
 * FLAM Player ADMINISTRATION - Section 1: Upload Mp3 File                                      *
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
		<div id="help">
			<a href=<?php echo "\"javascript:doc_popup('../doc/fp_doc_".$langage.".html#upload','2000','740')\""; ?>><?php echo $text[91][$langage]; ?></a>
		</div>
	</div>
		<form name="form_upload" enctype="multipart/form-data" action=<?php echo "\"".set_url($current_url, $langage, $section, $playlist, $author, $order, $direction, $active, array(0, 101, $mode[2], $mode[3]), $record)."\"" ?> method="POST">
			<table width="730" border="0" align="center" cellspacing="2" cellpadding="0" id="add_form_table">
					<tr height="10"><td colspan="3"></td></tr>
					<tr>
							<th><?php echo $text[29][$langage]; ?></th>
							<td align="right" width="1"><input type="file" name="upload" size="60" class="FILE"></td>
							<td align="right" width="1"><input type="submit" class="SUBMIT" value=<?php echo "\"".$text[30][$langage]."\""; ?>></td>
					</tr>
			</table>
			<table width="730" border="0" align="center" cellpadding="0" cellspacing="0" id="add_form_table">
					<tr><td height="5"></td></tr>
					<tr>
						<td>
							<?php if ($message[$mode[1]]) {echo $message[$mode[1]][$langage];} ?>
						</td>
					</tr>
			</table>
		</form>
</div>

<?php } else { echo "<font color=\"#FF0000\" size=\"7\">Forbidden</font>"; } ?>