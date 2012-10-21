<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>

<?php 
	$gallerydata = $this->gallery_io_m->init('id_image',$this->input->get('id_photo'));
	$path = site_url()."image/thumb/photos/";
	
	echo form_open(
						$action = site_url("mod_io/backstage_func/submit_edit_my_photo"), 
						$attributes = "method='post' id='submit_edit_my_photo' name='submit_edit_my_photo' ", 
						$hidden = array()
				);
?>
<input type="hidden" name="id_photo" id="id_photo" value="<?php echo $this->input->get('id_photo');?>" />

<div id="wrap-dialog-box">	
	<div class="input">
		<img src="<?php echo $path.$gallerydata->image; ?>" />
	</div>
	<div class="input" id="questionArea">
		<label><strong>Title:</strong></label>
		<input type="text" class="disablecopypaste" name="title" id="title" maxlength="45" value="<?php echo $gallerydata->comment;?>" style="width:200px;" />
		
		<div class="clear"></div>
		<label>&nbsp;</label>You have <span id="leftLetters">45</span> characters left. 
	</div>
	
	<div class="input">
		<label><strong>Set price:</strong></label>
		<input type="text" name="price" id="price" maxlength="15" value="<?php echo $gallerydata->price;?>" style="width:200px;" />
	</div>
	
	<div class="input">
		<div class="input-padding">
			<?php echo loader_image_s("id='save_loader' class='hidden'");?>
			<input type="submit" value="Save" name="submitbtn" class="share-2" id="submit-button-id" />
		</div>
	</div>
</div>	
<?php echo form_close();?>

<script type="text/javascript">
	$(document).ready(function(){
		 $('.disablecopypaste').bind('copy paste', function (e) {
		   e.preventDefault();
		});
		
		var TOTAL = 45;
		$('#title').live('keyup',function(){
			$length = 45 - $(this).val().length;
			$('#leftLetters').text($length);
		});
	});
	
	$(document).ready(function(){
		var options = { 
			beforeSubmit:  validateB4Submit,  
			success:       processAfterResponding  
		};	
		$('#submit_edit_my_photo').ajaxForm(options); 
	});
	
	function validateB4Submit(formData, jqForm, options){
		$('#save_loader').show();
		return true;
	}

	function processAfterResponding(responseText, statusText, xhr, $form) {
		$('#save_loader').hide();	
		if(responseText == 'ok'){
			sysMessage("Edit successfully.", 'callFuncShowMyBackstage();$("#hiddenElement").dialog("close")');
		}else{
			sysWarning(responseText);
		}
	}
</script>