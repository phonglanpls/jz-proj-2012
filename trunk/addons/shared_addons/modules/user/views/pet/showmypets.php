<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>

<?php 
	$userdataobj = getAccountUserDataObject();
	$myPetList = $this->pet_m->pet_list($userdataobj->id_user);
?>

<?php 
	if(!count($myPetList))
		echo "There is no one in your pet list";
?>


<?php $i=1; foreach($myPetList as $item):?>
	<div class="friend-item" id="itemID_<?php echo $item->id_user;?>">
		<div class="user-profile-avatar">
			<a href="<?php echo $this->user_m->getUserHomeLink($item->id_user);?>">
				<img src="<?php echo $this->user_m->getProfileAvatar($item->id_user);?>" />
			</a>
		</div>
		
		<div class="user-profile-username">
			<?php echo $this->user_m->getProfileDisplayName($item->id_user);?>
		</div>
		
		<div class="user-profile-cash">
			<strong>Cash:</strong> <?php echo $this->user_m->getCash($item->id_user);?>
		</div>
		
		<div class="user-profile-owner">
			<strong>Lock pet:</strong> <input type="radio" name="pet" value="<?php echo $item->id_user;?>"/>
		</div>
		
		<div id="lockedPetInfo_<?php echo $item->id_user;?>">
			<?php if($item->lockstatus == 1):?>
				Locked pet to:
				<?php echo juzTimeDisplay( $item->lockexp_date );?>
			<?php endif;?>
		</div>
		
		<div class="clear"></div>
	</div>
	
	<?php if( $i%4 == 0 ):?>
		<div class="clear"></div>
	<?php endif;?>	
	
	<?php $i++;?>
<?php endforeach;?>
