<?php defined('BASEPATH') or exit('No direct script access allowed');

class Report_abuse_m extends MY_Model {
	function __construct(){
		parent::__construct();
	}
	
	function wasIReportThisUser($id_user){
		$rs = $this->db->query("SELECT * FROM ".TBL_REPORT_ABUSE." WHERE id_reporter=".getAccountUserId()." AND id_user=$id_user" )->result();
		return ($rs)?$rs[0]:false;
	}	
	
	function submitReportAbuse(){
		$data['id_user'] = $this->input->post('id_user');
		$data['id_reporter'] = getAccountUserId();
		$data['message'] = substr( $this->input->post('message'), 0 , $GLOBALS['global']['INPUT_LIMIT']['askmeq']);
		$data['datetime'] = mysqlDate();
		
		$this->mod_io_m->insert_map($data,TBL_REPORT_ABUSE);
		echo 'ok';
		exit;
	}
	
	
	
	
	
	
	
//endclass
}	