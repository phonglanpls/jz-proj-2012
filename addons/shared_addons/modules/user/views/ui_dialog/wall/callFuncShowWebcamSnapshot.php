
<script type="text/javascript" src="<?php echo site_url() ?>media/js/webcam.js"></script>
<script language="text/javascript">
	webcam.set_swf_url('<?php echo site_url();?>media/js/webcam.swf');
	webcam.set_shutter_sound(true,'<?php echo site_url();?>media/js/shutter.mp3');
	webcam.set_api_url( '<?php echo site_url();?>webcam.php' );
	webcam.set_quality( 90 ); // JPEG quality (1 - 100)
	//webcam.set_shutter_sound( true ); // play shutter click sound
</script>

<div id="wrap-dialog-box">	

	<div style="width:100%;float:left;">
		<div id="webcam_ssn" style="width:45%;float:left;">
			<div id="webcam"></div> 
			
			<div class="clear"></div>
			
			<div id="controller" style="margin-top:15px;">
				<input type="button" value="Configure" class="share-2" onClick="webcam.configure()" />
				&nbsp;&nbsp;
				<input type="button" value="Capture" class="share-2" onClick="webcam.freeze()" />
				&nbsp;&nbsp;
				<input type="button" value="Save" class="share-2" onClick="do_upload()" />
				&nbsp;&nbsp;
				<input type="button" value="Reset" class="share-2" onClick="webcam.reset()" />
			</div>
			
		</div>
		
		<div id="webcam_image" style="width:45%;float:right;">
			<div id="image_saved"></div> 
			
			<div class="clear"></div>
			
			<div id="share_status" class="hidden">
				<input type="hidden" id="image_name" value="" />
				
				<textarea maxlength="<?php echo $GLOBALS['global']['INPUT_LIMIT']['wall_status'];?>" cols="10" rows="10" style="width:100%;height:125px;" name="status" id="shareTxtWC"><?php echo language_translate("wall_photo_share_default");?></textarea>
				
				
				<div class="share-submit">
					<?php echo loader_image_s("id=\"shareWCSnapshotContextLoader\" class='hidden'");?>
					<input type="button" value="Share" id="dosubmit" name="dosubmit" onclick="callFuncShareSnapshotWebcam();"/>
					<input type="button" value="Cancel" onclick="$('#hiddenElement').dialog('close');"/>
					
				</div>
			</div>
		</div>
	</div>
	
</div>	










<script language="text/javascript">
	var sharing = 0;
	$(document).ready(function(){
		$('#webcam').html(webcam.get_html(350,300,<?php echo WC_W;?>, <?php echo WC_H;?>));
		
		$('#shareTxtWC').live('focusin',function(){
			if($(this).val() == '<?php echo language_translate("wall_photo_share_default");?>'){
				$(this).val("");
			}
		});
	});
	
	webcam.set_hook( 'onComplete', 'my_completion_handler' );
		
	function do_upload() {
		// upload to server
		$('#image_saved').html('Uploading...');
		$('#share_status').hide();
		webcam.upload();
	}
	
	function my_completion_handler(msg) {
		// extract URL out of PHP output
		var stt = msg.split('|');
		if (stt[1] == 'ok') {
			var image_url = '<?php echo site_url().'webcamtemp/'?>'+stt[0];
			//var src = '<?php echo site_url()?>timthumb.php?w=300&h=200&zc=1&src='+image_url;
			$('#image_saved').html( '<img src="' + image_url + '" width="300px" />');
			webcam.reset();
			$('#share_status').show();
			$('#image_name').attr('value',stt[0]);
		}
		else alert("PHP Error: " + msg);
	}
</script>