
function callFuncShowDialogChangeFilterWall_MYPROFILE(){
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
					$.get(BASE_URI+'user/wall_func/loadAsyncFilterSplitPartial',{},function(res){
						$('#asyncSectionFilterBox').html(res);
					});
				 },
				 close: function(event, ui) { 
					siteLoadingDialogOff();
				},
				buttons:{},
				title: 'Change filter options' 
			}
		);
	});
}


function callFuncShareStatus_MYPROFILE(){
	$('#shareStatusContextLoader').toggle();
	var status = $('#shareTxtStatus').val();
	$.post(BASE_URI+'mod_io/wall_submit_async/submitShareStatus',{status:status},function(res){
		$('#shareStatusContextLoader').toggle();
		if(res.result=='OK'){
			$('#shareTxtStatus').val('');
			
			$.get(BASE_URI+'user/wall_func/loadAsyncWallFeed',{segment:'my_chatter'},function(res1){
				$('#asyncSectionFeed').html(res1);
			});
		}
		
	},'json');	
}

function callFuncGetMorePost_MYPROFILE(){
	$currentPage = cur_page;
	cur_page += 1;
	
	var obj = {};
	obj.segment = 'my_chatter';
	
	$('#morePostContextLoader').toggle();
	
	$.get(BASE_URI+'user/my_profile/myChatterAsync/?per_page='+$currentPage,obj,function(res1){
		$id = $('.morePostItem').attr('id');
		
		$('#'+$id ).html(res1);
		$('#morePostContextLoader').toggle();
		$('#'+$id).removeClass('morePostItem').addClass('addedPostItem');
	});
}