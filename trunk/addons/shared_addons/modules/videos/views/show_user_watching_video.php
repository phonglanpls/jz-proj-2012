<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>

<?php 
	$mode = $this->input->get('mode');
	if($mode != 'all'){
		$mode = 'default';
	}
	
	$this->watching_video_m->updateWatchingStatus($video_id);
	$watchingUser = $this->watching_video_m->getUserWatchingVideoOnline($video_id,30);
?>

<?php if(count($watchingUser)):?>
	<h3>Watching Video</h3>
	
	<div class="filter-split" style="border:1px solid #cfcfcf;position:relative;">
		
		<?php $i=1; foreach($watchingUser as $item):?>
			
			<div class="friend-item-s" id="itemID_<?php echo $item->user_id;?>">
				
				<div class="user-profile-avatar">
					<img src="<?php echo $this->user_m->getProfileAvatar($item->user_id);?>" />
				</div>
				
				<div class="user-profile-username">
					<?php echo $this->user_m->getProfileDisplayName($item->user_id);?>
				</div>
				
			</div>
			
			<?php if( $i%5 == 0 ):?>
				<div class="clear"></div>
			<?php endif;?>	
			
			<?php $i++;?>	
			
			<?php 
				if($mode != 'all'){
					if($i>5){
						break;
					}
				}
			?>
		<?php endforeach;?>
		
		<?php if(count($watchingUser) > 5):?>
			<div style="position:absolute;right:10px;top:5px;">
				<?php echo loader_image_s("id='showAllWatchingContextLoader' class='hidden'");?>
				<a href="javascript:void(0);" onclick="callFuncShowAllWatchingUser(<?php echo $video_id;?>)">Show All</a>
			</div>
		<?php endif;?>
		
		<div class="clear"></div>
	</div>

<?php endif;?>

<script type="text/javascript">
    WATCHING_MODE = '<?php echo $mode;?>';
</script>