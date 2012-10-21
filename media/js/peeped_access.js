
function reloadUserInfoAsync(){
	$username = $('#username_userinfo').val();
	
	$.get(BASE_URI+$username+'/reload_userInfo',{},function(res){
		$('#userInfoAsyncDiv').html(res);
	});
}

function callFuncBuyPeepAccess(id_user){
	siteLoadingDialogOn();
	$.get(BASE_URI+'user/peeped_access/callFuncBuyPeepAccess',{id_user:id_user},function(res){
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
				title: 'Who Peep Me' 
			}
		);
		
	});
}

function callFuncSubmitBuyPeepedAccess(days,id_user){
	if($('#actionFlag').val() == '1'){
		return false;
	}
	$('#actionFlag').attr('value','1');
	
	$context = $('#context').val();
	
	var obj = {};
	obj.days = days;
	obj.id_user = id_user;
	
	$('#buyPeepedAccessContextLoader').toggle();
	$.post(BASE_URI+'mod_io/peeped_access_func/submitBuyPeepedAccess',obj,function(res){
		if(res.result != 'ok'){
			sysWarning(res.message);
		}else{
			$('#hiddenElement').dialog('close');
			if($context == 'CMCHAT'){
				callFuncShowPeepedAccess(obj.id_user);
				jqcc.cometchat.sendMessage(id_user,res.CMCHATMSG);
			}else{
				sysMessage(res.message,'reload()');
				//reloadUserInfoAsync();
			}
		}
		$('#actionFlag').attr('value','0');
		$('#buyPeepedAccessContextLoader').toggle();
	},'json');
}

function callFuncShowPeepedAccess(id_user){
	siteLoadingDialogOn();
	$.get(BASE_URI+'user/peeped_access/callFuncShowPeepedAccess',{id_user:id_user},function(res){
		$('#hiddenElement').html(res);
		
		$('#hiddenElement').dialog(
			{
				 width: 850,
				 height:600 ,
				 draggable: false,
				 resizable: false,
				 beforeClose: function(event, ui) { 
				 },
				 close: function(event, ui) { 
					siteLoadingDialogOff();
					$('#hiddenElement').html('');
					reloadRightBarAsync();
				 },
				buttons:{
					"OK":function(event,ui){
						$('#hiddenElement').dialog('close');
					},
				},
				dialogClass: "",
				title: 'Who Peep Me' 
			}
		);
		$('.ui-dialog').center();
	});
}

function callFuncBuyPeepAccess_CMC(id_user){
	siteLoadingDialogOn();
	$.get(BASE_URI+'user/peeped_access/callFuncBuyPeepAccess',{id_user:id_user,context:'CMCHAT'},function(res){
		$('#hiddenElement').html(res);
		closeCMCpopupWD();
		
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
				title: 'Who Peep Me' 
			}
		);
		
	});
}





