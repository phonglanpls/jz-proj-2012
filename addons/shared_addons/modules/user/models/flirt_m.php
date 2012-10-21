<?php defined('BASEPATH') or exit('No direct script access allowed');

class Flirt_m extends MY_Model {
	function __construct(){
		parent::__construct();
	}
	
	function getFlirtsReceived(){
		$sql = "SELECT f.*,TIMEDIFF(NOW(),f.send_date) days,
						UNIX_TIMESTAMP(NOW())-UNIX_TIMESTAMP(f.send_date) AS time_diff,
						u1.first_name as sender_fname,
						u1.last_name as sender_lname,
						u1.username as uname_sender,
						u1.dob as dob,u1.photo as photo,
						u1.gender as gender,u1.age as age,
						u1.status as status,u2.username as uname_receiver 
				FROM ".TBL_FLIRT." f LEFT JOIN ".TBL_USER." u1 on f.id_sender=u1.id_user 
				LEFT JOIN ".TBL_USER." u2 on f.id_receiver=u2.id_user";
		$sql .=" WHERE id_receiver=".getAccountUserId()." AND u1.status=0 ORDER BY send_date DESC";
		return $this->db->query($sql)->result();		
	}
	
	function getFlirtsGiven(){
		$sql = "SELECT f.*,TIMEDIFF(NOW(),f.send_date) days,
						UNIX_TIMESTAMP(NOW())-UNIX_TIMESTAMP(f.send_date) AS time_diff,
						u1.first_name as sender_fname,
						u1.last_name as sender_lname,
						u1.username as uname_receiver,
						u1.dob as dob,u1.photo as photo,
						u1.gender as gender,
						u1.age as age,u1.status as status,
						u2.username as uname_sender 
				FROM ".TBL_FLIRT." f LEFT JOIN ".TBL_USER." u1 on f.id_receiver=u1.id_user 
				LEFT JOIN ".TBL_USER." u2 on f.id_sender=u2.id_user";
		$sql .=" WHERE id_sender=".getAccountUserId()." AND u1.status=0 ORDER BY send_date DESC";
		return $this->db->query($sql)->result();
	}
	
	
//endclass
}	