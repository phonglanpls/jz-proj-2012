<section class="nav">
	<?php $this->load->view('juzon/admin/nav'); ?> 
</section>

<div class="clear"></div>

<section class="nav">
	<?php $this->load->view('juzon/admin/config/top_nav'); ?>
</section>


<section class="title">
	<?php $this->load->view('juzon/admin/config/top'); ?> 
</section>

<?php echo form_open( 	site_url('admin/juzon/config/submit_config'), 
						$attributes = "method='post' id='submit_config' name='submit_config'", 
						$hidden = array() 
					);					
?> 
 
<section class="item">
	 
	<fieldset>
		<legend>Price And Tax</legend>
		 
		 <div class="row-item">
			<div class="half-row">
				<fieldset>
					<legend>Backstage Photo</legend>
					
					<label> Site (%)</label>
					<div class="input">
						<input type="text" name="global[BACKSTG_PRICE][site]" value="<?php echo $GLOBALS['global']['BACKSTG_PRICE']['site'];?>" />
					</div>
					
					<div class="clear"></div>
					
					<label> User (%)</label>
					<div class="input">
						<input type="text" name="global[BACKSTG_PRICE][owner]" value="<?php echo $GLOBALS['global']['BACKSTG_PRICE']['owner'];?>" />
					</div>
				</fieldset>	
			</div>
			
			<div class="half-row">
				<fieldset>
					<legend>Map Flirts</legend>
					
					<label> Site (%)</label>
					<div class="input">
						<input type="text" name="global[MAP_PRICE][site]" value="<?php echo $GLOBALS['global']['MAP_PRICE']['site'];?>" />
					</div>
					
					<div class="clear"></div>
					
					<label> User (%)</label>
					<div class="input">
						<input type="text" name="global[MAP_PRICE][user]" value="<?php echo $GLOBALS['global']['MAP_PRICE']['user'];?>" />
					</div>
				</fieldset>	
			</div>
		 </div>
		 
		 
		<div class="row-item">
			<div class="half-row">
				<fieldset>
					<legend>Peep</legend>
					
					<label> Site (%)</label>
					<div class="input">
						<input type="text" name="global[PEEP_PRICE][site]" value="<?php echo $GLOBALS['global']['PEEP_PRICE']['site'];?>" />
					</div>
					
					<div class="clear"></div>
					
					<label> User (%)</label>
					<div class="input">
						<input type="text" name="global[PEEP_PRICE][user]" value="<?php echo $GLOBALS['global']['PEEP_PRICE']['user'];?>" />
					</div>
				</fieldset>	
			</div>
		  
			<div class="half-row">
				<fieldset>
					<legend>Default Cost</legend>
					
					<label> Map access (J$)</label>
					<div class="input">
						<input type="text" name="global[ADMIN_DEFAULT][map]" value="<?php echo $GLOBALS['global']['ADMIN_DEFAULT']['map'];?>" />
					</div>
					
					<div class="clear"></div>
					
					<label> Peeped access (J$)</label>
					<div class="input">
						<input type="text" name="global[ADMIN_DEFAULT][peep]" value="<?php echo $GLOBALS['global']['ADMIN_DEFAULT']['peep'];?>" />
					</div>
					
					<div class="clear"></div>
					
					<label> Download hentai (J$)</label>
					<div class="input">
						<input type="text" name="global[ADMIN_DEFAULT][download]" value="<?php echo $GLOBALS['global']['ADMIN_DEFAULT']['download'];?>" />
					</div>
					
					<div class="clear"></div>
					
					<label> Affordable price (J$)</label>
					<div class="input">
						<input type="text" name="global[AFFORDABLE][min_price]" value="<?php echo $GLOBALS['global']['AFFORDABLE']['min_price'];?>" />
					</div>
					
					<div class="clear"></div>
					
					<label> "Favourite Show" price (J$)</label>
					<div class="input">
						<input type="text" name="global[ADMIN_DEFAULT][favourite]" value="<?php echo $GLOBALS['global']['ADMIN_DEFAULT']['favourite'];?>" />
					</div>
					
				</fieldset>	
			</div>
		</div>
		
		
		<div class="row-item">
			<div class="half-row">
				<fieldset>
					<legend>Pet</legend>
					
					<label> Pet percentage (%)</label>
					<div class="input">
						<input type="text" name="global[PET_VALUE][pet_percentage]" value="<?php echo $GLOBALS['global']['PET_VALUE']['pet_percentage'];?>" />
					</div>
					
					<div class="clear"></div>
					
					<label> Tax transaction (%)</label>
					<div class="input">
						<input type="text" name="global[PET_VALUE][tax_trans]" value="<?php echo $GLOBALS['global']['PET_VALUE']['tax_trans'];?>" />
					</div>
				</fieldset>	
                
                <div class="clear"></div>
                
                <fieldset>
					<legend>Pet Lock</legend>
					
					<label> Pet percentage (%)</label>
					<div class="input">
						<input type="text" name="global[LOCKPET][user]" value="<?php echo $GLOBALS['global']['LOCKPET']['user'];?>" />
					</div>
					
					<div class="clear"></div>
					
					<label> Tax transaction (%)</label>
					<div class="input">
						<input type="text" name="global[LOCKPET][site]" value="<?php echo $GLOBALS['global']['LOCKPET']['site'];?>" />
					</div>
				</fieldset>	
                
			</div>
			
			<div class="half-row">
				<fieldset>
					<legend>User join</legend>
					
					<label> User cash (J$)</label>
					<div class="input">
						<input type="text" name="global[USER_CASH][invited_cash]" value="<?php echo $GLOBALS['global']['USER_CASH']['invited_cash'];?>" />
					</div>
					
					<div class="clear"></div>
					
					<label> User Pet Start (J$)</label>
					<div class="input">
						<input type="text" name="global[USER_CASH][pet_start_value]" value="<?php echo $GLOBALS['global']['USER_CASH']['pet_start_value'];?>" />
					</div>
					
					<div class="clear"></div>
					
					<label> Inviter Cash (J$)</label>
					<div class="input">
						<input type="text" name="global[USER_CASH][invite_cash]" value="<?php echo $GLOBALS['global']['USER_CASH']['invite_cash'];?>" />
					</div>
				</fieldset>	
			</div>
			
		</div>
	</fieldset>
   
	<div class="clear"></div>
	
	<fieldset>
		<legend>Email</legend>
		
		<div class="row-item">
			<div class="half-row">
				<fieldset>
					<legend>Site</legend>
					
					<label> Sender email</label>
					<div class="input">
						<input type="text" name="global[SITE_ADMIN][email]" value="<?php echo $GLOBALS['global']['SITE_ADMIN']['email'];?>" />
					</div>
					
					<div class="clear"></div>
					<label> Admin alert email</label>
					<div class="input">
						<input type="text" name="global[EMAIL_ALERTS][emailalerts]" value="<?php echo $GLOBALS['global']['EMAIL_ALERTS']['emailalerts'];?>" />
					</div>
                    
                    <div class="clear"></div>
					<label> Send offline chat email</label>
					<div class="input">
						<input type="text" name="global[OFFLINE_CHAT][send_email]" value="<?php echo $GLOBALS['global']['OFFLINE_CHAT']['send_email'];?>" /> <br />(1: turn on; 0:turn off)
					</div>
					 
				</fieldset>	
			</div>
			
			<div class="half-row">
				<fieldset>
					<legend>Default invite email</legend>
					
					<label> Default email</label>
					<div class="input">
						<input type="text" name="global[HOME_PAGE][defaultinviterforhomepage]" value="<?php echo $GLOBALS['global']['HOME_PAGE']['defaultinviterforhomepage'];?>" />
					</div>
					
					<div class="clear"></div>
					 
				</fieldset>	
			</div>
		
		</div>
		
	</fieldset>

	<div class="clear"></div>
	
	<fieldset>
		<legend>Key</legend>
		<div class="row-item">
			<div class="half-row">
				<fieldset>
					<legend>Facebook</legend>
					
					<label> API Key</label>
					<div class="input">
						<input type="text" name="global[FACEBOOK][api_key]" value="<?php echo $GLOBALS['global']['FACEBOOK']['api_key'];?>" />
					</div>
					
					<div class="clear"></div>
					<label> API secret</label>
					<div class="input">
						<input type="text" name="global[FACEBOOK][api_secret]" value="<?php echo $GLOBALS['global']['FACEBOOK']['api_secret'];?>" />
					</div>
					
					<div class="clear"></div>
					<label> Min Friends Required</label>
					<div class="input">
						<input type="text" name="global[FACEBOOK][MinFacebookFriendsRequired]" value="<?php echo $GLOBALS['global']['FACEBOOK']['MinFacebookFriendsRequired'];?>" />
					</div>
					
					<div class="clear"></div>
					<label> Min Photos Required</label>
					<div class="input">
						<input type="text" name="global[FACEBOOK][MinFacebookPhotosRequired]" value="<?php echo $GLOBALS['global']['FACEBOOK']['MinFacebookPhotosRequired'];?>" />
					</div>
					
					<div class="clear"></div>
					<label> Status Message</label>
					<div class="input">
						<input type="text" name="global[FACEBOOK][FirstStatusMessage]" value="<?php echo $GLOBALS['global']['FACEBOOK']['FirstStatusMessage'];?>" />
					</div>
					
					<div class="clear"></div>
					<label> Status Description</label>
					<div class="input">
						<input type="text" name="global[FACEBOOK][FirstStatusDescription]" value="<?php echo $GLOBALS['global']['FACEBOOK']['FirstStatusDescription'];?>" />
					</div>
					
				</fieldset>	
			</div>
			
			<div class="half-row">
				<fieldset>
					<legend>Twitter</legend>
					
					<label> Consumer Key</label>
					<div class="input">
						<input type="text" name="global[TWITTER][consumer_key]" value="<?php echo $GLOBALS['global']['TWITTER']['consumer_key'];?>" />
					</div>
					
					<div class="clear"></div>
					<label> Consumer secret</label>
					<div class="input">
						<input type="text" name="global[TWITTER][consumer_secret]" value="<?php echo $GLOBALS['global']['TWITTER']['consumer_secret'];?>" />
					</div>
					
					<div class="clear"></div>
					<label> Min Followers Required</label>
					<div class="input">
						<input type="text" name="global[TWITTER][MinFollowersRequired]" value="<?php echo $GLOBALS['global']['TWITTER']['MinFollowersRequired'];?>" />
					</div>
					
					<div class="clear"></div>
					<label> Min Tweets Required</label>
					<div class="input">
						<input type="text" name="global[TWITTER][MinTweetsRequired]" value="<?php echo $GLOBALS['global']['TWITTER']['MinTweetsRequired'];?>" />
					</div>
					
					<div class="clear"></div>
					<label> Min Old Days Required</label>
					<div class="input">
						<input type="text" name="global[TWITTER][MinDaysOldAccountRequired]" value="<?php echo $GLOBALS['global']['TWITTER']['MinDaysOldAccountRequired'];?>" />
					</div>
					
					<div class="clear"></div>
					<label> Status Message</label>
					<div class="input">
						<input type="text" name="global[TWITTER][FirstStatusMessage]" value="<?php echo $GLOBALS['global']['TWITTER']['FirstStatusMessage'];?>" />
					</div>
					
				</fieldset>	
			</div>
		      
            <div class="clear"></div>
            
            <div class="half-row">
				<fieldset>
					<legend>Google API</legend>
					
					<label> API Key</label>
					<div class="input">
                        <input type="text" name="global[GOOGLE_MAP][key]" value="<?php echo $GLOBALS['global']['GOOGLE_MAP']['key'];?>" />
                    </div>
					<div class="clear"></div>
                    
				</fieldset>	
			</div>  
            
		</div>
		
	</fieldset>

	<div class="clear"></div>
	
	<fieldset>
		<legend>Message</legend>
		
		<div class="row-item">
			<fieldset>
				<legend>Post on wall</legend>
				
				<label> Buy pet</label>
				<div class="input">
					<input type="text" name="global[PRE_DEF_MESSAGE][buy_pet]" maxlength="100" value="<?php echo htmlentities($GLOBALS['global']['PRE_DEF_MESSAGE']['buy_pet']);?>" style="width:600px;" />
					Max length: 100 letters
				</div>
				
				<div class="clear"></div>
				<label> Lock pet</label>
				<div class="input">
					<input type="text" name="global[PRE_DEF_MESSAGE][lock_pet]" maxlength="100" value="<?php echo htmlentities($GLOBALS['global']['PRE_DEF_MESSAGE']['lock_pet']);?>" style="width:600px;" />
					Max length: 100 letters
				</div>
				 
				<div class="clear"></div>
				<label> Buy backstage</label>
				<div class="input">
					<input type="text" name="global[PRE_DEF_MESSAGE][add_backstage]" maxlength="100" value="<?php echo htmlentities($GLOBALS['global']['PRE_DEF_MESSAGE']['add_backstage']);?>" style="width:600px;" />
					Max length: 100 letters
				</div>
				 
			</fieldset>	
		</div>
		
		<div class="row-item">
			<fieldset>
				<legend>Site title</legend>
				
				<label> Title</label>
				<div class="input">
					<input type="text" name="global[HOME_PAGE][site_title]" maxlength="100" value="<?php echo htmlentities($GLOBALS['global']['HOME_PAGE']['site_title']);?>" style="width:600px;" />
					Max length: 100 letters
				</div>
				
			</fieldset>	
		</div>
		
	</fieldset>
	
	<div class="clear"></div>
	
	 
	<fieldset>
		<legend>Pagination</legend>
		
		<div class="row-item">
			
			<div class="half-row">
				<fieldset>
					<legend>Site</legend>
					
					<label> Max items per page</label>
					<div class="input">
						<input type="text" name="global[PAGINATE][rec_per_page]" value="<?php echo $GLOBALS['global']['PAGINATE']['rec_per_page'];?>" />
					</div>
					
					<div class="clear"></div>
					<label> Max rows</label>
					<div class="input">
						<input type="text" name="global[PAGINATE][rows_per_page]" value="<?php echo $GLOBALS['global']['PAGINATE']['rows_per_page'];?>" />
					</div>
				</fieldset>	
			</div>
			
			<div class="half-row">
				<fieldset>
					<legend>Admin</legend>
					
					<label> Max items per page</label>
					<div class="input">
						<input type="text" name="global[PAGINATE_ADMIN][rec_per_page]" value="<?php echo $GLOBALS['global']['PAGINATE_ADMIN']['rec_per_page'];?>" />
					</div>
					
				</fieldset>	
			</div>
		</div>
		
	</fieldset>
	
	<div class="clear"></div>
	
	<input type="submit" value="Submit" />
	<input type="button" value="Cancel" onclick="gotoDefaultPage();" />
	<?php echo loader_image_s("id='save_loader'");?>
</section>

<?php echo form_close(); ?>




<script type="text/javascript">
	jQuery(document).ready(function(){
		var options = { 
			beforeSubmit:  validateB4Submit,  
			success:       processAfterResponding  
		};	
		jQuery('#submit_config').ajaxForm(options); 
		jQuery('#save_loader').hide();	
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
		queryurl(BASE_URI+'admin/juzon/config');
	}
</script>