
<?php 
	$id_gift = intval( $this->input->get('id_gift') );
	$giftdata = $this->mod_io_m->init('id_gift',$id_gift,TBL_GIFT);
	$categoryArr = $this->juzon_gift_m->getGiftCategoriesArray($mode='NO_SELECTED');
	$path = site_url()."image/thumb/gift/";	 
	
	$id_category = ($giftdata)?$giftdata->id_category:null;
	$status = ($giftdata)?$giftdata->status:1;
?>


<?php echo form_open( 	site_url('admin/juzon/gift/saveGift'), 
						$attributes = "method='post' id='saveGift' name='saveGift'", 
						$hidden = array() 
					);					
?> 

<input type="hidden" name="id_gift" value="<?php echo $id_gift;?>" />

<div id="dialog-wrap">
	<div class="row-item">
		<label> Category</label>
		<div class="input">
			<?php echo form_dropdown('category',$categoryArr, array($id_category));?>
		</div>
		
		<div class="clear"></div>
		
		<label> Name</label>
		<div class="input">
			<input type="text" name="name_gift" value="<?php if($giftdata) echo $giftdata->name_gift;?>" />
		</div>
		
		<div class="clear"></div>
		
		<label> Price</label>
		<div class="input">
			<input type="text" name="price" value="<?php if($giftdata) echo $giftdata->price;?>" />
		</div>
		
		<div class="clear"></div>
		
		<label> Description</label>
		<div class="input">
			<input type="text" name="description" value="<?php if($giftdata) echo $giftdata->description;?>" />
		</div>
		
		<div class="clear"></div>
		
		<label> Status</label>
		<div class="input">
			<?php echo form_dropdown('status',adminStatusItemOptionData_ioc(), array($status));?>
		</div>
		
		<div class="clear"></div>
		<label> Image</label>
		<div class="input">
			<?php echo form_upload("image");?> 
			<?php if($giftdata):?>
				<img src="<?php echo $path.$giftdata->image;?>" />
			<?php endif; ?>
		</div>
		
		<div class="clear"></div>
		<label>&nbsp;</label>
		<div class="input">
			<input type="submit" value="Submit" />
			<input type="button" value="Cancel" onclick="$('#hiddenElement').dialog('close');"/>
			<?php echo admin_loader_image_s("id='save_loader'");?>
		</div>
	</div>
</div>


<?php echo form_close(); ?>




<script type="text/javascript">
	jQuery(document).ready(function(){
		var options = { 
			beforeSubmit:  validateB4Submit,  
			success:       processAfterResponding  
		};	
		jQuery('#saveGift').ajaxForm(options); 
	 
	});
	
	function validateB4Submit(formData, jqForm, options){
		jQuery('#save_loader').show();
		return true;
	}

	function processAfterResponding(responseText, statusText, xhr, $form) {
		jQuery('#save_loader').hide();	
		if(responseText == 'ok'){
			reload();
		}else{
			debug(responseText);
		}
	}
	 
</script>