
<?php 
	$id_petlock = intval( $this->input->get('id_petlock') );
	$lockdata = $this->mod_io_m->init('id_petlock',$id_petlock,TBL_PETLOCK);
	$path = site_url()."image/thumb/";
?>


<?php echo form_open( 	site_url('admin/juzon/config/savePetLock'), 
						$attributes = "method='post' id='savePetLock' name='savePetLock'", 
						$hidden = array() 
					);					
?> 

<input type="hidden" name="id_petlock" value="<?php echo $id_petlock;?>" />

<div id="dialog-wrap">
	<div class="row-item">
		<label> Name</label>
		<div class="input">
			<input type="text" name="name" value="<?php if($lockdata) echo $lockdata->name;?>" />
		</div>
		
		<div class="clear"></div>
		<label> Price</label> 	 	
		<div class="input">
			<input type="text" name="price" value="<?php if($lockdata) echo $lockdata->price;?>" /> J$
		</div>
		
		<div class="clear"></div>
		<label> Charge per day</label> 	 	
		<div class="input">
			<input type="text" name="chargeperday" value="<?php if($lockdata) echo $lockdata->chargeperday;?>" /> J$
		</div>
		
		<div class="clear"></div>
		<label> Image</label> 	 	
		<div class="input">
			<?php echo form_upload("image");?> 
			<?php if($lockdata):?>
				<img src="<?php echo $path.$lockdata->image;?>" />
			<?php endif; ?>
		</div>
		
		<div class="clear"></div>
		<label> &nbsp;</label> 
		<div class="input">
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
		jQuery('#savePetLock').ajaxForm(options); 
	 
	});
	
	function validateB4Submit(formData, jqForm, options){
		jQuery('#save_loader').show();
		return true;
	}

	function processAfterResponding(responseText, statusText, xhr, $form) {
		jQuery('#save_loader').hide();	
		if(responseText == 'ok'){
			gotoDefaultPage();
		}else{
			debug(responseText);
		}
	}
	
	function gotoDefaultPage(){
		queryurl(BASE_URI+'admin/juzon/config/pet_lock');
	}
</script>