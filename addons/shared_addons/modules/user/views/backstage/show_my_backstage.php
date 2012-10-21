<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>

<script type="text/javascript" src="<?php echo site_url();?>/media/js/photos.js"></script> 
<script type="text/javascript" src="<?php echo site_url();?>/media/jquery.raty/js/jquery.raty.min.js"></script> 

<?php 
	$id_photo = intval( $this->uri->segment(4,0) );
	$gallerydataobj = $this->gallery_io_m->init('id_image',$id_photo);
	
	if($gallerydataobj->image_type == 0){
		redirect("user/photos/$id_photo");
	}
	
	$id_user = $gallerydataobj->id_user;
	//$userdataobj = $this->user_io_m->init('id_user',$id_user);
	
	$myCollectionPhoto = $this->backstage_m->getMyBackstagePhoto();
	
	$prev_photo_id = $next_photo_id = 0;
	
	for($i=0;$i<count($myCollectionPhoto);$i++){
		if($myCollectionPhoto[$i]->id_image == $id_photo){
			if(isset($myCollectionPhoto[$i-1])){
				$prev_photo_id = $myCollectionPhoto[$i-1]->id_image;
			}
			if(isset($myCollectionPhoto[$i+1])){
				$next_photo_id = $myCollectionPhoto[$i+1]->id_image;
			}
			break;
		}
	}
	
	$path = site_url().$GLOBALS['global']['IMAGE']['image_orig']."photos/";
	
	if($this->input->get('task','') == 'rate'){
		$this->rate_m->ratePhoto($id_photo,$this->input->get('score'),$GLOBALS['global']['RATING']['backstage_photo']);
	}
?>

<h3><?php $u = $this->user_m->getProfileDisplayName($id_user); echo str_replace('%uname',$u,language_translate('show_my_backstg_photo_of'));?></h3>

<div class="clear sep"></div>

<div class="cls-photo-gallery">
	<div class="cls-nav-photos async-loading">
		<?php if($prev_photo_id){ $link = site_url("user/backstage/show_my_backstage/{$prev_photo_id}/?is_async=1"); echo "<a href='$link'>".language_translate('show_my_backstg_previous')."</a> |"; }?>
		<?php if($next_photo_id){ $link = site_url("user/backstage/show_my_backstage/{$next_photo_id}/?is_async=1"); echo "<a href='$link'>".language_translate('show_my_backstg_next')."</a>"; }?>
	</div>
	
	<div class="clear"></div>
	
	<?php if($this->backstage_m->getMyBackstagePhoto($id_photo)):?>
		<img src="<?php echo $path.$gallerydataobj->image; ?>" />
	<?php else:?>
		<?php echo lock_image(false);?>
	<?php endif;?>
	<div class="clear"></div>
	
	<?php echo maintainHtmlBreakLine($gallerydataobj->comment);?>
</div>

<div class="clear"></div>
<div class="cls-photo-gallery">
	<input type="hidden" id="rate_score" value="0" />
	
	<div id="rate-wrap">
		<div id="star"></div>
		<a onclick="callFuncRateObj(<?php echo $id_photo;?>);" href="javascript:void(0);" class="button hidden" id="rate-button">Rate</a>
	</div>
</div>

<div class="clear"></div>
<div class="filter-split cls-photo-comment" id="photoCommentAsyncDiv">
	<?php $this->load->view("photos/backstage/show_comments", array('id_photo'=>$id_photo)); ?>
</div>


<?php 
	$rateArr = $this->rate_m->getRateObject($id_obj=$id_photo, $obj_rate_type=$GLOBALS['global']['RATING']['backstage_photo'], $id_user_get_rated=$id_user);
	if($rateArr['rate'] != 0){
		$score = $rateArr['rate'];
	}else{
		$score = 0;
	}
	
	if($this->rate_m->wasIRatedThis($id_obj,$obj_rate_type,$id_user_get_rated)){
		$canRate = false;
	}else{
		$canRate = true;
	}
?>

<script type="text/javascript">	
	$(document).ready(function(){
		$('#star').raty({
			path: BASE_URI+'media/jquery.raty/img/',
			number: 10,
			hints:['1','2','3','4','5','6','7','8','9','10'],
			<?php if($score!=0):?>
				score    : <?php echo $score;?> ,
			<?php endif;?>
			
			<?php if(!$canRate):?>
				readOnly   : true,
			<?php endif;?>
			click: function(score, evt) {
				$('#rate_score').attr( 'value',score );
			},
		});
		<?php if($canRate):?>
			$('#rate-button').show();
		<?php endif;?>
	});
</script>










