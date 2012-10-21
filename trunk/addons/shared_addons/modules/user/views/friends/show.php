<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>

<?php 
	if(!isset($_GET['search_flag'])){
		$myFriends = $this->friend_m->getAllFriends(getAccountUserId());
	}else{
		$myFriends = $this->friend_m->_search_bycat(
				getAccountUserId(), 
				$this->input->get('bygroup',''),
				$this->input->get('bygender',''),
				$this->input->get('byage',''),
				$this->input->get('bylocation','')
			);
	}
?>

<?php $i=1; foreach($myFriends as $item):?>
	<div class="friend-item" id="itemID_<?php echo $item->id_user;?>">
		<div class="user-profile-avatar">
			<a href="<?php echo $this->user_m->getUserHomeLink($item->id_user);?>">
				<img src="<?php echo $this->user_m->getProfileAvatar($item->id_user);?>" />
			</a>
		</div>
		<div class="user-profile-username">
			<?php echo $this->user_m->getProfileDisplayName($item->id_user);?>
		</div>
		<div class="user-profile-agesex">
			<strong>Age/Sex:</strong> <?php echo $item->cal_age;?>, <?php echo $item->gender;?>
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
		<div class="user-profile-button">
			<a href="javascript:void(0);" onclick="callFuncUnfriend(<?php echo $item->id_user;?>);">
				Unfriend
			</a>
		</div>
		
	</div>
	
	<?php if( $i%4 == 0 ):?>
		<div class="clear"></div>
	<?php endif;?>	
	
	<?php $i++;?>
<?php endforeach;?>