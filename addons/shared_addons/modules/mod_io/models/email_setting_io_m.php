<?php defined('BASEPATH') or exit('No direct script access allowed');

class Email_setting_io_m extends MY_Model {
	function __construct(){
		parent::__construct();
	}
	
	function init($id_user){
		$res = $this->db->where('id_user', $id_user)->get(TBL_EMAILSETTING)->result();
		if($res){
			return $res[0];
		}else{
			$insert['id_user']=$id_user;
			$this->mod_io_m->insert_map($insert,TBL_EMAILSETTING);
			return $this->init($id_user);
		}
	}

		
//endclass
}	