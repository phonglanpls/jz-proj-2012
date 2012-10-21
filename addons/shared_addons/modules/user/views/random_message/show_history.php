<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>

<!--
<div class="filter-split" style="border:1px solid #cfcfcf;padding:5px;margin-bottom:25px;"> 
	<label><b>Send to:</b> </label>
	<?php //echo form_dropdown('gender',genderOptionData_ioc(), array(), 'id="gender"');?>	&nbsp;&nbsp;&nbsp;
	<?php //echo form_dropdown('type',sendRandomMessageOptionData_ioc(), array(), 'id="type"');?>	
	 
	<div class="clear sep"></div>
	<label><b>Message:</b> </label>
	<textarea name="message" id="message" class="disablecopypaste" style="width:350px;height:100px;"></textarea>
	
	<div class="clear"></div>
	<label>&nbsp;</label>You have <span id="leftLetters">200</span> characters left. 
	
	<div class="clear sep"></div>
	<div style="float:right;margin-right:10px;">
		<?php //echo loader_image_s("id=\"sendRandomMessageContextLoader\" class='hidden'");?> 
		
		<input type="button" value="Send" class="share-2" onclick="callFuncSendRandomMessage();"/>
		<div class="clear"></div>
	</div>	
	<div class="clear"></div>
	
</div>
				

<script type="text/javascript">
	var sending = 0;
	$(document).ready(function(){
		var TOTAL = 200;
		$('#message').live('keyup',function(){
			$length = 200 - $(this).val().length;
			$('#leftLetters').text($length);
		});
	});
	
</script>		

-->

<?php 
	if(isset($_GET['per_page'])){
		$offset = intval($_GET['per_page']);
	}else{
		$offset = 0;
	}
	
	$total = count($this->random_message_m->getRandomMessage(getAccountUserId()));
	
	$searchArray = $this->random_message_m->getRandomMessage(getAccountUserId(),$offset,$GLOBALS['global']['PAGINATE']['rec_per_page']);
	
	$pagination = create_pagination( 
					$uri = "user/random_message/showHistory/", 
					$total_rows = $total , 
					$limit= $GLOBALS['global']['PAGINATE']['rec_per_page'],
					$uri_segment = 0,
					TRUE, TRUE 
				);
				
?>		

<?php if($total):?>
	<table>
		<thead>
			<tr>
				<td width="150px" style="text-align:center;">Sent To</td> 
				<td width="200px" style="text-align:center;">Message</td>
				<td width="50px" style="text-align:center;">Type</td>	
				<td width="100px" style="text-align:center;">Date/time</td>		
			</tr>
		</thead>
		<?php foreach($searchArray as $item):?>
			<tr>
				<td style="text-align:center;">
					<div class="user-profile-username">
						<img src="<?php echo $this->user_m->getProfileAvatar($item->id_user_to);?>" />
					</div>
					<div class="user-profile-username">
						<?php echo $this->user_m->getProfileDisplayName($item->id_user_to);?>
					</div>
				</td> 
				<td style="text-align:center;">
					<?php echo $item->message;?>
				</td>
				<td style="text-align:center;">
					<?php 
						if($item->type_message ==1){
							echo "Email";
						}else{
							echo "Chat";
						}
					?>
				</td>
				<td style="text-align:center;">
					<?php echo juzTimeDisplay( $item->sentdate );?>
				</td>	
			</tr>
		<?php endforeach;?>
	</table>
	
	<div class="clear"></div>
	<div class="pagination">
		<?php echo $pagination['links'];?>
		<?php echo loader_image_s("id=\"paginationContextLoader\" class='hidden'");?>
	</div>	
	
<?php endif;?>