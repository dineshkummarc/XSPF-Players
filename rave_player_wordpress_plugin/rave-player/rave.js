///////////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////
//                                                      ///////
//                       Rave JS                        ///////
//                   Version 2.0.29                     ///////
//                                                      ///////
//        Available at http://www.wimpyplayer.com       ///////
//                 2002-2012 Plaino LLC                 ///////
//                                                      ///////
///////////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////
//                                                      ///////
//                USE AT YOUR OWN RISK                  ///////
//                                                      ///////
///////////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////
//                                                      ///////
//                       OPTIONS                        ///////
//                                                      ///////
///////////////////////////////////////////////////////////////


// Enter your registration code here:
var wimpyReg			= "";

// The following should refer to a filename only, not a full URL. 
// We've provided this option so that you can change the file name if needed.
var wimpySwfBasename	= "rave.swf";
var wimpyAppBasename	= "rave.php";
var wimpyPopout			= "rave_popout.html";
var wimpyFullscreen		= "rave_fullscreen.html";

// Enter your default configuration options here: 
// When entering options that are references to files 
// (e.g. wimpyApp, wimpySwf, plugPlaylist, onTrackCompleteURL), 
// be sure to use a full URL to the file.
var defaultWimpyConfigs = new Object();
defaultWimpyConfigs.wimpyReg			= wimpyReg;
defaultWimpyConfigs.wimpySwf			= wimpySwfBasename;
defaultWimpyConfigs.wimpyApp			= wimpyAppBasename;
defaultWimpyConfigs.wimpySkin			= "";
defaultWimpyConfigs.startPlayingOnload	= "";
defaultWimpyConfigs.startOnTrack		= "";
defaultWimpyConfigs.autoAdvance			= "";
defaultWimpyConfigs.loopTrack			= "";
defaultWimpyConfigs.repeatPlaylist		= "";
defaultWimpyConfigs.randomPlayback		= "";
defaultWimpyConfigs.randomOnLoad		= "";
defaultWimpyConfigs.sortField			= "";
defaultWimpyConfigs.sortOrder			= "";
defaultWimpyConfigs.bufferSeconds		= "";
defaultWimpyConfigs.theVolume			= "";
defaultWimpyConfigs.limitPlaytime		= "";
defaultWimpyConfigs.resume				= "";
defaultWimpyConfigs.scrollFormat		= "";
defaultWimpyConfigs.timeFormat			= "";
defaultWimpyConfigs.infoDisplaySpeed	= "";
defaultWimpyConfigs.fsMode				= "";
defaultWimpyConfigs.setAspectRatio		= "";
defaultWimpyConfigs.clickWindowAction	= "";
defaultWimpyConfigs.infoButtonAction	= "";
defaultWimpyConfigs.linkToWindow		= "";
defaultWimpyConfigs.coverartBasename	= "";
defaultWimpyConfigs.popUpHelp			= "";
defaultWimpyConfigs.enableDownloads		= "";
defaultWimpyConfigs.useSysCodePage		= "";
defaultWimpyConfigs.wimpyHTMLpageTitle	= "";
defaultWimpyConfigs.tptBkgd				= "";
defaultWimpyConfigs.bkgdColor			= "#000000";
defaultWimpyConfigs.wimpyWidth			= "250";
defaultWimpyConfigs.wimpyHeight			= "290";
defaultWimpyConfigs.debugMode			= "";
defaultWimpyConfigs.startupLogo			= "";
defaultWimpyConfigs.defaultImage		= "";
defaultWimpyConfigs.onTrackComplete		= "";
defaultWimpyConfigs.onTrackCompleteURL	= "";
defaultWimpyConfigs.plugPlaylist		= "";
defaultWimpyConfigs.plugEvery			= "";
defaultWimpyConfigs.getMyid3info		= "";
defaultWimpyConfigs.findAllMedia		= "";
defaultWimpyConfigs.hide_folders		= "";
defaultWimpyConfigs.hide_files			= "";
defaultWimpyConfigs.playlist			= "";


/////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////
////////////                                     ////////////
////////////    Advanced Usage (experts only!)   ////////////
////////////                                     ////////////
/////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////

// When enableWimpyEvents is set to TRUE, then the following functions will be enabled:
//    wimpy_amReady
//    handlTrackStarted
//    handleTrackDon
// These "handler" functions are currently set up for use with Example 6 and 7 (readme_rave_js_example6.html).

var enableWimpyEvents = false;



// This function is pinged when Wimpy is ready and able to accept JavaScript calls / interaction.
// NOTE: See also wimpy_amReady_ask
function handleWimpyInit(retval){

	// Your code here:

	// NOTE: The following code is used for example purposes:
	var retText = "Wimpy is ready:" + retval + "<br>";
	writeitAppend(retText,"wimpySaid");


}


// This function gets pinged every time a track starts to play.
function handlTrackStarted(returnedObject){

	// Your code here:

	// NOTE: The following code is used for example purposes:
	var retText = 'Track Started. <br>&nbsp;&nbsp;Track data should be visible in the "Track info" section below.<br>';
	writeitAppend(retText, "wimpySaid");
	displayPlaylistObject(returnedObject);


}



// This function gets pinged each time a track finnishes playing.
function handleTrackDone(returnedObject){
	
	// Your code here:

	// NOTE: The following code is used for example purposes:

	var retText = 'Track Done. <br>&nbsp;&nbsp;Track data should be visible in the "Track info" section below.<br>';
	writeitAppend(retText, "wimpySaid");
	displayPlaylistObject(returnedObject);


}

// This function gets pinged when an external link is clicked.
// NOTE: The option "linkToWindow" must be set to "javascript"
// Example:
// wimpyConfigsXXXX.linkToWindow="javascript";
function handleLinkClick(returnedObject){
	
	// Your code here:

	// NOTE: The following code is used for example purposes:

	var retText = 'Link Click. <br>&nbsp;&nbsp;Track "link" field data:'+returnedObject+'<br>';
	writeitAppend(retText, "wimpySaid");
	displayPlaylistObject(returnedObject);


}

/////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////
////////////                                     ////////////
////////////       Do not edit below here        ////////////
////////////                                     ////////////
/////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////



///////////////////////////////
//
//        UTILITIES
//
///////////////////////////////

function randomNumber(minNum, maxNum) {
	return (minNum + Math.floor(Math.random() * (maxNum - minNum + 1)));
}
function path_parts(thePath_in) {
	var AthePath = unescape(thePath_in).split("?");
	var thePath = AthePath[0];
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
	Oret.basepath = mybasepath;
	Oret.filepath = thePath;
	return Oret;
}
function getExtension(theFilename){
	return unescape(theFilename).split("/").pop().split(".").pop().toLowerCase();
}
function trim (str) {
	if(str){
		var	str = str.replace(/^\s\s*/, ''),
			ws = /\s/,
			i = str.length;
		while (ws.test(str.charAt(--i)));
		return str.slice(0, i + 1);
	} else {
		return str;
	}
}
function stripWhiteSpace(string_in) {
	var retval =  string_in.split("\n").join("").split("\r\n").join("").split("\t").join("").split("%0A").join("").split("%09").join("");
	return retval;
}
function getQueryString(){
	var qsParm = new Array();
	var q = window.location.search || document.location.hash;
	var query = q.substring(1);
	var parms = query.split('&');
	for (var i=0; i<parms.length; i++) {
		var pos = parms[i].indexOf('=');
		if (pos > 0) {
			var key = parms[i].substring(0,pos);
			var val = parms[i].substring(pos+1);
			qsParm[key] = val;
		}
	}
	return qsParm;
}

var XMLio = [];
function XMLimport(theURL, handler) {
	if(window.ActiveXObject ) {
		var id = XMLio.length;
		var AX = ["Msxml2.XMLHTTP", "Microsoft.XMLHTTP","Microsoft.XMLDOM"];
		for( var i = 0; !XMLio[id] && i < AX.length; i++ ) {
			try {XMLio[id] = new ActiveXObject( AX[i] );} catch(e) {}
		}
		if(XMLio[id]) {
			XMLio[id].onreadystatechange = new Function( 'if( XMLio['+(id)+'].readyState == 4 ) { '+handler+'(XMLio['+(id)+'].responseXML);}' );
			if( XMLio[id].load ) {
				XMLio[id].load(theURL);
			} else {
				XMLio[id].open('GET', theURL, true);
				XMLio[id].send(null);
			}
			return true;
		}
	} else {
		try{
			var id = XMLio.length;
			XMLio[id] = new XMLHttpRequest();
			XMLio[id].onreadystatechange = new Function('if(XMLio['+(id)+'].readyState == 4){if(XMLio['+(id)+'].status == 200 ) {'+handler+'(XMLio['+(id)+'].responseXML);} else {'+handler+'(false);}}');
			XMLio[id].open("GET", theURL, true);
			XMLio[id].send(null);
			return true;
		} catch(e){
			// ignore;
		}
		
	}
	return false;
}

///////////////////////////////
///////////////////////////////
///////////////////////////////
///////////////////////////////
///////////////////////////////
//
//        RENDER PLAYER
//
///////////////////////////////

var wimpyDomID = "wimpy";

function makeWimpyPlayer(configsIN, theTarget){
	
	var theConfigObject = configsIN || "";
	var theTarget = theTarget || "flashcontent";

	if(typeof(theConfigObject) == "string"){
		var theConfigObject = defaultWimpyConfigs;

		if(theConfigObject != ""){
			theConfigObject.playlist = configsIN;
		}
	}
	
	for(var prop in defaultWimpyConfigs){
		theConfigObject[prop] = theConfigObject[prop] || defaultWimpyConfigs[prop];
	}

	if(theConfigObject.bkgdColor.substring(0,1) != "#"){
		theConfigObject.bkgdColor = "#" + theConfigObject.bkgdColor;
	}
	
	
	var swf = theConfigObject.wimpySwf + "?cachebust=" + new Date().getTime();
	var setW = theConfigObject.wimpyWidth;
	var setH = theConfigObject.wimpyHeight;
	var setBkgdColor = theConfigObject.bkgdColor;
	
	theConfigObject["wimpyInstall"] = "";
	theConfigObject["wimpyHTMLpageTitle"] = "";
	theConfigObject["wimpyJS"] = "";
	theConfigObject["wimpySwf"] = "";
	theConfigObject["wimpyWidth"] = "";
	theConfigObject["wimpyHeight"] = "";
	theConfigObject["bkgdColor"] = "";
	theConfigObject["hide_files"] = "";
	theConfigObject["hide_folders"] = "";
	theConfigObject["findAllMedia"] = "";
	
	var flashvars = new Array();
	for(var prop in theConfigObject){
		var val = "";
		if(prop == "playlist"){
			val = theConfigObject[prop];
		} else {
			val = encodeURI(theConfigObject[prop]);
		}
		if(val != ""){
			flashvars.push(prop + "=" + val);
		}
	}
	var setFlashvars = flashvars.join("&");
	
	var confObj = new Object();
	confObj.swf 		= swf;
	confObj.swfid 		= wimpyDomID;
	confObj.bkgdColor 	= setBkgdColor;
	confObj.width 		= setW;
	confObj.height 		= setH;
	confObj.targetDiv 	= theTarget;
	confObj.flashvars 	= setFlashvars;
	
	wimpyWriteCoreSWF(confObj);

}

function wimpyWriteCoreSWF(confObj){
	

// "8", theConfigObject.bkgdColor
	var fn = function() {
		var att = new Object();
		att.data 	= confObj.swf;
		att.width 	= confObj.width;
		att.height 	= confObj.height;
		att.id 		= confObj.swfid;
		att.name 	= confObj.swfid;
		
		var par = new Object();
		par.scale 			= "noscale";
		par.salign 			= "lt";
		par.allowScriptAccess = "always";
		par.allowFullScreen = "true";
		par.menu 			= "false";
		par.wmode 			= "transparent";
		par.bgcolor			= confObj.bkgdColor;
		par.flashvars 		= confObj.flashvars;
		
		swfobject.createSWF(att, par, confObj.targetDiv);
		
	};
	
	swfobject.addDomLoadEvent(fn);
}


///////////////////////////////
///////////////////////////////
///////////////////////////////
///////////////////////////////
///////////////////////////////
//
//        POP OUT
//
///////////////////////////////

var wimpy_popout_window;

function wimpyIsOpen(){
	if (!wimpy_popout_window || wimpy_popout_window.closed){
		return false;
	} else {
		return true;
	}
}

function isNull(theValue) {
	if (theValue == "" || theValue == undefined || theValue == "undefined" || theValue == null || theValue == "null") {
		return true;
	} else {
		return false;
	}
}

function notifyOpener() {
	if(self.opener || !self.opener.wimpy_popout_window) {
		self.opener.wimpy_popout_window = self;
	}
}

function wimpy_popAndPlay(baseURL, theWidth, theHeight, thePlaylist, startPlayingOnload){


	if(isNull(theWidth)){
		theWidth = defaultWimpyConfigs.wimpyWidth;
	}
	if(isNull(theHeight)){
		theHeight = defaultWimpyConfigs.wimpyHeight;
	}
	if(isNull(startPlayingOnload)){
		startPlayingOnload = "yes";
	}
	// Old IE version don't do substr(-1)
	if ( (!isNull(baseURL) && baseURL != "") && baseURL.substring(baseURL.length - 1, baseURL.length) != "/") {
		baseURL += "/"; 
	}
	var winName = "a" + randomNumber(1, 1000);
	// Added "resume" within swf if we're doing a pop-out.
	//var winURL = myPopPage + "?w=" + theWidth + "&h=" + theHeight + "&startPlayingOnload=" + startPlayingOnload + "&playlist=" + thePlaylist;
	var winURL = baseURL + wimpyPopout + "?w=" + theWidth + "&h=" + theHeight + "&startPlayingOnload=" + startPlayingOnload; // + 
	wimpy_popout_window = window.open(winURL, winName,'width=' + theWidth + ',height=' + theHeight);
}

function wimpy_popout_make(){
	
	var queryString = getQueryString();
	
	var Ourl = path_parts(location.href);
	
	
	var confObj = new Object();
	confObj.swf 		= Ourl.basepath + wimpySwfBasename + "?cachebust=" + new Date().getTime();
	confObj.swfid 		= wimpyDomID;
	confObj.bkgdColor 	= "#000000";
	confObj.width 		= queryString['w'];
	confObj.height 		= queryString['h'];
	confObj.targetDiv 	= "flashcontent";
	confObj.flashvars 	= "wimpyPop=yes";
	
	wimpyWriteCoreSWF(confObj);

	/*
	var so = new SWFObject(Ourl.basepath + wimpySwfBasename + "?cachebust=" + new Date().getTime(), wimpyDomID, queryString['w'], queryString['h'], "8", "#000000");
	so.addVariable("wimpyPop", "yes");
	so.addParam("scale", "noscale");
	so.addParam("salign", "lt");
	so.addParam("allowScriptAccess", "always");
	so.addParam("allowFullScreen", "true");
	so.addParam("menu", "false");
	so.write("flashcontent");
	*/
	//notifyOpener();
	setInterval( notifyOpener, 1000 );
}


///////////////////////////////
///////////////////////////////
///////////////////////////////
///////////////////////////////
///////////////////////////////
//
//        FULL SCREEN
//
///////////////////////////////

function wimpy_fullscreen(baseURL){
	
	var winName = "a" + randomNumber(1, 1000);
	window.open(baseURL + wimpyFullscreen, winName,'resizable=yes');
}

function wimpy_fullscreen_make(){
	window.moveTo(0,0);
	window.resizeTo(screen.availWidth/2, screen.availHeight/2);
	//var queryString = getQueryString();
	var Ourl = path_parts(location.href);
	
	
	var confObj = new Object();
	confObj.swf 		= Ourl.basepath + wimpySwfBasename + "?cachebust=" + new Date().getTime();
	confObj.swfid 		= "wimpyFS";
	confObj.bkgdColor 	= "#000000";
	confObj.width 		= "100%";
	confObj.height 		= "100%";
	confObj.targetDiv 	= "flashcontent";
	confObj.flashvars 	= "wimpyFS=yes&cachebust=" + (  new Date().getTime()  );
	
	
	wimpyWriteCoreSWF(confObj);
	
	/*
	var so = new SWFObject(Ourl.basepath + wimpySwfBasename, "wimpyFS", "100%", "100%", "8", "#000000");
	so.addVariable("wimpyFS", "yes");
	so.addVariable("cachebust", new Date().getTime());
	so.addParam("scale", "noscale");
	so.addParam("salign", "lt");
	so.addParam("allowScriptAccess", "always");
	so.addParam("menu", "false");
	so.write("flashcontent");
	*/
}

///////////////////////////////
///////////////////////////////
///////////////////////////////
///////////////////////////////
///////////////////////////////
//
//        CONTROLS
//
///////////////////////////////

var wimpyUserAgent = navigator.appName.indexOf("Microsoft");

function wimpy_getWimpyByID(){
	//document.getElementsByName(wimpyDomID);
	return document.getElementById(wimpyDomID);
}

function wimpy_play(){
	return wimpy_getWimpyByID().js_wimpy_play();
}
function wimpy_stop(){
	return wimpy_getWimpyByID().js_wimpy_stop();
}
function wimpy_pause(){
	return wimpy_getWimpyByID().js_wimpy_pause();
}
function wimpy_next(){
	return wimpy_getWimpyByID().js_wimpy_next();
}
function wimpy_prev(){
	return wimpy_getWimpyByID().js_wimpy_prev();
}
function wimpy_gotoTrack(trackNumber){
	return wimpy_getWimpyByID().js_wimpy_gotoTrack(trackNumber);
}
function wimpy_clearPlaylist(){
	return wimpy_getWimpyByID().js_wimpy_clearPlaylist();
}
function wimpy_appendPlaylist(XMLplaylist, playOnLoad){
	return wimpy_getWimpyByID().js_wimpy_appendPlaylist(XMLplaylist, playOnLoad);
}
function wimpy_getTrackInfo(trackNumber){
	var sendTrackNumber = trackNumber || false;
	return wimpy_getWimpyByID().js_wimpy_getTrackInfo(sendTrackNumber);
}
function wimpy_loadExternalPlaylist(playlistURL, startOnLoad){
	return wimpy_getWimpyByID().js_wimpy_loadExternalPlaylist(playlistURL, startOnLoad);
}

function wimpy_amReady_ask(){
	return wimpy_getWimpyByID().js_wimpy_amReady_ask();
}

function wimpy_setVolume(thePercent){
	return wimpy_getWimpyByID().js_wimpy_setVolume(thePercent);
}

function wimpy_setLoopTrackState(theState){
	// off, on
	return wimpy_getWimpyByID().js_wimpy_setLoopTrackState(theState);
}

function wimpy_setRandomState(theState){
	// off, on
	return wimpy_getWimpyByID().js_wimpy_setRandomState(theState);
}

function wimpy_setRepeatState(theState){
	// off, on
	return wimpy_getWimpyByID().js_wimpy_setRepeatState(theState);
}

function wimpy_setMuteState(theState){
	// off, on
	return wimpy_getWimpyByID().js_wimpy_setMuteState(theState);
}

function wimpy_updateInfoDisplay(theArtist, theTitle){
	return wimpy_getWimpyByID().js_wimpy_updateInfoDisplay(theArtist, theTitle);
}




function wimpy_getPlayheadPercent(){
	return wimpy_getWimpyByID().js_wimpy_getPlayheadPercent();
}
function wimpy_getPlayheadSeconds(){
	return wimpy_getWimpyByID().js_wimpy_getPlayheadSeconds();
}


function wimpy_setPlayheadPercent(thePercent){
	return wimpy_getWimpyByID().js_wimpy_setPlayheadPercent(thePercent);
}
function wimpy_setPlayheadSeconds(theSeconds){
	return wimpy_getWimpyByID().js_wimpy_setPlayheadSeconds(theSeconds);
}
function wimpy_getLoadPercent(){
	var retval = "";
	retval = wimpy_getWimpyByID().js_wimpy_getLoadPercent();
	return retval;
}
function wimpy_getLoadState(){
	var retval = "";
	return wimpy_getWimpyByID().js_wimpy_getLoadState();
	return retval;
}
function wimpy_getPlayerState(){
	var retval = "";
	return wimpy_getWimpyByID().js_wimpy_getPlayerState();
	return retval;
}

function wimpy_getTotalPlaylistItems(){
	var retval = "";
	retval = wimpy_getWimpyByID().js_wimpy_getTotalPlaylistItems();
	return retval;
}

function wimpy_getPlaylist(){
	var retval;
	retval = wimpy_getWimpyByID().js_wimpy_getPlaylist();
	return retval;
}

function wimpy_getPlaylistXML(){
	var retval = "";
	retval = wimpy_getWimpyByID().js_wimpy_getPlaylistXML();
	return retval;
}

function wimpy_callPlugin(arg1, arg2){
	var retval = "";
	retval = wimpy_getWimpyByID().js_wimpy_callPlugin(arg1, arg2);
	return retval;
}

function wimpy_resume_kill(){
	var retval = "";
	retval = wimpy_getWimpyByID().js_wimpy_resume_kill();
	return retval;
}
// The following are called by Wimpy. DO NOTE invoke these methods, 
// Wimpy will call them as needed to inform you of an event.
function wimpy_amReady(retval){
	if(enableWimpyEvents){
		handleWimpyInit(retval);
	}
}
function wimpy_trackStarted(returnedObject){
	if(enableWimpyEvents){
		handlTrackStarted(returnedObject);
	}
}
function wimpy_trackDone(returnedObject){
	if(enableWimpyEvents){
		handleTrackDone(returnedObject);
	}
}

function wimpy_linkClick(returnedObject){
	if(enableWimpyEvents){
		handleLinkClick(returnedObject);
	}
}
/*	SWFObject v2.2 <http://code.google.com/p/swfobject/> 
	is released under the MIT License <http://www.opensource.org/licenses/mit-license.php> 
*/
var swfobject=function(){var D="undefined",r="object",S="Shockwave Flash",W="ShockwaveFlash.ShockwaveFlash",q="application/x-shockwave-flash",R="SWFObjectExprInst",x="onreadystatechange",O=window,j=document,t=navigator,T=false,U=[h],o=[],N=[],I=[],l,Q,E,B,J=false,a=false,n,G,m=true,M=function(){var aa=typeof j.getElementById!=D&&typeof j.getElementsByTagName!=D&&typeof j.createElement!=D,ah=t.userAgent.toLowerCase(),Y=t.platform.toLowerCase(),ae=Y?/win/.test(Y):/win/.test(ah),ac=Y?/mac/.test(Y):/mac/.test(ah),af=/webkit/.test(ah)?parseFloat(ah.replace(/^.*webkit\/(\d+(\.\d+)?).*$/,"$1")):false,X=!+"\v1",ag=[0,0,0],ab=null;if(typeof t.plugins!=D&&typeof t.plugins[S]==r){ab=t.plugins[S].description;if(ab&&!(typeof t.mimeTypes!=D&&t.mimeTypes[q]&&!t.mimeTypes[q].enabledPlugin)){T=true;X=false;ab=ab.replace(/^.*\s+(\S+\s+\S+$)/,"$1");ag[0]=parseInt(ab.replace(/^(.*)\..*$/,"$1"),10);ag[1]=parseInt(ab.replace(/^.*\.(.*)\s.*$/,"$1"),10);ag[2]=/[a-zA-Z]/.test(ab)?parseInt(ab.replace(/^.*[a-zA-Z]+(.*)$/,"$1"),10):0}}else{if(typeof O.ActiveXObject!=D){try{var ad=new ActiveXObject(W);if(ad){ab=ad.GetVariable("$version");if(ab){X=true;ab=ab.split(" ")[1].split(",");ag=[parseInt(ab[0],10),parseInt(ab[1],10),parseInt(ab[2],10)]}}}catch(Z){}}}return{w3:aa,pv:ag,wk:af,ie:X,win:ae,mac:ac}}(),k=function(){if(!M.w3){return}if((typeof j.readyState!=D&&j.readyState=="complete")||(typeof j.readyState==D&&(j.getElementsByTagName("body")[0]||j.body))){f()}if(!J){if(typeof j.addEventListener!=D){j.addEventListener("DOMContentLoaded",f,false)}if(M.ie&&M.win){j.attachEvent(x,function(){if(j.readyState=="complete"){j.detachEvent(x,arguments.callee);f()}});if(O==top){(function(){if(J){return}try{j.documentElement.doScroll("left")}catch(X){setTimeout(arguments.callee,0);return}f()})()}}if(M.wk){(function(){if(J){return}if(!/loaded|complete/.test(j.readyState)){setTimeout(arguments.callee,0);return}f()})()}s(f)}}();function f(){if(J){return}try{var Z=j.getElementsByTagName("body")[0].appendChild(C("span"));Z.parentNode.removeChild(Z)}catch(aa){return}J=true;var X=U.length;for(var Y=0;Y<X;Y++){U[Y]()}}function K(X){if(J){X()}else{U[U.length]=X}}function s(Y){if(typeof O.addEventListener!=D){O.addEventListener("load",Y,false)}else{if(typeof j.addEventListener!=D){j.addEventListener("load",Y,false)}else{if(typeof O.attachEvent!=D){i(O,"onload",Y)}else{if(typeof O.onload=="function"){var X=O.onload;O.onload=function(){X();Y()}}else{O.onload=Y}}}}}function h(){if(T){V()}else{H()}}function V(){var X=j.getElementsByTagName("body")[0];var aa=C(r);aa.setAttribute("type",q);var Z=X.appendChild(aa);if(Z){var Y=0;(function(){if(typeof Z.GetVariable!=D){var ab=Z.GetVariable("$version");if(ab){ab=ab.split(" ")[1].split(",");M.pv=[parseInt(ab[0],10),parseInt(ab[1],10),parseInt(ab[2],10)]}}else{if(Y<10){Y++;setTimeout(arguments.callee,10);return}}X.removeChild(aa);Z=null;H()})()}else{H()}}function H(){var ag=o.length;if(ag>0){for(var af=0;af<ag;af++){var Y=o[af].id;var ab=o[af].callbackFn;var aa={success:false,id:Y};if(M.pv[0]>0){var ae=c(Y);if(ae){if(F(o[af].swfVersion)&&!(M.wk&&M.wk<312)){w(Y,true);if(ab){aa.success=true;aa.ref=z(Y);ab(aa)}}else{if(o[af].expressInstall&&A()){var ai={};ai.data=o[af].expressInstall;ai.width=ae.getAttribute("width")||"0";ai.height=ae.getAttribute("height")||"0";if(ae.getAttribute("class")){ai.styleclass=ae.getAttribute("class")}if(ae.getAttribute("align")){ai.align=ae.getAttribute("align")}var ah={};var X=ae.getElementsByTagName("param");var ac=X.length;for(var ad=0;ad<ac;ad++){if(X[ad].getAttribute("name").toLowerCase()!="movie"){ah[X[ad].getAttribute("name")]=X[ad].getAttribute("value")}}P(ai,ah,Y,ab)}else{p(ae);if(ab){ab(aa)}}}}}else{w(Y,true);if(ab){var Z=z(Y);if(Z&&typeof Z.SetVariable!=D){aa.success=true;aa.ref=Z}ab(aa)}}}}}function z(aa){var X=null;var Y=c(aa);if(Y&&Y.nodeName=="OBJECT"){if(typeof Y.SetVariable!=D){X=Y}else{var Z=Y.getElementsByTagName(r)[0];if(Z){X=Z}}}return X}function A(){return !a&&F("6.0.65")&&(M.win||M.mac)&&!(M.wk&&M.wk<312)}function P(aa,ab,X,Z){a=true;E=Z||null;B={success:false,id:X};var ae=c(X);if(ae){if(ae.nodeName=="OBJECT"){l=g(ae);Q=null}else{l=ae;Q=X}aa.id=R;if(typeof aa.width==D||(!/%$/.test(aa.width)&&parseInt(aa.width,10)<310)){aa.width="310"}if(typeof aa.height==D||(!/%$/.test(aa.height)&&parseInt(aa.height,10)<137)){aa.height="137"}j.title=j.title.slice(0,47)+" - Flash Player Installation";var ad=M.ie&&M.win?"ActiveX":"PlugIn",ac="MMredirectURL="+O.location.toString().replace(/&/g,"%26")+"&MMplayerType="+ad+"&MMdoctitle="+j.title;if(typeof ab.flashvars!=D){ab.flashvars+="&"+ac}else{ab.flashvars=ac}if(M.ie&&M.win&&ae.readyState!=4){var Y=C("div");X+="SWFObjectNew";Y.setAttribute("id",X);ae.parentNode.insertBefore(Y,ae);ae.style.display="none";(function(){if(ae.readyState==4){ae.parentNode.removeChild(ae)}else{setTimeout(arguments.callee,10)}})()}u(aa,ab,X)}}function p(Y){if(M.ie&&M.win&&Y.readyState!=4){var X=C("div");Y.parentNode.insertBefore(X,Y);X.parentNode.replaceChild(g(Y),X);Y.style.display="none";(function(){if(Y.readyState==4){Y.parentNode.removeChild(Y)}else{setTimeout(arguments.callee,10)}})()}else{Y.parentNode.replaceChild(g(Y),Y)}}function g(ab){var aa=C("div");if(M.win&&M.ie){aa.innerHTML=ab.innerHTML}else{var Y=ab.getElementsByTagName(r)[0];if(Y){var ad=Y.childNodes;if(ad){var X=ad.length;for(var Z=0;Z<X;Z++){if(!(ad[Z].nodeType==1&&ad[Z].nodeName=="PARAM")&&!(ad[Z].nodeType==8)){aa.appendChild(ad[Z].cloneNode(true))}}}}}return aa}function u(ai,ag,Y){var X,aa=c(Y);if(M.wk&&M.wk<312){return X}if(aa){if(typeof ai.id==D){ai.id=Y}if(M.ie&&M.win){var ah="";for(var ae in ai){if(ai[ae]!=Object.prototype[ae]){if(ae.toLowerCase()=="data"){ag.movie=ai[ae]}else{if(ae.toLowerCase()=="styleclass"){ah+=' class="'+ai[ae]+'"'}else{if(ae.toLowerCase()!="classid"){ah+=" "+ae+'="'+ai[ae]+'"'}}}}}var af="";for(var ad in ag){if(ag[ad]!=Object.prototype[ad]){af+='<param name="'+ad+'" value="'+ag[ad]+'" />'}}aa.outerHTML='<object classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000"'+ah+">"+af+"</object>";N[N.length]=ai.id;X=c(ai.id)}else{var Z=C(r);Z.setAttribute("type",q);for(var ac in ai){if(ai[ac]!=Object.prototype[ac]){if(ac.toLowerCase()=="styleclass"){Z.setAttribute("class",ai[ac])}else{if(ac.toLowerCase()!="classid"){Z.setAttribute(ac,ai[ac])}}}}for(var ab in ag){if(ag[ab]!=Object.prototype[ab]&&ab.toLowerCase()!="movie"){e(Z,ab,ag[ab])}}aa.parentNode.replaceChild(Z,aa);X=Z}}return X}function e(Z,X,Y){var aa=C("param");aa.setAttribute("name",X);aa.setAttribute("value",Y);Z.appendChild(aa)}function y(Y){var X=c(Y);if(X&&X.nodeName=="OBJECT"){if(M.ie&&M.win){X.style.display="none";(function(){if(X.readyState==4){b(Y)}else{setTimeout(arguments.callee,10)}})()}else{X.parentNode.removeChild(X)}}}function b(Z){var Y=c(Z);if(Y){for(var X in Y){if(typeof Y[X]=="function"){Y[X]=null}}Y.parentNode.removeChild(Y)}}function c(Z){var X=null;try{X=j.getElementById(Z)}catch(Y){}return X}function C(X){return j.createElement(X)}function i(Z,X,Y){Z.attachEvent(X,Y);I[I.length]=[Z,X,Y]}function F(Z){var Y=M.pv,X=Z.split(".");X[0]=parseInt(X[0],10);X[1]=parseInt(X[1],10)||0;X[2]=parseInt(X[2],10)||0;return(Y[0]>X[0]||(Y[0]==X[0]&&Y[1]>X[1])||(Y[0]==X[0]&&Y[1]==X[1]&&Y[2]>=X[2]))?true:false}function v(ac,Y,ad,ab){if(M.ie&&M.mac){return}var aa=j.getElementsByTagName("head")[0];if(!aa){return}var X=(ad&&typeof ad=="string")?ad:"screen";if(ab){n=null;G=null}if(!n||G!=X){var Z=C("style");Z.setAttribute("type","text/css");Z.setAttribute("media",X);n=aa.appendChild(Z);if(M.ie&&M.win&&typeof j.styleSheets!=D&&j.styleSheets.length>0){n=j.styleSheets[j.styleSheets.length-1]}G=X}if(M.ie&&M.win){if(n&&typeof n.addRule==r){n.addRule(ac,Y)}}else{if(n&&typeof j.createTextNode!=D){n.appendChild(j.createTextNode(ac+" {"+Y+"}"))}}}function w(Z,X){if(!m){return}var Y=X?"visible":"hidden";if(J&&c(Z)){c(Z).style.visibility=Y}else{v("#"+Z,"visibility:"+Y)}}function L(Y){var Z=/[\\\"<>\.;]/;var X=Z.exec(Y)!=null;return X&&typeof encodeURIComponent!=D?encodeURIComponent(Y):Y}var d=function(){if(M.ie&&M.win){window.attachEvent("onunload",function(){var ac=I.length;for(var ab=0;ab<ac;ab++){I[ab][0].detachEvent(I[ab][1],I[ab][2])}var Z=N.length;for(var aa=0;aa<Z;aa++){y(N[aa])}for(var Y in M){M[Y]=null}M=null;for(var X in swfobject){swfobject[X]=null}swfobject=null})}}();return{registerObject:function(ab,X,aa,Z){if(M.w3&&ab&&X){var Y={};Y.id=ab;Y.swfVersion=X;Y.expressInstall=aa;Y.callbackFn=Z;o[o.length]=Y;w(ab,false)}else{if(Z){Z({success:false,id:ab})}}},getObjectById:function(X){if(M.w3){return z(X)}},embedSWF:function(ab,ah,ae,ag,Y,aa,Z,ad,af,ac){var X={success:false,id:ah};if(M.w3&&!(M.wk&&M.wk<312)&&ab&&ah&&ae&&ag&&Y){w(ah,false);K(function(){ae+="";ag+="";var aj={};if(af&&typeof af===r){for(var al in af){aj[al]=af[al]}}aj.data=ab;aj.width=ae;aj.height=ag;var am={};if(ad&&typeof ad===r){for(var ak in ad){am[ak]=ad[ak]}}if(Z&&typeof Z===r){for(var ai in Z){if(typeof am.flashvars!=D){am.flashvars+="&"+ai+"="+Z[ai]}else{am.flashvars=ai+"="+Z[ai]}}}if(F(Y)){var an=u(aj,am,ah);if(aj.id==ah){w(ah,true)}X.success=true;X.ref=an}else{if(aa&&A()){aj.data=aa;P(aj,am,ah,ac);return}else{w(ah,true)}}if(ac){ac(X)}})}else{if(ac){ac(X)}}},switchOffAutoHideShow:function(){m=false},ua:M,getFlashPlayerVersion:function(){return{major:M.pv[0],minor:M.pv[1],release:M.pv[2]}},hasFlashPlayerVersion:F,createSWF:function(Z,Y,X){if(M.w3){return u(Z,Y,X)}else{return undefined}},showExpressInstall:function(Z,aa,X,Y){if(M.w3&&A()){P(Z,aa,X,Y)}},removeSWF:function(X){if(M.w3){y(X)}},createCSS:function(aa,Z,Y,X){if(M.w3){v(aa,Z,Y,X)}},addDomLoadEvent:K,addLoadEvent:s,getQueryParamValue:function(aa){var Z=j.location.search||j.location.hash;if(Z){if(/\?/.test(Z)){Z=Z.split("?")[1]}if(aa==null){return L(Z)}var Y=Z.split("&");for(var X=0;X<Y.length;X++){if(Y[X].substring(0,Y[X].indexOf("="))==aa){return L(Y[X].substring((Y[X].indexOf("=")+1)))}}}return""},expressInstallCallback:function(){if(a){var X=c(R);if(X&&l){X.parentNode.replaceChild(l,X);if(Q){w(Q,true);if(M.ie&&M.win){l.style.display="block"}}if(E){E(B)}}a=false}}}}();