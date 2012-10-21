<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>

<script type="text/javascript" src="<?php echo site_url();?>/media/js/peeps.js"></script> 

<?php 
	$id_user = $this->input->get('id_user',0);
	
	$arrSearchType = array(
		'checked_me' => 'Checked Me',
		//'normal_photo' => 'Photo Rating'
	);
?>

<?php if(! $this->peepbought_history_m->wasIBoughtPeepedUser($id_user)):?> 
	You had not bought peeped access.
<?php else:?>
	  
	<div id="wrapUI">	
			<div class="filter-split">
				Search Type: <?php echo form_dropdown('search_type',$arrSearchType, array(), 'id="search_type" onchange="javascript:callFuncShowPeeps();"');?>
				&nbsp;&nbsp;&nbsp;
				Sort By: <?php echo form_dropdown('sort_by',peepSortOptionData_ioc(), array(), 'id="sort_by" onchange="javascript:callFuncShowPeeps();"' );?>
				<?php echo loader_image_s("id='peepContextLoader' class='hidden'");?>
			</div>
			
			<input type="hidden" id="hidden_id_user" value="<?php echo $id_user;?>" />
			
			<div id="peepAsyncDiv">
			</div>
	</div>				

<?php endif;?>			

<script type="text/javascript">
	$(document).ready(function(){
		callFuncShowPeeps();
		
		$('.pagination a').live('click',function(){
			$href = $(this).attr('href');
			$('#peepContextLoader').toggle();
			$.get($href,{},function(res){
				$('#peepContextLoader').toggle();
				$('#peepAsyncDiv').html(res);
				return false;
			});
			return false;
		});
	});
</script>