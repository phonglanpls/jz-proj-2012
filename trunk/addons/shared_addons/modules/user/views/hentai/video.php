<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>

<script type="text/javascript" src="<?php echo site_url();?>/media/js/hentai.js"></script> 
<script type="text/javascript" src="<?php echo site_url();?>/media/js/flowplayer-3.2.6.min.js"></script> 
<script type="text/javascript" src="<?php echo site_url();?>/media/js/flowplayer.ipad-3.2.2.min.js"></script> 


<?php 
	$this->load->model('mod_io/xls_io_m');
	
	$id_video = $this->uri->segment(4,0);
    $videodata = $this->mod_io_m->init('id_video',$id_video,TBL_VIDEO);
    //$code_video = strtolower( str_replace(array('-','_'),array('',''),$this->uri->segment(5)) ); 
	//$videodata = ( $this->mod_io_m->init('id_video',$id_video,TBL_VIDEO) ) ? $this->mod_io_m->init('id_video',$id_video,TBL_VIDEO) : $this->mod_io_m->init('code_video',$code_video,TBL_VIDEO) ;
	
	
	$seriesdata = $this->mod_io_m->init('id_series',$videodata->id_series,TBL_SERIES);
	$slug = slugify( $videodata->name );	
	$full_url = fullURL();
	
	unset($_SESSION['reffer_video_url']); 
?>

<script type="text/javascript">
	 
</script>


<div id="fb-root"></div>

<div id="body-content">
   <?php $this->load->view("user/partial/left");?>
 
	<div id="body">
		<div class="body">
			<div id="content">
				<?php $this->load->view("user/partial/top"); ?>
				<div class="clear"></div>
				 
				<div class="filter-split" style="border:1px solid #cfcfcf;">
				
				
				
				
											<?php 
												$seriesArray = $this->hentai_m->getAllSeriesVideo($videodata->id_series);
											?>
											
											<?php foreach($seriesArray as $item):?>
												<?php $slug = slugify( $item->name );	 ?>
												<div class="video-hentai-item">
													<a href="<?php echo site_url("user/videos/video/{$item->id_video}/{$slug}");?>" ><?php echo $item->name;?></a> 
												</div>
											<?php endforeach;?>
											<div class="clear"></div>
											
											
											
											
				
				</div>
				 
				<div class="filter-split">
						


						
									<div class="cls-photo-gallery">
										<?php if($seriesdata->id_hentai_category == 1): //is facebook video ?>
									        <?php $video_url = $this->hentai_m->getFacebookVideoSource($videodata->id_video);?>
											<div id="hentai_vid_div" align="center">
												<!--<a href="" style="display:block;width:520px;height:330px" id="video_player"></a>-->
												<a style="display:block; width:640px; height:360px;" id="ipad"></a>
												
												<?php if(!$video_url){
													echo "This video does not exist.";
												}?>
											</div>
											
											<script type="text/javascript">
												$(document).ready(function(){
													document.title = '<?php echo $videodata->name;?>';
													
													 flowplayer("ipad", url+"media/js/flowplayer-3.2.7.swf",{
														clip: {
																url: encodeURIComponent(videourl),
																autoPlay: false,
																ipadUrl: encodeURIComponent(videourl),
																onStart: function(clip){
																		//check if logged in 
																		/* if(! CONNECTED)
																		{
																			callFuncpromptFacebookTwitterConnect();
																		}
																		*/
																}	
															},
														play: {
															label: "Click Here to Play",
															replayLabel: "Click to Play Again"
														}
													}).ipad({ simulateiDevice: false });
												});
											</script>	
											
										<?php endif; ?>
										
										<?php if($seriesdata->id_hentai_category == 4): //is dailymotion video ?>
									
											<div id="dailymotionvid" align="center"></div>
											
											<script type="text/javascript">
												(function() {
													var e = document.createElement('script'); e.async = true;
													e.src = document.location.protocol + '//api.dmcdn.net/all.js';
													var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(e, s);
												}());

												window.dmAsyncInit = function()
												{
													var PARAMS = {};
													PARAMS.info = 0;
													PARAMS.logo = 0;
													var player = DM.player("dailymotionvid", {video: "<?php echo $this->xls_io_m->getvidCode( $videodata->video_url );?>", width: "640", height: "360", params: PARAMS});

													player.addEventListener("apiready", function(e)
													{
														
														e.target.play();
														
													});
												};
											</script>
										<?php endif; ?>
										
									</div> 

									<div class="clear"></div>

									<div class="cls-photo-gallery">
										<div style="float:left">
											<div style="float:left;">
											<!--
												<iframe allowtransparency="true" frameborder="0" scrolling="no" src="http://www.facebook.com/plugins/like.php?href=<?php echo urlencode($full_url)?>&amp;layout=button_count&amp;show_faces=true&amp;width=90&amp;action=like&amp;colorscheme=light&amp;height=20" style="border:none; overflow:hidden; width:90px; height:20px;"></iframe>
											-->
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
				
				<?php if($seriesdata->id_hentai_category == 1): //is facebook video ?>
                    <?php $video_url = $this->hentai_m->getFacebookVideoSource($videodata->id_video);?>
							<div class="filter-split">
								<?php if($video_url):?>
									<div style="float:right;">
										<div class="user-profile-button">
											<a href="javascript:void(0);" onclick="callFuncDownloadVideo(<?php echo $id_video;?>);">
												Download Video For <?php echo currencyDisplay($GLOBALS['global']['ADMIN_DEFAULT']['download']);?>J$
											</a>
										</div>
									</div>
								<?php endif;?>
							</div>
				<?php endif;?>
				
				<div style="clear:both"></div>
				
				
				
				<div class="filter-split" id="rateHentaiAsyncDiv">
						

						<?php $this->load->view("hentai/show_rating_video", array('id_video'=>$id_video)); ?>

				
				</div>
				
				
				
				<div class="filter-split" id="watchingUserAsyncDiv" style="margin-top:20px;">
				
					
					
								
								<?php $this->load->view("hentai/show_user_watching_video", array('video_id'=>$id_video)); ?>
					
				
				
				</div>
				
			</div>
		</div>
	   <?php $this->load->view("user/partial/right");?>
	</div>
	<div class="clear"></div>
	
</div>

<script type="text/javascript">
	var url = '<?php echo site_url();?>';
	var videourl = '<?php echo $video_url;?>';
	var WATCHING_MODE = 'default';
	
	$(document).ready(function(){
		window.setInterval(function(){callFuncShowWatchingVideoUser(<?php echo $id_video;?>,WATCHING_MODE);} , 15000);
		
	});
	
	var myurl = "<?php echo site_url();?>";
	/**
    function sharewithqq(){
		var myurl = myurl;
		window.open('http://sns.qzone.qq.com/cgi-bin/qzshare/cgi_qzshare_onekey?url='+myurl);return false;
	}
	
    $(function(){
		  var _w = 90 , _h = 24;
		  var param = {
			url:myurl,
			type:'3',
			count:'1',
			appkey:'',
			title:"<?php echo language_translate('weibo_network_title');?>",
			pic:myurl+'templates/css_theme/img/favicon.ico',
			ralateUid:'',
			rnd:new Date().valueOf()
		  }
		  var temp = [];
		  for( var p in param ){
			temp.push(p + '=' + encodeURIComponent( param[p] || '' ) )
		  }
		  document.getElementById('weibodiv').innerHTML='<iframe allowTransparency="true" frameborder="0" scrolling="no" src="http://hits.sinajs.cn/A1/weiboshare.html?' + temp.join('&') + '" width="'+ _w+'" height="'+_h+'"></iframe>';
	});
    
    $(function(){
		var p = {
			url:myurl,
			desc:"<?php echo language_translate('weibo_network_desc');?>",
			summary:"<?php echo language_translate('weibo_network_summany');?>",
			title:"<?php echo language_translate('weibo_network_title2');?>",
			site:'',
			pics:myurl+'templates/css_theme/img/favicon.ico'
		};
		var s = [];
		for(var i in p){
			s.push(i + '=' + encodeURIComponent(p[i]||''));
		}
		$('#qqdiv').html(['<a href="http://sns.qzone.qq.com/cgi-bin/qzshare/cgi_qzshare_onekey?',s.join('&'),'"target="_blank" title="<?php echo language_translate('qq_network_title');?>"><img src="http://qzonestyle.gtimg.cn/ac/qzone_v5/app/app_share/qz_logo.png" alt="<?php echo language_translate('qq_network_alt');?>" ></a>'].join(''));
	});
	**/
</script>