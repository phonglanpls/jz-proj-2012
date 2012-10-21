
<?php 
	$id_user = intval( $this->input->get('id_user') );
	$userdata = $this->mod_io_m->init('id_user',$id_user,TBL_USER);
?>


<?php echo form_open( 	site_url('admin/juzon/user/saveCashUser'), 
						$attributes = "method='post' id='saveCashUser' name='saveCashUser'", 
						$hidden = array() 
					);					
?> 

<input type="hidden" name="id_user" value="<?php echo $id_user;?>" />

<div id="dialog-wrap">
	<div class="row-item">
		<label> Cash</label>
		<div class="input">
			<input type="text" name="cash" value="" />
			<div class="clear"></div>
			
			<input type="radio" name="action" value="add" checked="checked" />Add 
			<input type="radio" name="action" value="reduce" />Reduce 
			<div class="clear"></div>
			
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
		jQuery('#saveCashUser').ajaxForm(options); 
	 
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