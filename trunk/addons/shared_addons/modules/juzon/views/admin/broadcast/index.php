<section class="nav">
	<?php $this->load->view('juzon/admin/nav'); ?> 
</section>

<div class="clear"></div>
  

<section class="title">
	<h4>Send Email to users</h4> 
</section>

<?php 
	$email_template_body = 'Use these markers: {$firstname}, {$lastname}, {$username}, {$country}, {$age}, {$invite_url}';		
	$listUser = $this->juzon_broadcast_m->getListUsername();
	
?>

 	 	 	 	 	
<form method='post' action="<?php echo site_url('admin/juzon/broadcast/sendemail');?>" name="send_broadcast_email" id="send_broadcast_email" >
						
	<section class="item">
		<fieldset>
			
			<div class="row-item">
				<label>Sender name</label>
				<div class="input">
					<input type="text" name="sender_name" value="<?php echo (isset($_SESSION['var_store']['sender_name'])) ? $_SESSION['var_store']['sender_name']:'';?>" /> (required)
				</div>
			</div>
			
			<div class="row-item">
				<label>Sender email</label>
				<div class="input">
					<input type="text" name="sender_email" value="<?php echo (isset($_SESSION['var_store']['sender_email'])) ? $_SESSION['var_store']['sender_email']:'';?>" /> (required)
				</div>
			</div>
			
			<div class="row-item">
				<label>To users</label>
				<div class="input">
					<textarea style="width:250px;height:100px;" name="to_users" id="to_users"><?php echo (isset($_SESSION['var_store']['to_users'])) ? $_SESSION['var_store']['to_users']:'';?></textarea> (optional)
				</div>
			</div>
			
			<div class="row-item">
				<label>Users Country</label>
				<div class="input">
					<?php echo form_multiselect("countries[]",countryOptionData_ioc(),isset($_SESSION['var_store']['countries'])?array_values($_SESSION['var_store']['countries']):array());?> (optional)
				</div>
			</div>
			
			<div class="row-item">
				<label>Age</label>
				<div class="input">
					From <?php echo form_dropdown("age_from",ageOptionData_ioc(),array(isset($_SESSION['var_store']['age_from'])?$_SESSION['var_store']['age_from']:18));?>
					To <?php echo form_dropdown("age_to",ageOptionData_ioc(),array(isset($_SESSION['var_store']['age_to'])?$_SESSION['var_store']['age_to']:45));?>
				</div>
			</div>
			
			<div class="row-item">
				<label>Gender</label>
				<div class="input">
					<?php echo form_dropdown("gender",genderOptionData_ioc(),array(isset($_SESSION['var_store']['gender'])?$_SESSION['var_store']['gender']:null));?>
				</div>
			</div>
            
            <div class="row-item">
				<label>Registration Date</label>
				<div class="input">
                    From
					<input type="text" name="date_from" value="<?php echo (isset($_SESSION['var_store']['date_from'])) ? $_SESSION['var_store']['date_from']:'';?>" id="date_from" />
                    To
                    <input type="text" name="date_to" value="<?php echo (isset($_SESSION['var_store']['date_to'])) ? $_SESSION['var_store']['date_to']:'';?>" id="date_to" />
				</div>
			</div>
			
            <div class="row-item">
				<label>Last Login</label>
				<div class="input">
					From 
                    <input type="text" name="last_login_from" id="last_login_from" value="<?php echo (isset($_SESSION['var_store']['last_login_from'])) ? $_SESSION['var_store']['last_login_from']:'';?>" />
                    To
                    <input type="text" name="last_login_to" id="last_login_to" value="<?php echo (isset($_SESSION['var_store']['last_login_to'])) ? $_SESSION['var_store']['last_login_to']:'';?>" />
				</div>
			</div>
            
			<div class="row-item">
				<label>Subject email</label>
				<div class="input">
					<input type="text" name="subject" value="<?php echo (isset($_SESSION['var_store']['subject'])) ? ($_SESSION['var_store']['subject']):'mail to {$firstname} {$lastname}';?>" /> (required)
				</div>
			</div>
			
			<div class="row-item">
				<label>Body email</label>
				<div class="input">
					<?php echo form_textarea('body', (isset($_SESSION['var_store']['body'])) ? $_SESSION['var_store']['body']:$email_template_body, 'class="mceEditor"'); ?> 
				</div>
			</div>
			
			
			<div class="row-item">
				<label>&nbsp;</label>
				<div class="input">
					<input type="submit" value="Send" name="action" />
					<input type="submit" value="Preview" name="action" />
					<?php echo admin_loader_image_s("id='save_loader'");?> 
				</div>
			</div>
			
		</fieldset>	
	</section>
	<input type="hidden" id="hidden_text_var" name="hidden_text_var" value="<?php echo isset($_SESSION['previewBROADCAST'])?$_SESSION['previewBROADCAST']:''; ?>" />
</form>

<?php if(isset($_SESSION['previewBROADCAST'])):?>
<div class="clear"></div>
  
<section class="title">
	<h4>Send Email to users Preview</h4> 
</section>


<section class="item" style="height:800px;overflow:auto;">
	<fieldset>
		<div class="row-item">
			<?php echo $_SESSION['previewBROADCAST'];?>
		</div>
	</fieldset>
</section>
<?php endif;?>

<?php 
if(isset($_SESSION['var_store'])){
	unset($_SESSION['var_store']);
}?>

<div class="clear"></div>
  
<script type="text/javascript" src="<?php echo site_url();?>asset/tinymce/jscripts/tiny_mce/tiny_mce.js"></script>
<script type="text/javascript">
	
	tinyMCE.init({
		 
			// General options
			mode : "textareas",
			theme : "advanced",
			plugins : "autolink,lists,spellchecker,pagebreak,style,layer,table,save,advhr,advimage,advlink,emotions,iespell,inlinepopups,insertdatetime,preview,media,searchreplace,print,contextmenu,paste,directionality,fullscreen,noneditable,visualchars,nonbreaking,xhtmlxtras,template",

			// Theme options
			theme_advanced_buttons1 : "bold,italic,underline,strikethrough,|,justifyleft,justifycenter,justifyright,justifyfull,|,styleselect,formatselect,fontselect,fontsizeselect",
			theme_advanced_buttons2 : "cut,copy,paste,pastetext,pasteword,|,search,replace,|,bullist,numlist,|,outdent,indent,blockquote,|,undo,redo,|,link,unlink,anchor,image,cleanup,help,code,|,insertdate,inserttime,preview,|,forecolor,backcolor",
			theme_advanced_buttons3 : "tablecontrols,|,hr,removeformat,visualaid,|,sub,sup,|,charmap,emotions,iespell,media,advhr,|,print,|,ltr,rtl,|,fullscreen",
			theme_advanced_buttons4 : "insertlayer,moveforward,movebackward,absolute,|,styleprops,spellchecker,|,cite,abbr,acronym,del,ins,attribs,|,visualchars,nonbreaking,template,blockquote,pagebreak,|,insertfile,insertimage",
			theme_advanced_toolbar_location : "top",
			theme_advanced_toolbar_align : "left",
			theme_advanced_statusbar_location : "bottom",
			theme_advanced_resizing : true,

			// Skin options
			skin : "o2k7",
			skin_variant : "silver",

			// Example content CSS (should be your site CSS)
			content_css : "css/example.css",

			// Drop lists for link/image/media/template dialogs
			template_external_list_url : "js/template_list.js",
			external_link_list_url : "js/link_list.js",
			external_image_list_url : "js/image_list.js",
			media_external_list_url : "js/media_list.js",
			
			editor_selector : "mceEditor",
			editor_deselector : "mceNoEditor"
			
	});

	
	$(function(){
	    $( "#date_from,#date_to,#last_login_from,#last_login_to" ).datepicker(
			{
				dateFormat: 'yy-mm-dd 00:00:00',
				changeMonth: true,
				changeYear: true ,
		      }	
		);   
       
		var availableTags = <?php echo json_encode($listUser);?>;
		
		function split( val ) {
			return val.split( /,\s*/ );
		}
		function extractLast( term ) {
			return split( term ).pop();
		}

		$( "#to_users" )
			// don't navigate away from the field on tab when selecting an item
			.bind( "keydown", function( event ) {
				if ( event.keyCode === $.ui.keyCode.TAB &&
						$( this ).data( "autocomplete" ).menu.active ) {
					event.preventDefault();
				}
			})
			.autocomplete({
				minLength: 1,
				source: function( request, response ) {
					// delegate back to autocomplete, but extract the last term
					response( $.ui.autocomplete.filter(
						availableTags, extractLast( request.term ) ) );
				},
				focus: function() {
					// prevent value inserted on focus
					return false;
				},
				select: function( event, ui ) {
					var terms = split( this.value );
					// remove the current input
					terms.pop();
					// add the selected item
					terms.push( ui.item.value );
					// add placeholder to get the comma-and-space at the end
					terms.push( "" );
					this.value = terms.join( ", " );
					return false;
				}
			});
	});
	
	
	
	jQuery(document).ready(function(){
		var options = { 
			beforeSubmit:  validateB4Submit,  
			success:       processAfterResponding  
		};	
		//jQuery('#send_broadcast_email').ajaxForm(options); 
	 
	});
	
	function validateB4Submit(formData, jqForm, options){
		jQuery('#save_loader').show();
		return true;
	}

	function processAfterResponding(responseText, statusText, xhr, $form) {
		jQuery('#save_loader').hide();	
		if(responseText == 'ok'){
			reload();
		}else{
			$('#hiddenElement').html(responseText);
			$('#hiddenElement').dialog(
				{
					width: 550,
					height:450 ,
					//draggable: false,
					//resizable: false,
					buttons:{},
					title: 'Broadcast Preview' 
				}
			);
		}
	}
	
	<?php if(isset($_SESSION['previewBROADCAST'])):?>
		<?php 
			unset($_SESSION['previewBROADCAST']);
		?>
		/*
			$('#hiddenElement').html($('#hidden_text_var').val());
			$('#hiddenElement').dialog(
				{
					width: 550,
					height:400 ,
					//draggable: false,
					//resizable: false,
					buttons:{},
					title: 'Broadcast Preview' 
				}
			);
		*/	
	<?php endif;?>
</script>










