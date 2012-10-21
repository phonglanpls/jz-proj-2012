<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>

<?php 
	$id_photo = $this->input->get('id_photo',0);
	$gallerydata = $this->gallery_io_m->init('id_image',$id_photo);
	$path = site_url()."image/thumb/photos/";	
	$userdataobj = getAccountUserDataObject(true);
    $cash = $userdataobj->cash;
?>

<?php if($cash < $gallerydata->price):?>
	Your J$ cash (<?php echo $cash;?>) isn't enough to buy this photo.	<br />
    <a href="javascript:void(0);" style="color: #3FAFFE;" onclick="callFuncTrialPay_addCampaign('<?php echo buildTrialPayParam('BACKSTAGE');?>','BACKSTAGE',<?php echo $id_photo;?>);">Add your J$ cash here</a>
<?php else:?>

<input type="hidden" name="buyingBackstage" id="buyingBackstage" value="0" />

<div id="wrapUI">
	<div class="wrap-left">	
		<div class="friend-item">
			<div class="user-profile-avatar">
				<?php if($this->collection_m->isMyCollectionPhoto($id_photo)):?>
					<img src="<?php echo $path.$gallerydata->image; ?>" />
				<?php else:?>
					<?php echo lock_image(true);?>
				<?php endif;?>
			</div>
			
			<div class="user-profile-username">
				<?php echo $this->user_m->getProfileDisplayName($gallerydata->id_user);?>
			</div>
			
			<div class="obj-item">
				<?php echo $gallerydata->comment;?>
			</div>
		</div>
	</div>
	
	<div class="wrap-right" style="width:130px;">		
		<?php if(! $this->collection_m->isMyCollectionPhoto($id_photo)):?>
			<div class="obj-item">
				You have <?php echo currencyDisplay($userdataobj->cash);?>J$ in cash.
			</div>
			
			<div class="user-profile-button">
				<a href="javascript:void(0);" onclick="callFuncSubmitBuyBackstagePhoto(<?php echo $id_photo;?>)">
					Buy For <?php echo currencyDisplay($gallerydata->price);?>J$
				</a>
			</div>
			
			<div class="user-profile-button">
				<a href="javascript:void(0);" onclick="siteLoadingDialogOff();$('#hiddenElement').dialog('close');">
					Cancel
				</a>
			</div>
			
			<div class="obj-item">
				<?php echo loader_image_s("id='buyBackstageContextLoader' class='hidden'");?>
			</div>
			
		<?php else:?>
			<div class="obj-item">
				This photo was in your collection.	
			</div>	
		<?php endif;?>
		<div class="clear"></div>
	</div>	
	
	<div class="clear"></div>
</div>	

<?php endif;?>