<?php defined('BASEPATH') or exit('No direct script access allowed');
error_reporting(E_ALL ^ E_NOTICE);

class Xls_io_m extends MY_Model {
	function __construct(){
		parent::__construct();
		require_once(ADDON_FOLDER.'shared_addons/libraries/Excel_reader2.php');
	}
	
	function toDb(){
		$data = new Spreadsheet_Excel_Reader("./media/hti-dm2.xls");
		$rowNumber = $data->rowcount($sheet_index=0);
		$colNumber = $data->colcount($sheet_index=0);
		
		$valueArray = array();
		
		$j=0;
		for($i=0;$i<=$rowNumber;$i++){
			if( $id = $data->val($i,2,$sheet=0) AND $this->phpvalidator->is_url( $data->val($i,6,$sheet=0) ) ){
				$j +=1;
				$valueArray[$j]['ID'][] = $id;
			}
			
			if( $seriesName = $data->val($i,3,$sheet=0) AND $this->phpvalidator->is_url( $data->val($i,6,$sheet=0) ) ){
				$valueArray[$j]['seriesName'][] = $seriesName;
			}
			
			if( $episodeName = $data->val($i,5,$sheet=0) AND $this->phpvalidator->is_url( $data->val($i,6,$sheet=0) ) ){
				$valueArray[$j]['episodeName'][] = $episodeName;
			}
			
			if( $link = $data->val($i,6,$sheet=0) AND $this->phpvalidator->is_url( $data->val($i,6,$sheet=0) ) ){
				$valueArray[$j]['link'][] = $link;
			}
			 
		}
		
		//var_dump($valueArray);
		
		foreach($valueArray as $key=>$array){
			$seriesName = $array['seriesName'][0];
			$seriesdata = array();
			 	 	 	 	 	 	 	
			$seriesdata['id_hentai_category'] = 4;
			$seriesdata['code_series'] = NULL;
			$seriesdata['name'] = $seriesName;
			$seriesdata['image'] = strtolower( str_replace(array(' ','-','_'), array('-','-','-'), $seriesName) );
			$seriesdata['img_url'] = $this->getThumbnail($array['link'][0]);
			$seriesdata['add_date'] = mysqlDate();
			$seriesdata['last_update'] = mysqlDate();
			$seriesdata['ip'] = $this->geo_lib->getIpAddress();
			
			$id_series = $this->mod_io_m->insert_map($seriesdata,TBL_SERIES);
			 
			for( $i=0; $i<count($array['episodeName']); $i++){
				$episodeName = $array['episodeName'][$i];
				$link = $array['link'][$i];
				
				$episodedata = array();
				 	 	 	 	 	 	 	 	 	 	 	
				$episodedata['id_series']  = $id_series;
				$episodedata['code_video']  = strtolower( str_replace(array(' ','-','_'), array('','',''), $episodeName) );
				$episodedata['name']  = $episodeName;
				$episodedata['video_url']  = $link;
				$episodedata['img_url']  = $this->getThumbnail($link);
				$episodedata['description']  = NULL;
				$episodedata['rating']  = 0;
				$episodedata['rate_num']  = 0;
				$episodedata['view_count']  = 0;
				$episodedata['add_date']  = mysqlDate();
				$episodedata['last_update']  = mysqlDate();
				$episodedata['ip']  = $this->geo_lib->getIpAddress();
				
				$this->mod_io_m->insert_map($episodedata,TBL_VIDEO);
			}
		}
	}
	
	function getThumbnail($link){
		$exp = explode('/',$link);
		$code = $exp[count($exp)-1];
		return "http://www.dailymotion.com/thumbnail/160x120/video/$code";
	}
	
	function delete(){
		$rs = $this->db->query("SELECT GROUP_CONCAT(id_series) AS id FROM ".TBL_SERIES." WHERE id_hentai_category=4")->result();
		$idStr = $rs[0]->id;
		$this->db->query("DELETE FROM ".TBL_VIDEO." WHERE id_series IN($idStr)");
		$this->db->query("DELETE FROM ".TBL_SERIES." WHERE id_series IN($idStr)");
	}
	
	function getvidCode($link){
		$exp = explode('/',$link);
		$code = $exp[count($exp)-1];
		return $code;
	}
	
    function delete_fb(){
        $rs = $this->db->query("SELECT GROUP_CONCAT(id_series) AS id FROM ".TBL_SERIES." WHERE id_hentai_category=1")->result();
		$idStr = $rs[0]->id;
		$this->db->query("DELETE FROM ".TBL_VIDEO." WHERE id_series IN($idStr)");
		$this->db->query("DELETE FROM ".TBL_SERIES." WHERE id_series IN($idStr)");
    }
    
    
    function toDbFB(){
		$data = new Spreadsheet_Excel_Reader("./media/fb.xls");
		$rowNumber = $data->rowcount($sheet_index=0);
		$colNumber = $data->colcount($sheet_index=0);
		
		$valueArray = array();
		
		$j=0;
		for($i=0;$i<=$rowNumber;$i++){
			if( $id = $data->val($i,2,$sheet=0) AND $this->phpvalidator->is_url( $data->val($i,6,$sheet=0) ) ){
				$j +=1;
				$valueArray[$j]['ID'][] = $id;
			}
			
			if( $seriesName = $data->val($i,3,$sheet=0) AND $this->phpvalidator->is_url( $data->val($i,6,$sheet=0) ) ){
				$valueArray[$j]['seriesName'][] = $seriesName;
			}
            
            if( $seriesThumb = $data->val($i,4,$sheet=0) AND $this->phpvalidator->is_url( $data->val($i,6,$sheet=0) ) ){
				$valueArray[$j]['seriesThumb'][] = $seriesThumb;
			}
			
			if( $episodeName = $data->val($i,5,$sheet=0) AND $this->phpvalidator->is_url( $data->val($i,6,$sheet=0) ) ){
				$valueArray[$j]['episodeName'][] = $episodeName;
			}
			
			if( $link = $data->val($i,6,$sheet=0) AND $this->phpvalidator->is_url( $data->val($i,6,$sheet=0) ) ){
				$valueArray[$j]['link'][] = $link;
			}
			 
		}
		
		//var_dump($valueArray);
		
		foreach($valueArray as $key=>$array){
			$seriesName = $array['seriesName'][0];
			$seriesdata = array();
			 	 	 	 	 	 	 	
			$seriesdata['id_hentai_category'] = 1;
			$seriesdata['code_series'] = NULL;
			$seriesdata['name'] = $seriesName;
			$seriesdata['image'] = NULL;//strtolower( str_replace(array(' ','-','_'), array('-','-','-'), $seriesName) );
			$seriesdata['img_url'] = $array['seriesThumb'][0];//$this->getThumbnail($array['link'][0]);
			$seriesdata['add_date'] = mysqlDate();
			$seriesdata['last_update'] = mysqlDate();
			$seriesdata['ip'] = $this->geo_lib->getIpAddress();
			
			$id_series = $this->mod_io_m->insert_map($seriesdata,TBL_SERIES);
			 
			for( $i=0; $i<count($array['episodeName']); $i++){
				$episodeName = $array['episodeName'][$i];
				$link = $array['link'][$i];
				
				$episodedata = array();
				 	 	 	 	 	 	 	 	 	 	 	
				$episodedata['id_series']  = $id_series;
				$episodedata['code_video']  = strtolower( str_replace(array(' ','-','_'), array('','',''), $episodeName) );
				$episodedata['name']  = $episodeName;
				$episodedata['video_url']  = $link;
				$episodedata['img_url']  = $this->getThumbnail($link);
				$episodedata['description']  = NULL;
				$episodedata['rating']  = 0;
				$episodedata['rate_num']  = 0;
				$episodedata['view_count']  = 0;
				$episodedata['add_date']  = mysqlDate();
				$episodedata['last_update']  = mysqlDate();
				$episodedata['ip']  = $this->geo_lib->getIpAddress();
				
				$this->mod_io_m->insert_map($episodedata,TBL_VIDEO);
			}
		}
	}
	
	
	//http://www.dailymotion.com/thumbnail/160x120/video/xlp7q4
	
	/*
		Hi,
		There has been a regression in the thumbnail code, we fixed it and it is now live. Sorry for the convenience.
		The good way to access a dailymotion thumbnail is: http://www.dailymotion.com/thumbnail/160x120/video/[ID] (this url redirects directly to our cdn)

		Regards
		Dailymotion team
	
		http://drupal.org/node/1318238
		
		{"error":{"code":403,"message":"Unsufficient scope to access private video, required scope: read.","type":"access_forbidden"}}
	*/
	 
	
	//endclass
}	
	