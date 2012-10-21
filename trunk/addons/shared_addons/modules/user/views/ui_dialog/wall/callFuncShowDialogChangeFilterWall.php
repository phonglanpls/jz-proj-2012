<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>

<?php 
	$userdataobj = getAccountUserDataObject(true);
	echo form_open(
						$action = site_url("mod_io/wall_submit_async/submit_change_filter_options"), 
						$attributes = "method='post' id='submit_change_filter_options' name='submit_change_filter_options' ", 
						$hidden = array()
				);
?>
<div id="wrap-dialog-box">	
	<div class="input">
		<label><strong>Show:</strong></label>
		<?php echo form_dropdown( $name='gender', genderOptionData_ioc(), array( $userdataobj->chat_gender ), $extra=" id='gender' class='inputcls'" );?>
	</div>
	
	<div class="input">
		<label><strong>Age from:</strong></label>
		<?php echo form_dropdown( $name='age_from', ageOptionData_ioc(), array( $userdataobj->chat_age_from ), $extra=" id='age_from' class='inputcls'" );?>
	</div>	
	
	<div class="input">
		<label><strong>Age To:</strong></label>
		<?php echo form_dropdown( $name='age_to', ageOptionData_ioc(), array( $userdataobj->chat_age_to ), $extra=" id='age_to' class='inputcls'" );?>
	</div>
	
	<div class="input">
		<label><strong>Country:</strong></label>
		<?php echo form_dropdown( $name='country_id', countryOptionData_ioc(), array( $userdataobj->id_country ), $extra=" id='country_id' class='inputcls' " );?>
		<?php echo loader_image_s("id='country_loader' class='hidden'");?>
	</div>
	
	<div class="input">
		<label><strong>State:</strong></label>
		<?php echo form_dropdown( $name='state_id', stateOptionData_ioc($country_id=$userdataobj->id_country), array( $userdataobj->id_state ), $extra=" id='state_id' class='inputcls' " );?>
		<?php echo loader_image_s("id='state_loader' class='hidden'");?>
	</div>
	
	<div class="input">
		<label><strong>City:</strong></label>
		<?php echo form_dropdown( $name='city_id', cityOptionData_ioc($country_id=$userdataobj->id_country, $state_id=$userdataobj->id_state), array( $userdataobj->id_city ), $extra=" id='city_id' class='inputcls' " );?>
		<?php echo loader_image_s("id='city_loader' class='hidden'");?>
	</div>
	
	<div class="input">
		<label><strong>Address:</strong></label>
		<textarea class="textareacls" name="address" ><?php echo $userdataobj->address;?></textarea>
	</div>
	
	<div class="input">
		<label><strong>Zip code:</strong></label>
		<input type="text" name="zipcode" id="zipcode" class="inputcls" value="<?php echo $userdataobj->postal_code;?>" />
	</div>
	
	<div class="input">
		<div id="sys_message">Update successfully.</div>
		<div class="input-padding">
			<?php echo loader_image_s("id='save_loader' class='hidden'");?>
			<input type="submit" value="Save" name="submit" class="share-2" id="submit-button-id" />
		</div>
	</div>
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
			beforeSubmit:  validateB4Submit,  
			success:       processAfterResponding  
		};	
		$('#submit_change_filter_options').ajaxForm(options); 
	});
	
	function validateB4Submit(formData, jqForm, options){
		$('#save_loader').show();
		return true;
	}

	function processAfterResponding(responseText, statusText, xhr, $form) {
		$('#save_loader').hide();	
		if(responseText == 'ok'){
			showSysMessage();
		}else{
			debug(responseText);
		}
	}
</script>