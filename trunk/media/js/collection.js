
function callFuncDeleteCollectionPhoto(id_coll){
	$('#photoCollectionContextLoader').toggle();
	$.get(BASE_URI+'user/collection/loadPhotoCollection',{task:'del',id:id_coll},function(res){
		$('#photoCollectionContextLoader').toggle();
		$('#photoCollectionAsyncDiv').html(res);
	});
}

function callFuncDeleteMyPhoto(id_photo){
	$('#myPhotoContextLoader').toggle();
	$.get(BASE_URI+'user/collection/loadMyPhoto',{task:'del',id:id_photo},function(res){
		$('#myPhotoContextLoader').toggle();
		$('#photoCollectionAsyncDiv').html(res);
	});
}

function callFuncShowPhotoCollection(){
	$('#photoCollectionContextLoader').toggle();
	$.get(BASE_URI+'user/collection/loadPhotoCollection',{},function(res){
		$('#photoCollectionContextLoader').toggle();
		$('#photoCollectionAsyncDiv').html(res);
	});
}

function callFuncShowMyPhoto(){
	$('#myPhotoContextLoader').toggle();
	$.get(BASE_URI+'user/collection/loadMyPhoto',{},function(res){
		$('#myPhotoContextLoader').toggle();
		$('#photoCollectionAsyncDiv').html(res);
	});
}

function callFuncReloadMyProfileSection(){
	$.get(BASE_URI+'user/collection/callFuncReloadMyProfileSection',{is_async:'1'},function(res){
		$('#myProfileAsync').html(res);
	});
}

function callFuncLoadUploadMyPhoto(){
	siteLoadingDialogOn();
	$.get(BASE_URI+'user/collection/callFuncLoadUploadMyPhoto',{},function(res){
		$('#hiddenElement').html(res);
		$('#hiddenElement').dialog(
			{
				 width: 450,
				 height:200 ,
				 draggable: false,
				 resizable: false,
				 beforeClose: function(event, ui) { 
					siteLoadingDialogOff();
				 },
				 close: function(event, ui) { 
					siteLoadingDialogOff();
				},
				buttons:{},
				title: 'Upload my photo' 
			}
		);
	});
}

function callFuncShowActionDialogMyPhoto(id_photo){
	siteLoadingDialogOn();
	$.get(BASE_URI+'user/collection/callFuncLoadActionMyPhoto',{id_gallery:id_photo},function(res){
		$('#hiddenElement').html(res);
		$('#hiddenElement').dialog(
			{
				 width: 730,
				 height:550 ,
				 draggable: false,
				 resizable: false,
				 beforeClose: function(event, ui) { 
					siteLoadingDialogOff();
				 },
				 close: function(event, ui) { 
					siteLoadingDialogOff();
					callFuncShowMyPhoto();
				},
				buttons:{},
				title: 'Action' 
			}
		);
	});
}

function callFuncRateObj_myCollectionContext(id_photo,rate_type){
	$score = $('#rate_score').val();
	if($score == 0){
		return ;
	}
	
	siteLoadingDialogOn();
	$.get(BASE_URI+'user/photos/backstage/'+id_photo+'/?is_async=1',{task:'rate',id_photo:id_photo,score:$score,rate_type:rate_type},function(res){
		siteLoadingDialogOff();
		$('#photoCollectionAsyncDiv').html(res);
	});
}

function callFuncRateObj_myPhotoContext(id_photo,rate_type){
	$score = $('#rate_score').val();
	if($score == 0){
		return ;
	}
	
	siteLoadingDialogOn();
	$.get(BASE_URI+'user/photos/'+id_photo+'/?is_async=1',{task:'rate',id_photo:id_photo,score:$score,rate_type:rate_type},function(res){
		siteLoadingDialogOff();
		$('#photoCollectionAsyncDiv').html(res);
	});
}

function callFuncRateObj_PUBLICPHOTO(id_photo,rate_type){
	$score = $('#rate_score').val();
	if($score == 0){
		return ;
	}
	$('#rate-button').hide();
	$.get(BASE_URI+'user/photos/load_rating',{task:'rate',id_photo:id_photo,score:$score,rate_type:rate_type},function(res){
		$('#publicPhotoRatingDiv').html(res);
	});
}

function callFuncRateObj_BACKSTAGEPHOTO(id_photo,rate_type){
	$score = $('#rate_score').val();
	if($score == 0){
		return ;
	}
	$('#rate-button').hide();
	$.get(BASE_URI+'user/photos/load_rating_backstage',{task:'rate',id_photo:id_photo,score:$score,rate_type:rate_type},function(res){
		$('#backstagePhotoRatingDiv').html(res);
	});
}

function callFuncLoadWCUI_PUBLICPHOTO(){
	$.get(BASE_URI+'user/collection/callFuncLoadWebcamUI',{},function(res){
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
	
	$.post(BASE_URI+'mod_io/collection_func/callFuncSubmitSnapshotWebcam',obj,function(res){
		$('#WCSnapshotContextLoader').toggle();
		sharing =0;	
		if(res.result=='ok'){
			$('#hiddenElement').dialog('close');
			sysMessage(res.message);
			callFuncShowMyPhoto();
		}
		
	},'json');
}



