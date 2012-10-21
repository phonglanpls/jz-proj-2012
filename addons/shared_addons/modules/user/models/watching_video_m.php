<?php defined('BASEPATH') or exit('No direct script access allowed');

class Watching_video_m extends MY_Model {
	function __construct(){
		parent::__construct();
	}
	
	function getUserWatchingVideoOnline($video_id, $timeDelay=30){
	/*
		return $this->db->where('video_id',$video_id)->where('timestamp >=',time() - $timeDelay)
						->order_by('timestamp', 'DESC')->get(TBL_WATCHING_VIDEO)->result();
						*/
		return $this->db->query("SELECT DISTINCT(user_id) FROM ".TBL_WATCHING_VIDEO.
								" WHERE video_id=$video_id ORDER BY timestamp DESC LIMIT 5")->result();				
	}	
	
	function updateWatchingStatus($video_id){
		$checkdata = $this->db->where('video_id',$video_id)->where('user_id',getAccountUserId())->get(TBL_WATCHING_VIDEO)->result();
		if($checkdata){
			$update['timestamp'] = time();
			$this->mod_io_m->update_map($update, array('watching_video_id'=>$checkdata[0]->watching_video_id), TBL_WATCHING_VIDEO);
		}else{
			$data['user_id'] =  getAccountUserId();
			$data['timestamp'] =  time();
			$data['video_id'] =  $video_id;
			$this->mod_io_m->insert_map($data, TBL_WATCHING_VIDEO); 	
		}
	}
	
//endclass	
}