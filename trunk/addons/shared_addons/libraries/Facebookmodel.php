<?php defined('BASEPATH') OR exit('No direct script access allowed');
//private $params=array('scope'=>'offline_access,read_friendlists,user_birthday,email,publish_stream,status_update,user_about_me,user_education_history,user_photos,user_work_history');

/**
array(20) { ["id"]=> string(15) "100000047988157" ["name"]=> string(17) "Đô Đốc Hùng" ["first_name"]=> string(4) "Đô" ["middle_name"]=> string(6) "Đốc" ["last_name"]=> string(5) "Hùng" ["link"]=> string(36) "http://www.facebook.com/dangdinhhung" ["username"]=> string(12) "dangdinhhung" ["birthday"]=> string(10) "12/24/1988" ["location"]=> array(2) { ["id"]=> string(15) "110931812264243" ["name"]=> string(15) "Ha Noi, Vietnam" } ["bio"]=> string(154) "Tuy ta không phải là cây ngọc đón gió Nhưng ta có tấm lòng rộng mở Thoải mái không câu lệ Cộng thêm cánh tay rắn chắc..." ["work"]=> array(3) { [0]=> array(1) { ["employer"]=> array(2) { ["id"]=> string(15) "115201351823736" ["name"]=> string(9) "Freelance" } } [1]=> array(2) { ["employer"]=> array(2) { ["id"]=> string(15) "140940855961474" ["name"]=> string(17) "Red River Vietnam" } ["position"]=> array(2) { ["id"]=> string(15) "108480125843293" ["name"]=> string(13) "Web Developer" } } [2]=> array(6) { ["employer"]=> array(2) { ["id"]=> string(15) "109356329087638" ["name"]=> string(3) "ffg" } ["location"]=> array(2) { ["id"]=> string(15) "110931812264243" ["name"]=> string(15) "Ha Noi, Vietnam" } ["position"]=> array(2) { ["id"]=> string(15) "137526292934288" ["name"]=> string(27) "2nd FL, Thanh Dong Building" } ["description"]=> string(50) "PHP, MySQL, CSS specializing. WEB 2.0 developer." ["start_date"]=> string(7) "2007-06" ["end_date"]=> string(7) "2009-10" } } ["education"]=> array(4) { [0]=> array(3) { ["school"]=> array(2) { ["id"]=> string(15) "112250748814375" ["name"]=> string(11) "chuong my a" } ["year"]=> array(2) { ["id"]=> string(15) "194603703904595" ["name"]=> string(4) "2003" } ["type"]=> string(11) "High School" } [1]=> array(3) { ["school"]=> array(2) { ["id"]=> string(15) "114124068619610" ["name"]=> string(20) "THPT Chương Mỹ A" } ["year"]=> array(2) { ["id"]=> string(15) "194603703904595" ["name"]=> string(4) "2003" } ["type"]=> string(11) "High School" } [2]=> array(3) { ["school"]=> array(2) { ["id"]=> string(15) "108494469181799" ["name"]=> string(7) "Coltech" } ["type"]=> string(7) "College" ["with"]=> array(1) { [0]=> array(2) { ["id"]=> string(10) "1301964179" ["name"]=> string(7) "Khi Con" } } } [3]=> array(5) { ["school"]=> array(2) { ["id"]=> string(15) "139198386099754" ["name"]=> string(12) "UET, COLTECH" } ["degree"]=> array(2) { ["id"]=> string(15) "107779095917871" ["name"]=> string(8) "Bachelor" } ["year"]=> array(2) { ["id"]=> string(15) "137616982934053" ["name"]=> string(4) "2006" } ["concentration"]=> array(1) { [0]=> array(2) { ["id"]=> string(15) "110969368990632" ["name"]=> string(22) "Information Technology" } } ["type"]=> string(15) "Graduate School" } } ["gender"]=> string(4) "male" ["interested_in"]=> array(1) { [0]=> string(6) "female" } ["relationship_status"]=> string(6) "Single" ["email"]=> string(19) "hungdd_88@yahoo.com" ["timezone"]=> int(7) ["locale"]=> string(5) "en_US" ["verified"]=> bool(true) ["updated_time"]=> string(24) "2012-06-04T01:07:55+0000" }
**/	

require_once ("Facebook.php");

class CI_Facebookmodel{
	private $appid; 
	private $appsecret;
	private $params=array('scope'=>'user_birthday,email,publish_stream,user_about_me,user_photos,user_activities,user_interests,user_relationships,user_relationship_details');
	private $loggedin=false; 
	public $facebook;
	public $CI;
	
	function __construct() {
		$this->appid		=	$GLOBALS['global']['FACEBOOK']['api_key'];
		$this->appsecret	=	$GLOBALS['global']['FACEBOOK']['api_secret'];
		$this->CI 			= 	&get_instance();
		
		$this->facebook = new Facebook(array(
			  'appId'  => $this->appid,
			  'secret' => $this->appsecret,
			  'cookie' => true,
			 // $this->params
			)
		);
		
	}
	
	function exchangeAccessToken(){
		$token = explode('=',$this->getApplicationAccessToken());
		$url = "https://graph.facebook.com/oauth/access_token?client_id={$this->appid}&client_secret={$this->appsecret}&grant_type=fb_exchange_token&fb_exchange_token={$token[1]}";

		$ch = curl_init();

		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_HEADER, 0);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
		curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

		$response = curl_exec($ch);

		curl_close($ch);

		// parse response
		parse_str($response, $token_data);

		// exchanged token
		$access_token = $token_data['access_token'];

		echo '<br/>exchanged access token: ' . $access_token;
	}
	
	function getUserAccessToken(){
		return $this->facebook->getUserAccessToken();
	}
	
	function getCurrentFacebookUser()
	{
	   /**
		 if(ENVIRONMENT == PYRO_DEVELOPMENT){
			//return unserialize('a:18:{s:2:"id";s:15:"100000047988157";s:4:"name";s:17:"Đô Đốc Hùng";s:10:"first_name";s:4:"Đô";s:11:"middle_name";s:6:"Đốc";s:9:"last_name";s:5:"Hùng";s:4:"link";s:36:"http://www.facebook.com/dangdinhhung";s:8:"username";s:12:"dangdinhhung";s:8:"birthday";s:10:"12/24/1988";s:8:"location";a:2:{s:2:"id";s:15:"110931812264243";s:4:"name";s:15:"Ha Noi, Vietnam";}s:3:"bio";s:154:"Tuy ta không phải là cây ngọc đón gió Nhưng ta có tấm lòng rộng mở Thoải mái không câu lệ Cộng thêm cánh tay rắn chắc...";s:4:"work";a:3:{i:0;a:1:{s:8:"employer";a:2:{s:2:"id";s:15:"115201351823736";s:4:"name";s:9:"Freelance";}}i:1;a:2:{s:8:"employer";a:2:{s:2:"id";s:15:"140940855961474";s:4:"name";s:17:"Red River Vietnam";}s:8:"position";a:2:{s:2:"id";s:15:"108480125843293";s:4:"name";s:13:"Web Developer";}}i:2;a:6:{s:8:"employer";a:2:{s:2:"id";s:15:"109356329087638";s:4:"name";s:3:"ffg";}s:8:"location";a:2:{s:2:"id";s:15:"110931812264243";s:4:"name";s:15:"Ha Noi, Vietnam";}s:8:"position";a:2:{s:2:"id";s:15:"137526292934288";s:4:"name";s:27:"2nd FL, Thanh Dong Building";}s:11:"description";s:50:"PHP, MySQL, CSS specializing. WEB 2.0 developer.";s:10:"start_date";s:7:"2007-06";s:8:"end_date";s:7:"2009-10";}}s:9:"education";a:4:{i:0;a:3:{s:6:"school";a:2:{s:2:"id";s:15:"112250748814375";s:4:"name";s:11:"chuong my a";}s:4:"year";a:2:{s:2:"id";s:15:"194603703904595";s:4:"name";s:4:"2003";}s:4:"type";s:11:"High School";}i:1;a:3:{s:6:"school";a:2:{s:2:"id";s:15:"114124068619610";s:4:"name";s:20:"THPT Chương Mỹ A";}s:4:"year";a:2:{s:2:"id";s:15:"194603703904595";s:4:"name";s:4:"2003";}s:4:"type";s:11:"High School";}i:2;a:3:{s:6:"school";a:2:{s:2:"id";s:15:"108494469181799";s:4:"name";s:7:"Coltech";}s:4:"type";s:7:"College";s:4:"with";a:1:{i:0;a:2:{s:2:"id";s:10:"1301964179";s:4:"name";s:7:"Khi Con";}}}i:3;a:5:{s:6:"school";a:2:{s:2:"id";s:15:"139198386099754";s:4:"name";s:12:"UET, COLTECH";}s:6:"degree";a:2:{s:2:"id";s:15:"107779095917871";s:4:"name";s:8:"Bachelor";}s:4:"year";a:2:{s:2:"id";s:15:"137616982934053";s:4:"name";s:4:"2006";}s:13:"concentration";a:1:{i:0;a:2:{s:2:"id";s:15:"110969368990632";s:4:"name";s:22:"Information Technology";}}s:4:"type";s:15:"Graduate School";}}s:6:"gender";s:4:"male";s:5:"email";s:19:"hungdd_88@yahoo.com";s:8:"timezone";i:7;s:6:"locale";s:5:"en_US";s:8:"verified";b:1;s:12:"updated_time";s:24:"2012-06-04T01:07:55+0000";}');
			$arr["id"] = "1000000479881512";
			$arr["name"] = "Đô Đốc Hùng";
			$arr["first_name"] = "Đô";
			$arr["middle_name"] = "Đốc";
			$arr["last_name"] = "Hùng";
			$arr["link"] = "http://www.facebook.com/dangdinhhung";
			$arr["username"] = "dangdinhhung123";
			$arr["birthday"] = "12/24/1988";
			$arr["location"] = array("id"=>1122334453345, "name"=> "Ha Noi, Vietnam");
			$arr["bio"] = "Tuy ta không phải là cây ngọc đón gió Nhưng ta có tấm lòng rộng mở Thoải mái không câu lệ Cộng thêm cánh tay rắn chắc...";
			$arr["work"] = "Array";
			$arr["education"] = "Array";
			$arr["gender"] = "male";
			$arr["email"] = "hungd11d_88@yahoo.com";
			$arr["timezone"] = "7";
			$arr["locale"] = "en_US";
			$arr["verified"] = "1";
			$arr["updated_time"] = "2012-06-04T01:07:55+0000";
			return $arr;
		}
		**/
		try
		{
			$user=$this->facebook->getUser();
		}
		catch(FacebookApiException $e)
		{
			return false;
		}
		if ($user) {
		  try {
			// Proceed knowing you have a logged in user who's authenticated.
			$user_profile = $this->facebook->api('/me') ;
			
			$this->loggedin=true;
			return $user_profile ;
		  } catch (FacebookApiException $e) {
			$user = null;
			return false;
		  }
		}
	}
	
	function testConnection()
	{
		try
		{
			$naitik = $this->facebook->api('/dangdinhhung');
		}
		catch(FacebookApiException $e)
		{
			return $e;
		}
		return $naitik;
	}
		
	function getLoginLogoutUrl()
	{
		$user=$this->facebook->getUser();
		if ($user) {
			$this->loggedin=true;
			$url = $this->facebook->getLogoutUrl();
		} else {
			$this->loggedin=false;
			$url = $this->facebook->getLoginUrl($this->params);
		}
		return $url;
	}
	
	function logout()
	{
		$this->facebook->destroySession();
	}
	
	function getApplicationAccessToken()
	{
		$token=file_get_contents('https://graph.facebook.com/oauth/access_token?client_id='.$this->appid.'&client_secret='.$this->appsecret.'&grant_type=client_credentials');
		return $token;		
	}
	
	function getTestUsers()
	{	
		$test_users=file_get_contents('https://graph.facebook.com/'.$this->appid.'/accounts/test-users?'.$this->getApplicationAccessToken());
		return stripslashes($test_users);
	}
	
	function createTestUsers()
	{
		//create 	
		$test_users=file_get_contents('https://graph.facebook.com/'.$this->appid.'/accounts/test-users?'.$this->getApplicationAccessToken().'&installed=false&name=juzondev&method=post');
		return $test_users;
	}
	
	function getTotalFriends()
	{
		try{
			$friends = $this->facebook->api('/me/friends') ;
		}
		catch(FacebookApiException $e)
		{
			return $e;
		}
		return count($friends['data']);
	}
	
	function getProfilePicture($id_user)
	{
		$picture=@file_get_contents('https://graph.facebook.com/me/picture?type=large&access_token='.$this->facebook->getAccessToken() );
		if($picture === FALSE)
		{
			return "error";
		}
		$temp_image_name	= $this->savePicture($picture);
		//////////////////////////////////////////
			
		$data['id_user']=$id_user;
        $data['image_type']='0';
        $data['price']=0;
        $data['comment']='Facebook Profile Picture';
		$randomnumber=rand(1, 999999999);
		$imagename='facebook_'.$randomnumber.'.jpg';	
        $image=$id_user.'_'.time().$imagename;
					
		$uploadDir  = APP_ROOT.$GLOBALS['global']['IMAGE']['image_orig']."photos/";
		$thumbnailDir = APP_ROOT.$GLOBALS['global']['IMAGE']['image_thumb']."photos/";
		$thumb_height = $GLOBALS['global']['IMAGE']['thumb_height'];
		$thumb_width = $GLOBALS['global']['IMAGE']['thumb_width'];
		$orig_width = $GLOBALS['global']['IMAGE']['orig_width'];
		$orig_height = $GLOBALS['global']['IMAGE']['orig_height'];
					
		//change the url format of picture
		$modified_cam_url=$temp_image_name;
		if(PHP_OS=='Windows')
		{
			$modified_cam_url=str_replace ("/","\\",$modified_cam_url);
		}
		else
		{
			//for linux
			$modified_cam_url=str_replace ("\\\\","\\",$modified_cam_url);
		}
		
		$file_tmp=$modified_cam_url;
		@chmod($file_tmp,0777);
		$is_copied =copy ($file_tmp,$uploadDir.$image);
		$is_copied =copy ($file_tmp,$thumbnailDir.$image);
		//delete temp file 
		if($is_copied)
		{
			// unlink($file_tmp);
		}
		
		makeThumb($image,$uploadDir,$orig_width,$orig_height);
		makeThumb($image,$thumbnailDir,$thumb_width,$thumb_height);
		if($is_copied){
			$data['image'] = $image;
			$img_id= $this->CI->gallery_io_m->insert_map($data);
			$this->changeProfileImage($id_user,$img_id);
		}
	}

	function changeProfileImage($id_user,$img_id)
	{
		$thumbDir = APP_ROOT.$GLOBALS['global']['PROF_IMAGE']['profile_thumb'];
		$chatterDir = APP_ROOT.$GLOBALS['global']['PROF_IMAGE']['profile_chatter'];
		$commDir = APP_ROOT.$GLOBALS['global']['PROF_IMAGE']['profile_comm'];
		$thumb_height = $GLOBALS['global']['PROF_IMAGE']['thumb_height'];
		$thumb_width = $GLOBALS['global']['PROF_IMAGE']['thumb_width'];
		$chatter_height = $GLOBALS['global']['PROF_IMAGE']['chatter_height'];
        $chatter_width = $GLOBALS['global']['PROF_IMAGE']['chatter_width'];
		$comm_height = $GLOBALS['global']['PROF_IMAGE']['comm_height'];
        $comm_width = $GLOBALS['global']['PROF_IMAGE']['comm_width'];
		
		$userobjdata = $this->CI->user_io_m->init('id_user',$id_user);
		
		$prev_img=$userobjdata->photo;
		if($prev_img){
			//unlink($thumbDir.$prev_img);
			//unlink($chatterDir.$prev_img);
			//unlink($commDir.$prev_img);
		}
		$imgtype=$GLOBALS['global']['IMAGE_STATUS']['public'];
		
		$this->CI->db->query(" UPDATE ".TBL_GALLERY." SET prof_flag=2 WHERE prof_flag=1 AND id_user=$id_user AND image_type=$imgtype");
		
		$res = $this->CI->db->query(" SELECT * FROM ".TBL_GALLERY." WHERE id_image=$img_id AND image_type=$imgtype LIMIT 1")->result();
		if($res AND $res[0]->id_wall){
			$galleryDir  = APP_ROOT.$GLOBALS['global']['IMAGE']['wall_image_orig'];
			$file_name = explode('_',$res[0]->image,2);
			$filename = $id_user."_".$img_id."_".$file_name[1];
		}else{
			$galleryDir  = APP_ROOT.$GLOBALS['global']['IMAGE']['image_orig']."photos/";
			$filename = $res[0]->image;
		}
		
		$photo['photo'] = $filename;
		$this->CI->user_io_m->update_map($photo, $id_user);
		
		$this->CI->db->query(" UPDATE ".TBL_GALLERY." SET prof_flag=1 WHERE id_image=$img_id AND image_type=$imgtype");
		
		copy ($galleryDir.$res[0]->image,$thumbDir.$filename);
		makeThumb($filename,$thumbDir,$thumb_width,$thumb_height); 
		copy ($galleryDir.$res[0]->image,$chatterDir.$filename);
		makeThumb($filename,$chatterDir,$chatter_width,$chatter_height); 
		copy ($galleryDir.$res[0]->image,$commDir.$filename);
		makeThumb($filename,$commDir,$comm_width,$comm_height); 
	}
	
	function savePicture($picture)
	{
		$randomnumber=rand(1, 999999999);
		
		$filename = "./image/facebook_temp/".$randomnumber."_".date('YmdHis') . '.jpg';
		$result = file_put_contents( $filename, $picture );
		if (!$result) {
			return "ERROR: Failed to write data to $filename, check permissions\n";
		}
		else
		{
			return $filename;
		}
	}
	
	function getInvitationDetails($inviter_id)
	{
		$userdataobj = $this->CI->user_io_m->init('id_user',$inviter_id);
	    $data['invite_fname'] = $userdataobj->first_name;
	    $data['invite_lname'] = $userdataobj->last_name;
	    $data['id_sender'] = $inviter_id;
		return $data;
	}
	
	// converts 5.5 to +05:30
	function convertToJuzTimeZoneFormat($time)
	{
		 $num = $time;
		$res = ($num < 0 ? '-' : '+') . (abs($num) < 10 ? '0' : '') . abs((int)$num) . ':';
		$mins = round((abs($num) - abs((int)$num)) * 60);
		$res .= ($mins < 10 ? '0' : '') . $mins;
		return $res;
	}
	
	function convertToJuzDateFormat($originalDate)
	{
		$unixdate= strtotime($originalDate);
		$newDate=date("Y-m-d",$unixdate);
		return $newDate;
	}
	
	function getFacebookid()
	{
		try{
			$userdetails=$this->getCurrentFacebookUser();
		}
		catch(FacebookApiException $e)
		{
			return false;
		}
		return $userdetails['id'];
	}
	
	//register as facebook connected
	function registerFacebookConnected($userid)
	{
		$this->CI->facebookconnect_io_m->insert_map(
			array(
					"userid"=>$userid,
					"facebookid"=>$this->getFacebookid() ,
					"add_date"=>date("Y-m-d",time()),
					"ip"=>$_SERVER['REMOTE_ADDR'], 	
					"invitedfriends"=>0,
					"access_token" => $this->getUserAccessToken()
				)
		);
	}
	
	function UnregisterFacebookConnected()
	{
	}
	
	function postOnWall($message,$description,$url)
	{	
		$attachment =  array(
			'description' => $description,
			'message' => $message,
			'picture'=> site_url()."image/logo.png", 
			'link' =>$url
		); 
		try
		{
			$wall= $this->facebook->api('/me/feed/','post',$attachment );
		}
		catch(FacebookApiException $e)
		{
			return $e;
		}
		return true;
	}
	
	function isFacebookUserInDatabase($userid)
	{
		if($userid)
		{
			$facebookconnectdataobj = $this->CI->facebookconnect_io_m->init('userid',$userid);
			if($facebookconnectdataobj){
				return true;
			}
			else
			{
				return false;
			}
		}
		else
		{
			false;
		}
	}
	
	function getUserAlbumIDs()
	{
		try{
			$albums = $this->facebook->api('/me/albums') ;
		}
		catch(FacebookApiException $e)
		{
			return $e;
		}
		$i=0;
		while($albums['data'][$i]['id'] != NULL)
		{
			$album_array[$i]=$albums['data'][$i]['id'];
			$i++;
		}
		return $album_array ;	
	}
	
	function getAboutMeCurrentCityFromFacebook()
	{
		$userdetails=$this->getCurrentFacebookUser();
		
		$details['aboutme']= isset($userdetails['bio'])?$userdetails['bio']:'';
		$details['currentcity']= isset($userdetails['hometown']['name']) ?$userdetails['hometown']['name']:'Ha noi';
		$details['email']= isset($userdetails['email'])?$userdetails['email']:'';
		
		/**
		$x=0;
		//get comma seperated work history
		while($userdetails['work'][$x]['employer']['name']!=NULL)
		{
			$details['workhistory']=$details['workhistory'].",".$userdetails['work'][$x]['employer']['name'];
			$x++;
		}
		**/
		return $details;	
	}
	
	function updateAboutMeCurrentCityJuz($id_user)
	{
		$details=$this->getAboutMeCurrentCityFromFacebook();
		//$location=$this->CI->geo_lib->getCoordinatesFromAddress($details['currentcity']);
		/*
		longitude = '".$location['longitude']."',
		latitude = '".$location['latitude']."',
		*/		
		$sql = "UPDATE ".TBL_USER."
				SET
				about_me = '".$details['aboutme']."',
				email = '".$details['email']."'
			    WHERE id_user='".$id_user."'";
		$this->CI->db->query($sql);
	}
	
	
	function getUserPhotoLinks()
	{
		$albums_array=$this->getUserAlbumIDs();
		$i=0;
		while($albums_array[$i] != NULL)
		{
			$pictures[$i]=$this->getPictureLinksFromaAlbum($albums_array[$i]);
			$i++;
		}
		return $pictures;
	}
	
	function countPictures()
	{
		$photolinks=$this->getUserPhotoLinks();
		
		$x=0;
		$y=0;
		$picturecount=0;
		while($photolinks[$x] != NULL)
		{
			while($photolinks[$x][$y] != NULL)
			{
				$picturecount++;
				$y++;
			}
			$y=0;
			$x++;
		}
		
		return $picturecount ;
	}
	
	function getPicturesInSequence()
	{
		$photolinks=$this->getUserPhotoLinks();
		
		$x=0;
		$y=0;
		$picturecount=0;
		while($photolinks[$x] != NULL)
		{
			while($photolinks[$x][$y] != NULL)
			{
				$PicturesInSequence[$picturecount]= $photolinks[$x][$y];
				$picturecount++;
				$y++;
			}
			$y=0;
			$x++;
		}
		 
		return $PicturesInSequence ;
	}
	
	function transferPicturesFromFaceBookToJuzon($id_user)
	{
		$picturelist=$this->getPicturesInSequence();
		$x=0;
		while($picturelist[$x]!= NULL)
		{
			echo $picturelist[$x];
			
			$picture=@file_get_contents($picturelist[$x]);
			$temp_image_name= 	$this->savePicture($picture);
			//////////////////////////////////////////
			$data['id_user']=$id_user;
			$data['image_type']='0';
			$data['price']='';
			$data['comment']='from Facebook';
			$randomnumber=rand(1, 999999999);
			$imagename='facebook_'.$randomnumber.'.jpg';	
			$image=$id_user.'_'.$img_id.'_'.$imagename;
						
			$uploadDir  = APP_ROOT.$GLOBALS['global']['IMAGE']['image_orig']."photos/";
			$thumbnailDir = APP_ROOT.$GLOBALS['global']['IMAGE']['image_thumb']."photos/";
			$thumb_height = $GLOBALS['global']['IMAGE']['thumb_height'];
			$thumb_width = $GLOBALS['global']['IMAGE']['thumb_width'];
			$orig_width = $GLOBALS['global']['IMAGE']['orig_width'];
			$orig_height = $GLOBALS['global']['IMAGE']['orig_height'];
					
			//change the url format of picture
			$modified_cam_url=$temp_image_name;
			if(PHP_OS=='Windows')
			{
				$modified_cam_url=str_replace ("/","\\",$modified_cam_url);
			}
			else
			{
				//for linux
				$modified_cam_url=str_replace ("\\\\","\\",$modified_cam_url);
			}
				
			$file_tmp=$modified_cam_url;
			chmod($file_tmp,0777);
			$is_copied =copy ($file_tmp,$uploadDir.$image);
			
			//delete temp file 
			 if($is_copied)
			 {
				// unlink($file_tmp);
			 }
			  
			chmod($uploadDir.$image,0777);
			
			makeThumb($image,$uploadDir,$orig_width,$orig_height);
			makeThumb($image,$thumbnailDir,$thumb_width,$thumb_height);
			if($is_copied){
				$data['image'] = $image;
				$this->CI->gallery_io_m->insert_map($data);
				//return  $img_id;
			}

			$x++;
		}
	}
	
	function getPictureLinksFromaAlbum($album_id)
	{
		try{
			$pictures = $this->facebook->api('/'.$album_id.'/photos') ;
		}
		
		catch(FacebookApiException $e)
		{
			return $e;
		}
		$i=0;
		while($pictures['data'][$i]['source'] != NULL)
		{
			$pictures_array[$i]=$pictures['data'][$i]['source'];
			$i++;
		}
		return	$pictures_array ;
	}
	
	//states
	function isAccountVerified()
	{
		if($this->getCurrentFacebookUser())
		{
			$userdetails=$this->getCurrentFacebookUser();
			if($userdetails['verified'])
			{
				return true;
			}
			else
			{
				return false;
			}
		}
		else
		{
			return false;
		}
	}
	
	function isUserLoggedin()
	{
		if($this->getCurrentFacebookUser())
		{
			return true;
		}
		else
		{
		  return false;
		}
	}
	
	function isFacebookConnected()
	{
		try{
			$facebookid=$this->getFacebookid();
		}
		catch(FacebookApiException $e)
		{
			return false;
		}
		
		$facebookconnectdataobj = $this->CI->facebookconnect_io_m->init('facebookid',$facebookid); 
		if($facebookconnectdataobj){
			return $facebookconnectdataobj->userid;
		}else{
			return false;
		}
	}

	//genral purpose
	// Insert into database Return inserted id  if success , error message if failed 
	function insert($arr){
		$sql = "INSERT INTO ".TBL_FACEBOOK_CONNECT." ";
		$fld_str_key = "";
		$fld_str_value = "";
		foreach($arr as $key => $value){
			$fld_str_key .= $key.","; 
		}
		
		$fld_str_key = substr($fld_str_key,'0',strlen($fld_str_key)-1);
		$fld_str_key .= ",add_date,ip";
		foreach ($arr as $key => $value) {
			if(!isset($value) || $value == ""){
				$fld_str_value .= "NULL,";
			} else {
				$fld_str_value .= "'".$value."',";
			}
		}

		$fld_str_value = substr($fld_str_value,'0',strlen($fld_str_value)-1);
		$fld_str_value .= ",NOW(),'".$_SERVER['REMOTE_ADDR']."'";
		$sql = $sql." (".$fld_str_key.") VALUES(".$fld_str_value.")";
		
		$this->CI->db->query($sql);
		return $this->CI->db->insert_id();
	}
	
	function getUserDetails($userid)
	{
		return $this->CI->user_io_m->init('id_user',$userid);
	}
	
	function getinviteRequestDialog($invite_url)
	{
		$FirstStatusMessage=$GLOBALS['global']['FACEBOOK']['FirstStatusMessage'];  //get from config	
		$name=urlencode($FirstStatusMessage);
		$link=$invite_url;
		$picture= site_url()."image/logo.png";
		$redirect= site_url().'member/invite';
		$dialog_url="http://www.facebook.com/dialog/send?app_id=".$this->appid."&name=".$name."&link=".$link."&picture=".$picture."&redirect_uri=".$redirect;
  
		return $dialog_url;
	}
	
	function inviteFacebookUser($idFacebookUser,$message,$description, $invite_url){
		$attachment =  array(
			'message' => "$message",
			'name' => $message,
			'link' => "$invite_url",
			'description' => "$description",
			'picture'=> site_url()."image/logo.png", 
		);
		try
		{
			$wall=$this->facebook->api('/'.$idFacebookUser.'/feed', 'post', $attachment);
		}
		catch(FacebookApiException $e)
		{
			return $e;
		}
		return true;
		
	}
	
	function myFacebookFriends(){
		try{
			$friends = $this->facebook->api('/me/friends') ;
		}
		catch(FacebookApiException $e)
		{
			return $e;
		}
		return $friends;
	}
	
	function getFacebookUserProfileImage($idFacebookUser){
		return "https://graph.facebook.com/{$idFacebookUser}/picture";
	}
	
//end class	
}

