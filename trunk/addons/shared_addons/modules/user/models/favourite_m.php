<?php defined('BASEPATH') or exit('No direct script access allowed');

class Favourite_m extends MY_Model {
	function __construct(){
		parent::__construct();
	}
	
	function getFavouriteList($from_id_user){
		return $this->db->where('from_id_user',$from_id_user)->order_by('id_favourite_list_chat','desc')->get(TBL_CHAT_FAVOURITE)->result();
	}
	
	function getWhoAddedMe(){
		return $this->db->where('to_id_user',getAccountUserId())->order_by('id_favourite_list_chat','desc')->get(TBL_CHAT_FAVOURITE)->result();
	}
	
	
	
	
	
//endclass	
}	