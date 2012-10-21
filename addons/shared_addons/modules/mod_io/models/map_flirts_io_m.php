<?php defined('BASEPATH') or exit('No direct script access allowed');

class Map_flirts_io_m extends MY_Model {
	function __construct(){
		parent::__construct();
		$this->load->model( 'user/mapflirt_m' );
	}
	
	function submitChangeMapValue(){
		$mapvalue = intval( $this->input->post('mapvalue') );
		$update['map_access '] = $mapvalue;
		$this->user_io_m->update_map($update,getAccountUserId());
		exit;
	}	
	
	function submitAccessMapFlirts(){
		$id_user_arr = array_filter( explode(',',$this->input->post('id_user_str')) );
		
		$total = 0;
		$data = array();
		$i=0;
		foreach($id_user_arr as $id_user){
			if(! $this->mapflirt_m->wasIMapedUser($id_user)){
				$sellerdataobj = $this->user_io_m->init('id_user',$id_user);
				
				$data[$i]['id_buyer'] = getAccountUserId();
				$data[$i]['id_seller'] = $id_user;
				$data[$i]['amount'] = $sellerdataobj->map_access;
				$data[$i]['map_days'] = 1;
				$data[$i]['buy_date'] = mysqlDate();
				$data[$i]['exp_date'] = sysDateTimeFormat( (mysql_to_unix($data[$i]['buy_date']) + 86400 ) , 'Y-m-d H:i:s' );
				$data[$i]['ip'] = $this->geo_lib->getIpAddress();
				
				$total += $data[$i]['amount'];
				$i++;
			}
		}
		
		$userdataobj = getAccountUserDataObject(true);
		if($userdataobj->cash < $total){
			echo json_encode(
			array(
					'result' => 'ERROR',
					'message'	=> 'Your balance is not enough to access map flirts.'
				)
			);
			exit;
		}
		
		foreach($data as $key=>$value){
			$id_history = $this->mod_io_m->insert_map($value,TBL_MAP_HISTORY);
			
			$site_amt = $value['amount']*($GLOBALS['global']['MAP_PRICE']['site']/100);
			$user_amt = $value['amount']*($GLOBALS['global']['MAP_PRICE']['user']/100);
			
			$transaction_data = array();
			$transaction_data['id_owner'] = getAccountUserId();
			$transaction_data['id_user'] = $value['id_seller'];
			$transaction_data['amount'] = $value['amount'];
			$transaction_data['trans_type'] = $GLOBALS['global']['TRANS_TYPE']['map'];
			$transaction_data['site_amt'] = $site_amt;
			$transaction_data['user_amt'] = $user_amt;
			$transaction_data['trans_date'] = mysqlDate();
			$transaction_data['ip'] = $this->geo_lib->getIpAddress();
			
			$transaction_id = $this->mod_io_m->insert_map($transaction_data,TBL_TRANSACTION);
			if($transaction_id){
				$this->db->query( "UPDATE ".TBL_USER." SET cash= cash +'".$site_amt."' WHERE id_admin=1" );
				$this->db->query( "UPDATE ".TBL_USER." SET cash= cash -'".$value['amount']."' WHERE id_user='".getAccountUserId()."'" );
				$this->db->query( "UPDATE ".TBL_USER." SET cash= cash +'".$user_amt."' WHERE id_user='".$value['id_seller']."'" );
			}
			
			$this->email_sender->juzonSendEmail_JUZ_WHO_BOUGHT_MY_MAPFLIRTS($transaction_data['id_owner'],$transaction_data['id_user'],$transaction_data['amount']);
		}
		
		echo json_encode(
			array(
				'result' => 'ok',
				'message'	=> 'successfully'
			)
		);
		exit;
	}
	
	function submitExtendAccessMapFlirts(){
		$userdataobj = getAccountUserDataObject(true);
		$id_user = $this->input->post('id_user',0);
		$sellerdataobj = $this->user_io_m->init('id_user',$id_user);
		
		$days = $this->input->post('days',0);
		
		$amountfee = $days*$sellerdataobj->map_access;
		$cash = $userdataobj->cash;
		
		if($cash < $amountfee){
			echo json_encode(
			array(
					'result' => 'ERROR',
					'message'	=> 'Your balance is not enough to access map flirts.'
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
		
		if($this->mapflirt_m->checkUserBlockedOther($id_user,getAccountUserId())){
			echo json_encode(
			array(
					'result' => 'ERROR',
					'message'	=> 'Error. This user was blocked you from access map location.'
				)
			);
			exit;
		}
		
		$historydata = $this->mapflirt_m->getHistory($id_user);
		
		if($historydata){
			$data['id_buyer'] = getAccountUserId();
			$data['id_seller'] = $id_user;
			$data['amount'] = $amountfee;
			$data['ip'] = $this->geo_lib->getIpAddress();
			
			if( mysql_to_unix($historydata->exp_date) > mysql_to_unix(mysqlDate()) ){ // extend
				$data['buy_date'] = $historydata->buy_date;
				$data['exp_date'] = sysDateTimeFormat( (mysql_to_unix($historydata->exp_date) + 86400*$days ) , 'Y-m-d H:i:s' );
				$data['map_days'] = $days + (int) ( (mysql_to_unix($historydata->exp_date))/86400 );
			}else{ //re-buy
				$data['buy_date'] = mysqlDate();
				$data['exp_date'] = sysDateTimeFormat( (mysql_to_unix($data['buy_date']) + 86400*$days ) , 'Y-m-d H:i:s' );
				$data['map_days'] = $days;
			}
			
			$id_history = $this->mod_io_m->update_map($data,array('id_map_history'=>$historydata->id_map_history),TBL_MAP_HISTORY);
			
			$site_amt = $amountfee*($GLOBALS['global']['MAP_PRICE']['site']/100);
			$user_amt = $amountfee*($GLOBALS['global']['MAP_PRICE']['user']/100);
			
			$transaction_data = array();
			$transaction_data['id_owner'] = getAccountUserId();
			$transaction_data['id_user'] = $data['id_seller'];
			$transaction_data['amount'] = $data['amount'];
			$transaction_data['trans_type'] = $GLOBALS['global']['TRANS_TYPE']['map'];
			$transaction_data['site_amt'] = $site_amt;
			$transaction_data['user_amt'] = $user_amt;
			$transaction_data['trans_date'] = mysqlDate();
			$transaction_data['ip'] = $this->geo_lib->getIpAddress();
			
			$transaction_id = $this->mod_io_m->insert_map($transaction_data,TBL_TRANSACTION);
			if($transaction_id){
				$this->db->query( "UPDATE ".TBL_USER." SET cash= cash +'".$site_amt."' WHERE id_admin=1" );
				$this->db->query( "UPDATE ".TBL_USER." SET cash= cash -'".$data['amount']."' WHERE id_user='".getAccountUserId()."'" );
				$this->db->query( "UPDATE ".TBL_USER." SET cash= cash +'".$user_amt."' WHERE id_user='".$data['id_seller']."'" );
			}
			debug("extend/buy map location transaction id=$transaction_id ");
			
			$this->email_sender->juzonSendEmail_JUZ_WHO_BOUGHT_MY_MAPFLIRTS($transaction_data['id_owner'],$transaction_data['id_user'],$transaction_data['amount']);
		}else{
			$i = 0;
			if(! $this->mapflirt_m->wasIMapedUser($id_user)){
				$sellerdataobj = $this->user_io_m->init('id_user',$id_user);
				
				$data[$i]['id_buyer'] = getAccountUserId();
				$data[$i]['id_seller'] = $id_user;
				$data[$i]['amount'] = $sellerdataobj->map_access;
				$data[$i]['map_days'] = 1;
				$data[$i]['buy_date'] = mysqlDate();
				$data[$i]['exp_date'] = sysDateTimeFormat( (mysql_to_unix($data[$i]['buy_date']) + 86400 ) , 'Y-m-d H:i:s' );
				$data[$i]['ip'] = $this->geo_lib->getIpAddress();

				foreach($data as $key=>$value){
					$id_history = $this->mod_io_m->insert_map($value,TBL_MAP_HISTORY);
					
					$site_amt = $value['amount']*($GLOBALS['global']['MAP_PRICE']['site']/100);
					$user_amt = $value['amount']*($GLOBALS['global']['MAP_PRICE']['user']/100);
					
					$transaction_data = array();
					$transaction_data['id_owner'] = getAccountUserId();
					$transaction_data['id_user'] = $value['id_seller'];
					$transaction_data['amount'] = $value['amount'];
					$transaction_data['trans_type'] = $GLOBALS['global']['TRANS_TYPE']['map'];
					$transaction_data['site_amt'] = $site_amt;
					$transaction_data['user_amt'] = $user_amt;
					$transaction_data['trans_date'] = mysqlDate();
					$transaction_data['ip'] = $this->geo_lib->getIpAddress();
					
					$transaction_id = $this->mod_io_m->insert_map($transaction_data,TBL_TRANSACTION);
					if($transaction_id){
						$this->db->query( "UPDATE ".TBL_USER." SET cash= cash +'".$site_amt."' WHERE id_admin=1" );
						$this->db->query( "UPDATE ".TBL_USER." SET cash= cash -'".$value['amount']."' WHERE id_user='".getAccountUserId()."'" );
						$this->db->query( "UPDATE ".TBL_USER." SET cash= cash +'".$user_amt."' WHERE id_user='".$value['id_seller']."'" );
					}
					debug("extend/buy map location transaction id=$transaction_id ");
					
					$this->email_sender->juzonSendEmail_JUZ_WHO_BOUGHT_MY_MAPFLIRTS($transaction_data['id_owner'],$transaction_data['id_user'],$transaction_data['amount']);
				}	
				
			}
		}
		
		$context = $this->input->post('context');
		if($context == 'CMCHAT'){
			$CMCHAT = str_replace(array('$u1','$u2','$p3'), array($userdataobj->username, $sellerdataobj->username,$amountfee), language_translate('hook_chat_buy_map'));
		}else{
			$CMCHAT = '';
		}
		
		echo json_encode(
			array(
				'result' => 'ok',
				'message'	=> 'Buy successfully.',
				'CMCHATMSG' => $CMCHAT
			)
		);
		exit;
		
	}
	
	
//endclass
}	