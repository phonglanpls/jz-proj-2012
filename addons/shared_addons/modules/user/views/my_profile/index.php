<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<!-- 
<script type="text/javascript">
	//var FBID = "<?php //echo $GLOBALS['global']['FACEBOOK']['api_key'];?>";
</script>	
<script type="text/javascript" src="<?php //echo site_url();?>/media/js/fb.js"></script> 
-->

<div id="body-content">
   <?php $this->load->view("user/partial/left");?>
 
	<div id="body">
		<div class="body">
			<div id="content">
				<?php $this->load->view("user/partial/top"); ?>
				<div class="clear"></div>
				
				<div class="filter-split">
					<?php $this->load->view("my_profile/user_info", array('userdataobj'=>$userdataobj)); ?>
				</div>
				 
				<div class="clear"></div>
				 
				<div class="filter-split">
					<?php $this->load->view("my_profile/user_social_info", array('userdataobj'=>$userdataobj)); ?>
				</div>
				
				<div class="clear"></div>
				 
				<div class="filter-split" id="asyncSectionShareBox">
					<?php $this->load->view("my_profile/share_box", array('userdataobj'=>$userdataobj)); ?>
				</div>

				<div class="clear"></div>
				<!--
				<div class="filter-split" id="asyncSectionFilterBox">
					<?php //$this->load->view("my_profile/filter_box", array('userdataobj'=>$userdataobj)); ?>
				</div>
				-->
				
				<div class="clear"></div>
				 
				<div class="filter-split" id="asyncSectionFeed">
					<?php $this->load->view("my_profile/user_chatter", array('userdataobj'=>$userdataobj)); ?>
					
					<div class="clear"></div>
					<div id="morePost">
						<a href="javascript:void(0);" onclick="callFuncGetMorePost_MYPROFILE();" >More</a> 
						<?php echo loader_image_s("id=\"morePostContextLoader\" class='hidden'");?>
					</div>
				</div>
				
			</div>
		</div>
	   <?php $this->load->view("user/partial/right");?>
	</div>
	<div class="clear"></div>
	
</div>
 

<script type="text/javascript">
	var cur_page = 1;
	$(document).ready(function(){
		if(FEEDCOUNT <1){
			$('#morePost').hide();
		}
	});
</script>
