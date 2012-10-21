<?php defined('BASEPATH') or exit('No direct script access allowed');

class Gift_m extends MY_Model {
	function __construct(){
		parent::__construct();
	}
	
	function getGiftCategories(){
		return $this->db->where('status','1')->order_by('id_category')->get(TBL_CATEGORY)->result();
	}
	
	function listGiftsOfCategory($id_category,$offset=0,$records_p_page=0){
		if($records_p_page){
			if($id_category == 0){
				return $this->db->where('status','1')
				->order_by('add_date','desc')->limit($records_p_page,$offset)->get(TBL_GIFT)->result();
			}else{
				return $this->db->where('status','1')->where('id_category',$id_category)
				->order_by('add_date','desc')->limit($records_p_page,$offset)->get(TBL_GIFT)->result();
			}	
		}else{
			if($id_category == 0){
				return $this->db->where('status','1')
				->order_by('add_date','desc')->get(TBL_GIFT)->result();
			}else{
				return $this->db->where('status','1')->where('id_category',$id_category)
				->order_by('add_date','desc')->get(TBL_GIFT)->result();
			}	
		}			
	}
	
	function getAllUserGifts($id_receiver,$offset=0,$rec_per_page=0){
		//return $this->db->where('id_reciever',$id_receiver)->order_by('add_date','DESC')->get(TBL_GIFT)->result();
		if($rec_per_page){
			$cond = " LIMIT $offset,$rec_per_page";
		}else{
			$cond = "";
		}
		 
		return $this->db->query("SELECT B.*,G.price FROM ".TBL_GIFTBOX." B,".TBL_GIFT." G WHERE B.id_reciever=$id_receiver AND G.status=1 AND B.id_gift=G.id_gift ORDER BY add_date DESC $cond")
				->result();
	}
	
	
	
	
//endclass
}	