<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>

<?php 
	$userdataobj = getAccountUserDataObject();
	$otherBoughtYou = $this->mapflirt_m->getListOthersBoughtYouHistory();
?>

<table>
	<thead>
		<td width="100px;">Who bought</td>
		<td width="150px;">Date/time</td>
		<td width="50px;">Days</td>
		<td width="130px;">Status</td>
		<td width="120px;">Spy back</td>
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
							echo 'Expire';
						}else if($timeLeft < 24){
							echo $timeLeft.' Hour(s) Left ';
						}else{
							$day = (int) ($timeLeft/24);
							echo $day.' Day(s) Left ';	
						}
					?>
				</td>
				
				<td>
					<?php 
					   echo "<a href='javascript:void(0);' onclick='javascript:callFuncBuyAccessMapFlirtCMChat({$item->id_user});'>Spy back</a>";
					?>
				</td>
			</tr>	
		<?php endforeach;?>
	</table>	