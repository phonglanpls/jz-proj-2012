<?php defined('BASEPATH') or exit('No direct script access allowed');

class Peep_m extends MY_Model {
	function __construct(){
		parent::__construct();
	}
	
	function showPeep($id_user,$search_type='', $sort_by='', $offset=0,$records_p_page=0){
		
		if($search_type == 'normal_photo') {
			$sql = "SELECT i.id_image,i.id_user,i.image,COUNT(*) AS rate_num,ROUND(i.rating/i.rate_num) AS rating,r.id_whom,r.rate_type,r.rate,r.rate_date FROM ".TBL_GALLERY." i,".
					TBL_RATE." r WHERE i.id_image=r.id_whom AND i.id_user='".$id_user."' AND i.rate_num!=0 AND i.rating!=0 AND rate_type='1' AND i.is_deleted=0 AND i.image_type=0";
			$field_name = " r.id_whom";
			$group_by = " GROUP BY res.id_whom";
		}else if($search_type == 'backstage_photo'){
			$sql = "SELECT i.id_image,i.id_user,i.image,COUNT(*) AS rate_num,ROUND(i.rating/i.rate_num) AS rating,r.id_whom,r.rate_type,r.rate,r.rate_date FROM ".TBL_GALLERY." i,".
					TBL_RATE." r WHERE i.id_image=r.id_whom AND i.id_user='".$id_user."' AND i.rate_num!=0 AND i.rating!=0 AND rate_type='4'  AND i.is_deleted=0 AND i.image_type=1";
			$field_name =" r.id_whom";
			$group_by =" GROUP BY res.id_whom";			
		}else{
			$sql = "SELECT c.*,SUM(c.num_count) AS number_count,MAX(c.last_visit) AS lvisit,u.username,u.photo,u.gender FROM ".TBL_CHECKED." c,".
					TBL_USER." u WHERE c.id_visitor=u.id_user AND c.id_user='".$id_user."' ";
			$field_name =" c.id_visitor ";
		}
		
		if($search_type != 'checked_me'){
			$date = 'r.rate_date';
		}else{
			$date = 'c.last_visit';
		}
		
		if( $sort_by == 'today' ) {
			$sql .= " AND DATE($date) = DATE(NOW()) GROUP BY $field_name";
		}else if( $sort_by == 'yesterday' ) {
			$sql .= " AND DATE($date) BETWEEN  DATE(DATE_SUB(NOW(),INTERVAL 1 DAY)) AND DATE(NOW()) GROUP BY $field_name";
		}else if( $sort_by == 'week' ) {
			$sql .= " AND DATE($date) BETWEEN  DATE(DATE_SUB(NOW(),INTERVAL 7 DAY)) AND DATE(NOW()) GROUP BY $field_name";
		}else if( $sort_by == 'month' ){
			$sql .=" AND DATE($date) BETWEEN  DATE(DATE_SUB(NOW(),INTERVAL 30 DAY)) AND DATE(NOW()) GROUP BY $field_name";
		}else{
			$sql .=" AND DATE($date) BETWEEN  DATE(DATE_SUB(NOW(),INTERVAL 365 DAY)) AND DATE(NOW()) GROUP BY $field_name";
		}
		
		if($search_type == 'normal_photo' OR $search_type == 'backstage_photo' ){
			$sql = " SELECT * FROM(".$sql." ORDER BY $date DESC) AS res".$group_by;
		}else{
			$sql .= " ORDER BY $date DESC ";	
		}
		
		if($records_p_page != 0){
			$sql .= " LIMIT $offset,$records_p_page";	
		}
		 
		return $this->db->query($sql)->result();
	}
	
	
	
	
	
	
	
//endclass
}	