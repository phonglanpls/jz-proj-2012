<?php defined('BASEPATH') or exit('No direct script access allowed');

class Rate_m extends MY_Model {
	function __construct(){
		parent::__construct();
	}
	
	function getPhotoRatedRecord($id_photo){
		$gallerydata = $this->gallery_io_m->init('id_image',$id_photo);
		if($gallerydata->image_type == 0){ // normal photo
			return $this->db->query( "SELECT * FROM ".TBL_RATE." WHERE id_whom=$id_photo 
									AND rate_type=".$GLOBALS['global']['RATING']['wall_image']." " )
						->result();
		}else{ //backstage photo
			return $this->db->query( "SELECT * FROM ".TBL_RATE." WHERE id_whom=$id_photo 
									AND rate_type=".$GLOBALS['global']['RATING']['backstage_photo']." " )
						->result();
		}				
	}
	
	function getRateObject($id_obj, $obj_rate_type, $id_user_get_rated){
		$res = $this->db->query( "SELECT SUM(rate) AS rating,COUNT(*) AS rate_num FROM ".TBL_RATE." WHERE id_whom=".$id_obj
					." AND rate_to='".$id_user_get_rated."' AND rate_type='".$obj_rate_type."' GROUP BY id_whom" )->result();
		if($res){			
			$rate = round($res[0]->rating/$res[0]->rate_num);	
			return array('rating'=>$res[0]->rating, 'rate_num'=>$res[0]->rate_num, 'rate'=>$rate);
		}else{
			return array('rating'=>0, 'rate_num'=>0, 'rate'=>0);
		}		
	}	
	
	function getRateScore($id_obj){
		$res = $this->db->query( "SELECT SUM(rate) AS rating,COUNT(*) AS rate_num FROM ".TBL_RATE." WHERE id_whom=".$id_obj
					." GROUP BY id_whom" )->result();
		if($res){			
			$rate = round($res[0]->rating/$res[0]->rate_num);	
			if($rate>10){
				$rate = 10;
			}
			return $rate;
		}else{
			return 0;
		}	
	}
	
	function wasIRatedThis($id_obj, $obj_rate_type, $id_user_get_rated){
		$res = $this->db->query("SELECT * FROM ".TBL_RATE." WHERE id_whom=$id_obj AND rate_by=".getAccountUserId().
									" AND rate_to=$id_user_get_rated AND rate_type=$obj_rate_type")->result();
		return $res?true:false;							
	}
	
	function ratePhoto($id_photo,$score,$rate_type){
		$gallerydataobj = $this->gallery_io_m->init('id_image',$id_photo);
		 	 	 	 	 	 	
		$data['rate_by'] = getAccountUserId();
		$data['rate_to'] = $gallerydataobj->id_user;
		$data['id_whom'] = $id_photo;
		$data['rate_type'] = $rate_type;//$GLOBALS['global']['RATING']['backstage_photo'];
		$data['rate'] = $score;
		$data['rate_date'] = mysqlDate();		
		$data['ip'] = $this->geo_lib->getIpAddress();
		$this->mod_io_m->insert_map($data,TBL_RATE);
		
		//update image rating record
		$rateArr = $this->getRateObject($id_photo,$data['rate_type'],$data['rate_to']);
		$update['rate_num'] = $rateArr['rate_num'];	
		$update['rating'] = $rateArr['rating'];
		$this->gallery_io_m->update_map($update,$id_photo);
		
		//post to wall
		$array['id_parent'] 	= 0;
		$array['id_user']		= getAccountUserId();
		$array['description']	= slugify( $gallerydataobj->comment );
		$array['add_date_post'] = mysqlDate(); 
		$array['post_name']		=	$score.'_'.filterCharacter( $gallerydataobj->comment );	
		$array['post_id']		= $id_photo;
		$array['post_code']		= ($rate_type == $GLOBALS['global']['RATING']['backstage_photo']) ? 99:100;//	$GLOBALS['global']['CHATTER_CODE']['rating_hentai'];
		$array['rate_num']		= $rateArr['rate_num'];
		$array['rating']		= $rateArr['rating'];
		$id_wall = $this->mod_io_m->insert_map( $array, TBL_WALL );
		
		$this->email_sender->juzonSendEmail_JUZ_PHOTO_RATING($data['rate_by'], $data['rate_to'], $id_photo, $score);
	}
	
	function rateHentai($id_video, $score){
		$videodata = $this->mod_io_m->init('id_video',$id_video,TBL_VIDEO);
		
		$data['rate_by'] = getAccountUserId();
		$data['rate_to'] = 1;
		$data['id_whom'] = $id_video;
		$data['rate_type'] = $GLOBALS['global']['RATING']['hentai'];
		$data['rate'] = $score;
		$data['rate_date'] = mysqlDate();		
		$data['ip'] = $this->geo_lib->getIpAddress();
		$this->mod_io_m->insert_map($data,TBL_RATE);
		
		//update image rating record
		$rateArr = $this->getRateObject($id_video,$data['rate_type'],$data['rate_to']);
		$update['rate_num'] = $rateArr['rate_num'];	
		$update['rating'] = $rateArr['rating'];
		$this->mod_io_m->update_map($update,array('id_video'=>$id_video), TBL_VIDEO);
		
		//insert to wall
		$array['id_parent'] 	= 0;
		$array['id_user']		= getAccountUserId();
		$array['description']	= slugify( $videodata->name );
		$array['add_date_post'] = mysqlDate(); 
		$array['post_name']		= $score.'_'.filterCharacter( $videodata->name );	
		$array['post_id']		= $id_video;
		$array['post_code']		=  $GLOBALS['global']['CHATTER_CODE']['rating_hentai'];
		$array['rate_num']		= $rateArr['rate_num'];
		$array['rating']		= $rateArr['rating'];
		$id_wall = $this->mod_io_m->insert_map( $array, TBL_WALL );
		
		$this->user_io_m->postItemOnFbTt($id_wall,TIMELINE_RATE_VIDEO);
		
	}
	
	
	
	
	
	
	
	
	
	
//endclass
}	