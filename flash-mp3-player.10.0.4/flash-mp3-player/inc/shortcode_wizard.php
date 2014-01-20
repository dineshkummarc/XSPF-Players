<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml"  dir="ltr" lang="zh-CN">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<link rel='stylesheet' href='css/wp-admin.css' type='text/css' media='all' />
<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.3.2/jquery.min.js"></script>
<script type="text/javascript">
$(document).ready(function(){
    $('#insert-button').click(function(){
        width = $('#fmp-jw-widget-width').val();
        height = $('#fmp-jw-widget-height').val();
        config = $('#fmp-jw-widget-config').val();
        playlist = $('#fmp-jw-widget-playlist').val();
        file = $('#fmp-jw-widget-file').val();
        id = $('#fmp-jw-widget-id').val();
        cclass=$('#fmp-jw-widget-class').val();
        shortcode = '';
        shortcode += '[mp3player';
        if(width != '')
            shortcode += ' width=' + width;
        if(height != '')
            shortcode += ' height=' + height;
        if (config != '')
            shortcode += ' config=' + config;
        else{
            alert('Please create a config file first!');
            window.parent.send_to_editor('');
            return;
        }
        if (playlist != '')
            shortcode += ' playlist=' + playlist;
        if (id != '')
            shortcode += ' id=' + id;
        if (cclass != '')
            shortcode += ' class=' + cclass;
        if (file != '')
            shortcode += ' file=' + file;
        if (playlist == '' && file == ''){
            alert('You should tell the player a playlist or a single song url!');
            window.parent.send_to_editor('');
            return;
        }
        shortcode += ']'
        window.parent.send_to_editor(shortcode);
    });
});
    
    
</script>
<style type="text/css">
body{
    text-align:center;
    width:90%;
    font-family:"Lucida Grande",Verdana,Arial,"Bitstream Vera";
}
#wpcontent{
    text-align:left;
    margin: 20px auto;
    padding:20px 20px;
}
</style>
</head>
<body>
<?php
$config_file_dir = $_REQUEST['config'];
$playlist_file_dir = $_REQUEST['playlist'];

$config_files = array();
$playlist_files = array();
$temp = array();
$temp = scandir($config_file_dir);
foreach($temp as $name){
    if(strpos($name, '.xml') !== false)
    $config_files[] = $name;
}
$temp = array();
$temp = scandir($playlist_file_dir);
foreach($temp as $name){
    if(strpos($name, '.xml') !== false)
    $playlist_files[] = $name;
}
unset($temp,$name);
?>
<div id="wpcontent">
<form class="form-table">
<p>
    <label for="fmp-jw-widget-width">
        Width:<input id="fmp-jw-widget-width" name="fmp-jw-widget[<?php echo $number;?>][width]" type="text" value="<?php echo $width;?>" class="widefat" />
        <br/><small>Just input the number, the unit is pixel.</small>
    </label>
</p>
<p>
    <label for="fmp-jw-widget-height">
        Height:<input id="fmp-jw-widget-height" name="fmp-jw-widget[<?php echo $number;?>][height]" type="text" value="<?php echo $height;?>" class="widefat" />
        <br/><small>Just input the number, the unit is pixel.</small>
    </label>
</p>
<p>
    <label for="fmp-jw-widget-config">
        Choose a config file:
        <select id="fmp-jw-widget-config" name="fmp-jw-widget[<?php echo $number;?>][config_url]" >
            <?php foreach($config_files as $config_file) :?>
            <option value="<?php echo $config_file;?>" <?php if($config_file == $config_url) echo ' selected="selected" ';?>><?php echo $config_file;?></option>
            <?php endforeach;?>
        </select>
    </label>
</p>
<p>
    <label for="fmp-jw-widget-playlist">
        Choose a playlist:
        <select id="fmp-jw-widget-playlist" name="fmp-jw-widget[<?php echo $number;?>][playlist_url]" >
            <option value="">Without Playlist and Play Single Song</option>
            <?php foreach($playlist_files as $playlist_file) :?>
            <option value="<?php echo $playlist_file;?>" <?php if($playlist_file == $playlist_url) echo ' selected="selected" ';?>><?php echo $playlist_file;?></option>
            <?php endforeach;?>
        </select>
    </label>
</p>
<p>
    <label for="fmp-jw-widget-id">
        Container <code>id</code>:<input id="fmp-jw-widget-id" name="fmp-jw-widget[<?php echo $number;?>][container_id]" type="text" value="<?php echo $container_id;?>" class="widefat" />
    </label>
</p>
<p>
    <label for="fmp-jw-widget-class">
        Container <code>class</code>:<input type="text" id="fmp-jw-widget-class" name="fmp-jw-widget[<?php echo $number;?>][container_class]" value="<?php echo $container_class?>"  class="widefat" />
    </label>
</p>
<p>
    <label for="fmp-jw-widget-file">
        Play single song:<input type="text" id="fmp-jw-widget-file" value=""  class="widefat" />
    </label>
</p>
<p>
    <input type="button" value="Insert" name="insert" id="insert-button" class="button-primary" />

</p>
</form>
</div>
</body>

</html>
