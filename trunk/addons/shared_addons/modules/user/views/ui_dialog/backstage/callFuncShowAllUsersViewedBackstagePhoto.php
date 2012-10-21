<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>

<?php 
	$userArr = $this->backstage_m->getUserArrayBuyBackstagePhoto($this->input->get('id_photo',0));
?>

<div id="wrap-dialog-box">	
		
	<?php foreach($userArr as $subitem):?>
		<div class="article-response-item" id="articleDivId_<?php echo $subitem->id_user;?>">
			<a href="javascript:void(0);" class="thumb">
				<img class="image" src="<?php echo $this->user_m->getCommentAvatar($subitem->id_user);?>" alt="" title="" />
			</a>
			
			<div class="article-response-note">
				<div class="article-response-header">
					<h3><?php echo $this->user_m->getProfileDisplayName($subitem->id_user);?></h3> 
				</div>
				
				<p class="time"><?php echo timeDiff($subitem->added_date);?></p>
			</div>
		</div>
		<div class="clear"></div>
	<?php endforeach; ?>

	<div class="clear"></div>
</div>	
