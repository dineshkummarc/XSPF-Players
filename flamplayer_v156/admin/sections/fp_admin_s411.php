<?php if ($master_page == true) { ?>

<?php
/************************************************************************************************
 * FLAM Player ADMINISTRATION - Section 4: ADD - DELETE Playlists                               *
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
		<h2><?php echo $text[57][$langage]; ?></h2><h3> <?php echo $text[56][$langage]; ?></h3>
		<div id="reduce_expand">
			<?php
					if ($mode[3] == 300) {	echo set_link($current_url, $langage, $section, $playlist, $author, $order, $direction, $active, array(0, $mode[1], $mode[2], 301), $record, $text[73][$langage]); }
					if ($mode[3] == 301) {	echo set_link($current_url, $langage, $section, $playlist, $author, $order, $direction, $active, array(0, $mode[1], $mode[2], 300), $record, $text[74][$langage]); }
			?>
		</div>
		<div id="help">
			<a href=<?php echo "\"javascript:doc_popup('../doc/fp_doc_".$langage.".html#add_del_playlists','2000','740')\""; ?>><?php echo $text[91][$langage]; ?></a>
		</div>
	</div>
	
<?php if($mode[3] == 300) { ?>
	
	<table width="730" border="0" align="center" cellspacing="1" cellpadding="0" id="add_form_table">
		<tr><td colspan="3" height="10"></td></tr>
		<tr>
			<form name="form_add_del_pl" action=<?php echo "\"".set_url($current_url, $langage, $section, $playlist, $author, $order, $direction, $active, array(0, 101, 200, $mode[3]), $record)."\"" ?> method="post">
			<th width="600"><?php echo $text[44][$langage]; ?></th>
			<td><input name="new_playlist" type="text" size="23" maxlength="25" class="TEXT"></td>
			<td><input type="submit" class="SUBMIT3" value="&nbsp;OK&nbsp;"></td>
			</form>
		</tr>
		<tr><td colspan="3" height="10"></td></tr>
		
		<?php
		if ($pl_empty > 0){
			echo "<tr><td colspan=\"3\">".$text[59][$langage]."</td></tr>";
			$altcr=0;
			foreach ($playlists_list as $playlist_item){
					if ($playlist_item != "default_playlist" && count($playlists_content[$playlist_item]) == 0){
						if(is_int($altcr/2)){ echo "<tr class=\"altrow\">"; } else { echo "<tr class=\"altrow2\">"; }
	
						echo "<td colspan=\"2\">&nbsp;".$playlist_item."</th>";
						
						echo "<form action=\"".set_url($current_url, $langage, $section, $playlist, $author, $order, $direction, $active, array(0, 102, 200, $mode[3]), $record)."\" method=\"post\">";	
						echo "<input name=\"playlist2del\" type=\"hidden\" value=\"".htmlspecialchars($playlist_item)."\">";
						echo "<td><input type=\"submit\" class=\"SUBMIT3\" value=\"".$text[47][$langage]."\"></td>";
						echo "</form>";
						echo "</tr>";
						$altcr++;
					}
			}
		}
		
		if ($message[$mode[1]]) {echo "<tr><td colspan=\"3\">".$message[$mode[1]][$langage]."</td></tr>";}
		?>
		<tr><td colspan="3" height="14"></td></tr>
	</table>

<?php } else { 
				echo "<table width=\"730\" height=\"50\" border=\"0\" align=\"center\" cellpadding=\"0\" cellspacing=\"0\" id=\"add_form_table\">";
				echo "<tr><td align=\"center\">".$text[72][$langage]."</td></tr>";
				echo "</table>";
		} ?>
</div>

<?php } else { echo "<font color=\"#FF0000\" size=\"7\">Forbidden</font>"; } ?>