<?php defined('BASEPATH') or exit('No direct script access allowed');

class Gallery_io_m extends MY_Model {
	function __construct(){
		parent::__construct();
	}
	
	function init($cmd, $value){
		if($cmd == 'id_image'){
			$rs = $this->db->where('id_image',$value)->get(TBL_GALLERY)->result();
			return ($rs)?$rs[0]:false;
		}
		return false;
	}
		
	function insert_map($array_key_value){
		foreach($array_key_value as $key=>$value){
			$this->db->set($key,$value);
		}
		$this->db->insert(TBL_GALLERY);
		return $this->db->insert_id();
	}
	
	function update_map($array_key_value,$id_image){
		foreach($array_key_value as $key=>$value){
			$this->db->set($key,$value);
		}
		$this->db->where('id_image',$id_image)->update(TBL_GALLERY);
	}
	
//end class	 
}