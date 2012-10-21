<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>

<div id="page-login">
    <?php echo form_open($action = site_url("member/submit_forgot_email"), $attributes = "method='post' id='submit_forgot_email' name='submit_forgot_email' ", $hidden = array());?>
		<div class="input">
			<?php echo language_translate('member_forgot_password_guide');?>
		</div>
		<div class="input">
			<label><?php echo language_translate('member_login_label_email');?></label>
			<input type="text" value="" name="email" class="text" maxlength="45" />
		</div>
		<div class="input">
			<div class="input-padding">
				<input type="submit" value="<?php echo language_translate('member_login_button_submit');?>" name="submit" class="share-2" />
			</div>
		</div>
	<?php echo form_close();?>
	
	<div class="clear"></div>
	 
</div>
	
<script type="text/javascript">
	$(document).ready(function() {
		var options = { 
			dataType:  'json', 	
			beforeSubmit:  validateB4Submit,  
			success:       processAfterResponding   
		};	
		$('#submit_forgot_email').ajaxForm(options); 
	});	
		
	function validateB4Submit(formData, jqForm, options){
		siteLoadingOn();
		return true;
	}

	function processAfterResponding(responseJson, statusText, xhr, $form) {
		siteLoadingOff();
		if(responseJson.status == 'ok'){
			queryurl( BASE_URI+'member/fgp_notify' );
		}else{
			siteWarning(responseJson.message);
		}
	}
</script>	