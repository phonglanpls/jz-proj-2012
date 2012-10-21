<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>

<?php 
	$userdataobj = getAccountUserDataObject(true);
?>

<?php if(!isset($_GET['edit_mode'])):?>

<div class="box-profile user-profile body-container">
	<h3><?php echo language_translate('contact_info_label_contact_info');?></h3>
	<label><?php echo language_translate('contact_info_label_f_name');?></label> <?php echo $userdataobj->first_name;?>
	<div class="clear sep"></div>
	
	<label><?php echo language_translate('contact_info_label_l_name');?></label> <?php echo $userdataobj->last_name;?>
	<div class="clear sep"></div>
	
	<label><?php echo language_translate('contact_info_label_email');?></label> <?php echo $userdataobj->email;?>
	<div class="clear sep"></div>
	
	<label><?php echo language_translate('contact_info_label_phone_number');?></label> <?php if($userdataobj->cell_no != 0)echo $userdataobj->cell_no;?>
	<div class="clear sep"></div>
	
	<label><?php echo language_translate('contact_info_label_country');?></label> <?php if($userdataobj->id_country) echo getValueOfArray ( countryOptionData_ioc( $userdataobj->id_country ) );?>
	<div class="clear sep"></div>
	
	<label><?php echo language_translate('contact_info_label_state');?></label> <?php if($userdataobj->id_state) echo getValueOfArray ( stateOptionData_ioc( $userdataobj->id_country, $userdataobj->id_state ) );?>
	<div class="clear sep"></div>
	
	<label><?php echo language_translate('contact_info_label_city');?></label> <?php if($userdataobj->id_city) echo getValueOfArray ( cityOptionData_ioc( $userdataobj->id_country, $userdataobj->id_state, $userdataobj->id_city ) );?>
	<div class="clear sep"></div>
	
	<label><?php echo language_translate('contact_info_label_address');?></label> <?php echo $userdataobj->address;?>
	<div class="clear sep"></div>
	
	<label><?php echo language_translate('contact_info_label_zip_code');?></label> <?php echo $userdataobj->postal_code;?>
	<div class="clear sep"></div>
	
	<label><?php echo language_translate('contact_info_label_timezone');?></label> <?php if($userdataobj->timezone) { $timezonearr = timezoneDataOption_ioc(); echo $timezonearr[$userdataobj->timezone];}?>
	<div class="clear sep"></div>
	
	<label><?php echo language_translate('contact_info_label_birthday');?></label> <?php  echo birthDay($userdataobj->dob);?>
	<div class="clear sep"></div>
	
	<label>&nbsp;</label> 
	<a href="javascript:void(0);" onclick="callFuncLoadEditContactInfoContext();" class="button"><?php echo language_translate('sys_button_title_edit');?></a> 
	<?php echo loader_image_s("id='loaderContextLoader' class='hidden'");?>
						
</div>

<?php else:?>

<?php 
	echo form_open(
						$action = site_url("mod_io/account_func/submit_edit_account_info"), 
						$attributes = "method='post' id='submit_edit_account_info' name='submit_edit_account_info' ", 
						$hidden = array()
				);
?>

<div class="box-profile user-profile body-container">
	<h3><?php echo language_translate('contact_info_label_contact_info');?></h3>
	<label><?php echo language_translate('contact_info_label_f_name');?></label> 
	<div class="inputcls">
		<input class="account-profile" type="text" name="first_name" value="<?php echo $userdataobj->first_name;?>" maxlength="45" />
	</div>
	<div class="clear"></div>
	
	<label><?php echo language_translate('contact_info_label_l_name');?></label> 
	<div class="inputcls">
		<input class="account-profile" type="text" name="last_name" value="<?php echo $userdataobj->last_name;?>" maxlength="45" />
	</div>
	<div class="clear"></div>
	
	<label><?php echo language_translate('contact_info_label_email');?></label> 
	<div class="inputcls">
		<input class="account-profile" type="text" name="email" value="<?php echo $userdataobj->email;?>" maxlength="45" />
	</div>
	<div class="clear"></div>

    
	<label><?php echo language_translate('contact_info_label_phone_number');?></label> 
	<div class="inputcls">
		<input class="account-profile" type="text" name="cell_no" value="<?php if($userdataobj->cell_no != 0)echo $userdataobj->cell_no;?>" maxlength="15" />
	</div>
	<div class="clear"></div>
	
	<label><?php echo language_translate('contact_info_label_country');?></label> 
	<div class="inputcls">
		<?php echo form_dropdown( $name='country_id', countryOptionData_ioc(), array( $userdataobj->id_country ), $extra=" id='country_id' class='account-profile' " );?>
		<?php echo loader_image_s("id='country_loader' class='hidden'");?>
	</div>
	<div class="clear"></div>
	
	<label><?php echo language_translate('contact_info_label_state');?></label> 
	<div class="inputcls">
		<?php echo form_dropdown( $name='state_id', stateOptionData_ioc($country_id=$userdataobj->id_country), array( $userdataobj->id_state ), $extra=" id='state_id' class='account-profile' " );?>
		<?php echo loader_image_s("id='state_loader' class='hidden'");?>
	</div>
	<div class="clear"></div>
	
	<label><?php echo language_translate('contact_info_label_city');?></label> 
	<div class="inputcls">
		<?php echo form_dropdown( $name='city_id', cityOptionData_ioc($country_id=$userdataobj->id_country, $state_id=$userdataobj->id_state), array( $userdataobj->id_city ), $extra=" id='city_id' class='account-profile' " );?>
		<?php echo loader_image_s("id='city_loader' class='hidden'");?>
	</div>
	<div class="clear"></div>
	
	<label><?php echo language_translate('contact_info_label_address');?></label> 
	<div class="inputcls">
		<textarea class="textareacls" name="address" ><?php echo $userdataobj->address;?></textarea>
	</div>
	<div class="clear"></div>
	
	<label><?php echo language_translate('contact_info_label_zip_code');?></label> 
	<div class="inputcls">
		<input class="account-profile" type="text" name="postal_code" value="<?php echo $userdataobj->postal_code;?>" maxlength="15" />
	</div>
	<div class="clear"></div>
	
	<label><?php echo language_translate('contact_info_label_timezone');?></label> 
	<div class="inputcls">
		<?php echo form_dropdown( $name='timezone', timezoneDataOption_ioc(), array( $userdataobj->timezone ), $extra=" id='timezone' class='account-profile'" );?>	
	</div>
	<div class="clear"></div>
	
	<label><?php echo language_translate('contact_info_label_birthday');?></label> 
	<div class="inputcls">
		<input class="account-profile" type="text" name="birthday" id="dob" value="<?php echo birthDay( $userdataobj->dob );?>" />
	</div>
	 
	<div class="clear"></div>
	
	<label>&nbsp;</label> 
	<div class="inputcls">
		<input type="submit" value="<?php echo language_translate('sys_button_title_save');?>" name="submit" class="share-2" />
		<input type="button" value="<?php echo language_translate('sys_button_title_cancel');?>" class="share-2" onclick="callFuncLoadDefaultContactInfoContext();"/>
		<?php echo loader_image_s("id='loaderContextLoader' class='hidden'");?>
	</div>
	
	<div class="clear"></div>
</div>

<?php echo form_close();?>

<script type="text/javascript">
	$(document).ready(function(){
		$('#country_id').live('change',function(){
			$id_country = $(this).val();
			$('#state_loader').removeClass('hidden');
			callFuncChangeState($id_country);
		});
		$('#state_id').live('change',function(){
			$id_country = $('#country_id').val();
			$id_state = $(this).val();
			$('#city_loader').removeClass('hidden');
			callFuncChangeCity($id_country,$id_state);
		});
	});
	
	function callFuncChangeState($id_country){
		$.get(BASE_URI+'mod_io/wall_async/changeStateAsync',{id_country:$id_country},function(res){
			$('#state_loader').addClass('hidden');
			$('#state_id').html(res);
			
			$id_state = $('#state_id').children().first().next().val();
			callFuncChangeCity($id_country,$id_state);
		});
	}
	
	function callFuncChangeCity($id_country,$id_state){
		$.get(BASE_URI+'mod_io/wall_async/changeCityAsync',{id_country:$id_country,id_state:$id_state},function(res){
			$('#city_loader').addClass('hidden');
			$('#city_id').html(res);
		});
	}
	
	$(document).ready(function(){
		var options = { 
			dataType:  'json', 	
			beforeSubmit:  validateB4Submit,  
			success:       processAfterResponding  
		};	
		$('#submit_edit_account_info').ajaxForm(options); 
		
		$( "#dob" ).datepicker(
			{
				dateFormat: 'dd-mm-yy',
				changeMonth: true,
				changeYear: true 
			}	
		);
	});
	
	function validateB4Submit(formData, jqForm, options){
		$('#loaderContextLoader').toggle();
		return true;
	}

	function processAfterResponding(responseText, statusText, xhr, $form) {
		$('#loaderContextLoader').toggle();	
		if(responseText.result == 'ok'){
			sysMessage(responseText.message,'callFuncLoadDefaultContactInfoContext()');
		}else{
			sysWarning(responseText.message);
		}
	}
</script>
	
<?php endif;?>
