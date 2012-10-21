<?php if (!defined('BASEPATH')) exit('No direct script access allowed'); ?>
<?php 
	if(!isset($contextcm)){
		$contextcm = 'default';
	}
?>
<?php foreach($res as $item): ?>
	<?php 
		$likeInfo = $this->wall_m->getLikeInfo($item->id_wall);
		$totalComments = count($this->wall_m->get_all_comment($item->id_wall));
		if($totalComments == 0){
			$commentCls = 'hidden';
			$commentFunc = "callFuncShowCommentBox({$item->id_wall})";
		}else{
			$commentCls = '';
			$commentFunc = "callFuncShowAllComments({$item->id_wall})";
		}
	?>
		<article id="articleID_<?php echo $item->id_wall;?>">
			<div class="article-thumb">
				<a href="<?php echo $this->user_m->getUserHomeLink($item->id_user);?>">
				    <img class="image" src="<?php echo $this->user_m->getCommentAvatar($item->id_user);?>" alt="" title="">
				</a>
                
				<?php if($item->id_user != getAccountUserId() AND isLogin() ):?>
					<a href="javascript:void(0);" class="chat" onclick="javascript:jqcc.cometchat.chatWith('<?php echo $item->id_user;?>');">Chat</a>
					<a href="javascript:void(0);" onclick="callFuncShowDialogSubmitQuestion(<?php echo $item->id_user;?>);" class="ask-me">Ask Me</a>
				<?php endif;?>
			</div>
			
			<div class="article-content">
				<h3><?php echo $this->user_m->getProfileDisplayName($item->id_user);?></h3>
				<div class="comment"><?php echo $this->wall_m->commentAccordingType($item);?></div>
				<p class="time"><?php echo timeDiff($item->date_diff);//time_interval(explode(':',$item->add_date));?></p>
				<?php 
					if($item->id_user == getAccountUserId()){
						echo loader_image_delete("class='deleteItem' onclick='callFuncDeleteMyThreadFeed({$item->id_wall});'");
					}
				?>
			</div>
			
			<div class="article-like-info" id="likeContext_<?php echo $item->id_wall;?>">
				<?php echo $likeInfo['context'];?>
			</div>
			
			<div class="article-tools">
				<?php if(isLogin()):?>
					<a href="javascript:void(0);" onclick="<?php echo $commentFunc;?>">Comment (<span id="commentCountNumber_<?php echo $item->id_wall;?>"><?php echo $totalComments ;?></span>)</a>
						<?php echo loader_image_s("id=\"commentContextLoader_{$item->id_wall}\" class='hidden'");?>  |  
					<a href="javascript:void(0);" onclick="toggleLikeContext(<?php echo $item->id_wall;?>);" id="likeContextFunc_<?php echo $item->id_wall;?>">
						<?php echo $likeInfo['contextme'];?>
					</a> 
						<?php echo loader_image_s("id=\"likeContextLoader_{$item->id_wall}\" class='hidden'");?> |  
					<a href="<?php echo site_url("user/wall_view/{$item->id_wall}");?>">View</a>
						<?php echo loader_image_s("id=\"viewContextLoader_{$item->id_wall}\" class='hidden'");?>	
				<?php endif;?>	
				
				
			</div>
			
			<div class="clear"></div>
			
			<?php if(isLogin()):?>
				<div class="article-response <?php echo $commentCls;?>" id="wrapCommentDiv_<?php echo $item->id_wall;?>">
					<div id="commentSectionAsyncDiv_<?php echo $item->id_wall;?>" class="commentBoxCls <?php echo $commentCls;?>">
						<?php $this->load->view('user/wall/feed_comment', array('contextcm'=>$contextcm, 'id_wall'=>$item->id_wall));?>
					</div>
					
					<div class="article-response-form" id="commentSectionSubmitDiv_<?php echo $item->id_wall;?>">
						<p>
							<textarea maxlength="<?php echo $GLOBALS['global']['INPUT_LIMIT']['comment_limit'];?>" cols="10" rows="5" name="sc" class="myCommentBox" onkeypress="searchKeyPress(event,<?php echo $item->id_wall;?>);" rel="<?php echo $item->id_wall;?>" id="my_comment_<?php echo $item->id_wall;?>"><?php echo language_translate("wall_comment_default");?></textarea>
						</p>
						<div class="button-submit-2">
							<?php echo loader_image_s("id=\"shareContextLoader_{$item->id_wall}\" class='hidden'");?>
							<!--
							<input type="button" value="Share" name="submit" class="share-2" onclick="callFuncShareCommentFeed(<?php //echo $item->id_wall;?>)" />
							-->
						</div>
					</div>
				</div>
			<?php endif;?>
			
		</article>
<?php endforeach;?>
<div class="clear"></div>

<div class="morePostItem" id="<?php echo $this->module_helper->getTokenId();?>">

</div>

<script type="text/javascript">
	$(document).ready(function(){
		$('.myCommentBox').live('focusin',function(){
			$dfText = $(this).val();
			if($dfText == '<?php echo language_translate("wall_comment_default");?>'){
				$(this).val('');
			}
		});
	});
</script>
