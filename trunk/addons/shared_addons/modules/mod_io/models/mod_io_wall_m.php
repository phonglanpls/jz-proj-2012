<?php defined('BASEPATH') or exit('No direct script access allowed');

class Mod_io_wall_m extends MY_Model {
	function __construct(){
		parent::__construct();
	}
	
	function changeStateAsync($country_id){
		$html = "";
		foreach(stateOptionData_ioc($country_id) as $k=>$v){
			$html .= "<option value=".$k.">".$v."</option>";
		}
		return $html;
	}	
	
	function changeCityAsync($country_id,$state_id){
		$html = "";
		foreach(cityOptionData_ioc($country_id,$state_id) as $k=>$v){
			$html .= "<option value=".$k.">".$v."</option>";
		}
		return $html;
	}
	
	function changeFilterOptions(){
		extract($_POST);
		
		if($country_id>0){
			$array['id_country'] = $country_id;
			$array['country'] = getValueOfArray(countryOptionData_ioc($country_id));
			
			if($state_id>0){
				$array['id_state'] = $state_id;
				$array['state'] = getValueOfArray(stateOptionData_ioc($country_id,$state_id));
				
				if($city_id>0){
					$array['id_city'] = $city_id;
					$array['city'] = getValueOfArray(cityOptionData_ioc($country_id,$state_id,$city_id));
					
					$geo = $this->geo_lib->getCoordinatesFromAddress($array['city']);
					$array['longitude'] = $geo['longitude'];
					$array['latitude'] = $geo['latitude'];
				}else{
					$array['id_city'] = 0;
					$array['city'] = null;
					$array['longitude'] = null;
					$array['latitude'] = null;
				}
			}else{
				$geo = $this->geo_lib->getCoordinatesFromAddress($array['country']);
				
				$array['id_state'] = 0;
				$array['state'] = null;
				$array['id_city'] = 0;
				$array['city'] = null;
				$array['longitude'] = $geo['longitude'];
				$array['latitude'] = $geo['latitude'];
			}
		}else{
			$array['id_country'] = 0;
			$array['country'] = null;
			$array['id_state'] = 0;
			$array['state'] = null;
			$array['id_city'] = 0;
			$array['city'] = null;
			$array['longitude'] = null;
			$array['latitude'] = null;
		}
		
		$array['chat_gender'] = $gender;
		$array['chat_age_from'] = $age_from;
		$array['chat_age_to'] = $age_to;
		$array['address'] = $address;
		$array['postal_code'] = $zipcode;
		
		if(!$array['longitude'] OR !$array['latitude']){
			$infoArray = $this->geo_lib->getLocationInfoFromIP();
			$array['longitude'] = $infoArray['longitude'];
			$array['latitude'] = $infoArray['latitude'];
		}
		  
		if($id=getAccountUserId()){
			$this->user_io_m->update_map($array,$id);
			echo 'ok';
			exit();
		}
		echo 'User not existed.';
	}
	
	function toggleLikeContext(){
		$this->load->model('user/wall_m');
		$id_wall = $this->input->get('id_wall',0);
		
		if(!$id_user=getAccountUserId()){
			echo json_encode(array('res'=>'ERROR'));
			exit;
		}
		
		$sql = "SELECT * FROM ".TBL_POST_INFO." WHERE id_post = '".$id_wall."' AND id_usr ='".$id_user."' LIMIT 1";
		$post_info = $this->db->query($sql)->result();
		
		$isLike = false;
		if($post_info){
			if($post_info[0]->p_like == 1){
				$array['p_like'] = 0;
			}else{
				$array['p_like'] = 1;
				$isLike = true;
			}
			$this->mod_io_m->update_map( $array, array('id_post_info'=>$post_info[0]->id_post_info), TBL_POST_INFO );
		}else{
			$array['p_like'] = 1;
			$array['id_usr'] = $id_user;
			$array['id_post'] = $id_wall;
			$array['like_date'] = mysqlDate();
			$this->mod_io_m->insert_map( $array, TBL_POST_INFO );
			$isLike = true;
		}
		
		$res = $this->wall_m->getLikeInfo($id_wall);		
		echo json_encode(
			array(
				'res' => "OK",
				'context'	=> $res['context'],
				'contextme'	=> $res['contextme']
			)
		);
		
		
		if($isLike ){
			$this->email_sender->juzonSendEmail_JUZ_LIKE_CHATTER($id_user,$id_wall);
		}
		exit;
	}
	
	function submitCommentWall($id_wall=0,$comment=''){
		if(!$id_user=getAccountUserId()){
			return false;
		}
		
		if($id_wall AND $comment){
			$array['id_parent'] 	= $id_wall;
			$array['id_user']		= $id_user;
			$array['description']	= substr($comment,0,$GLOBALS['global']['INPUT_LIMIT']['comment_limit']);
			$array['add_date_post'] = mysqlDate(); 
			$array['post_id']		=	0;	
			$this->mod_io_m->insert_map( $array, TBL_WALL );
			
			$this->email_sender->juzonSendEmail_JUZ_CHATTER_COMMENT($id_user,$id_wall,$comment);
		}
		return true;
	}
	
	function deleteComment(){
		$id_wall = $this->input->post('id_wall',0);
		
		if(!$this->wall_m->isDeletableCommentFeed($id_wall)){
			echo json_encode( array('result'=>'ERROR'));
			exit;
		}else{
			$this->db->where('id_wall',$id_wall)->delete(TBL_WALL);
			echo json_encode( array('result'=>'OK'));
			exit;
		}
	}
	
	function deleteFeedWall(){
		$id_wall = $this->input->post('id_wall',0);
		if(!$this->wall_m->isMyOwnWallFeed($id_wall)){
			echo json_encode( array('result'=>'ERROR'));
			exit;
		}else{
			$this->db->where('id_parent',$id_wall)->delete(TBL_WALL);
			$this->db->where('id_wall',$id_wall)->delete(TBL_WALL);
			echo json_encode( array('result'=>'OK'));
			exit;
		}
	}
	
	function submitShareStatus(){
		if(!$id_user=getAccountUserId()){
			echo json_encode(array('result'=>'ERROR'));
			exit;
		}
		$status = $this->input->post('status','');
		
		$array['id_parent'] 	= 0;
		$array['id_user']		= $id_user;
		$array['description']	= substr($status,0,$GLOBALS['global']['INPUT_LIMIT']['wall_status']);
		$array['add_date_post'] = mysqlDate(); 
		$array['post_id']		=	0;	
		$id_wall = $this->mod_io_m->insert_map( $array, TBL_WALL );
		
		echo json_encode(array('result'=>'OK'));
		
		$this->user_io_m->postItemOnFbTt($id_wall, TIMELINE_STATUS_UPDATE);
		exit;
	}
	
	function quickEditUserFilter($data){
		if($data['country']){
			$array['id_country'] = $data['country'];
			$array['country'] = getValueOfArray(countryOptionData_ioc($data['country']));
			
			$geo = $this->geo_lib->getCoordinatesFromAddress($array['country']);
				
			$array['id_state'] = 0;
			$array['state'] = NULL;
			$array['id_city'] = 0;
			$array['city'] = NULL;
			$array['longitude'] = $geo['longitude'];
			$array['latitude'] = $geo['latitude'];
			$array['address'] = NULL;
			$array['postal_code'] = NULL;
		}
		
		if($data['gender']){
			$array['chat_gender'] = $data['gender'];
		}
		
		if($data['age_from']){
			$array['chat_age_from'] = intval($data['age_from']);
		}
		
		if($data['age_to']){
			$array['chat_age_to'] = intval($data['age_to']);
		}
		
		if(!isset($array['longitude']) OR !isset($array['latitude']) OR !$array['longitude'] OR !$array['latitude']){
			$infoArray = $this->geo_lib->getLocationInfoFromIP();
			$array['longitude'] = $infoArray['longitude'];
			$array['latitude'] = $infoArray['latitude'];
		}
		  
		if($id=getAccountUserId()){
			$this->user_io_m->update_map($array,$id);
		}
		return;	
	}
	
	function submitPhotoUpload(){
		$desc = $this->input->post('status');
		$photo = '';
		
		$uploadDir  = APP_ROOT.$GLOBALS['global']['IMAGE']['image_orig']."photos/";
		$thumbnailDir = APP_ROOT.$GLOBALS['global']['IMAGE']['image_thumb']."photos/";
		$thumb_height = $GLOBALS['global']['IMAGE']['thumb_height'];
		$thumb_width = $GLOBALS['global']['IMAGE']['thumb_width'];
		$orig_width = $GLOBALS['global']['IMAGE']['orig_width'];
		$orig_height = $GLOBALS['global']['IMAGE']['orig_height'];
		
		if(isset($_FILES["photo"]) AND !empty($_FILES["photo"]['name'])) {
			if(($_FILES["photo"]['size']/1000000) > allowMaxFileSize() ){
				$photo = '';
			}else{
				$photo = $this->module_helper->uploadFile( 
										$_FILES["photo"]['tmp_name'],
										$_FILES["photo"]['name'],
										$uploadDir,
										allowExtensionPictureUpload()
									);
			}	
		}
		
		if(! $photo){
			echo "Upload picture failure.";
			exit;
		}else{
			copy($uploadDir.$photo, $thumbnailDir.$photo);
			//chmod( $thumbnailDir.$photo, 0777 );
			makeThumb($photo,$uploadDir,$orig_width,$orig_height);
			makeThumb($photo,$thumbnailDir,$thumb_width,$thumb_height);
			
			$data['image'] = $photo;
			$data['id_user'] = getAccountUserId();
			$data['image_type'] = $GLOBALS['global']['IMAGE_STATUS']['public'];
			$data['price'] = 0;
			$data['comment'] = $desc;
			$data['prof_flag'] = 0;
			$data['v_count'] = 0;
			$data['rate_num'] = 0;
			$data['rating'] = 0;
			$data['added_date'] = mysqlDate(); 	 	 	 	
			$id_photo = $this->gallery_io_m->insert_map($data);
			
			
			$array['id_parent'] 	= 0;
			$array['id_user']		= getAccountUserId();
			$array['description']	= substr($desc,0,$GLOBALS['global']['INPUT_LIMIT']['wall_status']);
			$array['add_date_post'] = mysqlDate(); 
			$array['post_id']		=	$id_photo;	
			$array['image']			=	$photo;
			$this->mod_io_m->insert_map( $array, TBL_WALL );
			
			
			echo 'ok';
			exit;
		}
		
		echo 'Unknown error';
		exit;
	}
	
	function submitShareStatusSnapshotWC(){
		$photo = $this->input->post('image_name');
		$desc = $this->input->post('status');
		
		$webcamDir =  APP_ROOT."webcamtemp/";
		
		$uploadDir  = APP_ROOT.$GLOBALS['global']['IMAGE']['image_orig']."photos/";
		$thumbnailDir = APP_ROOT.$GLOBALS['global']['IMAGE']['image_thumb']."photos/";
		$thumb_height = $GLOBALS['global']['IMAGE']['thumb_height'];
		$thumb_width = $GLOBALS['global']['IMAGE']['thumb_width'];
		$orig_width = $GLOBALS['global']['IMAGE']['orig_width'];
		$orig_height = $GLOBALS['global']['IMAGE']['orig_height'];
		
		copy($webcamDir.$photo, $thumbnailDir.$photo);
		copy($webcamDir.$photo, $uploadDir.$photo);
		//chmod( $thumbnailDir.$photo, 0777 );
		//chmod( $uploadDir.$myPhoto, 0777 );
		makeThumb($photo,$uploadDir,$orig_width,$orig_height);
		makeThumb($photo,$thumbnailDir,$thumb_width,$thumb_height);
		
		$data['image'] = $photo;
		$data['id_user'] = getAccountUserId();
		$data['image_type'] = $GLOBALS['global']['IMAGE_STATUS']['public'];
		$data['price'] = 0;
		$data['comment'] = $desc;
		$data['prof_flag'] = 0;
		$data['v_count'] = 0;
		$data['rate_num'] = 0;
		$data['rating'] = 0;
		$data['added_date'] = mysqlDate(); 	 	 	 	
		$id_photo = $this->gallery_io_m->insert_map($data);
		
		
		$array['id_parent'] 	= 0;
		$array['id_user']		= getAccountUserId();
		$array['description']	= substr($desc,0,$GLOBALS['global']['INPUT_LIMIT']['wall_status']);
		$array['add_date_post'] = mysqlDate(); 
		$array['post_id']		=	$id_photo;	
		$array['image']			=	$photo;
		$this->mod_io_m->insert_map( $array, TBL_WALL );
		
		
		echo json_encode( array('result'=>'ok', 'message'=>'Share your snapshot successfully.') );
		exit;
	}
	
	
	
	
	
	
	
	
	
	
//endclass
}	