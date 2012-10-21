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
	$userdataobj = getAccountUserDataObject();
	$myPetList = $this->pet_m->pet_list($userdataobj->id_user);
?>


<?php if(! $count=count($myPetList)):?>
	<h4><?php echo language_translate('left_menu_label_petlist');?></h4>
	<p class="msg"><?php echo language_translate('left_menu_label_petlist_msg');?></p>
<?php else: ?>
	<h4><?php echo language_translate('left_menu_label_petlist');?>(<?php echo $count;?>)</h4>	
	<div class="extra-link">
		<a href="<?php echo site_url("user/mypets");?>"><?php echo language_translate('left_menu_label_viewall');?></a>
	</div>
<?php endif;?>


<div id="myPetListBox">
	<?php $i=1; foreach($myPetList as $item):?>
		<div class="friend-item-s" id="myPetDiV_<?php echo $item->id_user;?>">
				<div class="user-profile-avatar">
					<a href="<?php echo $this->user_m->getUserHomeLink($item->id_user);?>">
						<img src="<?php echo $this->user_m->getProfileAvatar($item->id_user);?>" />
					</a>
				</div>
				<div class="user-profile-username">
					<?php echo $this->user_m->getProfileDisplayName($item->id_user);?>
				</div>
				
				<div class="user-profile-cash">
					<strong><?php echo language_translate('left_menu_label_cash');?></strong> <?php echo $this->user_m->getCash($item->id_user);?>
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
