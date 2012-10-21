<?php  if (!defined('BASEPATH')) exit('No direct script access allowed');

function isLogin(){
	return isset($_SESSION['joz_account']) ? true: false;
}

function notMe($id_user){
	if($id_user != getAccountUserId()){
		return true;
	}
	return false;
}

function getAccountUserId(){
	if(isLogin()){
		$session_array = $_SESSION['joz_account'];
		return $session_array['id_user'];
	}
	return false;
}

function getAccountUserDataObject($dynamic=false){
	$ci = &get_instance();
	if(isLogin()){
		if(!$dynamic){
			$session_array = $_SESSION['joz_account'];
			return $session_array['dataobj'];
		}else{
			$_SESSION['joz_account']['dataobj'] = $ci->user_io_m->init('id_user',getAccountUserId());
			return $_SESSION['joz_account']['dataobj'];
		}
	}
	return false;
}

function isTwitterLogin(){
	/*
	$ci = &get_instance();
	if(getAccountUserId()){
		$twitterdata = $ci->db->where('userid',getAccountUserId())->get(TBL_TWITTER_CONNECT)->result();
		if($twitterdata AND $twitterdata[0]->session_data){
			$_SESSION['twitterconnection'] = $twitterdata[0]->session_data;
		}
	}
	*/
	return isset($_SESSION['twitterconnection'])?true:false;
}

function isFacebookLogin(){
	$ci = &get_instance();
	/**
	if(getAccountUserId()){
		$facebookdata = $ci->db->where('userid',getAccountUserId())->get(TBL_FACEBOOK_CONNECT)->result();
		if($facebookdata AND $facebookdata[0]->access_token){
			$token = explode('=',$facebookdata[0]->access_token);
			
			if(!$ci->facebookmodel->isFacebookConnected()){
				$ci->facebookmodel->setAccessToken($token[1]);
				echo $token[1];
			}
			 
		}
	}
	**/
    $data = $ci->facebookconnect_io_m->init('userid',getAccountUserId());
    if($data->access_token AND $data->facebookid){
        return true;
    }
    return false;
	//return ($ci->facebookmodel->isFacebookConnected())?true:false;
}

function newCaptcha(){
	$ci = &get_instance();
	$ci->load->helper('captcha');	
	$timeLIMIT = 72000;
	$captchaContent = $ci->digit->rand_string(5);
	$content = strtolower($captchaContent);
	$captcha = array( 'captcha_exprise_time'=>time() + $timeLIMIT , 'captcha_content'=>$content );
	$ci->session->set_userdata($captcha);	
	$vals = array(
		'word' => $captchaContent,
		'img_path' => './captcha/images/',
		'img_url' => site_url().'captcha/images/',
		'font_path' => './captcha/fonts/arial.ttf',
		'img_width' => '130',
		'img_height' => '30',
		'expiration' => $timeLIMIT
		);
	$cap = create_captcha($vals);
	return $cap['image'];
}

function currencyDisplay($amount){
	$number = sprintf('%.2f', $amount); 
    while (true) { 
        $replaced = preg_replace('/(-?\d+)(\d\d\d)/', '$1,$2', $number); 
        if ($replaced != $number) { 
            $number = $replaced; 
        } else { 
            break; 
        } 
    } 
    return $number; 
}

function checkRealEmail($email){
    /**
    $array = json_decode(file_get_contents("http://verify-email.org/api.html?format=raw&usr=vaodiemm&pwd=lucnap&check=$email"));
    if($array['verify_status'] == '1'){
        return true;
    }
    return false;
    **/
    if(ENVIRONMENT == PYRO_DEVELOPMENT){
        return true;
    }else{
        require_once("./asset/SMTP_validateEmail.php");
        $SMTP = new SMTP_validateEmail();
        $array = $SMTP->validate(array($email),'auto.email.sender.gate2@gmail.com');
        if(getValueOfArray($array) == 1){
            return true;
        }
        return false;
    }
}

function buildTrialPayParam($campaign){
    $userdataobj = getAccountUserDataObject();
    if($campaign == 'Test'){
        return "0e6a6eb7747a6d4690843c04f207f5f6?sid={$userdataobj->username}&ref_page=&ref_choice=&campaign=Test";
        //return "<iframe width=\"760\" height=\"2400\" scrolling=\"auto\" frameborder=\"0\" style=\"border: 1px none white;\" src=\"https://www.trialpay.com/dispatch/0e6a6eb7747a6d4690843c04f207f5f6?sid={$userdataobj->username}&ref_page=&ref_choice=&campaign=\" ";
    }
    
    if($campaign == 'TOPLEFT'){
        return "bf2aabcf66dfb8ab30584dda467d1824?sid={$userdataobj->username}&ref_page=addcash&ref_choice=add&campaign=Topleft";
    }
    
    if($campaign == 'DOWNLOAD'){
        return "fb54731a42cd89d9f2404a88cd9078df?sid={$userdataobj->username}&ref_page=addcash&ref_choice=download&campaign=Download";
    }
    
    if($campaign == 'BACKSTAGE'){
        return "c50bedc6e29c641e9c61f231169c5abd?sid={$userdataobj->username}&ref_page=addcash&ref_choice=backstage&campaign=BackstagePhoto";
    }
    
    if($campaign == 'MAPFLIRTS'){
        return "00c4d9215b3ecdefc51682138cfddafa?sid={$userdataobj->username}&ref_page=addcash&ref_choice=map&campaign=MapFlirts";
    }
    
    if($campaign == 'PETBUY'){
        return "e913416717bb842bc65814dcec955523?sid={$userdataobj->username}&ref_page=addcash&ref_choice=petbuy&campaign=PetBuy";
    }
    
    if($campaign == 'PETLOCK'){
        return "b7a009a6dd8a14b0ecd8e542dc590a5c?sid={$userdataobj->username}&ref_page=addcash&ref_choice=petlock&campaign=PetLock";
    }
    
    if($campaign == 'GIFT'){ // giftbox.js
        return "87fff0f0316207265c80578645f89ef2?sid={$userdataobj->username}&ref_page=addcash&ref_choice=gift&campaign=Gift";
    }
    
    if($campaign == 'FAVORITE'){ // favourite.js
        return "51f6a4c640c08b62794399f24f4b6ceb?sid={$userdataobj->username}&ref_page=addcash&ref_choice=favorite&campaign=WhoFavoriteMe";
    }
    
    if($campaign == 'PEEPED'){
        return "c823b92c0aa7504bd7bbcbdb6fe743e3?sid={$userdataobj->username}&ref_page=addcash&ref_choice=peeped&campaign=BuyPeeped";
    }
    
}


function forceUserConnect(){
	$userdataobj = getAccountUserDataObject();
	$ci = &get_instance();
	$checkError = array();
	if( $ci->facebookmodel->isUserLoggedin() ){
		$facebookid = $ci->facebookmodel->getFacebookid();
		$facebookconnectdataobj = $ci->facebookconnect_io_m->init('facebookid',$facebookid);
		if($facebookconnectdataobj AND $facebookconnectdataobj->userid != getAccountUserId()){
			if($id_user = $ci->facebookmodel->isFacebookConnected()){
				$ci->mod_io_m->update_map( array('access_token'=>$ci->facebookmodel->getUserAccessToken()), array('userid'=>$id_user), TBL_FACEBOOK_CONNECT);
			}

			$ci->user_io_m->userLogout();
			reloadJS_url("member/login");
		}else if(! $facebookconnectdataobj){
			
			if($ci->facebookmodel->getTotalFriends() < $GLOBALS['global']['FACEBOOK']['MinFacebookFriendsRequired']){
				$checkError[] = str_replace( '$s', $GLOBALS['global']['FACEBOOK']['MinFacebookFriendsRequired'] ,language_translate('member_fb_friend_request_error') );
			}
		
			if($ci->facebookmodel->countPictures() < $GLOBALS['global']['FACEBOOK']['MinFacebookPhotosRequired']){
				$checkError[] = str_replace( '$s', $GLOBALS['global']['FACEBOOK']['MinFacebookPhotosRequired'], language_translate('member_fb_photo_request_error') );
			}
			
			if(empty($checkError)){
				$data['userid'] = getAccountUserId();
				$data['facebookid'] = $facebookid;
				$data['add_date'] = mysqlDate();
				$data['ip'] = $ci->geo_lib->getIpAddress();
				$data['invitedfriends'] = 0;
				$data['access_token'] = $ci->facebookmodel->getUserAccessToken();
				$ci->facebookconnect_io_m->insert_map($data); 	
				
				$postFB = true;
				$ci->facebookmodel->getProfilePicture(getAccountUserId());
				
				$FirstStatusMessage = $GLOBALS['global']['FACEBOOK']['FirstStatusMessage'];   
				$FirstStatusDescription = $GLOBALS['global']['FACEBOOK']['FirstStatusDescription'];   
				$invite_url= $ci->user_io_m->getInviteUrl($userdataobj->username);					
				//$this->facebookmodel->postOnWall($FirstStatusMessage,$FirstStatusDescription,$invite_url);
				$ci->facebookconnect_io_m->postOnUserWall($userdataobj->id_user,$FirstStatusMessage,$FirstStatusDescription,$invite_url);

			}else{
				$ci->facebookmodel->logout();
			}
		}
	}
	
	if(isTwitterLogin()){
		$twitterid = $ci->twittermodel->getTwitterId();
		$twitterconnectdataobj = $ci->mod_io_m->init('twitterid',$twitterid,TBL_TWITTER_CONNECT);
		$availabelTwitterConnectObj = $ci->mod_io_m->init('userid',getAccountUserId(),TBL_TWITTER_CONNECT);
		if($twitterconnectdataobj AND $twitterconnectdataobj->userid != getAccountUserId()){
			$ci->user_io_m->userLogout();
			reloadJS_url("member/login");
		}else if(! $twitterconnectdataobj AND !$availabelTwitterConnectObj){
			
			if($ci->twittermodel->getTotalFollowers() < $GLOBALS['global']['TWITTER']['MinFollowersRequired']){
				$checkError[] = str_replace( '$s', $GLOBALS['global']['TWITTER']['MinFollowersRequired'], language_translate('member_tt_followers_request_error') );
			}
		
			if($ci->twittermodel->getTotalTweets() < $GLOBALS['global']['TWITTER']['MinTweetsRequired']){
				$checkError[] = str_replace( '$s', $GLOBALS['global']['TWITTER']['MinTweetsRequired'], language_translate('member_tt_mintweet_request_error') );
			}
		
			if($ci->twittermodel->accountCreatedDaysBefore() < $GLOBALS['global']['TWITTER']['MinDaysOldAccountRequired']){
				$checkError[] = str_replace( '$s', $GLOBALS['global']['TWITTER']['MinDaysOldAccountRequired'], language_translate('member_tt_mindays_request_error') );
			}
				
			if(empty($checkError)){	
				$data['userid'] = getAccountUserId();
				$data['twitterid'] = $twitterid;
				$data['add_date'] = mysqlDate();
				$data['ip'] = $ci->geo_lib->getIpAddress();
				$data['session_data'] = ( $_SESSION['twwiterTokenInfo'] );
				$ci->mod_io_m->insert_map($data,TBL_TWITTER_CONNECT); 	 
						
				$ci->twittermodel->changeProfileImage(getAccountUserId(),$ci->twittermodel->savePictureToJuz(getAccountUserId()));	 
				$invite_url=$ci->user_io_m->getInviteUrl($userdataobj->username);
				$ci->twittermodel->postInviteStatus($invite_url);
			}else{
				unset($_SESSION['twitterconnection']);
			}
		}
	 }
	 
	 return $checkError;
}
