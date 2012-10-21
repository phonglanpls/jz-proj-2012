
function callFuncCalTotalPrice(price,chargeperday,day,id){
	if(day == 0){
		$('#totalPrice_'+id).html('');
		return false;
	}
	var pr = price*chargeperday*day;
	$('#totalPrice_'+id).html("Total price:" + pr.toFixed(2)+'J$');	
}

function callFuncLockPet(){
	$('#lockPetsContextLoader').toggle();
	
	$locktype = $('input[name="locktype"]:checked').val() ? parseInt ( $('input[name="locktype"]:checked').val() ) : 0;
	$pet =  $('input[name="pet"]:checked').val() ? parseInt ( $('input[name="pet"]:checked').val() ) : 0;
	  
	$('#warningAct').html('');
	if( $locktype == 0 || $pet == 0 ){
		$('#warningAct').html('Choose a pet and a lock firstly.');
		$('#lockPetsContextLoader').toggle();
		return;
	}
	$chargeperday = parseInt ( $('#lock_type_ID_'+$locktype).val() );
	 
	if(0 == $chargeperday){
		$('#warningAct').html('Select a type of lock.');
		$('#lockPetsContextLoader').toggle();
		return;
	}
	$('#lockPetsContextLoader').toggle();
	
	siteLoadingDialogOn();
	$.get(BASE_URI+'user/pets_func/callFuncDialogShowLockPet',{pet_id:$pet,lock_id:$locktype,day:$chargeperday},function(res){
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
				title: 'Lock a Pet' 
			}
		);
	});
}

function callFuncSubmitLockPet(pet_id,lock_id,day){
	$('#lockPetContextLoader').toggle();
	if($('#lockFlag').val() == '1'){
		return false;
	}
	$('#lockFlag').attr('value','1');
	
	$.get(BASE_URI+'user/pets_func/submitLockPet',{pet_id:pet_id,lock_id:lock_id,day:day},function(res){
		if(res.result == 'ok'){
			//$('#wrapUI').html(res.message);
			$('#lockedPetInfo_'+pet_id).html(res.update);
			callFuncShowUIPostToWall_lockpet(pet_id);
		}
	},'json');
}

function callFuncPostOnWall_lockpet(){
	$message = $('#message').val();
	$('#postonwallloaderContext').toggle();
	$.post(BASE_URI+'mod_io/pet_submit_async/postOnWall',{message:$message},function(res){
		$('#postonwallloaderContext').toggle();
		sysMessage(res.message,"$('#hiddenElement').dialog('close')");
	},'json');
}


function callFuncShowUIPostToWall_lockpet(id_pet){
	siteLoadingDialogOn();
	 
	if( SYS_JS_SOCIAL.facebook == 1 || SYS_JS_SOCIAL.twitter == 1){
		
		$.get(BASE_URI+'user/pets_func/callFuncShowUIPostToWall_lockpet',{id_pet:id_pet},function(res){
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
		 
	}	
}







