<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>

<script type="text/javascript" src="<?php echo site_url();?>/media/js/friends.js"></script> 
	
<div id="body-content">
   <?php $this->load->view("user/partial/left");?>
 
	<div id="body">
		<div class="body">
			<div id="content">
				<?php $this->load->view("user/partial/top"); ?>
				<div class="clear"></div>
				
				<div class="filter-split">
					<?php 
						$i = 1;
						foreach( $this->friend_m->myRequestFriend() as $item ):
					?>
						<div class="friend-item-s" id="requestUserContext_<?php echo $item->friend;?>">
							<div class="user-profile-avatar">
								<a href="<?php echo $this->user_m->getUserHomeLink($item->friend);?>">
									<img src="<?php echo $this->user_m->getProfileAvatar($item->friend);?>" />
								</a>
							</div>
							<div class="user-profile-username">
								<?php echo $this->user_m->getProfileDisplayName($item->friend);?>
							</div>
							
							<div class="user-profile-button" id="acceptContextDiv_<?php echo $item->friend;?>">
								<a onclick="callFuncAcceptFriendRequest(<?php echo $item->friend;?>)" href="javascript:void(0);">Accept</a>
							</div>
							
							<div class="user-profile-button" id="rejectContextDiv_<?php echo $item->friend;?>">
								<a onclick="callFuncRejectFriendRequest(<?php echo $item->friend;?>)" href="javascript:void(0);">Reject</a>
							</div>
							
							<div class="user-profile-button" id="blockContextDiv_<?php echo $item->friend;?>">
								<a onclick="callFuncBlockFriend(<?php echo $item->friend;?>)" href="javascript:void(0);">Block</a>
							</div>
						</div>
						
						<?php if( $i%5 == 0 ):?>
							<div class="clear"></div>
						<?php endif;?>	
						
						<?php $i++;?>
						
					<?php endforeach ;?>
				</div>
				 
				<div class="clear"></div>
				
			</div>
		</div>
	   <?php $this->load->view("user/partial/right");?>
	</div>
	<div class="clear"></div>
	
</div>

