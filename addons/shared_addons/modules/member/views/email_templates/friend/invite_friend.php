<?php defined('BASEPATH') or exit('No direct script access allowed');?>
<?php 
	//$ci= &get_instance();
	//$ci->load->model("user/user_m");
	$invite_url = "<a href='".$this->user_io_m->getInviteUrl($userdataobj->username)."'>".$this->user_io_m->getInviteUrl($userdataobj->username)."</a>";
	$messagePrint = str_replace('{$invite_url}',$invite_url , $message );
	$messagePrint .= str_replace('{$invite_url}',$invite_url , language_translate('append_invite_friend') );
?>

<!--
<div style="background-color: rgb(238, 238, 247);padding:20px">
    <div>
		<a href="<?php //echo $invite_link;?>"><img src="<?php //echo $ci->user_m->getProfileAvatar($userdataobj->id_user);?>" border="0" /></a>	
	   <br/>
       <a href="<?php //echo $invite_link;?>"><?php //echo $userdataobj->username;?></a>
    </div>
    <br/>
	
	<div>
		<?php //echo $message;?>
	</div>
	
	<br/>
    <div>
       Please click to invite link bellow to join Juzon. 
	   You will get J$ <?php //echo $GLOBALS['global']['USER_CASH']['invited_cash'];?> into cash and 
	   J$ <?php //echo $GLOBALS['global']['USER_CASH']['pet_start_value'];?> pet value.
	   <br/>
	   <a href="<?php //echo $invite_link;?>"><?php echo $invite_link;?></a> 
    </div>
    
</div>

-->

<div style="background-color: rgb(238, 238, 247);padding:20px">
	<?php echo nl2p2( $messagePrint );?>
</div>