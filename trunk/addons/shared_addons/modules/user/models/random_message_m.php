<?php defined('BASEPATH') or exit('No direct script access allowed');

class Random_message_m extends MY_Model {
	function __construct(){
		parent::__construct();
	}
	
	function getRandomMessage($id_user,$offset=0,$records_p_page=0){
		$sql = "SELECT * FROM ".TBL_RANDOM_MESSAGE." WHERE id_user_from=$id_user ORDER BY id_random_message DESC";
		
		if($records_p_page != 0){
			$sql .= " LIMIT $offset,$records_p_page";	
		}
		 
		return $this->db->query($sql)->result();
	}	
	
	
//endclass
}	