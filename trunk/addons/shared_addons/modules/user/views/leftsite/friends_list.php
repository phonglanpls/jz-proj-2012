<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>

<style>
	.extra-link{
		position:absolute;
		right:5px;
		top:15px;
	}
	.extra-link a{
		color:#3FAFFE;
	}
</style>

<?php 
	$myFriends = $this->friend_m->getAllFriends(getAccountUserId());
?>
<div class="widget" style="position:relative;">
	<h4><?php echo language_translate('left_menu_label_friendlist');?>(<?php echo $number = count($myFriends);?>)</h4>
	
	<?php if($number>0):?>
		<div class="extra-link">
			<a href="<?php echo site_url("user/friends");?>"><?php echo language_translate('left_menu_label_viewall');?></a>
		</div>
	<?php endif;?>
	
	<div class="clear"></div>
	
	<?php 
		if(count($myFriends) == 0){
			echo '<p class="msg">'.language_translate('left_menu_label_friendlist_msg').'</p>';
		}
	?>
	
	<div id="myFriendListBox">
		<?php $i=1; foreach($myFriends as $item):?>
			<div class="friend-item-s">
				<div class="user-profile-avatar">
					<a href="<?php echo $this->user_m->getUserHomeLink($item->id_user);?>">
						<img src="<?php echo $this->user_m->getProfileAvatar($item->id_user);?>" />
					</a>
				</div>
				<div class="user-profile-username">
					<?php echo $this->user_m->getProfileDisplayName($item->id_user);?>
				</div>
				<div class="user-profile-agesex">
					<?php echo $item->cal_age;?>, <?php echo $item->gender;?>
				</div>
				<div class="user-profile-location">
					<?php 
						if($item->state){
							echo $item->state.', ';
						}
						if($item->country){
							echo $item->country;
						}
					?>
				</div>
			</div>
			
			<?php if( $i%2 == 0 ):?>
				<div class="clear"></div>
			<?php endif;?>	
			
			<?php $i++;?>
			
			<?php 
				if($i > 10){
					break;
				}
			?>
		<?php endforeach;?>
	</div>
</div>