<?php defined('BASEPATH') OR exit('No direct script access allowed');
/**
 *
 */
class Plugin_Sys extends Plugin
{

	function search(){
		if(isLogin()){
			$search_title = language_translate('sys_search_title');
			$action = site_url("user/search");
			
			$keyword=($this->input->get('keyword'));
			$value = (strlen($keyword))?$keyword:$search_title;
			
			$html = "<div class=\"box-search\">
					<form method='get' action='$action'>
						<input type=\"text\" value=\"{$value}\" name=\"keyword\" id=\"search_keyword\" class=\"text\">
						<input type=\"submit\" value=\"\" class=\"submit\">
					</form>
				</div>";
			$html .= "<script type='text/javascript'>
						$(document).ready(function(){
							$('#search_keyword').focusin(function(){
								var name = '$search_title';
								if($(this).attr('value') == name){
									$(this).attr('value','');
								}
							});
						});
					</script>";
				
			return $html;
		}else{
			return '';
		}
	}

	function cometchat(){
		if(isLogin()){
			$site = site_url();
			return "
			<link type=\"text/css\" href=\"$site/cometchat/cometchatcss.php\" rel=\"stylesheet\" charset=\"utf-8\">
			<script type=\"text/javascript\" src=\"$site/cometchat/cometchatjs.php\" charset=\"utf-8\"></script>";
		}
		return '';
	}

    function getGoogleAPIKey(){
        return $GLOBALS['global']['GOOGLE_MAP']['key'];
    }
















//end class
}