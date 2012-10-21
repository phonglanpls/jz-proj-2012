<?php defined('BASEPATH') or exit('No direct script access allowed');

class Favourite_io_m extends MY_Model {
	function __construct(){
		parent::__construct();
	}
	
	function addUserToMyFvList(){
		$to_id_user = $this->input->post('id_user');
		$from_id_user = getAccountUserId();
		
		$rs = $this->db->where('from_id_user',$from_id_user)->where('to_id_user',$to_id_user)->get(TBL_CHAT_FAVOURITE)->result();
		
		if(!$rs){
			$data['to_id_user'] = $to_id_user;
			$data['from_id_user'] = $from_id_user;
			$data['datetime'] = mysqlDate();
			$this->mod_io_m->insert_map($data,TBL_CHAT_FAVOURITE);
		}
		
		$userdata = getAccountUserDataObject();
		$touserdata = $this->user_io_m->init('id_user',$to_id_user);
		
		$CMCHATMSG = str_replace(array('$u1','$u2'), array($userdata->username,$touserdata->username), language_translate('hook_chat_add_chat_favourite'));
		
		echo json_encode(
			array(
				'result'=>'ok',
				'message'=>'Add to favorite successfully.',
				'CMCHATMSG' => $CMCHATMSG
			)
		);
		exit;
	}
	
	function deleteItem(){
		$to_id_user = $this->input->post('id_user');
		$from_id_user = getAccountUserId();
		$this->db->where('from_id_user',$from_id_user)->where('to_id_user',$to_id_user)->delete(TBL_CHAT_FAVOURITE);
		exit;
	}
	
	function buyFavouriteAccessPackage(){
		$userdata = getAccountUserDataObject(true);
		if($userdata->cash < $GLOBALS['global']['ADMIN_DEFAULT']['favourite']){
			echo json_encode(
				array(
					'result'=>'error',
					'message' => "Your balance is not enough to buy this package."
				)
			);
			exit;
		}
		
		$sql = "INSERT INTO ".TBL_TRANSACTION." (id_owner,id_user,amount,trans_type,site_amt,trans_date,ip) 
					VALUES('".getAccountUserId()."',1,'".$GLOBALS['global']['ADMIN_DEFAULT']['favourite']."','".
							$GLOBALS['global']['TRANS_TYPE']['favourite']."','".
							$GLOBALS['global']['ADMIN_DEFAULT']['favourite']."',NOW(),'".$_SERVER['REMOTE_ADDR']."')";							
		$this->db->query($sql);
        
		$this->db->query( "UPDATE ".TBL_USER." SET cash= cash +'".$GLOBALS['global']['ADMIN_DEFAULT']['favourite']."' WHERE id_admin=1");
		$this->db->query( "UPDATE ".TBL_USER." SET cash= cash -'".$GLOBALS['global']['ADMIN_DEFAULT']['favourite']."' WHERE id_user='".getAccountUserId()."'" );
		
		$data['id_user'] = getAccountUserId();
		$data['price'] = $GLOBALS['global']['ADMIN_DEFAULT']['favourite'];
		$data['datetime'] = mysqlDate();
		
		$this->mod_io_m->insert_map($data,TBL_FAVOURITE_BUY_LOG);
		
		echo json_encode(
				array(
					'result'=>'ok',
					'message' => "Buy Favourite View Package successfully."
				)
			);
		exit;
	}
	
	
	
	
//endclass
}	