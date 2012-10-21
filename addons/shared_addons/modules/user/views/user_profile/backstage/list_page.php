<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>

<?php 
	$userBackstagePhotos = $this->backstage_m->getUserBackstagePhoto($userdataobj->id_user);
	$path = site_url()."image/thumb/photos/";
?>

<script type="text/javascript" src="<?php echo site_url();?>/media/js/photos.js"></script> 
<script type="text/javascript" src="<?php echo site_url();?>/media/js/backstage.js"></script> 


<div id="body-content">
   <?php $this->load->view("user/partial/left");?>
 
	<div id="body">
		<div class="body">
			<div id="content">
				<?php $this->load->view("user/partial/top"); ?>
				<div class="clear"></div>
				
				<div class="filter-split">
					<?php $this->load->view("user_profile/user_info", array('userdataobj'=>$userdataobj)); ?>
				</div>
				 
				<div class="clear"></div>
				 
				<h3>Backstage Photos</h3> 
				<div class="filter-split">
					
					<?php $i=1; foreach($userBackstagePhotos as $item):?>
						<div class="friend-item">
							<div class="user-profile-avatar">
								<?php if($this->collection_m->isMyCollectionPhoto($item->id_image)):?>
									<a href="<?php echo site_url("{$userdataobj->username}/backstage_photo/{$item->id_image}")?>">
										<img src="<?php echo $path.$item->image; ?>" class="tip" title="<?php echo $item->comment;?>" />
									</a>	
								<?php else:?>
									<?php echo lock_image(true,$ext=" class=\"tip\" title=\"{$item->comment}\" ");?>
								<?php endif;?>
							</div>
							 
							<div class="obj-item">
								<b>Views: </b><?php if($item->v_count) echo $item->v_count;?>
							</div>
							
							<div class="obj-item">
								<b>Comments: </b>
								<?php if($item->comments):?>
									<a href="javascript:void(0);" onclick="callFuncShowAllCommentBackstagePhoto(<?php echo $item->id_image?>,'<?php echo mysql_real_escape_string($item->comment);?>');" >
										[ <?php echo $item->comments;?> ]
									</a>
								<?php endif;?>
							</div>
							
							<div class="obj-item">
								<b>Rating: </b><?php if($item->rating) echo ($item->rating);?>
							</div>
							
							<?php if(! $this->collection_m->isMyCollectionPhoto($item->id_image)):?>
								<div class="user-profile-button">
									<a href="javascript:void(0);" onclick="callFuncBuyThisBackstagePhoto(<?php echo $item->id_image;?>)">
										Buy For <?php echo currencyDisplay($item->price);?>J$
									</a>
								</div>
							<?php endif;?>
							
						</div>
						
						<?php if( $i%4 == 0 ):?>
							<div class="clear"></div>
						<?php endif;?>	
						
						<?php $i++;?>
						
					<?php endforeach;?>
					
					
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
