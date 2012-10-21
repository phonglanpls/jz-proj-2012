
function callFuncAddUserToMyFavouriteList(id_user){
	siteLoadingDialogOn();
	$.post(BASE_URI+'mod_io/favourite_func/addUserToMyFvList',{id_user:id_user},function(res){
		if(res.result= 'ok'){
			/* jqcc.cometchat.sendMessage(id_user,res.CMCHATMSG); */
			sysMessage(res.message,'reloadRightBarAsync()');
			closeCMCpopupWD();
		}
		siteLoadingDialogOff();
	},'json');
}

function callFuncBuyFavouriteAccessPackage(){
	siteLoadingDialogOn();
	$.post(BASE_URI+'mod_io/favourite_func/callFuncBuyFavouriteAccessPackage',{},function(res){
		if(res.result== 'ok'){
			sysMessage(res.message,'reload()');
		}else{
		   $hash = "51f6a4c640c08b62794399f24f4b6ceb?sid="+USER_ID+"&ref_page=addcash&ref_choice=favorite&campaign=WhoFavoriteMe";
           $str = "<br />"+
		      "<a href=\"javascript:void(0);\" style=\"color: #3FAFFE;\" onclick=\"callFuncTrialPay_addCampaign('"+$hash+"');\" >Add your J$ cash here</a>";  
			sysWarning(res.message+$str);
		}
		siteLoadingDialogOff();
	},'json');
}