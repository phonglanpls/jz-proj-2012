 <?php 
	$userdataobj = getAccountUserDataObject();
	if( strtolower( $userdataobj->gender ) == 'male'){
		$oppsex = 'Female';
	}else{
		$oppsex = 'Male';
	}
 ?>
 
 <div class="widget">
	<h4><?php echo language_translate('left_menu_label_write_your_msg_here');?></h4>  
	<?php echo language_translate('left_menu_label_your_msg_hit_one_rd_user');?>
	<div class="form">
		<textarea cols="10" rows="10" name="message_rd" id="message_rd" maxlength="<?php echo $GLOBALS['global']['INPUT_LIMIT']['random_message'];?>"></textarea>
		
		<div class="clear sep"></div>
		
		<div style="margin:2px 0px;"><?php echo language_translate('left_menu_label_you_have');?><span id="leftLetters_info"><?php echo $GLOBALS['global']['INPUT_LIMIT']['random_message'];?></span> <?php echo language_translate('left_menu_label_characters_left');?> </div>
		
		<div class="clear sep"></div>
		
		<label><b><?php echo language_translate('left_menu_label_to');?></b> </label>
		<?php echo form_dropdown('gender',genderOptionData_ioc(), array($oppsex), 'id="gender"');?>	&nbsp;
		<?php echo form_dropdown('type',sendRandomMessageOptionData_ioc(), array(), 'id="type"');?>	
		
		<div class="clear sep"></div>
		
		<input type="submit" value="<?php echo language_translate('left_menu_label_send');?>" name="submit" onclick="callFuncSendRandomMessage();" />
		<?php echo loader_image_s("id=\"sendRandomMessageContextLoader\" class='hidden'");?> 
		
		<div class="clear"></div>
		
		
	</div>
	
	
</div>


<script type="text/javascript">
	var sending = 0;
	$(document).ready(function(){
		var TOTAL = <?php echo $GLOBALS['global']['INPUT_LIMIT']['random_message'];?>;
		$('#message_rd').live('keyup',function(){
			$length = TOTAL - $(this).val().length;
			$('#leftLetters_info').text($length);
		});
	});
	
</script>		