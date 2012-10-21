<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>

<script type="text/javascript" src="<?php echo site_url();?>/media/js/map_flirts.js"></script> 

<?php 
    $section = $this->input->get('s');
?>
<div id="body-content">
   <?php $this->load->view("user/partial/left");?>
 
	<div id="body">
		<div class="body">
			<div id="content">
				<?php $this->load->view("user/partial/top"); ?>
				<div class="clear"></div>
				 
					<div class="filter-split">
						<a href="javascript:void(0);" onclick="callFuncShowMapFlirts();">Map Flirts</a> 
							<?php echo loader_image_s("id='mapFlirtsContextLoader' class='hidden'");?>
						|
						<a href="javascript:void(0);" onclick="callFuncShowBoughtHistory();">Map Bought History</a>
							<?php echo loader_image_s("id='flirtBoughtContextLoader' class='hidden'");?>
					</div>
				 
				<div id="flirtAsyncDiv">
                    
					<?php 
                        if($section == 'spc1'){ // show other bought you section
                            $this->load->view("map_flirt/history");
                        }else{
                           $this->load->view("map_flirt/map_flirts"); 
                        }
                     ?>
				</div>
				
			</div>
		</div>
	   <?php $this->load->view("user/partial/right");?>
	</div>
	<div class="clear"></div>
	
</div>



<script type="text/javascript">

</script>
