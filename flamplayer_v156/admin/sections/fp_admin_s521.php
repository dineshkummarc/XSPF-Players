<?php if ($master_page == true) { ?>

<?php
/************************************************************************************************
 * FLAM Player ADMINISTRATION - Section 5: Integrate FLAM Player in a page                      *
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
		<h2><?php echo $text[80][$langage]; ?></h2><h3> <?php echo $text[81][$langage]; ?></h3>
		<div id="help">
			<a href=<?php echo "\"javascript:doc_popup('../doc/fp_doc_".$langage.".html#integrate_in_page','2000','740')\""; ?>><?php echo $text[91][$langage]; ?></a>
		</div>
	</div>
	<table border="0" cellspacing="2" cellpadding="0" width="730" align="center" id="add_form_table">
	<tr><td height="10"></td></tr>
	<tr>
		<td>
			<?php echo $ms1.$message[101][$langage].$mde; ?>
			<form class="buildpage" name= "build_page" action=<?php echo "\"".set_url($current_url, $langage, $section, $playlist, $author, $order, $direction, $active, array(0, $mode[1], 201, $mode[3]), $record)."\"" ?> method="post">
				<?php echo $ms1.$message[102][$langage].$mde; ?>
				<a href="javascript:autoSUBMIT()"><?php echo $message[103][$langage]; ?></a>
				<input name="ovr_color" type="hidden" value=<?php echo "\"".$_POST['ovr_color']."\""; ?>>
				<input name="BG_R" type="hidden" value=<?php echo "\"".substr( $bgcolor, 0,2 )."\""; ?>>
				<input name="BG_G" type="hidden" value=<?php echo "\"".substr( $bgcolor, 2,2 )."\""; ?>>
				<input name="BG_B" type="hidden" value=<?php echo "\"".substr( $bgcolor, 4,2 )."\""; ?>>
				<input name="Custom_R" type="hidden" value=<?php echo "\"".substr( $ovr_color, 0,2 )."\""; ?>>
				<input name="Custom_G" type="hidden" value=<?php echo "\"".substr( $ovr_color, 2,2 )."\""; ?>>
				<input name="Custom_B" type="hidden" value=<?php echo "\"".substr( $ovr_color, 4,2 )."\""; ?>>
				<input name="fp_style" type="hidden" value=<?php echo "\"".$fp_style."\""; ?>>
				<input name="ovr_langage" type="hidden" value=<?php echo "\"".$ovr_langage."\""; ?>>
				<input name="ovr_playlist" type="hidden" value=<?php echo "\"".$ovr_playlist."\""; ?>>
				<input name="ovr_author" type="hidden" value=<?php echo "\"".$ovr_author."\""; ?>>
				<input name="ovr_order" type="hidden" value=<?php echo "\"".$ovr_order."\""; ?>>
				<input name="ovr_order_direction" type="hidden" value=<?php echo "\"".$ovr_order_direction."\""; ?>>
				<input name="ovr_autoplay" type="hidden" value=<?php echo "\"".$ovr_autoplay."\""; ?>>
				<input name="ovr_loop_playlist" type="hidden" value=<?php echo "\"".$ovr_loop_playlist."\""; ?>>
				<input name="ovr_loop_tracks" type="hidden" value=<?php echo "\"".$ovr_loop_tracks."\""; ?>>
				<input name="ovr_shuffle" type="hidden" value=<?php echo "\"".$ovr_shuffle."\""; ?>>
			</form>
		</td>
	</tr>
	<tr>
		<td>
			<?php 
				if ($mode[2] == 210) {
					echo $ms1.$text[87][$langage].$mde;
					echo "<a href=\"".$fp_root_url."pages/".$_POST['created_file']."\" target=\"_blank\">".dots($fp_root_url."pages/".$_POST['created_file'], 100, "...")."</a>";
				}
				
				if ($mode[2] == 211) {
					echo $message[104][$langage];
				}
			?>
		</td>
	</tr>
	<tr>
	<td>
<textarea rows="32" class="player_code" wrap="OFF">
<?php echo $player_code_trans; ?>
</textarea>
	</td>
	</tr>
	<tr><td height="10"></td></tr>
	</table>
	
</div>

<?php } else { echo "<font color=\"#FF0000\" size=\"7\">Forbidden</font>"; } ?>