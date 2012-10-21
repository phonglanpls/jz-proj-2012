
function callFuncShowDialogChangeFilterWall(){
	siteLoadingDialogOn();
	$.get(BASE_URI+'user/wall_func/callFuncShowDialogChangeFilterWall',{},function(res){
		$('#hiddenElement').html(res);
		$('#hiddenElement').dialog(
			{
				 width: 550,
				 height:350 ,
				 draggable: false,
				 resizable: false,
				 beforeClose: function(event, ui) { 
					$('#greyDiv').addClass('hidden');
                	var uri = $('#tab-menu .current').attr('href');
					var segmentArray = uri.split('/');
					var lastsegment = segmentArray[segmentArray.length-1];
					$.get(BASE_URI+'user/wall_func/loadAsyncFilterSplitPartial',{segment:lastsegment},function(res){
						$('#asyncSectionFilterBox').html(res);
						$.get(BASE_URI+'user/wall_func/loadAsyncWallFeed',{segment:lastsegment},function(res1){
							$('#asyncSectionFeed').html(res1);
						});
					});
				 },
				 close: function(event, ui) { 
					siteLoadingDialogOff();
				},
				buttons:{},
				title: 'Change filter options' 
			}
		);
		//$('.ui-dialog').center();
	});
}

function toggleLikeContext(id_wall){
	$('#likeContextLoader_'+id_wall).toggle();
	$.get(BASE_URI+'mod_io/wall_async/toggleLikeContext',{id_wall:id_wall},function(response){
		$('#likeContextLoader_'+id_wall).toggle();
		if(response.res == 'OK'){
			$('#likeContext_'+id_wall).text(response.context);
			$('#likeContextFunc_'+id_wall).text(response.contextme);
		}
	},'json');
}

function callFuncShowCommentBox(id_wall){
	$("#wrapCommentDiv_"+id_wall).toggle();	
}

function callFuncShowAllComments(id_wall){
	$('#commentContextLoader_'+id_wall).toggle();
	$.get(BASE_URI+'user/wall_func/loadAsyncCommentFeed',{id_wall:id_wall},function(res){
		$('#commentContextLoader_'+id_wall).toggle();
		$('#commentSectionAsyncDiv_'+id_wall).html(res);
	});
}

function callFuncShareCommentFeed(id_wall){
	$('#shareContextLoader_'+id_wall).toggle();
	var commentText = $('#my_comment_'+id_wall).val();
	var contextcmt = $('#contextcm_'+id_wall).val();
	if(contextcmt == 'default'){
		contextcmt = 'addnew';
	}
	if(commentText.length == 0){
		$('#shareContextLoader_'+id_wall).toggle();
		return;
	}else{
		$.get(BASE_URI+'mod_io/wall_submit_async/submitCommentWall',{id_wall:id_wall, comment:commentText, contextcmt:contextcmt},function(res){
			$('#shareContextLoader_'+id_wall).toggle();
			$('#commentSectionAsyncDiv_'+id_wall).html(res).removeClass('hidden');
			$('#my_comment_'+id_wall).val('');
			$numberComment = parseInt( $('#commentCountNumber_'+id_wall).text() ) + 1;
			$('#commentCountNumber_'+id_wall).text($numberComment);
		});
	}
}

function callFuncDeleteComment(id_wall,master_id){		
	$.post(BASE_URI+'mod_io/wall_async/deleteComment',{id_wall:id_wall},function(res){
		if(res.result=='OK'){
			$('#articleDivId_'+id_wall).fadeOut();
			$numberComment = parseInt( $('#commentCountNumber_'+master_id).text() ) - 1;
			$('#commentCountNumber_'+master_id).text($numberComment);
		}
	},'json');	
}

function callFuncDeleteMyThreadFeed(id_wall){
	siteLoadingDialogOn();
	$('#hiddenElement').html("Are you sure you want to delete this?");
	$('#hiddenElement').dialog(
		{
			 width: 550,
			 height:150 ,
			 draggable: false,
			 resizable: false,
			 buttons:{
				"Delete":function(){
					$.post(BASE_URI+'mod_io/wall_async/deleteFeedWall',{id_wall:id_wall},function(res){
							if(res.result=='OK'){
								$('#articleID_'+id_wall).fadeOut();
							}
							$('#hiddenElement').dialog("close");
							siteLoadingDialogOff();
						},'json');	
				},
				"Cancel":function(){
					$(this).dialog("close");
					siteLoadingDialogOff();
				}
			 },
			close: function(event, ui) { 
				siteLoadingDialogOff();
			},
			title: 'Delete' 
		}
	);
	//$('.ui-dialog').center();
}

function callFuncShareStatus(segment){
	$('#shareStatusContextLoader').toggle();
	var status = $('#shareTxtStatus').val();
	$.post(BASE_URI+'mod_io/wall_submit_async/submitShareStatus',{status:status},function(res){
		$('#shareStatusContextLoader').toggle();
		if(res.result=='OK'){
			$('#shareTxtStatus').val('');
			
			if(segment){
				var lastsegment = segment;
			}else{
				var uri = $('#tab-menu .current').attr('href');
				var segmentArray = uri.split('/');
				var lastsegment = segmentArray[segmentArray.length-1];
			}
			
			$.get(BASE_URI+'user/wall_func/loadAsyncWallFeed',{segment:lastsegment},function(res1){
				$('#asyncSectionFeed').html(res1);
			});
		}
		
	},'json');	
}

function callFuncChangeFilter(value,mode){
	var obj = {};
	obj.task = 'qedit';
	eval("obj."+mode+"='"+value+"';");
	
	var uri = $('#tab-menu .current').attr('href');
	var segmentArray = uri.split('/');
	var lastsegment = segmentArray[segmentArray.length-1];
	
	obj.segment = lastsegment;
	
	$('#changeFilterContextLoader').toggle();
	
	$.get(BASE_URI+'user/wall_func/loadAsyncWallFeed',obj,function(res1){
		$('#asyncSectionFeed').html(res1);
		$('#changeFilterContextLoader').toggle();
	});
	
}

function callFuncGetMorePost(){
	$currentPage = cur_page;
	cur_page += 1;
	
	var uri = $('#tab-menu .current').attr('href');
	var segmentArray = uri.split('/');
	var lastsegment = segmentArray[segmentArray.length-1];
	var obj = {};
	obj.segment = lastsegment;
	
	$('#morePostContextLoader').toggle();
	
	$.get(BASE_URI+'user/wall_func/loadAsyncWallFeed/?per_page='+$currentPage,obj,function(res1){
		$id = $('.morePostItem').attr('id');
		
		$('#'+$id ).html(res1);
		$('#morePostContextLoader').toggle();
		$('#'+$id).removeClass('morePostItem').addClass('addedPostItem');
	});
	
}

function searchKeyPress(e,wall_id){
	if (typeof e == 'undefined' && window.event) { e = window.event; }
	/*
	if (e.keyCode == 13)
	{
		callFuncShareCommentFeed(wall_id);
	}
	*/
	
	if (e.keyCode == 13) {
        if (e.shiftKey) {
		 
            $(this).val(function(i,val){
				return val + "\n";
			});
			
			return false;
        }else{
			callFuncShareCommentFeed(wall_id);
		}
        
    }
}

function callFuncShowSharePhotoFeature(){
	$('#shareStatusControllerContext').hide();
	$('#sharePhotoControllerContext').show();
}

function callFuncShowShareStatusFeature(){
	$('#shareStatusControllerContext').show();
	$('#sharePhotoControllerContext').hide();
}

function callFuncReloadWallSection(){
	var force_uri = $('#force_uri').val();
	
	if(force_uri){
		var lastsegment = force_uri;
	}else{
		var uri = $('#tab-menu .current').attr('href');
		var segmentArray = uri.split('/');
		var lastsegment = segmentArray[segmentArray.length-1];
	}
	$.get(BASE_URI+'user/wall_func/loadAsyncWallFeed',{segment:lastsegment},function(res1){
		$('#asyncSectionFeed').html(res1);
		callFuncReloadShareSection();
	});
}

function callFuncReloadShareSection(){
	$.get(BASE_URI+'user/wall_func/callFuncReloadShareSection',{},function(res){
		$('#asyncSectionShareBox').html(res);
	});
}

function callFuncShowWebcamSnapshot(){
	siteLoadingDialogOn();
	$.get(BASE_URI+'user/wall_func/callFuncShowWebcamSnapshot',{},function(res){
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
	});
}

function callFuncShareSnapshotWebcam(){
	if(sharing == 1){
		return ;
	}
	sharing = 1;
	$('#shareWCSnapshotContextLoader').toggle();
	
	var obj = {};
	obj.status = $('#shareTxtWC').val();
	obj.image_name = $('#image_name').val();
	
	$.post(BASE_URI+'mod_io/wall_submit_async/submitShareStatusSnapshotWC',obj,function(res){
		$('#shareWCSnapshotContextLoader').toggle();
		sharing =0;	
		if(res.result=='ok'){
			$('#hiddenElement').dialog('close');
			sysMessage(res.message);
			callFuncReloadWallSection();
		}
		
	},'json');	
}