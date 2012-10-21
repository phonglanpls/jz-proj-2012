<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>

<?php 
	$input = array();
	$input['gen'] = $this->input->get('gen');
	$input['agefrom'] = $this->input->get('agefrom');
	$input['ageto'] = $this->input->get('ageto');
	$input['distance'] = $this->input->get('distance');
	$input['country_name'] = $this->input->get('country_name');
	$input['status'] = $this->input->get('status');
	$input['mapvalue'] = $this->input->get('mapvalue');
	$input['photo'] = $this->input->get('photo');
	
	$searchArray = $this->mapflirt_m->search_mapflirt($input);
	
	$userdataobj = getAccountUserDataObject();
?>

<?php if(!count($searchArray)):?>
	There is no search result.
<?php else:?>
	<div class="wrap-result" style="border:1px solid #cfcfcf;padding-left:15px;padding-top:10px; height:500px;overflow:auto;margin-top:10px;">
		<?php $i=1; foreach($searchArray as $item):?>
			<div class="friend-item" id="itemID_<?php echo $item->id_user;?>">
				
				<div class="user-profile-avatar">
					<a href="<?php echo $this->user_m->getUserHomeLink($item->id_user);?>">
						<img src="<?php echo $this->user_m->getProfileAvatar($item->id_user);?>" />
					</a>
				</div>
				
				<div class="user-profile-username">
					<?php echo $this->user_m->getProfileDisplayName($item->id_user);?>
				</div>
                
                <div class="user-profile-button">
        			<a href="javascript:void(0);" onclick="jqcc.cometchat.chatWith('<?php echo $item->id_user;?>');">
        				Chat
        			</a>
        		</div>
				
				<div class="user-profile-agesex">
					<strong>Age/Sex:</strong> <?php echo $item->age;?>, <?php echo $item->gender;?>
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
				
				<?php if(!$this->mapflirt_m->wasIMapedUser($item->id_user)):?>
					<div class="user-profile-username">
						<input type="checkbox" class="onSelectUser" name="map_flirt_user[]" id="user_id_<?php echo $item->id_user;?>" value="<?php echo $item->id_user;?>" rel="<?php echo $item->map_access;?>" />
						Select
					</div>
				<?php //else:?>
					<!--
					<div class="user-profile-username">
						<input type="checkbox" class="onSelectUser" name="map_flirt_user[]" id="user_id_<?php //echo $item->id_user;?>" value="<?php //echo $item->id_user;?>" rel="<?php //echo $item->map_access;?>" checked="checked" onclick="javascript:return false;"/>
					</div>
					-->
				<?php endif;?>
			</div>
			<?php if( $i%3 == 0 ):?>
				<div class="clear"></div>
			<?php endif;?>	
			
			<?php $i++;?>	
		<?php endforeach;?>
	</div>
	
	<div class="wrap-result" style="margin-top:20px;">
		<b>Your balance:</b> <?php echo currencyDisplay($userdataobj->cash);?>J$ <br/>
		<b>Total:</b> <span id="total_cash"></span>
		
		<div style="float:right;margin-right:10px;">
			<?php echo loader_image_s("id=\"accessMapFlirtsContextLoader\" class='hidden'");?> 
			
			<input type="button" value="Access Map" class="share-2" onclick="javascript:callFuncAccessMapFlirts();"/>
			<div class="clear"></div>
		</div>	
		<div class="clear"></div>
	</div>
<?php endif;?>	