function callFuncShowQuestions(){
	$('#questionContextLoader').toggle();
	$.get(BASE_URI+'user/qa_func/callFuncShowQuestions',{},function(res){
		$('#questionContextLoader').toggle();
		$('#askmeAsyncDiv').html(res);
	});
}

function callFuncShowAnswers(){
	$('#answerContextLoader').toggle();
	$.get(BASE_URI+'user/qa_func/callFuncShowAnswers',{},function(res){
		$('#answerContextLoader').toggle();
		$('#askmeAsyncDiv').html(res);
	});
}

function callFuncShowAksFriends(){
	$('#askFriendsContextLoader').toggle();
	$.get(BASE_URI+'user/qa_func/callFuncShowAksFriends',{},function(res){
		$('#askFriendsContextLoader').toggle();
		$('#askmeAsyncDiv').html(res);
	});
}

function callFuncShowDialogSubmitQuestion(id_user){
	siteLoadingDialogOn();
	$.get(BASE_URI+'user/qa_func/callFuncShowDialogSubmitQuestion',{id_user:id_user},function(res){
		$('#hiddenElement').html(res);
		$('#hiddenElement').dialog(
			{
				 width: 550,
				 height:300 ,
				 draggable: false,
				 resizable: false,
				 beforeClose: function(event, ui) { 
				 },
				 close: function(event, ui) { 
					siteLoadingDialogOff();
				 },
				buttons:{},
				title: 'Ask me a question' 
			}
		);
		//$('.ui-dialog').center();
	});
}

function callFuncAnswerQuestion(id_question){
	siteLoadingDialogOn();
	$.get(BASE_URI+'user/qa_func/callFuncAnswerQuestion',{id_question:id_question},function(res){
		$('#hiddenElement').html(res);
		$('#hiddenElement').dialog(
			{
				 width: 550,
				 height:300 ,
				 draggable: false,
				 resizable: false,
				 beforeClose: function(event, ui) { 
				 },
				 close: function(event, ui) { 
					siteLoadingDialogOff();
				 },
				buttons:{},
				title: 'Answer' 
			}
		);
		//$('.ui-dialog').center();
	});
}

function callFuncDeleteQuestion(id_question){
	siteLoadingDialogOn();
	$('#hiddenElement').html("Are you sure you want to delete this?");
	$('#hiddenElement').dialog(
		{
			 width: 550,
			 height:150 ,
			 draggable: false,
			 resizable: false,
			 buttons:{
				"Delete":function(){
					$.post(BASE_URI+'mod_io/qa_submit_async/deleteQuestion',{id_question:id_question},function(res){
						if(res.result=='OK'){
							$('#askmeQuestionItem_'+id_question).fadeOut();
						}
						$('#hiddenElement').dialog("close");
						siteLoadingDialogOff();
					},'json');	
				},
				"Cancel":function(){
					$(this).dialog("close");
					siteLoadingDialogOff();
				}
			 },
			close: function(event, ui) { 
				siteLoadingDialogOff();
			},
			title: 'Delete' 
		}
	);
	//$('.ui-dialog').center();
}

function callFuncShowDialogViewLog(id_user){
	siteLoadingDialogOn();
	$.get(BASE_URI+'user/qa_func/callFuncShowLog',{id_user:id_user},function(res){
		$('#hiddenElement').html(res);
		$('#hiddenElement').dialog(
			{
				 width: 650,
				 height:450 ,
				 draggable: false,
				 resizable: false,
				 beforeClose: function(event, ui) { 
				 },
				 close: function(event, ui) { 
					siteLoadingDialogOff();
				 },
				 buttons:{
					"OK": function(event, ui) { 
						$('#hiddenElement').dialog('close');
					},
				 },
				 title: 'View Log' 
			}
		);
		//$('.ui-dialog').center();
	});
}

function callFuncShowQuestionIdea(){
	$('#pre_def_loader').show();
	$.get(BASE_URI+'user/qa_func/callFuncShowQuestionIdea',{},function(res){
		$('#pre_def_loader').hide();
		$('#dialogElement').html(res);
		$('#dialogElement').dialog(
			{
				 width: 700,
				 height:550 ,
				 draggable: false,
				 resizable: false,
				 beforeClose: function(event, ui) { 
				 },
				 close: function(event, ui) { 
					//siteLoadingDialogOff();
				 },
				 buttons:{
				 },
				 title: 'Question Idea' 
			}
		);
		//$('.ui-dialog').center();
	});
}

function callFuncInsertIntoQuestionArea(ques){
	$('#question').val(ques);
	$('#dialogElement').dialog('close');
}
