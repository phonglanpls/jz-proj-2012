<?php defined('BASEPATH') or exit('No direct script access allowed');?>

<?php 
	$userdataobj = getAccountUserDataObject(true);
	$id_video = $this->input->get('id_video',0);
	$videodata = $this->mod_io_m->init('id_video',$id_video,TBL_VIDEO);
	
	$amountfee = $GLOBALS['global']['COST']['download_hentai'];
	$cash = $userdataobj->cash;
?>

<?php if($cash < $amountfee):?>
	Your J$ cash (<?php echo $cash;?>) isn't enough to download video.	<br />
    <a href="javascript:void(0);" style="color: #3FAFFE;" onclick="callFuncTrialPay_addCampaign('<?php echo buildTrialPayParam('DOWNLOAD');?>','DOWNLOAD',<?php echo $id_video;?>);">Add your J$ cash here</a>
<?php else:?>

	<input type="hidden" id="actionFlag" name="actionFlag" value="0"/>

	<div id="wrapUI" style="position:relative;">

		<div class="wrap-left" style="width:110px;">
			<div class="user-profile-avatar">
				<img src="<?php echo $videodata->img_url;?>" width="90px" height="60px;" />
			</div>
			<div class="user-profile-username">
				<?php echo $videodata->name;?>
			</div>
		</div>

		<div class="wrap-right">
			<div class="user-profile-owner">
				You have <?php echo currencyDisplay($cash);?>J$ in cash.
			</div>
			<div class="user-profile-button">
				<a href="javascript:void(0);" onclick="callFuncSubmitDownloadVideo(<?php echo $id_video;?>);" >
					Download Video For <?php echo currencyDisplay( $GLOBALS['global']['COST']['download_hentai'] );?>J$
				</a>	
			</div>
			<div class="user-profile-button">
				<a href="javascript:void(0);" onclick="javascript:$('#hiddenElement').dialog('close');" >
					Cancel
				</a>	
			</div>
			<?php echo loader_image_s("id=\"downloadVideoContextLoader\" class='hidden'");?>
		</div>
		
	</div>

<?php endif;?>

<script type="text/javascript">
	var downloading = 0;
</script>