<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>

<script type="text/javascript" src="<?php echo site_url();?>/media/js/backstage.js"></script> 
<script type="text/javascript" src="<?php echo site_url();?>/media/js/my_backstage.js"></script> 

<?php 
	$view_cat=$GLOBALS['global']['BACKSTAGE_LIST'];	
    
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
					<a href="javascript:void(0);" onclick="callFuncShowLatestBackstage('<?php echo $GLOBALS['global']['BACKSTAGE_LIST']['most_viewed']['latest'];?>');"><?php echo language_translate('backstage_menu_label_latest');?></a> 
						<?php echo loader_image_s("id='LatestBackstageContextLoader' class='hidden'");?>
					|
					<a href="javascript:void(0);" onclick="callFuncShowMostViewBackstage('<?php echo $GLOBALS['global']['BACKSTAGE_LIST']['most_viewed']['most_viewed'];?>');"><?php echo language_translate('backstage_menu_label_most_viewed');?></a>
						<?php echo loader_image_s("id='MostViewBackstageContextLoader' class='hidden'");?>
					|
					<a href="javascript:void(0);" onclick="callFuncShowRandomBackstage('<?php echo $GLOBALS['global']['BACKSTAGE_LIST']['most_viewed']['random'];?>');"><?php echo language_translate('backstage_menu_label_random');?></a>
						<?php echo loader_image_s("id='RandomBackstageContextLoader' class='hidden'");?>
						
					Or
					
					<input type="text" name="keyword" id="keyword" value="<?php echo language_translate('backstage_menu_label_search');?>" />
					<input type="button" class="share-2" onclick="callFuncSearchBackstage();" name="search" value="<?php echo language_translate('backstage_menu_label_search');?>" />	
						<?php echo loader_image_s("id='searchBackstageContextLoader' class='hidden'");?>
					
					&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;	
					<a href="javascript:void(0);" onclick="callFuncShowMyBackstage();"><?php echo language_translate('backstage_menu_label_my_backstage_photos');?></a>
						<?php echo loader_image_s("id='MyBackstageContextLoader' class='hidden'");?>	
				</div>
				
				<div class="filter-split" id="backstagePhotoAsyncDiv">
					<?php if($section == 'spc1') :?>
                        <script type="text/javascript">
                            $(function(){
                                callFuncShowMyBackstage();
                            });
                        </script>
                        
                    <?php else:    
                            $this->load->view("backstage/show_backstage");
                          endif;  
                    ?>
				</div>
				
			</div>
		</div>
	   <?php $this->load->view("user/partial/right");?>
	</div>
	<div class="clear"></div>
	
</div>

<script type="text/javascript">
	
$(document).ready(function(){
	$('#keyword').live('focusin',function(){
		$dfText = $(this).val();
		if($dfText == '<?php echo language_translate('backstage_menu_label_search');?>'){
			$(this).val('');
		}
	});
	
	$('.pagination a').live('click',function(){
		$href = $(this).attr('href');
		$('#paginationContextLoader').toggle();
		$.get($href,{},function(res){
			$('#paginationContextLoader').toggle();
			$('#backstagePhotoAsyncDiv').html(res);
			return false;
		});
		 
		return false;
	});
	
	$('.async-loading a').live('click',function(){
		$('#MyBackstageContextLoader').toggle();
		$href = $(this).attr('href');
		$.get($href,{},function(res){
			$('#MyBackstageContextLoader').toggle();
			$('#backstagePhotoAsyncDiv').html(res);
			return false;
		});
		return false;
	});
	
});
</script>
