
function callFuncTrialPay_addCampaign($param,$context,$param1,$param2,$param3){
    siteLoadingDialogOn();
	resetContext($context,$param1,$param2,$param3);
    
    $frame = '<iframe width="760" height="1000" scrolling="auto" frameborder="0" style="border: 1px none white;" src="'+'https://www.trialpay.com/dispatch/'+$param+'" ></iframe>';
    
    $('#hiddenElement').dialog('close');
	$('#hiddenElement').html($frame);
	$('#hiddenElement').dialog(
		{
			 width: 780,
			 height:600 ,
			 draggable: true,
			 resizable: true,
			 beforeClose: function(event, ui) { 
				siteLoadingDialogOff();
			 },
			 close: function(event, ui) { 
				siteLoadingDialogOff();
			},
			buttons:{
			},
			title: 'Add J$'
		}
	);
     
}

function resetContext($context,$param1,$param2,$param3){
    sessionStorage.contextACTION = '';
    sessionStorage.context_param1 = 0;
    sessionStorage.context_param2 = 0;
    sessionStorage.context_param3 = 0;
    if($context){
        sessionStorage.contextACTION = $context;
        sessionStorage.context_param1 = $param1;
        sessionStorage.context_param2 = $param2;
        sessionStorage.context_param3 = $param3;
    }
}

function reCallPreviousDialog(){
    $param1 = parseInt(sessionStorage.context_param1);    
    if(sessionStorage.contextACTION && $param1 > 0){
        if(sessionStorage.contextACTION == 'DOWNLOAD'){
            callFuncDownloadVideo(parseInt(sessionStorage.context_param1));
        }
        if(sessionStorage.contextACTION == 'BACKSTAGE'){
            callFuncBuyThisBackstagePhoto(parseInt(sessionStorage.context_param1));
        }
        
        //if(sessionStorage.contextACTION == 'MAPFLIRTS'){
        //    callFuncBuyAccessMapFlirtCMChat(parseInt(sessionStorage.context_param1));
        //}
        if(sessionStorage.contextACTION == 'PETBUY'){
            callFuncAddThisPet(parseInt(sessionStorage.context_param1));
        }
        if(sessionStorage.contextACTION == 'PETLOCK'){
            callFuncAddThisPet(parseInt(sessionStorage.context_param1),parseInt(sessionStorage.context_param2),parseInt(sessionStorage.context_param3));
        }
        if(sessionStorage.contextACTION == 'PEEPED'){
            callFuncBuyPeepAccess(parseInt(sessionStorage.context_param1));
        }
        
    }
    
    resetContext();
}



