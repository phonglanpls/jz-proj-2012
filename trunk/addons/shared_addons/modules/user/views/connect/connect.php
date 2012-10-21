<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>

<?php 

	 $checkError = forceUserConnect();
		
     $facebookdata = $this->db->where('userid',getAccountUserId())->get(TBL_FACEBOOK_CONNECT)->result();
	 $twitterdata = $this->db->where('userid',getAccountUserId())->get(TBL_TWITTER_CONNECT)->result();
		
     if(!$facebookdata AND !$twitterdata){
        //force connect page
        $force = true;
     }
     $this->load->model('mod_io/timeline_setting_io_m');
     $timeline_setting  = $this->timeline_setting_io_m->init(getAccountUserId());
?>
<div style="width:50%;float:left;text-align:center;">
	<?php if(! $this->facebookconnect_io_m->init('userid',getAccountUserId())):?>
		<a href="<?php echo $this->facebookmodel->getLoginLogoutUrl();?>"><img src="<?php echo site_url();?>media/images/facebook.png" alt="facebook" title="facebook"></a>		
	<?php else:?>
		<?php $fbDataArr = $this->facebookconnect_io_m->getUserInfo(getAccountUserId());?>
		<img src="https://graph.facebook.com/<?php echo $fbDataArr["username"];?>/picture"/>
		<br/>
		<?php echo language_translate('connect_label_facebook');?><?php echo $fbDataArr["first_name"].' '.$fbDataArr["middle_name"].' '.$fbDataArr["last_name"];?>
	
    	<br/>
		<a href="<?php echo site_url("mod_io/disconnect/facebook/?uri=".urlencode(site_url("user/connect")));?>"><?php echo language_translate('connect_label_disconnect');?></a>
   
	<?php endif;?>
</div>


<div style="width:50%;float:left;text-align:center;">
	<?php if(isTwitterLogin()):?>
		<?php $dataArr = $this->twittermodel->getCurrentUserDetails();?>
		<img src="<?php echo $dataArr["profile_image_url"];?>"/>
		<br/>
		<?php echo language_translate('connect_label_twitter');?><?php echo $dataArr["name"];?>
        
		  <br/>
		  <a href="<?php echo site_url("mod_io/disconnect/twitter/?uri=".urlencode(site_url("user/connect")));?>"><?php echo language_translate('connect_label_disconnect');?></a>
	  
    <?php else:?>
		<a href="<?php echo $this->twittermodel->getAuthorizeURL();?>"><img src="<?php echo site_url();?>media/images/twitter.png" alt="twitter" title="twitter"></a>
	<?php endif;?>
</div>

<?php if(isset($force) AND $force):?>
    <div class="clear"></div>
    <div style="width:100%;float:left;text-align:center;margin-top:25px;">
        Please connect to your facebook or twitter account first.
    </div>
<?php endif;?>

<?php if(isset($checkError) AND !empty($checkError)):?>
	<div class="clear"></div>
    <div style="width:100%;float:left;text-align:left;margin-top:25px;color:red;">
        <?php echo implode("<br/>",$checkError);?>
    </div>
<?php endif;?>


<?php if(isFacebookLogin() OR isTwitterLogin()):?>
    <div class="clear"></div>
    <div style="margin-top: 25px;clear:both;float:left;width:100%;">
    <?php 
    	echo form_open(
    						$action = site_url("mod_io/account_func/submit_change_timeline_option"), 
    						$attributes = "method='post' id='submit_change_timeline_option' name='submit_change_timeline_option' ", 
    						$hidden = array()
    				);
    ?>
        <table>
            <tr>
                <td width="33%"><b>Post to my Timeline</b></td>
                <?php if(isFacebookLogin()):?>
                    <td width="33%">
                        <img src="<?php echo base_url()?>image/fb.jpg" />
                    </td>
                <?php endif;?>
                 <?php if(isTwitterLogin()):?>
                    <td width="33%">
                        <img src="<?php echo base_url()?>image/tt.jpg" />
                    </td>
                <?php endif;?>
            </tr>
            
            <tr>
                <td>Post status update</td>
                 <?php if(isFacebookLogin()):?>
                    <td>
                        <input type="checkbox" name="fb_status_update" id="fb_status_update" value="1" <?php echo ($timeline_setting->fb_status_update==1)?'checked="checked"':'';?> /> 
                    </td>
                <?php endif;?>
                 <?php if(isTwitterLogin()):?>
                    <td>
                        <input type="checkbox" name="tt_status_update" id="tt_status_update" value="1" <?php echo ($timeline_setting->tt_status_update==1)?'checked="checked"':'';?> /> 
                    </td>
                <?php endif;?>
            </tr>
            
            <tr>
                <td>Post askme answer</td>
                 <?php if(isFacebookLogin()):?>
                    <td>
                        <input type="checkbox" name="fb_askme_answer" id="fb_askme_answer" value="1" <?php echo ($timeline_setting->fb_askme_answer==1)?'checked="checked"':'';?> /> 
                    </td>
                <?php endif;?>
                 <?php if(isTwitterLogin()):?>
                    <td>
                        <input type="checkbox" name="tt_askme_answer" id="tt_askme_answer" value="1" <?php echo ($timeline_setting->tt_askme_answer==1)?'checked="checked"':'';?> /> 
                    </td>
                <?php endif;?>
            </tr>
            
            <tr>
                <td>Post add backstage photo</td>
                 <?php if(isFacebookLogin()):?>
                    <td>
                        <input type="checkbox" name="fb_backstage_photo" id="fb_backstage_photo" value="1" <?php echo ($timeline_setting->fb_backstage_photo==1)?'checked="checked"':'';?> /> 
                    </td>
                <?php endif;?>
                 <?php if(isTwitterLogin()):?>
                    <td>
                        <input type="checkbox" name="tt_backstage_photo" id="tt_backstage_photo" value="1" <?php echo ($timeline_setting->tt_backstage_photo==1)?'checked="checked"':'';?> /> 
                    </td>
                <?php endif;?>
            </tr>
            
            <tr>
                <td>Post buy a pet</td>
                 <?php if(isFacebookLogin()):?>
                    <td>
                        <input type="checkbox" name="fb_buy_pet" id="fb_buy_pet" value="1" <?php echo ($timeline_setting->fb_buy_pet==1)?'checked="checked"':'';?> /> 
                    </td>
                <?php endif;?>
                 <?php if(isTwitterLogin()):?>
                    <td>
                        <input type="checkbox" name="tt_buy_pet" id="tt_buy_pet" value="1" <?php echo ($timeline_setting->tt_buy_pet==1)?'checked="checked"':'';?> /> 
                    </td>
                <?php endif;?>
            </tr>
            
            <tr>
                <td>Post lock a pet</td>
                 <?php if(isFacebookLogin()):?>
                    <td>
                        <input type="checkbox" name="fb_lock_pet" id="fb_lock_pet" value="1" <?php echo ($timeline_setting->fb_lock_pet==1)?'checked="checked"':'';?> /> 
                    </td>
                <?php endif;?>
                 <?php if(isTwitterLogin()):?>
                    <td>
                        <input type="checkbox" name="tt_lock_pet" id="tt_lock_pet" value="1" <?php echo ($timeline_setting->tt_lock_pet==1)?'checked="checked"':'';?> /> 
                    </td>
                <?php endif;?>
            </tr>
            
            <tr>
                <td>Post rate video</td>
                 <?php if(isFacebookLogin()):?>
                    <td>
                        <input type="checkbox" name="fb_rate_video" id="fb_rate_video" value="1" <?php echo ($timeline_setting->fb_rate_video==1)?'checked="checked"':'';?> /> 
                    </td>
                <?php endif;?>
                 <?php if(isTwitterLogin()):?>
                    <td>
                        <input type="checkbox" name="tt_rate_video" id="tt_rate_video" value="1" <?php echo ($timeline_setting->tt_rate_video==1)?'checked="checked"':'';?> /> 
                    </td>
                <?php endif;?>
            </tr>
            
        </table>
         
         <div class="clear"></div>
         
        <div class="inputcls" style="text-align: right;margin-top: 10px;">
            <?php echo loader_image_s("id='loaderChangeTimelineContextLoader' class='hidden'");?>
    		<input type="submit" value="Save" name="submit" class="share-2" />
            <input type="button" value="Cancel" name="cancel" class="share-2" onclick="queryurl(BASE_URI+'user/connect');" />
    	</div>
        
         <div class="clear"></div>
     <?php echo form_close();?>	   
        <div class="clear"></div>
        
    </div>
    
    
<script type="text/javascript">
	
	$(document).ready(function(){
		var options = { 
			dataType:  'json', 	
			beforeSubmit:  validateB4Submit,  
			success:       processAfterResponding  
		};	
		$('#submit_change_timeline_option').ajaxForm(options); 
	
	});
	
	function validateB4Submit(formData, jqForm, options){
		$('#loaderChangeTimelineContextLoader').toggle();
		return true;
	}

	function processAfterResponding(responseText, statusText, xhr, $form) {
		$('#loaderChangeTimelineContextLoader').toggle();	
		if(responseText.result == 'ok'){
			sysMessage(responseText.message);
		}else{
			sysWarning(responseText.message);
		}
	}
</script>
<?php endif;?>