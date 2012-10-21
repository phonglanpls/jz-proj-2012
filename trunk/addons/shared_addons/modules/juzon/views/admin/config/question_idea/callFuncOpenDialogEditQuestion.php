
<?php 
	$id_ques = intval( $this->input->get('id_ques') );
	$questiondata = $this->mod_io_m->init('id_question',$id_ques,TBL_QUESTION_DEF);
?>


<?php echo form_open( 	site_url('admin/juzon/config/saveQuestionIdea'), 
						$attributes = "method='post' id='saveQuestionIdea' name='saveQuestionIdea'", 
						$hidden = array() 
					);					
?> 

<input type="hidden" name="id_question" value="<?php echo $id_ques;?>" />

<div id="dialog-wrap">
	<div class="row-item">
		<label> Question</label>
		<div class="input">
			<textarea name="question" style="width:350px;height:120px;"><?php if($questiondata) echo $questiondata->question;?></textarea>
			<div class="clear"></div>
			
			<input type="submit" value="Save" />
			<input type="button" value="Cancel" onclick="$('#hiddenElement').dialog('close');"/>
			<?php echo admin_loader_image_s("id='save_loader'");?>
		</div>
	</div>
</div>


<?php echo form_close(); ?>




<script type="text/javascript">
	jQuery(document).ready(function(){
		var options = { 
			beforeSubmit:  validateB4Submit,  
			success:       processAfterResponding  
		};	
		jQuery('#saveQuestionIdea').ajaxForm(options); 
	 
	});
	
	function validateB4Submit(formData, jqForm, options){
		jQuery('#save_loader').show();
		return true;
	}

	function processAfterResponding(responseText, statusText, xhr, $form) {
		jQuery('#save_loader').hide();	
		if(responseText == 'ok'){
			gotoDefaultPage();
		}else{
			debug(responseText);
		}
	}
	
	function gotoDefaultPage(){
		queryurl(BASE_URI+'admin/juzon/config/question_idea');
	}
</script>