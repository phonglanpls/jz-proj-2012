function callFuncToggleBlockStatus(id_user){
	$('#mapBlockContextLoader_'+id_user).toggle();
	$.post(BASE_URI+'user/block/toggleBlockStatusMapAccess',{id_user:id_user},function(res){
		$('#mapBlockContextLoader_'+id_user).toggle();
		$('#status_'+id_user).text(res);
	});
}

function callFuncShowAccessMapBlock(){
	$('#accessMapContextLoader').toggle();
	$.get(BASE_URI+'user/block/callFuncShowAccessMapBlock',{},function(res){
		$('#accessMapContextLoader').toggle();
		$('#blockAsyncDiv').html(res);
	});
}

function callFuncShowChatBlock(){
	$('#chatBlockContextLoader').toggle();
	$.get(BASE_URI+'user/block/callFuncShowChatBlock',{},function(res){
		$('#chatBlockContextLoader').toggle();
		$('#blockAsyncDiv').html(res);
	});
}

function callFuncDeleteChatBlock(id_user){
	$('#id_'+id_user).fadeOut();
	$.post(BASE_URI+'user/block/callFuncDeleteChatBlock',{id_user:id_user},function(res){
	});
}