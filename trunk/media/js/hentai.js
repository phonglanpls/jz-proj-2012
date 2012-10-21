
function callFuncShowHentaiCategory(id_category){
	$('#HentaiVideoContextLoader_'+id_category).toggle();
	$.get(BASE_URI+'user/hentai/category',{category_id:id_category},function(res){
		$('#HentaiVideoContextLoader_'+id_category).toggle();
		$('#hentaiAsyncDiv').html(res);
	});
}

function callFuncShowVideoHentai(id_video){
	$('#videoHentaiEpisodeContextLoader').toggle();
	$.get(BASE_URI+'user/hentai/show_video_episode',{id_video:id_video},function(res){
		$('#videoHentaiEpisodeContextLoader').toggle();
		$('#videoHentaiAsyncDiv').html(res);
	});
}

function callFuncShowWatchingVideoUser(id_video,mode){
	$.get(BASE_URI+'user/hentai/show_watching_video',{id_video:id_video,mode:mode},function(res){
		$('#watchingUserAsyncDiv').html(res);
	});
}

function callFuncShowAllWatchingUser(id_video){
	$('#showAllWatchingContextLoader').toggle();
	$.get(BASE_URI+'user/hentai/show_watching_video',{id_video:id_video,mode:'all'},function(res){
		$('#watchingUserAsyncDiv').html(res);
	});
}

function callFuncDownloadVideo(id_video){
	siteLoadingDialogOn();
	$.get(BASE_URI+'user/hentai/downloadVideoUIDialog',{id_video:id_video},function(res){
		$('#hiddenElement').html(res);
		
		$('#hiddenElement').dialog(
			{
				 width: 350,
				 height:200 ,
				 draggable: false,
				 resizable: false,
				 beforeClose: function(event, ui) { 
				 },
				 close: function(event, ui) { 
					siteLoadingDialogOff();
					$('#hiddenElement').html('');
				 },
				buttons:{
					
				},
				dialogClass: "",
				title: 'Download Video' 
			}
		);
		
	});
}

function callFuncSubmitDownloadVideo(id_video){
	if(downloading == 1){
		return false;
	}
	downloading = 1;
	$('#downloadVideoContextLoader').toggle();
	
	$.post(BASE_URI+'mod_io/hentai_func/download_video',{id_video:id_video},function(res){
		$('#downloadVideoContextLoader').toggle();
		downloading = 0;
		if(res.result == 'ok'){
			//window.open(res.message, '_blank');
			//$('#hiddenElement').dialog('close');
			$('#wrapUI').html(res.message);
		}else{
			sysWarning(res.message);
		}
	},'json');
}



function callFuncRateHentaiVideo(id_video,rate_type){
	$score = $('#rate_score').val();
	if($score == 0){
		return ;
	}
	
	$('#rate-button').hide(); 
	$.get(BASE_URI+'user/hentai/callFuncRateHentaiVideo/'+id_video,{task:'rate',id_video:id_video,score:$score,rate_type:rate_type},function(res){
		$('#rateHentaiAsyncDiv').html(res);
	});
}


function callFuncpromptFacebookTwitterConnect(){
	sysMessage( 'You must connect to your Facebook or Twitter account firstly.' ,'queryurl("'+BASE_URI+'user/connect'+'")');
	
}


