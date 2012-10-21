<?php defined('BASEPATH') or exit('No direct script access allowed');

class Peeped_access_io_m extends MY_Model {
	function __construct(){
		parent::__construct();
		$this->load->model( 'user/peepbought_history_m' );
	}
	
	function submitBuyPeepedAccess(){
		$userdataobj = getAccountUserDataObject(true);
		$id_user = $this->input->post('id_user',0);
		$sellerdataobj = $this->user_io_m->init('id_user',$id_user);
		
		$days = $this->input->post('days',0);
		
		$amountfee = $days*$sellerdataobj->peep_access;
		$cash = $userdataobj->cash;
		
		if($cash < $amountfee){
			echo json_encode(
			array(
					'result' => 'ERROR',
					'message'	=> 'Your balance is not enough to access peeped.'
				)
			);
			exit;
		}
		
		if($days<1){
			echo json_encode(
			array(
					'result' => 'ERROR',
					'message'	=> 'Unknown error.'
				)
			);
			exit;
		}
		
		$data['id_buyer'] = getAccountUserId();
		$data['id_user'] = $id_user;
		$data['amount'] = $amountfee;
		$data['ip'] = $this->geo_lib->getIpAddress();
		$data['access_days'] = $days;
		$data['buy_date'] = mysqlDate();
		$data['exp_date'] = sysDateTimeFormat( (mysql_to_unix($data['buy_date']) + 86400*$days ) , 'Y-m-d H:i:s' );
		
		$id_history = $this->mod_io_m->insert_map($data,TBL_PEEPBOUGHT_HISTORY);
		
		$site_amt = $amountfee*($GLOBALS['global']['PEEP_PRICE']['site']/100);
		$user_amt = $amountfee*($GLOBALS['global']['PEEP_PRICE']['user']/100);
		
		$transaction_data = array();
		$transaction_data['id_owner'] = getAccountUserId();
		$transaction_data['id_user'] = $data['id_user'];
		$transaction_data['amount'] = $data['amount'];
		$transaction_data['trans_type'] = $GLOBALS['global']['TRANS_TYPE']['buy_peeped'];
		$transaction_data['site_amt'] = $site_amt;
		$transaction_data['user_amt'] = $user_amt;
		$transaction_data['trans_date'] = mysqlDate();
		$transaction_data['ip'] = $this->geo_lib->getIpAddress();
		
		$transaction_id = $this->mod_io_m->insert_map($transaction_data,TBL_TRANSACTION);
		if($transaction_id){
			$this->db->query( "UPDATE ".TBL_USER." SET cash= cash +'".$site_amt."' WHERE id_admin=1" );
			$this->db->query( "UPDATE ".TBL_USER." SET cash= cash -'".$data['amount']."' WHERE id_user='".getAccountUserId()."'" );
			$this->db->query( "UPDATE ".TBL_USER." SET cash= cash +'".$user_amt."' WHERE id_user='".$data['id_user']."'" );
		}
		
		
		$CMCHATMSG = str_replace(array('$u1','$u2','$p3'),array($userdataobj->username,$sellerdataobj->username,$amountfee),language_translate('hook_chat_buy_peep_access'));
		echo json_encode(
			array(
				'result' => 'ok',
				'message'	=> 'Buy peeped access successfully.',
				'CMCHATMSG' => $CMCHATMSG
			)
		);
		
		$this->email_sender->juzonSendEmail_JUZ_WHO_BOUGHT_WHO_PEEPED_ME($transaction_data['id_owner'],$transaction_data['id_user'],$transaction_data['amount']);
		
		exit;
	}
	
	
	
	
//endclass
}	