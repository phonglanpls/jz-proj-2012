<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>

<?php 

?>
<div id="page-login">
    	<div class="input">
			<?php echo language_translate('member_fake_email_detected'); ?>
		</div>
    <?php echo form_open($action = site_url("member/submit_renamed_email_site_login"), $attributes = "method='post' id='submit_renamed_email_site_login' name='submit_renamed_email_site_login' ", $hidden = array());?>
		<div class="input">
			<label><?php echo language_translate('member_old_fake_email');?></label>
			<input type="text" value="" name="old_email" class="text" maxlength="45" />
		</div>
        <div class="input">
			<label><?php echo language_translate('member_new_email');?></label>
			<input type="text" value="" name="new_email" class="text" maxlength="45" />
		</div>
		<div class="input">
			<label><?php echo language_translate('member_login_label_password');?></label>
			<input type="password" value="" name="password" class="text" maxlength="45" />
		</div>
		<div class="input">
			<div class="input-padding">
				<input type="submit" value="<?php echo language_translate('member_login_button_login');?>" name="submit" class="share-2" />
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
		$('#submit_renamed_email_site_login').ajaxForm(options); 
	});	
		
	function validateB4Submit(formData, jqForm, options){
		siteLoadingOn();
		return true;
	}

	function processAfterResponding(responseJson, statusText, xhr, $form) {
		siteLoadingOff();
		if(responseJson.status == 'ok'){
			siteMessage(responseJson.message);
			queryurl( BASE_URI+'user' );
        }else{
			siteWarning(responseJson.message);
		}
	}
</script>	