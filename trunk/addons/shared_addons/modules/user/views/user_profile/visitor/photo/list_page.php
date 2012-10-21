<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>

<?php 
	$userPublicPhotos = $this->collection_m->getPublicPhotos($userdataobj->id_user);
	$photopath = site_url()."image/thumb/photos/";
?>

<div id="body-content">
   
	<div id="body">
		<div class="body">
			<div id="content">
				<div class="clear"></div>
				
				<div class="filter-split">
					<?php $this->load->view("user_profile/visitor/user_info", array('userdataobj'=>$userdataobj)); ?>
				</div>
				 
				<div class="clear"></div>
				 
				<h3>Public Photos</h3> 
				<div class="filter-split">
					
					<?php $i=1; foreach($userPublicPhotos as $item):?>
						<div class="friend-item-s">
							<div class="user-profile-avatar">
								<img src="<?php echo $photopath.$item->image;?>" class="tip" title="<?php echo $item->comment;?>" />
								
							</div>
							
						</div>
						
						<?php if( $i%5 == 0 ):?>
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
