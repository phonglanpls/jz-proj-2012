function callFuncShowLatestBackstage(cat){
	$('#LatestBackstageContextLoader').toggle();
	$.get(BASE_URI+'user/backstage/callFuncShowLatestBackstage',{cat:cat},function(res){
		$('#LatestBackstageContextLoader').toggle();
		$('#backstagePhotoAsyncDiv').html(res);
	});
}

function callFuncShowMostViewBackstage(cat){
	$('#MostViewBackstageContextLoader').toggle();
	$.get(BASE_URI+'user/backstage/callFuncShowMostViewBackstage',{cat:cat},function(res){
		$('#MostViewBackstageContextLoader').toggle();
		$('#backstagePhotoAsyncDiv').html(res);
	});
}

function callFuncShowRandomBackstage(cat){
	$('#RandomBackstageContextLoader').toggle();
	$.get(BASE_URI+'user/backstage/callFuncShowRandomBackstage',{cat:cat},function(res){
		$('#RandomBackstageContextLoader').toggle();
		$('#backstagePhotoAsyncDiv').html(res);
	});
}

function callFuncSearchBackstage(){	
	$('#searchBackstageContextLoader').toggle();
	$.get(BASE_URI+'user/backstage/callFuncSearchBackstage',{keyword:$('#keyword').val()},function(res){
		$('#searchBackstageContextLoader').toggle();
		$('#backstagePhotoAsyncDiv').html(res);
	});
}

function callFuncShowMyBackstage(){
	$('#MyBackstageContextLoader').toggle();
	$.get(BASE_URI+'user/backstage/callFuncShowMyBackstage',{},function(res){
		$('#MyBackstageContextLoader').toggle();
		$('#backstagePhotoAsyncDiv').html(res);
	});
}

function callFuncShowAllCommentBackstagePhoto(id_photo,title){
	siteLoadingDialogOn();
	$.get(BASE_URI+'user/backstage/callFuncShowAllCommentBackstagePhoto',{id_photo:id_photo},function(res){
		$('#hiddenElement').html(res);
		$('#hiddenElement').dialog(
			{
				 width: 500,
				 height:300 ,
				 draggable: false,
				 resizable: false,
				 beforeClose: function(event, ui) { 
					siteLoadingDialogOff();
				 },
				 close: function(event, ui) { 
					siteLoadingDialogOff();
				},
				buttons:{
					"OK": function(event,ui){
						$('#hiddenElement').dialog('close');
					},
				},
				title: title
			}
		);
	});
}

function callFuncBuyThisBackstagePhoto(id_photo){
	siteLoadingDialogOn();
	$.get(BASE_URI+'user/backstage/callFuncBuyThisBackstagePhoto',{id_photo:id_photo},function(res){
		$('#hiddenElement').html(res);
		$('#hiddenElement').dialog(
			{
				 width: 350,
				 height:200 ,
				 draggable: false,
				 resizable: false,
				 beforeClose: function(event, ui) { 
					siteLoadingDialogOff();
				 },
				 close: function(event, ui) { 
					siteLoadingDialogOff();
				},
				buttons:{
				},
				title: 'Buy backstage photo'
			}
		);
	});
}

function callFuncSubmitBuyBackstagePhoto(id_photo){
	if($('#buyingBackstage').val() == '1'){
		return false;
	}
	$('#buyBackstageContextLoader').toggle();
	$('#buyingBackstage').attr('value','1');
	
	$.post(BASE_URI+'mod_io/backstage_func/submitBuyBackstagePhoto',{id_photo:id_photo},function(res){
		$('#buyBackstageContextLoader').toggle();
		if(res.result == 'ok'){
			jqcc.cometchat.sendMessage(res.id_user,res.CMCHATMSG);
			sysMessage(res.message, '$("#hiddenElement").dialog("close");reload()');
		}else{
			sysWarning(res.message);
		}
	},'json');
}

function callFuncEditMyBackstagePhoto(id_photo){
	siteLoadingDialogOn();
	$.get(BASE_URI+'user/backstage/callFuncEditMyBackstagePhoto',{id_photo:id_photo},function(res){
		$('#hiddenElement').html(res);
		$('#hiddenElement').dialog(
			{
				 width: 350,
				 height:250 ,
				 draggable: false,
				 resizable: false,
				 beforeClose: function(event, ui) { 
					siteLoadingDialogOff();
				 },
				 close: function(event, ui) { 
					siteLoadingDialogOff();
				},
				title: 'Edit backstage photo'
			}
		);
	});
}

function callFuncLoadWCUI_BACKSTAGEPHOTO(){
	$.get(BASE_URI+'user/backstage/callFuncLoadWebcamUI',{},function(res){
		siteLoadingDialogOn();
		$('#hiddenElement').html(res);
		
		$('#hiddenElement').dialog(
			{
				 width: 800,
				 height:450 ,
				 draggable: false,
				 resizable: false,
				 buttons:{
				 },
				close: function(event, ui) { 
					siteLoadingDialogOff();
				},
				title: 'Take a snapshot' 
			}
		);
		$('.ui-dialog').center();
	});
}

function callFuncSubmitSnapshotWebcam(){
	if(uploading == 1){
		return ;
	}
	uploading = 1;
	$('#WCSnapshotContextLoader').toggle();
	
	var obj = {};
	obj.title = $('#title').val();
	obj.image_name = $('#image_name').val();
	obj.price = $('#price').val();
	
	$.post(BASE_URI+'mod_io/backstage_func/callFuncSubmitSnapshotWebcam',obj,function(res){
		$('#WCSnapshotContextLoader').toggle();
		uploading =0;	
		if(res.result=='ok'){
			//sysMessage(res.message, "$('#hiddenElement').dialog('close')");
			//callFuncShowMyBackstage();
			callFuncShowUIPostToWall_BACKSTAGE();
		}else{
			sysWarning(res.message);
		}
		
	},'json');
}









function callFuncPostOnWall_BACKSTAGE(){
	$message = $('#message').val();
	$('#postonwallloaderContext').toggle();
	$.post(BASE_URI+'mod_io/backstage_func/postOnWall',{message:$message},function(res){
		$('#postonwallloaderContext').toggle();
		sysMessage(res.message,"$('#hiddenElement').dialog('close')");
	},'json');
}


function callFuncShowUIPostToWall_BACKSTAGE(){
	siteLoadingDialogOn();
	 
	if( SYS_JS_SOCIAL.facebook == 1 || SYS_JS_SOCIAL.twitter == 1){
		
		$.get(BASE_URI+'user/backstage/callFuncShowUIPostToWall',{},function(res){
			$('#hiddenElement').html(res);
			$('#hiddenElement').dialog(
				{
					 width: 550,
					 height:250 ,
					 draggable: false,
					 resizable: false,
					 beforeClose: function(event, ui) { 
					 },
					 close: function(event, ui) { 
						siteLoadingDialogOff();
					},
					buttons:{},
					title: 'Post on your wall' 
				}
			);
			//$('.ui-dialog').center();
			callFuncShowMyBackstage(); 
		});
	}else{
		$('#hiddenElement').html("You must connect on your facebook, twitter account firstly to post on wall.");
		$('#hiddenElement').dialog(
			{
				 width: 550,
				 height:200 ,
				 draggable: false,
				 resizable: false,
				 beforeClose: function(event, ui) { 
				 },
				 close: function(event, ui) { 
					siteLoadingDialogOff();
				},
				buttons:{
					"OK": function(event,ui){
							queryurl(BASE_URI+'user/connect');
						},
					 	
					"Cancel" : function (event, ui){
						$('#hiddenElement').dialog('close');
					}	 
				},
				title: 'Post on your wall' 
			}
		);
		callFuncShowMyBackstage(); 
	}	
}
