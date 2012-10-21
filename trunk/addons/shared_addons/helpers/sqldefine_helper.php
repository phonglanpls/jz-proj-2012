<?php  if (!defined('BASEPATH')) exit('No direct script access allowed');

function interator_getNextVal(&$array, $curr_val)	// return array value
{
    $next = null;
    reset($array);

    do
    {
        $tmp_val = current($array);
        $res = next($array);
    } while ( ($tmp_val != $curr_val) && $res );

    if( $res )
    {
        $next = current($array);
    }

    return $next;
}

function interator_getPrevVal(&$array, $curr_val)	// return array value
{
    end($array);
    $prev = null;

    do
    {
        $tmp_val = current($array);
        $res = prev($array);
    } while ( ($tmp_val != $curr_val) && $res );

    if( $res )
    {
        $prev = current($array);
    }

    return $prev;
}

function interator_getNext(&$array, $curr_key)	// return array key
{
    $next = null;
    reset($array);

    do
    {
        $tmp_key = key($array);
        $res = next($array);
    } while ( ($tmp_key != $curr_key) && $res );

    if( $res )
    {
        $next = key($array);
    }

    return $next;
}

function interator_getPrev(&$array, $curr_key)	// return array key
{
    end($array);
    $prev = null; 

    do
    {
        $tmp_key = key($array);
        $res = prev($array);
    } while ( ($tmp_key != $curr_key) && $res );

    if( $res )
    {
        $prev = key($array);
    }

    return $prev;
}

function getValueOfArray($array){
	if(!$array) return '';
	$tmp = array_values($array);
	return $tmp[0];
}

function getKeyOfArray($array){
	if(!$array) return '';
	$tmp = array_keys($array);
	return $tmp[0];
}

function trim_all(&$value)
{  
  if (is_array($value))
  {    
    array_walk_recursive($value, 'trim_all');
  }
  else
  {    
    $value = trim(str_replace("\r\n", "\n", $value));
  }
}

function filesInDir($path,&$files = array())
{
    $dir = opendir($path."/.");
    while($item = readdir($dir))
        if(is_file($sub = $path."/".$item))
            $files[] = $item;else
            if($item != "." and $item != "..")
                filesInDir($sub,$files); 
    return($files);
}
// ------------------------------------------------------------------------
function clone_($some)
{
   return (is_object($some)) ? clone $some : $some;
}

function normal_chars($string)
{
    $string = htmlentities($string, ENT_QUOTES, 'UTF-8');
    $string = preg_replace('~&([a-z]{1,2})(acute|cedil|circ|grave|lig|orn|ring|slash|th|tilde|uml);~i', '$1', $string);
    $string = preg_replace(array('~[^0-9a-z]~i', '~-+~'), ' ', $string);
    return trim($string);
}

function slugify($text)
{ 
	$text = preg_replace('~[^\\pL\d]+~u', '-', $text);
	$text = trim($text, '-');
	$text = iconv('utf-8', 'us-ascii//TRANSLIT', $text);
	$text = strtolower($text);
	$text = preg_replace('~[^-\w]+~', '', $text);
	if (empty($text))
	{
		return 'n-a';
	}
	return $text;
}

define( 'TBL_USER', 'default_juz__user' );
define( 'TBL_FACEBOOK_CONNECT', 'default_juz__facebookconnects' );
define( 'TBL_TWITTER_CONNECT', 'default_juz__twitterconnects' );
define( 'TBL_CONFIG', 'default_juz__config' );
define( 'TBL_BLACKLISTEMAILS', 'default_juz__blacklistedemails' );
define( 'TBL_BLOCKIP', 'default_juz__blockedip' );
define( 'TBL_GALLERY', 'default_juz__gallery');
define( 'TBL_TRANSACTION', 'default_juz__transaction');
define( 'TBL_FRIENDLIST', 'default_juz__friendlist' );
define( 'TBL_HENTAI_CATEGORY', 'default_juz__hentai_category' );
define( 'TBL_WALL', 'default_juz__wall' );
define( 'TBL_VIDEO', 'default_juz__video' );
define( 'TBL_SERIES', 'default_juz__series' );
define( 'TBL_ASK_QUESTION', 'default_juz__askmeq' );
define( 'TBL_POST_INFO', 'default_juz__post_info' );
define( 'TBL_CITY', 'default_juz__city' );
define( 'TBL_COUNTRY', 'default_juz__country' );
define( 'TBL_STATE', 'default_juz__state' );
define( 'TBL_ASK_ANSWER', 'default_juz__askmea' );
define( 'TBL_TIMEZONE', 'default_juz__timezone' );
define( 'TBL_INVITATION', 'default_juz__invitation' );
define( 'TBL_PET', 'default_juz__pet' );
define( 'TBL_PETLOCK', 'default_juz__petlock' );
define( 'TBL_PETSEARCH', 'default_juz__pet_search' );
define( 'TBL_ONLINE', 'default_juz__online' );
define( 'TBL_WISHLIST', 'default_juz__wishlist' );
define( 'TBL_LOCKHISTORY', 'default_juz__lockhistory' );
define( 'TBL_EMAILSETTING', 'default_juz__email_setting' );
define( 'TBL_BACKSTAGE_VIDEO', 'default_juz__backstage_video' );
define( 'TBL_COLLECTION', 'default_juz__collection' );
define( 'TBL_RATE', 'default_juz__rate' );
define( 'TBL_PHOTO_COMMENT', 'default_juz__photo_comment' );
define( 'TBL_CATEGORY', 'default_juz__category' );
define( 'TBL_GIFTBOX', 'default_juz__giftbox' );
define( 'TBL_GIFT', 'default_juz__gift' );
define( 'TBL_FLIRT', 'default_juz__flirt' );
define( 'TBL_MAP_HISTORY', 'default_juz__map_history' );
define( 'TBL_BLOCKED_LIST', 'default_juz__blocked_list' );
define( 'TBL_CHECKED', 'default_juz__checked' );
define( 'TBL_RANDOM_MESSAGE', 'default_juz__random_message' );
define( 'TBL_HENTAI_COMMENT', 'default_juz__hentai_comment' );
define( 'TBL_VIDEO_COMMENT', 'default_juz__video_comment' );
define( 'TBL_WATCHING_VIDEO', 'default_juz__watchingvideo' );
define( 'TBL_MAPFLIRT_SEARCH', 'default_juz__mapflirts_search' );
define( 'TBL_FAVORITE', 'default_juz__favorite' );
define( 'TBL_PEEPBOUGHT_HISTORY', 'default_juz__peepbought_history' );
define( 'TBL_QUESTION_DEF', 'default_juz__question_define' );
define( 'TBL_LOGIN', 'default_juz__login' );
define( 'TBL_BLOCKEDIP_LOGIN', 'default_juz__blockedip_login' );
define( 'TBL_REPORT_ABUSE', 'default_juz__report_abuse' );
define( 'TBL_CHAT_FAVOURITE', 'default_juz__favourite_list_chat' );
define( 'TBL_FAVOURITE_BUY_LOG', 'default_juz__favourite_buy_log' );

define( 'TBL_TIMELINE_OPTION', 'default_juz__timeline_option' );






