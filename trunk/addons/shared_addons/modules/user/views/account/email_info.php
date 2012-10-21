<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>

<?php 
	$userdataobj = getAccountUserDataObject(true);
	$emailSetting = $this->email_setting_io_m->init($userdataobj->id_user);
?>


<?php 
	echo form_open(
						$action = site_url("mod_io/account_func/submit_change_email_setting"), 
						$attributes = "method='post' id='submit_change_email_setting' name='submit_change_email_setting' ", 
						$hidden = array()
				);
?>
<div class="box-profile user-profile body-container">
	<h3><?php echo language_translate('email_info_label_email_setting');?></h3>
	
	<label><?php echo language_translate('email_info_label_chatter_comment');?></label> 
	<div class="inputcls">
		<input type="radio" name="chatter_comment" value="1" <?php echo ($emailSetting->chatter_comment==1)?'checked="checked"':'';?> />ON &nbsp;&nbsp;
		<input type="radio" name="chatter_comment" value="0" <?php echo ($emailSetting->chatter_comment==0)?'checked="checked"':'';?> />OFF &nbsp;&nbsp;	
	</div>
	 
	<div class="clear sep"></div>
<!--	
	<label>Chatter Rating:</label> 
	<div class="inputcls">
		<input type="radio" name="chatter_rating" value="1" <?php //echo ($emailSetting->chatter_rating==1)?'checked="checked"':'';?> />ON &nbsp;&nbsp;
		<input type="radio" name="chatter_rating" value="0" <?php //echo ($emailSetting->chatter_rating==0)?'checked="checked"':'';?> />OFF &nbsp;&nbsp;	
	</div>
	 
	<div class="clear sep"></div>
-->	
	<label><?php echo language_translate('email_info_label_askme_question');?></label> 
	<div class="inputcls">
		<input type="radio" name="askme_question" value="1" <?php echo ($emailSetting->askme_question==1)?'checked="checked"':'';?> />ON &nbsp;&nbsp;
		<input type="radio" name="askme_question" value="0" <?php echo ($emailSetting->askme_question==0)?'checked="checked"':'';?> />OFF &nbsp;&nbsp;	
	</div>
	 
	<div class="clear sep"></div>
	
	<label><?php echo language_translate('email_info_label_askme_answer');?></label> 
	<div class="inputcls">
		<input type="radio" name="askme_answer" value="1" <?php echo ($emailSetting->askme_answer==1)?'checked="checked"':'';?> />ON &nbsp;&nbsp;
		<input type="radio" name="askme_answer" value="0" <?php echo ($emailSetting->askme_answer==0)?'checked="checked"':'';?> />OFF &nbsp;&nbsp;	
	</div>
	 
	<div class="clear sep"></div>
	
	<label><?php echo language_translate('email_info_label_photo_comment');?></label> 
	<div class="inputcls">
		<input type="radio" name="photo_comment" value="1" <?php echo ($emailSetting->photo_comment==1)?'checked="checked"':'';?> />ON &nbsp;&nbsp;
		<input type="radio" name="photo_comment" value="0" <?php echo ($emailSetting->photo_comment==0)?'checked="checked"':'';?> />OFF &nbsp;&nbsp;	
	</div>
<!--	 
	<div class="clear sep"></div>
	
	<label>Video Comment:</label> 
	<div class="inputcls">
		<input type="radio" name="video_comment" value="1" <?php //echo ($emailSetting->video_comment==1)?'checked="checked"':'';?> />ON &nbsp;&nbsp;
		<input type="radio" name="video_comment" value="0" <?php //echo ($emailSetting->video_comment==0)?'checked="checked"':'';?> />OFF &nbsp;&nbsp;	
	</div>

	<div class="clear sep"></div>
	
	<label>Backstage Photo Comment:</label> 
	<div class="inputcls">
		<input type="radio" name="backstage_photo_comment" value="1" <?php echo ($emailSetting->backstage_photo_comment==1)?'checked="checked"':'';?> />ON &nbsp;&nbsp;
		<input type="radio" name="backstage_photo_comment" value="0" <?php echo ($emailSetting->backstage_photo_comment==0)?'checked="checked"':'';?> />OFF &nbsp;&nbsp;	
	</div>
-->	 	 
	<div class="clear sep"></div>
<!--	
	<label>Backstage Video Comment:</label> 
	<div class="inputcls">
		<input type="radio" name="backstage_video_comment" value="1" <?php //echo ($emailSetting->backstage_video_comment==1)?'checked="checked"':'';?> />ON &nbsp;&nbsp;
		<input type="radio" name="backstage_video_comment" value="0" <?php //echo ($emailSetting->backstage_video_comment==0)?'checked="checked"':'';?> />OFF &nbsp;&nbsp;	
	</div>
	 
	<div class="clear sep"></div>
-->	
	<label><?php echo language_translate('email_info_label_like_chatter');?></label> 
	<div class="inputcls">
		<input type="radio" name="like_chatter" value="1" <?php echo ($emailSetting->like_chatter==1)?'checked="checked"':'';?> />ON &nbsp;&nbsp;
		<input type="radio" name="like_chatter" value="0" <?php echo ($emailSetting->like_chatter==0)?'checked="checked"':'';?> />OFF &nbsp;&nbsp;	
	</div>
	 
	<div class="clear sep"></div>
	
	<label><?php echo language_translate('email_info_label_photo_rating');?></label> 
	<div class="inputcls">
		<input type="radio" name="photo_rating" value="1" <?php echo ($emailSetting->photo_rating==1)?'checked="checked"':'';?> />ON &nbsp;&nbsp;
		<input type="radio" name="photo_rating" value="0" <?php echo ($emailSetting->photo_rating==0)?'checked="checked"':'';?> />OFF &nbsp;&nbsp;	
	</div>
	 
	<div class="clear sep"></div>
<!--	
	<label>Video Rating:</label> 
	<div class="inputcls">
		<input type="radio" name="video_rating" value="1" <?php //echo ($emailSetting->video_rating==1)?'checked="checked"':'';?> />ON &nbsp;&nbsp;
		<input type="radio" name="video_rating" value="0" <?php //echo ($emailSetting->video_rating==0)?'checked="checked"':'';?> />OFF &nbsp;&nbsp;	
	</div>
	 
	<div class="clear sep"></div>

	<label>Message Send:</label> 
	<div class="inputcls">
		<input type="radio" name="message_send" value="1" <?php //echo ($emailSetting->message_send==1)?'checked="checked"':'';?> />ON &nbsp;&nbsp;
		<input type="radio" name="message_send" value="0" <?php //echo ($emailSetting->message_send==0)?'checked="checked"':'';?> />OFF &nbsp;&nbsp;	
	</div>
	 
	<div class="clear sep"></div>
	
	<label>Flirt Message:</label> 
	<div class="inputcls">
		<input type="radio" name="flirt_message" value="1" <?php //echo ($emailSetting->flirt_message==1)?'checked="checked"':'';?> />ON &nbsp;&nbsp;
		<input type="radio" name="flirt_message" value="0" <?php //echo ($emailSetting->flirt_message==0)?'checked="checked"':'';?> />OFF &nbsp;&nbsp;	
	</div>
	 
	<div class="clear sep"></div>
-->		
	<label><?php echo language_translate('email_info_label_friend_request');?></label> 
	<div class="inputcls">
		<input type="radio" name="friend_request" value="1" <?php echo ($emailSetting->friend_request==1)?'checked="checked"':'';?> />ON &nbsp;&nbsp;
		<input type="radio" name="friend_request" value="0" <?php echo ($emailSetting->friend_request==0)?'checked="checked"':'';?> />OFF &nbsp;&nbsp;	
	</div>
	 
	<div class="clear sep"></div>
	
	<label><?php echo language_translate('email_info_label_friend_confirm');?></label> 
	<div class="inputcls">
		<input type="radio" name="friend_confirm" value="1" <?php echo ($emailSetting->friend_confirm==1)?'checked="checked"':'';?> />ON &nbsp;&nbsp;
		<input type="radio" name="friend_confirm" value="0" <?php echo ($emailSetting->friend_confirm==0)?'checked="checked"':'';?> />OFF &nbsp;&nbsp;	
	</div>
	 
	<div class="clear sep"></div>
	
	<label><?php echo language_translate('email_info_label_send_gift');?></label> 
	<div class="inputcls">
		<input type="radio" name="send_gift" value="1" <?php echo ($emailSetting->send_gift==1)?'checked="checked"':'';?> />ON &nbsp;&nbsp;
		<input type="radio" name="send_gift" value="0" <?php echo ($emailSetting->send_gift==0)?'checked="checked"':'';?> />OFF &nbsp;&nbsp;	
	</div>
	 
	<div class="clear sep"></div>
	
	<label><?php echo language_translate('email_info_label_buy_pet');?></label> 
	<div class="inputcls">
		<input type="radio" name="buy_pet" value="1" <?php echo ($emailSetting->buy_pet==1)?'checked="checked"':'';?> />ON &nbsp;&nbsp;
		<input type="radio" name="buy_pet" value="0" <?php echo ($emailSetting->buy_pet==0)?'checked="checked"':'';?> />OFF &nbsp;&nbsp;	
	</div>
	 
	<div class="clear sep"></div>
	
	<label><?php echo language_translate('email_info_label_lock_pet');?></label> 
	<div class="inputcls">
		<input type="radio" name="lock_pet" value="1" <?php echo ($emailSetting->lock_pet==1)?'checked="checked"':'';?> />ON &nbsp;&nbsp;
		<input type="radio" name="lock_pet" value="0" <?php echo ($emailSetting->lock_pet==0)?'checked="checked"':'';?> />OFF &nbsp;&nbsp;	
	</div>
	 
	<div class="clear sep"></div>
	
	<label><?php echo language_translate('email_info_label_alert_me_other_buy_my_pet');?></label> 
	<div class="inputcls">
		<input type="radio" name="alertme_buymypet" value="1" <?php echo ($emailSetting->alertme_buymypet==1)?'checked="checked"':'';?> />ON &nbsp;&nbsp;
		<input type="radio" name="alertme_buymypet" value="0" <?php echo ($emailSetting->alertme_buymypet==0)?'checked="checked"':'';?> />OFF &nbsp;&nbsp;	
	</div>
	 
	<div class="clear sep"></div>
	
	<label><?php echo language_translate('email_info_label_birthday_alert');?></label> 
	<div class="inputcls">
		<input type="radio" name="bday_confirm" value="1" <?php echo ($emailSetting->bday_confirm==1)?'checked="checked"':'';?> />ON &nbsp;&nbsp;
		<input type="radio" name="bday_confirm" value="0" <?php echo ($emailSetting->bday_confirm==0)?'checked="checked"':'';?> />OFF &nbsp;&nbsp;	
	</div>
	 
	<div class="clear sep"></div>
<!--	
	<label>Profile Rating:</label> 
	<div class="inputcls">
		<input type="radio" name="profile_rating" value="1" <?php //echo ($emailSetting->profile_rating==1)?'checked="checked"':'';?> />ON &nbsp;&nbsp;
		<input type="radio" name="profile_rating" value="0" <?php //echo ($emailSetting->profile_rating==0)?'checked="checked"':'';?> />OFF &nbsp;&nbsp;	
	</div>
	 
	<div class="clear sep"></div>
-->	
	<label><?php echo language_translate('email_info_label_who_check_me');?></label> 
	<div class="inputcls">
		<input type="radio" name="who_checked_me" value="1" <?php echo ($emailSetting->who_checked_me==1)?'checked="checked"':'';?> />ON &nbsp;&nbsp;
		<input type="radio" name="who_checked_me" value="0" <?php echo ($emailSetting->who_checked_me==0)?'checked="checked"':'';?> />OFF &nbsp;&nbsp;	
	</div>
	 
	<div class="clear sep"></div>
	
	<label><?php echo language_translate('email_info_label_who_buy_my_map');?></label> 
	<div class="inputcls">
		<input type="radio" name="who_bought_map_location" value="1" <?php echo ($emailSetting->who_bought_map_location==1)?'checked="checked"':'';?> />ON &nbsp;&nbsp;
		<input type="radio" name="who_bought_map_location" value="0" <?php echo ($emailSetting->who_bought_map_location==0)?'checked="checked"':'';?> />OFF &nbsp;&nbsp;	
	</div>
	 
	<div class="clear sep"></div>
	
	<label><?php echo language_translate('email_info_label_announcement');?></label> 
	<div class="inputcls">
		<input type="radio" name="announcement" value="1" <?php echo ($emailSetting->announcement==1)?'checked="checked"':'';?> />ON &nbsp;&nbsp;
		<input type="radio" name="announcement" value="0" <?php echo ($emailSetting->announcement==0)?'checked="checked"':'';?> />OFF &nbsp;&nbsp;	
	</div>
	 
	<div class="clear sep"></div>
	
	<label><?php echo language_translate('email_info_label_offline_chat');?></label> 
	<div class="inputcls">
		<input type="radio" name="offline_chat" value="1" <?php echo ($emailSetting->offline_chat==1)?'checked="checked"':'';?> />ON &nbsp;&nbsp;
		<input type="radio" name="offline_chat" value="0" <?php echo ($emailSetting->offline_chat==0)?'checked="checked"':'';?> />OFF &nbsp;&nbsp;	
	</div>
	 
	<div class="clear sep"></div>
	
	<label><?php echo language_translate('email_info_label_who_buy_backstage');?></label> 
	<div class="inputcls">
		<input type="radio" name="bought_backstage_photo" value="1" <?php echo ($emailSetting->bought_backstage_photo==1)?'checked="checked"':'';?> />ON &nbsp;&nbsp;
		<input type="radio" name="bought_backstage_photo" value="0" <?php echo ($emailSetting->bought_backstage_photo==0)?'checked="checked"':'';?> />OFF &nbsp;&nbsp;	
	</div>
	 
	<div class="clear sep"></div>
<!--	
	<label>Bought Backstage Video:</label> 
	<div class="inputcls">
		<input type="radio" name="bought_backstage_video" value="1" <?php //echo ($emailSetting->bought_backstage_video==1)?'checked="checked"':'';?> />ON &nbsp;&nbsp;
		<input type="radio" name="bought_backstage_video" value="0" <?php //echo ($emailSetting->bought_backstage_video==0)?'checked="checked"':'';?> />OFF &nbsp;&nbsp;	
	</div>
	 
	<div class="clear sep"></div>
	
	<label>Personality Rating:</label> 
	<div class="inputcls">
		<input type="radio" name="personality_rating" value="1" <?php //echo ($emailSetting->personality_rating==1)?'checked="checked"':'';?> />ON &nbsp;&nbsp;
		<input type="radio" name="personality_rating" value="0" <?php //echo ($emailSetting->personality_rating==0)?'checked="checked"':'';?> />OFF &nbsp;&nbsp;	
	</div>
	 
	<div class="clear sep"></div>
	
	<label>Personality Review:</label> 
	<div class="inputcls">
		<input type="radio" name="personality_review" value="1" <?php //echo ($emailSetting->personality_review==1)?'checked="checked"':'';?> />ON &nbsp;&nbsp;
		<input type="radio" name="personality_review" value="0" <?php //echo ($emailSetting->personality_review==0)?'checked="checked"':'';?> />OFF &nbsp;&nbsp;	
	</div>
	 
	<div class="clear sep"></div>
-->	
	<label><?php echo language_translate('email_info_label_who_buy_who_peep_me');?></label> 
	<div class="inputcls">
		<input type="radio" name="bought_who_peeped_me" value="1" <?php echo ($emailSetting->bought_who_peeped_me==1)?'checked="checked"':'';?> />ON &nbsp;&nbsp;
		<input type="radio" name="bought_who_peeped_me" value="0" <?php echo ($emailSetting->bought_who_peeped_me==0)?'checked="checked"':'';?> />OFF &nbsp;&nbsp;	
	</div>
	 
	<div class="clear sep"></div>
	
	<label>&nbsp;</label> 
	<div class="inputcls">
		<input type="submit" value="<?php echo language_translate('sys_button_title_save');?>" name="submit" class="share-2" />
		<input type="button" value="<?php echo language_translate('sys_button_title_reset');?>" class="share-2" onclick="callFuncLoadDefaultEmailSetting();"/>
		<?php echo loader_image_s("id='emailSettingContextLoader' class='hidden'");?>
	</div>
	
	<div class="clear"></div>
	
</div>

<?php echo form_close();?>


<script type="text/javascript">
	
	$(document).ready(function(){
		var options = { 
			dataType:  'json', 	
			beforeSubmit:  validateB4Submit,  
			success:       processAfterResponding  
		};	
		$('#submit_change_email_setting').ajaxForm(options); 
		
	});
	
	function validateB4Submit(formData, jqForm, options){
		$('#emailSettingContextLoader').toggle();
		return true;
	}

	function processAfterResponding(responseText, statusText, xhr, $form) {
		$('#emailSettingContextLoader').toggle();	
		if(responseText.result == 'ok'){
			sysMessage(responseText.message,'callFuncLoadDefaultEmailSetting()');
		}else{
			sysWarning(responseText.message);
		}
	}
</script>
	












