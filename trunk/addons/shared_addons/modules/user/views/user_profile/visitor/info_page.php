<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>



<?php 
	$userfavoritedata = $this->mod_io_m->init('id_user',$userdataobj->id_user,TBL_FAVORITE);
?>

<div id="body-content">
   <?php $this->load->view("user_profile/visitor/left_login", array('userdataobj'=>$userdataobj));?>
 
	<div id="body">
		<div class="body">
			<div id="content">
				
				<div class="clear"></div>
				
				<div class="filter-split">
					<?php $this->load->view("user_profile/visitor/user_info", array('userdataobj'=>$userdataobj)); ?>
				</div>
				 
				<div class="clear"></div>
				 
				<div class="filter-split">
						
								<?php 
									echo '<b>Username:</b> '.$userdataobj->username.'';
								?>
								
								<div class="clear"></div> <br/>
								
								<b>Location: </b> 
								<?php 
									echo $userdataobj->country;
								?>
								
								<div class="clear"></div> <br/>
								
								<?php 
									echo '<b>Age:</b> '.cal_age( $userdataobj->dob );
								?>
								
								<div class="clear"></div> <br/>
								
								<?php 
									echo '<b>Sex:</b> '. $userdataobj->gender ;
								?>
								
								<div class="clear"></div> <br/>
								
								<?php 
									if($userfavoritedata AND $userfavoritedata->interested_in){
										echo '<b>Interested in: </b>'.$userfavoritedata->interested_in;
										echo '<div class="clear"></div> <br/>';
									}
								?>
								
								
								<?php 
									if($userdataobj->rel_status ){
										echo '<b>Relationship status: </b>'.$GLOBALS['global']['REL_STATUS'][$userdataobj->rel_status];
										echo '<div class="clear"></div> <br/>';
									}
								?>
								 
								<?php 
									if($userfavoritedata AND $userfavoritedata->language){
										echo '<b>Languages: </b>'.$userfavoritedata->language;
										echo '<div class="clear"></div> <br/>';
									}
								?>
								 
								<?php 
									if($userdataobj->timezone){
										$tzarr = timezoneDataOption_ioc();
										echo '<b>Timezone: </b>'.$tzarr[$userdataobj->timezone];
										echo '<div class="clear"></div> <br/>';
									}
								?>
								 
								<?php 
									if($userdataobj->about_me){
										echo '<b>About me: </b>'.$userdataobj->about_me;
									}
								?>
								<div class="clear"></div> <br/>
					
								<?php 
									if($userfavoritedata AND $userfavoritedata->music){
										echo '<b>Music: </b>'.$userfavoritedata->music;
										echo '<div class="clear"></div> <br/>';
									}
								?>
								  
								<?php 
									if($userfavoritedata AND $userfavoritedata->book){
										echo '<b>Book: </b>'.$userfavoritedata->book;
										echo '<div class="clear"></div> <br/>';
									}
								?>
								 
								<?php 
									if($userfavoritedata AND $userfavoritedata->tvshow){
										echo '<b>TV Show: </b>'.$userfavoritedata->tvshow;
										echo '<div class="clear"></div> <br/>';
									}
								?>
								 
								<?php 
									if($userfavoritedata AND $userfavoritedata->videogame){
										echo '<b>Games: </b>'.$userfavoritedata->videogame;
										echo '<div class="clear"></div> <br/>';
									}
								?>
								
								<?php 
									if($userfavoritedata AND $userfavoritedata->activity){
										echo '<b>Activities: </b>'.$userfavoritedata->activity;
										echo '<div class="clear"></div> <br/>';
									}
								?>
								
								<?php 
									if($userfavoritedata AND $userfavoritedata->interests){
										echo '<b>Interests: </b>'.$userfavoritedata->interests;
										echo '<div class="clear"></div> <br/>';
									}
								?>
					
				</div>
				 
				<div class="clear"></div>
				
			</div>
		</div>
	   
	</div>
	<div class="clear"></div>
	
</div>

<script type="text/javascript">
	
	$(document).ready(function(){
		
	});
</script>
