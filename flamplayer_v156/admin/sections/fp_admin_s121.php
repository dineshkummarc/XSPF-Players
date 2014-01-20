<?php if ($master_page == true) { ?>

<?php
/************************************************************************************************
 * FLAM Player ADMINISTRATION - Section 1: INTEGRATION Automatic tracks recording               *
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
		<h2><?php echo $text[26][$langage]; ?></h2><h3> <?php echo $text[27][$langage]; ?></h3>
		<div id="help">
			<a href=<?php echo "\"javascript:doc_popup('../doc/fp_doc_".$langage.".html#auto_record','2000','740')\""; ?>><?php echo $text[91][$langage]; ?></a>
		</div>
	</div>
	
	<form name="form_quickscan_add" action=<?php echo "\"".set_url($current_url, $langage, $section, $playlist, $author, $order, $direction, $active, array(0, 100, 201, $mode[3]), $record)."\"" ?> method="post">
	<table width="730" border="0" align="center" cellspacing="2" cellpadding="0" id="add_form_table">
		<tr><td height="5"></td></tr>
		<tr>
			<th><?php echo $text[35][$langage]; ?></th>
		</tr>
		<tr>
			<td>
				<select name="fadd_qs_files[]" class="LARGE_LIST" size=<?php echo "\"".count($filelist['filename'])."\""; ?> multiple>
   				<?php 
						for($i=0; $i<count($filelist['filename']); $i++) { 
							if(is_int($i/2)){
								echo 	"<option class=\"add_op1\" value=\"".$filelist['filename'][$i]."\">"
										."[".$filelist['id3_artist'][$i]."]&nbsp;&nbsp;"
										."[".$filelist['id3_title'][$i]."]&nbsp;&nbsp;"
										.us2space($filelist['filename'][$i])
										."</option>";}
							else {
								echo 	"<option value=\"".$filelist['filename'][$i]."\">"
										."[".$filelist['id3_artist'][$i]."]&nbsp;&nbsp;"
										."[".$filelist['id3_title'][$i]."]&nbsp;&nbsp;"
										.us2space($filelist['filename'][$i])
										."</option>";}
						}
					?>
   			</select>
			</td>
		</tr>
		<tr><td height="15"></td></tr>
		<tr>
			<td>
				<?php echo $text[36][$langage]; ?>
				<select name="fadd_qs_playlist" class="LIST" tabindex="7">
								<?php
								foreach( $playlists_list as $playlist_item ) {
										echo "<option value=\"".$playlist_item."\">".dots($playlist_item, 20, "...")."</option>";
								}
								?>
				</select>
				<?php echo $text[37][$langage]; ?>
				<input name="fadd_qs_newpl" type="text" size="20" maxlength="25" class="TEXT">
			</td>
		</tr>
		<tr>
			<td height="35" align="center" valign="bottom"><input type="submit" class="SUBMIT4" value="<?php echo $text[92][$langage]; ?>"></td>
		</tr>
		<tr>
			<td align="center" height="25">
				<?php if ($message[$mode[2]]) {echo $message[$mode[2]][$langage];} ?>
			</td>
		</tr>
		<tr><td height="15"></td></tr>
	</table>
	</form>	
</div>

<?php } else { echo "<font color=\"#FF0000\" size=\"7\">Forbidden</font>"; } ?>