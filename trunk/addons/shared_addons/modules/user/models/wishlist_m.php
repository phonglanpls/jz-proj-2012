<?php defined('BASEPATH') or exit('No direct script access allowed');

class Wishlist_m extends MY_Model {
	function __construct(){
		parent::__construct();
	}
	
	function fetchMyWishlist($id_owner){
		$sql = "SELECT f.*,p.lockstatus 
				FROM (
					SELECT u.cur_value,u.username,u.id_user,u.photo,u.gender,u.owner,u.cash,w.id_user as flg,
							u1.username as ownername,u1.id_user as idowner 
					FROM ".TBL_USER." u LEFT JOIN ".TBL_USER." u1 ON(u.owner=u1.id_user)
					, ".TBL_WISHLIST." w 
					WHERE (u.id_user=w.id_user and w.id_owner=".$id_owner.")  
					AND u.id_user NOT IN(SELECT id_user from ".TBL_PET." where id_owner=".$id_owner.")) 
					as f LEFT JOIN ".TBL_PET." p ON f.id_user=p.id_user Order by f.flg DESC";
		return $this->db->query($sql)->result();
		//return $this->db->where('id_owner',$id_owner)->order_by('id_wishlist','desc')->get(TBL_WISHLIST)->result();
	}
	
	function seekWishListRecord($id_owner,$id_user){
		$wishlistdata = $this->db->where('id_owner', $id_owner)
								->where('id_user',$id_user)
								->get(TBL_WISHLIST)->result();
		return 	$wishlistdata ? $wishlistdata[0]:false;					
	}
	
	function addToWishList(){
		$id_user = $this->input->get('id_user',0);
		$wishlistdata = $this->seekWishListRecord($owner_id = getAccountUserId(), $id_user);
		
		if(!$wishlistdata){
			$data['id_owner'] = $owner_id;
			$data['id_user'] = $id_user;
			$data['date'] = mysqlDate();
			$data['ip'] = $this->geo_lib->getIpAddress();
			$this->mod_io_m->insert_map($data, TBL_WISHLIST); 		
		}	
		echo "<a href=\"javascript:void(0);\" onclick=\"callFuncRemoveFromWishList($id_user);\">
				".language_translate('wishlist_remove_label')."
			</a>";
		exit;	
	}
	
	function removeFromWishList(){
		$id_user = $this->input->get('id_user',0);
		$wishlistdata = $this->seekWishListRecord($owner_id = getAccountUserId(), $id_user);
		if($wishlistdata){
			$this->db->where('id_owner', getAccountUserId())
						->where('id_user',$id_user)->delete(TBL_WISHLIST);
		}
		echo "<a href=\"javascript:void(0);\" onclick=\"callFuncAddToWishListThisPet($id_user);\">
				".language_translate('wishlist_addto')."
			</a>";
		exit;	
	}
	
	function remove($id_user){
		$wishlistdata = $this->seekWishListRecord($owner_id = getAccountUserId(), $id_user);
		if($wishlistdata){
			$this->db->where('id_owner', getAccountUserId())
						->where('id_user',$id_user)->delete(TBL_WISHLIST);
		}
	}
	
	
	
	
	
	
	
	
//endclass
}	