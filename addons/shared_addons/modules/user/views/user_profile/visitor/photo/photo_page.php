<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>

<?php 
	//$userPublicPhotos = $this->collection_m->getPublicPhotos($userdataobj->id_user);
	$path = site_url().$GLOBALS['global']['IMAGE']['image_orig']."photos/";
	
	$gallerydataobj = $this->gallery_io_m->init('id_image',$id_photo);
	if($gallerydataobj->image_type == 1){
		redirect("user/photos/backstage/$id_photo");
	}
	
	$id_user = $gallerydataobj->id_user;
	if($id_user != $userdataobj->id_user){
		show_404();
	}
	
	$myCollectionPhoto = $this->collection_m->getPublicPhotos($id_user);
	
	$prev_photo_id = $next_photo_id = 0;
	
	for($i=0;$i<count($myCollectionPhoto);$i++){
		if($myCollectionPhoto[$i]->id_image == $id_photo){
			if(isset($myCollectionPhoto[$i-1])){
				$prev_photo_id = $myCollectionPhoto[$i-1]->id_image;
			}
			if(isset($myCollectionPhoto[$i+1])){
				$next_photo_id = $myCollectionPhoto[$i+1]->id_image;
			}
			break;
		}
	}
?>

<script type="text/javascript" src="<?php echo site_url();?>/media/js/photos.js"></script> 
<script type="text/javascript" src="<?php echo site_url();?>/media/js/collection.js"></script> 

<div id="body-content">
   
	<div id="body">
		<div class="body">
			<div id="content">
				<div class="clear"></div>
				
				<div class="filter-split">
					<?php $this->load->view("user_profile/visitor/user_info", array('userdataobj'=>$userdataobj)); ?>
				</div>
				 
				<div class="clear"></div>
				 
				<h3><a href="<?php echo site_url("{$userdataobj->username}/photos");?>">Public Photos</a></h3> 
				<div class="filter-split">
												
						<div class="cls-photo-gallery">
							<div class="cls-nav-photos async-loading">
								<?php if($prev_photo_id){ $link = site_url("{$userdataobj->username}/photo/{$prev_photo_id}"); echo "<a href='$link'>&laquo; Previous</a> |"; }?>
								<?php if($next_photo_id){ $link = site_url("{$userdataobj->username}/photo/{$next_photo_id}"); echo "<a href='$link'>Next &raquo;</a>"; }?>
							</div>
							
							<div class="clear"></div>
							
							<img src="<?php echo $path.$gallerydataobj->image;?>" />	
							<div class="clear"></div>
							
							<?php echo $gallerydataobj->comment;?>
						</div>

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
		$('img.tip[title]').qtip( {
					style:{
								tip:{
									corner: true
									}
						},
				}	
			);
	});
</script>
