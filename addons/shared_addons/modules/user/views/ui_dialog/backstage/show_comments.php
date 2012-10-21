<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>

<?php 
	$commentArr = $this->photos_m->getMyPhotoComments($this->input->get('id_photo',0));
?>

<div id="wrap-dialog-box">	
		
	<?php foreach($commentArr as $subitem):?>
		<div class="article-response-item" id="articleDivId_<?php echo $subitem->id_photo_comment;?>">
			<a href="javascript:void(0);" class="thumb">
				<img class="image" src="<?php echo $this->user_m->getCommentAvatar($subitem->comment_by);?>" alt="" title="" />
			</a>
			
			<div class="article-response-note">
				<div class="article-response-header">
					<h3><?php echo $this->user_m->getProfileDisplayName($subitem->comment_by);?></h3> 
				</div>
				<div class="comment">
					<?php echo $subitem->comment;?>
				</div>
				<p class="time"><?php echo timeDiff($subitem->add_date);?></p>
			</div>
		</div>
		<div class="clear"></div>
	<?php endforeach; ?>

	<div class="clear"></div>
</div>	
