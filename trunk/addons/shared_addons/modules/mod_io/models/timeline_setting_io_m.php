<?php defined('BASEPATH') or exit('No direct script access allowed');

class Timeline_setting_io_m extends MY_Model {
	function __construct(){
		parent::__construct();
	}
	
	function init($id_user){
		$res = $this->db->where('id_user', $id_user)->get(TBL_TIMELINE_OPTION)->result();
		if($res){
			return $res[0];
		}else{
			$insert['id_user']=$id_user;
			$this->mod_io_m->insert_map($insert,TBL_TIMELINE_OPTION);
			return $this->init($id_user);
		}
	}

		
//endclass
}	