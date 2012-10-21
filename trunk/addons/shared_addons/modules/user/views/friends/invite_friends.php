<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>

<script type="text/javascript" src="<?php echo site_url();?>/media/js/friends.js"></script> 
<script type="text/javascript" src="<?php echo site_url();?>asset/tinymce/jscripts/tiny_mce/tiny_mce.js"></script>
<?php 
	$userdataobj = getAccountUserDataObject(true);
	
	$slug = "JUZ_INVITE_EMAIL";
	$template = $this->module_helper->getTemplateMail( $slug );
	
	$arrayMaker = array( '$username');//,'{$invite_url}' 
	$arrayReplace = array( $userdataobj->username);//, $this->user_io_m->getInviteUrl($userdataobj->username) 	
						
	$subject = str_replace( $arrayMaker, $arrayReplace, $template['subject'] );			
	$body = str_replace( $arrayMaker , $arrayReplace , strip_tags($template['body']) );	
	 
?>	


<script type="text/javascript">
/*
	tinyMCE.init({
		
			mode : "textareas",
			theme : "advanced",
			plugins : "",
			editor_selector : "mceSimple",
			editor_deselector : "mceNoEditor",
			theme_advanced_buttons1 : "",
			theme_advanced_toolbar_location : "external",
			theme_advanced_statusbar_location : "",
	});
   */ 
</script>



<div id="body-content">
   <?php $this->load->view("user/partial/left");?>
 
	<div id="body">
		<div class="body">
			<div id="content">
				<?php $this->load->view("user/partial/top"); ?>
				<div class="clear"></div>
				
				<div class="filter-split">
					<h3>
						Send invitations to friends
					</h3>
					<p>
						For every friend you successfully invite, you will be rewarded J$ <?php echo $GLOBALS['global']['USER_CASH']['invite_cash'];?>.
						<br/>
						Don't let other user invites your friend and rob your J$ 
						<br/>
						Start inviting and earn all your J$ :) 
					</p>
				</div>
				<div class="clear"></div>
				
				<?php if($this->facebookconnect_io_m->init('userid',getAccountUserId())):?>
					<br/><br/>
					<a href="javascript:void(0);" onclick="callFuncShowMyFacebookFriends();" class="button spctext">
						Invite your facebook friends 
				    </a>
				<?php endif;?> 
				
				<div class="clear"></div>
				
				<?php if(isTwitterLogin()):?>
					<br/><br/>
					<a href="javascript:void(0);" onclick="callFuncShowMyTwitterFriends();" class="button spctext">
						Invite your twitter friends 
				    </a>
				<?php endif;?> 
				
				<div class="clear"></div>
				
				<div class="filter-split body-container">
					<label><b>From:</b></label> 
					<div class="inputcls">
						<?php echo $userdataobj->email;?>
					</div>	
					<div class="clear sep"></div>
					
					<label><b>To Email:</b></label>
					<div class="inputcls">
						<textarea name="emailaddress" id="emailaddress" class="mceNoEditor" style="width:300px;height:100px;"></textarea>
						<br/>
						Address separated by commas( , )
					</div>
					<div class="clear"></div>
					
					<label><b>Subject:</b></label>
					<div class="inputcls">
						<input type="text" name="subject" id="subject" maxlength="250" style="width:300px;" value="<?php echo $subject;//language_translate("subject_email_invite_default");?>" /> 
					</div>
					<div class="clear"></div>
					
					<label><b>Message:</b></label>
					<div class="inputcls">
						<textarea name="message" id="message" class="mceSimple" style="width:310px;height:130px;"><?php echo $body;?></textarea>
					</div>
					<div class="clear"></div>
					
					<label>&nbsp;</label>
					<div class="inputcls">
						<a href="javascript:void(0);" onclick="callFuncInviteFriends();" class="button">
							Send
						</a>	
						
						&nbsp;&nbsp;&nbsp;
						
						<a href="javascript:void(0);" onclick="callFuncPreviewInviteFriends();" class="button">
							Preview
						</a>	
						&nbsp;
						<?php echo loader_image_s("id=\"inviteFriendContextLoader\" class='hidden'");?>
						
						<div class="clear"></div>
						
					</div>
				</div>
				<div class="clear"></div>
				
				
				
			</div>
		</div>
	   <?php $this->load->view("user/partial/right");?>
	</div>
	<div class="clear"></div>
	
</div>

