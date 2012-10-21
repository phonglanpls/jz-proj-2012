<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>

<script type="text/javascript" src="<?php echo site_url();?>/media/js/peeps.js"></script> 

<?php 
	
?>


<div id="body-content">
   <?php $this->load->view("user/partial/left");?>
 
	<div id="body">
		<div class="body">
			<div id="content">
				<?php $this->load->view("user/partial/top"); ?>
				<div class="clear"></div>
				 
					<div class="filter-split">
						Search Type: <?php echo form_dropdown('search_type',peepSearchTypeOptionData_ioc(), array(), 'id="search_type" onchange="javascript:callFuncShowPeeps();"');?>
						&nbsp;&nbsp;&nbsp;
						Sort By: <?php echo form_dropdown('sort_by',peepSortOptionData_ioc(), array(), 'id="sort_by" onchange="javascript:callFuncShowPeeps();"' );?>
						<?php echo loader_image_s("id='peepContextLoader' class='hidden'");?>
					</div>
					
					<input type="hidden" id="hidden_id_user" value="<?php echo $id_user;?>" />
					
				<div id="peepAsyncDiv">
				 
				</div>
				
			</div>
		</div>
	   <?php $this->load->view("user/partial/right");?>
	</div>
	<div class="clear"></div>
	
</div>

<script type="text/javascript">
	$(document).ready(function(){
		callFuncShowPeeps();
		
		$('.pagination a').live('click',function(){
			$href = $(this).attr('href');
			$('#peepContextLoader').toggle();
			$.get($href,{},function(res){
				$('#peepContextLoader').toggle();
				$('#peepAsyncDiv').html(res);
				return false;
			});
			return false;
		});
	});
</script>