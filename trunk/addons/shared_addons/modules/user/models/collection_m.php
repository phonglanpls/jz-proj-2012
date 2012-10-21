<?php defined('BASEPATH') or exit('No direct script access allowed');

class Collection_m extends MY_Model {
	function __construct(){
		parent::__construct();
	}
	
	function getCollectionPhoto(){
		$image_type = $GLOBALS['global']['IMAGE_STATUS']['private'];
		$sql = "SELECT u.id_user as ownerid,u.username,u.first_name,u.last_name,c.*,g.image,g.id_wall,g.comment FROM ".TBL_GALLERY." g,"
				.TBL_COLLECTION." c,".TBL_USER." u where c.id_image=g.id_image and g.id_user=u.id_user and c.id_user=".getAccountUserId()
				." AND c.coll_type=".$GLOBALS['global']['COLLECTION_TYPE']['photo']." AND g.image_type=$image_type ORDER BY c.id_image ASC" ;
		return $this->db->query($sql)->result();
	}	
	
	function getMyPhoto(){
		return $this->db->where('id_user',getAccountUserId())->where('image_type',$GLOBALS['global']['IMAGE_STATUS']['public'])->where('is_deleted',0)
				->order_by('added_date','desc')->get(TBL_GALLERY)->result();	
	}
	
	function getPublicPhotos($id_user){
		return $this->db->where('id_user',$id_user)->where('image_type',$GLOBALS['global']['IMAGE_STATUS']['public'])->where('is_deleted',0)
				->order_by('added_date','desc')->get(TBL_GALLERY)->result();	
	}
	
	function getUserCollectionPhotos($id_user){
		$sql = "SELECT u.id_user as ownerid,u.username,u.first_name,u.last_name,c.*,g.image,g.id_wall,g.comment FROM ".TBL_GALLERY." g,"
				.TBL_COLLECTION." c,".TBL_USER." u where c.id_image=g.id_image and g.id_user=u.id_user and c.id_user=".$id_user
				." AND c.coll_type=".$GLOBALS['global']['COLLECTION_TYPE']['photo']." ORDER BY c.id_image ASC" ;
		return $this->db->query($sql)->result();
	}
	
	function isMyCollectionPhoto($id_image){
		$sql = "SELECT u.id_user as ownerid,u.username,u.first_name,u.last_name,c.*,g.image,g.id_wall,g.comment FROM ".TBL_GALLERY." g,"
				.TBL_COLLECTION." c,".TBL_USER." u where c.id_image=g.id_image and g.id_user=u.id_user and c.id_user=".getAccountUserId()
				." AND c.coll_type=".$GLOBALS['global']['COLLECTION_TYPE']['photo']." AND g.id_image=$id_image" ;
		return ( $this->db->query($sql)->result() ) ? true:false;
	}
	
	function deleteCollectionPhoto($id_coll){
		$this->db->where('id_collection',$id_coll)->where('id_user',getAccountUserId())->delete(TBL_COLLECTION); 
	}
	
	function deleteMyPhoto($id_photo){
		//$this->db->query("UPDATE ".TBL_GALLERY." SET is_deleted=1 WHERE id_image=$id_photo AND id_user=".getAccountUserId());
		$gallerydataobj = $this->gallery_io_m->init('id_image',$id_photo);
		
		if($gallerydataobj->prof_flag == 1){
			return false;
		}
		
		if( $gallerydataobj->id_wall AND $gallerydataobj->image_type == $GLOBALS['global']['IMAGE_STATUS']['public']){
			$uploadDir  = APP_ROOT.$GLOBALS['global']['IMAGE']['wall_image_orig'];
			$thumbnailDir = APP_ROOT.$GLOBALS['global']['IMAGE']['wall_image_thumb'];
			$walldataobj = $this->mod_io_m->init('id_wall',$gallerydataobj->id_wall, TBL_WALL);		
		}else{
			$uploadDir  = APP_ROOT.$GLOBALS['global']['IMAGE']['image_orig']."photos/";
			$thumbnailDir = APP_ROOT.$GLOBALS['global']['IMAGE']['image_thumb']."photos/";
			$walldataobj = $this->mod_io_m->init('post_id',$gallerydataobj->id_image, TBL_WALL);		
		}
		
		if($walldataobj){
			if($walldataobj->id_parent == 0){
				$this->db->query( "DELETE FROM ".TBL_POST_INFO." WHERE id_post =".$walldataobj->id_wall);
				$this->db->query( "DELETE FROM ".TBL_RATE." WHERE id_whom =".$walldataobj->id_wall );
				
				foreach($this->db->where('id_parent',$walldataobj->id_wall)->get(TBL_WALL)->result() as $item){
					if($item->image AND $item->image_status ==0) {
						@unlink(APP_ROOT.$GLOBALS['global']['IMAGE']['wall_image_orig'].$item->image);
						@unlink(APP_ROOT.$GLOBALS['global']['IMAGE']['wall_image_thumb'].$item->image);	
					}	
				}
			}
			
			$this->db->query( "DELETE FROM ".TBL_WALL." WHERE id_wall ='".$walldataobj->id_wall."'OR id_parent = ".$walldataobj->id_wall);
		}
	
		@unlink($uploadDir.$gallerydataobj->image);
		@unlink($thumbnailDir.$gallerydataobj->image);
		
		$this->db->where('id_image',$id_photo)->delete(TBL_GALLERY);
		$this->db->where('id_wall',$id_photo)->delete(TBL_PHOTO_COMMENT);
		
		return true;
	}
	
	
	
//endclass
}	