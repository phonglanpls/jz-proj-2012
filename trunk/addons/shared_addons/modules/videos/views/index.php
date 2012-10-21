<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>

<div id="body-content">
  
	<div id="body">
		<div class="body">
			<div id="content">
				 
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
					<?php $this->load->view("videos/show_categories"); ?>
				</div>
				
			</div>
		</div>
	 
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
