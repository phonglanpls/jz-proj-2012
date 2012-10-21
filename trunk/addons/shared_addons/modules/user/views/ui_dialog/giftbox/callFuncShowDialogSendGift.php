
<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>

<?php 
	$giftCategories = $this->gift_m->getGiftCategories();
	$touserdataobj = $this->user_io_m->init('id_user',$to_id_user);
	$userdataobj = getAccountUserDataObject(true);
	$context = $this->input->get('context');
?>

<input type="hidden" name="context" id="context" value="<?php echo $context;?>" />

<div id="wrapUI">


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
		
					
			<div class="gift-container">
				<h3>Your balance: <?php echo currencyDisplay($userdataobj->cash);?>J$</h3>

				<div class="clear"></div>

				<div class="input">
					<label>Gift:</label> 
					<div class="inputcls" id="gift-selected">
					</div>
				</div>

				<div class="clear"></div>

				<div class="input">
					<label>To:</label> 
					<div class="inputcls">
						<?php echo $touserdataobj->username;?>
					</div>
				</div>
				<div class="clear"></div>

				<div class="input">
					<label>Message:</label> 
					<div class="inputcls">
						<textarea maxlength="200" cols="15" rows="5" style="width:300px;height:100px;" id="message" name="message"></textarea>		
					</div>
				</div>
				<div class="clear"></div>
				
				<div class="input" style="margin-bottom:10px;">
					<label>&nbsp;</label> 
					<div class="inputcls">
						<input type="button" value="Send" class="share-2" onclick="callFuncSendGiftToUser();"/>
						<input type="button" value="Cancel" class="share-2" onclick="$('#hiddenElement').dialog('close');"/>
						<?php echo loader_image_s("id='sendGiftContextLoader' class='hidden'");?>	
					</div>
				</div>
				<div class="clear"></div>
				
				<input type="hidden" name="id_gift" id="id_gift_send" value="0" />
				<input type="hidden" name="id_to_user" id="id_to_user" value="<?php echo $touserdataobj->id_user;?>" />
				<input type="hidden" name="sending_gift_context" id="sending_gift_context" value="0" />
			</div>

		
	</div>
	
	

<script type="text/javascript">
$(function() {
	$id_gift = $('#id_gift_send').val();
	if( $id_gift != 0){
		$imgLink = $(".image-gift[rel="+$id_gift+"]").attr('src');
		$('#gift-selected').html("<img src="+$imgLink+" />");
	}
});
	
	
$(document).ready(function(){
	$('.pagination a').live('click',function(){
		$href = $(this).attr('href');
		$('#paginationContextLoader').toggle();
		$.get($href,{},function(res){
			$('#paginationContextLoader').toggle();
			$('#giftIDAsync').html(res);
			return false;
		});
		 
		return false;
	});
});
	</script>	



</div>