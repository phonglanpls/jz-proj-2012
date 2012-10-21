<?php defined('BASEPATH') or exit('No direct script access allowed');

class Wall_m extends MY_Model {
	function __construct(){
		parent::__construct();
		$this->load->model( 'user/qa_m' );
	}
	
	function get_all_post($result='',$friend='',$city='',$limit='',$my_chat="",$country='',$id_wall=0) {
		$sql_cat = "SELECT group_concat( id_hentai_category ) AS id_cat FROM ".TBL_HENTAI_CATEGORY." WHERE status =0 LIMIT 1";
        $res_cat = $this->db->query($sql_cat)->result();

        if($GLOBALS['global']['HENTAI']['show']=="0"){
            $hide_post="post_code !='".$GLOBALS['global']['CHATTER_CODE']['rating_hentai']."'";
        }else {
            if(strlen($res_cat[0]->id_cat)>0){
				$sql_video = "SELECT GROUP_CONCAT( res.id_wall ) AS id_wall_hentai FROM (SELECT w.id_wall FROM ".TBL_WALL." w, ".
							TBL_VIDEO." v, ".
							TBL_SERIES." s WHERE w.post_id = v.id_video AND v.id_series = s.id_series AND w.post_code =10 AND s.id_hentai_category IN (".$res_cat[0]->id_cat.") ORDER BY w.id_wall DESC LIMIT 20) AS res";

				$hentai_post = $this->db->query($sql_video)->result();

				if(strlen($hentai_post[0]->id_wall_hentai)>0){
					$hide_post = "id_wall NOT IN(".$hentai_post[0]->id_wall_hentai.")";
				}else{
					$hide_post='';
				}
            }else{
                $hide_post='';
            }
        }
		
		$cond = '';
		if($friend) {
			if($friend=="No friends") {
				$cond.=" AND w.id_user IN(".getAccountUserId().")";
			}else {
				$cond.=" AND w.id_user IN($friend,".getAccountUserId().")";
			}
		}

		if($city) {
			if($city=="No city") {
				$cond.=" AND u.country ='".$country."' AND u.id_user!='".getAccountUserId()."'";
			}else {
				$cond.=" AND u.city ='".$city."' AND u.id_user!='".getAccountUserId()."'";
			}
		}

		if($my_chat) {
			$cond.=" AND w.id_user='".$my_chat."'";
		}

		//$sql="SELECT w.id_wall,w.id_parent,w.id_ques,w.description,w.image,w.post_code,w.post_name,w.video,w.rate_flag,ROUND(w.rating/w.rate_num) as rating,TIMEDIFF(NOW(),w.add_date_post) AS add_date,w.action_to,w.trans_type,u.photo,u.id_user,u.username,u.age FROM ".TABLE_PREFIX."wall w LEFT JOIN ".TABLE_PREFIX."user u   ON  u.id_user=w.id_user WHERE 1";

		$sql="SELECT w.id_wall,w.id_parent,w.id_ques,w.description,w.image,w.post_code,w.post_id,w.post_name,w.video,w.image_url,w.rate_flag,ROUND(w.rating/w.rate_num) as rating, UNIX_TIMESTAMP(NOW())-UNIX_TIMESTAMP(w.add_date_post) AS date_diff, TIMEDIFF(NOW(),w.add_date_post) AS add_date,w.action_to,w.trans_type,u.photo,u.gender,u.id_user,u.username,u.age FROM ".TBL_USER." u,".TBL_WALL." w WHERE  w.id_user=u.id_user";
		$sql.=" AND w.id_parent = 0 AND u.status=0 $cond ";

		if($result && !$my_chat) {
			$sql.=" AND u.age BETWEEN '".$result->chat_age_from."' AND '".$result->chat_age_to."'";

			if($result->chat_gender == 'Female') {
				$sql.=" AND u.gender = 'Female'";
			}else if($result->chat_gender == 'Male') {
				$sql.=" AND u.gender = 'Male'";
			}else {
				$sql.=" AND (u.gender ='Male' OR u.gender='Female')";	
			}
		}

        if($hide_post!=''){
            $sql.=" AND ".$hide_post."";
        }
			
		if($id_wall){
			$sql.= " AND id_wall=$id_wall";
		}	
		
		if($limit) {
			$limit = intval($limit);
			$sql.= " ORDER BY id_wall DESC LIMIT $limit,15";
		}else {
			$sql.=" ORDER BY id_wall DESC LIMIT 0,15";
		}

		return $sql;		
	}
	
	function get_all_comment($id_wall,$ids='') {
		if($ids) {
			$ids = $ids;
			$cond = "AND w.id_wall NOT IN($ids)";	 	
		}else {
			$ids ='';
			$cond ="";
		}

		$sql="SELECT w.id_wall,w.id_parent,w.description,w.image,UNIX_TIMESTAMP(NOW())-UNIX_TIMESTAMP(w.add_date_post) AS date_diff,TIMEDIFF(NOW(),w.add_date_post) AS add_date,u.id_user,u.photo,u.username,u.gender 
		      FROM ".TBL_WALL." w,".TBL_USER." u 
		      WHERE  w.id_user=u.id_user AND u.status=0";
		$sql.=" AND w.id_parent = ".$id_wall." $cond ORDER BY id_wall ASC";

		$result = $this->db->query($sql)->result();
		return $result;
	}
		
	function commentAccordingType($obj){
		$desc = $obj->description;
		if(isset($obj->post_name)) {
			$arr = explode('_',$obj->post_name);
		}
		
		if(isset($obj->post_code) AND $obj->post_code == $GLOBALS['global']['CHATTER_CODE']['pet_store']) {
			$data = $this->user_m->buildNativeLink( $obj->username )." "."bought"." ". $this->user_m->buildNativeLink($obj->action_to)." ".$desc; 					
		}else if(isset($obj->post_code) AND $obj->post_code == $GLOBALS['global']['CHATTER_CODE']['pet_locked']) {
			$data = $this->user_m->buildNativeLink( $obj->username )." "."locked"." ".$this->user_m->buildNativeLink($obj->action_to)." ".$desc; 					
		}else if(isset($obj->post_code) AND $obj->post_code == $GLOBALS['global']['CHATTER_CODE']['backstage_photo']) {
			$link = site_url("user/photos/{$obj->post_id}");
			$photo = "<a href='$link'>".$arr[1]."</a>";
			$data = $this->user_m->buildNativeLink( $obj->username )." "."uploaded"." ".$photo." (backstage photo) ".$desc; 					
		}else if(isset($obj->post_code) AND $obj->post_code == 99){
			$link = site_url("user/photos/{$obj->post_id}");
			$photo = "<a href='$link'>".$arr[1]."</a>";
			if($arr[0]<=10){
				$data =$this->user_m->buildNativeLink( $obj->username )." "."rated [".$arr[0]."] ".$photo." (backstage photo)";
			}else{
				$data =$this->user_m->buildNativeLink( $obj->username )." "."rated ".$photo." (backstage photo)";
			}
		}else if(isset($obj->post_code) AND $obj->post_code == 100){
			$link = site_url("user/photos/{$obj->post_id}");
			$photo = "<a href='$link'>".$arr[1]."</a>";
			if($arr[0] <=10){
				$data =$this->user_m->buildNativeLink( $obj->username )." "."rated [".$arr[0]."] ".$photo." (photo)";
			}else{
				$data =$this->user_m->buildNativeLink( $obj->username )." "."rated ".$photo." (photo)";
			}
		}else if(isset($obj->post_code) AND $obj->post_code == $GLOBALS['global']['CHATTER_CODE']['backstage_video']){
			$data = $this->user_m->buildNativeLink( $obj->username )." "."uploaded"." ".$arr[1]." (backstage video) ".$desc;
		}else if(isset($obj->post_code) AND $obj->post_code == $GLOBALS['global']['CHATTER_CODE']['rating_hentai']){
		    $videodata = $this->mod_io_m->init('id_video',$obj->post_id,TBL_VIDEO);
            $slug = ($videodata)?slugify( $videodata->name ):slugify($desc);	  
			$link = "<a href='".site_url("user/hentai/video/{$obj->post_id}/{$slug}")."'>".$arr[1]."</a>";
			if($arr[0] <=10){
				$data = $this->user_m->buildNativeLink( $obj->username )." "."rated [".$arr[0]."] ".$link." (hentai)";
			}else{
				$data = $this->user_m->buildNativeLink( $obj->username )." "."rated ".$link." (hentai)";
			}
		}else if(isset($obj->post_id) AND $obj->image ){
			$uploadPath  = site_url().$GLOBALS['global']['IMAGE']['image_orig']."photos/".$obj->image;
			$size	 = getimagesize(APP_ROOT.$GLOBALS['global']['IMAGE']['image_orig']."photos/".$obj->image);
			if($size[0]>WALL_PHOTO_W){
				$cc = " width='".WALL_PHOTO_W."'";//thumb2($uploadPath, WALL_PHOTO_W, '');
			}else if($size[1]>WALL_PHOTO_H){
				$cc = " height='".WALL_PHOTO_H."'";//thumb2($uploadPath, '', WALL_PHOTO_H);
			}else{
				$cc = '';
			}
			
			$src = $uploadPath;
			$imgLink = site_url().'user/photos/'.$obj->post_id;
			
			$data = "<a href='$imgLink'><img src='$src' $cc /></a><br/>";
			$data .= maintainHtmlBreakLine($obj->description);
		}else {
			if(isset($obj->id_ques) AND $obj->id_ques != 0){
				$questionRecord 	= $this->qa_m->getRecord_Question($obj->id_ques);
				if($questionRecord->asked_by){
					$userdataobj		= $this->user_io_m->init('id_user',$questionRecord->asked_by);
					$data = 'Q: '.$questionRecord->question. ' by '. '<strong>'.$this->user_m->buildNativeLink( $userdataobj->username ).'</strong>';
				}else{
					$data = 'Q: '.$questionRecord->question. ' by '. '<strong>Anonymous</strong>';
				}
				$data .= '<br/>';
				$data .= 'A: '.$obj->description;
			}else{
				$data = maintainHtmlBreakLine($obj->description);
			}
		}
		
		return $data;
	}	
	
	function getLikeInfo($id_wall){
		$sql = "SELECT * FROM ".TBL_POST_INFO." WHERE id_post = '".$id_wall."' AND id_usr ='".getAccountUserId()."' LIMIT 1";
		$post_info = $this->db->query($sql)->result();
		
		$res = array();
		if($post_info) {
			if($post_info[0]->photo_rating) {
				$res['photo_rating'] = 1;
			}else {
				$res['photo_rating'] = 0;
			}

			if($post_info[0]->p_like) {
				$res['p_like'] = 1;
			}else {
				$res['p_like'] = 0;
			}
		}else {
			$res['photo_rating'] = 0;
			$res['p_like'] = 0;
		}

		$result = $this->db->query(" SELECT * FROM ".TBL_POST_INFO." WHERE id_post = '".$id_wall."' AND p_like=1")->result();		
		if($result) {
			$res['like_num'] = count($result);
		}else {
			$res['like_num'] = 0;
		}
		
		if($res['p_like'] == 1){
			$res['context'] = 'You';
			if($res['like_num']-1 > 0){
				$res['context'] .= " and ".($res['like_num']-1)." people";
			}
			$res['context'] .= " like this.";
			$res['contextme'] = 'Unlike';
		}else{
			if($res['like_num'] >0){
				$res['context'] = $res['like_num'].' people like this.';
			}else{
				$res['context'] = '';
			}	
			$res['contextme'] = 'Like';
		}
		return $res;
	}
	
	function isMyOwnWallFeed($id_wall){
		if(!$id_user = getAccountUserId()){
			return false;
		}
		$rs = $this->db->query("SELECT id_user FROM ".TBL_WALL." WHERE id_wall=$id_wall")->result();
		if($rs[0]->id_user == $id_user){
			return true;
		}
		return false;
	}
	
	function isDeletableCommentFeed($id_wall){
		if(!$id_user = getAccountUserId()){
			return false;
		}
		$rs = $this->db->query("SELECT * FROM ".TBL_WALL." WHERE id_wall=$id_wall")->result();
		if($rs[0]->id_user == $id_user){
			return true;
		}else{
			$parent_id_wall = $rs[0]->id_parent;
			return $this->isMyOwnWallFeed($parent_id_wall);
		}
	}
	
	
	
	
	
//end class	 
}