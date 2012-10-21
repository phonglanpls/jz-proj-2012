
<?php 
	$myFriends = $this->friend_m->getAllFriends(getAccountUserId());
	$myFavoriteList = $this->favourite_m->getFavouriteList(getAccountUserId());
	$peepedList = $this->peepbought_history_m->myPeeeps(getAccountUserId());
	
	$is_async = $this->input->get('is_async');
?>

<?php if($is_async !=1):?>
	<div id="right-bar-async">
<?php endif;?>

<div id="navbar">
	<div id="right-chat-tabs">
		<ul>
			<li><a href="#tabs-all">All</a></li>
			<li><a href="#tabs-favorite">Favorite</a></li>
			<li><a href="#tabs-peeped-list">Peeped</a></li>
		</ul>
		<div id="tabs-all">
			<table>
				<?php foreach($myFriends as $item):?>
					<tr>
						<td width="40px">
                            <a href="javascript:void(0);" onclick="javascript:jqcc.cometchat.chatWith('<?php echo $item->id_user;?>');" title="Chat with <?php echo $item->username;?>" >
							     <img src="<?php echo $this->user_m->getCommentAvatar($item->id_user);?>" height="30px;" />
                            </a>
						</td>
						<td>	
							<a href="javascript:void(0);" onclick="javascript:jqcc.cometchat.chatWith('<?php echo $item->id_user;?>');" title="Chat with <?php echo $item->username;?>"><?php echo $item->username;?></a>
						</td>
					</tr>
				<?php endforeach;?>
			</table>
			<div class="clear"></div>
			
		</div>
		
		<div id="tabs-favorite">
			<table>
				<?php foreach($myFavoriteList as $item):?>
					<?php $userdata = $this->user_io_m->init('id_user',$item->to_id_user);?>
					<tr id="tr_<?php echo $item->to_id_user;?>">
						<td width="40px">
                            <a href="javascript:void(0);" onclick="javascript:jqcc.cometchat.chatWith('<?php echo $item->to_id_user ;?>');" title="Chat with <?php echo $userdata->username;?>">
							     <img src="<?php echo $this->user_m->getCommentAvatar($item->to_id_user);?>" height="30px;" />
                            </a>     
						</td>
						<td>	
							<div class="td-wrap">
								<a href="javascript:void(0);" onclick="javascript:jqcc.cometchat.chatWith('<?php echo $item->to_id_user ;?>');" title="Chat with <?php echo $userdata->username;?>"><?php echo $userdata->username;?></a>
								<?php 
									$confirm= language_translate('sys_button_delete_confirm'); 
									echo loader_image_delete("class='deleteItem' onclick=\"sysConfirm('{$confirm}','callFuncDeleteMyFavouriteItem({$item->to_id_user})');\" " );
								?>
							</div>
						</td>
					</tr>
				<?php endforeach;?>
			</table>
			<div class="clear"></div>
		</div>
		
		<div id="tabs-peeped-list">
			
			<table>
				<?php foreach($peepedList as $item):?>
					<?php $userdata = $this->user_io_m->init('id_user',$item->id_user);?>
					<tr id="tr_<?php echo $item->id_user;?>">
						<td width="40px">
							<!--
                            <a href="javascript:void(0);" onclick="javascript:callFuncBuyPeepAccess_CMC(<?php //echo $item->id_user ;?>);" title="View peeped: <?php echo $userdata->username;?>">
							     <img src="<?php //echo $this->user_m->getCommentAvatar($item->id_user);?>" height="30px;" />
                            </a>
							-->
							<a href="javascript:void(0);" onclick="javascript:jqcc.cometchat.chatWith('<?php echo $item->id_user ;?>');" title="Chat with <?php echo $userdata->username;?>">
							     <img src="<?php echo $this->user_m->getCommentAvatar($item->id_user);?>" height="30px;" />
                            </a>  
						</td>
						 
						<td>	
							<div class="td-wrap">
								<!--
									<a href="javascript:void(0);" onclick="javascript:callFuncBuyPeepAccess_CMC(<?php echo $item->id_user ;?>);" title="View peeped: <?php echo $userdata->username;?>"><?php echo $userdata->username;?></a>
								-->
								<a href="javascript:void(0);" onclick="javascript:jqcc.cometchat.chatWith('<?php echo $item->id_user;?>');" title="Chat with <?php echo $item->username;?>"><?php echo $item->username;?></a>
							</div>
						</td>
						 
					</tr>
				<?php endforeach;?>
			</table>
			<div class="clear"></div>
		</div>
	</div>
</div>

<?php if($is_async !=1):?>
	</div>
<?php endif;?>


<script type="text/javascript">
	$(function(){
		$( "#right-chat-tabs" ).tabs({
			 select: function(event, ui) { localStorage.indexTABS= parseInt( ui.index )  }
		});
		
		if(localStorage.indexTABS){
			$( "#right-chat-tabs" ).tabs({
				selected: parseInt( localStorage.indexTABS ) 
			});
		}
	});
	
	function callFuncDeleteMyFavouriteItem(id_user){
		$('#tr_'+id_user).fadeOut();
		$.post(BASE_URI+'mod_io/favourite_func/deleteItem',{id_user:id_user},function(res){
		});	
	}
	
	function reloadRightBarAsync(){
		$.get(BASE_URI+'user/account/reloadRightBarAsync',{is_async:1},function(res){
			$('#right-bar-async').html(res);
		});	
	}
</script>