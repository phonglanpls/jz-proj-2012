<?php if (!defined('BASEPATH')) exit('No direct script access allowed'); ?>

<?php 
	$commentArray = $this->wall_m->get_all_comment($id_wall);
	$showArray = array();
	if($commentArray){
		if($contextcm == 'default'){
			if(isset($commentArray[count($commentArray)-1])){
				$showArray[] = $commentArray[count($commentArray)-1];
			}
		}else if($contextcm == 'all'){
			$showArray = $commentArray;
		}else if($contextcm == 'addnew'){
			if(isset($commentArray[count($commentArray)-2])){
				$showArray[] = $commentArray[count($commentArray)-2];
			}
			if(isset($commentArray[count($commentArray)-1])){
				$showArray[] = $commentArray[count($commentArray)-1];
			}
		}
	}
	$isMyOwnFeed = $this->wall_m->isMyOwnWallFeed($id_wall);
?>

<input type="hidden" id="contextcm_<?php echo $id_wall?>" value="<?php echo $contextcm;?>" />

<?php foreach($showArray as $subitem):?>
	<div class="article-response-item" id="articleDivId_<?php echo $subitem->id_wall;?>">
		<a href="<?php echo site_url($subitem->username);?>" class="thumb">
			<img class="image" src="<?php echo $this->user_m->getCommentAvatar($subitem->id_user);?>" alt="" title="" />
		</a>
		
		<div class="article-response-note">
			<div class="article-response-header">
				<h3><?php echo $this->user_m->getProfileDisplayName($subitem->id_user);?></h3> 
				<?php if($subitem->id_user != getAccountUserId()):?>
					<a href="javascript:void(0);" onclick="javascript:jqcc.cometchat.chatWith('<?php echo $subitem->id_user;?>');" class="chat">Chat</a> 
					<a href="javascript:void(0);" onclick="callFuncShowDialogSubmitQuestion(<?php echo $subitem->id_user;?>);" class="ask-me">Ask Me</a>
				<?php endif;?>
				<?php 
					if($isMyOwnFeed OR $subitem->id_user == getAccountUserId()){
						echo loader_image_delete("class='deleteItem' onclick='callFuncDeleteComment({$subitem->id_wall},{$id_wall});'");
					}
				?>
			</div>
			<div class="comment">
				<?php echo $this->wall_m->commentAccordingType($subitem);?>
			</div>
			<p class="time"><?php echo timeDiff($subitem->date_diff);//time_interval(explode(':',$subitem->add_date));?></p>
		</div>
	</div>
	<div class="clear"></div>
<?php endforeach; ?>
