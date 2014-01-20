///////////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////
//                                                      ///////
//          Rave Player Plugin for Wordpress            ///////
//                   Version 1.0.14                     ///////
//                                                      ///////
//        Available at http://www.wimpyplayer.com       ///////
//            Copyright 2002-2012 Plaino LLC            ///////
//                                                      ///////
///////////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////
//                                                      ///////
//                USE AT YOUR OWN RISK                  ///////
//                                                      ///////
///////////////////////////////////////////////////////////////

// ===================================================================
// Wimpy Color Picker derived from Matt Kruse's color picker:
// http://www.mattkruse.com/
// ===================================================================

if(!RAVE){
	RAVE = new Object();
}

RAVE.cp_contents = "";
RAVE.makeColorPicker = function (){

	if(RAVE.cp_contents == ""){
		var colors = new Array("#FFFFFF","#F8F8F8","#F0F0F0","#E8E8E8","#E0E0E0","#D8D8D8","#D0D0D0","#C8C8C8","#C0C0C0","#B0B0B0","#A8A8A8","#A0A0A0","#989898","#909090","#787878","#707070","#686868","#606060","#585858","#505050","#404040","#383838","#303030","#000000","#F0DBDB","#F5D6D6","#FCCFCF","#E0B8B8","#EBADAD","#FA9E9E","#D19494","#E08585","#F76E6E","#C27070","#D65C5C","#F53D3D","#B24D4D","#CC3333","#F20D0D","#8F3D3D","#A32929","#C20A0A","#6B2E2E","#7A1F1F","#910808","#471F1F","#521414","#610505","#F0E6DB","#F5E6D6","#FCE6CF","#E0CCB8","#EBCCAD","#FACC9E","#D1B294","#E0B285","#F7B26E","#C29970","#D6995C","#F5993D","#B2804D","#CC8033","#F2800D","#8F663D","#A36629","#C2660A","#6B4C2E","#7A4C1F","#914C08","#47331F","#523314","#613305","#F0F0DB","#F5F5D6","#FCFCCF","#E0E0B8","#EBEBAD","#FAFA9E","#D1D194","#E0E085","#F7F76E","#C2C270","#D6D65C","#F5F53D","#B2B24D","#CCCC33","#F2F20D","#8F8F3D","#A3A329","#C2C20A","#6B6B2E","#7A7A1F","#919108","#47471F","#525214","#616105","#E6F0DB","#E6F5D6","#E6FCCF","#CCE0B8","#CCEBAD","#CCFA9E","#B2D194","#B3E085","#B3F76E","#99C270","#99D65C","#99F53D","#80B24D","#80CC33","#80F20D","#668F3D","#66A329","#66C20A","#4D6B2E","#4D7A1F","#4D9108","#33471F","#335214","#336105","#DBF0DB","#D6F5D6","#CFFCCF","#B8E0B8","#ADEBAD","#9EFA9E","#94D194","#85E085","#6EF76E","#70C270","#5CD65C","#3DF53D","#4DB24D","#33CC33","#0DF20D","#3D8F3D","#29A329","#0AC20A","#2E6B2E","#1F7A1F","#089108","#1F471F","#145214","#056105","#DBF0E6","#D6F5E6","#CFFCE6","#B8E0CC","#ADEBCC","#9EFACC","#94D1B2","#85E0B3","#6EF7B3","#70C299","#5CD699","#3DF599","#4DB280","#33CC80","#0DF280","#3D8F66","#29A366","#0AC266","#2E6B4D","#1F7A4D","#08914D","#1F4733","#145233","#056133","#DBF0F0","#D6F5F5","#CFFCFC","#B8E0E0","#ADEBEB","#9EFAFA","#94D1D1","#85E0E0","#6EF7F7","#70C2C2","#5CD6D6","#3DF5F5","#4DB2B2","#33CCCC","#0DF2F2","#3D8F8F","#29A3A3","#0AC2C2","#2E6B6B","#1F7A7A","#089191","#1F4747","#145252","#056161","#DBE6F0","#D6E6F5","#CFE5FC","#B8CCE0","#ADCCEB","#9ECCFA","#94B2D1","#85B2E0","#6EB2F7","#7099C2","#5C99D6","#3D99F5","#4D7FB2","#337FCC","#0D7FF2","#3D668F","#2966A3","#0A66C2","#2E4C6B","#1F4C7A","#084C91","#1F3347","#143352","#053361","#DBDBF0","#D6D6F5","#CFCFFC","#B8B8E0","#ADADEB","#9E9EFA","#9494D1","#8585E0","#6E6EF7","#7070C2","#5C5CD6","#3D3DF5","#4D4DB2","#3333CC","#0D0DF2","#3D3D8F","#2929A3","#0A0AC2","#2E2E6B","#1F1F7A","#080891","#1F1F47","#141452","#050561","#E6DBF0","#E6D6F5","#E5CFFC","#CCB8E0","#CCADEB","#CC9EFA","#B294D1","#B285E0","#B26EF7","#9970C2","#995CD6","#993DF5","#7F4DB2","#7F33CC","#7F0DF2","#663D8F","#6629A3","#660AC2","#4C2E6B","#4C1F7A","#4C0891","#331F47","#331452","#330561","#F0DBF0","#F5D6F5","#FCCFFC","#E0B8E0","#EBADEB","#FA9EFA","#D194D1","#E085E0","#F76EF7","#C270C2","#D65CD6","#F53DF5");
		var total = colors.length;
		var width = 24;
		RAVE.cp_contents = '<table width="100%" border=0 cellspacing=0 cellpadding=0>';
		var use_highlight = false;
		for(var i=0; i<total; i++){
			if((i % width) == 0){
				RAVE.cp_contents += "<tr>";
			}
			if(use_highlight){
				var mo = 'onMouseOver="RAVE.ColorPicker_highlightColor(\''+colors[i]+'\')"';
			} else {
				mo = "";
			}
			var myColor = colors[i];
			
			RAVE.cp_contents += '<td style="background-color:'+myColor+';cursor:pointer;cursor:hand;" onClick="javascript:RAVE.ColorPicker_pickColor(\''+myColor+'\');" '+mo+'>&nbsp;</td>';

			if( ((i+1)>=total) ||(((i+1) % width) == 0)){
				RAVE.cp_contents += "</tr>";
			}
		}
		RAVE.cp_contents += "</table>";
	}

	var x = document.getElementById("divColorPicker");
	x.style.cursor="hand";
	x.style.cursor="pointer";

	var obj = document.getElementById("divColorPicker");
	obj.innerHTML = RAVE.cp_contents;

}



RAVE.ColorPicker_pickColor = function (color){
	if(color!=null){
		document.form1.bkgdColor.value = color;
		RAVE.ColorPicker_highlightColor(color);
	}
}

RAVE.ColorPicker_set = function (){
	RAVE.ColorPicker_highlightColor(document.form1.bkgdColor.value);
}

RAVE.ColorPicker_highlightColor = function (c){
	var d = document.getElementById("previewWindow");
	d.style.backgroundColor = c;
	RAVE.ColorPickerClose();
	RAVE.updatePreview();
}

RAVE.ColorPickerOpen = function (){
	RAVE.makeColorPicker();
}

RAVE.ColorPickerClose = function (){
	var x = document.getElementById("divColorPicker");
	var obj = document.getElementById("divColorPicker");
	obj.innerHTML = "";
}



