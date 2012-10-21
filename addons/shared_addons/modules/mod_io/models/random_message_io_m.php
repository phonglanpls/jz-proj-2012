<?php defined('BASEPATH') or exit('No direct script access allowed');

class Random_message_io_m extends MY_Model {
	function __construct(){
		parent::__construct();
		$this->load->model( 'user/online_m' );
	}
	
	function sendMessage(){
		$gender = $this->input->post('gender');
		$type = $this->input->post('type');
		$message = substr( $this->input->post('message'), 0 , $GLOBALS['global']['INPUT_LIMIT']['random_message'] );
		
		$sql = "SELECT u.id_user FROM ".TBL_USER." u, ".TBL_FRIENDLIST." f WHERE u.status=0 ";
		
		$cond = '';
		if($type == 'friend'){
			$my_id_user = getAccountUserId();
			$cond .= " AND ( (u.id_user=f.id_user AND f.friend=$my_id_user) OR ( f.friend=u.id_user AND f.id_user=$my_id_user) ) AND f.request_type=0 ";	
		}
		if($gender != 'Both'){
			$cond .= " AND u.gender= '$gender'";
		}
		
		$offset_result = $this->db->query( " SELECT FLOOR(RAND() * COUNT(*)) AS offset FROM ".TBL_USER." u, ".
											TBL_FRIENDLIST." f WHERE u.status=0 $cond")->result();
		if(! $offset_result){
			echo json_encode(
				array(
					'result' => 'ERROR',
					'message' => 'No such user found. Send failure.'
				)
			);
			exit;
		}
		
		$offset = $offset_result[0]->offset;
		$res = $this->db->query( " SELECT u.id_user FROM ".TBL_USER." u, ".
											TBL_FRIENDLIST." f WHERE u.status=0 $cond LIMIT $offset,1")->result(); 
		if(! $res){
			echo json_encode(
				array(
					'result' => 'ERROR',
					'message' => 'No such user found. Send failure.'
				)
			);
			exit;
		}
		
		$id_user = $res[0]->id_user;
		
		$data['id_user_from'] = getAccountUserId();
		$data['id_user_to'] = $id_user;
		$data['message'] = $message;
		$data['sentdate'] = mysqlDate();
		
		if($this->online_m->checkOnlineUser($id_user)){
			//send chat message ...
			$data['type_message'] = 0;
            include_once ('./cometchat/cometchat_init.php');
            sendMessageTo($data['id_user_to'],$data['message']);
		}else{ //send email
			$data['type_message'] = 1;
			$this->email_sender->juzonSendEmail_RANDOMMESSAGEEMAIL($id_user,$message);
		}
		
		$this->mod_io_m->insert_map($data,TBL_RANDOM_MESSAGE);
		
		echo json_encode(
			array(
				'result' => 'ok',
				'message' => 'Send successfully.'
			)
		);
		exit;
	}	
	
	
//endclass
}	