<?php defined('BASEPATH') OR exit('No direct script access allowed');

require_once ("Twitteroauth.php");

class CI_Twittermodel{
	private $oauth_request_token; 
	private $oauth_request_token_secret;
	private $tokens;
	private $loggedin=false; 
	private $connection;
	private $consumerKey;
	private $consumerSecret;
	public $CI;
	
	function __construct(){
		//$this->obj_profile = new profile;

		$this->consumerKey = $GLOBALS['global']['TWITTER']['consumer_key'];
		$this->consumerSecret = $GLOBALS['global']['TWITTER']['consumer_secret'];
		$this->twitter = new TwitterOAuth($this->consumerKey, $this->consumerSecret);
		$this->tokens = $this->twitter->getRequestToken();
	
		$this->oauth_request_token = $this->tokens['oauth_token'];
		$this->oauth_request_token_secret= $this->tokens['oauth_token_secret'];
		$this->CI 			= 	&get_instance();
	}
	
	function getAuthorizeURL()
	{
		$request_link = $this->twitter->getAuthorizeURL( $this->tokens );
		return $request_link;
	}
	
	function getCurrentUserDetails()
	{
		$this->connection =  (object) unserialize( $_SESSION['twitterconnection']);
		
		$userdetails=$this->connection->get('account/verify_credentials');
		//$_SESSION['currenttwitteruserid']=$userdetails->id;
		
		return((array)$userdetails);
	}
	 

	function setCurrentConnection($oauth_token,$oauth_verifier)
	{
		$this->connection= new TwitterOAuth($this->consumerKey, $this->consumerSecret, $oauth_token,$oauth_verifier );
		$token_credentials = $this->connection->getAccessToken();
		
		$this->connection = new TwitterOAuth($this->consumerKey, $this->consumerSecret, $token_credentials['oauth_token'], 
		$token_credentials['oauth_token_secret']);
        
		//debug("oauth_token_first:".$oauth_token."| oauth_verifier:".$oauth_verifier);
		
		//debug("oauth_token:".$token_credentials['oauth_token']."| oauth_token_secret:".$token_credentials['oauth_token_secret']);
		
		//store this connection in session
		$_SESSION['twitterconnection']=serialize($this->connection);
		$_SESSION['twwiterTokenInfo'] = $token_credentials['oauth_token'].'{|#|}'.$token_credentials['oauth_token_secret'];
        
		if($id_user = $this->isTwitterConnected()){
			$this->CI->db->where('userid',$id_user)->update(TBL_TWITTER_CONNECT, array('session_data'=>$_SESSION['twwiterTokenInfo']));
		}
	}
    
    function invokedSessionLogin($session_data){
        $explode = explode('{|#|}',$session_data);
        
        $this->connection = new TwitterOAuth($this->consumerKey, $this->consumerSecret, $explode[0], $explode[1]); 
        $_SESSION['twwiterTokenInfo'] = $session_data;
		$_SESSION['twitterconnection']=serialize($this->connection);
    }
	
	function postInviteStatus($invite_url)
	{
        $this->connection =unserialize( $_SESSION['twitterconnection']);
		$message = $GLOBALS['global']['TWITTER']['FirstStatusMessage'];
		 
		$postdetails= $this->connection->post('statuses/update',array("status"=>$message." ".$invite_url ));
	}
	
	function postOnWall($message, $link){
		$this->connection =unserialize( $_SESSION['twitterconnection']);
		$postdetails= $this->connection->post('statuses/update',array("status"=>$message." ".$link ));
	}
	
	function tweetOnOther($message, $link, $username){
		$this->connection =unserialize( $_SESSION['twitterconnection']);
		$postdetails= $this->connection->post('statuses/update',array("status"=>"@$username ".$message." ".$link ));
	}
	
	function tweetByApp($message, $link){
		$connection = new TwitterOAuth(	$this->consumerKey, $this->consumerSecret, 
										$GLOBALS['global']['TWITTER']['oauth_token'], 
										$GLOBALS['global']['TWITTER']['oauth_token_secret']
									);
									
		$twitterdata = $ci->db->where('userid',getAccountUserId())->get(TBL_TWITTER_CONNECT)->result();
		if($twitterdata AND $twitterdata[0]->session_data){
			$_SESSION['twitterconnection'] = $twitterdata[0]->session_data;
		}
		$userdetails=$this->connection->get('account/verify_credentials');
		
		$url = 'https://api.twitter.com/1/statuses/update.json';
		$status = "status=".urlencode($message.' '.$link)."&trim_user=true&include_entities=true&in_reply_to_status_id=@".$userdetails['screen_name'];	
		$ch = curl_init();
		
		curl_setopt($ch,CURLOPT_URL,$url);
		curl_setopt($ch,CURLOPT_POST,count($fields));
		curl_setopt($ch,CURLOPT_POSTFIELDS,$fields_string);
		//execute post
		$result = curl_exec($ch);
		//close connection
		curl_close($ch);
		return $result;
	}
	
	function getTwitterId()
	{
		$userdetails=$this->getCurrentUserDetails();
		return $userdetails['id'];		
	}
	
	//register as facebook connected
	function registerTwitterConnected($userid)
	{
		$this->insert(array("userid"=>$userid,"twitterid"=>$this->getTwitterId(), "session_data"=>( $_SESSION['twwiterTokenInfo'] )  ));
	}
	
	function UnregisterTwitterConnected()
	{
	}
	
	function isTwitterConnected()
	{
		$twitterid=$this->getTwitterId();		
		
		$twitterdata = $this->CI->db->query("SELECT userid FROM  ".TBL_TWITTER_CONNECT." WHERE  twitterid = '".$twitterid."'")->result();
		if($twitterdata)
		{
			return $twitterdata[0]->userid;
		}else
		{
			return false;
		}
	}
	
	function isTwitterUserInDatabase($userid)
	{
		$twitterdata = $this->CI->db->query("SELECT userid FROM  ".TBL_TWITTER_CONNECT." WHERE  userid = '".$userid."'")->result();
			
		if($twitterdata)
		{
			return true ;
		}else
		{
			return false;
		}
	}
	
	//genral purpose
	// Insert into database Return inserted id  if success , error message if failed 

	function insert($arr){
		$sql = "INSERT INTO ".TBL_TWITTER_CONNECT."";
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
		$err =  $this->CI->db->query($sql);

		return $this->CI->db->insert_id();
	}
	
	// converts 19800 to +05:30
	function convertToJuzTimeZoneFormat($time)
	{		
		$num = $time/3600;
		$res = ($num < 0 ? '-' : '+') . (abs($num) < 10 ? '0' : '') . abs((int)$num) . ':';
		// --> -05:
		$mins = round((abs($num) - abs((int)$num)) * 60);
		// --> 30
		$res .= ($mins < 10 ? '0' : '') . $mins;
		return $res;
	}
	
	function getProfilePictureLink()
	{
		$userdetails=$this->getCurrentUserDetails();
		return $userdetails['profile_image_url'];
	}
	
	function savePicture($picture)
	{
		$randomnumber=rand(1, 999999999);

		$filename = APP_ROOT."image/twitter_temp/".$randomnumber."_".date('YmdHis') . '.jpg';
		$result = file_put_contents( $filename, $picture );
		if (!$result) {
			debug("ERROR: Failed to write data to $filename, check permissions\n");
			return "ERROR: Failed to write data to $filename, check permissions\n";
		}
		else
		{
		//$image= imagecreatefromjpeg($picture);
		//var_dump($picture);
		return $filename;
		}
	}
	
	function savePictureToJuz($id_user)
	{
		$picture=@file_get_contents( $this->getProfilePictureLink() );
		
		if($picture === FALSE)
		{
			debug("CAN NOT GET PICTURE");
			return "error";
		}
		
        $temp_image_name=  $this->savePicture($picture);
	   
	    $data['id_user']=$id_user;
        $data['image_type']='0';
        $data['price']=0;
        $data['comment']='from twitter profile';
		
		//$imagename='twitter_profile.jpg';	
        //$image=$id_user.'_'.$imagename;
        $randomnumber=rand(1, 999999999);
		$imagename='twitter_profile'.$randomnumber.'.jpg';	
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
		
		@chmod($uploadDir.$image,0777);
		@chmod($thumbnailDir.$image,0777);
		
		makeThumb($image,$uploadDir,$orig_width,$orig_height);
		makeThumb($image,$thumbnailDir,$thumb_width,$thumb_height);
		if($is_copied){
			$data['image'] = $image;
			$img_id= $this->CI->gallery_io_m->insert_map($data);
			//$this->changeProfileImage($id_user,$img_id);
			return $img_id;
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
		 
		$prev_img = $userobjdata->photo;
		if($prev_img){
			//unlink($thumbDir.$prev_img);
			//unlink($chatterDir.$prev_img);
			//unlink($commDir.$prev_img);
		}
		$imgtype = $GLOBALS['global']['IMAGE_STATUS']['public'];
		
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
	
	function accountCreatedDaysBefore()
	{
		$userdetails=$this->getCurrentUserDetails();
		return (int)((time()-strtotime($userdetails['created_at']))/(24*60*60));

	}
	function getTotalFollowers()
	{
		$userdetails=$this->getCurrentUserDetails();
		return $userdetails['followers_count'];

	}
	function getTotalTweets()
	{
		$userdetails=$this->getCurrentUserDetails();
		return $userdetails['statuses_count'];

	}
}




	