<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>

<div id="body-content">
  <?php $this->load->view("user_profile/visitor/left_login", array('userdataobj'=>$userdataobj));?>
  
	<div id="body">
		<div class="body">
			<div id="content">
				<div class="clear"></div>
				
				<div class="filter-split">
					<?php $this->load->view("user_profile/visitor/user_info", array('userdataobj'=>$userdataobj)); ?>
				</div>
				 
				<div class="clear"></div>
				 
				<div class="filter-split">
					<?php $this->load->view("user_profile/visitor/gift_async", array('userdataobj'=>$userdataobj)); ?>
				</div>
				 
				<div class="clear"></div>
				
			</div>
		</div>
	   
	</div>
	<div class="clear"></div>
	
</div>

<script type="text/javascript">
	
	$(document).ready(function(){
		
	});
</script>
