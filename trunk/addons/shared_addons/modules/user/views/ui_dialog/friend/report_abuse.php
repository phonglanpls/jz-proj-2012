<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>

<?php 
	
	echo form_open(
						$action = site_url("mod_io/friend_async/submit_report_abuse"), 
						$attributes = "method='post' id='submit_report_abuse' name='submit_report_abuse' ", 
						$hidden = array()
				);
?>
<input type="hidden" name="id_user" id="id_user" value="<?php echo intval($this->input->get('id_user'));?>" />
<div id="wrap-dialog-box">	
	<div class="input" id="questionArea">
		<label><strong>Message:</strong></label>
		
		<div class="clear"></div>
		<label>&nbsp;</label> <textarea class="disablecopypaste" maxlength="<?php echo $GLOBALS['global']['INPUT_LIMIT']['askmeq'];?>" cols="15" rows="5" style="width:392px;height:125px;" id="message" name="message"></textarea>
		
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
		$('#message').live('keyup',function(){
			$length = TOTAL - $(this).val().length;
			$('#leftLetters').text($length);
		});
	});
	
	$(document).ready(function(){
		var options = { 
			beforeSubmit:  validateB4Submit,  
			success:       processAfterResponding  
		};	
		$('#submit_report_abuse').ajaxForm(options); 
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
			$('#report_abuse').hide();
		}else{
			debug(responseText);
		}
	}
</script>