<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>

<?php 	
	$this->load->model('user/user_m');
	$gallerydataobj = $this->gallery_io_m->init('id_image',$id_photo);
	
	$id_user = $gallerydataobj->id_user;
	$userdataobj = $this->user_io_m->init('id_user',$id_user);	
	//$myuserdataobj = getAccountUserDataObject();	
	$commentArr = $this->photos_m->getMyPhotoComments($id_photo);
?>


<?php foreach($commentArr as $subitem):?>
	<div class="article-response-item" id="articleDivId_<?php echo $subitem->id_photo_comment;?>">
		<a href="javascript:void(0);" class="thumb">
			<img class="image" src="<?php echo $this->user_m->getCommentAvatar($subitem->comment_by);?>" alt="" title="" />
		</a>
		
		<div class="article-response-note">
			<div class="article-response-header">
				<h3><?php echo $this->user_m->getProfileDisplayName($subitem->comment_by);?></h3> 
				
				<?php 
					if($id_user == getAccountUserId() OR $subitem->comment_by == getAccountUserId()){
						echo loader_image_delete("class='deleteItem' onclick='callFuncDeleteComment({$subitem->id_photo_comment});'");
					}
				?>
			</div>
			<div class="comment">
				<?php echo maintainHtmlBreakLine($subitem->comment);?>
			</div>
			<p class="time"><?php echo timeDiff($subitem->add_date);?></p>
		</div>
	</div>
	<div class="clear"></div>
<?php endforeach; ?>

<div class="clear"></div>
			
<div class="article-response">
	
	<div class="article-response-form" id="commentSectionSubmitDiv">
		<p>
			<textarea maxlength="<?php echo $GLOBALS['global']['INPUT_LIMIT']['comment_limit'];?>" cols="10" rows="5" name="sc" class="myCommentBox" id="my_comment" ><?php echo language_translate("wall_comment_default");?></textarea>
		</p>
		<div class="button-submit-2">
			<?php echo loader_image_s("id=\"shareContextLoader\" class='hidden'");?>
			<input type="button" value="Share" name="submit" class="share-2" onclick="callFuncShareCommentPhoto(<?php echo $id_photo;?>)" />
		</div>
	</div>
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






