<?php if ($master_page == true) { ?>

<?php
/************************************************************************************************
 * FLAM Player ADMINISTRATION - Section 4: Move Playlists content                               *
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
		<h2><?php echo $text[54][$langage]; ?></h2><h3> <?php echo $text[55][$langage]; ?></h3>
		<div id="help">
			<a href=<?php echo "\"javascript:doc_popup('../doc/fp_doc_".$langage.".html#move_playlists','2000','740')\""; ?>><?php echo $text[91][$langage]; ?></a>
		</div>
	</div>
	
	<table border="0" align="center" cellspacing="1" cellpadding="0" id="add_form_table">
		<tr><td colspan="3" height="10"></td></tr>
		<tr>
			<th><?php echo $text[60][$langage]; ?></th>
			<th><?php echo $text[61][$langage]."&nbsp;".$mhs.$record.$mde; ?></th>
			<th><?php echo $text[62][$langage]; ?></th>
		</tr>
		<tr>
			<td>
				
				<form name="m_playlists" action=<?php echo "\"".set_url($current_url, $langage, $section, $playlist, $author, $order, $direction, $active, array(0, 100, 201, $mode[3]), $record)."\"" ?> method="post">
				<?php
				echo "<select name=\"ori_pl\" class=\"ORIDEST_LIST\" size=".$select_vsize." onChange=\"jumpMenu('parent',this,0); document.m_playlists.long_name.value = this.options[this.selectedIndex].text;\">";
					foreach ($playlists_not_empty as $playlist_not_empty) {
						if ($playlist_not_empty == $record) {
							echo "<option value=\"".set_url($current_url, $langage, $section, $playlist, $author, $order, $direction, $active, array(0, 100, 200, $mode[3]), $playlist_not_empty)."\" selected>".htmlentities($playlist_not_empty)."</option>";
							$ori_playlist_selected = htmlentities($playlist_not_empty); }
						else {
							echo "<option value=\"".set_url($current_url, $langage, $section, $playlist, $author, $order, $direction, $active, array(0, 100, 200, $mode[3]), $playlist_not_empty)."\">".htmlentities($playlist_not_empty)."</option>";}
					}
				echo "</select>";
				?>
				
			</td>
			<td>
				<?php
				echo "<select name=\"moving_tracks[]\" class=\"MIDDLE_LIST\" size=".$select_vsize." multiple onChange=\"document.m_playlists.long_name.value = this.options[this.selectedIndex].text;\">";
				foreach ($playlists_content[$record] as $track){
					echo 	"<option value=\"".$track->id_music."\">"
							."[".htmlentities($track->name_artist)."]&nbsp;&nbsp;"
							.us2space(htmlentities($track->filename_music))
							."</option>";
				}
				echo "</select>";
				?>
			</td>
			<td>
				
				<?php
				echo "<select name=\"dest_pl\" class=\"ORIDEST_LIST\" size=".$select_vsize." onChange=\"document.m_playlists.long_name.value = this.options[this.selectedIndex].text;\">";
					
					foreach ($playlists_list as $playlist) {
						if ($playlist != $record){
							echo "<option value=\"".$playlist."\">".htmlentities($playlist)."</option>";
						}
					}
				
				echo "</select>";
				?>
				
			</td>
		</tr>
		<tr>
			<td colspan="3">
				<input type="text" name="long_name" style="width: 100%;" class="TEXT" value="<?php echo $ori_playlist_selected; ?>" />			
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