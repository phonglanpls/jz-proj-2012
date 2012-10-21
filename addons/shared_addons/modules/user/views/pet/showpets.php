<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>

<?php 
	$userdataobj = getAccountUserDataObject();
	if(isset($_GET['per_page'])){
		$offset = intval($_GET['per_page']);
	}else{
		$offset = 0;
	}
	
	if(isset($_GET['search_flag'])){
		$arr['pric'] = $this->input->get('pric');
		$arr['gen']	 = $this->input->get('gen'); 	
		$arr['sb']   = $this->input->get('sb');
		$arr['agefrom'] = $this->input->get('agefrom');
		$arr['ageto'] 	= $this->input->get('ageto');
		$arr['distance'] = $this->input->get('distance');
		$arr['country_name'] = $this->input->get('country_name');
		$arr['status'] = $this->input->get('status');
		//$arr['mapvalue'] = $this->input->get('mapvalue');
		$arr['photo'] = $this->input->get('photo');
		
		$this->pet_m->saveSearchInfo($arr);
	}
	
	$total = count($this->pet_m->defaultSearch());
	
	$rec_per_page = $GLOBALS['global']['PAGINATE']['rows_per_page'] * 4; //$GLOBALS['global']['PAGINATE']['rec_per_page']
	$pageArray = $this->pet_m->defaultSearch($offset,$rec_per_page);
	
	$pagination = create_pagination( 
					$uri = 'user/pets_func/callFuncSearchPetsDefault/?psl=1', 
					$total_rows = $total , 
					$limit= $rec_per_page,
					$uri_segment = 0,
					TRUE, TRUE 
				);
	 	
?>

<?php 
	if(!count($pageArray))
		echo "No Such Records Founds....";
?>

<?php $i=1; foreach($pageArray as $item):?>
	<div class="friend-item" id="itemID_<?php echo $item->id_user;?>">
		<div class="user-profile-avatar">
			<a href="<?php echo $this->user_m->getUserHomeLink($item->id_user);?>">
				<img src="<?php echo $this->user_m->getProfileAvatar($item->id_user);?>" />
			</a>	
		</div>
		
		<div class="user-profile-username">
			<?php echo $this->user_m->getProfileDisplayName($item->id_user);?>
		</div>
		
		<div class="user-profile-agesex">
			<strong>Age/Sex:</strong> <?php echo $item->cur_age;?>, <?php echo $item->gender;?>
		</div>
		
		<div class="user-profile-location">
			<strong>Distance:</strong>
			<?php 
				echo number_format( 
					$this->geo_lib->distance($userdataobj->latitude, $userdataobj->longitude, $item->latitude, $item->longitude, 'K'),
					2
					);
			?>
			Km
		</div>
		
		<div class="user-profile-cash">
			<strong>Cash:</strong> <?php echo $this->user_m->getCash($item->id_user);?>
		</div>
		
		<div class="user-profile-owner">
			<strong>Owner:</strong> <?php echo $this->user_m->buildNativeLink( $item->ownername );?>
		</div>
		
		<?php if($item->lockstatus == 1):?>
			<div class="user-profile-owner">
				<strong>Locked By:</strong> <?php echo $this->user_m->buildNativeLink( $item->ownername );?>
			</div>
		<?php endif;?>
		
		<div class="user-profile-button">
			<a href="javascript:void(0);" onclick="callFuncAddThisPet(<?php echo $item->id_user;?>)">
				Buy For <?php echo $this->user_m->calculatePetPrice($item->id_user);?>J$
			</a>
		</div>
		
		<div class="user-profile-button" id="wishlistInfoDivID_<?php echo $item->id_user;?>">
			<a href="javascript:void(0);" onclick="callFuncAddToWishListThisPet(<?php echo $item->id_user;?>);">
				<?php echo language_translate('wishlist_addto');?>
			</a>
		</div>
		
        <div class="user-profile-button">
			<a href="javascript:void(0);" onclick="jqcc.cometchat.chatWith('<?php echo $item->id_user;?>');">
				Chat
			</a>
		</div>
        
		<div class="clear"></div>
	</div>
	
	<?php if( $i%4 == 0 ):?>
		<div class="clear"></div>
	<?php endif;?>	
	
	<?php $i++;?>
<?php endforeach;?>


<div class="clear"></div>
<div class="pagination">
	<?php echo $pagination['links'];?>
	<?php echo loader_image_s("id=\"paginationContextLoader\" class='hidden'");?>
</div>	
