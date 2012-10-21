<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>

<style>
	
	.user-profile-friendlist .friend-item-s{
		width:95px;
	}
	
</style>


<?php 
	$userfavoritedata = $this->mod_io_m->init('id_user',$userdataobj->id_user,TBL_FAVORITE);
?>
<h3>Basic Info</h3>
<div class="extralink">
	<a href="<?php echo site_url("{$userdataobj->username}/info");?>" >More</a>
</div>

<div class="box-profile user-profile-friendlist">
	<div style="width:48%;float:left;padding:5px 0 0 5px;">
		<?php 
			if($this->friend_m->isMyFriend($userdataobj->id_user) AND notMe($userdataobj->id_user)){
				echo '<b>'.$userdataobj->first_name.' '.$userdataobj->last_name.'</b>';
			}else{
				echo '<b>'.$userdataobj->username.'</b>';
			}
		?>
		
		<div class="clear"></div>
		
		<b>Location:</b> 
		<?php 
			if($this->friend_m->isMyFriend($userdataobj->id_user) AND notMe($userdataobj->id_user)){
				echo $userdataobj->city.', '.$userdataobj->state.', '.$userdataobj->country; 	
			}else{
				echo $userdataobj->country;
			}
		?>
		
		<div class="clear"></div>
		
		<?php 
			if($userfavoritedata AND $userfavoritedata->interested_in){
				echo '<b>Interested in: </b>'.$userfavoritedata->interested_in;
			}
		?>
		
		<div class="clear"></div>
		
		<?php 
			if($userdataobj->rel_status ){
				echo '<b>Relationship status: </b>'.$GLOBALS['global']['REL_STATUS'][$userdataobj->rel_status];
			}
		?>
		
		<div class="clear"></div>
		
		<?php 
			if($userfavoritedata AND $userfavoritedata->language){
				echo '<b>Languages: </b>'.$userfavoritedata->language;
			}
		?>
		
		<div class="clear"></div>
		
		<?php 
			if($userdataobj->about_me){
				echo '<b>About me: </b>'.$userdataobj->about_me;
			}
		?>
		<div class="clear"></div>
	</div>
	
	<div style="width:48%;float:left">
		<?php 
			if($userfavoritedata AND $userfavoritedata->music){
				echo '<b>Music: </b>'.$userfavoritedata->music;
			}
		?>
		
		<div class="clear"></div>
		
		<?php 
			if($userfavoritedata AND $userfavoritedata->book){
				echo '<b>Book: </b>'.$userfavoritedata->book;
			}
		?>
		
		<div class="clear"></div>
		
		<?php 
			if($userfavoritedata AND $userfavoritedata->tvshow){
				echo '<b>TV Show: </b>'.$userfavoritedata->tvshow;
			}
		?>
		
		<div class="clear"></div>
		
		<?php 
			if($userfavoritedata AND $userfavoritedata->videogame){
				echo '<b>Games: </b>'.$userfavoritedata->videogame;
			}
		?>
		
		<div class="clear"></div>
		
		<?php 
			if($userfavoritedata AND $userfavoritedata->activity){
				echo '<b>Activities: </b>'.$userfavoritedata->activity;
			}
		?>
		
		<div class="clear"></div>
		
		<?php 
			if($userfavoritedata AND $userfavoritedata->interests){
				echo '<b>Interests: </b>'.$userfavoritedata->interests;
			}
		?>
		
	</div>
	<div class="clear"></div>
</div>
 
<div class="clear"></div>



<?php 
	$userPublicPhotos = $this->collection_m->getPublicPhotos($userdataobj->id_user);
	$userBackstagePhotos = $this->backstage_m->getUserBackstagePhoto($userdataobj->id_user);
	
	$photopath = site_url()."image/thumb/photos/";
?>

<h3>Photos</h3>

<div class="extralink" style="margin-right:340px;">
	<a href="<?php echo site_url("{$userdataobj->username}/photos");?>" >More photos</a>
</div>

<div class="extralink" style="margin-right:0px;">
	<a href="<?php echo site_url("{$userdataobj->username}/backstages");?>" >More Backstages</a>
</div>

<div class="box-profile user-profile-friendlist">

	<div style="width:50%;float:left">
		
		<?php $i=1; foreach($userPublicPhotos as $item):?>
			<div class="friend-item-s">
				<div class="user-profile-avatar">
					<a href="<?php echo site_url("{$userdataobj->username}/photo/{$item->id_image}")?>">
						<img src="<?php echo $photopath.$item->image;?>" class="tip" title="<?php echo $item->comment;?>" />
					</a>
				</div>
				
			</div>
			
			<?php if( $i%3 == 0 ):?>
				<div class="clear"></div>
			<?php endif;?>	
			
			<?php $i++;?>
			
			<?php 
				if($i > 3){
					break;
				}
			?>
		<?php endforeach;?>
	</div>
	
	
	<div style="width:50%;float:left">
		
		<?php $i=1; foreach($userBackstagePhotos as $item):?>
			<div class="friend-item-s">
				<div class="user-profile-avatar">
					<?php if($this->collection_m->isMyCollectionPhoto($item->id_image)):?>
						<a href="<?php echo site_url("{$userdataobj->username}/backstage_photo/{$item->id_image}")?>">
							<img src="<?php echo $photopath.$item->image; ?>" class="tip" title="<?php echo $item->comment;?>" />
						</a>
					<?php else:?>
						<?php echo lock_image(true,$ext=" class=\"tip\" title=\"{$item->comment}\" ");?>
					<?php endif;?>
				</div>
				
			</div>
			
			<?php if( $i%3 == 0 ):?>
				<div class="clear"></div>
			<?php endif;?>	
			
			<?php $i++;?>
			
			<?php 
				if($i > 3){
					break;
				}
			?>
		<?php endforeach;?>
	</div>
	
	<div class="clear"></div>
</div>



<?php 
	$myFriends = $this->friend_m->getAllFriends($userdataobj->id_user);
?>
<?php if($count=count($myFriends)): ?>
	<h3>Friends List(<?php echo $count;?>)</h3>
	<?php if($count > 6):?>
		<div class="extralink">
			<a href="<?php echo site_url("{$userdataobj->username}/friends");?>" >More</a>
		</div>
	<?php endif;?>	
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
			
			<?php if( $i%6 == 0 ):?>
				<div class="clear"></div>
			<?php endif;?>	
			
			<?php $i++;?>
			
			<?php 
				if($i > 6){
					break;
				}
			?>
		<?php endforeach;?>
	 
		<div class="clear"></div>
	</div>
<?php endif;?>

<div class="clear"></div>












<?php 
	$myPetList = $this->pet_m->pet_list($userdataobj->id_user);
?>

<?php if($count=count($myPetList)): ?>
	<h3>Pets List (<?php echo $count;?>)</h3>
	<?php if($count > 6):?>
		<div class="extralink">
			<a href="<?php echo site_url("{$userdataobj->username}/pet_list");?>" >More</a>
		</div>
	<?php endif;?>	
	
	<div class="box-profile user-profile-friendlist">
		 
		<?php $i=1; foreach($myPetList as $item):?>
			<div class="friend-item-s">
				<div class="user-profile-avatar">
					<a href="<?php echo $this->user_m->getUserHomeLink($item->id_user);?>">
						<img src="<?php echo $this->user_m->getProfileAvatar($item->id_user);?>" />
					</a>
				</div>
				<div class="user-profile-username">
					<?php echo $this->user_m->getProfileDisplayName($item->id_user);?>
				</div>
				
				<div class="user-profile-cash">
					<strong>Cash:</strong> <?php echo $this->user_m->getCash($item->id_user);?>
				</div>
			</div>
			
			<?php if( $i%6 == 0 ):?>
				<div class="clear"></div>
			<?php endif;?>	
			
			<?php $i++;?>
			
			<?php 
				if($i > 6){
					break;
				}
			?>
		<?php endforeach;?>
	 
		<div class="clear"></div>
	</div>
<?php endif;?>

<div class="clear"></div>







<?php 
	$myGiftList = $this->gift_m->getAllUserGifts($userdataobj->id_user);
	$path = site_url()."image/thumb/gift/";	
	
?>	


<?php if($count=count($myGiftList)): ?>
	<h3>Gifts List (<?php echo $count;?>)</h3>
	<?php if($count > 6):?>
		<div class="extralink">
			<a href="<?php echo site_url("{$userdataobj->username}/gift_list");?>" >More</a>
		</div>
	<?php endif;?>	
	
	<div class="box-profile user-profile-friendlist">
		 
		<?php $i=1; foreach($myGiftList as $item):?>
			<div class="friend-item-s">
				<div class="user-profile-avatar">
					<img src="<?php echo $path.$item->image;?>" class="tip" title="<?php echo $item->comment;?>" />
				</div>
				<div class="user-profile-username">
					<b>From:</b> <?php echo $this->user_m->getProfileDisplayName($item->id_sender );?>
				</div>
				
				<div class="user-profile-cash">
					<strong>Price:</strong> <?php echo currencyDisplay($item->price);?>J$
				</div>
			</div>
			
			<?php if( $i%6 == 0 ):?>
				<div class="clear"></div>
			<?php endif;?>	
			
			<?php $i++;?>
			
			<?php 
				if($i > 6){
					break;
				}
			?>
		<?php endforeach;?>
	 
		<div class="clear"></div>
	</div>
	
		
	<script type="text/javascript">
		$(document).ready(function(){
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

<?php endif;?>

	
