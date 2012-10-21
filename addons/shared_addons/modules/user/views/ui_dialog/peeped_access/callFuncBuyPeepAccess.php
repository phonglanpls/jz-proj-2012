<?php defined('BASEPATH') or exit('No direct script access allowed');?>

<?php 
	$userdataobj = getAccountUserDataObject(true);
	$id_user = $this->input->get('id_user',0);
	$sellerdataobj = $this->user_io_m->init('id_user',$id_user);
	
	$days = 1;
	
	$amountfee = $days*$sellerdataobj->peep_access;
	$cash = $userdataobj->cash;
	
	$context = $this->input->get('context');
?>

<?php if( $this->peepbought_history_m->wasIBoughtPeepedUser($id_user)):?>
	<script type="text/javascript">
		$(function(){
			$('#hiddenElement').dialog('close');
			callFuncShowPeepedAccess(<?php echo $id_user;?>);
		});
	</script>
	
	<?php exit;?>
<?php endif;?>

<?php if($cash < $amountfee):?>
	Your J$ cash (<?php echo $cash;?>) isn't enough to access peeped.	<br />
    <a href="javascript:void(0);" style="color: #3FAFFE;" onclick="callFuncTrialPay_addCampaign('<?php echo buildTrialPayParam('PEEPED');?>','PEEPED',<?php echo $id_user;?>);">Add your J$ cash here</a>
<?php else:?>
	
	
	<input type="hidden" id="actionFlag" name="actionFlag" value="0"/>
	<input type="hidden" id="context" name="context" value="<?php echo $context;?>"/>
	
	<div id="wrapUI">

		<div class="wrap-left" style="width:100px;">
			<div class="user-profile-avatar">
				<img src="<?php echo $this->user_m->getProfileAvatar($id_user);?>" />
			</div>
			<div class="user-profile-username">
				<?php echo $this->user_m->getProfileDisplayName($id_user);?>
			</div>
		</div>

		<div class="wrap-right">
			<div class="user-profile-owner">
				You have <?php echo currencyDisplay($cash);?>J$ in cash.
			</div>
			<div class="user-profile-button">
				<a href="javascript:void(0);" onclick="callFuncSubmitBuyPeepedAccess(<?php echo $days;?>,<?php echo $id_user;?>);" >
					Who Peep Me <?php echo currencyDisplay($amountfee);?>J$ for 24h
				</a>	
			</div>
			<div class="user-profile-button">
				<a href="javascript:void(0);" onclick="javascript:$('#hiddenElement').dialog('close');" >
					Cancel
				</a>	
			</div>
			<?php echo loader_image_s("id=\"buyPeepedAccessContextLoader\" class='hidden'");?>
		</div>
		
	</div>

<?php endif;?>