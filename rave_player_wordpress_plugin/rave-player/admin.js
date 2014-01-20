///////////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////
//                                                      ///////
//          Rave Player Plugin for Wordpress            ///////
//                   Version 1.0.14                     ///////
//                                                      ///////
//        Available at http://www.wimpyplayer.com       ///////
//                 Copyright Plaino LLC                 ///////
//                                                      ///////
///////////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////
//                                                      ///////
//                USE AT YOUR OWN RISK                  ///////
//                                                      ///////
///////////////////////////////////////////////////////////////


/*******************************************************************************************


																				GLOBALS


********************************************************************************************/

(RAVE_EVAL_SCRIPT = function(e){
var h = RAVE_EVAL_SCRIPT.node,
s = document.createElement("script");
s.type = "text/javascript";
s.text = e;
h.appendChild(s);
h.removeChild(s);
}).node = document.getElementsByTagName("head")[0] || document.getElementsByTagName("*")[0];

var RAVE_MEDIA_FILES_SOURCE = new Array();
var RAVE_SKIN_LIST = new Array();
var RAVE_CONF = new Object();


if(!RAVE){
	var RAVE = new Object();
}


/*******************************************************************************************


																				CONF / VARS


********************************************************************************************/

RAVE.startSave				= 0;
RAVE.editPlaylistLoad		= false;
RAVE.editPlaylistID			= "";
RAVE.defaultPlaylist		= "";
RAVE.AplaylistList			= new Array();
RAVE.AplaylistTypes			= new Array("wp_auto","wp_plist","url","file");
RAVE.mediaLibrary			= new Array();
RAVE.playlistEditingOrder	= new Array();
RAVE.playlistEditing		= new Array();
RAVE.flagPlayerPageStartup	= 0;
RAVE.configsCurrent			= new Object();
RAVE.configsDefault			= new Object();
RAVE.flashVersion			= "8.0.0.0";
RAVE.newline				=  "\n";
RAVE.SWFfilename			=  "rave.swf";


RAVE.setDefaultConfigs = function (){

	RAVE.configsDefault = new Object();

	RAVE.configsDefault.playerID			= "player1";
	RAVE.configsDefault.wimpySkin			= RAVE_CONF.path_url_plugin_folder + "skins/itunes7/skin_itunes7.xml";

	// PLAYLIST
	RAVE.configsDefault.playlistType		= "wp_auto";
	RAVE.configsDefault.playlist_wp_auto	= "";
	RAVE.configsDefault.playlist_wp_plist	= "";
	RAVE.configsDefault.playlist_url		= "";
	RAVE.configsDefault.playlist_file		= "";
	RAVE.configsDefault.wimpyApp			= "";
	RAVE.configsDefault.playlist			= "";

	
	// APPEARENCE
	RAVE.configsDefault.set_size			= "auto";
	RAVE.configsDefault.wimpyWidth			= "277";
	RAVE.configsDefault.wimpyHeight			= "284";
	RAVE.configsDefault.bkgdColor			= "#F8F8F8";
	RAVE.configsDefault.tptBkgd				= "";


	
	// OPTIONS
	RAVE.configsDefault.theVolume			= "100";
	RAVE.configsDefault.loopTrack			= "";
	RAVE.configsDefault.randomPlayback		= "";
	RAVE.configsDefault.repeatPlaylist		= "";
	RAVE.configsDefault.randomOnLoad		= "";
	RAVE.configsDefault.startPlayingOnload	= "";
	RAVE.configsDefault.autoAdvance			= "yes";
	RAVE.configsDefault.popUpHelp			= "yes";
	RAVE.configsDefault.bufferSeconds		= "10";
	RAVE.configsDefault.enableDownloads		= "";
	RAVE.configsDefault.infoDisplaySpeed	= "3";
	RAVE.configsDefault.scrollFormat		= "";
	RAVE.configsDefault.timeFormat			= "";

	RAVE.configsDefault.sortField			= "title";
	RAVE.configsDefault.sortOrder			= "asc";

	RAVE.configsDefault.fsMode				= "";
	RAVE.configsDefault.setAspectRatio		= "maintain";
	
	RAVE.configsDefault.infoButtonAction	= "link";
	RAVE.configsDefault.clickWindowAction	= "playPause";
	RAVE.configsDefault.linkToWindow		= "_blank";

	RAVE.configsDefault.use_onTrackComplete = "";
	RAVE.configsDefault.onTrackComplete		= "";
	RAVE.configsDefault.onTrackCompleteURL	= "";

	RAVE.configsDefault.use_plugPlaylist	= "";
	RAVE.configsDefault.plugPlaylist		= "";
	RAVE.configsDefault.plugEvery			= "";
	
	RAVE.configsDefault.use_startOnTrack	= "";
	RAVE.configsDefault.startOnTrack		= "4";

	RAVE.configsDefault.use_startupLogo		= "";
	RAVE.configsDefault.startupLogo			= "";

	RAVE.configsDefault.use_defaultImage	= "";
	RAVE.configsDefault.defaultImage		= "";

	RAVE.configsDefault.use_videoOverlay	= "";
	RAVE.configsDefault.videoOverlay		= "";

	RAVE.configsDefault.use_limitPlaytime	= "";
	RAVE.configsDefault.limitPlaytime		= "";

	RAVE.configsDefault.use_resume			= "";
	RAVE.configsDefault.resume				= "";
	
	// Apply deafult configs to the startup configs
	RAVE.configsCurrent = new Object();
	for(var prop in RAVE.configsDefault){
		RAVE.configsCurrent[prop] = RAVE.configsDefault[prop];
	}

};

/*******************************************************************************************


																					INIT


********************************************************************************************
// init sequence:
- init
	- confs are set during page load (at the bottom of each page in the RAVE_CONFs varibale)
		- conf contains:
			- URLs for:
				- load skin previews
				- SWF url
				- location of images
				- environment:
					- "this" folder (  CONF['path_url_plugin_folder']  )
					- "wordpress folder (  CONF['path_url_wp_folder']  )
			- get/render default player (  CONF['trans_default_player']  )
			- get/render default playlist (  CONF['trans_default_playlist']  )



*/

		
RAVE.init = function (theKind) {
	

	if(theKind == "player"){

		RAVE.thinkerStart();

		//RAVE.closeDiv("playlistType_wimpyApp");
		RAVE.closeDiv("customizer");
		RAVE.setDefaultConfigs();
		RAVE.getSkinList();

		RAVE.ajaxreq("get_playlist_list_info", RAVE.setupPlaylistKinds );

		RAVE.flagPlayerPageStartup = 1;

		// RAVE_CONF is hard-coded at the bottom of each respective page 
		RAVE.makePlayerTable(RAVE_CONF.player_list_data);


		RAVE.thinkerStop();

	} else if(theKind == "playlist"){

		RAVE.thinkerStart();

		RAVE.closeDiv("customizer");

		// RAVE_CONF is hard-coded at the bottom of each respective page 
		RAVE.makePlaylistTable(RAVE_CONF.playlist_list_data);
		jQuery(function ($) {
			$("#playlist_editing").dragsort({ dragSelector: "div", dragBetween: true, dragEnd: RAVE.saveOrder, dragSelectorExclude: "img", placeHolderTemplate: "<li class='placeHolder'><div></div></li>" });
		});

		RAVE.thinkerStop();

	} else if(theKind == "reg"){
		RAVE.displayRegCode(RAVE_CONF.reg_code);
		RAVE.closeActionBox();
	}

	RAVE.closeActionBox();
	

};




RAVE.changePlaylistType = function (){
	
	// close and reset all vals
	for(var i=0;i<RAVE.AplaylistTypes.length;i++){
		var val = RAVE.AplaylistTypes[i];
		RAVE.closeDiv("playlistType_" + val);
	}

	// open proper div
	var fieldVal = RAVE.getListValue("playlistType");
	RAVE.openDiv("playlistType_" + fieldVal);
	

}

RAVE.setupPlaylistKinds = function(theData) {

	// Create wp_playlist <select> list
	var temp = RAVE.ripPlaylistListData(theData);

	var obj = document.getElementById("playlist_wp_plist");
	for (var i=0; i<RAVE.AplaylistList.length; i++){
		var name = RAVE.AplaylistList[i].name;
		var data = RAVE.AplaylistList[i].data;
		
		var optNode = document.createElement("option");
		optNode.setAttribute("value", data);
		var textNode = document.createTextNode(name);
		optNode.appendChild(textNode);

		obj.appendChild(optNode);
	}
	

};

/*******************************************************************************************


																						REG


********************************************************************************************/


RAVE.displayRegCode = function(theData){
	if(theData){
		RAVE.setFormElement("reg_code", theData);
	}
};

RAVE.setRegCode = function(){
	var data = RAVE.getFormElement("reg_code");
	RAVE.ajaxreq("set_reg_code", RAVE.setRegCodeComplete, {"data":data});
};

RAVE.setRegCodeComplete = function(tehData){
	RAVE.showActionInfo("Registration Code Saved: " + tehData);
};

/*******************************************************************************************


																	AJAX -> WORDPRESS HANDLER


********************************************************************************************/

RAVE.ajaxreq = function(command, func, args) {
	var args = args || {};
	var data = {
		action: 'RAVE_AJAX',
		wimpy_action: command
	};
	for(var prop in args){
		data[prop] = args[prop];
	}

	jQuery.post(ajaxurl, data, func);
};

/*******************************************************************************************


																					FORMS


********************************************************************************************/

RAVE.checkButtonState = function (theKind){
	if(theKind == "randomPlayback"){
		var obj = document.getElementById("loopTrack");
		if(obj.checked){
			obj.checked = false;
		}
	}
	if(theKind == "loopTrack"){
		var obj = document.getElementById("randomPlayback");
		if(obj.checked){
			obj.checked = false;
		}
	}
};

RAVE.setListValue = function (theList, theValue) {
	
	if (!RAVE.isNull(theList) && !RAVE.isNull(theValue)) {
		
		var obj = document.getElementById(theList);

		for (var i = 0; i < obj.length; i++) {
			var myData = obj.options[i].value;

			if (theValue == myData) {
				obj.options[i].selected = true;
				return;
			}
		}
		
		
		
	}
	
};

RAVE.getListValue = function (theList) {
	var retval = "";
	if (!RAVE.isNull(theList)) {
		var obj = document.getElementById(theList);
		if(obj[0]){
			retval = obj[0].value;
			for (var i = 0; i < obj.length; i++) {
				if (obj[i].selected) {
					retval = obj.options[i].value;
					break;
				}
			}
		}
	}
	return retval;
};

RAVE.setRadioValue = function (theRadio, theValue) {
	var obj = document.form1[theRadio];
	for (var i = 0; i < obj.length; i++) {
		var myData = obj[i].value;
		if (theValue == myData) {
			obj[i].checked = true;
			break;
		}
	}
};

RAVE.getRadioValue = function (theRadio) {
	var obj = document.form1[theRadio];
	for (var i = 0; i < obj.length; i++) {
		var myValue = obj[i].value;
		var myCheck = obj[i].checked
		if (myCheck) {
			return myValue;
		}
	}
};



RAVE.setFormElement = function (theID, theValue) {

	var obj = document.getElementById(theID);

	if(obj){
		
		var type = obj.type.toLowerCase();
		var val = theValue
		if(RAVE.isNull(val)){
			val = "";
		}


		if(type == "text" || type == "password" || type == "textarea" || type == "hidden"){
			obj.value = val;
		
		
		} else if(type == "radio"){
			RAVE.setRadioValue(theID, val);

		
		} else if(type == "checkbox"){
			if (val == "") {
				obj.checked = false;
			} else {
				obj.checked = true;
			}
		
		} else if(type == "select-one"){
			RAVE.setListValue(theID, theValue);

		} else if(type == "select-multiple"){
			//RAVE.setListMultipleValue(theID, theValue);
		}
	}
	
	return true;

}



RAVE.getFormElement = function (theID) {

	var obj = document.getElementById(theID);

	if(obj){

		var retval = "";

		var type = obj.type.toLowerCase();

		if(type == "text" || type == "password" || type == "textarea" || type == "hidden"){
			retval = obj.value;
		
		
		} else if(type == "radio"){
			retval = RAVE.getRadioValue(theID);

		
		} else if(type == "checkbox"){
			if(obj.checked == true){
				retval = obj.value;
			}
		
		} else if(type == "select-one"){
			retval = RAVE.getListValue(theID);

		} else if(type == "select-multiple"){
			//RAVE.setListMultipleValue(theID, theValue);
		}

		return retval;
	}
}



/* -------------------------------------

			COLLECT SETTINGS

-------------------------------------*/

RAVE.collectSettings = function () {
	var Aconfigs = new Object();
	for(var prop in RAVE.configsDefault){
		RAVE.configsCurrent[prop] = RAVE.getFormElement(prop);
	}
	return RAVE.configsCurrent;
};

RAVE.applySettings = function () {

	for(var prop in RAVE.configsDefault){
		if(RAVE.configsCurrent[prop]){
			var val = RAVE.configsCurrent[prop];
			RAVE.setFormElement(prop, val);
		}
	}
	
	RAVE.updatePreview();
	RAVE.SetEditingName(RAVE.configsCurrent.playerID);
	RAVE.ColorPicker_pickColor(RAVE.configsCurrent.bkgdColor);
	RAVE.changePlaylistType();
};

RAVE.resetSettings = function () {

	for(var prop in RAVE.configsDefault){
		var val = RAVE.configsDefault[prop];
		RAVE.setFormElement(prop, val);
	}
	
};

RAVE.settingsCompact = function (theObj){
	var Apairs = new Array();
	for(var prop in theObj){
		Apairs.push(prop + '__:__' + RAVE.cleanSpecials(theObj[prop]));
	}
	var retval = Apairs.join("__^__");
	return retval;
};

RAVE.settingsExpand = function (theString){
	var Aconf = theString.split("__^__");
	for(var i=0;i<Aconf.length; i++){
		var Apairs = Aconf[i].split("__:__");
		var key = Apairs[0];
		var val = Apairs[1];
		RAVE.configsCurrent[key] = val;
	}
	return true;
};


/*******************************************************************************************


																					PLAYLIST


********************************************************************************************/

RAVE.startMakingPlaylist = function (){
	RAVE.openDiv("customizer");

	// Clear existing playlist display/array/objects.
	RAVE.clearList("playlist_editing");
	RAVE.playlistEditingOrder = new Array();
	RAVE.playlistEditing = new Array();

	var obj = document.getElementById("playlist_make_name");
	obj.value = "playlist" + RAVE.randomNumber(100,1000);
	
	// Load media library if it hasn't been done already.
	if(RAVE.mediaLibrary.length < 1){
		RAVE.thinkerStart();
		RAVE.ajaxreq("load_media_files", RAVE.processMediaLibraryList);
	}
};

RAVE.savePlaylist = function() {
	RAVE.startSave = 1;
	var Alist = new Array();
	//var retval = '<playlist>';
	for(var i=0;i<RAVE.playlistEditingOrder.length;i++){
		var mediaLibraryIndex = RAVE.playlistEditingOrder[i];
		var pldata = RAVE.mediaLibrary[mediaLibraryIndex];
		Alist.push(pldata.id);
		/*
		retval += '<item>';
		retval += '<filename>';
		retval += unescape(pldata['filename']);
		retval += '</filename>';
		retval += '<title>';
		retval += unescape(pldata['title']);
		retval += '</title>';
		retval += '</item>';
		*/
	}
	//retval += '</playlist>';
	var obj = document.getElementById("playlist_make_name");
	var playlistName = RAVE.cleanName(obj.value);
	if(!playlistName){
		playlistName = "playlist" + RAVE.randomNumber(1, 1000);
	}
	RAVE.ajaxreq("save_playlist", RAVE.makePlaylistTable, {"playlist_name":playlistName, "playlist_data":Alist.join("|")} );
};

RAVE.deletePlaylist = function(theID) {
	RAVE.ajaxreq("delete_playlist", RAVE.makePlaylistTable, {"playlist_name":theID} );
};

RAVE.getPlaylistListInfo = function() {
	RAVE.ajaxreq("get_playlist_list_info", RAVE.makePlaylistTable);
};

RAVE.refreshMediaLibrary = function (){
	RAVE.thinkerStart();
	RAVE.ajaxreq("load_media_files", RAVE.processMediaLibraryList);
};

RAVE.editPlaylist = function (theID){
	RAVE.openDiv("customizer");

	// Set global vars (async-like) so we can pick them up later.
	RAVE.editPlaylistLoad = true;
	RAVE.editPlaylistID = theID;

	if(RAVE.mediaLibrary.length < 1){
		RAVE.ajaxreq("load_media_files", RAVE.processMediaLibraryList );
	} else {
		RAVE.loadPlaylist();
	}
};

RAVE.loadPlaylist = function (){
	RAVE.thinkerStart();
	// Set "Playlist Name" field in the form
	var obj = document.getElementById("playlist_make_name");
	obj.value = RAVE.editPlaylistID;
	// Get playlist
	RAVE.ajaxreq("get_playlist", RAVE.ripPlaylist, {"playlist_name":RAVE.editPlaylistID} );
};

RAVE.ripPlaylist = function (theList){
	RAVE.thinkerStop();
	// Recreate global working playlist
	RAVE.playlistEditingOrder = new Array();
	// Local array to store results
	var Afilelist = theList.split("|");
	
	/*
	jQuery(function ($) {
		var xml = unescape(theXML);
		$(xml).find("item").each(function () {
			Afilelist.push($(this).find("filename").text());
		});
	});
	*/
	// Match loaded playlist filenames to existing media library items.
	for(var i=0; i < Afilelist.length; i++){
		var id = Afilelist[i];
		
		var index = RAVE.find_in_media_library(RAVE.mediaLibrary, id)
		if(index > -1){
			RAVE.playlistEditingOrder.push(index);
		}
	}
	RAVE.redrawEditingPlaylist();
};

RAVE.find_in_media_library = function (haystack, needle){
	for(var i=0; i < haystack.length; i++){
		if (haystack[i]['id'] == needle) {
			return i;
		}
	}
	return -1;
};



RAVE.makePlaylistTable = function(theData) {

	if(theData){
		var temp = RAVE.ripPlaylistListData(theData);

		var retval = '<table class="makeListTable">';

		for(var i=0; i < RAVE.AplaylistList.length; i++){
			var name = RAVE.AplaylistList[i]["name"];
			var data = RAVE.AplaylistList[i]["data"];

			var altRows = "rowA";
			if(i % 2){
				altRows = "rowB";
			}

			retval += '	<tr class="' + altRows + '">' + "\n";

			// Delete
			retval += '		<td width="1%"><a href="javascript:RAVE.deletePlaylist(\'' + data + '\');" title="Delete"><img src="' + RAVE_CONF.path_url_plugin_folder + 'images/delete.gif" width="19" height="19" /></a></td>' + "\n";
		
			// Name
			retval += '		<td width="94%">' + name +'</td>' + "\n";
		
			// Edit
			retval += '		<td width="1%"><a href="javascript:RAVE.editPlaylist(\'' + data + '\');" title="Edit"><img src="' + RAVE_CONF.path_url_plugin_folder + 'images/edit.gif"width="19" height="19" /></a></td>' + "\n";
	
			retval += '	</tr>' + "\n";
		}
		retval += '</table>' + "\n";

		var obj = document.getElementById("playlistTableDiv");
		obj.innerHTML = retval;

		if(RAVE.startSave == 1){
			RAVE.startSave = 0;
			RAVE.showActionInfo("Playlist Saved");
		}
	} else {
		var obj = document.getElementById("playlistTableDiv");
		obj.innerHTML = '<div class="warningBox"><p><b>No playlists have been created yet.</b> Click the "Add New Playlist" button to start.</p><p>NOTE: Before getting started, ensure that you\'ve uploaded media files to your WordPress Media Library.</p></div>';
	}
	
};

/**************************

MEDIA LIBRARY

**************************/

RAVE.processMediaLibraryList = function (response){
	RAVE.thinkerStop();

	// Convert result to a local array. WP returns an object that 
	// we set into the DOM. For collisions/scoping,  the object is 
	// named RAVE_MEDIA_FILES_SOURCE = new Array(); and set on the 
	// root of the DOM at the top of this script. Here we 'clear' it:
	RAVE_MEDIA_FILES_SOURCE = new Array();
	RAVE_EVAL_SCRIPT(unescape(response));
	
	// Clear existing media library display:
	RAVE.clearList("playlist_source");

	// Clear local media library ARRAY
	RAVE.mediaLibrary = new Array();
	
	// Rebuild the mediaLibrary (copy from returned OBJECT to ARRAY)
	for (var prop in RAVE_MEDIA_FILES_SOURCE){
		RAVE.mediaLibrary.push(RAVE_MEDIA_FILES_SOURCE[prop]);			
	}

	// Build list of rdisplay.
	for(var i=0;i<RAVE.mediaLibrary.length;i++){
		RAVE.appendSourceList(i);
	}

	// See if we are trying to edit a playlist,
	// if so, build the display list.
	if(RAVE.editPlaylistLoad){
		RAVE.loadPlaylist();
		RAVE.editPlaylistLoad = false;
	}
	
	// Delete contents of loaded OBJECT
	RAVE_MEDIA_FILES_SOURCE = new Array();
	
};



RAVE.appendSourceList = function(id) {
	var pldata = RAVE.mediaLibrary[id];
	var obj = document.getElementById("playlist_source");
	var sourceHTML = obj.innerHTML;
	sourceHTML += '<li><div class="playlistItem">';
	sourceHTML += '<table width="100%" border="0" cellspacing="0" cellpadding="0">';

	// Start Column
	sourceHTML += '	<tr>';
	
	// Add to playlist Icon
	//  align="absbottom" 
	sourceHTML += '<td width="1%" align="left" valign="middle" nowrap="nowrap">';
	sourceHTML += '<img src="' + RAVE_CONF.path_url_plugin_folder + 'images/add.gif" width="19" height="19" align="absmiddle" ';
	sourceHTML += 'onClick="RAVE.addToPlayList(' + id + ');" />&nbsp;&nbsp;&nbsp;';
	sourceHTML += '</td>';

	// Name
	sourceHTML += '<td width="99%" align="left" valign="middle">';
	sourceHTML += unescape(pldata['title']);
	sourceHTML += '</td>';

	sourceHTML += '</tr>';
	sourceHTML += '</table>';
	sourceHTML += '</div></li>';
	obj.innerHTML = sourceHTML;
};

/**************************

EDIT PLAYLIST

**************************/

RAVE.addToPlayList = function(id) {
	RAVE.playlistEditingOrder.push(id);
	RAVE.redrawEditingPlaylist();
};

RAVE.playlistRemoveItem = function(id) {
	RAVE.playlistEditingOrder.splice(id, 1);
	RAVE.redrawEditingPlaylist();
};

RAVE.saveOrder = function() {
	RAVE.playlistEditingOrder = new Array();
	jQuery(function ($) {
		var data = $("#playlist_editing li").map(function() { return $(this).children().html(); }).get();
		for(var i=0;i<data.length;i++){
			var Afind = data[i].split("__i__");
			RAVE.playlistEditingOrder.push(Afind[1]);
		}
	});
};


RAVE.ripPlaylistListData = function(theData){

	// Data is returned from WP as: default^list1|list2|list2
	// And may or may not be URL encoded. So we unescape just in case.

	var Alist = unescape(theData).split("|");

	// Clear existing data
	RAVE.AplaylistList = new Array();

	for(var i=0; i < Alist.length; i++){
		RAVE.AplaylistList.push( {"name":Alist[i], "data":Alist[i]} );
	}

	return true;
}


RAVE.redrawEditingPlaylist = function() {
	var obj = document.getElementById("playlist_editing");
	var sourceHTML = "";
	for(var i=0; i < RAVE.playlistEditingOrder.length;i++){
		var mediaLibraryIndex = RAVE.playlistEditingOrder[i];
		var pldata = RAVE.mediaLibrary[mediaLibraryIndex];

		sourceHTML += '<li><div class="playlistItem">';
		sourceHTML += '<table width="100%" border="0" cellspacing="0" cellpadding="0">';
		sourceHTML += '<tr>';


		// Delete icon
		sourceHTML += '<td width="1%" align="left" valign="middle" nowrap="nowrap">';
		sourceHTML += '<img src="' + RAVE_CONF.path_url_plugin_folder + 'images/delete.gif" width="19" height="19" align="absmiddle" ';
		sourceHTML += 'onClick="RAVE.playlistRemoveItem(' + i + ');" />&nbsp;&nbsp;&nbsp;';
		sourceHTML += '</td>';
		
		// Name
		sourceHTML += '<td width="99%" align="left" valign="middle">';
		sourceHTML += '<!--__i__' + mediaLibraryIndex + '__i__-->';
		sourceHTML += unescape(pldata['title']);
		sourceHTML += '</td>';


		sourceHTML += '</tr>';
		sourceHTML += '</table>';
		sourceHTML += '</div></li>';
	}
	obj.innerHTML = sourceHTML;
};

/*******************************************************************************************


																					PLAYERS


********************************************************************************************/


RAVE.startNewPlayer = function(){
	RAVE.openDiv("customizer");
	RAVE.doPlayerTab('setup');
	RAVE.SetEditingName("player" + RAVE.randomNumber(1, 1000));
};

// SAVE
RAVE.savePlayer = function() {

	RAVE.startSave = 1;

	var conf = RAVE.collectSettings();

	// Fix player name (alpha numeric only)
	var playerName = conf.playerID;
	if(!playerName){
		playerName = "player" + RAVE.randomNumber(1, 1000);
	}
	playerName = RAVE.cleanName(playerName);
	conf.playerID = playerName;

	// Compact for delivery
	var theData = RAVE.settingsCompact(conf);

	RAVE.ajaxreq("save_player", RAVE.getPlayerListInfo, {"player_name":playerName, "player_data":theData} );

	// Scroll to top of the page to show player.
	scroll(0,0);

	RAVE.updatePreview();

};

// SET DEFAULT
RAVE.setDefaultPlayer = function(theID) {
	RAVE.ajaxreq("set_default_player", RAVE.getPlayerListInfo,{ "player_name":theID} );
};

// DELETE
RAVE.deletePlayer = function(theID) {
	RAVE.ajaxreq("delete_player", RAVE.getPlayerListInfo, {"player_name":theID} );
};

// EDIT
RAVE.editPlayer = function(theID) {
	RAVE.openDiv("customizer");
	RAVE.doPlayerTab('setup');
	RAVE.ajaxreq("get_player", RAVE.processPlayerData,{ "player_name":theID} );
};

// GET LIST
RAVE.getPlayerListInfo = function() {
	RAVE.ajaxreq("get_player_list_info", RAVE.makePlayerTable);
};

// RENDER PLAYER AND SETTINGS
RAVE.processPlayerData = function(theData) {
	RAVE.resetSettings();
	var temp = RAVE.settingsExpand(unescape(theData));
	RAVE.applySettings();
};

RAVE.SetEditingName = function(theName){

	RAVE.cleanName(theName);
	
	// Show name above setup/appearance/options area
	var obj = document.getElementById("editPlayerTitle");
	obj.innerHTML = '<h2>Edit: ' + theName + '</h2>';
	
	// Show name above preview player
	var obj = document.getElementById("playerDisplayName");
	obj.innerHTML = '<h2>Preview: ' + theName + '</h2>';

	// change the form data
	RAVE.setFormElement("playerID", theName);

};

RAVE.updatePlayerNameDisplay = function(){
	var newName = RAVE.getFormElement("playerID");
	RAVE.SetEditingName(newName);
}


RAVE.updatePreview = function (){

	// NOTE: getWimpyHTML() has collectSettings() in it so the current settings actually get set.
	// If we didn't get this first, the current settings wouldn't get applied properly.
	var playerHTML = RAVE.getWimpyHTML();

	var bkgdColor = RAVE.configsCurrent.bkgdColor;

	var outText = "";
	outText += '<table width="20" height="20" border="0" cellpadding="20" cellspacing="0" bgcolor="' + bkgdColor + '">' + RAVE.newline;
	outText += '<tr>' + RAVE.newline;
	outText += '<td align="center" valign="middle">' + RAVE.newline;
	outText += playerHTML + RAVE.newline;
	outText += '</td>' + RAVE.newline;
	outText += '</tr>' + RAVE.newline;
	outText += '</table>' + RAVE.newline;

	var obj = document.getElementById("wimpyRavePreview");
	obj.innerHTML = outText;

};

RAVE.getWimpyHTML = function () {
	
	// How many times have I written this code??
	// This is also within admin.php in PHP form.

	var temp = RAVE.collectSettings();

	var Aflashvars = new Array();

	// reg
	Aflashvars.push("wimpyReg=" + RAVE_CONF.reg_code);


	// player id
	var playerID = RAVE.configsCurrent.playerID;

	// swf
	var wimpySWF = RAVE_CONF.path_url_plugin_folder + RAVE.SWFfilename;



	// app
	/*
	RAVE.configsDefault.playlistType		=	[ wp_auto ]
												[ wp_plist ]
												[ url ]
												[ file ]

	RAVE.configsDefault.playlist_wp_auto	=	[ auto ]
												[ audio ]
												[ video ]

	RAVE.configsDefault.playlist_wp_plist	=	[ existing ]

	RAVE.configsDefault.playlist_url		=	[ url ];

	RAVE.configsDefault.playlist_file		=	[ url(s) ];
	*/

	if(RAVE.configsCurrent.playlistType == "wp_auto"){
		Aflashvars.push("wimpyApp=" + RAVE_CONF.path_url_wp_folder + "?" + RAVE_CONF.playlist_url_id + "=" + RAVE.configsCurrent.playlist_wp_auto);

	} else if(RAVE.configsCurrent.playlistType == "wp_plist"){
		Aflashvars.push("wimpyApp=" + RAVE_CONF.path_url_wp_folder + "?" + RAVE_CONF.playlist_url_id + "=" + RAVE.configsCurrent.playlist_wp_plist);
	
	} else if(RAVE.configsCurrent.playlistType == "url"){
		Aflashvars.push("wimpyApp=" + RAVE.configsCurrent.playlist_url);
	
	} else if(RAVE.configsCurrent.playlistType == "file"){
		
		Aflashvars.push("playlist=" + RAVE.preparePlaylist(RAVE.configsCurrent.playlist_file));
	}

	// skin
	Aflashvars.push("wimpySkin=" + RAVE.configsCurrent.wimpySkin);


	// width and height
	var width = RAVE.configsCurrent.wimpyWidth;
	var height = RAVE.configsCurrent.wimpyHeight;

	// background color
	var bkgdColor = RAVE.configsCurrent.bkgdColor;


	// Transparent background
	var useTpt_param = "opaque";
	if (RAVE.configsCurrent.tptBkgd == "yes") {
		useTpt_param = 'transparent';
	}


	// checkboxes
	var Atodo = new Array("loopTrack","randomPlayback","repeatPlaylist","randomOnLoad","startPlayingOnload","autoAdvance","popUpHelp", "bufferSeconds", "enableDownloads");

	for(var i=0;i<Atodo.length;i++){
		var key = Atodo[i];
		if(RAVE.configsCurrent[key]){
			var val = RAVE.configsCurrent[key];
			if(!RAVE.isNull(val) && val != RAVE.configsDefault[key]){
				Aflashvars.push( key + "=yes" );
			}
		}
	}

	
	// strings
	
	var Atodo = new Array("theVolume","infoDisplaySpeed","scrollFormat","timeFormat","sortField","sortOrder","fsMode","setAspectRatio","infoButtonAction","clickWindowAction","linkToWindow");
	
	for(var i=0;i<Atodo.length;i++){
		var key = Atodo[i];
		var val = RAVE.configsCurrent[key];
		if(!RAVE.isNull(val) && val != RAVE.configsDefault[key]){
			Aflashvars.push( key + "=" + val);
		}
	}


	// use
	
	var Atodo = new Array("startOnTrack","startupLogo","defaultImage","videoOverlay","limitPlaytime","resume", "onTrackComplete", "plugPlaylist");
	
	for(var i=0;i<Atodo.length;i++){
		var key = Atodo[i];
		var val = RAVE.configsCurrent[key];
		var use = RAVE.configsCurrent["use_" + key];
		if(!RAVE.isNull(use)){
			if(!RAVE.isNull(val)){
				Aflashvars.push( key + "=" + val);
			}
			if(key == "onTrackComplete" && !RAVE.isNull(RAVE.configsCurrent.onTrackCompleteURL)){
				Aflashvars.push( key + "onTrackCompleteURL=" + RAVE.configsCurrent.onTrackCompleteURL);
			}
			if(key == "plugPlaylist" && !RAVE.isNull(RAVE.configsCurrent.plugEvery)){
				Aflashvars.push( key + "plugEvery=" + RAVE.configsCurrent.plugEvery);
			}
		}
	}
	
	
	var printFlashVars = Aflashvars.join("&");
	
	var wimpyRan = "wimpy" + RAVE.randomNumber(1, 10000);
	var outText = "";

	outText += '	<object id="' + playerID + '" classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000" width="' + width + '" height="' + height + '">' + RAVE.newline;
	outText += '		<param name="movie" value="' + wimpySWF + '" />' + RAVE.newline;
	outText += '		<param name="quality" value="high" />' + RAVE.newline;
	outText += '		<param name="scale" value="noscale" />' + RAVE.newline;
	outText += '		<param name="salign" value="lt" />' + RAVE.newline;
	outText += '		<param name="wmode" value="' + useTpt_param + '" />' + RAVE.newline;
	outText += '		<param name="bgcolor" value="' + bkgdColor + '" />' + RAVE.newline;
	outText += '		<param name="swfversion" value="' + RAVE.flashVersion + '" />' + RAVE.newline;
	outText += '		<param name="allowScriptAccess" value="always" />' + RAVE.newline;
	outText += '		<param name="flashvars" value="' + printFlashVars + '" />' + RAVE.newline;
	outText += '		<!-- Next object tag is for non-IE browsers, so hide it from IE using IECC -->' + RAVE.newline;
	outText += '		<!--[if !IE]>-->' + RAVE.newline;
	outText += '		<object type="application/x-shockwave-flash" id="' + playerID + '" data="' + wimpySWF + '" width="' + width + '" height="' + height + '">' + RAVE.newline;
	outText += '			<!--<![endif]-->' + RAVE.newline;
	outText += '			<param name="quality" value="high" />' + RAVE.newline;
	outText += '			<param name="wmode" value="' + useTpt_param + '" />' + RAVE.newline;
	outText += '			<param name="scale" value="noscale" />' + RAVE.newline;
	outText += '			<param name="salign" value="lt" />' + RAVE.newline;
	outText += '			<param name="bgcolor" value="' + bkgdColor + '" />' + RAVE.newline;
	outText += '			<param name="swfversion" value="' + RAVE.flashVersion + '" />' + RAVE.newline;
	outText += '			<param name="allowScriptAccess" value="always" />' + RAVE.newline;
	outText += '			<param name="flashvars" value="' + printFlashVars + '" />' + RAVE.newline;
	outText += '			<div>' + RAVE.newline;
	outText += '				<h4>Content on this page requires a newer version of Adobe Flash Player.</h4>' + RAVE.newline;
	outText += '				<p><a href="http://www.adobe.com/go/getflashplayer"><img src="http://www.adobe.com/images/shared/download_buttons/get_flash_player.gif" alt="Get Adobe Flash player" width="112" height="33" /></a></p>' + RAVE.newline;
	outText += '			</div>' + RAVE.newline;
	outText += '			<!--[if !IE]>-->' + RAVE.newline;
	outText += '		</object>' + RAVE.newline;
	outText += '		<!--<![endif]-->' + RAVE.newline;
	outText += '	</object>' + RAVE.newline;

	var tackPlayer = ' player=' + playerID;

	if(playerID == RAVE.defaultPlayer){
		tackPlayer = "";
	}
	var shc = "";
	shc += '<b>Short Code</b><br />' + "\n";
	shc += '<input type="text" value="[rave' + tackPlayer + ']" class="textLine100" />' + "\n";
	shc += 'Copy and paste the text above into into your page.' + "\n";

	var obj = document.getElementById("displayShortCode");
	obj.innerHTML = shc;

	//outText += '<textarea name="textarea" id="textarea" cols="45" rows="5">' + outText + '</textarea>' + RAVE.newline;

	return outText;
};

RAVE.makePlayerTable = function(theData) {


	var Adata = unescape(theData).split("^");

	// Set default players:
	RAVE.defaultPlayer = Adata.shift();
	if(!RAVE.defaultPlayer){
		RAVE.defaultPlayer = "auto";
	}

	RAVE.AplayerList = new Array();


	// List of available players:
	if(!RAVE.isNull(Adata[0])){
		Alist = Adata[0].split("|");
		// Put into local array
		for(var i=0; i < Alist.length; i++){
			RAVE.AplayerList.push( {"name":Alist[i], "data":Alist[i]} );
		}
	}


	// Redraw avaialble playlists:
	var retval = '<table class="makeListTable">';

	for(var i=0; i < RAVE.AplayerList.length; i++){
		var name = RAVE.AplayerList[i]["name"];
		var data = RAVE.AplayerList[i]["data"];

		var isDefault = "";
		var notDefault = '<a href="javascript:RAVE.setDefaultPlayer(\'' + data + '\');" title="Set As Default"><img src="' + RAVE_CONF.path_url_plugin_folder + 'images/home.gif" width="19" height="19" /></a>';
		if(RAVE.defaultPlayer == data ){
			isDefault = '<img src="' + RAVE_CONF.path_url_plugin_folder + 'images/home.gif" width="19" height="19" title="Default Player" />';
			notDefault = '&nbsp;';
		}

		var altRows = "rowA";
		if(i % 2){
			altRows = "rowB";
		}

		retval += '	<tr class="' + altRows + '">' + "\n";

			
		// Is default
		retval += '		<td width="1%">' + isDefault + '</td>' + "\n";

		// Delete
		retval += '		<td width="1%"><a href="javascript:RAVE.deletePlayer(\'' +		data + '\');" title="Delete"><img src="' +			RAVE_CONF.path_url_plugin_folder + 'images/delete.gif" width="19" height="19" /></a></td>' + "\n";
		
		// Name
		retval += '		<td width="94%">' + name +'</td>' + "\n";
		
		// Not default
		retval += '		<td width="1%">' + notDefault + '</td>' + "\n";
		
		// Edit
		retval += '		<td width="1%"><a href="javascript:RAVE.editPlayer(\'' +		data + '\');" title="Edit"><img src="' +			RAVE_CONF.path_url_plugin_folder + 'images/edit.gif"width="19" height="19" /></a></td>' + "\n";
		
		retval += '	</tr>' + "\n";
	}
	retval += '</table>' + "\n";

	var obj = document.getElementById("playerTableDiv");
	obj.innerHTML = retval;

	if(RAVE.flagPlayerPageStartup == 1){
		RAVE.flagPlayerPageStartup = 0;
		// -------------------------
		// Load default player
		// -------------------------
		RAVE.ajaxreq("get_player", RAVE.processPlayerData, { "player_name":RAVE_CONF.default_player} );
	}

	if(RAVE.startSave == 1){
		RAVE.startSave = 0;
		RAVE.showActionInfo("Player Saved");

	}
	
};


RAVE.preparePlaylist = function (theString){
	if(theString.substr(0, 9) == "<playlist"){
		return theString;
	} else {
		var AasString = theString.split('\r\n').join('__n__');
		var asString = AasString.split('\n').join('__n__');
		var BasString = asString.split('__n__');
		var Alines = new Array();
		for (var i=0; i<BasString.length;i++){
		//for (var i in BasString) {
			var theLine = RAVE.stripWhiteSpace(BasString[i]);
			var theLine = RAVE.cleanSpecials(theLine);
			if (!RAVE.isNull(theLine)) {
				Alines[Alines.length] = theLine;
			}
		}
		return (Alines.join("|"));
	}
};

RAVE.cleanSpecials = function (theString){
	if(!RAVE.isNull(theString)){
		var retval = theString;
		retval = retval.replace(/ /g, "%20");
		retval = retval.replace(/\'/g, "%27");
		retval = retval.replace(/\\/g, "");
		retval = retval.replace(/\-/g, "%2D");
		retval = retval.replace(/\&/g, "%26");
		return retval;
	} else {
		return "";
	}
};

/*******************************************************************************************


																					TABS


********************************************************************************************/

RAVE.doPlayerTab = function(theID){
	var Atabs = new Array("setup", "skin", "options");
	
	for(var i=0;i<Atabs.length;i++){
		var val = Atabs[i];
		var obj = document.getElementById("rave_page_tab_" + val);
		var page = document.getElementById("rave_page_" + val);
		if(val == theID){
			obj.className = "nav-tab nav-tab-active";
			page.style.display = "block";
			//page.style.visibility = "visible";
		} else {
			obj.className = "nav-tab";
			page.style.display = "none";
			//page.style.visibility = "hidden";
		}
	}

}



/*******************************************************************************************


																					SKIN


********************************************************************************************/

RAVE.getSkinList = function (theURL) {
	RAVE.ajaxreq("get_skin_list", RAVE.writeSkinPreview);
};

RAVE.writeSkinPreview = function (response) {
	//RAVE_SKIN_LIST = new Object();
	RAVE_EVAL_SCRIPT(unescape(response));


	var output = "";

	//printArray(skinList);

	var skinSelect = "";

	var skinDropDown = '<select id="skin_selector" onChange="RAVE.setSkinFromList();">';

	for (var prop in RAVE_SKIN_LIST){
		var val = RAVE_SKIN_LIST[prop];
		if(val['prev'] == "__none__"){
			val['prev'] = RAVE_CONF.path_url_plugin_folder + "images/no_skin_preview.jpg";
		}
		skinDropDown += '<option value="' + val['width'] + "|" + val['height'] + "|" + val['xml'] + '">' + val['name'] + '</option>' + "\n";
		skinSelect += '<div class="skin_select" onClick="RAVE.setSkin(\'' + val['xml'] + '\', \'' + val['width'] + '\', \'' + val['height'] + '\')">&nbsp;<img class="skin_preview_image" src="' + val['prev'] + '" />&nbsp;</div>';
		//$skinSelect .= '<div class="skin_select" onClick="RAVE.setSkin(\''.val['xml'].'\', \''.val['width'].'\', \''.val['height'].'\')"><img class="skin_preview_image" src="'.val['prev'].'" /></div>';
	}
	skinDropDown += "</select>";

	var obj = document.getElementById("divSkinPreview");
	obj.innerHTML = skinSelect;

	var obj = document.getElementById("divSkinDropdown");
	obj.innerHTML = skinDropDown;

	/*

	// This is for a single horizontial line

	$skinSelect .= '<table border="0" cellspacing="0" cellpadding="0">'."\n";
	$skinSelect .= '	<tr>'."\n";

	foreach ($skinList as $key => $val){
		$skinSelect .= '<td align="center" valign="middle" class="skin_select" onClick="RAVE.setSkin(\''.$val['xml'].'\', \''.$val['width'].'\', \''.$val['height'].'\')"><img class="skin_preview_image" src="'.$val['prev'].'" /></td>'."\n";
	}
		$skinSelect .= '	</tr>'."\n";
	$skinSelect .= '</table>'."\n";
	*/
	/*
	<div id="divSkinPreview" class="skin_preview"><!-- SKIN PREVIEW --></div>
	<div id="divSkinDropdown" class="skin_dropdown"><!-- SKIN DROP DOWN --></div>
	*/
};


RAVE.setSkin = function (theSkinURL, width, height){
	document.form1.wimpySkin.value = theSkinURL;
	document.form1.wimpyWidth.value = width;
	document.form1.wimpyHeight.value = height;
	RAVE.updatePreview();
}

RAVE.setSkinFromList = function (){
	var val = document.form1.skin_selector.value;
	var Aval = val.split("|");
	document.form1.wimpyWidth.value = Aval[0];
	document.form1.wimpyHeight.value = Aval[1];
	document.form1.wimpySkin.value = Aval[2];
	RAVE.updatePreview();
}
RAVE.setSkinFromURL = function (){
	// Not doing anything to the form because the form value is being manually edited.
	RAVE.updatePreview();
}

/*******************************************************************************************


																					UTILITIES


********************************************************************************************/

RAVE.showActionInfo = function(theText){
	jQuery("div.actionBox").fadeIn("fast", function () {});
	var obj = document.getElementById("actionBoxDiv");
	obj.innerHTML = theText;
	setTimeout(function(){
		jQuery("div.actionBox").fadeOut("slow", function () {
		});
	}, 2000);
}
RAVE.closeActionBox = function(){
	jQuery("div.actionBox").fadeOut("fast", function () {});
}

RAVE.printArray = function(theArray, lineEnd){
	var lineEnd = lineEnd || "\n";
	var retval = "";
	if( typeof theArray == "object"){
		for(var prop in theArray){
			var val = theArray[prop];
			if( typeof val == "array" || typeof val == "object"){
				retval += RAVE.printArray(val, lineEnd);
			} else {
				retval += prop + " : " + theArray[prop] + lineEnd;
			}
		}
	} else if( typeof theArray == "array"){
		for(var i=0;i<theArray.length; i++){
			var val = theArray[i];
			if( typeof val == "array" || typeof val == "object"){
				retval += RAVE.printArray(val, lineEnd);
			} else {
				retval += i + " : " + theArray[i] + lineEnd;
			}
		}
	} else {
		retval += theArray;
	}

	return retval;

};

RAVE.isNull = function (theValue) {
	if (theValue == "" || theValue == undefined || theValue == "undefined" || theValue == null) {
		return true;
	} else {
		return false;
	}
}
RAVE.path_parts = function (thePath) {
	
	if(thePath){
		var protocol = "";
		if(thePath.substring(0,4) == "http"){
			protocol = thePath.substring(0, thePath.indexOf("/")) + "//";
			thePath = thePath.substring(thePath.indexOf("/") + 2, thePath.length);
		}
		if(thePath.lastIndexOf("/") == thePath.length-1){
			thePath = thePath.substr(0, thePath.length-1);
		}

		var filepathA = thePath.split("/");
		var filename = filepathA.pop();
		var filepathB = filename.split(".");
		var extension = "";
		if (filepathB.length > 1) {
			extension = filepathB.pop();
		}
		var basename = filepathB.join(".");
		if(extension == ""){
			filepathA.push(filename);
		}
		var mybasepath = filepathA.join("/");

		if(mybasepath.length > 0){
			mybasepath = mybasepath + "/";
		}
		var Oret = new Object();
		Oret.filename = filename;
		Oret.extension = extension;
		Oret.basename = basename;
		Oret.basepath = protocol + mybasepath;
		Oret.filepath = protocol + thePath;
	} else {
		var Oret = new Object();
		Oret.filename = "";
		Oret.extension = "";
		Oret.basename = "";
		Oret.basepath = "";
		Oret.filepath = "";
	}
	return Oret;
}
RAVE.in_array = function (haystack, needle) {
	for (var p in haystack) {
		var item = haystack[p].toString().toLowerCase();
		var val = needle.toString().toLowerCase();
		if (item == val) {
			return true;
		}
	}
	return false;
}

RAVE.thinkerStart = function() {
	var obj = document.getElementById("thinker");
	obj.style.visibility = "visible";
};

RAVE.thinkerStop = function() {
	var obj = document.getElementById("thinker");
	obj.style.visibility = "hidden";
};

RAVE.clearList = function(id) {
	var obj = document.getElementById(id);
	obj.innerHTML = "";
};

RAVE.toggleDiv = function (theDiv){
	var obj = document.getElementById(theDiv);
	if(obj.style.display == "none"){
		RAVE.closeDiv(theDiv);
	} else {
		RAVE.openDiv(theDiv);
	}
	/*
	if(obj.style.visibility == "hidden"){
		RAVE.openDiv(theDiv);
	} else {
		RAVE.closeDiv(theDiv);
	}
	*/
};

RAVE.openDiv = function (theDiv){
	var obj = document.getElementById(theDiv);
	if(obj){
		obj.style.display = "block";
		//obj.style.visibility = "visible";
	}
};

RAVE.closeDiv = function (theDiv){
	var obj = document.getElementById(theDiv);
	if(obj){
		obj.style.display = "none";
		//obj.style.visibility = "hidden";
	}
};

RAVE.cleanName = function (theString){
	return theString.replace(/[^a-z0-9A-Z]/g, "");

};

RAVE.randomNumber = function (minNum, maxNum) {
	var retval = minNum + Math.floor(Math.random() * (maxNum - minNum + 1));
	return retval;
};

RAVE.trim = function(stringToTrim) {
	return stringToTrim.replace(/^\s+|\s+$/g,"");
};

RAVE.stripWhiteSpace = function (string_in) {
	var retval =  string_in.split("\n").join("").split("\r\n").join("").split("\t").join("").split("%0A").join("").split("%09").join("");
	return retval;
};

