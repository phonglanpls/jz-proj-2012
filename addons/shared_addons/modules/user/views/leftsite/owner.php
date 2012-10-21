<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>

<style>
	.profile-picture,
	.owner-info{
		float:left;
		margin-bottom:10px;
	}
	.owner-info{
		margin-left:10px;
		margin-top:20px;
	}
</style>
<?php 
	$owner_id = $this->user_m->getMyOwnerId(getAccountUserId());
?>
<div class="widget" style="position:relative;">
	<div class="profile-picture">
		<a href="<?php echo $this->user_m->getUserHomeLink($owner_id);?>">
			<img src="<?php echo $this->user_m->getProfileAvatar($owner_id);?>" />
		</a>
	</div>
	<div class="owner-info">
		<strong><?php echo language_translate('left_menu_label_owner');?></strong> <?php echo $this->user_m->getProfileDisplayName($owner_id);?> <br/>
		<strong><?php echo language_translate('left_menu_label_cash');?></strong> <?php echo $this->user_m->getCash($owner_id);?> 
	</div>
</div>