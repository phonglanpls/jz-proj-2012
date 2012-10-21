<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>

<?php 
	 
	$this->load->model('mod_io/mod_io_account_m');
	if($userdataobj->id_user != getAccountUserId()){
		$this->mod_io_account_m->increaseNumberChecked($userdataobj->id_user);
		if(!isset($_SESSION['checked_profile_user'])){
			$this->email_sender->juzonSendEmail_JUZ_WHO_CHECK_ME($userdataobj->id_user,getAccountUserId());
			$_SESSION['checked_profile_user'][] = $userdataobj->id_user;
		}else{
			if( !in_array($userdataobj->id_user,$_SESSION['checked_profile_user'] ) ){
				$this->email_sender->juzonSendEmail_JUZ_WHO_CHECK_ME($userdataobj->id_user,getAccountUserId());
				$_SESSION['checked_profile_user'][] = $userdataobj->id_user;
			}
		}
	}
?>

<div id="body-content">
   <?php $this->load->view("user/partial/left");?>
 
	<div id="body">
		<div class="body">
			<div id="content">
				<?php $this->load->view("user/partial/top"); ?>
				<div class="clear"></div>
				
				<?php if($userdataobj->status != 0 OR $userdataobj->id_user == 1):?>
					<br/>
					This user is not available.
				<?php else:?>
				
				<div class="filter-split" id="userInfoAsyncDiv">
					<?php $this->load->view("user_profile/user_info", array('userdataobj'=>$userdataobj)); ?>
				</div>
				 
				<div class="clear"></div>
				 
				<div class="filter-split">
					<?php $this->load->view("user_profile/user_social_info", array('userdataobj'=>$userdataobj)); ?>
				</div>
				
				<div class="clear"></div>
				 
				<div class="filter-split">
					<?php $this->load->view("user_profile/user_chatter", array('userdataobj'=>$userdataobj)); ?>
					
					<div class="clear"></div>
					<div id="morePost">
						<a href="javascript:void(0);" onclick="callFuncGetMorePost_USERPROFILE();" >More</a> 
						<?php echo loader_image_s("id=\"morePostContextLoader\" class='hidden'");?>
					</div>
				</div>
				<?php endif;?>
			</div>
		</div>
	   <?php $this->load->view("user/partial/right");?>
	</div>
	<div class="clear"></div>
	
</div>

<input type="hidden" id="username" value="<?php echo $userdataobj->username;?>" />

<script type="text/javascript">
	var cur_page = 1;
	function callFuncGetMorePost_USERPROFILE(){
		$currentPage = cur_page;
		cur_page += 1;
		$username = $('#username').val();
		
		var obj = {};
		obj.segment = 'my_chatter';
		
		$('#morePostContextLoader').toggle();
		
		$.get(WEB_URI+'/'+$username+'/userChatterAsync/?per_page='+$currentPage,obj,function(res1){
			$id = $('.morePostItem').attr('id');
			
			$('#'+$id ).html(res1);
			$('#morePostContextLoader').toggle();
			$('#'+$id).removeClass('morePostItem').addClass('addedPostItem');
		});
	}
	
	$(document).ready(function(){
		if(FEEDCOUNT <1){
			$('#morePost').hide();
		}
	});
</script>
