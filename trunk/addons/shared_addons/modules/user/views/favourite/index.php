<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
 
<?php 
	$check= $this->db->where('id_user',getAccountUserId())->get(TBL_FAVOURITE_BUY_LOG)->result();
?>

<div id="body-content">
   <?php $this->load->view("user/partial/left");?>
 
	<div id="body">
		<div class="body">
			<div id="content">
				<?php $this->load->view("user/partial/top"); ?>
				<div class="clear"></div>
				
				<?php if(!$check):?>
					<div class="filter-split"> 
						View who added you as favorite 
						
						<div class="user-profile-button" style="width:130px;">
							<a href="javascript:void(0);" onclick="callFuncBuyFavouriteAccessPackage();">
								Buy For <?php echo currencyDisplay( $GLOBALS['global']['ADMIN_DEFAULT']['favourite'] );?>J$
							</a>
						</div>
					</div>
				<?php else:?>
					<?php $listFavourite = $this->favourite_m->getWhoAddedMe();?>
					<div class="filter-split"> 					
						<table>
							<thead>
								<td>Username</td>
								<td>Date/time</td>
							</thead>
						
							<?php foreach($listFavourite as $item):?>
								<tr>
									<td>
										<div class="user-profile-username">
											<?php echo $this->user_m->getProfileDisplayName($item->from_id_user);?>
										</div>
									</td>	
								
									<td>
										<?php echo juzTimeDisplay($item->datetime);?>
									</td>
								</tr>	
							<?php endforeach;?>
						</table>	
					</div>		
				<?php endif;?>
			</div>
		</div>
	   <?php $this->load->view("user/partial/right");?>
	</div>
	<div class="clear"></div>
	
</div>

<script type="text/javascript">
	
$(document).ready(function(){
	
});
</script>
