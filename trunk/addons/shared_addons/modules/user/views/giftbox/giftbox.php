<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>

<?php 
	$giftCategories = $this->gift_m->getGiftCategories();
?>

<div class="category-wrap">
	<h3>Gift Categories <?php echo loader_image_s("id='giftCategoryContextLoader' class='hidden'");?></h3>
	<ul id="categories">
		<li>
			<a href="javascript:void(0);" onclick="callFuncShowGiftCategory(0);">All</a>
		</li>
		<?php foreach($giftCategories as $item):?>
			<li>
				<a href="javascript:void(0);" onclick="callFuncShowGiftCategory(<?php echo $item->id_category;?>);"><?php echo $item->cat_name;?></a>
			</li>
		<?php endforeach;?>
	</ul>
</div>

<div class="gift-wrap" id="giftIDAsync">
	<?php $this->load->view("giftbox/category_gifts"); ?>
</div>

<div class="clear sep"></div>

<div class="category-wrap">&nbsp;</div>
<div class="gift-wrap" id="sendGifAsyncDiv" style="margin-top:15px;">
	<?php $this->load->view("giftbox/send_gifts"); ?>
</div>
