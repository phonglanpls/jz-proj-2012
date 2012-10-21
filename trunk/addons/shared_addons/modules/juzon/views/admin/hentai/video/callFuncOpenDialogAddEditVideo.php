
<?php 
	$id_video = intval( $this->input->get('id_video') );
	$videodata = $this->mod_io_m->init('id_video',$id_video,TBL_VIDEO);
	
	if($videodata){
		$seriesdata = $this->mod_io_m->init('id_series',$videodata->id_series,TBL_SERIES);
	}
	$id_hentai_category = isset($seriesdata)?$seriesdata->id_hentai_category:1;
	$id_series = isset($seriesdata)?$seriesdata->id_series:null;
?>


<?php echo form_open( 	site_url('admin/juzon/hentai/saveVideo'), 
						$attributes = "method='post' id='saveVideo' name='saveVideo'", 
						$hidden = array() 
					);					
?> 

<input type="hidden" name="id_video" value="<?php echo $id_video;?>" />

<div id="dialog-wrap">
	<div class="row-item">
		
		<label> Category</label>
		<div class="input">
			<?php echo form_dropdown('id_hentai_category',$this->juzon_hentai_m->getHentaiCategoriesArray('NO_SELECTED'),array($id_hentai_category), 'id="id_hentai_category"');?>
			<div class="clear"></div>
		</div>
		
		<div class="clear"></div>
		
		<label> Series</label>
		<div class="input" id="series_cate">
			<?php echo form_dropdown('id_series',$this->juzon_hentai_m->getSeriesArray($id_hentai_category),array($id_series), 'id="id_series"');?>
			<div class="clear"></div>
		</div>
		
		<div class="clear"></div>
		
		<label>Video Name</label>
		<div class="input">
			<input type="text" name="name" value="<?php if($videodata) echo $videodata->name;?>" />
			<div class="clear"></div>
		</div>
		
		<div class="clear"></div>
	 
		<label> Video URL</label>
		<div class="input">
			<input type="text" name="video_url" value="<?php if($videodata) echo $videodata->video_url;?>" />
			<div class="clear"></div>
		</div>
		<div class="clear"></div>
		
		<label>&nbsp;</label>
		<div class="input">
			<input type="submit" value="Submit" />
			<input type="button" value="Cancel" onclick="$('#hiddenElement').dialog('close');"/>
			<?php echo admin_loader_image_s("id='save_loader'");?>
			<div class="clear"></div>
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
		jQuery('#saveVideo').ajaxForm(options); 
	 
		$('#id_hentai_category').bind('change',function(){
			$('#series_cate').html('');
			category_id = $(this).val();
			loadCorrespondSeries(category_id);
		});
	});
	
	function loadCorrespondSeries(hentai_category_id){
		$.get(BASE_URI+'admin/juzon/hentai/loadCorrespondSeries',{hentai_category_id:hentai_category_id},function(res){
			$('#series_cate').html(res);
		});
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