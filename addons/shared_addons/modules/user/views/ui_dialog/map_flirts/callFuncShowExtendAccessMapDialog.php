<?php defined('BASEPATH') or exit('No direct script access allowed');?>

<?php 
	$userdataobj = getAccountUserDataObject(true);
	$id_user = $this->input->get('id_user',0);
	$sellerdataobj = $this->user_io_m->init('id_user',$id_user);
	
	$days = $this->input->get('days',0);
	
	$amountfee = $days*$sellerdataobj->map_access;
	$cash = $userdataobj->cash;
	
	$context = $this->input->get('context');
	$historydata = $this->mapflirt_m->getHistory($id_user);
?>

<?php if($cash < $amountfee OR $context == 'ADDCASH'):?>
	Your J$ cash (<?php echo $cash;?>) isn't enough to access map flirt.	<br />
    <a href="javascript:void(0);" style="color: #3FAFFE;" onclick="callFuncTrialPay_addCampaign('<?php echo buildTrialPayParam('MAPFLIRTS');?>','MAPFLIRTS',<?php echo $id_user;?>);">Add your J$ cash here</a>
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
				<a href="javascript:void(0);" onclick="callFuncSubmitExtendAccessMapFlirts(<?php echo $days;?>,<?php echo $id_user;?>);" >
					Access For <?php echo currencyDisplay($amountfee);?>J$
				</a>	
			</div>
			<?php if($context == 'CMCHAT' AND $historydata AND mysql_to_unix($historydata->exp_date) > mysql_to_unix(mysqlDate()) ):?>
				<div class="user-profile-button">
					<a href="javascript:void(0);" onclick="$('#hiddenElement').dialog('close');callFuncShowAccessMap_SELLER(<?php echo $id_user;?>);" >
						Access Map Location
					</a>	
				</div>
			<?php endif;?>
			<div class="user-profile-button">
				<a href="javascript:void(0);" onclick="javascript:$('#hiddenElement').dialog('close');" >
					Cancel
				</a>	
			</div>
			<?php echo loader_image_s("id=\"extendAccessMapContextLoader\" class='hidden'");?>
		</div>
		
	</div>

<?php endif;?>