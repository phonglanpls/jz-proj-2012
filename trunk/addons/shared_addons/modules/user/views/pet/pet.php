<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<style>
	.sep{
		height:5px;
		clear:both;
		width:1px;
		display:block;
	}
	#country_name{
		width:150px;
	}
	.filter-split label{
		width:140px;
		display:block;
		float:left;
	}
</style>
<script type="text/javascript" src="<?php echo site_url();?>/media/js/pet.js"></script> 
	
<div id="body-content">
   <?php $this->load->view("user/partial/left");?>
 
	<div id="body">
		<div class="body">
			<div id="content">
				<?php $this->load->view("user/partial/top"); ?>
				<div class="clear"></div>
				<div class="sep"></div>
				
				<h3>Buy your pets and make them belong to you ....</h3> 
				<div class="clear"></div>
				<div class="sep"></div>
				
				<div class="filter-split" style="border:1px solid #cfcfcf;padding-left:5px;" id="wrapPetSearchDiv">
					<?php $this->load->view("user/pet/filter");?>
				</div>
				 
				<div class="clear"></div>
				 
				<div class="filter-split">
					<div id="petAsyncDiv">
						 
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
	callFuncSearchPets();
	
	$('.pagination a').live('click',function(){
		$href = $(this).attr('href');
		$('#paginationContextLoader').toggle();
		$.get($href,{},function(res){
			$('#paginationContextLoader').toggle();
			$('#petAsyncDiv').html(res);
			return false;
		});
		return false;
	});
});
</script>
