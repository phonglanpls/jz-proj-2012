<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>

<script type="text/javascript" src="<?php echo site_url();?>/media/js/block.js"></script> 

<?php 
	
?>

<div id="body-content">
   <?php $this->load->view("user/partial/left");?>
 
	<div id="body">
		<div class="body">
			<div id="content">
				<?php $this->load->view("user/partial/top"); ?>
				<div class="clear"></div>
				
				<div class="filter-split"> 
					<a href="javascript:void(0);" onclick="callFuncShowAccessMapBlock();"><?php echo language_translate('block_menu_label_map_location');?></a> 
						<?php echo loader_image_s("id='accessMapContextLoader' class='hidden'");?>
					|
					<a href="javascript:void(0);" onclick="callFuncShowChatBlock();"><?php echo language_translate('block_menu_label_chat');?></a>
						<?php echo loader_image_s("id='chatBlockContextLoader' class='hidden'");?>
					
				</div>
				
				<div class="filter-split" id="blockAsyncDiv">
					<?php $this->load->view("block/accessMapBlock"); ?>
				</div>
				
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
