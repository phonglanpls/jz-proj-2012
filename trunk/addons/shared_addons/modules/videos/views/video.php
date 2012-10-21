<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>


<script src="http://connect.facebook.net/en_US/all.js#xfbml=1"></script>

<script type="text/javascript" src="<?php echo site_url();?>/media/js/flowplayer-3.2.6.min.js"></script> 
<script type="text/javascript" src="<?php echo site_url();?>/media/js/flowplayer.ipad-3.2.2.min.js"></script> 


<?php 
	$this->load->model('mod_io/xls_io_m');
	
	$id_video = $this->uri->segment(4,0);
	$videodata = $this->mod_io_m->init('id_video',$id_video,TBL_VIDEO);
	$video_url = $this->hentai_m->getFacebookVideoSource($id_video);
	
	$seriesdata = $this->mod_io_m->init('id_series',$videodata->id_series,TBL_SERIES);
	$slug = slugify( $videodata->name );	
	$full_url = fullURL();
	
	if(! isLogin()){
		$is_connect = 0;
	}
	
	$_SESSION['reffer_video_url'] = fullURL();
?>

<script type="text/javascript">
	var CONNECTED = <?php echo $is_connect;?>;
	var url = '<?php echo site_url();?>';
	
</script>


<div id="fb-root"></div>

<div id="body-content">
   
	<div id="body">
		<div class="body">
			<div id="content">
				
				<div class="clear"></div>
				 
				<div class="filter-split" style="border:1px solid #cfcfcf;">
				
				
				
				
											<?php 
												$seriesArray = $this->hentai_m->getAllSeriesVideo($videodata->id_series);
											?>
											
											<?php foreach($seriesArray as $item):?>
												<?php $slug = slugify( $item->name );	 ?>
												<div class="video-hentai-item">
													<a href="<?php echo site_url("videos/category/video/{$item->id_video}/{$slug}");?>" ><?php echo $item->name;?></a> 
												</div>
											<?php endforeach;?>
											<div class="clear"></div>
											
											
											
											
				
				</div>
				 
				<div class="filter-split">
						


						
									<div class="cls-photo-gallery">
										<div id="login-require" style="margin-bottom:15px;">
											Please <a href="<?php echo site_url('member');?>">login</a> first to watch this video.
										</div>
										
										<div id="video-alert" onclick="callFuncpromptFacebookTwitterConnect();"></div>
									
										
									</div> 

									<div class="clear"></div>

									<div class="cls-photo-gallery">
										<div style="float:left">
											<div style="float:left;">
											
											<fb:like href="<?php echo $full_url;?>" show_faces="false" layout="button_count" width="150" send="true"></fb:like>
											</div>
											
											<div style="float:left; width:115px;">
												<iframe allowtransparency="true" frameborder="0" scrolling="no"
													src="https://platform.twitter.com/widgets/tweet_button.html"
													style="width:130px; height:20px;"></iframe>
											</div>

											<div style="float:left;" id="qqdiv">
												<script type="text/javascript" src="<?php echo site_url();?>/media/js/qq_share.js"></script> 
											</div>
											
											<div style="float:left" id="weibodiv">
												<script type="text/javascript" src="<?php echo site_url();?>/media/js/weibo_share.js"></script> 
											</div>
											
											<div style="clear:both"></div>
										</div>
									</div>
					
					
					
				</div>
				
				<div style="clear:both"></div>
				
				
				
			</div>
		</div>
	  
	</div>
	<div class="clear"></div>
	
</div>
<div class="clear"></div>

<div id="divUIDialog" style="display:none;">
	<p style="text-align:center;width:100%;float:left;margin-bottom:15px;">You must connect to your Facebook or Twitter account first.</p>
	
	<div class="clear"></div>
	
	<div style="width:45%;float:left;text-align:center;">
		<a href="<?php echo $this->facebookmodel->getLoginLogoutUrl();?>"><img src="<?php echo site_url();?>media/images/facebook.png" alt="facebook" title="facebook"></a>		
	</div>

	<div style="width:45%;float:left;text-align:center;">
		<a href="<?php echo $this->twittermodel->getAuthorizeURL();?>"><img src="<?php echo site_url();?>media/images/twitter.png" alt="twitter" title="twitter"></a>
	</div>
</div>