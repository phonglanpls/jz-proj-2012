<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>

<script type="text/javascript" src="<?php echo site_url();?>/media/js/giftbox.js"></script> 

<div id="body-content">
   <?php $this->load->view("user/partial/left");?>
 
	<div id="body">
		<div class="body">
			<div id="content">
				<?php $this->load->view("user/partial/top"); ?>
				<div class="clear"></div>
				<!--
					<div class="filter-split">
						<a href="javascript:void(0);" onclick="callFuncShowPhotoCollection();">Giftbox</a> 
							<?php //echo loader_image_s("id='giftBoxContextLoader' class='hidden'");?>
						|
						<a href="javascript:void(0);" onclick="callFuncShowMyPhoto();">My Gifts</a>
							<?php //echo loader_image_s("id='myGiftContextLoader' class='hidden'");?>
					</div>
				-->
				<div class="filter-split" id="giftAsyncDiv">
					<?php $this->load->view("giftbox/giftbox"); ?>
				</div>
				
			</div>
		</div>
	   <?php $this->load->view("user/partial/right");?>
	</div>
	<div class="clear"></div>
	
</div>

<script type="text/javascript">
	
$(document).ready(function(){
	$('.pagination a').live('click',function(){
		$href = $(this).attr('href');
		$('#paginationContextLoader').toggle();
		$.get($href,{},function(res){
			$('#paginationContextLoader').toggle();
			$('#giftIDAsync').html(res);
			return false;
		});
		 
		return false;
	});
});
</script>
