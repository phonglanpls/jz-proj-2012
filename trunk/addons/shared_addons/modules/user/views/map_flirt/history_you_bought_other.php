<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>

<?php 
	$userdataobj = getAccountUserDataObject();
	$youBoughtOthers = $this->mapflirt_m->getListYouBoughtOthersHistory();
?>

<table>
	<thead>
		<td width="100px;">Map bought</td>
		<td width="150px;">Date/time</td>
		<td width="50px;">Days</td>
		<td width="130px;">Status</td>
		<td width="120px;">Extend (Buy access)</td>
	</thead>
	
		<?php foreach($youBoughtOthers as $item):?>
			<tr id="id_<?php echo $item->id_map_history;?>">
				<td>
					<div class="user-profile-username">
						<?php echo $this->user_m->getProfileDisplayName($item->id_user);?>
					</div>
				</td>	
				
				<td>
					<?php echo juzTimeDisplay($item->buy_date);?>
				</td>
				
				<td>
					<?php 
						$days = (int) ( ( mysql_to_unix($item->exp_date) - mysql_to_unix($item->buy_date) )/86400 );
						echo $days;
					?>
				</td>
				
				<td>
					<?php 
						$checkBlock = $this->mapflirt_m->checkUserBlockedOther($item->id_user,getAccountUserId());
						$timeLeft = $item->time_left;
						if($checkBlock){
							echo 'Was Blocked';
						}else{
							if(!$timeLeft){
								echo 'Expire';
							}else if($timeLeft < 24){
								echo "<a href='javascript:void(0);' onclick='javascript:callFuncShowAccessMap_SELLER({$item->id_user});'>".$timeLeft.' Hour(s) Left '."</a>";
							}else{
								$day = (int) ($timeLeft/24);
								echo "<a href='javascript:void(0);' onclick='javascript:callFuncShowAccessMap_SELLER({$item->id_user});'>".$day.' Day(s) Left '."</a>";
							}
						}
					?>
				</td>
				
				<td>
					<?php 
						echo form_dropdown('extend_days',extendDaysAccessMapOptionData_ioc(),array()," id=\"extend_days\" onchange=\"javascript:callFuncExtendAccessMap(this.value,{$item->id_user});\" "); 
						echo loader_image_s("id=\"extendDayscontextLoader_{$item->id_user}\" class='hidden'"); 
					?>
				</td>
			</tr>	
		<?php endforeach;?>
	</table>	