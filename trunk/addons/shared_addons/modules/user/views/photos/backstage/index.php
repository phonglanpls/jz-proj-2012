<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>

<script type="text/javascript" src="<?php echo site_url();?>/media/js/photos.js"></script> 

<?php 
	$id_photo = intval( $this->uri->segment(4,0) );
	$gallerydataobj = $this->gallery_io_m->init('id_image',$id_photo);
	
	$id_user = getAccountUserId();
	if(!$gallerydataobj ){
		show_404();
	}
	
	if($gallerydataobj->image_type == 0){
		redirect("user/photos/$id_photo");
	}
	
	/**
	if( $id_user != $gallerydata->id_user ){
		if( !$this->collection_m->isMyCollectionPhoto($id_photo) ){
			show_404();
		}
	}
	**/
?>
<div id="body-content">
   <?php $this->load->view("user/partial/left");?>
 
	<div id="body">
		<div class="body">
			<div id="content">
				<?php $this->load->view("user/partial/top"); ?>
				<div class="clear"></div>
				
				<div class="filter-split">
					<?php $this->load->view("photos/backstage/show_photo", array('id_photo'=>$id_photo)); ?>
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
	$('.myCommentBox').live('focusin',function(){
		$dfText = $(this).val();
		if($dfText == '<?php echo language_translate("wall_comment_default");?>'){
			$(this).val('');
		}
	});
	
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
