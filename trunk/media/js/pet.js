function callFuncSearchPets(){
	$('#searchPetsContextLoader').toggle();
	var obj = {};
	
	obj.pric = $('#pric').val();
	obj.gen = $('#gen').val();
	obj.sb = $('#sb').val();
	obj.agefrom = $('#agefrom').val();
	obj.ageto = $('#ageto').val();
	obj.distance = $('#distance').val();
	obj.country_name = $('#country_name').val();
	obj.status = $('#status').val();
	obj.mapvalue = $('#mapvalue').val();
	obj.photo = $('#photo').val();
	obj.search_flag = 1;
	
	$.get(BASE_URI+'user/pets_func/callFuncSearchPetsDefault',obj,function(res){
		$('#searchPetsContextLoader').toggle();
		$('#petAsyncDiv').html(res);
	});
}

function callFuncSearchPets2(){
	$('#searchPetsContextLoader').toggle();
	var obj = {};
	obj.name = $('#name').val();
	$.get(BASE_URI+'user/pets_func/callFuncSearchPets2',obj,function(res){
		$('#searchPetsContextLoader').toggle();
		$('#petAsyncDiv').html(res);
	});
}

function callFuncResetSearch(){
	$.get(BASE_URI+'user/pets_func/callFuncResetSearch',{},function(res){
		$('#wrapPetSearchDiv').html(res);
	});
}

function callFuncAddToWishListThisPet(id_user){
	siteLoadingDialogOn();
	$.get(BASE_URI+'mod_io/pet_submit_async/callFuncAddToWishListThisPet',{id_user:id_user},function(res){
		siteLoadingDialogOff();
		$('#wishlistInfoDivID_'+id_user).html(res);
		callFuncReloadWishList();
	});
}

function callFuncReloadWishList(){
	$.get(BASE_URI+'user/pets_func/callFuncReloadWishList',{},function(res){
		$('#wishlistBoxAsync').html(res);
	});
}

function callFuncReloadPetList(){
	$.get(BASE_URI+'user/pets_func/callFuncReloadPetList',{},function(res){
		$('#petlistBoxAsync').html(res);
	});
}

function callFuncRemoveFromWishList(id_user){
	siteLoadingDialogOn();
	$.get(BASE_URI+'mod_io/pet_submit_async/callFuncRemoveFromWishList',{id_user:id_user},function(res){
		siteLoadingDialogOff();
		$('#wishlistInfoDivID_'+id_user).html(res);
		callFuncReloadWishList();
	});
}

function callFuncChangeSearchMode(){
	$.get(BASE_URI+'user/pets_func/callFuncChangeSearchMode',{},function(res){
		$('#wrapPetSearchDiv').html(res);
	});
}

function callFuncBackToSearchDefault(){
	$.get(BASE_URI+'user/pets_func/callFuncBackToSearchDefault',{},function(res){
		$('#wrapPetSearchDiv').html(res);
	});
}

function callFuncAddThisPet(id_user){
	siteLoadingDialogOn();
	$.get(BASE_URI+'user/pets_func/callFuncAddThisPet',{id_user:id_user,context:'CMCHAT'},function(res){
		//siteLoadingDialogOff();
		//$('#itemID_'+id_user).fadeOut();
		//callFuncReloadWishList();
		closeCMCpopupWD();
		
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
				},
				buttons:{},
				title: 'Buy pet' 
			}
		);
	});
}

function callFuncSubmitInfoBuyPet(id_pet){
	$contexture = $('#buyFlag').val();
	if($contexture == '1'){
		return false;
	}
	$context = $('#context').val();
	
	$('#buyFlag').attr('value','1');	
	$('#buyPetContextLoader').toggle();
	$.get(BASE_URI+'user/pets_func/callFuncSubmitInfoBuyPet',{id_pet:id_pet,context:$context},function(res){
		if(res.result == 'ok'){
			//$('#wrapUI').html(res.message);
			$('#itemID_'+id_pet).remove();
			$('#wishLISTid_'+id_pet).remove();
			$('#hiddenElement').dialog('close');
			callFuncShowUIPostToWall(id_pet);
			if($context == 'CMCHAT'){
				jqcc.cometchat.sendMessage(id_pet,res.CMCMSG);
			}
		}else{
			debug(res.message);
		}
		$('#buyPetContextLoader').toggle();
	},'json');
}


function callFuncShowUIPostToWall(id_pet){
	siteLoadingDialogOn();
	if( SYS_JS_SOCIAL.facebook == 1 || SYS_JS_SOCIAL.twitter == 1){
		
		$.get(BASE_URI+'user/pets_func/callFuncShowUIPostToWall',{id_pet:id_pet},function(res){
			$('#hiddenElement').html(res);
			$('#hiddenElement').dialog(
				{
					 width: 550,
					 height:250 ,
					 draggable: false,
					 resizable: false,
					 beforeClose: function(event, ui) { 
					 },
					 close: function(event, ui) { 
						siteLoadingDialogOff();
					},
					buttons:{},
					title: 'Post on your wall' 
				}
			);
			//$('.ui-dialog').center();
			callFuncReloadPetList();
		});
	}else{
		$('#hiddenElement').html("You must connect on your facebook, twitter account firstly to post on wall.");
		$('#hiddenElement').dialog(
			{
				 width: 550,
				 height:200 ,
				 draggable: false,
				 resizable: false,
				 beforeClose: function(event, ui) { 
				 },
				 close: function(event, ui) { 
					siteLoadingDialogOff();
				},
				buttons:{
					"OK": function(event,ui){
							queryurl(BASE_URI+'user/connect');
						},
					 "Cancel" : function (event, ui){
						$('#hiddenElement').dialog('close');
					}	
				},
				title: 'Post on your wall' 
			}
		);
		callFuncReloadPetList(); 
	}	
}

function callFuncPostOnWall(){
	$message = $('#message').val();
	$('#postonwallloaderContext').toggle();
	$.post(BASE_URI+'mod_io/pet_submit_async/postOnWall',{message:$message},function(res){
		$('#postonwallloaderContext').toggle();
		sysMessage(res.message,"gotoMyPets()");
	},'json');
}

function gotoMyPets(){
	queryurl(BASE_URI+'user/mypets');
}









