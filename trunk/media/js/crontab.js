function updatelockpet(){
	$.post(BASE_URI+'mod_io/crontab/updatelockpet',{},function(res){});
}

function sendOfflineChat(){
    $.post(BASE_URI+'mod_io/crontab/sendOfflineChat',{},function(res){});
}

$(document).ready(function(){
	//window.setInterval("updatelockpet()",5000);
    //window.setInterval("sendOfflineChat()",30000);
});