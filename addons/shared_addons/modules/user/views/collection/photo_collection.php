<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>

<?php
	if($this->input->get('task') == 'del'){
		$this->collection_m->deleteCollectionPhoto($this->input->get('id'));
	}
	$collection = $this->collection_m->getCollectionPhoto();
	$path = site_url()."image/thumb/photos/";
?>

<?php if(! count($collection)) :?>
	<?php echo language_translate('photo_collection_message');?>
<?php else: ?>
	<?php $i=1; foreach($collection as $item):?>
		<div class="friend-item">
			<div class="user-profile-avatar async-loading">
				<a href="<?php echo site_url("user/photos/backstage/{$item->id_image}/?is_async=1");?>">
					<img src="<?php echo $path.$item->image; ?>" />
				</a>
			</div>
			<div class="user-profile-username">
				<?php echo $this->user_m->getProfileDisplayName($item->ownerid);?>
			</div>
			<div class="obj-item">
				<?php echo maintainHtmlBreakLine($item->comment);?>
			</div>
			<div class="user-profile-button">
				<a href="javascript:void(0);" onclick="return sysConfirm('<?php echo language_translate('sys_button_delete_confirm');?>','callFuncDeleteCollectionPhoto(<?php echo $item->id_collection;?>)');"><?php echo language_translate('sys_button_title_delete');?></a>
			</div>
		</div>
		
		<?php if($i %4 == 0):?>
			<div class="clear"></div>
		<?php endif;?>
		
		<?php $i++;?>
		
	<?php endforeach;?>	
<?php endif;?>	

<div class="clear"></div>