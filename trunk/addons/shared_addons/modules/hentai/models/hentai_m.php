<?php defined('BASEPATH') or exit('No direct script access allowed');

class Hentai_m extends MY_Model {
	function __construct(){
		parent::__construct();
	}
	
	function getCategories(){
		return $this->db->where('status',1)->order_by('id_hentai_category','asc')->get(TBL_HENTAI_CATEGORY)->result();
	}
	
	function getVideoCategory($id_category,$offset=0,$records_per_page=0){
		if($records_per_page){
			return $this->db->where('id_hentai_category',$id_category)->where('img_url !=','')->order_by('last_update','DESC')->order_by('name','ASC')
					->limit($records_per_page,$offset)->get(TBL_SERIES)->result();
		}
		return $this->db->where('id_hentai_category',$id_category)->where('img_url !=','')->order_by('last_update','DESC')->get(TBL_SERIES)->result();
	}
	
	function getAllSeriesVideo($serie_id){
		$seriesdata = $this->mod_io_m->init('id_series',$serie_id,TBL_SERIES);
        if( $seriesdata->id_hentai_category == 1){
            //facebook
            return $this->db->where('id_series',$serie_id)->order_by('id_video','asc')->get(TBL_VIDEO)->result();
        }
        if( $seriesdata->id_hentai_category == 4 ){
            //dailymotion
            return $this->db->where('id_series',$serie_id)->order_by('id_video','asc')->get(TBL_VIDEO)->result();
        }
	}
	
	function getFacebookVideoSource($id_video){
		$videodata = $this->mod_io_m->init('id_video',$id_video,TBL_VIDEO);
		if($videodata ){
			if($videodata->video_url){
				$video_url = "http://www.facebook.com/video/video.php?v=";
				$id = strstr($videodata->video_url,$video_url); 
				if($id){
					$parsed_url = parse_url($videodata->video_url);
					parse_str($parsed_url['query'], $parsed_query);
					if($parsed_query['v']){
						$page = @urldecode(file_get_contents("http://www.facebook.com/video/external_video.php?v=".$parsed_query['v']));
						$res['video_url'] = stripslashes($this->extract_unit($page, '"video_src":"', '"'));
					}
				}
				return $res['video_url']; 
			}
		}else{
			return false;
		}		
	}
	
	function extract_unit($string, $start, $end) {
		$pos = stripos($string, $start);
		$str = substr($string, $pos);
		$str_two = substr($str, strlen($start));
		$second_pos = stripos($str_two, $end);
		$str_three = substr($str_two, 0, $second_pos);
		$unit = trim($str_three); // remove whitespaces
		return $unit;
    }
	
	
	
	
	
	
	
	
//endclass
}	