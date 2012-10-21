<?php defined('BASEPATH') or exit('No direct script access allowed');

class Photos_m extends MY_Model {
	function __construct(){
		parent::__construct();
	}
	
	function getMyPhotoComments($id_photo){
		$qr = "SELECT p.*, UNIX_TIMESTAMP(NOW())-UNIX_TIMESTAMP(p.comm_date) AS add_date FROM ".TBL_PHOTO_COMMENT." p WHERE id_wall=$id_photo ORDER BY comm_date ASC";
		return $this->db->query($qr)->result();
	}
	
	function updateComment(){
		$id_photo = $this->input->get('id_photo');
		$comment = $this->input->get('comment');
		
		$data['id_wall'] = $id_photo;
		$data['comment'] = $comment;
		$data['comment_by'] = getAccountUserId();
		$data['comm_date'] = mysqlDate();
		$data['ip'] = $this->geo_lib->getIpAddress();
		
		$this->mod_io_m->insert_map($data,TBL_PHOTO_COMMENT); 	
		
		$this->email_sender->juzonSendEmail_JUZ_PHOTO_COMMENT($data['comment_by'],$id_photo,$comment);
		return true;	
	}
	
	function deleteComment(){
		$id_photo_comment = $this->input->post('id_photo_comment');
		$id_user = getAccountUserId();
		$dataobj = $this->mod_io_m->init('id_photo_comment',$id_photo_comment,TBL_PHOTO_COMMENT);
		
		if($dataobj){
			$gallerydataobj = $this->gallery_io_m->init('id_image',$dataobj->id_wall);
			
			if($dataobj->comment_by==$id_user OR $id_user == $gallerydataobj->id_user){
				$this->db->where('id_photo_comment',$id_photo_comment)->delete(TBL_PHOTO_COMMENT);
				echo json_encode(
					array('result'=>'OK')	
				);
				exit;
			}else{
				echo json_encode(
					array('result'=>'ERROR')	
				);
				exit;	
			}
		}else{
			echo json_encode(
				array('result'=>'ERROR')	
			);
			exit;
		}
	}
	
	
	
	
	
//endclass
}	