<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>

<?php 
	$userdataobj = getAccountUserDataObject();
	$otherBoughtYou = $this->mapflirt_m->getListOthersBoughtYouHistory();
?>

<table>
	<thead>
		<td width="150px;"><?php echo language_translate('accessmap_label_thead_who_access_map');?></td>
		<td width="150px;"><?php echo language_translate('accessmap_label_thead_datetime');?></td>
		<td width="50px;"><?php echo language_translate('accessmap_label_thead_days');?></td>
		<td width="130px;"><?php echo language_translate('accessmap_label_thead_status');?></td>
		<td width="70px;"><?php echo language_translate('accessmap_label_thead_action');?></td>
	</thead>
	
		<?php foreach($otherBoughtYou as $item):?>
			<tr id="id_<?php echo $item->id_map_history;?>">
				<td>
					<div class="user-profile-username">
						<?php echo $this->user_m->getProfileDisplayName($item->id_user);?>
					</div>
				</td>	
				
				<td>
					<?php echo juzTimeDisplay( $item->buy_date );?>
				</td>
				
				<td>
					<?php 
						$days = (int) ( ( mysql_to_unix($item->exp_date) - mysql_to_unix($item->buy_date) )/86400 );
						echo $days;
					?>
				</td>
				
				<td>
					<?php 
						$timeLeft = $item->time_left;
						if(!$timeLeft){
							echo language_translate('accessmap_label_expires');
						}else if($timeLeft < 24){
							echo $timeLeft.language_translate('accessmap_label_hours_left');
						}else{
							$day = (int) ($timeLeft/24);
							echo $day.language_translate('accessmap_label_days_left');	
						}
					?>
				</td>
				
				<td>
					<?php 
						echo $this->block_m->mapBlockContextStatus($item->id_user);
					?>
				</td>
			</tr>	
		<?php endforeach;?>
	</table>	