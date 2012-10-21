<?php defined('BASEPATH') or exit('No direct script access allowed');

class Mod_io_m extends MY_Model {
	function __construct(){
		parent::__construct();
	}
	
	function init($cmd, $value, $table){
		$res = $this->db->where($cmd, $value)->get($table)->result();
		return $res?$res[0]:false;
	}
	
	function insert_map($array_key_value,$table){
		foreach($array_key_value as $key=>$value){
			$this->db->set($key,$value);
		}
		$this->db->insert($table);
		return $this->db->insert_id();
	}
		
	function update_map($array_key_value,$where_array,$table){
		foreach($array_key_value as $key=>$value){
			$this->db->set($key,$value);
		}
		$this->db->where(getKeyOfArray($where_array),getValueOfArray($where_array))->update($table);
	}	
		
		
		
//end class	 
}