<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>

<?php 
	$userdataobj = getAccountUserDataObject(true);
	$id_pet = $this->input->get('id_pet');
	$petdataobj	  = $this->user_io_m->init('id_user', $id_pet);
	$curval = $_SESSION['PET_CUR_VAL']; //value which owner must pay
	
	$premessage = $GLOBALS['global']['PRE_DEF_MESSAGE']['buy_pet'];
	$premessage = str_replace(array('$username','$amount'), array($petdataobj->username,$curval),$premessage);
?>

<div id="wrap-dialog-box">	
	<div class="input" id="messageArea">
		
		<label><strong>Message:</strong></label> 
		<textarea class="disablecopypaste" maxlength="100" cols="15" rows="5" style="width:392px;height:65px;" id="message" name="message"><?php echo $premessage;?></textarea>
		
		<div class="clear"></div>
		<label>&nbsp;</label>You have <span id="leftLetters">100</span> characters left. 
	</div>
	
	<div class="input">
		<div class="input-padding">
			<?php echo loader_image_s("id='postonwallloaderContext' class='hidden'");?>
			<input type="button" value="Post" class="share-2" id="submit-button-id" onclick="callFuncPostOnWall();" />
			<!-- <input type="button" value="Cancel" class="share-2" onclick="$('#hiddenElement').dialog('close');" /> -->
		</div>
	</div>
</div>	


<script type="text/javascript">
	var TOTAL = 100;
	
	$(document).ready(function(){
		calLeftLetters();
		$('#message').live('keyup',function(){
			calLeftLetters();
		});
	});
	
	function calLeftLetters(){
		$length = TOTAL - $('#message').val().length;
		$('#leftLetters').text($length);
	}
</script>