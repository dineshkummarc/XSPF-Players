<?php if ($master_page == true) { ?>

<?php
/************************************************************************************************
 * FLAM Player ADMINISTRATION - Section 2: Track Edition                                        *
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

<form name="form_edit_track" action=<?php echo "\"".set_url($current_url, $langage, $section, $playlist, $author, $order, $direction, $active, array(0, 100, 210, $mode[3]), $record)."\"" ?> method="POST">
		
			<table border="0" align="center" cellpadding="0" cellspacing="2" id="add_form_table">
				<tr><td colspan="2" height="10"></td></tr>
				<tr>
						<th width="100" height="20"><?php echo $text[13][$langage]; ?></th>
						<td bgcolor="#6C6C6C"><?php echo "&nbsp;".$ms1.htmlentities(wordwrap(rawurldecode($record2edit->filename_music), 100, "\n&nbsp;", 1)).$mde; ?></td>
				</tr>
				<tr><td colspan="2" height="10"></td></tr>
				<tr>
						<th width="100" height="20"><?php echo $text[11][$langage]; ?></th>
						<td>
							<select name="edit_author" class="LIST">
								<?php
								foreach( $authors_list as $author_item ) {
									if ($author_item->id_artist == $record2edit->id_artist){
										echo "<option value=\"".$author_item->id_artist."\" selected>".htmlentities($author_item->name_artist)."</option>";}
									else {
										echo "<option value=\"".$author_item->id_artist."\">".htmlentities($author_item->name_artist)."</option>";}
								}
								?>
							</select>
						</td>
				</tr>
				<tr><td colspan="2" height="10"></td></tr>
				<tr>
						<th height="20"><?php echo $text[38][$langage]; ?></th>
						<td><input name="edit_title" type="text" value=<?php echo "\"".htmlentities($record2edit->title_music)."\""; ?> size="55" maxlength="200" class="TEXT"></td>
				</tr>
				<tr><td colspan="2" height="10"></td></tr>
				<tr>
						<th height="20"><?php echo $text[10][$langage]; ?></th>
						<td>
							<select name="edit_playlist" class="LIST">
								<?php
								foreach( $playlists_list as $playlist_item ) {
									if ($playlist_item == $record2edit->playlist_music){
										echo "<option value=\"".$playlist_item."\" selected>".htmlentities($playlist_item)."</option>";}
									else {
										echo "<option value=\"".$playlist_item."\">".htmlentities($playlist_item)."</option>";}
								}
								?>
							</select>
						</td>
				</tr>
				<tr><td colspan="2" height="10"></td></tr>
				<tr>
						<th height="20"><?php echo $text[39][$langage]; ?></th>
						<td>
							<select name="edit_active" class="LIST">
								<?php
								foreach( $active_list as $active_item ) {
									if ($active_item['value'] == $record2edit->active_music) {
										echo "<option value=\"".$active_item['value']."\" selected>".$active_item['text'.$langage]."</option>";}
									else {
										echo "<option value=\"".$active_item['value']."\">".$active_item['text'.$langage]."</option>";}
								}
								?>
							</select>
						</td>
				</tr>
				<tr><td colspan="2" height="10"></td></tr>
				<tr>
					<td class="last_col" height="20">
						<input type="submit" class="SUBMIT3" value=<?php echo "\"".$text[53][$langage]."\""; ?>>&nbsp;
						</form>
					</td>
					<td>
					</td>
				</tr>
				<tr>
					<td class="last_col" height="20">
						<form action=<?php echo "\"".set_url($current_url, $langage, $section, $playlist, $author, $order, $direction, $active, array(0, 113, 200, $mode[3]), $record)."\"" ?> method="POST">
							<input type="submit" class="SUBMIT3" value=<?php echo "\"".$text[32][$langage]."\""; ?>>
						</form>
					</td>
					<td></td>
				</tr>
			</table>				


<?php } else { echo "<font color=\"#FF0000\" size=\"7\">Forbidden</font>"; } ?>