<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>

<?php 
	$userBackstagePhotos = $this->backstage_m->getUserBackstagePhoto($userdataobj->id_user);
	$path = site_url()."image/thumb/photos/";
?>

<script type="text/javascript" src="<?php echo site_url();?>/media/js/photos.js"></script> 
<script type="text/javascript" src="<?php echo site_url();?>/media/js/backstage.js"></script> 


<div id="body-content">
   
	<div id="body">
		<div class="body">
			<div id="content">
				<div class="clear"></div>
				
				<div class="filter-split">
					<?php $this->load->view("user_profile/visitor/user_info", array('userdataobj'=>$userdataobj)); ?>
				</div>
				 
				<div class="clear"></div>
				 
				<h3>Backstage Photos</h3> 
				<div class="filter-split">
					
					<?php $i=1; foreach($userBackstagePhotos as $item):?>
						<div class="friend-item">
							<div class="user-profile-avatar">
									<?php echo lock_image(true,$ext=" class=\"tip\" title=\"{$item->comment}\" ");?>
								
							</div>
							 
							<div class="obj-item">
								<b>Views: </b><?php if($item->v_count) echo $item->v_count;?>
							</div>
							
							<div class="obj-item">
								<b>Comments: </b>
								<?php if($item->comments):?>
										[ <?php echo $item->comments;?> ]
									
								<?php endif;?>
							</div>
							
							<div class="obj-item">
								<b>Rating: </b><?php if($item->rating) echo ($item->rating);?>
							</div>
							
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
