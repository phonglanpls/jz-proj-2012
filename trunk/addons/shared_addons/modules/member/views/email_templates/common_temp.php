<?php defined('BASEPATH') or exit('No direct script access allowed');?>
<?php 
	$ci= &get_instance();
	$unsubcribe = $ci->user_io_m->buildDirectAccessLink($username,"user/account/#emailInfoAsyncDiv");
?>

<div style="background-color: rgb(238, 238, 247);padding:20px">
    <div>
        {###BODY###}
    </div>
   
    <br />
    <div>
        If you don't want to receive these emails from Juzon in the future, please click: <a href="<?php echo $unsubcribe;?>">unsubscribe</a>.
    </div>
</div>