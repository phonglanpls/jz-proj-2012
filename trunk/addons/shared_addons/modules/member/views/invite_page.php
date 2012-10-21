<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>

<?php 
	if($this->facebookmodel->getCurrentFacebookUser()){
		if($this->facebookmodel->isFacebookConnected()){
			redirect("member/proceedFacebookUserConnected");
		}else{
			redirect("member/fb_register");
		}
	}
?>
<div id="page-login" style="height:300px;">
	
	<div class="input" style="width:600px;">
		<?php 
			if(isset($_SESSION['USER_INVITE']['id_user'])){
				$userdataobj = $this->user_io_m->init('id_user',$_SESSION['USER_INVITE']['id_user']);
				echo str_replace( 
									array('$firstname','$lastname'), 
									array($userdataobj->first_name,$userdataobj->last_name) ,
									language_translate('member_invitepage_title')		
								);
			}else{
				echo str_replace( 
									'$firstname $lastname', 
									'' ,
									language_translate('member_invitepage_title')		
								);
			}
		
		?>
		 
	</div>
	
	<div style="text-align: center" class="input">
		<a href="<?php echo $this->facebookmodel->getLoginLogoutUrl();?>"><img src="<?php echo site_url();?>media/images/facebook.png" alt="facebook" title="facebook"></a>
		<a href="<?php echo $this->twittermodel->getAuthorizeURL();?>"><img src="<?php echo site_url();?>media/images/twitter.png" alt="twitter" title="twitter"></a>
	</div>
	
</div>	