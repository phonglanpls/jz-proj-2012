<?php defined('BASEPATH') or exit('No direct script access allowed');

class Mapflirt_m extends MY_Model {
	function __construct(){
		parent::__construct();
	}
	
	function wasIMapedUser($id_user){
		$sql = "SELECT * FROM " . TBL_MAP_HISTORY . " WHERE id_buyer = " . getAccountUserId() . 
				" AND buy_date > SUBDATE(NOW(), map_days) AND id_seller =$id_user";
		$result = $this->db->query($sql)->result();
		return ($result)?true:false;
	}
	
	function getListMyMapFlirts(){
		$sql_block = "SELECT GROUP_CONCAT(blocked_user) as blocked_user FROM " . TBL_BLOCKED_LIST . " WHERE id_user='" . getAccountUserId() . 
				"' AND (blocked_type = '" . $GLOBALS['global']['BLOCK_TYPE']['map'] . 
				"' )";
		$block_users = $this->db->query($sql_block)->result();
		
		if ($block_users AND $block_users[0]->blocked_user != '') {
			$cond = " AND id_seller NOT IN(" . $block_users[0]->blocked_user . ")";
		}else{
			$cond = '';
		}
		 
		$sql = "SELECT * FROM " . TBL_MAP_HISTORY . " WHERE id_buyer = " . getAccountUserId() . 
				" AND map_days > SUBDATE(NOW(), buy_date) $cond";
		return 	$this->db->query($sql)->result();
	}
	
	function getHistory($id_seller){
		$res= $this->db->where('id_seller',$id_seller)->where('id_buyer',getAccountUserId())->get(TBL_MAP_HISTORY)->result();
		return ($res)?$res[0]:false;
	}
	
	function saveMapFlirtSearch($input){
		$mysearch = $this->db->where('id_user', getAccountUserId())->get(TBL_MAPFLIRT_SEARCH)->result();
		
		$arr['id_user'] = getAccountUserId();
		$arr['datetime'] = mysqlDate();
		
		$arr['gender'] = $input['gen'];
		$arr['age_from'] = $input['agefrom'];
		$arr['age_to'] = $input['ageto'];
		$arr['distance'] = $input['distance'];
		$arr['country'] = $input['country_name'];
		$arr['status'] = $input['status'];
		$arr['map'] = $input['mapvalue'];
		$arr['photo'] = $input['photo'];
		
		if(!$mysearch){
			$this->mod_io_m->insert_map($arr, TBL_MAPFLIRT_SEARCH);
		}else{
			$this->mod_io_m->update_map($arr, array('id_mapflirt_search'=>$mysearch[0]->id_mapflirt_search), TBL_MAPFLIRT_SEARCH);
		}
	}
	
	function search_mapflirt($input){
		$userdataobj = getAccountUserDataObject(true);
		
		$this->saveMapFlirtSearch($input);
		
		$sql_block = "SELECT GROUP_CONCAT(blocked_user) as blocked_user FROM " . TBL_BLOCKED_LIST . " WHERE id_user='" . getAccountUserId() . 
				"' AND (blocked_type = '" . $GLOBALS['global']['BLOCK_TYPE']['map'] . 
				"' OR blocked_type = '" . $GLOBALS['global']['BLOCK_TYPE']['everything'] . "')";
		$block_users = $this->db->query($sql_block)->result();
		
		$sql = "SELECT id_user,username,photo,gender,address,city,state,country,
					floor(datediff(now(),dob)/365.25) as age,longitude,latitude,if(rating,round(rating/rate_num),0) as rate,map_access 
					FROM " . TBL_USER . " 
					WHERE id_user!='" . getAccountUserId() . 
					"' AND id_admin=0 AND loc_flag=1 AND status=0 AND random_num='0' AND latitude IS NOT NULL AND longitude IS NOT NULL AND address IS NOT NULL AND address!=''";
		
		if ($block_users AND $block_users[0]->blocked_user != '') {
			$sql .= " AND id_user NOT IN(" . $block_users[0]->blocked_user . ")";
		}
		
		if ($input['distance'] != 0) {
			$lat  = $this->geo_lib->change_in_latitude($input['distance']);
			$long = $this->geo_lib->change_in_longitude($userdataobj->latitude, $input['distance']);
			
			$latitude1  = $userdataobj->latitude + $lat;
			$latitude2  = $userdataobj->latitude - $lat;
			$longitude1 = $userdataobj->longitude + $long;
			$longitude2 = $userdataobj->longitude - $long;
			$sql	.=	" AND latitude BETWEEN " . $latitude2 . " AND " . $latitude1 .
						" AND longitude BETWEEN " . $longitude2 . " AND " . $longitude1 . "";
		}
		if ($input['gen']) {
			if ( strtolower($input['gen']) == 'both') {
				$sql .=" AND (gender='male' OR gender='female') ";
			} else {
				$sql .=" AND gender ='" . $input['gen'] . "' ";
			}
		}
		if ($input['country_name']) {
			$sql .=" AND country='" . $input['country_name'] . "'";
		}
		if ($input['agefrom']) {
			$sql .=" AND (age BETWEEN " . $input['agefrom'] . " AND " . $input['ageto'] . ")";
		}
		if ($input['mapvalue']) {
			$sql .=" AND (map_access < " . $input['mapvalue'] . ")";
		}
		if ($input['status'] == "1") {
			//$sql .=" AND id_user IN (SELECT id_user FROM " . TBL_ONLINE . " WHERE 1 GROUP BY id_user)";
            $sql .=" AND ( lastactivity +60 >= UNIX_TIMESTAMP() ) ";
		}
		
		if (isset($input['photo']) AND $input['photo'] == "1") {
			$sql .=" AND (photo IS NOT NULL AND photo != '' ) ";
		}
		$sql .=" ORDER BY id_user DESC";
		 
		return $this->db->query($sql)->result();
	}	
	
	function getListYouBoughtOthersHistory(){
		$sql = "SELECT m.*,u.id_user,u.username,u.first_name,u.last_name,u.timezone,u.map_access,if(m.exp_date > NOW(),(TIMESTAMPDIFF(HOUR,NOW(),m.exp_date)),0) as time_left 
				FROM " . TBL_MAP_HISTORY . " m LEFT JOIN " . TBL_USER . " u ";
		$sql .= " ON m.id_seller=u.id_user WHERE m.id_buyer=" . getAccountUserId() . "  ORDER BY buy_date DESC ";
		return $this->db->query($sql)->result();
	}
	
	function getListOthersBoughtYouHistory(){
		$sql = "SELECT m.*,u.id_user,u.username,u.first_name,u.last_name,u.timezone,u.map_access,if(m.exp_date > NOW(),(TIMESTAMPDIFF(HOUR,NOW(),m.exp_date)),0) as time_left 
				FROM " . TBL_MAP_HISTORY . " m LEFT JOIN " . TBL_USER . " u ";
		$sql .= " ON m.id_buyer=u.id_user WHERE m.id_seller=" . getAccountUserId() . "  ORDER BY buy_date DESC ";
		return $this->db->query($sql)->result();
	}
	
	function getAccessMapActiveInfo(){
		$sql = "SELECT * FROM " . TBL_MAP_HISTORY . " WHERE id_buyer = " . getAccountUserId() . 
				" AND exp_date > NOW() ";
		$sql2 = "SELECT * FROM " . TBL_MAP_HISTORY . " WHERE id_seller = " . getAccountUserId() . 
				" AND exp_date > NOW() ";		
		$res = $this->db->query($sql)->result();
		$res2 = $this->db->query($sql2)->result();		
		
		$i_bought = $other_bought = 0;
		if($res){
			$i_bought = count($res);
		}
		
		if($res2){
			$other_bought = count($res2);
		}
		return array('i_bought_other'=>$i_bought, 'other_bought'=>$other_bought);
	}
	
	function checkUserBlockedOther($user_id, $other_id){
		$sql_block = "SELECT * FROM " . TBL_BLOCKED_LIST . " WHERE blocked_user='" . $user_id . 
				"' AND blocked_type = '" . $GLOBALS['global']['BLOCK_TYPE']['map'] . 
				"' AND id_user = '$other_id' ";
		$block = $this->db->query($sql_block)->result();
		return ($block)?$block[0]:false;
	}
	
	
	
	
	
	
	
//endclass
}