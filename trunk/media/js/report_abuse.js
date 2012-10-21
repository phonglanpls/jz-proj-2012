
function callFuncReportAbuse(id_user){
	siteLoadingDialogOn();
	$.get(BASE_URI+'user/friends_func/show_report_abuse_dialog',{id_user:id_user},function(res){
		$('#hiddenElement').html(res);
		$('#hiddenElement').dialog(
			{
				 width: 550,
				 height:300 ,
				 draggable: false,
				 resizable: false,
				 beforeClose: function(event, ui) { 
				 },
				 close: function(event, ui) { 
					siteLoadingDialogOff();
				 },
				buttons:{},
				title: 'Report abuse' 
			}
		);
		//$('.ui-dialog').center();
	});
}