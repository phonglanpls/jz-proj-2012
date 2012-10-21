<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<div id="fb-root"></div>
<script>(function(d, s, id) {
  var js, fjs = d.getElementsByTagName(s)[0];
  if (d.getElementById(id)) return;
  js = d.createElement(s); js.id = id;
  js.src = "//connect.facebook.net/en_US/all.js#xfbml=1&appId=126097570834019";
  fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));</script>
<?php 
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
<div id="page-login">
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
				<input type="submit" value="<?php echo language_translate('member_login_button_login');?>" name="submit" class="share-2" />
			</div>
		</div>
		<div class="input">
			<div id="guidetext"><?php echo language_translate('member_login_guide_text');?></div>
		</div>
	<?php echo form_close();?>
	
	<div style="text-align: right" class="input">
		<a href="<?php echo $this->facebookmodel->getLoginLogoutUrl();?>"><img src="<?php echo site_url();?>media/images/facebook.png" alt="facebook" title="facebook"></a>
		<a href="<?php echo $this->twittermodel->getAuthorizeURL();?>"><img src="<?php echo site_url();?>media/images/twitter.png" alt="twitter" title="twitter"></a>
	</div>
	
	<div class="clear"></div>
	
    <div style="width: 100%;float:left;text-align:center;">
        <div style="float:left;margin-top:10px;margin-left: 80px;">
    		<div style="float:left;">
    	         <fb:like href="http://juzon.com" show_faces="false" layout="button_count" width="150" send="true"></fb:like>
			</div>
    		
    		<div style="float:left; width:115px;margin-left:10px;">
    			<!--<iframe allowtransparency="true" frameborder="0" scrolling="no"
    				src="https://platform.twitter.com/widgets/tweet_button.html"
    				style="width:130px; height:20px;"></iframe>-->
				<a href="https://twitter.com/share" class="twitter-share-button" data-url="http://www.juzon.com/" data-text="Juzon">Tweet</a>
				<script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0];if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src="//platform.twitter.com/widgets.js";fjs.parentNode.insertBefore(js,fjs);}}(document,"script","twitter-wjs");</script>
    		</div>
            
            <div style="clear:both"></div>
            
    		<div style="float:left;" id="qqdiv">
    			<script type="text/javascript" src="<?php echo site_url();?>/media/js/qq_share2.js"></script> 
    		</div>
    		
    		<div style="float:left" id="weibodiv">
    			<script type="text/javascript" src="<?php echo site_url();?>/media/js/weibo_share2.js"></script> 
    		</div>
    		
    		<div style="clear:both"></div>
    	</div> 
    </div> 
</div>
	
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