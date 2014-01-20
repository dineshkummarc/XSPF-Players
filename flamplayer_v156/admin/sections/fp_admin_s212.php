<?php if ($master_page == true) { ?>

<?php
/************************************************************************************************
 * FLAM Player ADMINISTRATION - Section 2: Track Deletion confirm                               *
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

<table id="add_form_table" align="center" border="0" cellpadding="0" cellspacing="2">
	<tr><td height="10"></td></tr>
	<tr>
		<td colspan="2" align="center"><?php echo $mhs.$text[48][$langage].$mde; ?></td>
		
	</tr>
	<tr><td height="10"></td></tr>
	<tr>
		<th><?php echo $text[11][$langage]; ?></th>
		<th><?php echo $text[12][$langage]; ?></th>
	</tr>
	<?php foreach ($records2del as $record2del) {
				echo "<tr>";
				echo "<td>&nbsp;".htmlentities($record2del->name_artist)."&nbsp;</td>";
				echo "<td>&nbsp;".$ms1.htmlentities(dots($record2del->title_music, 55, "...")).$mde."&nbsp;</td>";
				echo "</tr>";
			}
	?>
	<tr><td height="20" colspan="2"></td></tr>
	<tr>
		<td height="20" colspan="2" align="center">
			<form name="form_delor" action=<?php echo "\"".set_url($current_url, $langage, $section, $playlist, $author, $order, $direction, $active, array(0, 110, $mode[2], $mode[3]), $record)."\"" ?> method="POST">
				<input type="submit" class="SUBMIT4" value=<?php echo "\"".$text[49][$langage]."\""; ?>>
				<?php 
						$i=0;
						foreach ($records2del as $record2del) {
							echo "<input name=\"id2del".$i."\" type=\"hidden\" value=\"".$record2del->id_music."\">";
							$i++;
						}
				?>
			</form>
		</td>
	</tr>
	<tr>
		<td height="20" colspan="2" align="center">
			<form name="form_delor" action=<?php echo "\"".set_url($current_url, $langage, $section, $playlist, $author, $order, $direction, $active, array(0, 111, $mode[2], $mode[3]), $record)."\"" ?> method="POST">
				<input type="submit" class="SUBMIT4" value=<?php echo "\"".$text[50][$langage]."\""; ?>>
				<?php 
						$i=0;
						foreach ($records2del as $record2del) {
							echo "<input name=\"id2del".$i."\" type=\"hidden\" value=\"".htmlentities($record2del->id_music)."\">";
							echo "<input name=\"file2del".$i."\" type=\"hidden\" value=\"".htmlentities($record2del->filename_music)."\">";
							$i++;
						}
				?>
			</form>
		</td>
	</tr>
	<tr>
		<td height="20" colspan="2" align="center">
			<form name="form_delor" action=<?php echo "\"".set_url($current_url, $langage, $section, $playlist, $author, $order, $direction, $active, array(0, 113, $mode[2], $mode[3]), $record)."\"" ?> method="POST">
				<input type="submit" class="SUBMIT4" value=<?php echo "\"".$text[32][$langage]."\""; ?>>
			</form>
		</td>
	</tr>	
</table>


<?php } else { echo "<font color=\"#FF0000\" size=\"7\">Forbidden</font>"; } ?>