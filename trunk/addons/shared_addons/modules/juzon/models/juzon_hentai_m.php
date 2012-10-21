<?php defined('BASEPATH') or exit('No direct script access allowed');
/**
 * @package 	PyroCMS
 * @subpackage  Templates Module
 * @category	Module
 */
class Juzon_hentai_m extends MY_Model {
	
	function __construct()
    {
        parent::__construct();
    }
	
	function getHentaiCategoriesArray($mode=''){
		$rs = $this->db->order_by('id_hentai_category')->get(TBL_HENTAI_CATEGORY)->result();
		
		if($mode != 'NO_SELECTED'){
			$array[0]= '-Select-';
		}
		foreach($rs as $item){
			$array[$item->id_hentai_category]= $item->category_name;
		}
		return $array;
	}

	function getSeriesArray($id_hentai_category){
		$query = "SELECT s.* FROM ".TBL_SERIES." s WHERE s.id_hentai_category = $id_hentai_category ";
		$rs = $this->db->query($query)->result();
		foreach($rs as $item){
			$array[$item->id_series]= $item->name ;
		}
		return $array;
	}
	
	function loadCorrespondSeries(){
		$hentai_category_id = $this->input->get('hentai_category_id');
		echo form_dropdown('id_series',$this->getSeriesArray($hentai_category_id),array(null), 'id="id_series"');
		exit;
	}

	function saveCategory(){
		$id_hentai_category = $this->input->post('id_hentai_category');
		$data['category_name']	= $this->input->post('category_name');
		$data['status']	= $this->input->post('status');
		
		$this->mod_io_m->update_map($data, array('id_hentai_category'=>$id_hentai_category), TBL_HENTAI_CATEGORY);
		echo 'ok';
		$this->session->set_flashdata('success', lang('templates.tmpl_save_success') );
		exit;
	}	
	
	function saveSeries(){
		$id_series = $this->input->post('id_series');
		$seriesdata = $this->mod_io_m->init('id_series',$id_series,TBL_SERIES);
		
		$data['id_hentai_category'] = $this->input->post('id_hentai_category');
		
		if($data['id_hentai_category'] == 1){ //facebook
			$data['img_url'] = $this->input->post('img_url');
		}else{
			$uploadDir  = APP_ROOT.$GLOBALS['global']['IMAGE']['image_orig'].'hentai/';
			$thumbnailDir = APP_ROOT.$GLOBALS['global']['IMAGE']['image_thumb'].'hentai/dailymotion/';
			$thumb_height = 160;
			$thumb_width = 120;
			
			if($seriesdata){
				$image = $seriesdata->image.'.jpg';
			}else{
				$image = '';
			}
			
			if(isset($_FILES["image"]) AND !empty($_FILES["image"]['name'])) {
				if(($_FILES["image"]['size']/1000000) > allowMaxFileSize() ){
					$image = '';
				}else{
					$image = $this->module_helper->uploadFile( 
											$_FILES["image"]['tmp_name'],
											$_FILES["image"]['name'],
											$uploadDir,
											array('jpg')
										);
				}	
			}
			
			if($image){
				copy($uploadDir.$image, $thumbnailDir.$image);
				makeThumb($image,$thumbnailDir,$thumb_width,$thumb_height);
				
				$data['image'] = substr( $image, 0, strrpos( $image, '.' ) ) ;
			}
		}
		$data['name'] = $this->input->post('name');
		
		if($seriesdata){
			$this->mod_io_m->update_map($data, array('id_series'=>$id_series),TBL_SERIES);
		}else{
			$this->mod_io_m->insert_map($data,TBL_SERIES);
		}
		
		echo 'ok';
		$this->session->set_flashdata('success', lang('templates.tmpl_save_success') );
		exit;
	}
	
	function deleteSeries(){
		$id_series = $this->input->post('id_series');
		$this->db->where('id_series',$id_series)->delete(TBL_SERIES);
		exit;
	}
	
	function saveVideo(){
		$id_video = $this->input->post('id_video');
		$data['id_series'] = $this->input->post('id_series');
		$data['name'] = $this->input->post('name');
		$data['video_url'] = $this->input->post('video_url');
		
		if(!$data['id_series']){
			echo 'Series must not empty.';
			exit;
		}
		
		if(!$data['name']){
			echo 'Name must not empty.';
			exit;
		}
		
		if(!$data['video_url']){
			echo 'Video Url must not empty.';
			exit;
		}
		
		if($id_video){
			$data['last_update'] = mysqlDate(); 	
		}else{
			$data['add_date'] = mysqlDate();
		}
		$data['ip'] = $this->geo_lib->getIpAddress();
		
		if($id_video){
			$this->mod_io_m->update_map($data, array('id_video'=>$id_video),TBL_VIDEO);
		}else{
			$this->mod_io_m->insert_map($data, TBL_VIDEO);
		}
		
		echo 'ok';
		$this->session->set_flashdata('success', lang('templates.tmpl_save_success') );
		exit;
	}
	
	function deleteVideo(){
		$id_video = $this->input->post('id_video');
		$this->db->where('id_video',$id_video)->delete(TBL_VIDEO);
		exit;
	}
	
//endclass
}	