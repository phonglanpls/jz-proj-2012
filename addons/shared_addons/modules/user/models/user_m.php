<?php defined('BASEPATH') or exit('No direct script access allowed');

class User_m extends MY_Model {
	function __construct(){
		parent::__construct();
	}
	
	function getUserHomeLink($user_id){
		$userdataobj = $this->user_io_m->init('id_user',$user_id);
		$username = strtolower($userdataobj->username);
		if(	$username == 'admin' || $username == 'anonymous' || 
			$username == 'anonymously' || $username == 'member'
			|| $username == 'mod_io' || $username == 'user' || $username== 'hentai' || $username == 'fadmin' || $username == 'videos'
		){
			return '#';	
		}
		
		$link = site_url($username);
		return $link;
	}
	
	function getProfileAvatar($user_id){
		$userdataobj = $this->user_io_m->init('id_user',$user_id);
		if($userdataobj->photo)
			return site_url().$GLOBALS['global']['PROF_IMAGE']['profile_thumb'].$userdataobj->photo;
		else
			if($userdataobj->gender == 'Male')
				return site_url().$GLOBALS['global']['PROF_IMAGE']['profile_thumb'].'default_male.png';
			else
				return site_url().$GLOBALS['global']['PROF_IMAGE']['profile_thumb'].'default_female.png';
	}
	
	function getCommentAvatar($user_id){
		$userdataobj = $this->user_io_m->init('id_user',$user_id);
		if($userdataobj->photo)
			return site_url().$GLOBALS['global']['PROF_IMAGE']['profile_comm'].$userdataobj->photo;
		else
			if($userdataobj->gender == 'Male')
				return site_url().$GLOBALS['global']['PROF_IMAGE']['profile_comm'].'default_male.png';
			else
				return site_url().$GLOBALS['global']['PROF_IMAGE']['profile_comm'].'default_female.png';
	}
	
	function getProfileDisplayName($user_id){
		$userdataobj = $this->user_io_m->init('id_user',$user_id);
		//return $userdataobj->first_name.' '.$userdataobj->last_name;
		return $this->buildNativeLink( $userdataobj->username );
	}	
		
	function getCash($user_id){
		$userdataobj = $this->user_io_m->init('id_user',$user_id);
		return number_format($userdataobj->cash,2). 'J$';
	}	
	
	function getValue($user_id){
		$userdataobj = $this->user_io_m->init('id_user',$user_id);
		return number_format($userdataobj->cur_value,2). 'J$';
	}
	
	function getMyOwnerId($user_id){
		$res = $this->db->where('id_user',$user_id)->get(TBL_PET)->result();
		return $res?$res[0]->id_owner:131;
	}	
	
	function calculatePetPrice($user_id){
		$userdataobj = $this->user_io_m->init('id_user',$user_id);
		$x = $GLOBALS['global']['PET_VALUE']['pet_percentage']/100;
		$y = $userdataobj->cur_value;
		
		$price = $x*$y + $y;
		return number_format($price,2);
	}
	
	function buildNativeLink($username){
		//$userdataobj = $this->user_io_m->init('id_user',$id_user);
		$username = strtolower($username);
		if(	$username == 'admin' || $username == 'anonymous' || 
			$username == 'anonymously' || $username == 'member'
			|| $username == 'mod_io' || $username == 'user' || $username== 'hentai' || $username == 'fadmin'
		){
			return $username;	
		}
		
		$link = site_url($username);
		return "<a href=\"$link\">$username</a>";
	}
	
	function getListUsername(){
		$arr = array();
		$rs  = $this->db->where('status',0)->get(TBL_USER)->result();
		foreach($rs as $item){
			if($item->username != 'admin'){
				$arr[] = $item->username;
			}
		}
		return $arr;
	}
	
	function getListMyFriendsUsername(){
		$id_user = getAccountUserId();
		$rs = $this->db->query("SELECT * FROM ".TBL_FRIENDLIST." WHERE (id_user=$id_user OR friend=$id_user) AND request_type='0' ")->result();
		$arr = array();
		
		foreach($rs as $item){
			if($item->id_user != $id_user){
				$datauser = $this->user_io_m->init('id_user',$item->id_user);
			}else{
				$datauser = $this->user_io_m->init('id_user',$item->friend);
			}
			if($datauser AND $datauser->status == 0){
				$arr[] = $datauser->username;
			}
		}
		return $arr;
	}
	
	function getListUserFriendsUserId($id_user){
		$rs = $this->db->query("SELECT * FROM ".TBL_FRIENDLIST." WHERE (id_user=$id_user OR friend=$id_user) AND request_type='0' ")->result();
		$arr = array();
		
		foreach($rs as $item){
			if($item->id_user != $id_user){
				$datauser = $this->user_io_m->init('id_user',$item->id_user);
			}else{
				$datauser = $this->user_io_m->init('id_user',$item->friend);
			}
			if($datauser AND $datauser->status == 0){
				$arr[] = $datauser->id_user;
			}
		}
		return $arr;
	}
//end class	 
}