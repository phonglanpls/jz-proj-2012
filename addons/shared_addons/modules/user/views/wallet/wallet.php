<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>

<script type="text/javascript" src="<?php echo site_url();?>/media/js/wallet.js"></script> 
	
<div id="body-content">
   <?php $this->load->view("user/partial/left");?>
 
	<div id="body">
		<div class="body">
			<div id="content">
				<?php $this->load->view("user/partial/top"); ?>
				<div class="clear"></div>
				
				<div class="filter-split">
					<a href="javascript:void(0);" onclick="callFuncShowEarning();"><strong>J$ Earning</strong></a>
						<?php echo loader_image_s("id=\"earningContextLoader\" class='hidden'");?> 
					|
					<a href="javascript:void(0);" onclick="callFuncShowExpense();"><strong>J$ Expense</strong></a>
						<?php echo loader_image_s("id=\"expenseContextLoader\" class='hidden'");?> 
					|
					<a href="javascript:void(0);" onclick="callFuncShowBalance();"><strong>J$ Balance</strong></a>
						<?php echo loader_image_s("id=\"balanceContextLoader\" class='hidden'");?> 	
				</div>
				 
				<div class="clear"></div>
				 
				<div class="filter-split">
					<div id="wallAsyncDiv">
						<?php $this->load->view('user/wallet/earning');?>
					</div>
				</div>
			</div>
		</div>
	   <?php $this->load->view("user/partial/right");?>
	</div>
	<div class="clear"></div>
	
</div>

<script type="text/javascript">
	
$(document).ready(function(){
	$('.pagination a').live('click',function(){
		$href = $(this).attr('href');
		$('#paginationContextLoader').toggle();
		$.get($href,{},function(res){
			$('#paginationContextLoader').toggle();
			$('#wallAsyncDiv').html(res);
			return false;
		});
		 
		return false;
	});
});
</script>
