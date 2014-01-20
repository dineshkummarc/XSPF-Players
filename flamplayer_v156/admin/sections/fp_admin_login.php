<?php if ($master_page == true) { ?>
<?php
/************************************************************************************************
 * FLAM Player ADMINISTRATION - Admin Login                                                     *
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

	echo 	"<div id=\"login\">";
	
	echo	"<form action=\"".set_url($current_url, $langage, $section, $playlist, $author, $order, $direction, $active, $mode, $record)."\" method=\"post\">".
			"<table border=\"0\" align=\"right\" cellspacing=\"1\" cellpadding=\"0\" id=\"add_form_table\">".
			"<tr>".
			"<th height=\"18\">".
			$text[88][$langage].			
			"</th>".
			"<td class=\"last_col\">".
			"<input name=\"login\" type=\"text\"".get_login()." class=\"TEXT\">".
			"</td>".
			"</tr>".
			
			"<tr>".
			"<th height=\"18\">".
			$text[89][$langage]."&nbsp;&nbsp;".
			"</th>".
			"<td class=\"last_col\">".
			"<input name=\"password\" type=\"password\" class=\"TEXT\">".
			"</td>".
			"</tr>".
			
			"<tr>".
			"<td>".
			"</td>".
			"<td align=\"right\">".
			"<input type=\"submit\" class=\"SUBMIT2\" value=\"OK\">".
			"</td>".
			"</tr>";
			
if ($bad_log_pass == true) {
	echo "<tr>";
	echo "<td colspan=\"2\" height=\"40\" align=\"left\">";
	echo "<div id=\"message_head_w\">".$text[90][$langage]."</div>";
	echo "</td>";
	echo "</tr>";
}

	echo "</table>";
	echo "</form>";
	echo "&nbsp;";		
echo		"</div>";
?>

<?php } else { echo "<font color=\"#FF0000\" size=\"7\">Forbidden</font>"; } ?>