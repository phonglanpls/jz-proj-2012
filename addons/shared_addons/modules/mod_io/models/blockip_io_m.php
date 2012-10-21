<?php defined('BASEPATH') or exit('No direct script access allowed');

class Blockip_io_m extends MY_Model {
	function __construct(){
		parent::__construct();
	}
	
	function countFailureAttemp(){
		$rs = $this->db->query("SELECT COUNT(id_block) AS cnt FROM ".TBL_BLOCKIP." WHERE ip='" . $this->geo_lib->getIpAddress() . "'")->result();
		return $rs[0]->cnt;
	}
		
	function insert_map($array_key_value){
		foreach($array_key_value as $key=>$value){
			$this->db->set($key,$value);
		}
		$this->db->insert(TBL_BLOCKIP);
		return $this->db->insert_id();
	}
	
	function deleteFailureAttemp(){
		$this->db->where('ip',$this->geo_lib->getIpAddress())->delete(TBL_BLOCKIP);
	}
	
//end class	 
}