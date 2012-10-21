<?php defined('BASEPATH') or exit('No direct script access allowed');
//deprecated

class Jsonservices_io_m extends MY_Model {
	function __construct(){
		parent::__construct();
        $this->load->model( 'user/online_m' );
	}
	
	function _user_status(){
	   $id_user = intval ( $this->input->get('id_user') );
       
       $userdataobj = $this->user_io_m->init('id_user',$id_user);
       
       $is_online = 'offline';
       if($this->online_m->checkOnlineUser($id_user)){
             $is_online = 'online';
       }
        
       if($userdataobj){
            echo json_encode(array('online_status'=>$is_online, 'send_offline_message'=>$GLOBALS['global']['OFFLINE_CHAT']['send_email']));
       }else{
            echo '';
       }
   	}			
	
	function _sendemail(){
	   $id_user = intval ( $this->input->get('id_user') );
       $userdataobj = $this->user_io_m->init('id_user',$id_user);
       $message = urldecode($this->input->get('message'));
       
       if($userdataobj){
            $this->email_sender->juzonSendEmail_JUZ_SENDOFFLINECHATMESSAGEEMAIL($id_user,$message);
       }
	}

//endclass
}	