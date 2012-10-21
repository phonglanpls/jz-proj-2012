<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<style>
	#askME,#sendGift,#accessPeeped{
		margin:5px 0px 0px 20px;
	}
	#show_url_vanity{
		bottom:-15px;
	}
 
</style>

<script type="text/javascript" src="<?php echo site_url();?>/media/js/friends.js"></script> 

<script type="text/javascript" src="<?php echo site_url();?>/media/js/wall.js"></script> 

<script type="text/javascript" src="<?php echo site_url();?>/media/js/qa.js"></script> 

<script type="text/javascript" src="<?php echo site_url();?>/media/js/report_abuse.js"></script> 

<div id="fb-root"></div>

<?php 
	//$myaccountdata = getAccountUserDataObject();
?>

<input type="hidden" id="username_userinfo" value="<?php echo $userdataobj->username;?>" />

<div class="box-profile" style="position:relative;">
	<div class="left">
		<a href="<?php echo $this->user_m->getUserHomeLink($userdataobj->id_user);?>">
			<img src="<?php echo $this->user_m->getProfileAvatar($userdataobj->id_user);?>" /> 
		</a>
		<br/>
		<?php echo $this->user_m->buildNativeLink($userdataobj->username);?>  	
		
		
	</div>
	<div class="right">
		<b>Age/Sex:</b> <?php echo cal_age($userdataobj->dob);?>/ <?php echo $userdataobj->gender;?>
		
	</div>
	
	<div class="right" style="margin-left:10px;">
		<div style="width: 270px;">
			<div style="float:left;">
				<!--<fb:like href="<?php //echo site_url();?>" layout="button_count"
				show_faces="false" width="20" action="like" font="arial" colorscheme="light"></fb:like>
				-->
				<fb:like href="<?php echo fullURL();?>" show_faces="false" layout="button_count" width="60" height="30" send="true"></fb:like>
			</div>
			<br/>
			<div style="clear:both;margin:3px 0px;"></div>
			
			<div style="float:left;margin-top:10px;">
				<a href="<?php echo site_url();?>" class="twitter-share-button" data-lang="en">Tweet</a>
				<script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0];if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src="//platform.twitter.com/widgets.js";fjs.parentNode.insertBefore(js,fjs);}}(document,"script","twitter-wjs");</script>
			</div>

			<div style="clear:both;margin:3px 0px;"></div>
			<br/>
		</div>
			
		<div class="clear"></div>
		
		<div style="width: 270px;">
			<div style="float:left;width:100%;" id="qqdiv">
				<script type="text/javascript" src="<?php echo site_url();?>/media/js/qq_share.js"></script> 
			</div>
			
			<div class="clear"></div>
			
			<div style="float:left;width:100%;" id="weibodiv">
				<script type="text/javascript" src="<?php echo site_url();?>/media/js/weibo_share.js"></script> 
			</div>
		</div>
	</div>
	
	<div class="right" style="margin-left:10px;">
		<?php 
			$owner_id = $this->user_m->getMyOwnerId($userdataobj->id_user);
		?>
		<a href="<?php echo $this->user_m->getUserHomeLink($owner_id);?>">
			<img src="<?php echo $this->user_m->getProfileAvatar($owner_id);?>" />
		</a>
		<br/>
		<strong>Owner:</strong> <?php echo $this->user_m->getProfileDisplayName($owner_id);?> 
		<br/>
		<strong>Cash:</strong> <?php echo $this->user_m->getCash($owner_id);?> 
		<br/>
		<strong>Value:</strong> <?php echo $this->user_m->getValue($owner_id);?> 
		<div class="clear"></div> 
	</div>
	
	<div class="clear"></div>
	
	<div id="show_url_vanity">
		<b>URL:</b> <?php echo site_url("{$userdataobj->username}");?>
	</div>
</div>

<div class="clear"></div>
