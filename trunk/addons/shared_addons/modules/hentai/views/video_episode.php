<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>


<script type="text/javascript" src="<?php echo site_url();?>/media/js/flowplayer-3.2.6.min.js"></script> 
<script type="text/javascript" src="<?php echo site_url();?>/media/js/flowplayer.ipad-3.2.2.min.js"></script> 

<?php 
	$id_video = $this->input->get('id_video');
	$videodata = $this->mod_io_m->init('id_video',$id_video,TBL_VIDEO);
	$video_url = $this->hentai_m->getFacebookVideoSource($id_video);
	
	$seriesdata = $this->mod_io_m->init('id_series',$videodata->id_series,TBL_SERIES);
	$slug = slugify( $seriesdata->name );	
	$full_url = site_url("user/hentai/series/{$videodata->id_series}/$slug");
?>


<div class="cls-photo-gallery">
	<div id="hentai_vid_div" align="center">
		<!--<a href="" style="display:block;width:520px;height:330px" id="video_player"></a>-->
        <a style="display:block; width:640px; height:360px;" id="ipad"></a>
		
		<?php if(!$video_url){
			echo "This video does not exist.";exit;
		}?>
	</div>
</div> 

<div class="clear"></div>

<div class="cls-photo-gallery">
	<div style="float:left">
		<div style="float:left;">
			<iframe allowtransparency="true" frameborder="0" scrolling="no" src="http://www.facebook.com/plugins/like.php?href=<?php echo urlencode($full_url)?>&amp;layout=button_count&amp;show_faces=true&amp;width=90&amp;action=like&amp;colorscheme=light&amp;height=20" style="border:none; overflow:hidden; width:90px; height:20px;"></iframe>
		</div>
		
		<div style="float:left; width:115px;">
			<!-- <a href="<?php echo $full_url;?>" class="twitter-share-button" data-lang="en">Tweet</a>
			<script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0];if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src="//platform.twitter.com/widgets.js";fjs.parentNode.insertBefore(js,fjs);}}(document,"script","twitter-wjs");</script>
			-->
			<iframe allowtransparency="true" frameborder="0" scrolling="no"
				src="https://platform.twitter.com/widgets/tweet_button.html"
				style="width:130px; height:20px;"></iframe>
		</div>

		<div style="float:left;width:60px;" id="qqdiv"></div>
		<div style="float:left" id="weibodiv"></div>
		
		<div style="clear:both"></div>
	</div>
</div>







<script type="text/javascript">	
	var url = '<?php echo site_url();?>';
	var videourl = '<?php echo $video_url;?>';
	
	$(document).ready(function(){
		document.title = '<?php echo $videodata->name;?>';
		
		 flowplayer("ipad", url+"media/js/flowplayer-3.2.7.swf",{
			clip: {
					url: encodeURIComponent(videourl),
					autoPlay: false,
					ipadUrl: encodeURIComponent(videourl),
					onStart: function(clip){
							//check if logged in 
							/*	var userid=getCurrentUserID();
								if(!userid)
								{
									promptFacebookTwitterConnect();
									this.close();
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
	
	var myurl = "<?php echo site_url();?>";
    function sharewithqq(){
		var myurl = myurl;
		window.open('http://sns.qzone.qq.com/cgi-bin/qzshare/cgi_qzshare_onekey?url='+myurl);return false;
	}
	
    (function(){
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
	})();
    
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
</script>
