<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>

<?php 
	$keyword = $this->input->get('keyword','');
	$cat = $this->input->get('cat','');
	$offset = intval( $this->input->get('per_page',0) );
	
	$total = count( $this->backstage_m->getBackstageList($cat,$keyword) );
	
	$rec_per_page = $GLOBALS['global']['PAGINATE']['rows_per_page'] * 4; //$GLOBALS['global']['PAGINATE']['rec_per_page']
	$backstageList = $this->backstage_m->getBackstageList($cat,$keyword,$offset,$rec_per_page);
	
	$pagination = create_pagination( 
					$uri = "user/backstage/?is_async=1&cat=$cat&keyword=$keyword", 
					$total_rows = $total , 
					$limit= $rec_per_page,
					$uri_segment = 0,
					TRUE, TRUE 
				);
				
	$path = site_url()."image/thumb/photos/";	

	//print_r($backstageList);
?>

<div  style="margin-bottom:10px;">
	<a class="button" href="javascript:void(0);" onclick="callFuncLoadUploadMyBackstagePhoto();"><?php echo language_translate('show_backstage_upload_backstg');?></a>
	<?php echo loader_image_s("id='uploadmyPhotoContextLoader' class='hidden'");?>
</div>

<div class="clear sep"></div>

<?php if(! count($backstageList)) :?>
	<?php echo language_translate('show_backstage_message_backstg');?>
<?php else: ?>
	<?php $i=1; foreach($backstageList as $item):?>
		<div class="friend-item">
			<div class="user-profile-avatar">
				<?php if($this->collection_m->isMyCollectionPhoto($item->id_image)):?>
					<img src="<?php echo $path.$item->image; ?>" />
				<?php else:?>
					<?php echo lock_image(true);?>
				<?php endif;?>
			</div>
			
			<div class="user-profile-username">
				<?php echo $this->user_m->getProfileDisplayName($item->id_user);?>
			</div>
			
			<div class="obj-item">
				<?php echo maintainHtmlBreakLine($item->comment);?>
			</div>
			
			<div class="obj-item">
				<b><?php echo language_translate('show_backstage_views');?> </b><?php if($item->v_count) echo $item->v_count;?>
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
			
			<?php if(! $this->collection_m->isMyCollectionPhoto($item->id_image)):?>
				<div class="user-profile-button">
					<a href="javascript:void(0);" onclick="callFuncBuyThisBackstagePhoto(<?php echo $item->id_image;?>)">
						<?php echo language_translate('show_backstage_buyfor');?> <?php echo currencyDisplay($item->price).JC;?> 
					</a>
				</div>
			<?php endif;?>
			
			<div class="clear"></div>
		</div>
		
		<?php if($i %4 == 0):?>
			<div class="clear"></div>
		<?php endif;?>
		
		<?php $i++;?>
		
	<?php endforeach;?>	
<?php endif;?>	

<div class="clear"></div>

<div class="pagination">
	<?php echo $pagination['links'];?>
	<?php echo loader_image_s("id=\"paginationContextLoader\" class='hidden'");?>
</div>	








