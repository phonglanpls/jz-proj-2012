<?php defined('BASEPATH') or exit('No direct script access allowed');

class Friend_m extends MY_Model {
	function __construct(){
		parent::__construct();
	}
	
	function isMyFriend($id_user){
		$accept = $GLOBALS['global']['FRIEND_ACTION']['accept'];
		$myid = getAccountUserId();
		$res = $this->db->query("SELECT * FROM ".TBL_FRIENDLIST." WHERE 
							(id_user=$id_user AND request_type=$accept AND friend=$myid) 
							OR (id_user=$myid AND request_type=$accept AND friend=$id_user)"
						)->result();
		return $res?true:false;
	}
	 
	function getAllFriends($user_id=0,$offset=0,$records_p_page=0){
		$accept = $GLOBALS['global']['FRIEND_ACTION']['accept'];
		$cond = "(f.id_user=".$user_id." AND request_type=".$accept.
					" AND f.friend=u.id_user AND u.status=0) OR 
					(friend=".$user_id." AND request_type=".$accept." 
					AND f.id_user=u.id_user AND u.status=0)";
		 
		$sql  = " SELECT f.id_friend,u.*,floor(datediff(now(),u.dob)/365.25) as cal_age FROM ".TBL_FRIENDLIST." f,".TBL_USER." u WHERE ";
		$sql .= $cond;
		//$sql .= " group by f.id_friend ORDER BY f.action_date DESC";
		$sql .= " group by f.id_friend ORDER BY u.lastactivity DESC";
		 	
		if($records_p_page){
			$sql .= " LIMIT ".$offset.",".$records_p_page."";
		}
		$friends = $this->db->query($sql)->result();
		return $friends;
	}
	
	function _search_bycat($user_id=0, $bygroup='', $bygender='', $byage='', $bylocation=''){
		$accept = $GLOBALS['global']['FRIEND_ACTION']['accept'];
		$within = $GLOBALS['global']['RECENT_ADD']['within'];
		$within_days = $GLOBALS['global']['BDAY_ALERT']['upto'];
		
		$gcond = $gecond = $acond = $lcond = null;
		
		$con="(f.id_user=".$user_id." and request_type=".$accept."
		 and f.friend=u.id_user AND u.status=0) or 
		 (friend=".$user_id." and request_type=".$accept." and f.id_user=u.id_user AND u.status=0)";
	 
		if($bygroup){
			if($bygroup == $GLOBALS['global']['FRIEND_BYGROUP']['all friends']){
				$gcond = " ";
			}
			if($bygroup == $GLOBALS['global']['FRIEND_BYGROUP']['recently added']){
				$gcond = " AND f.action_date BETWEEN 
				SUBDATE(NOW(),INTERVAL $within day) AND NOW()";
			}
			if($bygroup == $GLOBALS['global']['FRIEND_BYGROUP']['upcoming birthdays']){
				$gcond = " AND (date_format(dob,'%m%d') between date_format(now(),'%m%d') and 
				date_format(adddate(now(),interval $within_days day),'%m%d'))";
			}
		}
	 
		if($bygender){
			if($bygender == 'Both'){
				$gecond=" ";
			}else{
				$gecond=" AND u.gender='$bygender'";
			}
		}
		 
		if($byage){
			if($byage == 'All'){
				$acond=" ";
			}else{
				if(strpos($byage,'-')){
					$age=explode('-',$byage);
					$acond=" AND floor(datediff(now(),u.dob)/365.25) BETWEEN $age[0] AND $age[1]";
				}else{
					$acond=" AND floor(datediff(now(),u.dob)/365.25) > ".rtrim($byage,'+');
				}
			}
		}
		 
		if($bylocation){
			if($bylocation == 'Anywhere'){
				$lcond=" ";
			}else{
				$res = $this->db->where("country_name",$bylocation)->get(TBL_COUNTRY)->result();
				if($res){
					$lcond=" AND u.country='$bylocation'";
				}else{
					$lcond=" AND u.state='$bylocation'";
				}
			}
		}
	 
		$cond = "($con)".$gcond.$gecond.$acond.$lcond;
		$sql  = " SELECT f.id_friend,u.*,floor(datediff(now(),u.dob)/365.25) as cal_age FROM ".TBL_FRIENDLIST." f,".TBL_USER." u WHERE ";
		$sql .= $cond;
		$sql .= " group by f.id_friend ORDER BY f.action_date DESC";
	  
		$friends = $this->db->query($sql)->result();
		return $friends;		 
	}
	
	function isUserBlockMe($id_user){
		$sql = "SELECT * FROM ".TBL_FRIENDLIST." WHERE id_user=$id_user AND friend=".getAccountUserId().
				" AND request_type='".$GLOBALS['global']['FRIEND_ACTION']['block']."'";
		$res = $this->db->query($sql)->result();
		return $res?$res[0]:false;
	}
	
	function isUserRejectMe($id_user){
		$sql = "SELECT * FROM ".TBL_FRIENDLIST.
				" WHERE ((id_user='".getAccountUserId()."' AND 
				friend='".$id_user."') OR (id_user='".$id_user."' AND 
				friend='".getAccountUserId()."')) AND 
				request_type='".$GLOBALS['global']['FRIEND_ACTION']['reject']."'";
		$res = $this->db->query($sql)->result();
		return $res?$res[0]:false;
	}
	
	function isPendingAddFriend($id_user){
		$sql =  "SELECT * FROM ".TBL_FRIENDLIST.
				" WHERE ((id_user='".getAccountUserId()."' 
				AND friend='".$id_user."') 
				OR (id_user='".$id_user."' AND friend='".getAccountUserId()."'))";
		$res = $this->db->query($sql)->result();
		return $res?$res[0]:false;
	}
	
	function myRequestFriend(){
		$sql =  "SELECT * FROM ".TBL_FRIENDLIST.
				" WHERE id_user='".getAccountUserId()."'
				AND request_type='1'
				";
		$res = $this->db->query($sql)->result();
		return $res;
	}
	
	function getBirthdayList(){
		$within = 2;//$GLOBALS['global']['BDAY_ALERT']['upto'];
		$within = $within-1; //for birthday with current period
		$accept = $GLOBALS['global']['FRIEND_ACTION']['accept'];
		$id  = getAccountUserId();
		$con = "(f.id_user=".$id." AND request_type=".$accept." AND f.friend=u.id_user AND u.status=0) OR (friend=".$id." AND request_type=".$accept." AND f.id_user=u.id_user AND u.status=0)";
	
		$cond = "($con) AND (UNIX_TIMESTAMP(CONCAT(EXTRACT(YEAR FROM IF(EXTRACT(MONTH FROM dob)=1 && EXTRACT(MONTH FROM CURDATE())=12, ADDDATE(NOW(),INTERVAL 1 YEAR),NOW())),'-',EXTRACT(MONTH FROM dob),'-',EXTRACT(DAY FROM dob))) BETWEEN UNIX_TIMESTAMP(DATE_SUB( NOW(),INTERVAL 1 DAY)) AND UNIX_TIMESTAMP(ADDDATE( NOW(),INTERVAL $within DAY)))";
		
		$sql  = "SELECT f.id_friend,u.*,floor(datediff(now(),u.dob)/365.25) as cal_age FROM ".TBL_FRIENDLIST." f,".TBL_USER." u WHERE ";
		$sql .= $cond;
		$sql .= " group by f.id_friend ORDER BY f.action_date DESC";
		
		return $this->db->query($sql)->result();	
	}
	
	function birthdayList(){	// use for crontab
	
		$within = 2;//$GLOBALS['global']['BDAY_ALERT']['upto'];
		$within = $within-1; //for birthday with current period
		  
		$con = " u.status=0";
		$cond = "($con) AND (UNIX_TIMESTAMP(CONCAT(EXTRACT(YEAR FROM IF(EXTRACT(MONTH FROM dob)=1 && EXTRACT(MONTH FROM CURDATE())=12, ADDDATE(NOW(),INTERVAL 1 YEAR),NOW())),'-',EXTRACT(MONTH FROM dob),'-',EXTRACT(DAY FROM dob))) BETWEEN UNIX_TIMESTAMP(DATE_SUB( NOW(),INTERVAL 1 DAY)) AND UNIX_TIMESTAMP(ADDDATE( NOW(),INTERVAL $within DAY)))";
		
		$sql  = "SELECT u.*,floor(datediff(now(),u.dob)/365.25) as cal_age FROM ".TBL_USER." u WHERE ";
		$sql .= $cond;
		//$sql .= " group by u.id_user ORDER BY f.action_date DESC";
		
		return $this->db->query($sql)->result();	
		
	}
	
//end class
}