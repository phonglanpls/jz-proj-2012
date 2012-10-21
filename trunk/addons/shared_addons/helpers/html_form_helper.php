<?php  if (!defined('BASEPATH')) exit('No direct script access allowed');
 
function maintainHtmlBreakLine($str){
	$str =  stripslashes( htmlentities( url_to_link( breakLine($str) ) ) );
	$strReturn = str_replace(array("[OPEN_TAG]","[CLOSE_TAG]"), array('<','>'), $str);
	return $strReturn;
}

function newLine($string){
	return trim(str_replace(array("\r\n","\r","\n"),array("&#10;","&#10;","&#10;"),$string));
}

function breakLine($string){
	return trim(str_replace(array("\r\n","\r","\n"),array("[OPEN_TAG]br/[CLOSE_TAG]","[OPEN_TAG]br/[CLOSE_TAG]","[OPEN_TAG]br/[CLOSE_TAG]"),$string));
}

function url_to_link($text) {
	$reg_exUrl = "/(http|https|ftp|ftps)\:\/\/[a-zA-Z0-9\-\.]+\.[a-zA-Z]{2,3}(\/\S*)?/";
	preg_match_all($reg_exUrl, $text, $matches);
	$usedPatterns = array();
	foreach($matches[0] as $pattern){
		if(!array_key_exists($pattern, $usedPatterns)){
			$usedPatterns[$pattern]=true;
			$text = str_replace($pattern, "[OPEN_TAG]a href='{$pattern}' target='_blank'[CLOSE_TAG]{$pattern}[OPEN_TAG]/a[CLOSE_TAG]", $text);
		}
	}
	return $text;
}

function stripAllLinks($str){
	$str = str_replace("'",'"',$str);
	return preg_replace('/<a href=\"(.*?)\">(.*?)<\/a>/', "\\2", $str);
}

function nl2p2($html) 
{ 
    // Use \n for newline on all systems 
    $html = preg_replace("/(\r\n|\n|\r)/", "\n", $html);
    // Only allow two newlines in a row. 
    $html = preg_replace("/\n\n+/", "\n\n", $html);
    
    // Put <p>..</p> around paragraphs 
    $html = preg_replace('/\n?(.+?)(\n\n|\z)/s', "<p>$1</p>", $html);
    
    // convert newlines not preceded by </p> to a <br /> tag 
    $html = preg_replace('|(?<!</p> )\s*\n|', "<br />", $html);
    
    return $html; 
} 

function filterCharacter($str){
	$array_filter = array('-','_');
	$array_replace = array(' ',' ');
	return str_replace($array_filter, $array_replace, $str);
}