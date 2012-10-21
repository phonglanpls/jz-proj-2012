<?php defined('BASEPATH') or exit('No direct script access allowed');

class Collection_io_m extends MY_Model {
	function __construct(){
		parent::__construct();
	}
	
	function uploadMyPhoto(){
		$title = $this->input->post('title');
		$myPhoto = '';
		
		$uploadDir  = APP_ROOT.$GLOBALS['global']['IMAGE']['image_orig']."photos/";
		$thumbnailDir = APP_ROOT.$GLOBALS['global']['IMAGE']['image_thumb']."photos/";
		$thumb_height = $GLOBALS['global']['IMAGE']['thumb_height'];
		$thumb_width = $GLOBALS['global']['IMAGE']['thumb_width'];
		$orig_width = $GLOBALS['global']['IMAGE']['orig_width'];
		$orig_height = $GLOBALS['global']['IMAGE']['orig_height'];
		
		if(isset($_FILES["my_photo"]) AND !empty($_FILES["my_photo"]['name'])) {
			if(($_FILES["my_photo"]['size']/1000000) > allowMaxFileSize() ){
				$myPhoto = '';
			}else{
				$myPhoto = $this->module_helper->uploadFile( 
										$_FILES["my_photo"]['tmp_name'],
										$_FILES["my_photo"]['name'],
										$uploadDir,
										allowExtensionPictureUpload()
									);
			}	
		}
		
		if(! $myPhoto){
			echo "Upload picture failure.";
			exit;
		}else{
			copy($uploadDir.$myPhoto, $thumbnailDir.$myPhoto);
			//chmod( $thumbnailDir.$myPhoto, 0777 );
			makeThumb($myPhoto,$uploadDir,$orig_width,$orig_height);
			makeThumb($myPhoto,$thumbnailDir,$thumb_width,$thumb_height);
			
			$data['image'] = $myPhoto;
			$data['id_user'] = getAccountUserId();
			$data['image_type'] = $GLOBALS['global']['IMAGE_STATUS']['public'];
			$data['price'] = 0;
			$data['comment'] = $title;
			$data['prof_flag'] = 0;
			$data['v_count'] = 0;
			$data['rate_num'] = 0;
			$data['rating'] = 0;
			$data['added_date'] = mysqlDate(); 	 	 	 	
			$this->gallery_io_m->insert_map($data);
			echo 'ok';
			exit;
		}
		
		echo 'Unknown error';
		exit;
	}	
	
	function editMyPhoto(){
		$photodataobj = $this->gallery_io_m->init('id_image',$this->input->post('id_image'));
		 
		if($photodataobj){
			$update['comment'] = $this->input->post('title');
			
			if($this->input->post('is_profile') == 1){
				$this->db->where('id_user',getAccountUserId())->update(TBL_GALLERY, array('prof_flag'=>0));
				$update['prof_flag'] = 1;
				
				$uploadDir  = APP_ROOT.$GLOBALS['global']['IMAGE']['image_orig']."photos/";
				
				$thumbDir = APP_ROOT.$GLOBALS['global']['PROF_IMAGE']['profile_thumb'];
				$chatterDir = APP_ROOT.$GLOBALS['global']['PROF_IMAGE']['profile_chatter'];
				$commDir = APP_ROOT.$GLOBALS['global']['PROF_IMAGE']['profile_comm'];
				$thumb_height = $GLOBALS['global']['PROF_IMAGE']['thumb_height'];
				$thumb_width = $GLOBALS['global']['PROF_IMAGE']['thumb_width'];
				$chatter_height = $GLOBALS['global']['PROF_IMAGE']['chatter_height'];
				$chatter_width = $GLOBALS['global']['PROF_IMAGE']['chatter_width'];
				$comm_height = $GLOBALS['global']['PROF_IMAGE']['comm_height'];
				$comm_width = $GLOBALS['global']['PROF_IMAGE']['comm_width'];
				
				copy($uploadDir.$photodataobj->image, $thumbDir.$photodataobj->image);
				copy($uploadDir.$photodataobj->image, $chatterDir.$photodataobj->image);
				copy($uploadDir.$photodataobj->image, $commDir.$photodataobj->image);
				
				makeThumb($photodataobj->image,$thumbDir,$thumb_width,$thumb_height);
				makeThumb($photodataobj->image,$chatterDir,$chatter_width,$chatter_height);
				makeThumb($photodataobj->image,$commDir,$comm_width,$comm_height);
				
				$user['photo'] = $photodataobj->image;
				$this->user_io_m->update_map($user,getAccountUserId());
			}else{
				$update['prof_flag'] = 0;
			}
			$this->gallery_io_m->update_map($update,$photodataobj->id_image);
			echo 'ok';
			exit;
		}
		echo 'Unknown error';
		exit;	
	}
	
	function submitSnapshotWebcam(){
		$title = $this->input->post('title');
		$myPhoto = $this->input->post('image_name');
		
		$webcamDir =  APP_ROOT."webcamtemp/";
		
		$uploadDir  = APP_ROOT.$GLOBALS['global']['IMAGE']['image_orig']."photos/";
		$thumbnailDir = APP_ROOT.$GLOBALS['global']['IMAGE']['image_thumb']."photos/";
		$thumb_height = $GLOBALS['global']['IMAGE']['thumb_height'];
		$thumb_width = $GLOBALS['global']['IMAGE']['thumb_width'];
		$orig_width = $GLOBALS['global']['IMAGE']['orig_width'];
		$orig_height = $GLOBALS['global']['IMAGE']['orig_height'];
		
		if(! $myPhoto){
			echo "Upload picture failure.";
			exit;
		}else{
			copy($webcamDir.$myPhoto, $thumbnailDir.$myPhoto);
			copy($webcamDir.$myPhoto, $uploadDir.$myPhoto);
			//chmod( $thumbnailDir.$myPhoto, 0777 );
			//chmod( $uploadDir.$myPhoto, 0777 );
			makeThumb($myPhoto,$uploadDir,$orig_width,$orig_height);
			makeThumb($myPhoto,$thumbnailDir,$thumb_width,$thumb_height);
			
			$data['image'] = $myPhoto;
			$data['id_user'] = getAccountUserId();
			$data['image_type'] = $GLOBALS['global']['IMAGE_STATUS']['public'];
			$data['price'] = 0;
			$data['comment'] = $title;
			$data['prof_flag'] = 0;
			$data['v_count'] = 0;
			$data['rate_num'] = 0;
			$data['rating'] = 0;
			$data['added_date'] = mysqlDate(); 	 	 	 	
			$this->gallery_io_m->insert_map($data);
			
			echo json_encode( array('result'=>'ok', 'message'=>'Upload your snapshot successfully.') );
			exit;
		}
		
		echo 'Unknown error';
		exit;
	}
	
	
	//endclass
}	