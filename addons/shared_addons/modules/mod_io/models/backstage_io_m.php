<?php defined('BASEPATH') or exit('No direct script access allowed');

class Backstage_io_m extends MY_Model {
	function __construct(){
		parent::__construct();
	}
	
	function uploadMyPhoto(){
		$title = $this->input->post('title');
		$price = round($this->input->post('price'),2);
		$myPhoto = '';
		
		if(!$price OR $price <=0 ){
			echo "Price must greater than 0.";
			exit;
		}
		
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
			$data['image_type'] = $GLOBALS['global']['IMAGE_STATUS']['private'];
			$data['price'] = $price;
			$data['comment'] = $title;
			$data['prof_flag'] = 0;
			$data['v_count'] = 0;
			$data['rate_num'] = 0;
			$data['rating'] = 0;
			$data['added_date'] = mysqlDate(); 	 	 	 	
			$id_photo = $this->gallery_io_m->insert_map($data);
			
			$array['id_parent'] 	= 0;
			$array['id_user']		= getAccountUserId();
			$array['description']	= "priced at {$price}J$";
			$array['add_date_post'] = mysqlDate(); 
			$array['post_name']		=	getAccountUserId().'_'.filterCharacter($title);	
			$array['post_id']		= $id_photo;
			$array['post_code']		=	$GLOBALS['global']['CHATTER_CODE']['backstage_photo'];
			$id_wall = $this->mod_io_m->insert_map( $array, TBL_WALL );
			$this->user_io_m->postItemOnFbTt($id_wall, TIMELINE_BACKSTAGE_PHOTO);
			
			$_SESSION['BACKSTAGE_PRICE'] = $price;
			
			echo 'ok';
			exit;
		}
		
		echo 'Unknown error';
		exit;
	}	
	
	function editBackstagePhoto(){
		extract($_POST);
		//$gallerydata = $this->gallery_io_m->init('id_image',$id_photo);
		
		if(!$price OR $price <=0 ){
			echo "Price must greater than 0.";
			exit;
		}
		
		$data['comment'] = $title;
		$data['price'] = $price;
		
		$this->gallery_io_m->update_map($data,$id_photo);
		echo 'ok';
		exit;
	}
	
	function submitSnapshotWebcam(){
		$title = $this->input->post('title');
		$myPhoto = $this->input->post('image_name');
		$price = round($this->input->post('price'),2);
		
		if(!$price OR $price <=0 ){
			echo json_encode( array('result'=>'error', 'message'=>'Price must greater than 0.') );
			exit;
		}
		
		$webcamDir =  APP_ROOT."webcamtemp/";
		
		$uploadDir  = APP_ROOT.$GLOBALS['global']['IMAGE']['image_orig']."photos/";
		$thumbnailDir = APP_ROOT.$GLOBALS['global']['IMAGE']['image_thumb']."photos/";
		$thumb_height = $GLOBALS['global']['IMAGE']['thumb_height'];
		$thumb_width = $GLOBALS['global']['IMAGE']['thumb_width'];
		$orig_width = $GLOBALS['global']['IMAGE']['orig_width'];
		$orig_height = $GLOBALS['global']['IMAGE']['orig_height'];
		
		if(! $myPhoto){
			echo json_encode( array('result'=>'error', 'message'=>'Upload picture failure.') );
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
			$data['image_type'] = $GLOBALS['global']['IMAGE_STATUS']['private'];
			$data['price'] = $price;
			$data['comment'] = $title;
			$data['prof_flag'] = 0;
			$data['v_count'] = 0;
			$data['rate_num'] = 0;
			$data['rating'] = 0;
			$data['added_date'] = mysqlDate(); 	 	 	 	
			$id_photo = $this->gallery_io_m->insert_map($data);
			
			$array['id_parent'] 	= 0;
			$array['id_user']		= getAccountUserId();
			$array['description']	= "priced at {$price}J$";
			$array['add_date_post'] = mysqlDate(); 
			$array['post_name']		=	getAccountUserId().'_'.filterCharacter($title);	
			$array['post_id']		= $id_photo;
			$array['post_code']		=	$GLOBALS['global']['CHATTER_CODE']['backstage_photo'];
			$id_wall = $this->mod_io_m->insert_map( $array, TBL_WALL );
			$this->user_io_m->postItemOnFbTt($id_wall, TIMELINE_BACKSTAGE_PHOTO);
			
			$_SESSION['BACKSTAGE_PRICE'] = $price;
			
			echo json_encode( array('result'=>'ok', 'message'=>'Upload your backstage photo successfully.') );
			exit;
		}
		
		echo 'Unknown error';
		exit;
	}
	
	function postOnWall(){
		$message = $this->input->post('message');
		$userdataobj = getAccountUserDataObject();
		
		if(isFacebookLogin()){
			$this->facebookconnect_io_m->postOnUserWall($userdataobj->id_user,$message,$message,$url=$this->user_io_m->getInviteUrl($userdataobj->username));
		}
		if(isTwitterLogin()){
			$this->twittermodel->postOnWall($message,$url=$this->user_io_m->getInviteUrl($userdataobj->username)); 
		}
		
		echo json_encode(
			array('message'=>'Post on your wall successfully.')
		);
		exit;
	}
	
	//endclass
}	