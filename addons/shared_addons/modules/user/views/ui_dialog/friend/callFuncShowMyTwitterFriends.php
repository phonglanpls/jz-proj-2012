<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>

<?php 
	$maxlength = 80;
	echo form_open(
						$action = site_url("mod_io/friend_async/submit_invite_twitter_friend"), 
						$attributes = "method='post' id='submit_invite_twitter_friend' name='submit_invite_twitter_friend' ", 
						$hidden = array()
				);
				
	$dataArr = $this->twittermodel->getCurrentUserDetails();
	$myScreenName = $dataArr['screen_name'];
	
	$followerObj = json_decode(file_get_contents("https://api.twitter.com/1/followers/ids.json?screen_name=$myScreenName"));
	$friendObj = json_decode(file_get_contents("https://api.twitter.com/1/friends/ids.json?screen_name=$myScreenName"));
	
	$idUsersArray = array_unique( array_filter( array_merge($followerObj->ids, $friendObj->ids)) );	
?>

<div id="wrap-dialog-box">	
	<div class="input" id="questionArea">
		<label><strong>Message:</strong></label>
		
		<div class="clear"></div>
		<label>&nbsp;</label> <textarea class="disablecopypaste" maxlength="<?php echo $maxlength;?>" cols="15" rows="5" style="width:392px;height:45px;" id="message" name="message"><?php echo $GLOBALS['global']['TWITTER']['FirstStatusMessage'];?></textarea>
		
		<div class="clear"></div>
		<label>&nbsp;</label>You have <span id="leftLetters"><?php echo $maxlength;?></span> characters left. 
		
		<div class="clear"></div>
	 
		<label>&nbsp;</label>
		<input type="checkbox" name="select_all" id="select_all" class="checkAll" />
		Check all?
	 
	</div>
	
	<div class="clear"></div>
	<div class="input" id="fbFriends">
		<?php $i=0; foreach($idUsersArray as $id):?>
			<?php 
				$userdata = json_decode(file_get_contents("https://api.twitter.com/1/users/lookup.json?user_id=$id&include_entities=true"));
			?>
				<div class="wrap-left" style="width:23%;">
					<div class="user-profile-avatar">
						<?php echo "<img src=".$userdata[0]->profile_image_url." />";?>
					</div>
				 
					<div class="user-profile-owner">
						<?php echo $userdata[0]->screen_name;?>
						<div class="clear"></div>
						<input type="checkbox" name="usercheck[]" value="<?php echo $userdata[0]->screen_name;?>"/>
					</div>
				</div>
				
				<?php $i++;?>
				<?php if($i % 4 ==0):?>
					<div class="clear"></div>
				<?php endif;?>
				
			 
		<?php endforeach;?>
		
		
	</div>
	
	<div class="input">
		<div id="sys_message">Send message successfully.</div>
		<div class="input-padding">
			<?php echo loader_image_s("id='save_loader' class='hidden'");?>
			<input type="submit" value="Send" name="submit" class="share-2" id="submit-button-id" />
		</div>
	</div>
</div>	
<?php echo form_close();?>

<script type="text/javascript">
	$(document).ready(function(){
		 $('textarea.disablecopypaste').bind('copy paste', function (e) {
		   e.preventDefault();
		});
		
		var TOTAL = <?php echo $maxlength;?>;
		$('#message').live('keyup',function(){
			$length = TOTAL - $(this).val().length;
			$('#leftLetters').text($length);
		});
		
		$('input:checkbox').attr('checked',true);
		$('.checkAll').click(function(){
			if($(this).attr('checked')){
				$('input:checkbox').attr('checked',true);
			}
			else{
				$('input:checkbox').attr('checked',false);
			}
		});
	});
	
	$(document).ready(function(){
		var options = { 
			beforeSubmit:  validateB4Submit,  
			success:       processAfterResponding  
		};	
		$('#submit_invite_twitter_friend').ajaxForm(options); 
	});
	
	function validateB4Submit(formData, jqForm, options){
		$('#save_loader').show();
		return true;
	}

	function processAfterResponding(responseText, statusText, xhr, $form) {
		$('#save_loader').hide();	
		if(responseText == 'ok'){
			$('#questionArea,#submit-button-id,#fbFriends').hide();
			showSysMessage();
			$('#hiddenElement').dialog({height:100});
			setTimeout(function(){$('#hiddenElement').dialog("close");},DELAY);
			siteLoadingDialogOff();
		 
		}else{
			debug(responseText);
		}
	}
	 
</script>