<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<style>
	.user-profile-friendlist .friend-item-s{
		width:100px;
	}
</style>
<?php 
	$is_async = $this->input->get('is_async','');
	$total = count( $this->friend_m->getAllFriends($userdataobj->id_user) );
	
	$offset = intval( $this->input->get('per_page',0) );
	
	$rec_per_page = $GLOBALS['global']['PAGINATE']['rows_per_page'] * 5; //$GLOBALS['global']['PAGINATE']['rec_per_page']
	$myFriends = $this->friend_m->getAllFriends($userdataobj->id_user,$offset,$rec_per_page);
	
	$pagination = create_pagination( 
					$uri = "{$userdataobj->username}/friends/?is_async=1", 
					$total_rows = $total , 
					$limit= $rec_per_page,
					$uri_segment = 0,
					TRUE, TRUE 
				);
?>

<?php if(!$is_async):?>
<div id="userFriendListAsync">
<?php endif;?>

	<h3>Friends (<?php echo $total;?>)</h3>
	
	<div class="box-profile user-profile-friendlist">
		 
		<?php $i=1; foreach($myFriends as $item):?>
			<div class="friend-item-s">
				<div class="user-profile-avatar">
					<a href="<?php echo $this->user_m->getUserHomeLink($item->id_user);?>">
						<img src="<?php echo $this->user_m->getProfileAvatar($item->id_user);?>" />
					</a>
				</div>
				<div class="user-profile-username">
					<?php echo $this->user_m->getProfileDisplayName($item->id_user);?>
				</div>
				<div class="user-profile-agesex">
					<?php echo $item->cal_age;?>, <?php echo $item->gender;?>
				</div>
				<div class="user-profile-location">
					<?php 
						if($item->state){
							echo $item->state.', ';
						}
						if($item->country){
							echo $item->country;
						}
					?>
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
				$('#userFriendListAsync').html(res);
				return false;
			});
			 
			return false;
		});
	});
</script>