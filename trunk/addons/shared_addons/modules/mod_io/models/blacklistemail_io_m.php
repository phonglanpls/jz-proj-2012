<?php defined('BASEPATH') or exit('No direct script access allowed');

class Blacklistemail_io_m extends MY_Model {
	function __construct(){
		parent::__construct();
	}
	
	function init($cmd,$value){
		if($cmd=='email'){
			$res = $this->db->where('email',$value)->get(TBL_BLACKLISTEMAILS)->result();
			return ($res)?$res[0]:false;
		}
		return false;
	}
		
	function insert_map($array_key_value){
		foreach($array_key_value as $key=>$value){
			$this->db->set($key,$value);
		}
		$this->db->insert(TBL_BLACKLISTEMAILS);
		return $this->db->insert_id();
	}
	
//end class	 
}