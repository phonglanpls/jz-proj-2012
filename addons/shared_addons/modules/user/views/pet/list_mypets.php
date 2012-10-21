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
	#lockedDiv{
		height:400px;
		overflow:auto
	}
</style>
<script type="text/javascript" src="<?php echo site_url();?>/media/js/mypet.js"></script> 
	
<div id="body-content">
   <?php $this->load->view("user/partial/left");?>
 
	<div id="body">
		<div class="body">
			<div id="content">
				<?php $this->load->view("user/partial/top"); ?>
				<div class="clear"></div>
				<div class="sep"></div>
				
				<h3>Lock your pets so no other user can buy them for the selected time</h3> 
				<div class="clear"></div>
				<div class="sep"></div>
				
				<h3>STEP 1: CHOOSE A PET</h2>
				<div class="filter-split"  id="wrapPetDiv">
					<?php $this->load->view("user/pet/showmypets");?>
				</div>
				 
				<div class="clear"></div>
				<div class="sep"></div>
				
				<h3>STEP 2: CHOOSE A LOCK</h2>	
				<div class="filter-split">
					<div id="lockedDiv">
						<?php $this->load->view("user/pet/lockedpets");?> 
					</div>
				</div>
				
				<div class="clear"></div>
				<div class="sep"></div>
				
				<div id="warningAct" style="color:red;"></div>
				
				<div style="float:right;margin-right:10px;">
					<?php echo loader_image_s("id=\"lockPetsContextLoader\" class='hidden'");?> 
					<input type="button" value="Lock" class="share-2" onclick="callFuncLockPet();"/>
				</div>	
				<div class="clear"></div>
				
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
			$('#wrapPetDiv').html(res);
			return false;
		});
		return false;
	});
});
</script>
