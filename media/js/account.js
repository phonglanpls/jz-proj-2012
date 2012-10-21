
function callFuncLoadEditContactInfoContext(){
	$('#loaderContextLoader').toggle();
	$.get(BASE_URI+'user/account/loadContactInfo',{edit_mode:'1',is_async:'1'},function(res){
		$('#loaderContextLoader').toggle();
		$('#contactInfoAsyncDiv').html(res);
	});
}

function callFuncLoadDefaultContactInfoContext(){
	$('#loaderContextLoader').toggle();
	$.get(BASE_URI+'user/account/loadDefaultContactInfo',{is_async:'1'},function(res){
		$('#loaderContextLoader').toggle();
		$('#contactInfoAsyncDiv').html(res);
	});
}

function callFuncLoadChangePasswordContext(){
	$('#loaderChangePasswordContextLoader').toggle();
	$.get(BASE_URI+'user/account/loadChangePasswordContext',{is_async:'1',edit_mode:'1'},function(res){
		$('#loaderChangePasswordContextLoader').toggle();
		$('#passwordInfoAsyncDiv').html(res);
	});
}

function callFuncLoadDefaultPasswordContext(){
	$('#loaderChangePasswordContextLoader').toggle();
	$.get(BASE_URI+'user/account/loadDefaultPasswordContext',{is_async:'1'},function(res){
		$('#loaderChangePasswordContextLoader').toggle();
		$('#passwordInfoAsyncDiv').html(res);
	});
}

function callFuncLoadDefaultEmailSetting(){
	$('#emailSettingContextLoader').toggle();
	$.get(BASE_URI+'user/account/loadDefaultEmailSettingContext',{is_async:'1'},function(res){
		$('#emailSettingContextLoader').toggle();
		$('#emailInfoAsyncDiv').html(res);
	});
}


$(document).ready(function(){
	$('#peep_access').live('change',function(e){
		var peepvalue = parseInt( $(this).val() );
		if(peepvalue < 1){
			e.preventDefault();
			sysWarning("Please choose a value");
			return;
		}
		$.post(BASE_URI+'mod_io/account_func/submitChangePeepValue',{peepvalue:peepvalue},function(res){
		});
	});
	
});
