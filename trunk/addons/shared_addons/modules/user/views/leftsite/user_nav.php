<?php if (!defined('BASEPATH')) exit('No direct script access allowed'); ?>

<?php 
	$mapFlirtInfo = $this->mapflirt_m->getAccessMapActiveInfo();
	$birthdayNum = count($this->friend_m->getBirthdayList()) ? count($this->friend_m->getBirthdayList()):0;	
?>
	<div class="widget">
		<ul>
			<li><a href="<?php echo site_url("user/information");?>"><?php echo language_translate('menu_nav_label_how-to-earn-J$');?></a></li>
			<li><a href="<?php echo site_url("user/wallet");?>"><?php echo language_translate('menu_nav_label_J$-wallet');?></a></li>
			<li><a href="<?php echo site_url("user/invite_friends");?>"><?php echo language_translate('menu_nav_label_invite-your-friend');?></a></li>
			<li><a href="<?php echo site_url("user/wall");?>"><?php echo language_translate('menu_nav_label_chatter');?></a></li>
		<!--	<li><a href="#"><?php echo language_translate('menu_nav_label_chat');?>(<span>0</span>)</a></li> -->
			<li><a href="<?php echo site_url("user/peeps");?>"><?php echo language_translate('menu_nav_label_peeps');?></a></li>
			<li><a href="<?php echo site_url("user/map_flirts");?>"><?php echo language_translate('menu_nav_label_map_flirts');?>(<span><?php echo $mapFlirtInfo['i_bought_other'];?>/<?php echo $mapFlirtInfo['other_bought'];?></span>)</a></li>
			<!-- <li><a href="<?php //echo site_url("user/flirts");?>">Flirts (<span>0</span>)</a></li> -->
			<li><a href="<?php echo site_url("user/friends");?>"><?php echo language_translate('menu_nav_label_friends');?></a></li>
			<li><a href="<?php echo site_url("user/friends_request");?>"><?php echo language_translate('menu_nav_label_friends-request');?>(<span><?php echo count($this->friend_m->myRequestFriend());?></span>)</a></li>
			<li><a href="<?php echo site_url("user/birthdays");?>"><?php echo language_translate('menu_nav_label_birthdays');?><?php if($birthdayNum):?>(<span><?php echo $birthdayNum;?></span>)<?php endif;?></a></li>
			<li><a href="<?php echo site_url("user/giftbox")?>"><?php echo language_translate('menu_nav_label_gift-box');?></a></li>
			<li><a href="<?php echo site_url("user/backstage");?>"><?php echo language_translate('menu_nav_label_backstage');?></a></li>
			<li><a href="<?php echo site_url("user/collection");?>"><?php echo language_translate('menu_nav_label_collection');?></a></li>
			<li><a href="<?php echo site_url("user/favourite");?>"><?php echo language_translate('menu_nav_label_favourite');?></a></li>
			<!-- <li><a href="<?php //echo site_url("user/random_message");?>">Random Message</a></li> -->
			<li><a href="<?php echo site_url("user/mypets");?>"><?php echo language_translate('menu_nav_label_lock-pet');?></a></li>
			<li><a href="<?php echo site_url("user/block");?>"><?php echo language_translate('menu_nav_label_blocklist');?></a></li>
		</ul>
	</div>
