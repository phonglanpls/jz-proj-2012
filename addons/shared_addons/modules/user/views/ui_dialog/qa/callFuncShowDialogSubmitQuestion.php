<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>

<?php 
	$userdataobj = getAccountUserDataObject(true);
	echo form_open(
						$action = site_url("mod_io/qa_submit_async/submit_a_question"), 
						$attributes = "method='post' id='submit_a_question' name='submit_a_question' ", 
						$hidden = array()
				);
?>
<input type="hidden" name="id_user" id="id_user" value="<?php echo intval($this->input->get('id_user'));?>" />
<div id="wrap-dialog-box">	
	<div class="input" id="questionArea">
		<label><strong>Question:</strong></label>
		
		<a href="javascript:void(0);" onclick="callFuncShowQuestionIdea();">Need a question idea?</a>
		<?php echo loader_image_s("id='pre_def_loader' class='hidden'");?>
		
		<div class="clear"></div>
		<label>&nbsp;</label> <textarea class="disablecopypaste" maxlength="<?php echo $GLOBALS['global']['INPUT_LIMIT']['askmeq'];?>" cols="15" rows="5" style="width:392px;height:125px;" id="question" name="question"></textarea>
		
		<div class="clear"></div>
		<label>&nbsp;</label> <input type="checkbox" name="anonymous" value="1" /> &nbsp; Ask Anonymously?
		
		<div class="clear"></div>
		<label>&nbsp;</label>You have <span id="leftLetters"><?php echo $GLOBALS['global']['INPUT_LIMIT']['askmeq'];?></span> characters left. 
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
		
		var TOTAL = <?php echo $GLOBALS['global']['INPUT_LIMIT']['askmeq'];?>;
		$('#question').live('keyup',function(){
			$length = TOTAL - $(this).val().length;
			$('#leftLetters').text($length);
		});
	});
	
	$(document).ready(function(){
		var options = { 
			beforeSubmit:  validateB4Submit,  
			success:       processAfterResponding  
		};	
		$('#submit_a_question').ajaxForm(options); 
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
		}else{
			debug(responseText);
		}
	}
</script>