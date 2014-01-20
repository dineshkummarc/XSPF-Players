<?php if ($master_page == true) { ?>

<?php
/************************************************************************************************
 * FLAM Player ADMINISTRATION - Section 3: Change Tracks authors                                *
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

<div id="block_add_quickscan">
	<div id="block_title">
		<h2><?php echo $text[66][$langage]; ?></h2><h3> <?php echo $text[67][$langage]; ?></h3>
		<div id="help">
			<a href=<?php echo "\"javascript:doc_popup('../doc/fp_doc_".$langage.".html#change_authors','2000','740')\""; ?>><?php echo $text[91][$langage]; ?></a>
		</div>
	</div>
	
	<table border="0" align="center" cellspacing="1" cellpadding="0" id="add_form_table">
		<tr><td colspan="3" height="10"></td></tr>
			<form name="m_authors" action=<?php echo "\"".set_url($current_url, $langage, $section, $playlist, $author, $order, $direction, $active, array(0, 100, 201, $mode[3]), $record)."\"" ?> method="post">
			<th><?php echo $text[68][$langage]; ?></th>
			<th><?php echo $text[69][$langage]."&nbsp;".$mhs.htmlentities($authors_content[$record][0]->name_artist).$mde; ?></th>
			<th><?php echo $text[70][$langage]; ?></th>
		</tr>
		<tr>
			<td>
				<?php
				echo "<select name=\"ori_au\" class=\"ORIDEST_LIST\" size=".$select_vsize." onChange=\"jumpMenu('parent',this,0); document.m_authors.long_name.value = (this.options[this.selectedIndex].text);\">";
					foreach ($authors_not_empty as $author_not_empty) {
						if ($author_not_empty->id_artist == $record) {
							echo "<option value=\"".set_url($current_url, $langage, $section, $playlist, $author, $order, $direction, $active, array(0, 100, 200, $mode[3]), $author_not_empty->id_artist)."\" selected>".htmlentities($author_not_empty->name_artist)."</option>";
							$ori_author_selected = htmlentities($author_not_empty->name_artist); }
						else {
							echo "<option value=\"".set_url($current_url, $langage, $section, $playlist, $author, $order, $direction, $active, array(0, 100, 200, $mode[3]), $author_not_empty->id_artist)."\">".htmlentities($author_not_empty->name_artist)."</option>";}
					}
				echo "</select>";
				?>
				
			</td>
			<td>
				<?php
				echo "<select name=\"moving_tracks[]\" class=\"MIDDLE_LIST\" size=".$select_vsize." multiple onChange=\"document.m_authors.long_name.value = (this.options[this.selectedIndex].text);\">";
				foreach ($authors_content[$record] as $track){
					echo 	"<option value=\"".$track->id_music."\">"
							."[".htmlentities($track->title_music)."]&nbsp;&nbsp;"
							.us2space(htmlentities($track->filename_music))
							."</option>";
				}
				echo "</select>";
				?>
			</td>
			<td>
				
				<?php
				echo "<select name=\"dest_au\" class=\"ORIDEST_LIST\" size=".$select_vsize." onChange=\"document.m_authors.long_name.value = (this.options[this.selectedIndex].text);\">";
					
					foreach ($authors_list as $author) {
						if ($author->id_artist != $record){
							echo "<option value=\"".$author->id_artist."\">".htmlentities($author->name_artist)."</option>";
						}
					}
				
				echo "</select>";
				?>
				
			</td>
		</tr>
		<tr>
			<td colspan="3">
				<input type="text" name="long_name" style="width: 100%;" class="TEXT" value="<?php echo $ori_author_selected; ?>" />			
			</td>
		</tr>		
		<tr>
			<td colspan="2"><?php if ($message[$mode[2]]) {echo $message[$mode[2]][$langage];} ?>
			<td>
				<input type="submit" class="SUBMIT5" value=<?php echo "\"".$text[53][$langage]."\""; ?>>
				</form>
			</td>
		</tr>
		<tr><td colspan="2" height="10"></td></tr>
	</table>
	
</div>

<?php } else { echo "<font color=\"#FF0000\" size=\"7\">Forbidden</font>"; } ?>