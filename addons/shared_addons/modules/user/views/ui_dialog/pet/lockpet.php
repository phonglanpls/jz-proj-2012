<?php defined('BASEPATH') or exit('No direct script access allowed');?>

<?php 
	$pet_id = $this->input->get('pet_id');
	$lock_id = $this->input->get('lock_id');
	$day = $this->input->get('day');
	
	$lockinfodata = $this->lock_m->getLockRecord($lock_id);
	$ownerdataobj = $this->user_io_m->init('id_user',getAccountUserId());
	$petdataobj = $this->user_io_m->init('id_user',$pet_id);
	
	$totalprice = $lockinfodata->price*$day*$lockinfodata->chargeperday;
	$mycash = $ownerdataobj->cash;

?>

<?php if($mycash < $totalprice):?>
	Your J$ cash (<?php echo $mycash;?>) isn't enough to lock this pet.  <br />
    <a href="javascript:void(0);" style="color: #3FAFFE;" onclick="callFuncTrialPay_addCampaign('<?php echo buildTrialPayParam('PETLOCK');?>','PETLOCK',<?php echo $pet_id;?>,<?php echo $lock_id;?>,<?php echo $day;?>);">Add your J$ cash here</a>
<?php else:?>

	<input type="hidden" id="lockFlag" name="lockFlag" value="0"/>

	<div id="wrapUI">

		<div class="wrap-left" style="width:100px;">
			<div class="user-profile-avatar">
				<img src="<?php echo $this->user_m->getProfileAvatar($pet_id);?>" />
			</div>
		</div>

		<div class="wrap-right">
			<div class="user-profile-owner">
				Lock pet: <b><?php echo $petdataobj->username;?></b><br/>
				Total price to lock: <?php echo currencyDisplay($totalprice);?>J$ <br/>
				You have <?php echo currencyDisplay($mycash);?>J$ in cash.
			</div>
			<div class="user-profile-button">
				<a href="javascript:void(0);" onclick="callFuncSubmitLockPet(<?php echo $pet_id;?>,<?php echo $lock_id;?>,<?php echo $day;?>);" >
					Lock
				</a>	
			</div>
			<?php echo loader_image_s("id=\"lockPetContextLoader\" class='hidden'");?>
		</div>
		
	</div>

<?php endif;?>