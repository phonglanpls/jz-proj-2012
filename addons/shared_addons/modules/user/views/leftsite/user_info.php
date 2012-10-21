<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>

<?php 
	$userdataobj = getAccountUserDataObject(true);
	$is_async = $this->input->get('is_async','');
?>

<?php if(!$is_async): ?>
	<div id="myProfileAsync">
<?php endif; ?>

<div class="box-profile">
	<div class="left">
		<a href="<?php echo $this->user_m->getUserHomeLink($userdataobj->id_user);?>" class="thumb"><img class="image" src="<?php echo $this->user_m->getProfileAvatar(getAccountUserId());?>" alt="" title=""></a>
	</div>
	<div class="right">
		<h3>
			<?php echo $this->user_m->getProfileDisplayName(getAccountUserId());?>
			
		</h3>
		<p><?php echo language_translate('left_menu_label_cash');?> <?php echo $this->user_m->getCash(getAccountUserId());?>
	       <br />
		 <?php echo language_translate('left_menu_label_value');?> <?php echo $this->user_m->getValue(getAccountUserId());?>  
           <br /> <br /> 
		<a href="javascript:void(0);" onclick="callFuncTrialPay_addCampaign('<?php echo buildTrialPayParam('TOPLEFT');?>');">Add J$</a></p>
	</div>
	<div class="clear"></div>
</div>

<?php if(!$is_async): ?>
	</div>
<?php endif; ?>