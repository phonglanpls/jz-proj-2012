
<?php echo form_open( 	site_url('admin/juzon/report/saveIPBlocked'), 
						$attributes = "method='post' id='saveIPBlocked' name='saveIPBlocked'", 
						$hidden = array() 
					);					
?> 
 
<div id="dialog-wrap">
	<div class="row-item">
		<label> IP</label>
		<div class="input">
			<input type="text" name="ip" value="" />
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
		jQuery('#saveIPBlocked').ajaxForm(options); 
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