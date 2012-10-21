<?php defined('BASEPATH') or exit('No direct script access allowed');

class Gift_io_m extends MY_Model {
	function __construct(){
		parent::__construct();
	}
	
	function sendgift(){
		$this->load->model('user/user_m');
		
		$id_gift = $this->input->post('id_gift',0);
		$usernames = $this->input->post('usernames','');
		$message = $this->input->post('message','');
		
		$listUser = $this->user_m->getListUsername();
		
		if($id_gift == 0){
			echo json_encode(
				array(
					'result'=>'ERROR',
					'message'=>"Please choose a gift firstly."
				)
			);
			exit;
		}
		
		$userArr = explode(',',$usernames);
		array_walk_recursive($userArr, 'trim_all');
		
		$is_pass = true;
		$arrayusername = array();
		foreach($userArr as $username){
			if($username){
				if(!in_array($username,$listUser)){
					$is_pass = false;
					$tmp = $username;
					break;
				}else{
					$arrayusername[] = $username; 
				}
			}
		}
		
		if($is_pass == false){
			echo json_encode(
				array(
					'result'=>'ERROR',
					'message'=>"<b>$tmp</b> is not existed or blocked. Send failure."
				)
			);
			exit;
		}
		
		if(empty($arrayusername)){
			echo json_encode(
				array(
					'result'=>'ERROR',
					'message'=>"Please fill any username."
				)
			);
			exit;
		}
		
		$giftdataobj = $this->mod_io_m->init('id_gift',$id_gift,TBL_GIFT);
		
		$totalPrice = round(count($arrayusername)*$giftdataobj->price,2);
		$userdataobj = getAccountUserDataObject(true);
		
		if($userdataobj->cash < $totalPrice){
			echo json_encode(
				array(
					'result'=>'ERROR',
					'message'=>"Your cash is not enough to send gifts."
				)
			);
			exit;
		}
		
		foreach($arrayusername as $username){
			$userobj = $this->user_io_m->init('username',$username);
			
			$giftbox = array();
			$transaction = array(); 	 
			
			$giftbox['id_reciever'] = $userobj->id_user;
			$giftbox['id_sender'] = $userdataobj->id_user;
			$giftbox['id_gift'] = $id_gift;
			$giftbox['comment'] = $message;
			$giftbox['image'] = $giftdataobj->image;
			$giftbox['add_date'] = mysqlDate();
			$giftbox['ip'] = $this->geo_lib->getIpAddress();
			$id_gb = $this->mod_io_m->insert_map($giftbox,TBL_GIFTBOX);
			debug("insert gift box ID=$id_gb");
			
			$transaction['id_user'] = $userobj->id_user;
			$transaction['id_owner'] = $userdataobj->id_user;
			$transaction['facevalue'] = 0;
			$transaction['amount'] = $giftdataobj->price;
			$transaction['trans_type'] = $GLOBALS['global']['TRANS_TYPE']['gift'];
			$transaction['site_amt'] = $giftdataobj->price;
			$transaction['user_amt'] = 0;//$giftdataobj->price;
			$transaction['trans_date'] = mysqlDate();
			$transaction['ip'] = $this->geo_lib->getIpAddress();
			$this->mod_io_m->insert_map($transaction,TBL_TRANSACTION);
			
			$this->db->query( "UPDATE ".TBL_USER." SET cash= cash+".$giftdataobj->price. " WHERE id_admin=1" );
			$this->db->query( "UPDATE ".TBL_USER." SET cash= cash-".$giftdataobj->price. " WHERE id_user=".$userdataobj->id_user );
		
			$this->email_sender->juzonSendEmail_JUZ_SEND_GIFT($id_sender=$giftbox['id_sender'], $id_receiver=$giftbox['id_reciever'], $id_gift=$giftbox['id_gift'],$message=$giftbox['comment']);
		}
		
		echo json_encode(
			array(
				'result'=>'ok',
				'message'=> "Sent gift successfully."
			)
		);
		exit;
	}	
	
	function sendgiftToUser(){
		$this->load->model('user/user_m');
		
		$id_gift = $this->input->post('id_gift',0);
		$id_user = $this->input->post('id_user'); 
		$message = $this->input->post('message','');
		$context = $this->input->post('context');
		
		if($id_gift == 0){
			echo json_encode(
				array(
					'result'=>'ERROR',
					'message'=>"Please choose a gift firstly."
				)
			);
			exit;
		}
		
		$giftdataobj = $this->mod_io_m->init('id_gift',$id_gift,TBL_GIFT);
		
		$totalPrice = $giftdataobj->price;
		$userdataobj = getAccountUserDataObject(true);
		
		if($userdataobj->cash < $totalPrice){
			echo json_encode(
				array(
					'result'=>'ERROR',
					'message'=>"Your cash is not enough to send gifts."
				)
			);
			exit;
		}
		
		
		$userobj = $this->user_io_m->init('id_user',$id_user);
		
		$giftbox = array();
		$transaction = array(); 	 
		
		$giftbox['id_reciever'] = $userobj->id_user;
		$giftbox['id_sender'] = $userdataobj->id_user;
		$giftbox['id_gift'] = $id_gift;
		$giftbox['comment'] = $message;
		$giftbox['image'] = $giftdataobj->image;
		$giftbox['add_date'] = mysqlDate();
		$giftbox['ip'] = $this->geo_lib->getIpAddress();
		$id_gb = $this->mod_io_m->insert_map($giftbox,TBL_GIFTBOX);
		debug("insert gift box ID=$id_gb");
		
		$transaction['id_user'] = $userobj->id_user;
		$transaction['id_owner'] = $userdataobj->id_user;
		$transaction['facevalue'] = 0;
		$transaction['amount'] = $giftdataobj->price;
		$transaction['trans_type'] = $GLOBALS['global']['TRANS_TYPE']['gift'];
		$transaction['site_amt'] = $giftdataobj->price;
		$transaction['user_amt'] = 0;//$giftdataobj->price;
		$transaction['trans_date'] = mysqlDate();
		$transaction['ip'] = $this->geo_lib->getIpAddress();
		$this->mod_io_m->insert_map($transaction,TBL_TRANSACTION);
		
		$this->db->query( "UPDATE ".TBL_USER." SET cash= cash+".$giftdataobj->price. " WHERE id_admin=1" );
		$this->db->query( "UPDATE ".TBL_USER." SET cash= cash-".$giftdataobj->price. " WHERE id_user=".$userdataobj->id_user );
	
		if($context == 'CMCHAT'){
		    if(ENVIRONMENT == 'development'){
		          $imageLink = site_url()."image/thumb/gift/".$giftdataobj->image;
		    }else{
		          $imageLink = "[WEB_URL]/image/thumb/gift/".$giftdataobj->image;
		    }
		    
            $image = "[OPENTAG]img src=\"$imageLink\" class=\"cometchat_smiley\" height=\"25px\" width=\"25px\" [CLOSETAG]";	
			$postCHATMESSAGE = str_replace( array('$u1','$u2','$p3','$image'), array($userdataobj->username,$userobj->username,$giftdataobj->price,$image), language_translate('hook_chat_send_gift') );
		}else{
			$postCHATMESSAGE = '';
		}
		
		echo json_encode(
			array(
				'result'=>'ok',
				'message'=> "Sent gift successfully.",
				'CMCHATMSG'=>$postCHATMESSAGE
			)
		);
		
		$this->email_sender->juzonSendEmail_JUZ_SEND_GIFT($id_sender=$giftbox['id_sender'], $id_receiver=$giftbox['id_reciever'], $id_gift=$giftbox['id_gift'],$message=$giftbox['comment']);
		
		exit;
	}	
	
	
	
	
	
//endclass
}	