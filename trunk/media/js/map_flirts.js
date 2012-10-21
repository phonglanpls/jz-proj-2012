function callFuncSearchMapFlirts(){
	if(search_context == 1){
		return false;
	}
	search_context == 1;
	
	$('#searchMapFlirtsContextLoader').toggle();
	var obj = {};
	
	obj.gen = $('#gen').val();
	obj.agefrom = $('#agefrom').val();
	obj.ageto = $('#ageto').val();
	obj.distance = $('#distance').val();
	obj.country_name = $('#country_name').val();
	obj.status = $('#status').val();
	obj.mapvalue = $('#mapvalue').val();
	obj.photo = $('#photo').val();
	obj.search_flag = 1;
	
	$.get(BASE_URI+'user/map_flirts/callFuncSearchMapFlirts',obj,function(res){
		$('#searchMapFlirtsContextLoader').toggle();
		$('#mapFlirtAsyncDiv').html(res);
		search_context == 0;
	});
}

$(document).ready(function(){
	$('#mymapvalue').live('change',function(e){
		var mapvalue = parseInt( $(this).val() );
		if(mapvalue < 1){
			e.preventDefault();
			sysWarning("Please choose a value");
			return;
		}
		$.post(BASE_URI+'mod_io/map_flirts_func/submitChangeMapValue',{mapvalue:mapvalue},function(res){
		});
	});
	
	$('.onSelectUser').live('click',function(){
		var id_user_arr = getMultiCheckbox('map_flirt_user');
		var total = 0;
		for(var i=0;i<id_user_arr.length;i++){
			total += parseInt($('#user_id_'+id_user_arr[i]).attr('rel'));
		}
		$('#total_cash').html(total+'J$');
	});
});

function callFuncChangeMapValue(mapvalue){
	if(mapvalue < 1){
		sysWarning("Please choose a value");
	}
	$.post(BASE_URI+'mod_io/map_flirts_func/submitChangeMapValue',{mapvalue:mapvalue},function(res){
	});
}

function callFuncAccessMapFlirts(){
	var id_user_arr = getMultiCheckbox('map_flirt_user');
	var id_user_str = id_user_arr.join(',');
	
	$('#accessMapFlirtsContextLoader').toggle();
	$.post(BASE_URI+'mod_io/map_flirts_func/submitAccessMapFlirts',{id_user_str:id_user_str},function(res){
		if(res.result != 'ok'){
			//sysWarning(res.message);
            callFuncAddCashInfo(id_user_arr[0]);
		}else{
			callFuncShowGoogleMapFlirts();
		}
		$('#accessMapFlirtsContextLoader').toggle();
	},'json');
}

function callFuncAddCashInfo(id_user){
    siteLoadingDialogOn();
	$.get(BASE_URI+'user/map_flirts/callFuncShowExtendAccessMapDialog',{days:1,id_user:id_user,context:'ADDCASH'},function(res){
		$('#hiddenElement').html(res);
		closeCMCpopupWD();
		
		siteLoadingDialogOn();
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
				title: 'Buy Access Map Flirt' 
			}
		);
	});
}

function callFuncShowGoogleMapFlirts(){
	siteLoadingDialogOn();
	$.get(BASE_URI+'user/map_flirts/callFuncShowGoogleMapFlirts',{},function(res){
		$('#hiddenElement').html(res);
		
		$('#hiddenElement').dialog(
			{
				 width: 850,
				 height:550 ,
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
				title: 'Access Map Flirts' 
			}
		);
		
		$("#gmap").gMap(options);
	});
}

function callFuncShowMapFlirts(){
	$('#mapFlirtsContextLoader').toggle();
	$.get(BASE_URI+'user/map_flirts/callFuncShowMapFlirts',{},function(res){
		$('#mapFlirtsContextLoader').toggle();
		$('#flirtAsyncDiv').html(res);
	});
}

function callFuncShowBoughtHistory(){
	$('#flirtBoughtContextLoader').toggle();
	$.get(BASE_URI+'user/map_flirts/callFuncShowHistory',{},function(res){
		$('#flirtBoughtContextLoader').toggle();
		$('#flirtAsyncDiv').html(res);
	});
}

function callFuncShowHistory_YOUBOUGHTOTHER(){
	$('#historyYOUBOUGHTOTHERcontextLoader').toggle();
	$.get(BASE_URI+'user/map_flirts/callFuncShowHistory_YOUBOUGHTOTHER',{},function(res){
		$('#historyYOUBOUGHTOTHERcontextLoader').toggle();
		$('#historyAsyncDiv').html(res);
	});
}

function callFuncShowHistory_OTHERBOUGHTYOU(){
	$('#historyOTHERBOUGHTYOUcontextLoader').toggle();
	$.get(BASE_URI+'user/map_flirts/callFuncShowHistory_OTHERBOUGHTYOU',{},function(res){
		$('#historyOTHERBOUGHTYOUcontextLoader').toggle();
		$('#historyAsyncDiv').html(res);
	});
}

function callFuncExtendAccessMap(value,id_user){
	if(value<1){
		return false;
	}
	
	$('#extendDayscontextLoader_'+id_user).toggle();
	
	$.get(BASE_URI+'user/map_flirts/callFuncShowExtendAccessMapDialog',{days:value,id_user:id_user},function(res){
		$('#extendDayscontextLoader_'+id_user).toggle();
		$('#hiddenElement').html(res);
		siteLoadingDialogOn();
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
				title: 'Buy/Extend Access Map' 
			}
		);
	});
}

function callFuncSubmitExtendAccessMapFlirts(days,id_user){
	if($('#actionFlag').val() == '1'){
		return false;
	}
	$('#actionFlag').attr('value','1');
	
	$context = $('#context').val();
	
	var obj = {};
	obj.days = days;
	obj.id_user = id_user;
	obj.context = $context
	
	$('#extendAccessMapContextLoader').toggle();
	$.post(BASE_URI+'mod_io/map_flirts_func/submitExtendAccessMapFlirts',obj,function(res){
		if(res.result != 'ok'){
			sysWarning(res.message);
		}else{
			$('#hiddenElement').dialog('close');
			if($context != 'CMCHAT'){
				callFuncShowHistory_YOUBOUGHTOTHER();
				sysMessage(res.message);
			}else{
				jqcc.cometchat.sendMessage(id_user,res.CMCHATMSG);
				sysMessage(res.message,'callFuncShowAccessMap_SELLER('+id_user+')');
			}
		}
		$('#extendAccessMapContextLoader').toggle();
	},'json');
}

function callFuncShowAccessMap_SELLER(id_user){
	siteLoadingDialogOn();
	$.get(BASE_URI+'user/map_flirts/callFuncShowAccessMap_SELLER',{id_user:id_user},function(res){
		$('#hiddenElement').html(res);
		
		$('#hiddenElement').dialog(
			{
				 width: 850,
				 height:550 ,
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
				title: 'Access Map Flirts' 
			}
		);
		
		$("#gmap").gMap(options);
	});
}


function callFuncBuyAccessMapFlirtCMChat(id_user){
	siteLoadingDialogOn();
	$.get(BASE_URI+'user/map_flirts/callFuncShowExtendAccessMapDialog',{days:1,id_user:id_user,context:'CMCHAT'},function(res){
		$('#hiddenElement').html(res);
		closeCMCpopupWD();
		
		siteLoadingDialogOn();
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
				title: 'Buy Access Map Flirt' 
			}
		);
	});
}









