function callFuncShareCommentPhoto(id_photo){
	$('#shareContextLoader').toggle();
	var commentText = $('#my_comment').val();
	
	if(commentText.length == 0){
		$('#shareContextLoader').toggle();
		return;
	}else{
		$.get(BASE_URI+'mod_io/photos_func/submitCommentPhoto',{id_photo:id_photo, comment:commentText},function(res){
			$('#shareContextLoader').toggle();
			$('#photoCommentAsyncDiv').html(res);
			$('#my_comment').val('');
		});
	}
}

function callFuncDeleteComment(id_photo_comment){
	$.post(BASE_URI+'mod_io/photos_func/deleteComment',{id_photo_comment:id_photo_comment},function(res){
		if(res.result=='OK'){
			$('#articleDivId_'+id_photo_comment).fadeOut();
		}
	},'json');	
}