<?php defined('BASEPATH') or exit('No direct script access allowed');

class Peepbought_history_m extends MY_Model {
	function __construct(){
		parent::__construct();
	}
	
	function wasIBoughtPeepedUser($id_user){
		$sql = "SELECT * FROM " . TBL_PEEPBOUGHT_HISTORY . " WHERE id_buyer = " . getAccountUserId() . 
				" AND buy_date > SUBDATE(NOW(), access_days) AND id_user =$id_user";
		$result = $this->db->query($sql)->result();
		return ($result)?$result[0]:false;
	}
	
	function peepedList($id_user){
		$sql = "SELECT * FROM " . TBL_PEEPBOUGHT_HISTORY . " WHERE id_buyer = $id_user
				 AND buy_date > SUBDATE(NOW(), access_days) ";
		$result = $this->db->query($sql)->result();
		return $result;
	}
	
	function myPeeeps($id_user){
		$sql = "SELECT c.*,SUM(c.num_count) AS number_count,MAX(c.last_visit) AS lvisit,u.username,u.photo,u.gender FROM ".TBL_CHECKED." c,".
					TBL_USER." u WHERE c.id_user=u.id_user AND c.id_visitor='".$id_user."' AND c.id_user !=1 GROUP BY c.id_user ORDER BY last_visit DESC";
		$result = $this->db->query($sql)->result();
		return $result;
	}
	
	
	
	
//endclass
}	