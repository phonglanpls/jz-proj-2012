<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>

<script type="text/javascript" src="<?php echo site_url();?>/media/js/my_backstage.js"></script> 

<?php
	if($this->input->get('task') == 'del'){
		$result = $this->backstage_m->deleteMyBackstagePhoto($this->input->get('id'));
	}
	$myphoto = $this->backstage_m->getMyBackstagePhoto();
	$path = site_url()."image/thumb/photos/";
?>

<?php if(isset($result) AND $result == false):?>
	
<script type="text/javascript">		
	$(document).ready(function(){
		sysWarning("<?php echo language_translate('my_backstage_change_profile_alert');?>");
	});
</script>

<?php endif;?>

<div  style="margin-bottom:10px;">
	<a class="button" href="javascript:void(0);" onclick="callFuncLoadUploadMyBackstagePhoto();"><?php echo language_translate('show_backstage_upload_backstg');?></a>
	<?php echo loader_image_s("id='uploadmyPhotoContextLoader' class='hidden'");?>
</div>
<div class="clear sep"></div>

<?php if(! count($myphoto)) :?>
	<?php echo language_translate('my_backstage_message_backstg');?>
<?php else: ?>
	<?php $i=1; foreach($myphoto as $item):?>
		<div class="friend-item">
			<div class="user-profile-avatar async-loading">
				<a href="<?php echo site_url("user/backstage/show_my_backstage/{$item->id_image}/?is_async=1");?>">
					<img src="<?php echo $path.$item->image; ?>" />
				</a>
			</div>
			<div class="obj-item">
				<?php echo maintainHtmlBreakLine($item->comment);?>
			</div>
			
			<div class="obj-item">
				<?php echo currencyDisplay($item->price).JC;?> 
			</div>
			
			<div class="obj-item">
				<b><?php echo language_translate('show_backstage_views');?> </b>
                
                <?php if($item->v_count):?>
					<a href="javascript:void(0);" onclick="callFuncShowAllUsersViewedBackstagePhoto(<?php echo $item->id_image?>);" >
						[ <?php echo $item->v_count;?> ]
					</a>
				<?php endif;?>
			</div>
			
			<div class="obj-item">
				<b><?php echo language_translate('show_backstage_comments');?> </b>
				<?php if($item->comments):?>
					<a href="javascript:void(0);" onclick="callFuncShowAllCommentBackstagePhoto(<?php echo $item->id_image?>,'<?php echo mysql_real_escape_string($item->comment);?>');" >
						[ <?php echo $item->comments;?> ]
					</a>
				<?php endif;?>
			</div>
			
			<div class="obj-item">
				<b><?php echo language_translate('show_backstage_rating');?> </b><?php if( $tmp = $this->rate_m->getRateScore($item->id_image) ) echo ($tmp);?>
			</div>
			
			<div class="user-profile-button">
				<a href="javascript:void(0);" onclick="callFuncEditMyBackstagePhoto(<?php echo $item->id_image;?>);"><?php echo language_translate('sys_button_title_edit');?></a>
			</div>
			
			<div class="user-profile-button">
				<a href="javascript:void(0);" onclick="return sysConfirm('<?php echo language_translate('sys_button_delete_confirm');?>','callFuncDeleteMyBackstagePhoto(<?php echo $item->id_image;?>)');"><?php echo language_translate('sys_button_title_delete');?></a>
			</div>
		</div>
		
		<?php if($i %4 == 0):?>
			<div class="clear"></div>
		<?php endif;?>
		
		<?php $i++;?>
		
	<?php endforeach;?>	
<?php endif;?>	

<div class="clear"></div>