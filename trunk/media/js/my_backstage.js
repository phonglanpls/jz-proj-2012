function callFuncLoadUploadMyBackstagePhoto(){
	siteLoadingDialogOn();
	$.get(BASE_URI+'user/backstage/callFuncLoadUploadMyBackstagePhoto',{},function(res){
		$('#hiddenElement').html(res);
		$('#hiddenElement').dialog(
			{
				 width: 450,
				 height:250 ,
				 draggable: false,
				 resizable: false,
				 beforeClose: function(event, ui) { 
					siteLoadingDialogOff();
				 },
				 close: function(event, ui) { 
					siteLoadingDialogOff();
				},
				buttons:{},
				title: 'Upload my backstage photo' 
			}
		);
	});
}


function callFuncDeleteMyBackstagePhoto(id_photo){
	$('#MyBackstageContextLoader').toggle();
	$.get(BASE_URI+'user/backstage/callFuncShowMyBackstage',{task:'del',id:id_photo},function(res){
		$('#MyBackstageContextLoader').toggle();
		$('#backstagePhotoAsyncDiv').html(res);
	});
}

function callFuncRateObj(id_photo){
	$score = $('#rate_score').val();
	if($score == 0){
		return ;
	}
	
	siteLoadingDialogOn();
	$.get(BASE_URI+'user/backstage/show_my_backstage/'+id_photo+'/?is_async=1',{task:'rate',id_photo:id_photo,score:$score},function(res){
		siteLoadingDialogOff();
		$('#backstagePhotoAsyncDiv').html(res);
	});
}

function callFuncShowAllUsersViewedBackstagePhoto(id_photo){
    siteLoadingDialogOn();
	$.get(BASE_URI+'user/backstage/callFuncShowAllUsersViewedBackstagePhoto',{id_photo:id_photo},function(res){
		$('#hiddenElement').html(res);
		$('#hiddenElement').dialog(
			{
				 width: 450,
				 height:250 ,
				 draggable: false,
				 resizable: false,
				 beforeClose: function(event, ui) { 
					siteLoadingDialogOff();
				 },
				 close: function(event, ui) { 
					siteLoadingDialogOff();
				},
				buttons:{},
				title: 'Who viewed this photo' 
			}
		);
	});
}




$(function(){
	$('#cometchat_trayicon_backstage').bind('click',function(){callFuncLoadUploadMyBackstagePhoto();});
});