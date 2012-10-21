<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>

<script type="text/javascript" src="<?php echo site_url();?>/media/js/hentai.js"></script> 
<script type="text/javascript" src="<?php echo site_url();?>/media/js/backstage.js"></script> 
<script type="text/javascript" src="<?php echo site_url();?>/media/js/my_backstage.js"></script> 
<script type="text/javascript" src="<?php echo site_url();?>/media/js/map_flirts.js"></script> 



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
				 
				<div class="filter-split" id="emailInfoAsyncDiv">
					<?php if(isset($_SESSION['trialpay'])): ?>
                        Your transaction was successfully. You added <?php echo currencyDisplay($_SESSION['trialpay']['cash_added']).JC;?> into your balance.
                    <?php endif;?>
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
	$(function(){
	   if(sessionStorage.contextACTION){
	       reCallPreviousDialog();
	   }
	})
});
</script>
