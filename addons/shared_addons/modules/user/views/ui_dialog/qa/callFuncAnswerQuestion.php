<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>

<?php 
	$userdataobj = getAccountUserDataObject(true);
	$id_question = intval($this->input->get('id_question'));
	$questionRecord = $this->qa_m->getRecord_Question($id_question);
	
	echo form_open(
						$action = site_url("mod_io/qa_submit_async/submit_answer_question"), 
						$attributes = "method='post' id='submit_answer_question' name='submit_answer_question' ", 
						$hidden = array()
				);
?>
<input type="hidden" name="id_question" id="id_question" value="<?php echo $id_question;?>" />
<div id="wrap-dialog-box">	
	<div class="input" id="questionArea">
		<label><strong>Question:</strong></label> <?php echo $questionRecord->question;?> 
		
		<div class="clear"></div>
		<label><strong>Answer:</strong></label> 
		<textarea class="disablecopypaste" maxlength="<?php echo $GLOBALS['global']['INPUT_LIMIT']['askme_answer'];?>" cols="15" rows="5" style="width:392px;height:145px;" id="answer" name="answer"></textarea>
		
		<div class="clear"></div>
		<label>&nbsp;</label>You have <span id="leftLetters"><?php echo $GLOBALS['global']['INPUT_LIMIT']['askme_answer'];?></span> characters left. 
	</div>
	
	<div class="input">
		<div id="sys_message">Submit successfully.</div>
		<div class="input-padding">
			<?php echo loader_image_s("id='save_loader' class='hidden'");?>
			<input type="submit" value="Save" name="submit" class="share-2" id="submit-button-id" />
		</div>
	</div>
</div>	
<?php echo form_close();?>

<script type="text/javascript">
	$(document).ready(function(){
		 $('textarea.disablecopypaste').bind('copy paste', function (e) {
		   e.preventDefault();
		});
		
		var TOTAL = <?php echo $GLOBALS['global']['INPUT_LIMIT']['askme_answer'];?>;
		$('#answer').live('keyup',function(){
			$length = TOTAL - $(this).val().length;
			$('#leftLetters').text($length);
		});
	});
	
	$(document).ready(function(){
		var options = { 
			beforeSubmit:  validateB4Submit,  
			success:       processAfterResponding  
		};	
		$('#submit_answer_question').ajaxForm(options); 
	});
	
	function validateB4Submit(formData, jqForm, options){
		$('#save_loader').show();
		return true;
	}

	function processAfterResponding(responseText, statusText, xhr, $form) {
		$('#save_loader').hide();	
		if(responseText == 'ok'){
			$('#questionArea,#submit-button-id').hide();
			showSysMessage();
			$('#hiddenElement').dialog({height:100});
			setTimeout(function(){$('#hiddenElement').dialog("close");},DELAY);
			siteLoadingDialogOff();
			$id_question = $('#id_question').val();
			$('#askmeQuestionItem_'+$id_question).fadeOut();
		}else{
			debug(responseText);
		}
	}
</script>