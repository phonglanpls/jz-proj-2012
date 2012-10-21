<?php if (!defined('BASEPATH')) exit('No direct script access allowed'); ?>

<?php 
	$cat = $this->uri->segment(3,'');
	$nearme = $friends = $everyone = $mychatter = '';
	$nearme = "class='first'";
	if($cat == 'friends'){
		$friends = "class='current'";
	}else if($cat == 'near_me'){
		$nearme = "class='current first'"; 
	}else if($cat == 'everyone' OR $cat == '' OR !in_array($cat, array('near_me', 'friends', 'everyone', 'my_chatter'))){
		$everyone = "class='current'";
	}else{
		$mychatter = "class='current'";
	}
	
?>

<div id="tab-menu">
	<a href="<?php echo site_url( 'user/wall/near_me' );?>" <?php echo $nearme;?> >Near Me</a>
	<a href="<?php echo site_url( 'user/wall/friends' );?>" <?php echo $friends;?> >Friends</a>
	<a href="<?php echo site_url( 'user/wall/everyone' );?>" <?php echo $everyone;?> >Everyone</a>
	<a href="<?php echo site_url( 'user/wall/my_chatter' );?>" <?php echo $mychatter;?> >My Chatter</a>
</div>

<div class="clear"></div>
