<?php  if (!defined('BASEPATH')) exit('No direct script access allowed');

define('EARTH_RADIUS',6378.13); // in Miles. Change this to Kms if needed.
define('DEGREES_TO_RADIANS', pi()/180.0);
define('RADIANS_TO_DEGREES', 180.0/pi());

define('SENDMAIL', 1);

define('JC', 'J$');

define('TIMELINE_BACKSTAGE_PHOTO',1);
define('TIMELINE_AKSME_ANSWER',2);
define('TIMELINE_STATUS_UPDATE',3);
define('TIMELINE_BUY_PET',4);
define('TIMELINE_LOCKPET',5);
define('TIMELINE_RATE_VIDEO',6);

function allowExtensionVideoUpload(){
	return array('flv','mp4','ogg','webm','swf');
	/*
		Technically a browser could support flv via the HTML5 <video> element, but that's never going to happen. Browser support is thus:
		Firefox 3.6 - Ogg Theora
		Firefox 4.0 - Ogg Theora + WebM
		Chrome 5.0 - H.264 + Ogg Theora (WebM coming soon)
		Safari 4/5 - H.264
		Opera 10.5 - Ogg Theora (I believe WebM coming soon)
		IE9 - H.264 (supports WebM if installed by the user)
	*/
}

function allowExtensionPictureUpload(){
	return array('png','jpg','jpeg');
}

function allowMaxFileSize(){
	//mb
	return 10;
}

function debug($str, $file=''){
	if(!is_dir("./logs/")){
		mkdir("./logs/",777);
	}
    if(!$file){
        $file = "log_".date("Y_m_d",time()).".txt";
    }
	
	$ci = &get_instance();
	$ci->load->helper('file');
	
	$text = PHP_EOL . "______________".date("Y-m-d H:i:s",time())."________________". PHP_EOL;
	$text .= $str;
	$text .= PHP_EOL . "__________________________________________________". PHP_EOL;
	write_file("./logs/$file",$text,'a+');
}