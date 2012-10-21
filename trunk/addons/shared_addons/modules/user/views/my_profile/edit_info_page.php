<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>

<div id="fb-root"></div>

<div id="body-content">
   <?php $this->load->view("user/partial/left");?>
 
	<div id="body">
		<div class="body">
			<div id="content">
				<?php $this->load->view("user/partial/top"); ?>
				<div class="clear"></div>
				
				<div class="filter-split">
					<?php $this->load->view("my_profile/user_info", array('userdataobj'=>$userdataobj)); ?>
				</div>
				 
				<div class="clear"></div>
				 
				<div class="filter-split">
					
											
					<?php 
						$userdataobj = getAccountUserDataObject(true);
						$userfavoritedata = $this->mod_io_m->init('id_user',$userdataobj->id_user,TBL_FAVORITE);
						echo form_open(
											$action = site_url("mod_io/account_func/submit_change_basic_info"), 
											$attributes = "method='post' id='submit_change_basic_info' name='submit_change_basic_info' ", 
											$hidden = array()
									);
					?>
																		

							<div class="box-profile user-profile body-container">
								<h3>Edit Basic Info</h3>
								
								<label>About me:</label> 
								<div class="inputcls">
									<textarea name="about_me" id="about_me" maxlength="500" style="width:300px;height:100px;"><?php echo $userdataobj->about_me;?></textarea>
								</div>
								<div class="clear"></div>
								
								<label>Sex:</label> 
								<div class="inputcls">
									<?php 
										echo form_dropdown('gender',userGenderOptionData_ioc(), array($userdataobj->gender),'gender');
									?>
								</div>
								<div class="clear"></div>
								
								<label>Languages:</label> 
								<div class="inputcls">
									<input type="text" name="languages" id="languages" maxlength="200" value="<?php if($userfavoritedata AND $userfavoritedata->language) echo $userfavoritedata->language;?>" style="width:300px;"/>
								</div>
								<div class="clear"></div>
								
								<label>Relationship status:</label> 
								<div class="inputcls">
									<?php 
										$status = ($userdataobj->rel_status)?$userdataobj->rel_status:null;
										echo form_dropdown('relationship',relationshipOptionData_ioc(), array($status),'relationship');
									?>
								</div>
								<div class="clear"></div>
								
								<label>Interested in:</label> 
								<div class="inputcls">
									<?php 
										if($userfavoritedata AND $userfavoritedata->interested_in){
											$status = $userfavoritedata->interested_in;
										}else{
											$status = null;
										}
										echo form_dropdown('interested_in',interestedInOptionData_ioc(), array($status),'interested_in');
									?>
								</div>
								<div class="clear"></div>
								
								
								<label>Music:</label> 
								<div class="inputcls">
									<input type="text" maxlength="200" name="music" id="music" value="<?php if($userfavoritedata AND $userfavoritedata->music){echo $userfavoritedata->music;}?>" style="width:300px;"/>
								</div>
								<div class="clear"></div>
								
						
								<label>Book:</label> 
								<div class="inputcls">
									<input type="text" maxlength="200" name="book" id="book" value="<?php if($userfavoritedata AND $userfavoritedata->book){echo $userfavoritedata->book;}?>" style="width:300px;"/>
								</div>
								<div class="clear"></div>
						
						
								<label>TV Show:</label> 
								<div class="inputcls">
									<input type="text" maxlength="200" name="tvshow" id="tvshow" value="<?php if($userfavoritedata AND $userfavoritedata->tvshow){echo $userfavoritedata->tvshow;}?>" style="width:300px;"/>
								</div>
								<div class="clear"></div>
								
								
								<label>Games:</label> 
								<div class="inputcls">
									<input type="text" maxlength="200" name="videogame" id="videogame" value="<?php if($userfavoritedata AND $userfavoritedata->videogame){echo $userfavoritedata->videogame;}?>" style="width:300px;"/>
								</div>
								<div class="clear"></div>
								
								
								<label>Activities:</label> 
								<div class="inputcls">
									<input type="text" maxlength="200" name="activity" id="activity" value="<?php if($userfavoritedata AND $userfavoritedata->activity){echo $userfavoritedata->activity;}?>" style="width:300px;"/>
								</div>
								<div class="clear"></div>
								
								
								<label>Interests:</label> 
								<div class="inputcls">
									<input type="text" maxlength="200" name="interests" id="interests" value="<?php if($userfavoritedata AND $userfavoritedata->interests){echo $userfavoritedata->interests;}?>" style="width:300px;"/>
								</div>
								<div class="clear"></div>
								
						
								<div class="clear"></div>
								
								<label>&nbsp;</label> 
								<div class="inputcls">
									<input type="submit" value="Save" name="submit" class="share-2" />
									<?php echo loader_image_s("id='loaderContextLoader' class='hidden'");?>
								</div>
								
								<div class="clear"></div>
							</div>

							<?php echo form_close();?>

												
					
				</div>
				 
				<div class="clear"></div>
				
			</div>
		</div>
	   <?php $this->load->view("user/partial/right");?>
	</div>
	<div class="clear"></div>
	
</div>



<script type="text/javascript">
	$(document).ready(function(){
		var availableTags = <?php echo json_encode(getAvailableLanguagesOptionData_ioc());?>;
		
		function split( val ) {
			return val.split( /,\s*/ );
		}
		function extractLast( term ) {
			return split( term ).pop();
		}

		$( "#languages" )
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
	
	
	
	$(document).ready(function(){
		var options = { 
			beforeSubmit:  validateB4Submit,  
			success:       processAfterResponding  
		};	
		$('#submit_change_basic_info').ajaxForm(options); 
	});
	
	function validateB4Submit(formData, jqForm, options){
		$('#loaderContextLoader').show();
		return true;
	}

	function processAfterResponding(responseText, statusText, xhr, $form) {
		$('#loaderContextLoader').hide();	
		if(responseText == 'ok'){
			sysMessage('Save successfully.');
		}else{
			sysWarning(responseText);
		}
	}
</script>