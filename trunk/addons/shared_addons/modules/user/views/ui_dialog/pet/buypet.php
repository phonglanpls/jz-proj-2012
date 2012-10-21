<?php defined('BASEPATH') or exit('No direct script access allowed');?>

<?php 
	$id_pet = $this->input->get('id_user',0);
	$ownerdataobj = $this->user_io_m->init('id_user',getAccountUserId());
	$petdataobj	  = $this->user_io_m->init('id_user', $id_pet);

	$uid = $id_pet;
	$curval = $this->user_m->calculatePetPrice($id_pet);
	$cash = $ownerdataobj->cash;
	$fcval = $petdataobj->cur_value;
	$username = $petdataobj->username;
	$usercash = $petdataobj->cash;
	
	$petinfo = $this->pet_io_m->fetchRecord($id_pet);
	
	$context = $this->input->get('context');
?>
<?php if($petdataobj->owner == getAccountUserId()):?>
    <?php echo $petdataobj->username?> was already your pet.
<?php elseif($cash < $curval):?>
	Your J$ cash (<?php echo $cash;?>) isn't enough to buy this pet.  <br />
    <a href="javascript:void(0);" style="color: #3FAFFE;" onclick="callFuncTrialPay_addCampaign('<?php echo buildTrialPayParam('PETBUY');?>','PETBUY',<?php echo $id_pet;?>);">Add your J$ cash here</a>
<?php elseif($petinfo->lockstatus==1):?>
	This pet was locked. You can not buy.	
<?php else:?>

	<input type="hidden" id="buyFlag" name="buyFlag" value="0"/>
	<input type="hidden" id="context" name="context" value="<?php echo $context;?>"/>
	
	<div id="wrapUI">

		<div class="wrap-left" style="width:100px;">
			<div class="user-profile-avatar">
				<img src="<?php echo $this->user_m->getProfileAvatar($id_pet);?>" />
			</div>
			
		</div>

		<div class="wrap-right">
			<div class="user-profile-owner">
				Buy <?php echo $username;?> As a Pet <br/>
				You have <?php echo $cash;?>J$ in cash.
			</div>
			<div class="user-profile-button">
				<a href="javascript:void(0);" onclick="callFuncSubmitInfoBuyPet(<?php echo $id_pet;?>);" >
					Buy For <?php echo $this->user_m->calculatePetPrice($id_pet);?>J$
				</a>	
			</div>
			<?php echo loader_image_s("id=\"buyPetContextLoader\" class='hidden'");?>
		</div>
		
	</div>

<?php endif;?>