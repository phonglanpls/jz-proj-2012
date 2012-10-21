
<?php 
	$id_category = intval( $this->input->get('id_category') );
	$categorydata = $this->mod_io_m->init('id_category',$id_category,TBL_CATEGORY);
	$status = ($categorydata)?$categorydata->status:1;
?>


<?php echo form_open( 	site_url('admin/juzon/gift/saveCategory'), 
						$attributes = "method='post' id='saveCategory' name='saveCategory'", 
						$hidden = array() 
					);					
?> 

<input type="hidden" name="id_category" value="<?php echo $id_category;?>" />

<div id="dialog-wrap">
	<div class="row-item">
		<label> Category</label>
		<div class="input">
			<input type="text" name="cat_name" value="<?php if($categorydata) echo $categorydata->cat_name;?>" />
		</div>
		
		<div class="clear"></div>
		
		<label> Status</label>
		<div class="input">
			<?php echo form_dropdown('status',adminStatusItemOptionData_ioc(), array($status));?>
			<div class="clear"></div>
			
			<input type="submit" value="Save" />
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
		jQuery('#saveCategory').ajaxForm(options); 
	 
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