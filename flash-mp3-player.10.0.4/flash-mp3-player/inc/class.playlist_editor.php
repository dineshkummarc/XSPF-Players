<?php
class FMP_Playlist_Editor{
var $playlist_dir;
var $current_playlist;
var $playlist_array;
var $updated_message;
var $error_message;

function FMP_Playlist_Editor(){
    global $fmp_jw_files_dir;
    $this->playlist_dir = $fmp_jw_files_dir . '/playlists';
    $this->update_playlist_array();
    add_action('admin_head', array(&$this, 'admin_js'));
}

function update_playlist_array(){
    $this->playlist_array = array();
    $temp = scandir($this->playlist_dir);
    foreach($temp as $playlist){
        if(strpos($playlist, '.xml') !== false){
            $this->playlist_array[] = $playlist;
        }
    }
    unset($temp);
}

function add_menu_item(){
    add_options_page('Flash MP3 Player -> Playlist Editor', 'FMP:Playlist Editor', 8, 'fmp_playlist_editor', array(&$this, 'edit_a_playlist_file'));
}

function edit_a_playlist_file(){
    if(isset($_POST['delete-playlist'])){
        if(!empty($_POST['select-file'])){
            unlink($this->playlist_dir . '/' . $_POST['select-file']);
            $this->update_playlist_array();
            $this->updated_message = '<p>The playlist file : '. $_POST['select-file'] .' has been deleted.</p>';
        }
    }
    
    if(isset($_POST['edit-playlist'])){
        $this->current_playlist = $_POST['select-file'];
    }else if(isset($_POST['current-edit-list'])){
        $this->current_playlist = $_POST['current-edit-list'];
    }else{
        $this->current_playlist = $this->playlist_array[0];
    }
    
    if(isset($_POST['save-changes'])){
        $newinfos = $_POST['songsinfo'];
        $songs = array();
        foreach($newinfos as $song){
            $songs[] = $song;
        }
        $this->save_playlist($songs, $this->playlist_dir . '/' . $this->current_playlist);
        $this->updated_message = '<p>Your change on '. $this->current_playlist.' has been saved.</p>';
    }
    
    $songs = array();
    if(isset($_POST['create-new-playlist'])){
        if(!empty($_POST['new-filename'])){
            $filename = sanitize_title($_POST['new-filename']);
            $this->current_playlist = $filename . '.xml';
            $this->updated_message = '<p>Playlist file : '. $filename .'.xml has been created and now you are editting it.</p>';
        }else{
            $this->error_message = '<p>You should input the file name.</p>';
            $this->load_playlist($songs, $this->playlist_dir . '/' . $this->current_playlist);
        }
    }else{
        $this->load_playlist($songs, $this->playlist_dir . '/' . $this->current_playlist);
    }


?>

<div class="wrap">
    <h2>MP3 Player Playlist Eidtor</h2>
    <?php $this->display_message();?>
    <p><?php _e('Visit the <a href="http://sexywp.com/flash-player-widget.htm">plugin\'s homepage</a> for further details. If you find a bug, or have a fantastic idea for this plugin, <a href="mailto:charlestang@foxmail.com">feel free to send me a email</a> !', 'fmp'); ?><br /><a href="http://sexywp.com/forum/">Now you can visit forum to share your idea with other users.</a></p>
    <?php $phpver = phpversion(); if (floatval(substr($phpver,0,3)) < 5.0) :?>
    <p>Your PHP version is <?php echo $phpver; ?>. The playlist editor cannot work in PHP 4.x environment.</p>
    <?php endif;?>
    <p><strong>Feel absolutely free to </strong>
        <form action="https://www.paypal.com/cgi-bin/webscr" method="post">
            <input type="hidden" name="cmd" value="_s-xclick">
            <input type="hidden" name="encrypted" value="-----BEGIN PKCS7-----MIIHNwYJKoZIhvcNAQcEoIIHKDCCByQCAQExggEwMIIBLAIBADCBlDCBjjELMAkGA1UEBhMCVVMxCzAJBgNVBAgTAkNBMRYwFAYDVQQHEw1Nb3VudGFpbiBWaWV3MRQwEgYDVQQKEwtQYXlQYWwgSW5jLjETMBEGA1UECxQKbGl2ZV9jZXJ0czERMA8GA1UEAxQIbGl2ZV9hcGkxHDAaBgkqhkiG9w0BCQEWDXJlQHBheXBhbC5jb20CAQAwDQYJKoZIhvcNAQEBBQAEgYB2EQv1+Soj5NuujXdg/QZIJQFfTlpI4CrvIpXMrkKBUhuGpJq/KexrQLkDnw45I1d2AWVq6l7uL9uRXcCbDpHGBniU0D2rzdRyDEOTMFc3+yYXX/uv2RE4rFzMxoIWuZBw5W5SXNRFpJAmKbFmrSK3UUicBCZklAj1DrYFPQVnPDELMAkGBSsOAwIaBQAwgbQGCSqGSIb3DQEHATAUBggqhkiG9w0DBwQIVk6DhKRNuNKAgZA4swjsh6HombF5EuT3QaCFPWvOtvT/FW6A/Pz7vfpx5D61OyR8XTkEf5y2go/iNUPXA2bsEhU2CwpwSZoTK38QFtv1RZsZk980lo0MGAbzd/eFko/zDE1Yq6JSJtgdTWQr1Rebd1/8cOfORXi7ijDlsMf3MpXTIWghhVVSsvPVOQdFq3CkUU2DkShWuxCI8segggOHMIIDgzCCAuygAwIBAgIBADANBgkqhkiG9w0BAQUFADCBjjELMAkGA1UEBhMCVVMxCzAJBgNVBAgTAkNBMRYwFAYDVQQHEw1Nb3VudGFpbiBWaWV3MRQwEgYDVQQKEwtQYXlQYWwgSW5jLjETMBEGA1UECxQKbGl2ZV9jZXJ0czERMA8GA1UEAxQIbGl2ZV9hcGkxHDAaBgkqhkiG9w0BCQEWDXJlQHBheXBhbC5jb20wHhcNMDQwMjEzMTAxMzE1WhcNMzUwMjEzMTAxMzE1WjCBjjELMAkGA1UEBhMCVVMxCzAJBgNVBAgTAkNBMRYwFAYDVQQHEw1Nb3VudGFpbiBWaWV3MRQwEgYDVQQKEwtQYXlQYWwgSW5jLjETMBEGA1UECxQKbGl2ZV9jZXJ0czERMA8GA1UEAxQIbGl2ZV9hcGkxHDAaBgkqhkiG9w0BCQEWDXJlQHBheXBhbC5jb20wgZ8wDQYJKoZIhvcNAQEBBQADgY0AMIGJAoGBAMFHTt38RMxLXJyO2SmS+Ndl72T7oKJ4u4uw+6awntALWh03PewmIJuzbALScsTS4sZoS1fKciBGoh11gIfHzylvkdNe/hJl66/RGqrj5rFb08sAABNTzDTiqqNpJeBsYs/c2aiGozptX2RlnBktH+SUNpAajW724Nv2Wvhif6sFAgMBAAGjge4wgeswHQYDVR0OBBYEFJaffLvGbxe9WT9S1wob7BDWZJRrMIG7BgNVHSMEgbMwgbCAFJaffLvGbxe9WT9S1wob7BDWZJRroYGUpIGRMIGOMQswCQYDVQQGEwJVUzELMAkGA1UECBMCQ0ExFjAUBgNVBAcTDU1vdW50YWluIFZpZXcxFDASBgNVBAoTC1BheVBhbCBJbmMuMRMwEQYDVQQLFApsaXZlX2NlcnRzMREwDwYDVQQDFAhsaXZlX2FwaTEcMBoGCSqGSIb3DQEJARYNcmVAcGF5cGFsLmNvbYIBADAMBgNVHRMEBTADAQH/MA0GCSqGSIb3DQEBBQUAA4GBAIFfOlaagFrl71+jq6OKidbWFSE+Q4FqROvdgIONth+8kSK//Y/4ihuE4Ymvzn5ceE3S/iBSQQMjyvb+s2TWbQYDwcp129OPIbD9epdr4tJOUNiSojw7BHwYRiPh58S1xGlFgHFXwrEBb3dgNbMUa+u4qectsMAXpVHnD9wIyfmHMYIBmjCCAZYCAQEwgZQwgY4xCzAJBgNVBAYTAlVTMQswCQYDVQQIEwJDQTEWMBQGA1UEBxMNTW91bnRhaW4gVmlldzEUMBIGA1UEChMLUGF5UGFsIEluYy4xEzARBgNVBAsUCmxpdmVfY2VydHMxETAPBgNVBAMUCGxpdmVfYXBpMRwwGgYJKoZIhvcNAQkBFg1yZUBwYXlwYWwuY29tAgEAMAkGBSsOAwIaBQCgXTAYBgkqhkiG9w0BCQMxCwYJKoZIhvcNAQcBMBwGCSqGSIb3DQEJBTEPFw0wOTAzMjQyMDQ1NDZaMCMGCSqGSIb3DQEJBDEWBBQ3cx3dDHdv7A/xMHsq+rw48zXFyzANBgkqhkiG9w0BAQEFAASBgFZCHyUMzqEn5brB/9GbvZMeMIbAVdOvZOuBO9pRTc+NCgXT0EIDgHlGNPZgES9aWbrNDTgWeACMKItOCX/9eKMXcrnj+wOh6+8eoBUdQY0hKw4GrcSkpFvNnKLByUv8q4iY0PpCWIzZ8S+ckANkg92HLykSbe2sI2p60bLbBd0+-----END PKCS7-----">
            <input type="image" src="https://www.paypal.com/en_US/i/btn/x-click-but21.gif" border="0" name="submit" alt="PayPal - The safer, easier way to pay online!">
            <img alt="" border="0" src="https://www.paypal.com/zh_XC/i/scr/pixel.gif" width="1" height="1">
        </form>
    </p>
<form method="post">


<h3> Playlists Management</h3>
<table class="form-table">
    <tody>
        <tr valign="top">
            <th scope="row">Select a playlit</th>
            <td>
                <select id="select-file" name="select-file">
                    <?php
                    foreach($this->playlist_array as $playlistfile){
                        echo '<option value="', $playlistfile , '"';
                        if ($this->current_playlist == $playlistfile)
                            echo ' selected="selected" ';
                        echo '>', $playlistfile, '</option>';
                    }?>
                </select>
                <input type="submit" name="edit-playlist" class="button-primary" value="Edit" />
                <input type="submit" name="delete-playlist" class="button-highlighted" value="Delete" />
            </td>
        </tr>
        <tr valign="top">
            <th scope="row">Create new list</th>
            <td>
                File Name:<input type="text" class="reqular-text" value="" name="new-filename" />
                <input type="submit" class="button-secondary" value="Create a new playlist" name="create-new-playlist" />
            </td>
        </tr>
    </tody>
</table>

<h3> Currently Editing Playlist: <span style="color:red;font-weight:bold" ><?php echo $this->current_playlist; ?></span> </h3>

<p>
    <input type="button" name="add-new" value="Add New" class="button-highlighted" />
    <input type="button" name="delete-checked" value="Delete all checked" class="button-highlighted" />

</p>

<table class="widefat fixed">
    <thead>
        <tr>
            <th id="cb" class="manage-column column-cb check-column" scope="col"><input type="checkbox" /></th>
            <th id="albumimg" class="manage-column column-albumimg" scope="col" width="105px">Album Picture</th>
            <th id="songinof" class="manage-column column-songinfo" scope="col">Song Info</th>
        </tr>
    </thead>
    <tfoot>
        <tr>
            <th class="manage-column column-cb check-column" scope="col"><input type="checkbox" /></th>
            <th class="manage-column column-albumimg" scope="col">Album Picture</th>
            <th class="manage-column column-songinfo" scope="col">Song Info</th>
        </tr>
    </tfoot>

    <tbody id="songs-list">
<?php $i = 0; foreach($songs as $song) :?>
        <tr>
            <th class="check-column" scope="row"><input type="checkbox" /></th>
            <td><img width="100" height="100" src="<?php echo $song['image'];?>" /></td>
            <td class="form-table">
                <p><label for="song-title-<?php echo $i;?>">Song Title:</label><input id="song-title-<?php echo $i;?>" type="text" name="songsinfo[<?php echo $i;?>][annotation]" class="regular-text" value="<?php echo $song['annotation'];?>" /><label for="song-link-<?php echo $i;?>">Link to:</label><input id="song-link-<?php echo $i;?>" type="text" name="songsinfo[<?php echo $i;?>][info]" class="regular-text" value="<?php echo $song['info'];?>" /></p>
                <p><label for="song-src-<?php echo $i;?>">Song's URL:</label><input id="song-src-<?php echo $i;?>" type="text" name="songsinfo[<?php echo $i;?>][location]" value="<?php echo $song['location'];?>" size="80" /></p>
                <p><label for="song-image-<?php echo $i;?>">Image URL:</label><input class="songimage" id="song-image-<?php echo $i;?>" type="text" name="songsinfo[<?php echo $i;?>][image]" value="<?php echo $song['image'];?>" size="80" /></p>
            </td>
        </tr>

<?php $i++; endforeach;?>
        <tr class="template-row" style="display:none">
            <th class="check-column" scope="row"><input type="checkbox" /></th>
            <td><img width="100" height="100" src="" /></td>
            <td class="form-table">
                <p><label for="">Song Title:</label><input type="text" name="" class="regular-text songtitle" value="" /><label for="">Link to:</label><input type="text" name="" class="regular-text songlink" value="" /></p>
                <p><label for="">Song's URL:</label><input type="text" name="" class="songurl" value="" size="80" /></p>
                <p><label for="">Image URL:</label><input type="text" name="" class="songimage" value="" size="80" /></p>
            </td>
        </tr>


    </tbody>
</table>
<p>
    <input type="button" name="add-new" value="Add New" class="button-highlighted" />
    <input type="button" name="delete-checked" value="Delete all checked" class="button-highlighted" />

</p>

<p>
    <input type="hidden" name="current-edit-list" value="<?php echo $this->current_playlist;?>" />
    <input type="submit" name="save-changes" value="Save changes" class="button-primary" />
</p>

</form>
</div>



<?php

}

function display_message(){
    if(!empty($this->updated_message)){
        echo '<div class="updated">' . $this->updated_message . '</div>';
    }else if(!empty($this->error_message)){
        echo '<div class="error">' . $this->error_message . '</div>';
    }
}


function load_playlist(&$songs, $filename){
    $doc = new DOMDocument('1.0', 'UTF-8');
    $doc->load($filename);
    $tracklists = $doc->getElementsByTagName('trackList');
    $songs = array();
    foreach($tracklists as $tracklist){

        $tracks = $tracklist->getElementsByTagName('track');
        foreach($tracks as $track){
            $song = array();
            foreach($track->childNodes as $node){
                if($node->nodeType == XML_ELEMENT_NODE){
                    $song[$node->nodeName] = $node->nodeValue;
                }
            }
            $songs[] = $song;
        }

    }
}

function save_playlist(&$songs, $filename){
    $doc = new DOMDocument('1.0', 'UTF-8');
    $root = $doc->createElement('playlist');
    $tracklist = $doc->createElement('trackList');
    foreach($songs as $song){
        $track = $doc->createElement('track');
        foreach($song as $key => $val){
            $track->appendChild($doc->createElement($key, $val));
        }
        $tracklist->appendChild($track);
    }
    $root->appendChild($tracklist);
    $doc->appendChild($root);
    $doc->formatOutput = true;
    $doc->save($filename);
}




function admin_js(){
    ?>

<script type="text/javascript">
(function($){


$(document).ready(function(){
    //these two lines used to make the color of table head and foot same in wp 2.6
    $table = $('table.widefat:first');
    $('tfoot', $table).css("backgroundColor", $('thead', $table).css('backgroundColor'));

    $('input[name=add-new]').click(function(){
        $newrow = $('tr.template-row:first').clone();
        $songlist = $('#songs-list');
        if($songlist.length < 1) return;
        var len = $('#songs-list tr:not(.template-row)').length;
        $('input.songtitle', $newrow).attr('name', 'songsinfo[' + len + '][annotation]');
        $('input.songlink' , $newrow).attr('name', 'songsinfo[' + len + '][info]');
        $('input.songurl'  , $newrow).attr('name', 'songsinfo[' + len + '][location]');
        $('input.songimage', $newrow).attr('name', 'songsinfo[' + len + '][image]')
            .blur(function(){
                $(this).parents('tr').find('img:first').attr('src', $(this).val());
            });
        $newrow.removeClass("template-row").show();
        $songlist.append($newrow);
    });

    $('input[name=delete-checked]').click(function(){
        $(".check-column input[type=checkbox]:checked").parents("tr").remove();
    });

    $('input.songimage').blur(function(){
        $(this).parents('tr').find('img:first').attr('src', $(this).val());
    });


});








})(jQuery);
</script>



    <?php
}













}
?>
