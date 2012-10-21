	<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
	
	<script type="text/javascript" src="<?php echo site_url();?>/media/jquery.raty/js/jquery.raty.min.js"></script>

	<?php 
		if($this->input->get('task') == 'rate'){
			$score = $this->input->get('score'); 
			$this->rate_m->rateHentai($id_video, $score);
		}
	?>
	
	<div class="clear"></div>
	<div class="cls-photo-gallery">
		<input type="hidden" id="rate_score" value="0" />
		
		<div id="rate-wrap">
			<div id="star"></div>
			<a onclick="callFuncRateHentaiVideo(<?php echo $id_video;?>,'<?php echo $GLOBALS['global']['RATING']['hentai'];?>');" href="javascript:void(0);" class="button hidden" id="rate-button">Rate</a>
		</div>
	</div>
								
	<?php 
		$rateArr = $this->rate_m->getRateObject($id_obj=$id_video, $obj_rate_type=$GLOBALS['global']['RATING']['hentai'], $id_user_get_rated=1);
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