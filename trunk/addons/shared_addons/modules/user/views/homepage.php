	<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
	
	<script type="text/javascript" src="<?php echo site_url();?>/media/js/wall.js"></script> 
	<script type="text/javascript" src="<?php echo site_url();?>/media/js/qa.js"></script> 
	
	<div id="body-content">
       <?php 
			$this->load->view("user/partial/left");
	   ?>
        
        <div id="body">
        	<div class="body">
            	<div id="content">
                	<?php $this->load->view("user/partial/top"); ?>
					
					<?php $this->load->view("user/wall/top_nav"); ?>
					
                    <div class="clear"></div>
					
					<div id="asyncSectionShareBox">
						<?php $this->load->view("user/wall/share_box"); ?>
					</div>
					
					<div id="asyncSectionFilterBox">
						<?php $this->load->view("user/wall/filter_box"); ?>
                    </div>
					
					<div id="asyncSectionFeed">
						<?php $this->load->view("user/wall/feed"); ?> 
						
					</div>	
                    
					<div class="clear"></div>
					<div id="morePost">
						<a href="javascript:void(0);" onclick="callFuncGetMorePost();" >More</a> 
						<?php echo loader_image_s("id=\"morePostContextLoader\" class='hidden'");?>
					</div>
                    
                </div>
            </div>
           <?php $this->load->view("user/partial/right");?>
        </div>
        <div class="clear"></div>
		
    </div>
	
<script type="text/javascript">
	var cur_page = 1;
</script>	
	
