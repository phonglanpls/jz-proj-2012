<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>

<script type="text/javascript" src="<?php echo site_url();?>/media/js/friends.js"></script> 

<?php 
	$birthdayList = $this->friend_m->getBirthdayList();
?>	

<div id="body-content">
   <?php $this->load->view("user/partial/left");?>
 
	<div id="body">
		<div class="body">
			<div id="content">
				<?php $this->load->view("user/partial/top"); ?>
				<div class="clear"></div>
				
				<div class="filter-split">
					<?php if(! count($birthdayList)):?>
						Currently there are no birthdays.
					<?php else:?>
						<table>
						
						<?php foreach($birthdayList as $item):?>
							<tr>
								<td style="vertical-align:middle;">
									<a href="<?php echo $this->user_m->getUserHomeLink($item->id_user);?>">
										<img src="<?php echo $this->user_m->getProfileAvatar($item->id_user);?>" />
									</a>
								</td>
								<td style="vertical-align:middle;">
									Username: <?php echo $this->user_m->getProfileDisplayName($item->id_user);?> <br/>
									Age/Sex: <?php echo $item->cal_age;?>, <?php echo $item->gender;?> <br/>
									Location: 
										<?php 
											if($item->state){
												echo $item->state.', ';
											}
											if($item->country){
												echo $item->country;
											}
										?>
								</td>
								<td style="vertical-align:middle;">
									<?php echo birthDay($item->dob);?>
								</td>
								<td style="vertical-align:middle;">
									<a href="javascript:void(0);" onclick="callFuncShowDialogSendGift(<?php echo $item->id_user;?>);">Send a Gift</a>
								</td>
						<?php endforeach;?>
						</table>
					<?php endif;?>
				</div>
				<div class="clear"></div>
			</div>
		</div>
	   <?php $this->load->view("user/partial/right");?>
	</div>
	<div class="clear"></div>
	
</div>

