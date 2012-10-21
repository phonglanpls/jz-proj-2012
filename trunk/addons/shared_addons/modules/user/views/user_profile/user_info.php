<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<style>
	#askME,#sendGift,#accessPeeped{
		margin:5px 0px 0px 20px;
	}
</style>

<script type="text/javascript" src="<?php echo site_url();?>/media/js/friends.js"></script> 

<script type="text/javascript" src="<?php echo site_url();?>/media/js/wall.js"></script> 

<script type="text/javascript" src="<?php echo site_url();?>/media/js/qa.js"></script> 

<script type="text/javascript" src="<?php echo site_url();?>/media/js/report_abuse.js"></script> 

<div id="fb-root"></div>

<?php 
	$myaccountdata = getAccountUserDataObject();
?>

<input type="hidden" id="username_userinfo" value="<?php echo $userdataobj->username;?>" />

<div class="box-profile" style="position:relative;">
	<div class="left">
		<a href="<?php echo $this->user_m->getUserHomeLink($userdataobj->id_user);?>">
			<img src="<?php echo $this->user_m->getProfileAvatar($userdataobj->id_user);?>" />
		</a>
		<br/>
		<?php echo $this->user_m->buildNativeLink($userdataobj->username);?>  	
		
		<?php //if(! $this->friend_m->isMyFriend($userdataobj->id_user) AND notMe($userdataobj->id_user) ):?>
			<br/>
			<a class="ask-me" id="askME" onclick="callFuncShowDialogSubmitQuestion(<?php echo $userdataobj->id_user;?>);" href="javascript:void(0);">Ask Me</a>
			
			<div class="clear"></div>
			
			<a class="ask-me" id="sendGift" onclick="callFuncShowDialogSendGift(<?php echo $userdataobj->id_user;?>);" href="javascript:void(0);">Send Gift</a>
			
			<?php if( $this->peepbought_history_m->wasIBoughtPeepedUser($userdataobj->id_user)):?>
				<a class="ask-me" id="accessPeeped" onclick="callFuncShowPeepedAccess(<?php echo $userdataobj->id_user;?>);" href="javascript:void(0);">Access Peeped</a>
			<?php endif;?>
			
			<div class="clear"></div>
			
			<a class="ask-me" id="sendGift" onclick="jqcc.cometchat.chatWith('<?php echo $userdataobj->id_user;?>');" href="javascript:void(0);">Chat</a>
			<div class="clear"></div>
			
			<?php if( !$this->report_abuse_m->wasIReportThisUser($userdataobj->id_user) ):?>
				<br/>
				<a id="report_abuse" onclick="callFuncReportAbuse(<?php echo $userdataobj->id_user;?>)"  href="javascript:void(0);">Report abuse</a>
			<?php endif;?>
			<div class="clear"></div>
			
		<?php // endif;?>
	</div>
	<div class="right">
		<b>Age/Sex:</b> <?php echo cal_age($userdataobj->dob);?>/ <?php echo $userdataobj->gender;?>
		
		<div class="clear"></div>
		
		<?php echo currencyDisplay ( $this->geo_lib->distance($userdataobj->latitude,$userdataobj->longitude ,$myaccountdata->latitude,$myaccountdata->longitude,'K') );?> km
		
		<div class="clear"></div>
		
		<?php if($this->online_m->checkOnlineUser($userdataobj->id_user)):?>
            <span class="cometchat_userscontentdot cometchat_available" style="float: left;"></span>
			Online
		<?php else:?>
            <span class="cometchat_userscontentdot cometchat_offline" style="float: left;"></span>
			Offline
		<?php endif;?>
		
		<div class="clear"></div>
		
		<?php if(! $this->pet_m->isMyPet($userdataobj->id_user) AND notMe($userdataobj->id_user) AND ! $this->pet_m->isMyOwner($userdataobj->id_user) ) :?>
			<div class="user-profile-button">
				<a onclick="callFuncAddThisPet(<?php echo $userdataobj->id_user;?>)" href="javascript:void(0);"> 
					Buy as Pet For <?php echo $this->user_m->calculatePetPrice($userdataobj->id_user);?>J$ 
				</a>
			</div>
			<div class="clear"></div>
			
			<div id="wishlistInfoDivID_<?php echo $userdataobj->id_user;?>" class="user-profile-button">
				<a onclick="callFuncAddToWishListThisPet(<?php echo $userdataobj->id_user;?>);" href="javascript:void(0);"> Add To Wishlist </a>
			</div>
			<div class="clear"></div>
		<?php endif;?>
		
		<?php if(! $this->friend_m->isMyFriend($userdataobj->id_user) AND notMe($userdataobj->id_user) ):?>
			<div class="user-profile-button">
				<a onclick="callFuncAddFriend(<?php echo $userdataobj->id_user;?>)" href="javascript:void(0);" id="addFriendContext_<?php echo $userdataobj->id_user;?>"> 
					<?php if($this->friend_m->isPendingAddFriend($userdataobj->id_user)):?>
						<?php echo language_translate('request_add_friend_success');?>
					<?php else:?>
						Add Friend
					<?php endif;?>
				</a>
			</div>
			<div class="clear"></div>
			
		<?php endif;?>
		
		<?php if(! $this->peepbought_history_m->wasIBoughtPeepedUser($userdataobj->id_user)):?>
			<div class="user-profile-button" id="buyPeepAccessBtnDiv">
				<a onclick="callFuncBuyPeepAccess(<?php echo $userdataobj->id_user;?>)" href="javascript:void(0);"> 
					Who Peep Me <?php echo currencyDisplay($userdataobj->peep_access);?>J$ for 24h
				</a>
			</div>
			<div class="clear"></div>
		<?php endif;?>
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
				<a href="<?php echo fullURL();?>" class="twitter-share-button" data-lang="en">Tweet</a>
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
