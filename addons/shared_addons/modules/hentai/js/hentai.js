
function callFuncShowHentaiCategory(id_category){
	$('#HentaiVideoContextLoader_'+id_category).toggle();
	$.get(BASE_URI+'hentai/category/category',{category_id:id_category},function(res){
		$('#HentaiVideoContextLoader_'+id_category).toggle();
		$('#hentaiAsyncDiv').html(res);
	});
}

function callFuncShowVideoHentai(id_video){
	$('#videoHentaiEpisodeContextLoader').toggle();
	$.get(BASE_URI+'hentai/category/show_video_episode',{id_video:id_video},function(res){
		$('#videoHentaiEpisodeContextLoader').toggle();
		$('#videoHentaiAsyncDiv').html(res);
	});
}

function callFuncShowWatchingVideoUser(id_video,mode){
	$.get(BASE_URI+'hentai/category/show_watching_video',{id_video:id_video,mode:mode},function(res){
		$('#watchingUserAsyncDiv').html(res);
	});
}

function callFuncShowAllWatchingUser(id_video){
	$('#showAllWatchingContextLoader').toggle();
	$.get(BASE_URI+'hentai/category/show_watching_video',{id_video:id_video,mode:'all'},function(res){
		$('#watchingUserAsyncDiv').html(res);
	});
}


function callFuncpromptFacebookTwitterConnect(){
	//sysMessage( 'You must login firstly.' ,'queryurl("'+BASE_URI+'member'+'")');
	/*
	siteLoadingDialogOn();
	$('#dialogElement').html('You must login firstly.');
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
					queryurl(BASE_URI+'member');
				},
			},
			dialogClass: "",
			title: 'Message' ,
			zIndex:99999
		}
	);
	*/
	
	$('#divUIDialog').dialog(
	{
		 width: 550,
		 height:200 ,
		 draggable: false,
		 resizable: false,
		 beforeClose: function(event, ui) { 
		 },
		 close: function(event, ui) { 
			siteLoadingDialogOff();
			//$('#divUIDialog').html('');
		 },
		buttons:{
		},
		dialogClass: "",
		title: 'Warning' 
	}
	);
}


