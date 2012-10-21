<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<style>
	#bygroup,
	#bylocation{
		width:100px;
	}
</style>
 <?php 
	$userdataobj = getAccountUserDataObject(true);
	
	$locationArray['Anywhere'] = 'Anywhere';
	if($userdataobj->country){
		$locationArray[$userdataobj->country] = 'Within '.$userdataobj->country;
	}
	if($userdataobj->state){
		$locationArray[$userdataobj->state] = 'Within '.$userdataobj->state;
	}
 ?>
 
 <strong>Show:</strong>
 <?php echo form_dropdown( $name='bygroup', friendByGroupOptionData_ioc(), array( $this->input->get('bygroup','') ), $extra=" id='bygroup' size='1' class='filterOfMyFriends' " );?>

 <strong>Gender:</strong>
 <?php echo form_dropdown( $name='bygender', genderOptionData_ioc(), array( $this->input->get('bygender','') ), $extra=" id='bygender' size='1' class='filterOfMyFriends' " );?>

 <strong>Age:</strong>
 <?php echo form_dropdown( $name='byage', rangeAgeOptionData_ioc(), array( $this->input->get('byage','') ), $extra=" id='byage' size='1' class='filterOfMyFriends' " );?>

 <strong>Location:</strong>
 <?php echo form_dropdown( $name='bylocation', $locationArray, array( $this->input->get('bylocation','') ), $extra=" id='bylocation' size='1' class='filterOfMyFriends' " );?>

 <?php echo loader_image_s("id=\"filterContextLoader\" class='hidden'");?>