var WMODE = 'dev'; //dev|stage
var DELAY = 3000; //milisecond

$(document).ready(function(){
	$('.disablecopypaste').live('copy paste', function (e) {
	   e.preventDefault();
	});
});
function siteLoadingOn(){
	$("#loading").removeClass("hidden");
	$("#site-warning,#site-message").addClass("hidden");
}
function siteLoadingOff(){
	$("#loading").addClass("hidden");
	$("#site-warning,#site-message").addClass("hidden");
}
function siteWarning(msg){
	$("#loading,#site-message").addClass("hidden");
	$("#site-warning").removeClass("hidden").html(msg);
}
function siteMessage(msg){
	$("#loading,#site-warning").addClass("hidden");
	$("#site-message").removeClass("hidden").html(msg);
}
function siteLoadingDialogOn(){
	$("#greyDiv").removeClass("hidden");
}
function siteLoadingDialogOff(){
	$("#greyDiv").addClass("hidden");
}
function debug(message){
	if(WMODE == 'dev'){
		alert(message);
	}
}
function showSysMessage(){
	$('#sys_message').fadeIn();
	setTimeout(function(){$('#sys_message').fadeOut();},DELAY);
}
function sysWarning(message,callBackFunc){
	siteLoadingDialogOn();
	$('#dialogElement').html(message);
	$('#dialogElement').dialog(
		{
			 width: 350,
			 height:150 ,
			 draggable: false,
			 resizable: false,
			 beforeClose: function(event, ui) { 
			 },
			 close: function(event, ui) { 
				siteLoadingDialogOff();
				eval(""+callBackFunc+";");
			 },
			buttons:{
				"OK": function(event,ui){
					siteLoadingDialogOff();
					$('#dialogElement').dialog("close");
				},
			},
			dialogClass: "alert",
			title: 'Warning' 
		}
	);
}
function sysMessage(message,callBackFunc){
	siteLoadingDialogOn();
	$('#dialogElement').html(message);
	$('#dialogElement').dialog(
		{
			 width: 350,
			 height:150 ,
			 draggable: false,
			 resizable: false,
			 beforeClose: function(event, ui) { 
			 },
			 close: function(event, ui) { 
				siteLoadingDialogOff();
				eval(""+callBackFunc+";");
			 },
			buttons:{
				"OK": function(event,ui){
					siteLoadingDialogOff();
					$('#dialogElement').dialog("close");
				},
			},
			dialogClass: "",
			title: 'Message' 
		}
	);
}
function sysConfirm(message,callBackFunc){
	siteLoadingDialogOn();
	$('#dialogElement').html(message);
	$('#dialogElement').dialog(
		{
			 width: 350,
			 height:150 ,
			 draggable: false,
			 resizable: false,
			 beforeClose: function(event, ui) { 
			 },
			 close: function(event, ui) { 
				siteLoadingDialogOff();
			 },
			buttons:{
				"OK": function(event,ui){
					siteLoadingDialogOff();
					$('#dialogElement').dialog("close");
					eval(""+callBackFunc+";");
				},
				"Cancel": function(event,ui){
					siteLoadingDialogOff();
					$('#dialogElement').dialog("close");
				}
			},
			dialogClass: "",
			title: 'Confirm' 
		}
	);
}




