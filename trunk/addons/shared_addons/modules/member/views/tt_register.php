<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>

<?php 

	if(isTwitterLogin()){
		if($this->twittermodel->isTwitterConnected()){
			redirect("member/proceedTwitterUserConnected");
		}
		$dataarr = $this->twittermodel->getCurrentUserDetails();
	}else{
		redirect("member/login");
	}
	$name = explode(' ',$dataarr['name'],2);
	
    if($dataarr["screen_name"]){
		$uname = str_replace('.','',$dataarr["screen_name"]);
	}else{
		$uname = strtolower($dataarr['name']);
        $uname = str_replace('.','',$uname);
	}
?>
<div id="page-login">
    <?php echo form_open($action = site_url("member/submit_tt_register"), $attributes = "method='post' id='submit_tt_register' name='submit_tt_register' ", $hidden = array());?>
		<div class="input">
			<h3><?php echo language_translate('member_tt_connect_label');?></h3>
		</div>
		
		<div class="input">
			<img src="<?php echo $dataarr["profile_image_url"];?>"/>
		</div>	
		
		<div class="input">
			<label><?php echo language_translate('member_fb_connect_firstname');?></label>
			<input type="text" value="<?php echo $name[0];?>" name="firstname" class="text" maxlength="45" />
		</div>
		
		<div class="input">
			<label><?php echo language_translate('member_fb_connect_lastname');?></label>
			<input type="text" value="<?php echo $name[1];?>" name="lastname" class="text" maxlength="45" />
		</div>
		
		<div class="input">
			<label><?php echo language_translate('member_vanity_url_label');?></label>
			<div id="vanity_url"><b><?php echo site_url();?><span id='username_url'></span></b></div>
		</div>
		
		<div class="input">
			<label><?php echo language_translate('member_fb_connect_username');?></label>
			<input type="text" value="<?php echo $uname; ?>" name="username" id="username" class="text" maxlength="45" />
			
			<div class="clear"></div>
			
			<a href="javascript:void(0);" onclick="checkUsernameValid();"><?php echo language_translate('member_fb_connect_check_username');?></a>
			<?php echo loader_image_s("id='checkUsername_loader' class='hidden'");?>
			
		</div>
		
		<div class="input">
			<label><?php echo language_translate('member_login_label_password');?></label>
			<input type="password" value="" name="password" class="text" maxlength="45" />
		</div>
		
		<div class="input">
			<label><?php echo language_translate('member_fb_connect_gender');?></label>
			<?php echo form_dropdown('gender',userGenderOptionData_ioc(),array(),'id="gender"');?>
		</div>
		
		<div class="input">
			<label><?php echo language_translate('member_login_label_email');?></label>
			<input type="text" value="" name="email" class="text" maxlength="45" />
		</div>
		
		<div class="input">
			<label><?php echo language_translate('member_fb_connect_birthday');?></label>
		<!--	<input type="text" value="" name="birthday" id="birthday" class="text" maxlength="45" /> -->
            <?php echo dayMonthYearSelectBox(0,'day','month','year',array('d'));?> /
            <?php echo dayMonthYearSelectBox(0,'day','month','year',array('m'));?> /
            <?php echo dayMonthYearSelectBox(0,'day','month','year',array('y'));?> 
		</div>
		
		<div class="input">
			<label><?php echo language_translate('member_fb_connect_timezone');?></label>
			<?php echo form_dropdown( $name='timezone', timezoneDataOption_ioc(), array(  ), $extra=" id='timezone' class='inputcls'" );?>	
		</div>
		
		<div class="input">
			<input type="checkbox" name="agree" id="agree" checked="checked" />
			<?php echo language_translate('member_fb_connect_agree_terms_conditions');?>
		</div>
		
		<div class="input">
			<div class="input-padding">
				<input type="submit" value="<?php echo language_translate('member_login_button_login');?>" name="submit" class="share-2" />
			</div>
		</div>
		
		<input type="hidden" name="latitude" id="latitude" value="" />
		<input type="hidden" name="longitude" id="longitude" value="" />
		
	<?php echo form_close();?>
	
	<div class="clear"></div>
	<div id="termsAndConditions" class="hidden">
		{{getpost:body_slug slug="term-and-conditions"}}
	</div> 
</div>
	
<script type="text/javascript">
	$(document).ready(function() {
		var options = { 
			dataType:  'json', 	
			beforeSubmit:  validateB4Submit,  
			success:       processAfterResponding   
		};	
		$('#submit_tt_register').ajaxForm(options); 
		checkUsernameValid();
		
		navigator.geolocation.getCurrentPosition(show_map);
		showUrl();
		$('#username').bind('keyup',function(){
			showUrl();
		});
		/**
		$( "#birthday" ).datepicker(
			{
				dateFormat: 'dd-mm-yy',
				changeMonth: true,
				changeYear: true ,
				yearRange: 'c-40:c'
			}	
		);
		**/
	});	
	
	function showUrl(){
		var username = $('#username').attr('value');
		$('#username_url').text(username);
	}
	
	function checkUsernameValid(){
		var username = $('#username').attr('value');
		$('#checkUsername_loader').toggle();
		$.post(BASE_URI+'member/checkUsernameValid',{username:username},function(res){
			$('#checkUsername_loader').toggle();
			if(res.result == 'ERROR'){
				siteWarning(res.message);
			}else{
				siteMessage(res.message);
			}
		},'json');
	}
		
	function validateB4Submit(formData, jqForm, options){
		siteLoadingOn();
		return true;
	}

	function processAfterResponding(responseJson, statusText, xhr, $form) {
		siteLoadingOff();
		if(responseJson.result == 'ok'){
			siteMessage(responseJson.message);
			queryurl( BASE_URI+'user' );
		}else{
			siteWarning(responseJson.message);
			$(window).scrollTop(0);
		}
	}
	
	function openTermsAndConditions(){
		siteLoadingDialogOn();
		$('#termsAndConditions').dialog(
			{
				 width: 650,
				 height:450 ,
				 draggable: false,
				 resizable: false,
				 close: function(event, ui) { 
					siteLoadingDialogOff();
				},
				buttons:{
					"OK": function(){$("#termsAndConditions").dialog("close");}
				},
				title: 'Terms and Conditions' 
			}
		);
	}
	
	function show_map(position) {
	  var latitude = position.coords.latitude;
	  var longitude = position.coords.longitude;

	  $('#latitude').attr('value',latitude);
	  $('#longitude').attr('value',longitude);
	}
	
	
</script>	