<?php defined('BASEPATH') or exit('No direct script access allowed');

class Online_m extends MY_Model {
	function __construct(){
		parent::__construct();
	}
	
	function checkOnlineUser($id_user){
		//$res = $this->db->where('id_user')->get(TBL_ONLINE)->result();
		$userdata = $this->user_io_m->init('id_user',$id_user);
		if($userdata->lastactivity + 60 >= time()){
			return true;
		}
		
		return false;
	}	
	
	
	
	
	
	
	
//endclass
}	