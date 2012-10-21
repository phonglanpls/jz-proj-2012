 <?php if (!defined('BASEPATH')) exit('No direct script access allowed'); ?>
 
 <?php 
	$userdataobj = getAccountUserDataObject(true);
    $segment = $this->input->get('segment');
    $cat = ($segment)?$segment:$this->uri->segment(3,'');
    
 ?>
 <?php if($cat == 'my_chatter'):?>
 
 <?php elseif($cat == 'friends'):?>
 
 <?php elseif($cat == 'everyone' OR $cat == ''):?>
     <div class="filter-split">
    	<strong>Show:</strong>
    	<?php echo form_dropdown( $name='gender', genderOptionData_ioc(), array( $userdataobj->chat_gender ), $extra=" id='gender' size='1' onchange='callFuncChangeFilter(this.value,\"gender\");' " );?>
    
    	<strong>Age from:</strong>
    	<?php echo form_dropdown( $name='age_from', ageOptionData_ioc(), array( $userdataobj->chat_age_from ), $extra=" id='age_from' size='1' onchange='callFuncChangeFilter(this.value,\"age_from\");'" );?>
    	
    	<strong>To:</strong>
    	<?php echo form_dropdown( $name='age_to', ageOptionData_ioc(), array( $userdataobj->chat_age_to ), $extra=" id='age_to' size='1' onchange='callFuncChangeFilter(this.value,\"age_to\");'" );?>
    <!--
    	<strong>Location:</strong>
    	<?php //echo form_dropdown( $name='country_id', countryOptionData_ioc(), array( $userdataobj->id_country ), $extra=" id='country_id' size='1' onchange='callFuncChangeFilter(this.value,\"country\");'" );?>
    -->	
    	<a class="button" href="javascript:void(0);" onclick="callFuncShowDialogChangeFilterWall();">Change</a>
    		<?php echo loader_image_s("id=\"changeFilterContextLoader\" class='hidden'");?>
     </div>
<?php else:?>
    <div class="filter-split">
    	<strong>Show:</strong>
    	<?php echo form_dropdown( $name='gender', genderOptionData_ioc(), array( $userdataobj->chat_gender ), $extra=" id='gender' size='1' onchange='callFuncChangeFilter(this.value,\"gender\");' " );?>
    
    	<strong>Age from:</strong>
    	<?php echo form_dropdown( $name='age_from', ageOptionData_ioc(), array( $userdataobj->chat_age_from ), $extra=" id='age_from' size='1' onchange='callFuncChangeFilter(this.value,\"age_from\");'" );?>
    	
    	<strong>To:</strong>
    	<?php echo form_dropdown( $name='age_to', ageOptionData_ioc(), array( $userdataobj->chat_age_to ), $extra=" id='age_to' size='1' onchange='callFuncChangeFilter(this.value,\"age_to\");'" );?>
    
    	<strong>Location:</strong>
    	<?php echo form_dropdown( $name='country_id', countryOptionData_ioc(), array( $userdataobj->id_country ), $extra=" id='country_id' size='1' onchange='callFuncChangeFilter(this.value,\"country\");'" );?>
    	
    	<a class="button" href="javascript:void(0);" onclick="callFuncShowDialogChangeFilterWall();">Change</a>
    		<?php echo loader_image_s("id=\"changeFilterContextLoader\" class='hidden'");?>
    </div>
<?php endif;?>
