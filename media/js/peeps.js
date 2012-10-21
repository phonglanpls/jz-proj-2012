
function callFuncShowPeeps(){
	$('#peepContextLoader').toggle();
	var obj = {};
	obj.search_type = $('#search_type').val();
	obj.sort_by = $('#sort_by').val();
	obj.id_user = $('#hidden_id_user').val();
	
	$.get(BASE_URI+'user/peeps/show',obj,function(res){
		$('#peepContextLoader').toggle();
		$('#peepAsyncDiv').html(res);
	});
}

function callFuncShowWhoRatedPicture(id_photo){
	siteLoadingDialogOn();
	$.get(BASE_URI+'user/peeps/callFuncShowWhoRatedPicture',{id_photo:id_photo},function(res){
		$('#hiddenElement').html(res);
		$('#hiddenElement').dialog(
			{
				 width: 500,
				 height:350 ,
				 draggable: false,
				 resizable: false,
				 beforeClose: function(event, ui) { 
				 },
				 close: function(event, ui) { 
					siteLoadingDialogOff();
				 },
				buttons:{
					"OK": function(event,ui){
						$('#hiddenElement').dialog("close");
						siteLoadingDialogOff();
					},
				},
				title: 'Who rated' 
			}
		);
	});
}