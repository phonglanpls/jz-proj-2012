<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>

<?php if(!isset($_GET['edit_mode'])):?>
	<div class="box-profile body-container">
		<a href="javascript:void(0);" onclick="callFuncLoadChangePasswordContext();" class="button"><?php echo language_translate('password_info_label_change_pw');?></a> 
		<?php echo loader_image_s("id='loaderChangePasswordContextLoader' class='hidden'");?>
	</div>
<?php else:?>
	
<?php 
	echo form_open(
						$action = site_url("mod_io/account_func/submit_change_password_info"), 
						$attributes = "method='post' id='submit_change_password_info' name='submit_change_password_info' ", 
						$hidden = array()
				);
?>

<div class="box-profile user-profile body-container">
	<h3><?php echo language_translate('password_info_label_change_pw');?></h3>
	
	<label><?php echo language_translate('password_info_label_old_pw');?></label> 
	<div class="inputcls">
		<input class="account-profile" type="password" name="old_passwd" value="" maxlength="45" />
	</div>
	<div class="clear"></div>
	
	<label><?php echo language_translate('password_info_label_new_pw');?></label> 
	<div class="inputcls">
		<input class="account-profile" type="password" name="new_passwd" value="" maxlength="45" />
	</div>
	<div class="clear"></div>
	
	<label><?php echo language_translate('password_info_label_retype_new_pw');?></label> 
	<div class="inputcls">
		<input class="account-profile" type="password" name="new_passwd2" value="" maxlength="45" />
	</div>
	<div class="clear"></div>
	
	<label>&nbsp;</label> 
	<div class="inputcls">
		<input type="submit" value="<?php echo language_translate('sys_button_title_save');?>" name="submit" class="share-2" />
		<input type="button" value="<?php echo language_translate('sys_button_title_cancel');?>" class="share-2" onclick="callFuncLoadDefaultPasswordContext();"/>
		<?php echo loader_image_s("id='loaderChangePasswordContextLoader' class='hidden'");?>
	</div>
	
	<div class="clear"></div>
</div>

<?php echo form_close();?>	


<script type="text/javascript">
	
	$(document).ready(function(){
		var options = { 
			dataType:  'json', 	
			beforeSubmit:  validateB4Submit,  
			success:       processAfterResponding  
		};	
		$('#submit_change_password_info').ajaxForm(options); 
	
	});
	
	function validateB4Submit(formData, jqForm, options){
		$('#loaderChangePasswordContextLoader').toggle();
		return true;
	}

	function processAfterResponding(responseText, statusText, xhr, $form) {
		$('#loaderChangePasswordContextLoader').toggle();	
		if(responseText.result == 'ok'){
			sysMessage(responseText.message,'callFuncLoadDefaultPasswordContext()');
		}else{
			sysWarning(responseText.message);
		}
	}
</script>
<?php endif;?>