<?php defined('BASEPATH') or exit('No direct script access allowed');

class Facebookconnect_io_m extends MY_Model {
	function __construct(){
		parent::__construct();
	}
	
	function init($cmd, $value){
		if($cmd == 'facebookid'){
			$rs = $this->db->where('facebookid',$value)->get(TBL_FACEBOOK_CONNECT)->result();
			return ($rs)?$rs[0]:false;
		}elseif($cmd == 'userid'){
			$rs = $this->db->where('userid',$value)->get(TBL_FACEBOOK_CONNECT)->result();
			return ($rs)?$rs[0]:false;
		}
		return false;
	}
		
	function insert_map($array_key_value){
		foreach($array_key_value as $key=>$value){
			$this->db->set($key,$value);
		}
		$this->db->insert(TBL_FACEBOOK_CONNECT);
		return $this->db->insert_id();
	}
	
	function update_map($array_key_value,$facebookconnectid){
		foreach($array_key_value as $key=>$value){
			$this->db->set($key,$value);
		}
		$this->db->where('facebookconnectid',$facebookconnectid)->update(TBL_FACEBOOK_CONNECT);
	}
	
	function getFriendsList($id_user){
		$data = $this->init('userid',$id_user);
		 
		$friends = file_get_contents("https://graph.facebook.com/me/friends?access_token={$data->access_token}") ;
		return (array) json_decode($friends);
	}
	
	function getUserInfo($id_user){
		$data = $this->init('userid',$id_user);
		 
		$info = file_get_contents("https://graph.facebook.com/{$data->facebookid}") ; //?access_token={$data->access_token}
		return( (array) json_decode($info) );
	}
	
	function getFacebookUserProfileImage($idFacebookUser){
		return "https://graph.facebook.com/{$idFacebookUser}/picture";
	}
	
	function postOnUserWall($id_user,$message,$description,$url){
		$data = $this->init('userid',$id_user);
		
		$attachment =  array(
			'description' => $description,
			'message' => $message,
			'picture'=> site_url()."image/logo.png", 
			'link' =>$url,
			'access_token' => $data->access_token
		); 
		
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL,"https://graph.facebook.com/{$data->facebookid}/feed");
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
		curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2);
		curl_setopt($ch, CURLOPT_POST, true);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $attachment);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);  //to suppress the curl output 
		$result = curl_exec($ch);
		curl_close ($ch);
		return $result;
	}
	
	
	function postOnFacebookUserWall($id_user,$fbUserId,$message,$description,$url ){
		$data = $this->init('userid',$id_user);
	
		$attachment =  array(
			'access_token' => $data->access_token,
			'message' => $message,
			//'name' => $title,
			'link' => $url,
			'description' => $description,
			'picture'=>site_url()."image/logo.png", 
			//'actions' => json_encode(array('name' => $action_name,'link' => $action_link))
			);

		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL,"https://graph.facebook.com/{$fbUserId}/feed");
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
		curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2);
		curl_setopt($ch, CURLOPT_POST, true);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $attachment);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);  //to suppress the curl output 
		$result = curl_exec($ch);
		curl_close ($ch);
		return $result;
	}
	
	
//end class	 
}