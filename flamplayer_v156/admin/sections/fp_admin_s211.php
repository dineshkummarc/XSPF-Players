<?php if ($master_page == true) { ?>

<?php
/************************************************************************************************
 * FLAM Player ADMINISTRATION - Section 2: EDIT - DELETE a track                                *
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

<!-- ************** Filter Form -->
		<form name="filter">				
			<table border="0" align="center" cellspacing="4" cellpadding="0">
				<tr align="center">
					<td class="filter_title"><?php echo $text[15][$langage]; ?></td>
					<td class="filter_title"><?php echo $text[16][$langage]; ?></td>
					<td class="filter_title"><?php echo $text[17][$langage]; ?></td>
					<td class="filter_title"><?php echo $text[18][$langage]; ?></td>
					<td class="filter_title"><?php echo $text[19][$langage]; ?></td>
				</tr>
				<tr align="center">
					<td>
					<select class="filter_list" name="onoff_filter" onChange="jumpMenu('parent',this,0)">
						<?php
							foreach( $active_list as $active_item ) {
								if ($active_item['value'] == $active) {
									echo "<option value=\"".set_url($current_url, $langage, $section, $playlist, $author, $order, $direction, $active_item['value'], array(0,100,200,300), $record)."\" selected>".$active_item['text'.$langage]."</option>";
								} else {
									echo "<option value=\"".set_url($current_url, $langage, $section, $playlist, $author, $order, $direction, $active_item['value'], array(0,100,200,300), $record)."\">".$active_item['text'.$langage]."</option>";
								}
							}					
						?>
					</select>
					</td>
					<td>
					<select class="filter_list" name="playlist_filter" onChange="jumpMenu('parent',this,0)">
						<?php 
							if ($playlist == "all") {
								echo "<option value=\"".set_url($current_url, $langage, $section, "all", $author, $order, $direction, $active, array(0,100,200,300), $record)."\" selected>".$text[14][$langage]."</option>";
							} else {
								echo "<option value=\"".set_url($current_url, $langage, $section, "all", $author, $order, $direction, $active, array(0,100,200,300), $record)."\">".$text[14][$langage]."</option>";
							}
							foreach( $playlists_list as $playlist_item ) {
								if ($playlist_item == $playlist) {	
									echo "<option value=\"".set_url($current_url, $langage, $section, $playlist_item, $author, $order, $direction, $active, array(0,100,200,300), $record)."\" selected>".htmlentities(dots($playlist_item, 20, "..."))."</option>";
								} else {	
									echo "<option value=\"".set_url($current_url, $langage, $section, $playlist_item, $author, $order, $direction, $active, array(0,100,200,300), $record)."\">".htmlentities(dots($playlist_item, 20, "..."))."</option>";
								}
							}
						?>				
					</select>									
					</td>
					<td>
					<select class="filter_list" name="author_filter" onChange="jumpMenu('parent',this,0)">
						<?php 
							if ($author == "all") {
								echo "<option value=\"".set_url($current_url, $langage, $section, $playlist, "all", $order, $direction, $active, array(0,100,200,300), $record)."\" selected>".$text[14][$langage]."</option>";
							} else {
								echo "<option value=\"".set_url($current_url, $langage, $section, $playlist, "all", $order, $direction, $active, array(0,100,200,300), $record)."\">".$text[14][$langage]."</option>";
							}
							foreach( $authors_list as $author_item ) {
								if ($author_item->id_artist == $author) {	
									echo "<option value=\"".set_url($current_url, $langage, $section, $playlist, $author_item->id_artist, $order, $direction, $active, array(0,100,200,300), $record)."\" selected>".htmlentities($author_item->name_artist)."</option>";
								} else {	
									echo "<option value=\"".set_url($current_url, $langage, $section, $playlist, $author_item->id_artist, $order, $direction, $active, array(0,100,200,300), $record)."\">".htmlentities($author_item->name_artist)."</option>";
								}
							}
						?>						
        			</select>
					</td>
					<td>
					<select class="filter_list" name="order_filter" onChange="jumpMenu('parent',this,0)">
						<?php
							foreach( $orders_list as $order_item ) {
								if ($order_item['value'] == $order) {
									echo "<option value=\"".set_url($current_url, $langage, $section, $playlist, $author, $order_item['value'], $direction, $active, array(0,100,200,300), $record)."\" selected>".$order_item['text'.$langage]."</option>";
								} else {
									echo "<option value=\"".set_url($current_url, $langage, $section, $playlist, $author, $order_item['value'], $direction, $active, array(0,100,200,300), $record)."\">".$order_item['text'.$langage]."</option>";
								}
							}					
						?>
					</select>
					</td>
					<td>
					<select class="filter_list" name="direction_filter" onChange="jumpMenu('parent',this,0)">
						<?php
							foreach( $directions_list as $direction_item ) {
								if ($direction_item['value'] == $direction) {
									echo "<option value=\"".set_url($current_url, $langage, $section, $playlist, $author, $order, $direction_item['value'], $active, array(0,100,200,300), $record)."\" selected>".$direction_item['text'.$langage]."</option>";
								} else {
									echo "<option value=\"".set_url($current_url, $langage, $section, $playlist, $author, $order, $direction_item['value'], $active, array(0,100,200,300), $record)."\">".$direction_item['text'.$langage]."</option>";
								}
							}					
						?>
					</select>
					</td>
				</tr>
				<tr height="5">&nbsp;</tr>
			</table>
		</form>
<!-- ************** Filter Form END-->				
		
<!-- ************** Launch FLAM Player table -->
			<table width="100%" border="0" cellpadding="0" cellspacing="0" class="view_filter">
				<tr align="center" height="25"><td>	<?php echo
																				"<a href=\"javascript:open_popup('sections/fp_admin_flampopup.php?lang=".$langage.
																				"&p=".urlencode($playlist).
																				"&a=".$author.
																				"&o=".$order.
																				"&d=".$direction."','425','310')\""
																			?>	>&nbsp;<?php echo $text[20][$langage]; ?>&nbsp;</a></td></tr>
			</table>
<!-- ************** Launch FLAM Player table END-->	
			<form name="Edit_del_track" action=<?php echo "\"".set_url($current_url, $langage, $section, $playlist, $author, $order, $direction, $active, array(0, 101, $mode[2], $mode[3]), $record)."\"" ?> method="POST">
			<table width="740" align="center" border="0" cellspacing="0" cellpadding="0" id="add_form_table">
				<tr><td height="8" colspan="3"></td></tr>
				<tr>
					<td width="100%" valign="bottom"><?php if ($message[$mode[1]]) {echo $message[$mode[1]][$langage];} ?>
					</td>
					<td align="right">
						<?php	if (count($tracks) >0){ ?>
						<input name="checkall" type=button class="SUBMIT3" value=<?php echo "\"".$text[45][$langage]."\""; ?> <?php echo "onClick=\"check('Edit_del_track','del_track',".count($tracks).")\">"; ?>
						<?php } ?>
					</td>
					<td>&nbsp;&nbsp;</td>
					<td align="right">
						<?php	if (count($tracks) >0){ ?>
						<input type="submit" class="SUBMIT3" value=<?php echo "\"".$text[47][$langage]."\""; ?>>
						<?php } ?>
					</td>
				</tr>
				<tr><td height="5" colspan="3"></td></tr>
			</table>
<!-- ************** Repeated records table -->
	<?php 
		$i=0;
		if (count($tracks) > 0 ) {
			foreach( $tracks as $track ) { ?>
				<table id="edit_del_table" width="740" border="0" cellspacing="0" cellpadding="0">
						<tr>
								<td width="20" align="center" valign="top" bgcolor="#585858">
									<?php if ($track->active_music == "active") { ?>	
										<img src="css/led_on.gif" width="20" height="16">
									<?php } else { ?>
										<img src="css/led_off.gif" width="20" height="16">
									<?php } ?>
								</td>
								<td class="edit_del_table_headerc" width="20" bgcolor="#585858">Id</td>
								<td class="edit_del_table_header" width="130" height="16" bgcolor="#696969"><?php echo $text[10][$langage]; ?></td>
								<td class="edit_del_table_header" width="200" bgcolor="#696969"><?php echo $text[11][$langage]; ?></td>
								<td class="edit_del_table_header" bgcolor="#696969"><?php echo $text[12][$langage]; ?></td>
								<td class="edit_del_table_headerc" width="30" bgcolor="#585858"><?php echo $text[51][$langage]; ?></td>
								<td class="edit_del_table_headerc" width="30" bgcolor="#585858"><?php echo $text[52][$langage]; ?></td>
						</tr>
						<tr>
								<?php 	// Is it an external link ?
										$link_start = strtolower(substr($track->filename_music, 0, 6));
										if ($link_start != "http:/" && $link_start != "ftp://" && $link_start != "https:") {
											$ext_link = ""; }
										else {
											$ext_link = "<br><img src=\"css/ext_link.gif\" width=\"35\" height=\"35\" border=\"0\">";
										}								
								?>
								<td class="edit_del_table_stext" colspan="2" rowspan="3" valign="top" align="right" bgcolor="#585858"><?php echo $track->id_music.$ext_link; ?></td>
								<td class="edit_del_table_soft" height="16" bgcolor="#696969"><?php echo htmlentities(dots($track->playlist_music, 20, "...")); ?></td>
								<td class="edit_del_table_hard" bgcolor="#696969"><?php echo htmlentities(dots($track->name_artist, 28, "...")); ?></td>
								<td class="edit_del_table_hard" bgcolor="#696969"><?php echo htmlentities($track->title_music); ?></td>
								<td rowspan="3" bgcolor="#585858">
									<a href=<?php echo "\"".set_url($current_url, $langage, $section, $playlist, $author, $order, $direction, $active, array(0, 100, 201, $mode[3]), $track->id_music)."\"" ?>>
									<img src="css/edit_btn.gif" 
									width="26" height="45" border="0"
									name=<?php echo "\"editbtn".$i."\""; ?> alt="Edit this record" 
									></a>
								</td>
								<td rowspan="3" align="center" bgcolor="#585858"><input type="checkbox" name=<?php echo "\"del_track".$i."\""; ?> class="CHECKB" value=<?php echo "\"".$track->id_music."\""; ?>></td>
						</tr>
						<tr>
								<td class="edit_del_table_header" colspan="2" height="16" bgcolor="#5F5F5F"><?php echo $text[13][$langage]; ?></td>
								<td class="edit_del_table_header" bgcolor="#5F5F5F">Date</td>
						</tr>
						<tr>
								<td class="edit_del_table_soft" colspan="2" height="16" bgcolor="#5F5F5F"><a title="<?php echo htmlentities(rawurldecode($track->filename_music)); ?>"><?php echo htmlentities(dots(rawurldecode($track->filename_music), 50, "...")); ?></a></td>
								<td class="edit_del_table_soft" bgcolor="#5F5F5F"><?php echo $track->date_music; ?></td>
						</tr>
						<tr>
								<td class="edit_del_table_foot" colspan="7">&nbsp;</td>
						</tr>
				</table>
		<?php $i++; }} ?>
<!-- ************** Repeated records table END -->
			<table width="740" align="center" border="0" cellspacing="0" cellpadding="0">
				<tr>
					<td width="100%">
					</td>
					<td align="right">
						<?php	if (count($tracks) >0){ ?>
						<input name="checkall" type=button class="SUBMIT3" value=<?php echo "\"".$text[45][$langage]."\""; ?> <?php echo "onClick=\"check('Edit_del_track','del_track',".count($tracks).")\">"; ?>		
						<?php } ?>
					</td>
					<td>&nbsp;&nbsp;</td>
					<td align="right">
						<?php	if (count($tracks) >0){ ?>
						<input type="submit" class="SUBMIT3" value=<?php echo "\"".$text[47][$langage]."\""; ?>>
						<?php } ?>
					</td>
				</tr>
				<tr><td height="15"></td></tr>
			</table>
		</form>
		
<?php } else { echo "<font color=\"#FF0000\" size=\"7\">Forbidden</font>"; } ?>