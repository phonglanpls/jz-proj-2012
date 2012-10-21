<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>

<script type="text/javascript" src="<?php echo site_url();?>/media/js/photos.js"></script> 

<?php 
	$id_photo = intval( $this->uri->segment(3,0) );
	
	$gallerydataobj = $this->gallery_io_m->init('id_image',$id_photo);
	if($gallerydataobj->image_type == 1){
		redirect("user/photos/backstage/$id_photo");
	}
?>
<div id="body-content">
   <?php $this->load->view("user/partial/left");?>
 
	<div id="body">
		<div class="body">
			<div id="content">
				<?php $this->load->view("user/partial/top"); ?>
				<div class="clear"></div>
				
				<div class="filter-split">
					<?php $this->load->view("photos/show_photo", array('id_photo'=>$id_photo)); ?>
					<div class="clear"></div>
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