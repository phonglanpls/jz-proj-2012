<?php defined('BASEPATH') or exit('No direct script access allowed');

class Block_m extends MY_Model {
	function __construct(){
		parent::__construct();
		$this->load->model('user/mapflirt_m');
	}
	
	function mapBlockContextStatus($user_other_id){
		if( $this->mapflirt_m->checkUserBlockedOther( getAccountUserId(), $user_other_id) ){ //was blocked
			$status = 'Unblock';
		}else{
			$status = 'Block';
		}
		
		$html = "<a href='javascript:void(0);' onclick='callFuncToggleBlockStatus($user_other_id);' id='status_$user_other_id'>$status</a>";
		$html .= loader_image_s("id='mapBlockContextLoader_$user_other_id' class='hidden'");	
		return $html;
	}
	
	function toggleBlockStatusMapAccess(){
		$user_other_id = $this->input->post('id_user');
		
		if( $blockdata = $this->mapflirt_m->checkUserBlockedOther( getAccountUserId(), $user_other_id)){ //was blocked
			$this->db->where('id_blocked',$blockdata->id_blocked)->delete(TBL_BLOCKED_LIST);
			echo 'Block';
			exit;
		}else{
			$data['id_user'] = $user_other_id ;
			$data['blocked_user'] = getAccountUserId();
			$data['blocked_type'] = $GLOBALS['global']['BLOCK_TYPE']['map'];
			$data['message'] = '';
			$data['add_date'] = mysqlDate();
			$data['ip'] = $this->geo_lib->getIpAddress();
			
			$this->mod_io_m->insert_map($data,TBL_BLOCKED_LIST);
			echo 'Unblock';
			exit;
		}
	}
	
	function deleteChatBlock(){
		$user_to_id = $this->input->post('id_user');
		$current_dbprefix = $ci->db->dbprefix;
		$this->db->set_dbprefix('');
		 
		$this->db->where('fromid',getAccountUserId())->where('toid',$user_to_id)->delete('cometchat_block');
		
		$this->db->set_dbprefix($current_dbprefix);
		exit;
	}
	
	
//endclass
}	