 <?php if (!defined('BASEPATH')) exit('No direct script access allowed'); ?>
 
 <div class="filter-split">
	<strong>Show:</strong>
	<?php echo form_dropdown( $name='gender', genderOptionData_ioc(), array( $userdataobj->chat_gender ), $extra=" id='gender' size='1' " );?>

	<strong>Age from:</strong>
	<?php echo form_dropdown( $name='age_from', ageOptionData_ioc(), array( $userdataobj->chat_age_from ), $extra=" id='age_from' size='1' " );?>
	
	<strong>To:</strong>
	<?php echo form_dropdown( $name='age_to', ageOptionData_ioc(), array( $userdataobj->chat_age_to ), $extra=" id='age_to' size='1' " );?>

	<strong>Location:</strong>
	<?php echo form_dropdown( $name='country_id', countryOptionData_ioc(), array( $userdataobj->id_country ), $extra=" id='country_id' size='1' " );?>
	
	<a class="button" href="javascript:void(0);" onclick="callFuncShowDialogChangeFilterWall_MYPROFILE();">Change</a>
</div>
