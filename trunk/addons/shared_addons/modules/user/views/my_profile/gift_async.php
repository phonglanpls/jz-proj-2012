<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<style>
	.user-profile-friendlist .friend-item-s{
		width:100px;
	}
</style>
<?php 
	$is_async = $this->input->get('is_async','');
	$total = count( $this->gift_m->getAllUserGifts($userdataobj->id_user) );
	 
	$offset = intval( $this->input->get('per_page',0) );
	
	$rec_per_page = $GLOBALS['global']['PAGINATE']['rows_per_page'] * 5; //$GLOBALS['global']['PAGINATE']['rec_per_page']
	$myGift = $this->gift_m->getAllUserGifts($userdataobj->id_user,$offset,$rec_per_page);
	
	$pagination = create_pagination( 
					$uri = "user/my_profile/gift_list/?is_async=1", 
					$total_rows = $total , 
					$limit= $rec_per_page,
					$uri_segment = 0,
					TRUE, TRUE 
				);
	$path = site_url()."image/thumb/gift/";			
?>

<?php if(!$is_async):?>
<div id="userPetListAsync">
<?php endif;?>

	<h3>My Gifts (<?php echo $total;?>)</h3>
	
	<div class="box-profile user-profile-friendlist">
		 
		<?php $i=1; foreach($myGift as $item):?>
			<div class="friend-item-s">
				 
				<div class="user-profile-avatar">
					<img src="<?php echo $path.$item->image;?>" class="tip" title="<?php echo maintainHtmlBreakLine($item->comment);?>" />
				</div>
				<div class="user-profile-username">
					<b>From:</b> <?php echo $this->user_m->getProfileDisplayName($item->id_sender );?>
				</div>
				
				<div class="user-profile-cash">
					<strong>Price:</strong> <?php echo currencyDisplay($item->price);?>J$
				</div>
			 
			</div>
			
			<?php if( $i%5 == 0 ):?>
				<div class="clear"></div>
			<?php endif;?>	
			
			<?php $i++;?>
			
		<?php endforeach;?>
	 
		<div class="clear"></div>
	</div>
	<div class="clear"></div>
		
	<div class="pagination">
		<?php echo $pagination['links'];?>
		<?php echo loader_image_s("id=\"paginationContextLoader\" class='hidden'");?>
	</div>	

<?php if(!$is_async):?>
</div>
<?php endif;?>


<script type="text/javascript">
	
	$(document).ready(function(){
		$('.pagination a').bind('click',function(){
			$href = $(this).attr('href');
			$('#paginationContextLoader').toggle();
			$.get($href,{},function(res){
				$('#paginationContextLoader').toggle();
				$('#userPetListAsync').html(res);
				return false;
			});
			 
			return false;
		});
		
		$('img.tip[title]').qtip( {
					style:{
								tip:{
									corner: true
									}
						},
				}	
			);
	});
</script>