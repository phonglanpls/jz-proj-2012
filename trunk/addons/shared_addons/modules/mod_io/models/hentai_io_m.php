<?php defined('BASEPATH') or exit('No direct script access allowed');

class Hentai_io_m extends MY_Model {
	function __construct(){
		parent::__construct();
		$this->load->model('user/hentai_m');
	}
	
	function downloadVideo(){
		$id_video = $this->input->post('id_video');
		$videodata = $this->mod_io_m->init('id_video',$id_video,TBL_VIDEO);
		
		$link = $this->hentai_m->getFacebookVideoSource($id_video);
		
		if(!$link){
			echo json_encode(
				array(
					'result'=>'ERROR',
					'message' => 'Link is not existed. Download failure.'
				)
			);
			exit;
		}else{
		
			$sql = "INSERT INTO ".TBL_TRANSACTION." (id_owner,id_user,amount,trans_type,site_amt,trans_date,ip) 
					VALUES('".getAccountUserId()."',1,'".$GLOBALS['global']['ADMIN_DEFAULT']['download']."','".
							$GLOBALS['global']['TRANS_TYPE']['download']."','".
							$GLOBALS['global']['ADMIN_DEFAULT']['download']."',NOW(),'".$_SERVER['REMOTE_ADDR']."')";							
			$this->db->query($sql);
        
			$this->db->query( "UPDATE ".TBL_USER." SET cash= cash +'".$GLOBALS['global']['ADMIN_DEFAULT']['download']."' WHERE id_admin=1");
			$this->db->query( "UPDATE ".TBL_USER." SET cash= cash -'".$GLOBALS['global']['ADMIN_DEFAULT']['download']."' WHERE id_user='".getAccountUserId()."'" );

			$session_key = md5(getAccountUserId().time().$id_video);
			$_SESSION['file'][$session_key] = array('name'=>slugify( $videodata->name ).'.mp4', 'link'=>$link);
			
			//$downloadLink = site_url().'download.php?id='.$session_key;
			$downloadLink = $link;
			echo json_encode(
				array(
					'result'=>'ok',
					'message' => "<div id='downloadIconID'><a href='$downloadLink' target='_blank'><img src='".site_url().'media/images/download.png'."' /></a></div>"
				)
			);
			exit;
		}
	}	
	
	
	
	
	
	
	
//endclass
}	