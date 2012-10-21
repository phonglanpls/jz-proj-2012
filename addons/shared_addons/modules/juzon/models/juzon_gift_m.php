<?php defined('BASEPATH') or exit('No direct script access allowed');
/**
 * @package 	PyroCMS
 * @subpackage  Templates Module
 * @category	Module
 */
class Juzon_gift_m extends MY_Model {
	
	function __construct()
    {
        parent::__construct();
    }
	
	function getGiftCategoriesArray($mode=''){
		$rs = $this->db->where('status','1')->order_by('id_category')->get(TBL_CATEGORY)->result();
		
		if($mode != 'NO_SELECTED'){
			$array[0]= '-Select-';
		}
		foreach($rs as $item){
			$array[$item->id_category]= $item->cat_name;
		}
		return $array;
	}
	
	function saveGift(){
		$id_gift = intval( $this->input->post('id_gift',0) );
		$giftdata = $this->mod_io_m->init('id_gift',$id_gift,TBL_GIFT);
		
		if($giftdata){
			$image = $giftdata->image;
		}else{
			$image = '';
		}
		
		$uploadDir  = APP_ROOT.$GLOBALS['global']['IMAGE']['image_orig'].'gift/';
		$thumbnailDir = APP_ROOT.$GLOBALS['global']['IMAGE']['image_thumb'].'gift/';
		$thumb_height = 60;
		$thumb_width = 60;
	
		if(isset($_FILES["image"]) AND !empty($_FILES["image"]['name'])) {
			if(($_FILES["image"]['size']/1000000) > allowMaxFileSize() ){
				$image = '';
			}else{
				$image = $this->module_helper->uploadFile( 
										$_FILES["image"]['tmp_name'],
										$_FILES["image"]['name'],
										$uploadDir,
										allowExtensionPictureUpload()
									);
			}	
		}
		
		if(!$image){
			echo 'Image must not empty';exit;
		}else{
			copy($uploadDir.$image, $thumbnailDir.$image);
			makeThumb($image,$thumbnailDir,$thumb_width,$thumb_height);
			
			$data['image'] = $image;
		}
		
		if(! $this->phpvalidator->is_numeric($this->input->post('price'))){
			echo 'Price must be numeric.';exit;
		}else{
			$data['price'] = $this->input->post('price');
		}
		 	
		if($this->input->post('name_gift')){
			$data['name_gift'] = $this->input->post('name_gift');
			$data['code_gift'] = slugify( $this->input->post('name_gift') );
		}
		$data['ip'] = $this->geo_lib->getIpAddress();
		
		$data['description'] = $this->input->post('description'); 	 	
		$data['id_category'] = $this->input->post('category');
		$data['status'] = $this->input->post('status');
		
		if($giftdata){
			$data['last_update'] = mysqlDate();
			$this->mod_io_m->update_map($data, array('id_gift'=>$id_gift),TBL_GIFT);
		}else{
			$data['add_date'] = mysqlDate();
			$this->mod_io_m->insert_map($data, TBL_GIFT);
		}
		echo 'ok';
		$this->session->set_flashdata('success', lang('templates.tmpl_save_success') );
		exit;
	}
	
	function deleteGift(){
		$id_gift = intval( $this->input->post('id_gift',0) );
		$this->db->where('id_gift',$id_gift)->delete(TBL_GIFT);
		exit;
	}
	
	
	function saveCategory(){
		$id_category = intval( $this->input->post('id_category') );
		$data['cat_name'] = $this->input->post('cat_name');
		$data['status'] = $this->input->post('status');
		
		$data['code_category'] = slugify( $data['cat_name'] );
		$data['add_date'] = mysqlDate();
		$data['ip'] = $this->geo_lib->getIpAddress();
		 	
		if($id_category){
			$this->mod_io_m->update_map($data,array('id_category'=>$id_category),TBL_CATEGORY);
		}else{
			$this->mod_io_m->insert_map($data,TBL_CATEGORY);
		}
		echo 'ok';
		$this->session->set_flashdata('success', lang('templates.tmpl_save_success') );
		exit;
	}
	
	function deleteCategory(){
		$id_category = intval( $this->input->post('id_category') );
		$this->db->where('id_category',$id_category)->delete(TBL_CATEGORY);
		exit;
	}
	
	
	
	
	
	
	
	
	
	
	
	
	
	
//endclass
}	