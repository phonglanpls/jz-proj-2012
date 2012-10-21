<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<style>
	#askME{
		margin:5px 0px 0px 20px;
	}
</style>

<script type="text/javascript" src="http://localhost/juzon/media/js/friends.js"></script> 

<script type="text/javascript" src="<?php echo site_url();?>/media/js/wall.js"></script> 
<script type="text/javascript" src="<?php echo site_url();?>/media/js/pet.js"></script> 
<script type="text/javascript" src="<?php echo site_url();?>/media/js/qa.js"></script> 
 

<div id="fb-root"></div>

<div class="box-profile" style="position:relative;height:135px;">
	<div class="left">
		<img src="<?php echo $this->user_m->getProfileAvatar($userdataobj->id_user);?>" /> <br/>
		<?php echo $this->user_m->buildNativeLink($userdataobj->username);?>  	
		
	</div>
	<div class="right">
		<b>Age/Sex:</b> <?php echo cal_age($userdataobj->dob);?>/ <?php echo $userdataobj->gender;?>
		
		<div class="clear"></div>
		
	</div>
	
	<div class="right" style="margin-left:10px;">
		<div style="width: 270px;">
			<div style="float:left;">
				<!--<fb:like href="<?php //echo site_url();?>" layout="button_count"
				show_faces="false" width="20" action="like" font="arial" colorscheme="light"></fb:like>
				-->
				<fb:like href="<?php echo fullURL();?>" show_faces="false" layout="button_count" width="60" height="30" send="true"></fb:like>
			</div>
			<br/>
			<div style="clear:both;margin:3px 0px;"></div>
			
			<div style="float:left;margin-top:10px;">
				<a href="<?php echo site_url();?>" class="twitter-share-button" data-lang="en">Tweet</a>
				<script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0];if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src="//platform.twitter.com/widgets.js";fjs.parentNode.insertBefore(js,fjs);}}(document,"script","twitter-wjs");</script>
			</div>

			<div style="clear:both;margin:3px 0px;"></div>
			<br/>
		</div>
			
		<div class="clear"></div>
		
		<div style="width: 270px;">
			<div style="float:left;width:100%;" id="qqdiv">
				<script type="text/javascript" src="<?php echo site_url();?>/media/js/qq_share.js"></script> 
			</div>
			
			<div class="clear"></div>
			
			<div style="float:left;width:100%;" id="weibodiv">
				<script type="text/javascript" src="<?php echo site_url();?>/media/js/weibo_share.js"></script> 
			</div>
		</div>
	</div>
	
	<div class="right" style="margin-left:10px;">
		<?php 
			$owner_id = $this->user_m->getMyOwnerId($userdataobj->id_user);
		?>
		
		<img src="<?php echo $this->user_m->getProfileAvatar($owner_id);?>" />
		<br/>
		<strong>Owner:</strong> <?php echo $this->user_m->getProfileDisplayName($owner_id);?> 
		<br/>
		<strong>Cash:</strong> <?php echo $this->user_m->getCash($owner_id);?> 
		<br/>
		<strong>Value:</strong> <?php echo $this->user_m->getValue($owner_id);?> 
		<div class="clear"></div> 
	</div>
	
	<div class="clear"></div>
	
	<div id="show_url_vanity">
		<b>URL:</b> <?php echo site_url("{$userdataobj->username}");?>
	</div>
	
</div>


<script type="text/javascript">
	var myurl = "<?php echo fullURL();?>";
	/**
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
	**/
</script>