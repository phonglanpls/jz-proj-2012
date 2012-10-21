<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>

<script type="text/javascript" src="<?php echo site_url();?>/media/js/collection.js"></script> 

<div id="body-content">
   <?php $this->load->view("user/partial/left");?>
 
	<div id="body">
		<div class="body">
			<div id="content">
				<?php $this->load->view("user/partial/top"); ?>
				<div class="clear"></div>
				
				<div class="filter-split">
					<a href="javascript:void(0);" onclick="callFuncShowPhotoCollection();"><?php echo language_translate('collection_menu_label_photo_collection');?></a> 
						<?php echo loader_image_s("id='photoCollectionContextLoader' class='hidden'");?>
					|
					<a href="javascript:void(0);" onclick="callFuncShowMyPhoto();"><?php echo language_translate('collection_menu_label_my_photo');?></a>
						<?php echo loader_image_s("id='myPhotoContextLoader' class='hidden'");?>
				</div>
				
				<div class="filter-split" id="photoCollectionAsyncDiv">
					<?php $this->load->view("collection/photo_collection"); ?>
				</div>
				
			</div>
		</div>
	   <?php $this->load->view("user/partial/right");?>
	</div>
	<div class="clear"></div>
	
</div>

<script type="text/javascript">
	
$(document).ready(function(){
	$('.async-loading a').live('click',function(){
		$('#myPhotoContextLoader').toggle();
		$href = $(this).attr('href');
		$.get($href,{},function(res){
			$('#myPhotoContextLoader').toggle();
			$('#photoCollectionAsyncDiv').html(res);
			return false;
		});
		return false;
	});
});
</script>
