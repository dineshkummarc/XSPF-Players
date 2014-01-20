<?php if ($master_page == true) { ?>

<?php
/************************************************************************************************
 * FLAM Player ADMINISTRATION - Section 5: Adjust FLAM Player settings                          *
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
		<h2><?php echo $text[78][$langage]; ?></h2><h3> <?php echo $text[79][$langage]; ?></h3>
		<div id="help">
			<a href=<?php echo "\"javascript:doc_popup('../doc/fp_doc_".$langage.".html#adjust_settings','2000','740')\""; ?>><?php echo $text[91][$langage]; ?></a>
		</div>
	</div>
	<table width="730" border="0" align="center" cellspacing="1" cellpadding="0" id="add_form_table">
		<tr><td colspan="2" height="10"></td></tr>
		<tr>
			<td>
<!-- *********************************************************************************************************** -->
				<form action=<?php echo "\"".set_url($current_url, $langage, $section, $playlist, $author, $order, $direction, $active, array(0, $mode[1], 200, $mode[3]) , $record)."\"" ?> method="post">
				<table width="410" border="0" align="left" cellspacing="2" cellpadding="0">
					<tr>
						<th colspan="2"><?php echo $text[84][$langage]; ?></th>
					</tr>
					<!------------------------------------------------>
					<tr>
						<td colspan="2">
				
							<table border="0" cellspacing="2" cellpadding="0">
								<tr align="center">
								<?php
									foreach ($color_presets as $color_preset){
										if($color_preset != "custom"){
											echo "<td style=\"background-color:#".$color_preset."\" width=\"21\" height=\"11\"></td>";
										}
									}
								?>
									<td height="11"><?php echo $text[82][$langage]; ?> -&gt;</td>
									<td width="21" height="11">RR</td>
									<td width="21" height="11">GG</td>
									<td width="21" height="11">BB</td>
								</tr>
								<tr align="left">
									<?php
									foreach ($color_presets as $color_preset){
										if ($color_preset == $_POST['ovr_color']){
											echo "<td><input type=\"radio\" name=\"ovr_color\" value=\"".$color_preset."\" checked></td>";}
										else {
											echo "<td><input type=\"radio\" name=\"ovr_color\" value=\"".$color_preset."\"></td>";}
									}
									?>
									<td><input type="text" name="Custom_R" maxlength="2" class="RGB" value=<?php echo "\"".substr( $ovr_color, 0,2 )."\""; ?>></td>
									<td><input type="text" name="Custom_G" maxlength="2" class="RGB" value=<?php echo "\"".substr( $ovr_color, 2,2 )."\""; ?>></td>
									<td><input type="text" name="Custom_B" maxlength="2" class="RGB" value=<?php echo "\"".substr( $ovr_color, 4,2 )."\""; ?>></td>
								</tr>
							</table>
							
						</td>
					</tr>
					<!------------------------------------------------>
					<tr><th colspan="2"><?php echo $text[85][$langage]; ?></th></tr>
					<!------------------------------------------------>
					<tr>
						<td colspan="2">
							<table>
								<tr>
									<td></td>
									<td width="21" height="11">RR</td>
									<td width="21" height="11">GG</td>
									<td width="21" height="11">BB</td>
								</tr>
								<tr>
									<td>#</td>
									<td><input type="text" name="BG_R" maxlength="2" class="RGB" value=<?php echo "\"".substr( $bgcolor, 0,2 )."\""; ?>></td>
									<td><input type="text" name="BG_G" maxlength="2" class="RGB" value=<?php echo "\"".substr( $bgcolor, 2,2 )."\""; ?>></td>
									<td><input type="text" name="BG_B" maxlength="2" class="RGB" value=<?php echo "\"".substr( $bgcolor, 4,2 )."\""; ?>></td>
								</tr>
							</table>
						</td>
					</tr>
					<!------------------------------------------------>
					<tr>
						<th width="150"><?php echo $text[105][$langage]; ?></th>
						<td align="right">
							<select class="filter_list2" name="fp_style">
									<?php
										foreach( $style_list as $style_item ) {
											if ($style_item['value'] == $fp_style) {
												echo "<option value=\"".$style_item['value']."\" selected>".$style_item['text'.$langage]."</option>";
											} else {
												echo "<option value=\"".$style_item['value']."\">".$style_item['text'.$langage]."</option>";
											}
										}					
									?>
							</select>
						</td>
					</tr>
					<!------------------------------------------------>
					<tr>
						<th width="150"><?php echo $text[86][$langage]; ?></th>
						<td align="right">
							<select class="filter_list2" name="ovr_langage">
									<?php
										foreach( $langages_list as $langage_item ) {
											if ($langage_item['value'] == $ovr_langage) {
												echo "<option value=\"".$langage_item['value']."\" selected>".$langage_item['text'.$langage]."</option>";
											} else {
												echo "<option value=\"".$langage_item['value']."\">".$langage_item['text'.$langage]."</option>";
											}
										}					
									?>
							</select>
						</td>
					</tr>
					<!------------------------------------------------>
					<tr>
						<th><?php echo $text[16][$langage]; ?></th>
						<td align="right">
							<select class="filter_list2" name="ovr_playlist">
									<?php 
										if ($playlist == "all") {
											echo "<option value=\"all\" selected>".$text[14][$langage]."</option>";
										} else {
											echo "<option value=\"all\">".$text[14][$langage]."</option>";
										}
										foreach( $playlists_list as $playlist_item ) {
											if ($playlist_item == $ovr_playlist) {	
												echo "<option value=\"".$playlist_item."\" selected>".htmlentities($playlist_item)."</option>";
											} else {	
												echo "<option value=\"".$playlist_item."\">".htmlentities($playlist_item)."</option>";
											}
										}
									?>				
							</select>
						</td>
					</tr>
					<!------------------------------------------------>
					<tr>
						<th><?php echo $text[17][$langage]; ?></th>
						<td align="right">
							<select class="filter_list2" name="ovr_author">
									<?php 
										if ($author == "all") {
											echo "<option value=\"all\" selected>".$text[14][$langage]."</option>";
										} else {
											echo "<option value=\"all\">".$text[14][$langage]."</option>";
										}
										foreach( $authors_list as $author_item ) {
											if ($author_item->id_artist == $ovr_author) {	
												echo "<option value=\"".$author_item->id_artist."\" selected>".htmlentities($author_item->name_artist)."</option>";
											} else {	
												echo "<option value=\"".$author_item->id_artist."\">".htmlentities($author_item->name_artist)."</option>";
											}
										}
									?>						
			        		</select>
						</td>
					</tr>
					<!------------------------------------------------>
					<tr>
						<th><?php echo $text[18][$langage]; ?></th>
						<td align="right">
							<select class="filter_list2" name="ovr_order">
									<?php
										foreach( $orders_list as $order_item ) {
											if ($order_item['value'] == $ovr_order) {
												echo "<option value=\"".$order_item['value']."\" selected>".$order_item['text'.$langage]."</option>";
											} else {
												echo "<option value=\"".$order_item['value']."\">".$order_item['text'.$langage]."</option>";
											}
										}					
									?>
							</select>
						</td>
					</tr>
					<!------------------------------------------------>
					<tr>
						<th><?php echo $text[19][$langage]; ?></th>
						<td align="right">
							<select class="filter_list2" name="ovr_order_direction">
									<?php
										foreach( $directions_list as $direction_item ) {
											if ($direction_item['value'] == $ovr_order_direction) {
												echo "<option value=\"".$direction_item['value']."\" selected>".$direction_item['text'.$langage]."</option>";
											} else {
												echo "<option value=\"".$direction_item['value']."\">".$direction_item['text'.$langage]."</option>";
											}
										}					
									?>
							</select>
						</td>
					</tr>
					<!------------------------------------------------>
					<tr>
						<th><?php echo $text[98][$langage]; ?></th>
						<td align="left">
							<?php if ( $ovr_autoplay == 1 ) { ?>
							  <input type="radio" name="ovr_autoplay" value="1" checked="checked"/><?php echo $text[101][$langage]; ?>
							  <input type="radio" name="ovr_autoplay" value="0" /><?php echo $text[102][$langage]; ?>
							<?php } else { ?>
							  <input type="radio" name="ovr_autoplay" value="1" /><?php echo $text[101][$langage]; ?>
							  <input type="radio" name="ovr_autoplay" value="0" checked="checked"/><?php echo $text[102][$langage]; ?>
							<?php } ?>
						</td>
					</tr>
					<!------------------------------------------------>
					<tr>
						<th><?php echo $text[99][$langage]; ?></th>
						<td align="left">
							<?php if ( $ovr_loop_playlist == 1 ) { ?>
							  <input type="radio" name="ovr_loop_playlist" value="1" checked="checked"/><?php echo $text[101][$langage]; ?>
							  <input type="radio" name="ovr_loop_playlist" value="0" /><?php echo $text[102][$langage]; ?>
							<?php } else { ?>
							  <input type="radio" name="ovr_loop_playlist" value="1" /><?php echo $text[101][$langage]; ?>
							  <input type="radio" name="ovr_loop_playlist" value="0" checked="checked"/><?php echo $text[102][$langage]; ?>
							<?php } ?>
						</td>
					</tr>
					<!------------------------------------------------>
					<tr>
						<th><?php echo $text[100][$langage]; ?></th>
						<td align="left">
							<?php if ( $ovr_loop_tracks == 1 ) { ?>
							  <input type="radio" name="ovr_loop_tracks" value="1" checked="checked"/><?php echo $text[101][$langage]; ?>
							  <input type="radio" name="ovr_loop_tracks" value="0" /><?php echo $text[102][$langage]; ?>
							<?php } else { ?>
							  <input type="radio" name="ovr_loop_tracks" value="1" /><?php echo $text[101][$langage]; ?>
							  <input type="radio" name="ovr_loop_tracks" value="0" checked="checked"/><?php echo $text[102][$langage]; ?>
							<?php } ?>
						</td>
					</tr>
					<!------------------------------------------------>
					<tr>
						<th><?php echo $text[103][$langage]; ?></th>
						<td align="left">
							<?php if ( $ovr_shuffle == 1 ) { ?>
							  <input type="radio" name="ovr_shuffle" value="1" checked="checked"/><?php echo $text[101][$langage]; ?>
							  <input type="radio" name="ovr_shuffle" value="0" /><?php echo $text[102][$langage]; ?>
							<?php } else { ?>
							  <input type="radio" name="ovr_shuffle" value="1" /><?php echo $text[101][$langage]; ?>
							  <input type="radio" name="ovr_shuffle" value="0" checked="checked"/><?php echo $text[102][$langage]; ?>
							<?php } ?>
						</td>
					</tr>
					<!------------------------------------------------>															
					<tr><td colspan="2" height="10"></td></tr>
					<!------------------------------------------------>
					<tr>
						<td colspan="2" align="right">
							<input type="submit" class="SUBMIT6" value=<?php echo $text[83][$langage]; ?>>
						</td>
					</tr>
				</table>
				</form>

<!-- *********************************************************************************************************** -->
			</td>
			<td align="right" width="300" valign="top">
<?php echo $player_code; ?>
			</td>		
		</tr>
		<tr><td colspan="2" height="10"></td></tr>
	</table>
</div>

<?php } else { echo "<font color=\"#FF0000\" size=\"7\">Forbidden</font>"; } ?>