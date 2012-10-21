<?php if (!defined('BASEPATH')) exit('No direct script access allowed'); ?>
<?php 
	$countUnreadQuestion = count($this->qa_m->getUnreadQuestion(getAccountUserId()));
	$announcement = $this->db->query( " SELECT * FROM ".TBL_CONFIG." WHERE name LIKE 'ANNOUNCEMENT' AND f_key LIKE 'content'")->result();
?>

<style>
	#announcement{
		position:relative;
	}
	#announcement #hide{
		position:absolute;
		right:0px;top:0px;
		height:10px;width:10px;
	}
</style>

<script type="text/javascript">
	var FBID = "<?php echo $GLOBALS['global']['FACEBOOK']['api_key'];?>";
	$(function(){
		if (sessionStorage.hideAnnouncement)
		{
		  callFuncDeleteAnnouncement();
		}
	});
	
	function callFuncDeleteAnnouncement(){
		$('#announcement').hide();	
		if (sessionStorage.hideAnnouncement)
		{
		  sessionStorage.hideAnnouncement=1;
		}
		else
		{
		  sessionStorage.hideAnnouncement=1;
		}
	}
</script>	

<div id="fb-root"></div>

<?php if($announcement[0]->value == '1' AND $announcement[0]->f_value):?>
	<div id="announcement">
		<div id="hide">
			<?php echo loader_image_delete("class='deleteItem' onclick='callFuncDeleteAnnouncement();'"); ?>
		</div>
		<?php echo $announcement[0]->f_value;?>
	</div>
<?php endif;?>

<nav>
	<a href="<?php echo site_url();?>"><?php echo language_translate('menu_nav_label_home');?></a> | 
	<a href="<?php echo site_url("user/pets")?>"><?php echo language_translate('menu_nav_label_pets');?></a> | 
	<!-- <a href="#"><?php echo language_translate('menu_nav_label_chat');?> (0)</a> | -->
	<a href="<?php echo site_url("user/askme")?>"><?php echo language_translate('menu_nav_label_askme');?> (<?php echo $countUnreadQuestion;?>)</a> | 
	<?php if($GLOBALS['global']['HENTAI']['show'] == 1):?>
		<a href="<?php echo site_url("user/videos")?>">Video</a> | 
	<?php endif;?>
	<a href="<?php echo site_url("user/my_profile")?>"><?php echo language_translate('menu_nav_label_profile');?></a> | 
	<a href="<?php echo site_url("user/account")?>"><?php echo language_translate('menu_nav_label_account');?></a> | 
	<a href="<?php echo site_url("user/connect")?>"><?php echo language_translate('menu_nav_label_connect');?></a> | 
	<a href="<?php echo site_url("member/logout");?>"><?php echo language_translate('menu_nav_label_logout');?></a> 
</nav>