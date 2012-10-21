
<?php 
	$announcement = $this->db->query( " SELECT * FROM ".TBL_CONFIG." WHERE name LIKE 'ANNOUNCEMENT' AND f_key LIKE 'content'")->result();
?>


<?php echo form_open( 	site_url('admin/juzon/config/saveAnnouncement'), 
						$attributes = "method='post' id='saveAnnouncement' name='saveAnnouncement'", 
						$hidden = array() 
					);					
?> 

<div id="dialog-wrap">
	<div class="row-item">
		<label> Content</label>
		<div class="input">
			<textarea name="announcement" style="width:300px;height:100px;"><?php echo $announcement[0]->f_value?></textarea>
			
			<div class="clear"></div>
			
			<input type="checkbox" value="1" name="is_show" <?php if($announcement[0]->value=='1'){echo 'checked="checked"';}?> /> Show Announcement
			
			<div class="clear"></div>
			
			<input type="submit" value="Save" />
			<?php echo loader_image_s("id='save_loader'");?>
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
		jQuery('#saveAnnouncement').ajaxForm(options); 
		jQuery('#save_loader').hide();	
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
		queryurl(BASE_URI+'admin/juzon/config');
	}
</script>