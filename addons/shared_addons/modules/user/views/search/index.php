<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>

<script type="text/javascript" src="<?php echo site_url();?>/media/js/search.js"></script> 

<div id="body-content">
   <?php $this->load->view("user/partial/left");?>
 
	<div id="body">
		<div class="body">
			<div id="content">
				<?php $this->load->view("user/partial/top"); ?>
				<div class="clear"></div>
				 
					<div class="filter-split">
						<h3>Search User Results With: <?php echo $keyword=($this->input->get('keyword'));?></h3>
						
						<div class="clear sep"></div>
						
						<?php 
							if(strlen($keyword)){
								$rs = $this->db->query(" SELECT * FROM ".TBL_USER." WHERE username LIKE '%$keyword%' AND status=0")->result();
							}else{
								$rs = array();
							}
						?>
						
						<?php $i=1; foreach($rs as $item):?>
							<div class="friend-item" id="itemID_<?php echo $item->id_user;?>">
								<div class="user-profile-avatar">
									<img src="<?php echo $this->user_m->getProfileAvatar($item->id_user);?>" />
								</div>
								<div class="user-profile-username">
									<?php echo $this->user_m->getProfileDisplayName($item->id_user);?>
								</div>
								<div class="user-profile-agesex">
									<strong>Age/Sex:</strong> <?php echo cal_age($item->dob);?>, <?php echo $item->gender;?>
								</div>
								<div class="user-profile-location">
									<strong>Location:</strong>
									<?php 
										if($item->state){
											echo $item->state.', ';
										}
										if($item->country){
											echo $item->country;
										}
									?>
								</div>
								<div class="user-profile-birthday">
									<strong>Birthday:</strong> <?php echo birthDay($item->dob);?>
								</div>
								<div class="user-profile-cash">
									<strong>Cash:</strong> <?php echo $this->user_m->getCash($item->id_user);?>
								</div>
							</div>
							
							<?php if( $i%4 == 0 ):?>
								<div class="clear"></div>
							<?php endif;?>	
							
							<?php $i++;?>
						<?php endforeach;?>
						
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
