<?php defined('BASEPATH') or exit('No direct script access allowed');

class Flirts_io_m extends MY_Model {
	function __construct(){
		parent::__construct();
	}
	
	function deleteFlirt(){
		$id_flirt = $this->input->post('id_flirt');
		$flirtdataobj = $this->mod_io_m->init('id_flirt',$id_flirt,TBL_FLIRT);
		
		if($flirtdataobj->id_sender == getAccountUserId() OR $flirtdataobj->id_receiver == getAccountUserId()){
			$this->db->where('id_flirt',$id_flirt)->delete(TBL_FLIRT);
		}
		exit;
	}
	
	
	
	
	
	
//endclass
}	