
<?php 
	$id_series = intval( $this->input->get('id_series') );
	$seriesdata = $this->mod_io_m->init('id_series',$id_series,TBL_SERIES);
	
	$id_hentai_category = ($seriesdata)?$seriesdata->id_hentai_category:null;
?>


<?php echo form_open( 	site_url('admin/juzon/hentai/saveSeries'), 
						$attributes = "method='post' id='saveSeries' name='saveSeries'", 
						$hidden = array() 
					);					
?> 

<input type="hidden" name="id_series" value="<?php echo $id_series;?>" />

<div id="dialog-wrap">
	<div class="row-item">
		
		<label> Category</label>
		<div class="input">
			<?php echo form_dropdown('id_hentai_category',$this->juzon_hentai_m->getHentaiCategoriesArray('NO_SELECTED'),array($id_hentai_category), 'id="id_hentai_category"');?>
		</div>
		
		<div class="clear"></div>
		
		<label> Name</label>
		<div class="input">
			<input type="text" name="name" value="<?php if($seriesdata) echo $seriesdata->name;?>" />
		</div>
		
		<div class="clear"></div>
		
		<div id="wrapFacebook">
			<label> Image URL</label>
			<div class="input">
				<input type="text" name="img_url" value="<?php if($seriesdata) echo $seriesdata->img_url;?>" />
				<div class="clear"></div>
				<?php if($seriesdata AND $seriesdata->img_url):?>
					<img src="<?php echo $seriesdata->img_url;?>" />
				<?php endif;?>
			</div>
			<div class="clear"></div>
		</div>
		
		<div class="clear"></div>
		
		<div id="wrapDailymotion">
			<label>Image</label>
			<div class="input">
				<?php echo form_upload("image");?> <br/>
				(Accept .jpg image file.)
				<div class="clear"></div>
				<?php 
					if($seriesdata AND $seriesdata->image):
					$thumbPath = site_url().'image/thumb/hentai/dailymotion/'.$seriesdata->image.'.jpg';
				?>
					<img src="<?php echo $thumbPath;?>" />
				<?php endif; ?>
			</div>
			<div class="clear"></div>
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
	var category_id;
	
	jQuery(document).ready(function(){
		var options = { 
			beforeSubmit:  validateB4Submit,  
			success:       processAfterResponding  
		};	
		jQuery('#saveSeries').ajaxForm(options); 
	 
		category_id = $('#id_hentai_category').val();
		loadCorrespondImage(category_id);
		
		$('#id_hentai_category').bind('change',function(){
			category_id = $(this).val();
			loadCorrespondImage(category_id);
		});
	});
	
	function loadCorrespondImage(hentai_category_id){
		if(hentai_category_id == '1'){
			$('#wrapFacebook').show();
			$('#wrapDailymotion').hide();
		}else{
			$('#wrapDailymotion').show();
			$('#wrapFacebook').hide();
		}
	}
	
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