<?php defined('BASEPATH') or exit('No direct script access allowed');?>
<?php 
	$ci= &get_instance();
	$profileLink = site_url("{$ownerdata->username}");
	$ci->load->model("user/user_m");
?>

<div style="background-color: rgb(238, 238, 247);padding:20px">
    <div>
        <a href="<?php echo $profileLink;?>">
			<img src="<?php echo $ci->user_m->getProfileAvatar($ownerdata->id_user);?>" border="0" />
		</a>
		<br />
        <a href="<?php echo $profileLink;?>"><?php echo $ownerdata->username;?></a><br>
    </div>
    <br>
    <div>
       <b><?php echo $ownerdata->username;?></b> has locked you as pet for J$<?php echo $value;?>.<br/><br/>
       <a href="<?php echo $profileLink;?>">View <?php echo $ownerdata->username;?>'s profile.</a>
    </div>
    
</div>