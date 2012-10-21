<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>

<script type="text/javascript" src="<?php echo site_url();?>/media/js/pet.js"></script> 

<?php 
	$myWishList = $this->wishlist_m->fetchMyWishlist(getAccountUserId());
?>

<?php if(! $count = count($myWishList)):?>
	<p class="msg"><?php echo language_translate('left_menu_label_wishlist_msg');?></p>
<?php endif;?>

<div id="myWishListBox">
	<?php foreach($myWishList as $item):?>
		<div class="wishlist-item" id="wishLISTid_<?php echo $item->id_user;?>">
			<div class="wrap-left">
				<div class="user-profile-avatar">
					<a href="<?php echo $this->user_m->getUserHomeLink($item->id_user);?>">
						<img src="<?php echo $this->user_m->getProfileAvatar($item->id_user);?>" />
					</a>	
				</div>
				
				<div class="clear"></div>
				
				<div class="user-profile-username">
					<?php echo $this->user_m->getProfileDisplayName($item->id_user);?>
				</div>
			</div>
			
			<div class="wrap-right">
				<div class="user-profile-button">
					<a href="javascript:void(0);" onclick="callFuncAddThisPet(<?php echo $item->id_user;?>)">
						<?php echo language_translate('left_menu_label_buy_for');?> <?php echo $this->user_m->calculatePetPrice($item->id_user).JC;?> 
					</a>
				</div>
				
				<div class="clear"></div>
				
				<div class="user-profile-button" id="wishlistBoxDivID_<?php echo $item->id_user;?>">
					<a href="javascript:void(0);" onclick="callFuncRemoveFromWishList(<?php echo $item->id_user;?>);">
						<?php echo language_translate('wishlist_remove');?>
					</a>
				</div>
			</div>
			<div class="clear"></div>
		</div>
		<div class="clear"></div>
	<?php endforeach;?>
</div>
