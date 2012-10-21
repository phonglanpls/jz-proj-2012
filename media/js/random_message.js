function callFuncSendRandomMessage(){
	if(sending == 1){
		return false;
	}
	sending = 1;
	$('#sendRandomMessageContextLoader').toggle();
	
	var obj = {};
	obj.gender = $('#gender').val();
	obj.type = $('#type').val();
	obj.message = $('#message_rd').val();
	
	if(!obj.message){
		$('#sendRandomMessageContextLoader').hide();
		sending = 0;
		return false;
	}
	
	$.post(BASE_URI+'mod_io/random_message_func/sendMessage',obj,function(res){
		sending = 0;
		$('#sendRandomMessageContextLoader').toggle();
		if(res.result == 'ok'){
			sysMessage(res.message, 'callFuncReloadUI();');
		}else{
			sysWarning(res.message);
		}
	},'json');
}

function callFuncLoadHistory(){
	$.get(BASE_URI+'user/random_message/showHistory',{},function(res){
		$('#randomMessageAsyncDiv').html(res);
	});
}

function callFuncReloadUI(){
	$.get(BASE_URI+'user/random_message/callFuncReloadUI',{},function(res){
		$('#randomMessageUIAsync').html(res);
	});
}