
function callFuncShowGiftCategory(id_category){
	$('#giftCategoryContextLoader').toggle();
	$.get(BASE_URI+'user/giftbox/gift_category',{category_id:id_category},function(res){
		$('#giftCategoryContextLoader').toggle();
		$('#giftIDAsync').html(res);
	});
}

function callFuncLoadSendGift(){
	$.get(BASE_URI+'user/giftbox/callFuncLoadSendGift',{},function(res){
		$('#sendGifAsyncDiv').html(res);
	});
}

function callFuncAddGiftToBox(id_gift){
	$imgLink = $(".image-gift[rel="+id_gift+"]").attr('src');
	$('#id_gift_send').attr('value',id_gift);
	$('#gift-selected').html("<img src="+$imgLink+" />");
}

function callFuncSendGift(){
	if($('#sending_gift_context').val() == '1'){
		return false;
	}
	
	$id_gift = $('#id_gift_send').val();
	$usernames = $('#to_username').val();
	$message = $('#message').val();
	
	$('#sending_gift_context').attr('value','1');
	$('#sendGiftContextLoader').toggle();
	$.post(BASE_URI+'mod_io/giftbox_func/sendgift',{id_gift:$id_gift,usernames:$usernames,message:$message},function(res){
		$('#sendGiftContextLoader').toggle();
		$('#sending_gift_context').attr('value','0');
		if(res.result=='ok'){
			sysMessage(res.message, 'callFuncLoadSendGift()');
		}else{
		   $hash = "87fff0f0316207265c80578645f89ef2?sid="+USER_ID+"&ref_page=addcash&ref_choice=gift&campaign=Gift";
           $str = "<br />"+
		      "<a href=\"javascript:void(0);\" style=\"color: #3FAFFE;\" onclick=\"callFuncTrialPay_addCampaign('"+$hash+"');\" >Add your J$ cash here</a>";  
			sysWarning(res.message+$str);
		}
	},'json');
}

function callFuncSendGiftToUser(){
	if($('#sending_gift_context').val() == '1'){
		return false;
	}
	
	$id_gift = $('#id_gift_send').val();
	$id_user = $('#id_to_user').val();
	$message = $('#message').val();
	
	$context = $('#context').val();
	
	$('#sending_gift_context').attr('value','1');
	$('#sendGiftContextLoader').toggle();
	$.post(BASE_URI+'mod_io/giftbox_func/sendgiftToUser',{id_gift:$id_gift,id_user:$id_user,message:$message,context:$context},function(res){
		$('#sendGiftContextLoader').toggle();
		$('#sending_gift_context').attr('value','0');
		if(res.result=='ok'){
			sysMessage(res.message, "$('#hiddenElement').dialog('close')");
			//if($context=='CMCHAT'){
				jqcc.cometchat.sendMessage($id_user,res.CMCHATMSG);
			//}
		}else{
			sysWarning(res.message);
		}
	},'json');
}

function callFuncShowDialogSendGift(id_user){
	siteLoadingDialogOn();
	$.get(BASE_URI+'user/giftbox/callFuncShowDialogSendGift',{id_user:id_user,context:'CMCHAT'},function(res){
		closeCMCpopupWD();
		$('#hiddenElement').html(res);
		$('#hiddenElement').dialog(
			{
				 width: 850,
				 height:650 ,
				 draggable: false,
				 resizable: false,
				 beforeClose: function(event, ui) { 
					siteLoadingDialogOff();
				 },
				 close: function(event, ui) { 
					siteLoadingDialogOff();
				},
				buttons:{},
				title: 'Send gift' 
			}
		);
	});
}