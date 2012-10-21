<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>

<?php 
	echo form_open(
						$action = site_url("mod_io/collection_func/submit_my_photo"), 
						$attributes = "method='post' id='submit_my_photo' name='submit_my_photo' ", 
						$hidden = array()
				);
?>

<div id="wrap-dialog-box">	
	<div class="input">
		Accept picture file format: <?php echo implode(', ',allowExtensionPictureUpload());?> <br/>
		Maximum file size: <?php echo allowMaxFileSize();?>Mb.
	</div>
	
	<div class="input">
		<label><strong>&nbsp;</strong></label>
		<?php echo form_upload("my_photo");?>
	</div>
	
	<div class="input" id="questionArea">
		<label><strong>Title:</strong></label>
		<input type="text" class="disablecopypaste" name="title" id="title" maxlength="45" value="" style="width:200px;" />
		
		<div class="clear"></div>
		<label>&nbsp;</label>You have <span id="leftLetters_">45</span> characters left. 
	</div>
	
	<div class="input">
		<!--
		<a href="javascript:void(0);" onclick="callFuncLoadWCUI_PUBLICPHOTO();">Use your webcam to take a snapshot</a>
		-->
		<input type="button" value="Use your webcam" name="submitbtn" class="share-2" onclick="callFuncLoadWCUI_PUBLICPHOTO();" />
		
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
			$length = TOTAL - $(this).val().length;
			$('#leftLetters_').text($length+'');
		});
	});
	
	$(document).ready(function(){
		var options = { 
			beforeSubmit:  validateB4Submit,  
			success:       processAfterResponding  
		};	
		$('#submit_my_photo').ajaxForm(options); 
	});
	
	function validateB4Submit(formData, jqForm, options){
		$('#save_loader').show();
		return true;
	}

	function processAfterResponding(responseText, statusText, xhr, $form) {
		$('#save_loader').hide();	
		if(responseText == 'ok'){
			sysMessage("Upload successfully.", 'callFuncShowMyPhoto()');
		}else{
			sysWarning(responseText);
		}
	}
</script>