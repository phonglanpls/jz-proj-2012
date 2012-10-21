<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>

<?php 
	if(!$category_id=$this->input->get('category_id')){
		$categoriesArray = $this->hentai_m->getCategories();
		if($categoriesArray){
			$category_id=$categoriesArray[0]->id_hentai_category;
		}else{
			exit;
		}	
	}
	
	if(isset($_GET['per_page'])){
		$offset = intval($_GET['per_page']);
	}else{
		$offset = 0;
	}
	
	$total = count($this->hentai_m->getVideoCategory($category_id));
	
	$rec_per_page = $GLOBALS['global']['PAGINATE']['rows_per_page'] * 3; //$GLOBALS['global']['PAGINATE']['rec_per_page']
	$videoSeries = $this->hentai_m->getVideoCategory($category_id,$offset,$rec_per_page);
	
	$pagination = create_pagination( 
					$uri = "user/videos/category/?category_id=$category_id", 
					$total_rows = $total , 
					$limit= $rec_per_page,
					$uri_segment = 0,
					TRUE, TRUE 
				);
	
	$videocategory = $this->mod_io_m->init('id_hentai_category',$category_id,TBL_HENTAI_CATEGORY); 
?>

<h3><?php echo ucfirst($videocategory->category_name);?> Videos</h3>

<?php $i=1; foreach($videoSeries as $item):?>
	<?php 
		$seriesdata = $this->mod_io_m->init('id_series',$item->id_series,TBL_SERIES);
		$slug = slugify( $seriesdata->name );
		
		if($category_id == 1){
			$thumbPath = $item->img_url;
		}else{
			$thumbPath = site_url().'image/thumb/hentai/dailymotion/'.$item->image.'.jpg';
		}
	?>
	<div class="video-thumb-info">
		<a href="<?php echo site_url("user/videos/series/{$item->id_series}/{$slug}");?>"><img src="<?php echo $thumbPath;?>" width="160px" height="120px" /></a>
		<div class="clear"></div>
		<a href="<?php echo site_url("user/videos/series/{$item->id_series}/{$slug}");?>"><?php echo $item->name;?></a>
	</div>
	
	<?php if($i%3 ==0):?>
		<div class="clear"></div>
	<?php 
		endif;
		$i++;
	?>
<?php endforeach;?>


<div class="clear"></div>
<div class="pagination">
	<?php echo $pagination['links'];?>
	<?php echo loader_image_s("id=\"paginationContextLoader\" class='hidden'");?>
</div>	