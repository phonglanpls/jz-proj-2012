<?php

/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

/* ADVANCED */

define('SET_SESSION_NAME','');			// Session name
define('DO_NOT_START_SESSION','0');		// Set to 1 if you have already started the session
define('DO_NOT_DESTROY_SESSION','0');	// Set to 1 if you do not want to destroy session on logout
define('SWITCH_ENABLED','0');		
define('INCLUDE_JQUERY','1');	
define('FORCE_MAGIC_QUOTES','0');

/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

/* DATABASE */

define('DB_SERVER',					'localhost'								);
define('DB_PORT',					'3306'									);
define('DB_USERNAME',				'root'									);
define('DB_PASSWORD',				''								);
define('DB_NAME',					'juzon1'								);
define('TABLE_PREFIX',				''										);
define('DB_USERTABLE',				'default_juz__user'									);
define('DB_USERTABLE_NAME',			'username'								);
define('DB_USERTABLE_USERID',		'id_user'								);
define('DB_USERTABLE_LASTACTIVITY',	'lastactivity'							);

/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

/* FUNCTIONS */

function getUserID() {
	$userid = 0;
	
	if (!empty($_SESSION['joz_account']['id_user'])) {
		$userid = $_SESSION['joz_account']['id_user'];
	}

	return $userid;
}


function getFriendsList($userid,$time) {
	/**
	$sql = ("select DISTINCT ".TABLE_PREFIX.DB_USERTABLE.".".DB_USERTABLE_USERID." userid, ".
			TABLE_PREFIX.DB_USERTABLE.".".DB_USERTABLE_NAME." username, ".TABLE_PREFIX.DB_USERTABLE.
			".".DB_USERTABLE_LASTACTIVITY." lastactivity, ".TABLE_PREFIX.DB_USERTABLE.
			".".DB_USERTABLE_USERID." avatar, ".TABLE_PREFIX.DB_USERTABLE.
			".".DB_USERTABLE_USERID." link, cometchat_status.message, cometchat_status.status from ".
			TABLE_PREFIX."friends join ".TABLE_PREFIX.DB_USERTABLE." on  ".TABLE_PREFIX.
			"friends.toid = ".TABLE_PREFIX.DB_USERTABLE.".".
			DB_USERTABLE_USERID." left join cometchat_status on ".
			TABLE_PREFIX.DB_USERTABLE.".".DB_USERTABLE_USERID." = cometchat_status.userid where ".
			TABLE_PREFIX."friends.fromid = '".mysql_real_escape_string($userid)."' order by username asc");
	**/
	
	$sql = ("select DISTINCT U.id_user userid,  
			U.username username,  
			U.lastactivity lastactivity,  
			U.photo avatar, U.username link, C.message, C.status from ".
			TABLE_PREFIX."default_juz__friendlist F, ".TABLE_PREFIX.DB_USERTABLE." U,cometchat_status C  WHERE ".
			"( (F.friend = U.id_user AND F.id_user=".$userid." AND F.request_type=0 AND U.status=0) OR 
			(F.id_user=U.id_user AND U.status=0 AND F.friend=".$userid." AND F.request_type=0) ) 
			AND C.userid=U.id_user ORDER BY U.username ASC");
			
	return $sql;
}

function getUserDetails($userid) {
	/**
	$sql = ("select ".TABLE_PREFIX.DB_USERTABLE.".".DB_USERTABLE_USERID." userid, 
			".TABLE_PREFIX.DB_USERTABLE.".".DB_USERTABLE_NAME." username, 
			".TABLE_PREFIX.DB_USERTABLE.".".DB_USERTABLE_LASTACTIVITY." lastactivity,  
			".TABLE_PREFIX.DB_USERTABLE.".".DB_USERTABLE_USERID." link,  
			".TABLE_PREFIX.DB_USERTABLE.".".DB_USERTABLE_USERID." avatar, 
			cometchat_status.message, cometchat_status.status from 
			".TABLE_PREFIX.DB_USERTABLE." left join cometchat_status on 
			".TABLE_PREFIX.DB_USERTABLE.".".DB_USERTABLE_USERID." = cometchat_status.userid 
			where ".TABLE_PREFIX.DB_USERTABLE.".".DB_USERTABLE_USERID." 
			= '".mysql_real_escape_string($userid)."'");
	**/		
	$sql = ("select ".TABLE_PREFIX.DB_USERTABLE.".".DB_USERTABLE_USERID." userid, 
			".TABLE_PREFIX.DB_USERTABLE.".".DB_USERTABLE_NAME." username, 
			".TABLE_PREFIX.DB_USERTABLE.".".DB_USERTABLE_LASTACTIVITY." lastactivity,  
			".TABLE_PREFIX.DB_USERTABLE.".".DB_USERTABLE_NAME." link,  
			".TABLE_PREFIX.DB_USERTABLE.".photo avatar, 
			cometchat_status.message, cometchat_status.status from 
			".TABLE_PREFIX.DB_USERTABLE." left join cometchat_status on 
			".TABLE_PREFIX.DB_USERTABLE.".".DB_USERTABLE_USERID." = cometchat_status.userid 
			where ".TABLE_PREFIX.DB_USERTABLE.".".DB_USERTABLE_USERID." 
			= '".mysql_real_escape_string($userid)."'");
	return $sql;
}

function updateLastActivity($userid) {
	$sql = ("update `".TABLE_PREFIX.DB_USERTABLE."` set ".DB_USERTABLE_LASTACTIVITY." = '".getTimeStamp()."' where ".DB_USERTABLE_USERID." = '".mysql_real_escape_string($userid)."'");
	return $sql;
}

function getUserStatus($userid) {
	 $sql = ("select cometchat_status.message, cometchat_status.status from cometchat_status where userid = '".mysql_real_escape_string($userid)."'");
	 return $sql;
}

function getLink($link) {
   // return 'users.php?id='.$link;
   return JUZ_BASE_URL.$link;
}

function getAvatar($image) {
	/*
    if (is_file(dirname(dirname(__FILE__)).'/image/profile_thumb/'.$image)) {
        return 'image/profile_thumb/'.$image;
    } else {
        return 'images/noavatar.gif';
    }
	*/
	if($image){
		return JUZ_BASE_URL."image/comment_thumb/$image";
	}else{
		return JUZ_BASE_URL."image/no_avatar.png";
	}
}


function getTimeStamp() {
	return time();
}

function processTime($time) {
	return $time;
}

/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

/* HOOKS */

function hooks_statusupdate($userid,$statusmessage) {
	
}

function hooks_forcefriends() {
	
}

function hooks_activityupdate($userid,$status) {

}

function hooks_message($fromuserid,$touserid,$unsanitizedmessage) {
    /*
	$jsonarray = json_decode( file_get_contents(JUZ_BASE_URL.'mod_io/jsonservices/user_status?id_user='.$userid) );
    if($jsonarray AND $jsonarray['online_status'] == 'offline' AND intval( $jsonarray['send_offline_message'] ) == 1){
        $message = urlencode($unsanitizedmessage);
        file_get_contents(JUZ_BASE_URL."mod_io/jsonservices/sendemail/?id_user=$userid&message=$message");
    } */
    $text = str_replace(array('[OPENTAG]','[CLOSETAG]','[WEB_URL]'), array('<','>',JUZ_BASE_URL),$unsanitizedmessage);
    write_file('../chat/chat_text.txt',$fromuserid.'|'.$touserid.'{|DELEMIT|}'.$text.PHP_EOL, 'a+');
}

function write_file($path, $data, $mode = FOPEN_WRITE_CREATE_DESTRUCTIVE)
{
	if ( ! $fp = @fopen($path, $mode))
	{
		return FALSE;
	}

	flock($fp, LOCK_EX);
	fwrite($fp, $data);
	flock($fp, LOCK_UN);
	fclose($fp);

	return TRUE;
}
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

/* LICENSE */

include_once(dirname(__FILE__).'/license.php');
$x="\x62a\x73\x656\x34\x5fd\x65c\157\144\x65";
eval($x('JHI9ZXhwbG9kZSgnLScsJGxpY2Vuc2VrZXkpOyRwXz0wO2lmKCFlbXB0eSgkclsyXSkpJHBfPWludHZhbChwcmVnX3JlcGxhY2UoIi9bXjAtOV0vIiwnJywkclsyXSkpOw'));

///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////// 