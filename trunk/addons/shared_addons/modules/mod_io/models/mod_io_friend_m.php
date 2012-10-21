<?php defined('BASEPATH') or exit('No direct script access allowed');

class Mod_io_friend_m extends MY_Model {
	function __construct(){
		parent::__construct();
		$this->load->model('user/user_m');
	}
	
	function addFriend(){
		$this->load->model("user/friend_m");
		$id_user = $this->input->post('id_user',0);
		
		if($this->friend_m->isUserBlockMe($id_user)){
			echo json_encode(
				array(
					'result' => 'ERROR',
					'message'	=> language_translate('error_block_message_alert')
				)
			);
			exit;
		}
		
		if($this->friend_m->isUserRejectMe($id_user)){
			$cond = "SELECT * FROM ".TBL_FRIENDLIST." WHERE friend=".getAccountUserId().",
					id_user=$id_user,request_type=1,request_date=NOW() WHERE request_type='".$GLOBALS['global']['FRIEND_ACTION']['reject']."'";
			$this->db->query($cond);
			
			echo json_encode(
				array(
					'result' => 'ok',
					'message'	=> language_translate('request_add_friend_success')
				)
			);
			exit;	
		}
		
		if($obj = $this->friend_m->isPendingAddFriend($id_user)){
			if( $obj->id_user == getAccountUserId() ){
				echo json_encode(
					array(
						'result' => 'ERROR',
						'message'	=> language_translate('error_user_send_request_alert')
					)
				);
				exit;
			}
			if( $obj->id_user == $id_user ){
				echo json_encode(
					array(
						'result' => 'ERROR',
						'message'	=> language_translate('error_sent_request_frient_alert')
					)
				);
				exit;
			}
		}
		
		//
		$user['id_user'] = $id_user;
		$user['friend']  = getAccountUserId();
		$user['request_type'] = 1;
		$user['request_date'] = mysqlDate();
		$this->mod_io_m->insert_map($user,TBL_FRIENDLIST);
		
		echo json_encode(
			array(
				'result' => 'ok',
				'message'	=> language_translate('request_add_friend_success')
			)
		);
		
		$this->email_sender->juzonSendEmail_JUZ_FRIEND_REQUEST($user['friend'],$user['id_user']);
		exit;		
	}	
	
	function acceptFriend(){
		$this->load->model("user/friend_m");
		$id_user = $this->input->post('id_user',0);
		
		$update['request_type'] = $GLOBALS['global']['FRIEND_ACTION']['accept'];
		$update['action_date']	= mysqlDate();
		
		$where['id_user']	=	getAccountUserId();
		$where['friend']	=	$id_user;
		$where['request_type'] = 1;
		$this->mod_io_m->update_map($update,$where,TBL_FRIENDLIST);
		
		echo json_encode(
			array(
				'result'=>'ok',
				'message' => 'successfully'
			)
		);
		
		$this->email_sender->juzonSendEmail_JUZ_FRIEND_CONFIRM($id_user,getAccountUserId());
		exit;
	}
	
	function rejectFriend(){
		$this->load->model("user/friend_m");
		$id_user = $this->input->post('id_user',0);
		
		$update['request_type'] = $GLOBALS['global']['FRIEND_ACTION']['reject'];
		$update['action_date']	= mysqlDate();
		
		$where['id_user']	=	getAccountUserId();
		$where['friend']	=	$id_user;
		$where['request_type'] = 1;
		$this->mod_io_m->update_map($update,$where,TBL_FRIENDLIST);
		
		echo json_encode(
			array(
				'result'=>'ok',
				'message' => 'successfully'
			)
		);
		exit;
	}
	
	function blockFriend(){
		$this->load->model("user/friend_m");
		$id_user = $this->input->post('id_user',0);
		
		$update['request_type'] = $GLOBALS['global']['FRIEND_ACTION']['block'];
		$update['action_date']	= mysqlDate();
		
		$where['id_user']	=	getAccountUserId();
		$where['friend']	=	$id_user;
		$where['request_type'] = 1;
		$this->mod_io_m->update_map($update,$where,TBL_FRIENDLIST);
		
		echo json_encode(
			array(
				'result'=>'ok',
				'message' => 'successfully'
			)
		);
		exit;
	}
	
	function unFriend(){
		$id_user = $this->input->post('id_user',0);
		
		$query = "DELETE FROM ".TBL_FRIENDLIST." WHERE (id_user=$id_user AND friend=".getAccountUserId().") OR (id_user=".getAccountUserId()." AND friend=$id_user)"; 	
		$this->db->query($query);
		echo json_encode(
			array('result'=>'ok')
		);	
	}
	
	function inviteFriend(){
	
		$userdataobj = getAccountUserDataObject();
		$message = $this->input->get("message","");
		$subject = $this->input->get("subject","");
		$emailaddress = $this->input->get("emailaddress","");
		
		$invite_url = "<a href='".$this->user_io_m->getInviteUrl($userdataobj->username)."'>".$this->user_io_m->getInviteUrl($userdataobj->username)."</a>";
		$message = str_replace('{$invite_url}',$invite_url , nl2p2($message) );
		$message .= str_replace('{$invite_url}',$this->user_io_m->getInviteUrl($userdataobj->username) , language_translate('append_invite_friend') );
		
        $message = strip_slashes($message);
		$emailArr = $notEmailArr = array();
		
		$emailepl = explode(',', $emailaddress);
		foreach($emailepl as $email){
			$tmp = trim($email);
			if($this->phpvalidator->is_email($tmp)){
				$emailArr[] = $tmp;
			}else{
				$notEmailArr[] = $tmp;
			}
		}
		
		//$invite_link = $this->user_io_m->getInviteUrl($userdataobj->username);
		
		 
		$userdataExisted = array();
		$i=0;
		foreach($emailArr as $email){
			$checkuserdata = $this->mod_io_m->init('email', $email, TBL_USER);
			
			if($checkuserdata){
				$userdataExisted[] = $checkuserdata;
			}else{
				$i++;
				$this->email_sender->setSubject($subject);
				$this->email_sender->setFromEmail($userdataobj->email);
				$this->email_sender->setToEmail($email);
				
				$inviteID = $this->user_io_m->generateConfirmInviteId($userdataobj->id_user,$email);
				
				$check = $this->mod_io_m->init('invite_confirm',$inviteID,TBL_INVITATION);
				if(!$check){
					$insert['invite_email'] =  $userdataobj->email;
					$insert['invite_id_user'] =  $userdataobj->id_user;
					$insert['invited_email'] =  $email;
					$insert['invite_msg'] =  $message;
					$insert['invite_confirm'] =  $inviteID;
					$insert['invite_date'] =  mysqlDate();
					$this->mod_io_m->insert_map($insert,TBL_INVITATION);
				}else{
					$update['invite_msg'] =  $message;
					$update['invite_date'] =  mysqlDate();
					$this->mod_io_m->update_map($update,array('invite_confirm'=>$inviteID),TBL_INVITATION);
				}
				
				/*
				$body = $this->load->view('member/email_templates/friend/invite_friend', 
										array('invite_link'=>$invite_link,'userdataobj'=>$userdataobj,'message'=>$message),
										true
									);
				*/					
				$this->email_sender->setBody($message);		
				$this->email_sender->sendEmail();		
				
			}
		}
		
		$msg = "Sent email successfully: ".$i;
		$msg .= "<br/> Failure: ".count($notEmailArr);
		$msg .= "<br/><div class='clear'></div>";
		if(count($userdataExisted) != 0){
			$msg .= "<br/>These users were existed in system:<br/><div class='clear'></div>";
			foreach($userdataExisted as $item){
				$msg .= "<div class=\"wrap-left\" style=\"width:100px;\"><div class=\"user-profile-owner\">";
				$msg .= "<img src='".$this->user_m->getProfileAvatar($item->id_user)."' /><br/>";
				$msg .= "".$this->user_m->getProfileDisplayName($item->id_user)."</div></div>";
				$msg .= "<div class=\"wrap-right\"><div class=\"user-profile-owner\">";
				$msg .= "<b>Email:</b> ".$item->email;
				$msg .= "</div></div><div class='clear'></div><hr/>";
			}
		}
		echo $msg;
		exit;
	}
	
	function inviteFacebookFriend(){
		$friend_fb_id = isset($_POST['usercheck'])?$_POST['usercheck']:null;
		$message = substr( $this->input->post('message'), 0, 200 );
		
		if(!$friend_fb_id){
			echo 'Please choose any people first.';
			exit;
		}
		
		$userdataobj = getAccountUserDataObject();
		$invite_url = $this->user_io_m->getInviteUrl($userdataobj->username);
		$description = $GLOBALS['global']['FACEBOOK']['FirstStatusDescription'];
		
		foreach($friend_fb_id as $id_fb){
			//$this->facebookmodel->inviteFacebookUser($id_fb, $message, $description, $invite_url);
			$rs = $this->facebookconnect_io_m->postOnFacebookUserWall(getAccountUserId(),$id_fb, $message, $description, $invite_url);
			debug("post on fb: $rs");
		}	
		
		echo 'ok';
		exit;
	}
	
	function inviteTwitterFriend(){
		$friend_name = isset($_POST['usercheck'])?$_POST['usercheck']:null;
		$message = substr( $this->input->post('message'), 0, 80 );
		
		if(!$friend_name){
			echo 'Please choose any people first.';
			exit;
		}
		
		$userdataobj = getAccountUserDataObject();
		$invite_url = $this->user_io_m->getInviteUrl($userdataobj->username);
		
		foreach($friend_name as $usertt){
			$this->twittermodel->tweetOnOther($message, $invite_url, $usertt);
		}	
		
		echo 'ok';
		exit;
	}
	
	
	
//endclass
}	