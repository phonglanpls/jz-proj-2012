<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>

<?php 
	$givenArray = $this->flirt_m->getFlirtsGiven();
?>

<?php if(! count($givenArray)):?>
	There is no flirts
<?php else:?>
	<table>
		<?php foreach($givenArray as $item):?>
			<tr id="id_<?php echo $item->id_flirt;?>">
				<td width="100%">
					<div class="left-wrap" style="width:160px;">
						<div class="friend-item">
							<div class="user-profile-avatar">
								<img src="<?php echo $this->user_m->getProfileAvatar($item->id_receiver);?>" />
							</div>
							<div class="user-profile-username">
								<?php echo $this->user_m->getProfileDisplayName($item->id_receiver);?>
							</div>
						</div>
					</div>
					
					<div class="right-wrap" style="width:460px;">
						<p>Sent <?php echo timeDiff($item->time_diff);?></p>
						<br/>
						<?php echo $item->subject;?>
						<br/>
						
						<?php echo loader_image_delete("class='deleteItem' onclick='callFuncDeleteFlirt({$item->id_flirt});'"); ?>
					</div>
				</td>
			</tr>	
		<?php endforeach;?>
	</table>	
<?php endif;?>
