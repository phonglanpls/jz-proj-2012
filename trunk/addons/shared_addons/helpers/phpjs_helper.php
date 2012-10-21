<?php  if (!defined('BASEPATH')) exit('No direct script access allowed');

	function fullURL(){
		$ci=& get_instance();
		$query = $_SERVER['QUERY_STRING'] ? '?'.$_SERVER['QUERY_STRING'] : '';
		return $ci->config->site_url().$ci->uri->uri_string(). $query;  
	}
	
	function baseURL(){
		$ci=& get_instance();
		return $ci->config->site_url().$ci->uri->uri_string();
	}
	
	function php2js(){
		$json = !empty($_GET) ? json_encode($_GET) : '{}';
		return "
			<script type='text/javascript'>
				var __GET = $json;
				var __URL = '".fullURL()."';
				var __BASE_URL = '".baseURL()."';
				
				function _toURLstring(){
					return jQuery.param(__GET);
				}
				
				function _buildNewString(){
					return __BASE_URL+'/?'+_toURLstring();
				}
				
				function _makeQueryURL(){
					window.location = _buildNewString();
				}
			</script>
		";
	}
	
	function php2jsCallParentURL($url){
		echo "
			<script type='text/javascript'>
				window.parent.queryurl('$url');
			</script>
		";
	}
	
	function reloadJS(){
		echo "<script type='text/javascript'>
				document.location=document.location.href;
			</script>";
	}
	
	function reloadJS_url($url){
		echo "<script type='text/javascript'>
				document.location='$url';
			</script>";
	}
	
	function getDefaultLanguage() {
	   if (isset($_SERVER["HTTP_ACCEPT_LANGUAGE"]))
		  return parseDefaultLanguage($_SERVER["HTTP_ACCEPT_LANGUAGE"]);
	   else
		  return parseDefaultLanguage(NULL);
   }

	function parseDefaultLanguage($http_accept, $deflang = "en") {
	   if(isset($http_accept) && strlen($http_accept) > 1)  {
		  # Split possible languages into array
		  $x = explode(",",$http_accept);
		  foreach ($x as $val) {
			 #check for q-value and create associative array. No q-value means 1 by rule
			 if(preg_match("/(.*);q=([0-1]{0,1}\.\d{0,4})/i",$val,$matches))
				$lang[$matches[1]] = (float)$matches[2];
			 else
				$lang[$val] = 1.0;
		  }

		  #return default language (highest q-value)
		  $qval = 0.0;
		  foreach ($lang as $key => $value) {
			 if ($value > $qval) {
				$qval = (float)$value;
				$deflang = $key;
			 }
		  }
	   }
	   $lang = strtolower($deflang);
	   $lang = substr( $lang, 0, 2 );
	   return $lang;
	}
	
/***	
	if(!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
		 
	}else{
		php2js();
	}
***/	
?>
