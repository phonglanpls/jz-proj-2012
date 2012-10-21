function callFuncShowFlirtsReceived(){
	$('#flirtReceiveContextLoader').toggle();
	$.get(BASE_URI+'user/flirts/callFuncShowFlirtsReceived',{},function(res){
		$('#flirtReceiveContextLoader').toggle();
		$('#flirtAsyncDiv').html(res);
	});
}

function callFuncFlirtsGiven(){
	$('#flirtGivenContextLoader').toggle();
	$.get(BASE_URI+'user/flirts/flirtGivenContextLoader',{},function(res){
		$('#flirtGivenContextLoader').toggle();
		$('#flirtAsyncDiv').html(res);
	});
}

function callFuncDeleteFlirt(id_flirt){
	sysConfirm("Are you sure want to delete this?",'deleteFlirt('+id_flirt+')');
}

function deleteFlirt(id_flirt){
	$("#id_"+id_flirt).fadeOut();
	$.post(BASE_URI+'mod_io/flirts_func/deleteFlirt',{id_flirt:id_flirt});
}

function callFuncSendFlirt(){
	siteLoadingDialogOn();
	$.get(BASE_URI+'user/flirts/loadSendFlirtUI',{},function(res){
		$('#dialogElement').html(res);
		$('#dialogElement').dialog(
			{
				 width: 550,
				 height:350 ,
				 draggable: false,
				 resizable: false,
				 beforeClose: function(event, ui) { 
				 },
				 close: function(event, ui) { 
					siteLoadingDialogOff();
				 },
				buttons:{
				},
				dialogClass: "",
				title: 'Send flirt' 
			}
		);
	});
}