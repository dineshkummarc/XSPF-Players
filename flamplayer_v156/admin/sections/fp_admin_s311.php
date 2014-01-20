<?php if ($master_page == true) { ?>

<?php
/************************************************************************************************
 * FLAM Player ADMINISTRATION - Section 3: ADD - EDIT - DELETE Authors                          *
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
		<h2><?php echo $text[63][$langage]; ?></h2><h3> <?php echo $text[64][$langage]; ?></h3>
		<div id="reduce_expand">
			<?php
					if ($mode[3] == 300) {	echo set_link($current_url, $langage, $section, $playlist, $author, $order, $direction, $active, array(0, $mode[1], $mode[2], 301), $record, $text[73][$langage]); }
					if ($mode[3] == 301) {	echo set_link($current_url, $langage, $section, $playlist, $author, $order, $direction, $active, array(0, $mode[1], $mode[2], 300), $record, $text[74][$langage]); }
			?>
		</div>
		<div id="help">
			<a href=<?php echo "\"javascript:doc_popup('../doc/fp_doc_".$langage.".html#add_edit_del_authors','2000','740')\""; ?>><?php echo $text[91][$langage]; ?></a>
		</div>
	</div>

<?php if($mode[3] == 300) { ?>

	<table width="730" border="0" align="center" cellspacing="2" cellpadding="0" id="add_form_table">
		<tr><td height="10" colspan="4"></td></tr>
		<form name="form_add_del_au" action=<?php echo "\"".set_url($current_url, $langage, $section, $playlist, $author, $order, $direction, $active, array(0, 101, 200, $mode[3]), $record)."\"" ?> method="post">
		<tr>
			<th width="386"><?php echo $text[71][$langage]; ?></th>
			<th width="70"><?php echo $text[40][$langage]; ?></th>
			<td colspan="2" class="last_col"><input name="new_name_au" type="text" size="48" maxlength="40" class="TEXT"></td>	
		</tr>
		<tr>
			<td><?php if ($message[$mode[1]] && $mode[1]>149) {echo $message[$mode[1]][$langage];} ?></td>
			<th><?php echo $text[41][$langage]; ?></th>
			<td colspan="2" class="last_col"><input name="new_email_au" type="text" size="48" maxlength="100" class="TEXT"></td>
		</tr>
		<tr>
			<td></td>
			<th><?php echo $text[42][$langage]; ?></th>
			<td class="last_col"><input name="new_website_au" type="text" size="40" maxlength="200" class="TEXT"></td>
			<td class="last_col" align="right" valign="middle"><input type="submit" class="SUBMIT2" value="&nbsp;OK&nbsp;"></td>	
		</tr>
		</form>
	</table>
		<?php
		if (count($authors_list) >0){
			echo "<table width=\"730\" border=\"0\" align=\"center\" cellspacing=\"1\" cellpadding=\"0\" id=\"add_form_table\">";
			echo "<tr><td colspan=\"5\">".$text[65][$langage]."</td></tr>";
			$altcr=0;
			foreach ($authors_list as $author){
						
						if(is_int($altcr/2)){ echo "<tr class=\"altrow2\">"; } else { echo "<tr class=\"altrow\">"; }
						
						echo "<td width=\"400\">&nbsp;".htmlentities($author->name_artist)."</th>";
						
						if($author->email_artist != NULL) {
							echo "<td width=\"35\" align=\"center\"><a href=\"mailto:".htmlentities($author->email_artist)."\">email</a></th>";}
						else {
							echo "<td width=\"35\" align=\"center\"><h5>email</h5></th>";}
							
						if($author->website_artist != NULL) {
							echo "<td width=\"35\" align=\"center\"><a href=\"".htmlentities($author->website_artist)."\" target=\"_blank\">site</a></th>";}
						else {
							echo "<td width=\"35\" align=\"center\"><h5>site</h5></th>";}
												
						if(count($authors_content[$author->id_artist]) == 0){
							echo "<form action=\"".set_url($current_url, $langage, $section, $playlist, $author, $order, $direction, $active, array(0, 102, 200, $mode[3]), $record)."\" method=\"post\">";	
							echo "<input name=\"author2del\" type=\"hidden\" value=\"".$author->id_artist."\">";
							echo "<td width=\"130\"><input type=\"submit\" class=\"SUBMIT3\" value=\"".$text[47][$langage]."\"></td>";
							echo "</form>";}
						else {
							echo "<td></td>";}
							
						echo "<form action=\"".set_url($current_url, $langage, $section, $playlist, $author, $order, $direction, $active, array(0, 103, 200, $mode[3]), $record)."\" method=\"post\">";	
						echo "<input name=\"author2edit\" type=\"hidden\" value=\"".$author->id_artist."\">";
						echo "<td width=\"130\"><input type=\"submit\" class=\"SUBMIT3\" value=\"".$text[58][$langage]."\"></td>";
						echo "</form>";
						echo "</tr>";
						$altcr++;
					
			}
			if ($message[$mode[1]] && $mode[1]<150) {echo "<tr><td colspan=\"3\">".$message[$mode[1]][$langage]."</td></tr>";}
			echo "<tr><td colspan=\"3\" height=\"14\"></td></tr>";
			echo "</table>";
		}		
		?>
		
<?php } else { 
				echo "<table width=\"730\" height=\"50\" border=\"0\" align=\"center\" cellpadding=\"0\" cellspacing=\"0\" id=\"add_form_table\">";
				echo "<tr><td align=\"center\">".$text[72][$langage]."</td></tr>";
				echo "</table>";
		} ?>
</div>

<?php } else { echo "<font color=\"#FF0000\" size=\"7\">Forbidden</font>"; } ?>