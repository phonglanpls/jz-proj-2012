<?php defined('BASEPATH') or exit('No direct script access allowed');
/**
 * @package 	PyroCMS
 * @subpackage  Templates Module
 * @category	Module
 */
class Juzon_report_m extends MY_Model {
	
	function __construct()
    {
        parent::__construct();
    }
	
	function deleteLoginItem(){
		$this->db->query("DELETE FROM ".TBL_LOGIN." WHERE id_login IN(".$this->input->post('id_str').")");
		exit;		
	}	
	
	function saveIPBlocked(){
		$data['ip'] = $this->input->post('ip');
		
		if($data['ip']){
			$this->mod_io_m->insert_map($data,TBL_BLOCKEDIP_LOGIN);
		}
		echo 'ok';
		$this->session->set_flashdata('success', lang('templates.tmpl_save_success') );
		exit;
	}
	
	function deleteIP(){
		$this->db->where('id_blockedip_login',$this->input->post('id_blockedip_login'))->delete(TBL_BLOCKEDIP_LOGIN);
		exit;
	}
	
	function deleteLoginLogItem(){
	    $this->db->query("DELETE FROM ".TBL_BLOCKIP." WHERE id_block IN(".$this->input->post('id_str').")");
		exit;
	}
	
	function deleteReportAbuseItem(){
		$this->db->query("DELETE FROM ".TBL_REPORT_ABUSE." WHERE id_report_abuse IN(".$this->input->post('id_str').")");
		exit;
	}
//endclass
}	