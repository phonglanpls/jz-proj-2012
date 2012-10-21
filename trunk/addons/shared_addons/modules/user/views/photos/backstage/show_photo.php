<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>

<script type="text/javascript" src="<?php echo site_url();?>/media/js/photos.js"></script> 
<script type="text/javascript" src="<?php echo site_url();?>/media/jquery.raty/js/jquery.raty.min.js"></script> 
<script type="text/javascript" src="<?php echo site_url();?>/media/js/collection.js"></script> 
<script type="text/javascript" src="<?php echo site_url();?>/media/js/backstage.js"></script> 

<?php 
	$gallerydataobj = $this->gallery_io_m->init('id_image',$id_photo);
	
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
		$this->rate_m->ratePhoto($id_photo,$this->input->get('score'),$this->input->get('rate_type'));
	}
	
	$is_async = $this->input->get('is_async','');
	
	$isMyCollectionPhoto = $this->collection_m->isMyCollectionPhoto($id_photo);
	if($this->collection_m->isMyCollectionPhoto($id_photo) OR $this->backstage_m->isMyBackstagePhoto($id_photo)){
		$readPermission = true;
	}else{
		$readPermission = false;
	}
	
?>

<?php if(!$is_async):?>
	<div id="photoCollectionAsyncDiv">
<?php endif;?>

<h3><?php echo $this->user_m->getProfileDisplayName($id_user);?>'s backstage photo.</h3>

<div class="clear sep"></div>

<div class="cls-photo-gallery">
	<div class="cls-nav-photos async-loading">
		<?php if($prev_photo_id){ $link = site_url("user/photos/backstage/{$prev_photo_id}/?is_async=1"); echo "<a href='$link'>&laquo; Previous</a> |"; }?>
		<?php if($next_photo_id){ $link = site_url("user/photos/backstage/{$next_photo_id}/?is_async=1"); echo "<a href='$link'>Next &raquo;</a>"; }?>
	</div>
	
	<div class="clear"></div>
	
	<?php if($readPermission):?>
		<img src="<?php echo $path.$gallerydataobj->image; ?>" />
	<?php else:?>
		<?php echo lock_image(false);?>
	<?php endif;?>
	<div class="clear"></div>
	
	<?php echo $gallerydataobj->comment;?>
</div>

<div class="clear"></div>
<div class="cls-photo-gallery">
	<input type="hidden" id="rate_score" value="0" />
	
	<div id="rate-wrap">
		<div id="star"></div>
		<a onclick="callFuncRateObj_myCollectionContext(<?php echo $id_photo;?>,'<?php echo $GLOBALS['global']['RATING']['backstage_photo'];?>');" href="javascript:void(0);" class="button hidden" id="rate-button">Rate</a>
	</div>
</div>

<div class="clear"></div>

<?php if( ! $readPermission):?>
		
	<div class="cls-photo-gallery">
		<div class="user-profile-button" style="width:180px;margin-left:200px;float:right;">
			<a href="javascript:void(0);" onclick="callFuncBuyThisBackstagePhoto(<?php echo $id_photo;?>)">
				Buy For <?php echo currencyDisplay($gallerydataobj->price);?>J$
			</a>
		</div>	
	</div>

<?php endif;?>

<div class="clear"></div>
<div class="filter-split cls-photo-comment" id="photoCommentAsyncDiv">
	<?php  $this->load->view("photos/show_comments", array('id_photo'=>$id_photo)); ?>
</div>

<?php if(!$is_async):?>
	</div>
<?php endif;?>

<?php 
	$rateArr = $this->rate_m->getRateObject($id_obj=$id_photo, $obj_rate_type=$GLOBALS['global']['RATING']['backstage_photo'], $id_user_get_rated=$id_user);
	if($rateArr['rate'] != 0){
		$score = $rateArr['rate'];
	}else{
		$score = 0;
	}
	
	if($this->rate_m->wasIRatedThis($id_obj,$obj_rate_type,$id_user_get_rated) OR !$readPermission ){
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











