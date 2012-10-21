<?php  if (!defined('BASEPATH')) exit('No direct script access allowed');
define('WALL_PHOTO_W', 500);
define('WALL_PHOTO_H', 300);

define('WC_W', 650);
define('WC_H', 350);

function explode_name($source_image)
{
	$ext = strrchr($source_image, '.');
	$name = ($ext === FALSE) ? $source_image : substr($source_image, 0, -strlen($ext));

	return array('ext' => $ext, 'name' => $name);
}

function thumb($src, $w, $h, $is_use = true){
	if(!$w){
		$cond = "h=$h&zc=1";
	}elseif(!$h){
		$cond = "w=$w&zc=1";
	}else{
		$cond = "w=$w&h=$h&zc=1";
	}
	if(!$is_use){
		return "<img src='$src'/>";
	}
	return "<img src='".site_url()."timthumb.php?$cond&src=$src"."' />";
}

function thumb2($src, $w, $h, $is_use = true){
	if(!$w){
		$cond = "h=$h&zc=1";
	}elseif(!$h){
		$cond = "w=$w&zc=1";
	}else{
		$cond = "w=$w&h=$h&zc=1";
	}
	if(!$is_use){
		return $src;
	}
	return site_url()."timthumb.php?$cond&src=$src" ;
}

function loader_image($ext=""){
	return "<img $ext src='".site_url()."media/images/ajax-loader.gif"."' />";
}

function loader_image_s($ext=""){
	return "<img $ext src='".site_url()."media/images/ajax-loader-s.gif"."' />";
}

function admin_loader_image_s($ext=""){
	return "<img $ext src='".site_url()."media/images/ajax-loader-s.gif"."' style='display:none;' />";
}

function loader_image_delete($ext=""){
	return "<img $ext src='".site_url()."media/images/remove.png"."' title='Delete?'/>";
}

function lock_image($thumb=true,$ext=''){
	if($thumb){
		return "<img $ext src='".site_url()."media/images/lock-s.png"."' title='' alt=''/>";
	}else{
		return "<img $ext src='".site_url()."media/images/lock.png"."' title='' alt=''/>";
	}
}

function admin_load_edit($ext=''){
	return "<img $ext src='".site_url()."media/images/edit.jpg"."' title='Edit?' style='cursor:pointer;'/>";
}

function admin_load_delete($ext=''){
	return "<img $ext src='".site_url()."media/images/delete.jpg"."' title='Delete?' style='cursor:pointer;' />";
}

function makeThumb($imageName, $path, $width, $height){
	$config['source_image'] = $path.$imageName;
	$config['create_thumb'] = TRUE;
	$config['maintain_ratio'] = TRUE;
	$config['thumb_marker'] = "";
	
	$size	 = getimagesize($config['source_image']);
	$config['width'] = ($width >= $size[0]) ? $size[0]:$width;
	$config['height'] = ($height >= $size[1]) ?$size[1]:$height;
	
	$ci = &get_instance();
	$ci->image_lib->initialize($config);
	$ci->image_lib->resize();
	$ci->image_lib->clear();
}
 
