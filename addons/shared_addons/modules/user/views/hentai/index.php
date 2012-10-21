<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>

<script type="text/javascript" src="<?php echo site_url();?>/media/js/hentai.js"></script> 

<div id="body-content">
   <?php $this->load->view("user/partial/left");?>
 
	<div id="body">
		<div class="body">
			<div id="content">
				<?php $this->load->view("user/partial/top"); ?>
				<div class="clear"></div>
				 
					<div class="filter-split">
						<?php 
							$categoriesArray = $this->hentai_m->getCategories();
							$html = array();
							foreach($categoriesArray as $item){
								$html[] = "<a href=\"javascript:void(0);\" onclick=\"callFuncShowHentaiCategory({$item->id_hentai_category});\">{$item->category_name}</a>". 
											loader_image_s("id='HentaiVideoContextLoader_{$item->id_hentai_category}' class='hidden'");
							}
							echo implode(' | ',$html);
						?>
						
					</div>
				 
				<div class="filter-split" id="hentaiAsyncDiv">
					<?php $this->load->view("hentai/show_categories"); ?>
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
			$('#hentaiAsyncDiv').html(res);
			return false;
		});
		 
		return false;
	});
});
</script>
