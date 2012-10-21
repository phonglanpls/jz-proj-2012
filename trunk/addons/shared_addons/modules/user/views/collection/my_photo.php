<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>

<?php
	if($this->input->get('task') == 'del'){
		$result = $this->collection_m->deleteMyPhoto($this->input->get('id'));
	}
	$myphoto = $this->collection_m->getMyPhoto();
	$path = site_url()."image/thumb/photos/";
?>

<?php if(isset($result) AND $result == false):?>
	
<script type="text/javascript">		
	$(document).ready(function(){
		sysWarning("<?php echo language_translate('my_photo_change_profile_alert');?>");
	});
</script>

<?php endif;?>

<div  style="margin-bottom:10px;">
	<a class="button" href="javascript:void(0);" onclick="callFuncLoadUploadMyPhoto();"><?php echo language_translate('my_photo_label_upload_photo');?></a>
	<?php echo loader_image_s("id='uploadmyPhotoContextLoader' class='hidden'");?>
</div>
<div class="clear sep"></div>

<?php if(! count($myphoto)) :?>
	<?php echo language_translate('photo_collection_message');?>
<?php else: ?>
	<?php $i=1; foreach($myphoto as $item):?>
		<?php $class = ($item->prof_flag==1)? ' red-border':'';?>
		<div class="friend-item<?php echo $class;?>">
			<div class="user-profile-avatar async-loading">
				<a href="<?php echo site_url("user/photos/{$item->id_image}/?is_async=1");?>">
					<img src="<?php echo $path.$item->image; ?>" />
				</a>
			</div>
			<div class="obj-item">
				<?php echo maintainHtmlBreakLine($item->comment);?>
			</div>
			
			<div class="user-profile-button">
				<a href="javascript:void(0);" onclick="callFuncShowActionDialogMyPhoto(<?php echo $item->id_image;?>);"><?php echo language_translate('sys_button_title_action');?></a>
			</div>
			
			<div class="user-profile-button">
				<a href="javascript:void(0);" onclick="return sysConfirm('<?php echo language_translate('sys_button_delete_confirm');?>','callFuncDeleteMyPhoto(<?php echo $item->id_image;?>)');"><?php echo language_translate('sys_button_title_delete');?></a>
			</div>
		</div>
		
		<?php if($i %4 == 0):?>
			<div class="clear"></div>
		<?php endif;?>
		
		<?php $i++;?>
		
	<?php endforeach;?>	
<?php endif;?>	

<div class="clear"></div>