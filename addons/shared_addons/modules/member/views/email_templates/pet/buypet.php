<?php defined('BASEPATH') or exit('No direct script access allowed');?>
<?php 
	$ci= &get_instance();
	$buyerdata = $ci->user_io_m->init('id_user',$buyer_id);
	$profileLink = site_url("{$buyerdata->username}");
	$ci->load->model("user/user_m");
?>

<div style="background-color: rgb(238, 238, 247);padding:20px">
    <div>
        <a href="<?php echo $profileLink;?>">
			<img src="<?php echo $ci->user_m->getProfileAvatar($buyerdata->id_user);?>" border="0" />
		</a>
		<br />
        <a href="<?php echo $profileLink;?>"><?php echo $buyerdata->username;?></a><br>
    </div>
    <br>
    <div>
       <b><?php echo $buyerdata->username;?></b> has bought you as pet for J$<?php echo $value;?> on <?php echo date(DATETIMEEMAIL,time())?>.<br/><br/>
       <a href="<?php echo $profileLink;?>">View <?php echo $buyerdata->username;?>'s profile.</a>
    </div>
    
</div>