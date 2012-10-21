<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>

<script type="text/javascript" src="<?php echo site_url();?>/media/js/account.js"></script> 

<?php 
	$userdataobj = getAccountUserDataObject(true);
?>

<div id="body-content">
   <?php $this->load->view("user/partial/left");?>
 
	<div id="body">
		<div class="body">
			<div id="content">
				<?php $this->load->view("user/partial/top"); ?>
				<div class="clear"></div>
				
				<div class="filter-split">
					<?php 
						$str1 = form_dropdown('peep_access',peepValueOptionData_ioc(), array($userdataobj->peep_access ), 'id="peep_access" ');
						$str2 = $GLOBALS['global']['PEEP_PRICE']['user'];
						echo str_replace(array('$1','$2'), array($str1, $str2), language_translate('contact_info_label_index'));
					?>
				</div>
				
                <?php if(isset($active_email)):?>
                    <div class="filter-split" id="contactInfoAsyncDiv">
    					<?php 
                            $array = (array) json_decode($active_email);
                            echo $array['message'];
                         ?>
    				</div>
                <?php endif;?>
                
				<div class="filter-split" id="contactInfoAsyncDiv">
					<?php $this->load->view("account/contact_info"); ?>
				</div>
				 
				<div class="clear"></div>
				 
				<div class="filter-split" id="passwordInfoAsyncDiv">
					<?php $this->load->view("account/password_info"); ?>
				</div>
				
				<div class="clear"></div>
				 
				<div class="filter-split" id="emailInfoAsyncDiv">
					<?php $this->load->view("account/email_info"); ?>
				</div>

				<div class="clear"></div>
				
			</div>
		</div>
	   <?php $this->load->view("user/partial/right");?>
	</div>
	<div class="clear"></div>
	
</div>

<script type="text/javascript">
	
$(document).ready(function(){
	
});
</script>
