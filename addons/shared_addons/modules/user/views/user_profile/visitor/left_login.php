
<?php 
    $_SESSION['USER_INVITE']['id_user'] = $userdataobj->id_user;
    
	if($this->facebookmodel->getCurrentFacebookUser()){
		if($id_user = $this->facebookmodel->isFacebookConnected()){
			$this->mod_io_m->update_map( array('access_token'=>$this->facebookmodel->getUserAccessToken()), array('userid'=>$id_user), TBL_FACEBOOK_CONNECT);
		}
		
		if($this->facebookmodel->getCurrentFacebookUser()){
			redirect("member/proceedFacebookUserConnected");
		}else{
			redirect("member/fb_register");
		}
	}
	
	if(isTwitterLogin()){
		if($this->twittermodel->isTwitterConnected()){
			redirect("member/proceedTwitterUserConnected");
		}else{
			redirect("member/tt_register");
		}	
	}
    
    $full_url = site_url();
?>
<aside>
 <div id="left_login">

    <?php echo form_open($action = site_url("member/submit_site_login"), $attributes = "method='post' id='submit_site_login' name='submit_site_login' ", $hidden = array());?>
		<div class="input">
			<label><?php echo language_translate('member_login_label_email');?></label>
			<input type="text" value="" name="email" class="text" maxlength="45" />
		</div>
		<div class="input">
			<label><?php echo language_translate('member_login_label_password');?></label>
			<input type="password" value="" name="password" class="text" maxlength="45" />
		</div>
		<div class="input">
			<div class="input-padding">
				<p>
					<input type="checkbox" value="1" class="checkbox" name="remember"><?php echo language_translate('member_login_remember_me');?><br>
					<a href="<?php echo site_url("member/forgot_password");?>"><?php echo language_translate('member_login_label_forgot_password');?></a>
				</p>
				<input style="float: right;margin:10px 52px 10px 0px;" type="submit" value="<?php echo language_translate('member_login_button_login');?>" name="submit" class="share-2" />
			</div>
		</div>
	<?php echo form_close();?>
	
	<div class="input">
		<a href="<?php echo $this->facebookmodel->getLoginLogoutUrl();?>"><img src="<?php echo site_url();?>media/images/facebook.png" alt="facebook" title="facebook"></a>
		<a href="<?php echo $this->twittermodel->getAuthorizeURL();?>"><img src="<?php echo site_url();?>media/images/twitter.png" alt="twitter" title="twitter"></a>
	</div>
	
	<div class="clear"></div>
 
 </div>   
 </aside>
 
<script type="text/javascript">
	$(document).ready(function() {
		var options = { 
			dataType:  'json', 	
			beforeSubmit:  validateB4Submit,  
			success:       processAfterResponding   
		};	
		$('#submit_site_login').ajaxForm(options); 
	});	
		
	function validateB4Submit(formData, jqForm, options){
		siteLoadingOn();
		return true;
	}

	function processAfterResponding(responseJson, statusText, xhr, $form) {
		siteLoadingOff();
		if(responseJson.status == 'ok'){
			siteMessage(responseJson.message);
			queryurl( BASE_URI+'user' );
        }else if(responseJson.status == 'fake_email'){
            queryurl( BASE_URI+'member/fake_email_detect' );
		}else{
			siteWarning(responseJson.message);
		}
	}
</script>	   