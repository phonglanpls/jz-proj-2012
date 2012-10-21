
<div class="clear"></div>
<div id="tab-menu2" class="status-type">
	<a href="javascript:void(0);" onclick="callFuncShowShareStatusFeature();" class="active" >Update status</a>
	<a href="javascript:void(0);" onclick="callFuncShowSharePhotoFeature();" >Add Photo</a>
</div>

<script type="text/javascript">
	$(function(){
		$('.status-type a').click(function(){
			$('.status-type a').removeClass('active');
			$(this).addClass('active');
		});
	});
</script>

<div class="clear"></div>

<div id="box-share-status">
	<div class="wrap">
		<div id="shareStatusControllerContext">
			<input type="hidden" id="shareContext" name="shareContext" value="status" />
			
			<div id="boxShareStatus">
				<p class="textarea">
					<textarea maxlength="<?php echo $GLOBALS['global']['INPUT_LIMIT']['wall_status'];?>" cols="10" rows="10" name="status" id="shareTxtStatus"><?php echo language_translate("wall_status_share_default");?></textarea>
				</p>
			</div>
			
			<div class="share-type">
				<!--<strong>Add:</strong> 
				<a href="javascript:void(0);" id="addLinkControllerCmdDiv">Link</a> | 
				<a href="javascript:void(0);" id="addPhotoControllerCmdDiv" onclick="callFuncShowSharePhotoFeature();">Photo</a> 
			 	<a href="javascript:void(0);" id="addVideoControllerCmdDiv">Video</a>	 
				Or 
				<a href="javascript:void(0);" id="takesnapshotWC" onclick="callFuncShowWebcamSnapshot();">Take a snapshot</a>
				-->
			</div>
			
			<div class="share-submit">
				<?php echo loader_image_s("id=\"shareStatusContextLoader\" class='hidden'");?>
				<input type="button" value="Share" name="submit" onclick="callFuncShareStatus();"/>
			</div>
		</div>
		
		
		<div id="sharePhotoControllerContext" class="hidden">
			
			<?php 
				echo form_open(
									$action = site_url("mod_io/wall_submit_async/submit_upload_photo"), 
									$attributes = "method='post' id='submit_upload_photo' name='submit_upload_photo' ", 
									$hidden = array()
							);
			?>
				<input type="hidden" id="shareContext" name="shareContext" value="photo" />
				
				<div id="boxShareStatus">
					<p class="textarea">
						<textarea maxlength="<?php echo $GLOBALS['global']['INPUT_LIMIT']['wall_status'];?>" cols="10" rows="10" name="status" id="shareTxtPhoto"><?php echo language_translate("wall_photo_share_default");?></textarea>
					</p>
				</div>
				
				<div style="margin:4px 0px;">
					<p>Select an image file on your computer.</p>
					
					<?php echo form_upload("photo");?>
				</div>
				
				<div class="share-type">
					<!--<strong>Add:</strong> 
					<a href="javascript:void(0);" id="addLinkControllerCmdDiv">Link</a> |  
					<a href="javascript:void(0);" id="addStatusControllerCmdDiv" onclick="callFuncShowShareStatusFeature();">Status</a> 
				 	<a href="javascript:void(0);" id="addVideoControllerCmdDiv">Video</a>	-->
				
					Or 
					<a href="javascript:void(0);" id="takesnapshotWC" onclick="callFuncShowWebcamSnapshot();">Take a snapshot</a>
				</div>
				
				<div class="share-submit">
					<?php echo loader_image_s("id=\"sharePhotoContextLoader\" class='hidden'");?>
					<input type="submit" value="Share" id="dosubmit" name="dosubmit" onclick="callFuncSharePhoto();"/>
				</div>
				
			<?php echo form_close();?>
		</div>
		
		<div class="clear"></div>
	</div>
</div>

<script type="text/javascript">
	$(document).ready(function(){
		if($('#shareContext').val() == 'status'){
			$('#shareTxtStatus').live('focusin',function(){
				if($(this).val() == '<?php echo language_translate("wall_status_share_default");?>'){
					$(this).val("");
				}
			});
		}
		$('#shareTxtPhoto').live('focusin',function(){
			if($(this).val() == '<?php echo language_translate("wall_photo_share_default");?>'){
				$(this).val("");
			}
		});
		
	});
	
	
	$(document).ready(function(){
		var options = { 
			beforeSubmit:  validateB4Submit,  
			success:       processAfterResponding  
		};	
		$('#submit_upload_photo').ajaxForm(options); 
	});
	
	function validateB4Submit(formData, jqForm, options){
		$('#sharePhotoContextLoader').show();
		return true;
	}

	function processAfterResponding(responseText, statusText, xhr, $form) {
		$('#sharePhotoContextLoader').hide();	
		if(responseText == 'ok'){
			//sysMessage("Upload successfully.", 'callFuncShowMyBackstage();$("#hiddenElement").dialog("close")');
			callFuncReloadWallSection();
		}else{
			sysWarning(responseText);
		}
	}
</script>