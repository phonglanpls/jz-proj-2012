<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>

<?php 
	$photodataobj = $this->gallery_io_m->init('id_image',$this->input->get('id_gallery'));
	echo form_open(
						$action = site_url("mod_io/collection_func/edit_my_photo"), 
						$attributes = "method='post' id='edit_my_photo' name='edit_my_photo' ", 
						$hidden = array()
				);
?>

<?php echo form_hidden($name="id_image",$value=$photodataobj->id_image);?>

<div id="wrap-dialog-box">	
	<div class="input">
		<img src="<?php echo site_url().$GLOBALS['global']['IMAGE']['image_orig']."photos/".$photodataobj->image;?>" />
	</div>
	
	<div class="input" id="questionArea">
		<label><strong>Title:</strong></label>
		<input type="text" class="disablecopypaste" name="title" id="title" maxlength="45" value="<?php echo $photodataobj->comment;?>" style="width:200px;" />
		
		<div class="clear"></div>
		<label>&nbsp;</label>You have <span id="leftLetters">45</span> characters left. 
	</div>
	
	<div class="input">
		<label><strong>&nbsp;</strong></label>
		<?php echo form_checkbox( $data = 'is_profile', $value = '1', $checked = ($photodataobj->prof_flag==1)?TRUE:FALSE, $extra = '')?>
		Mark it as profile avatar.
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
		$('#edit_my_photo').ajaxForm(options); 
	});
	
	function validateB4Submit(formData, jqForm, options){
		$('#save_loader').show();
		return true;
	}

	function processAfterResponding(responseText, statusText, xhr, $form) {
		$('#save_loader').hide();	
		if(responseText == 'ok'){
			sysMessage("Save successfully.", 'callFuncReloadMyProfileSection()');
		}else{
			sysWarning(responseText);
		}
	}
</script>