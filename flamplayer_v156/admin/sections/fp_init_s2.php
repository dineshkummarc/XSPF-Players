<?php if ($master_page == true) { ?>

<?php
/************************************************************************************************
 * FLAM Player INITIALIZATION - Section 1: Admin logged / others settings                       *
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

/****************************************************
 * This is the FLAM Player initialization Section 2 *
 ****************************************************/
require_once('includes/ez_sql.php');

// Check access and rights
// Is the musics directory reachable ?
$musics_url = $_POST['musics_url'];
$musics_local_path = $_POST['musics_local_path'];

if ( $musics_reachable = @opendir($musics_local_path)) { @closedir($musics_reachable); }

// Is the musics directory writable ?
if ( $musics_reachable ) {
	$access = view_perms($musics_local_path);
	if ( $access == 777 ) {
		$musics_access = true;
		$report[0] = $text[200][$langage];
	}
	else { 
		$musics_access = false;
		$report[0] = $text[201][$langage];
	}
}
else {
	$report[0] = $text[202][$langage];
}

// Is fp_settings_2.xml writable ?
$access = view_perms("../settings/fp_settings_2.xml");
if ( $access == 777 || $access == 666 ) { // 666 check for windows hostings (file is in chmod 666 by default but is writable)
	$fps2_access = true;
	$report[1] = $text[200][$langage];
}
else { 
	$fps2_access = false;
	$report[1] = $text[201][$langage];
}

// Is the pages directory writable ?
$access = view_perms("../pages");
if ( $access == 777 ) {
	$pages_access = true;
	$report[2] = $text[200][$langage];
}
else { 
	$pages_access = false;
	$report[2] = $text[201][$langage];
}


// Body DIV Start
echo "<div id=\"block_init\">";

?>
	
<form action=<?php echo "\"".$current_url."\"" ?> method="post">
<table width="730" border="0" align="center" cellspacing="1" cellpadding="0" id="add_form_table">
	<tr><td height="10"></td></tr>
	<tr><th height="30"><?php echo $text[7][$langage]; ?></th></tr>
	<tr>
	<tr><td height="10"></td></tr>
		<td>
			
			<table border="0" cellspacing="2" cellpadding="0">
				<tr align="center">
					<td rowspan="2" width="5"></td>
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
						if ($color_preset == "custom"){
							echo "<td><input type=\"radio\" name=\"color\" value=\"".$color_preset."\" checked></td>";}
						else {
							echo "<td><input type=\"radio\" name=\"color\" value=\"".$color_preset."\"></td>";}
					}
					?>
					<td><input type="text" name="Custom_R" maxlength="2" class="RGB" value=<?php echo "\"".substr( $color, 0,2 )."\""; ?>></td>
					<td><input type="text" name="Custom_G" maxlength="2" class="RGB" value=<?php echo "\"".substr( $color, 2,2 )."\""; ?>></td>
					<td><input type="text" name="Custom_B" maxlength="2" class="RGB" value=<?php echo "\"".substr( $color, 4,2 )."\""; ?>></td>
				</tr>
			</table>
			
		</td>
	</tr>
	<tr><td height="10"></td></tr>		
	<tr><th height="30"><?php echo $text[8][$langage]; ?></th></tr>
	<tr><td height="10"></td></tr>
	<tr>
		<td>&nbsp;
			<select class="filter_list2" name="langage">
					<?php
						foreach( $langages_list as $langage_item ) {
							if ($langage_item['value'] == $default_langage) {
								echo "<option value=\"".$langage_item['value']."\" selected>".$langage_item['text'.$langage]."</option>";
							} else {
								echo "<option value=\"".$langage_item['value']."\">".$langage_item['text'.$langage]."</option>";
							}
						}					
					?>
			</select>
		</td>
	</tr>
	<tr><td height="10"></td></tr>		
	<tr><th height="30"><?php echo $text[103][$langage]; ?></th></tr>
	<tr><td height="10"></td></tr>
	<tr>
		<td>
			<table border="0" cellspacing="2" cellpadding="0">
				<tr>
					<td><?php echo $text[97][$langage]; ?></td>
					<td width="100" align="right">
						<?php if ( $autoplay == 1 ) { ?>
						  <input type="radio" name="autoplay" value="1" checked="checked"/><?php echo $text[101][$langage]; ?>
						  <input type="radio" name="autoplay" value="0" /><?php echo $text[102][$langage]; ?>
						<?php } else { ?>
						  <input type="radio" name="autoplay" value="1" /><?php echo $text[101][$langage]; ?>
						  <input type="radio" name="autoplay" value="0" checked="checked"/><?php echo $text[102][$langage]; ?>
						<?php } ?>					
					</td>
				</tr>
				<tr>
					<td><?php echo $text[98][$langage]; ?></td>
					<td align="right">
						<?php if ( $loop_playlist == 1 ) { ?>
						  <input type="radio" name="loop_playlist" value="1" checked="checked"/><?php echo $text[101][$langage]; ?>
						  <input type="radio" name="loop_playlist" value="0" /><?php echo $text[102][$langage]; ?>
						<?php } else { ?>
						  <input type="radio" name="loop_playlist" value="1" /><?php echo $text[101][$langage]; ?>
						  <input type="radio" name="loop_playlist" value="0" checked="checked"/><?php echo $text[102][$langage]; ?>
						<?php } ?>
					</td>
				</tr>
				<tr>
					<td><?php echo $text[99][$langage]; ?></td>				
					<td align="right">
						<?php if ( $loop_tracks == 1 ) { ?>
						  <input type="radio" name="loop_tracks" value="1" checked="checked"/><?php echo $text[101][$langage]; ?>
						  <input type="radio" name="loop_tracks" value="0" /><?php echo $text[102][$langage]; ?>
						<?php } else { ?>
						  <input type="radio" name="loop_tracks" value="1" /><?php echo $text[101][$langage]; ?>
						  <input type="radio" name="loop_tracks" value="0" checked="checked"/><?php echo $text[102][$langage]; ?>
						<?php } ?>
					</td>
				</tr>
				<tr>
					<td><?php echo $text[100][$langage]; ?></td>				
					<td align="right">
						<?php if ( $shuffle == 1 ) { ?>
						  <input type="radio" name="shuffle" value="1" checked="checked"/><?php echo $text[101][$langage]; ?>
						  <input type="radio" name="shuffle" value="0" /><?php echo $text[102][$langage]; ?>
						<?php } else { ?>
						  <input type="radio" name="shuffle" value="1" /><?php echo $text[101][$langage]; ?>
						  <input type="radio" name="shuffle" value="0" checked="checked"/><?php echo $text[102][$langage]; ?>
						<?php } ?>
					</td>
				</tr>													
			</table>
		</td>
	</tr>
	<tr><td height="10"></td></tr>
	<tr><th height="30"><?php echo $text[10][$langage]; ?></th></tr>
	<tr><td height="10"></td></tr>
	<tr>
		<td>&nbsp;&nbsp;<input type="text" name="buffer" maxlength="2" class="RGB" value=<?php echo "\"".$buffer_time."\""; ?>>&nbsp;Sec</td>
	</tr>	
	<tr><td height="10"></td></tr>
	<tr><th><?php echo $text[94][$langage]; ?></th></tr>
	<tr>
		<td>
			<table border="0" cellspacing="10" cellpadding="0" width="100%">
				<tr>
					<td height="30" width="150"><?php echo $text[93][$langage].": "; ?></td>
					<td><?php 
							echo "<div id=\"div_w\">".$musics_url."</div><br>(".$musics_local_path.")"; 
						?></td>
					<td align="right"><?php echo $report[0]; ?></td>
					<input type="hidden" name="musics_url" value="<?php echo $musics_url; ?>" />
					<input type="hidden" name="musics_local_path" value="<?php echo $musics_local_path; ?>" />
				</tr>
				<tr>
					<td height="30" width="150"><?php echo $text[95][$langage].": "; ?></td>
					<td><div id="div_w">FLAM_PLAYER_ROOT/settings/fp_settings_2.xml</div></td>
					<td align="right"><?php echo $report[1]; ?></td>
				</tr>
				<tr>
					<td height="30" width="150"><?php echo $text[96][$langage].": "; ?></td>
					<td><div id="div_w">FLAM_PLAYER_ROOT/pages</div></td>
					<td align="right"><?php echo $report[2]; ?></td>
				</tr>				
			</table>
		</td>
	</tr>
	<tr><td height="20"></td></tr>
	<tr>
		<td align="center">
		<?php if ( $musics_reachable && $musics_access && $fps2_access && $pages_access ) { ?>
			<input type="submit" class="SUBMIT4" value=<?php echo "\"".$text[83][$langage]."\""; ?>>
		<?php } ?>
		</td>
	</tr>
</table>
</form>

<?php
// Body DIV End
echo "</div>";

?>

<?php } else { echo "<font color=\"#FF0000\" size=\"7\">Forbidden</font>"; } ?>