
$(document).ready(function(){
	$('.filterOfMyFriends').live('change',function(){
		$bygroup = $('#bygroup').val();
		$bygender = $('#bygender').val();
		$byage = $('#byage').val();
		$bylocation = $('#bylocation').val();
		
		$('#filterContextLoader').toggle();
		$.get(BASE_URI+'user/friends_func/callFuncShowFriendFilter',
			{bygroup:$bygroup,bygender:$bygender,byage:$byage,bylocation:$bylocation,search_flag:'1'},
			function(res){
				$('#filterContextLoader').toggle();
				$('#friendsShowAsyncDiv').html(res);
			}
		);
	});
});


function callFuncAddFriend(id_user){
	siteLoadingDialogOn();
	$.post(BASE_URI+'mod_io/friend_async/callFuncAddFriend',{id_user:id_user},function(res){
		if(res.result == 'ok'){
			$('#addFriendContext_'+id_user).text(res.message);
			siteLoadingDialogOff();
		}else{
			$('#hiddenElement').html(res.message);
			$('#hiddenElement').dialog(
				{
					 width: 300,
					 height:150 ,
					 draggable: false,
					 resizable: false,
					 beforeClose: function(event, ui) { 
					 },
					 close: function(event, ui) { 
						siteLoadingDialogOff();
					 },
					buttons:{},
					title: 'Warning' 
				}
			);
		}
		
	},'json');
}

function callFuncAcceptFriendRequest(id_user){
	siteLoadingDialogOn();
	$.post(BASE_URI+'mod_io/friend_async/callFuncAcceptFriendRequest',{id_user:id_user},function(res){
		siteLoadingDialogOff();
		if(res.result == 'ok'){
			$('#requestUserContext_'+id_user).fadeOut();
		}
	},'json');
}

function callFuncRejectFriendRequest(id_user){
	siteLoadingDialogOn();
	$.post(BASE_URI+'mod_io/friend_async/callFuncRejectFriendRequest',{id_user:id_user},function(res){
		siteLoadingDialogOff();
		if(res.result == 'ok'){
			$('#requestUserContext_'+id_user).fadeOut();
		}
	},'json');
}

function callFuncBlockFriend(id_user){
	siteLoadingDialogOn();
	$.post(BASE_URI+'mod_io/friend_async/callFuncBlockFriend',{id_user:id_user},function(res){
		siteLoadingDialogOff();
		if(res.result == 'ok'){
			$('#requestUserContext_'+id_user).fadeOut();
		}
	},'json');
}

function callFuncPreviewInviteFriends(){
	siteLoadingDialogOn();
	$.get(BASE_URI+'user/friends_func/callFuncPreviewInviteFriends',{message:$("#message").val()},function(res){
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
				title: 'Invite friend preview email' 
			}
		);
	});
}

function callFuncInviteFriends(){
	$('#inviteFriendContextLoader').toggle();
	$.get(BASE_URI+'mod_io/friend_async/callFuncInviteFriends',
		{message:$("#message").val(), subject:$("#subject").val(),emailaddress:$("#emailaddress").val()},
		function(res){
			$('#inviteFriendContextLoader').toggle();
			
			$('#hiddenElement').html(res);
			$('#hiddenElement').dialog(
				{
					 width: 550,
					 height:350 ,
					 draggable: false,
					 resizable: false,
					 beforeClose: function(event, ui) { 
					 },
					 close: function(event, ui) { 
					},
					buttons:{
						"OK": function(event,ui){
							$('#hiddenElement').dialog("close");
						},
					},
					title: 'Invite friend send email report' 
				}
			);
		}
	);
}

function callFuncUnfriend(id_user){
	$.post(BASE_URI+'mod_io/friend_async/callFuncUnfriend',{id_user:id_user},function(res){
		if(res.result= 'ok'){
			$('#itemID_'+id_user).fadeOut();
		}
	},'json');
}

function callFuncShowMyFacebookFriends(){
	siteLoadingDialogOn();
	$.get(BASE_URI+'user/friends_func/callFuncShowMyFacebookFriends',{},function(res){
		$('#hiddenElement').html(res);
		$('#hiddenElement').dialog(
			{
				 width: 700,
				 height:550 ,
				 draggable: false,
				 resizable: false,
				 beforeClose: function(event, ui) { 
				 },
				 close: function(event, ui) { 
					siteLoadingDialogOff();
				 },
				buttons:{
				},
				title: 'Invite friends' 
			}
		);
	});
}

function callFuncShowMyTwitterFriends(){
	siteLoadingDialogOn();
	$.get(BASE_URI+'user/friends_func/callFuncShowMyTwitterFriends',{},function(res){
		$('#hiddenElement').html(res);
		$('#hiddenElement').dialog(
			{
				 width: 700,
				 height:550 ,
				 draggable: false,
				 resizable: false,
				 beforeClose: function(event, ui) { 
				 },
				 close: function(event, ui) { 
					siteLoadingDialogOff();
				 },
				buttons:{
				},
				title: 'Invite friends' 
			}
		);
	});
}







