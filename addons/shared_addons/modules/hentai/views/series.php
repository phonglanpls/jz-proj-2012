<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>


<?php 
	$id_series = $this->uri->segment(4,0);
	$seriesdata = $this->mod_io_m->init('id_series',$id_series,TBL_SERIES);
?>
 
<div id="fb-root"></div>
<div id="body-content">
	<div id="body">
		<div class="body">
			<div id="content">
				<div class="clear"></div>
				 
					<div class="filter-split" style="border:1px solid #cfcfcf;">
						<?php 
							$seriesArray = $this->hentai_m->getAllSeriesVideo($id_series);
						?>
						
						<?php foreach($seriesArray as $item):?>
							<?php $slug = slugify( $seriesdata->name );	 ?>
							<div class="video-hentai-item">
						
								<a href="<?php echo site_url("hentai/category/video/{$item->id_video}/{$slug}");?>" ><?php echo $item->name;?></a> 
								
							</div>
						<?php endforeach;?>
						<div class="clear"></div>
						&nbsp;
						<?php echo loader_image_s("id='videoHentaiEpisodeContextLoader' class='hidden'");?>
					</div>
				 
				<div class="filter-split" id="videoHentaiAsyncDiv">
					
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