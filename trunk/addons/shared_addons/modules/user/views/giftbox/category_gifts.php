<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>

<?php 
	$category_id = $this->input->get('category_id',0);
	$offset = intval( $this->input->get('per_page',0) );
	
	$total =  count( $this->gift_m->listGiftsOfCategory($category_id) );
	$giftList = $this->gift_m->listGiftsOfCategory($category_id,$offset,18);
	
	$pagination = create_pagination( 
					$uri = "user/giftbox/gift_category/?is_async=1&category_id=$category_id", 
					$total_rows = $total , 
					$limit= 18,
					$uri_segment = 0,
					TRUE, TRUE 
				);
				
	$path = site_url()."image/thumb/gift/";	
	
	if($category_id == 0){
		$cat_name = "All Category";
	}else{
		$catdataobj = $this->mod_io_m->init('id_category',$category_id,TBL_CATEGORY);
		$cat_name = $catdataobj->cat_name;
	}
	$cat_name = "Gift Details For ".$cat_name;
?>

<div class="clear sep"></div>
<h3>&nbsp;<?php echo $cat_name;?></h3>
<div class="clear sep"></div>

<?php foreach($giftList as $item):?>
	<div class="gift-item">
		<a href="javascript:void(0);" onclick="callFuncAddGiftToBox(<?php echo $item->id_gift?>);">
			<img src="<?php echo $path.$item->image;?>" class="image-gift" rel="<?php echo $item->id_gift;?>" />
		</a>
		<div class="clear"></div>
		<p><?php echo currencyDisplay($item->price);?>J$</p>
	</div>
<?php endforeach;?>

<div class="clear"></div>

<div class="pagination">
	<?php echo $pagination['links'];?>
	<?php echo loader_image_s("id=\"paginationContextLoader\" class='hidden'");?>
</div>	
