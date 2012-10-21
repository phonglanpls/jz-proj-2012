<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>

<script type="text/javascript" src="<?php echo site_url();?>/media/js/friends.js"></script> 
	
<div id="body-content">
   <?php $this->load->view("user/partial/left");?>
 
	<div id="body">
		<div class="body">
			<div id="content">
				<?php $this->load->view("user/partial/top"); ?>
				<div class="clear"></div>
				
				<div class="filter-split">
					<?php $this->load->view("user/friends/filter");?>
				</div>
				 
				<div class="clear"></div>
				
				<div class="filter-split">
					<div id="friendsShowAsyncDiv">
						<?php $this->load->view("user/friends/show");?>
					</div>
				</div>
				
			</div>
		</div>
	   <?php $this->load->view("user/partial/right");?>
	</div>
	<div class="clear"></div>
	
</div>

