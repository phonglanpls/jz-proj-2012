<?php defined('BASEPATH') or exit('No direct script access allowed');
/**
 * @package 	PyroCMS
 * @subpackage  Templates Module
 * @category	Module
 */
class Juzon_config_m extends MY_Model {
	
	function __construct()
    {
        parent::__construct();
    }

	function submit_config(){
		foreach($_POST as $key=>$val){
			foreach($val as $k=>$v){
				foreach($v as $kk=>$vv){
					$value = mysql_real_escape_string($vv);
					$qr = "UPDATE ".TBL_CONFIG." SET value='$value' WHERE name='$k' AND ckey='$kk' "; 
					$this->db->query($qr);
				}
			}
		}
		
		$this->session->set_flashdata('success', lang('templates.tmpl_save_success') );
		// $this->session->set_flashdata('error', (lang('templates.tmpl_error')));
		getGlobalConfig();
		
		print_r('ok');
		exit;
	}
	
	function toggleHentaiSection(){
		$rs = $this->db->query("SELECT * FROM ".TBL_CONFIG." WHERE name LIKE 'HENTAI' AND ckey LIKE 'show'")->result();
		
		if($rs[0]->value == 0){
			$upd = 1;
		}else{
			$upd = 0;
		}
		$this->db->query("UPDATE ".TBL_CONFIG." SET value='$upd' WHERE name LIKE 'HENTAI' AND ckey LIKE 'show'");
		$statusArr = adminStatusItemOptionData_ioc();
		getGlobalConfig();
		
		echo $statusArr[$upd];
		exit;
	}
	
	function saveAnnouncement(){
		$announcement = $this->input->post('announcement');
		$is_show = $this->input->post('is_show');
		 
		$this->db->query( "UPDATE ".TBL_CONFIG." SET f_value='".mysql_real_escape_string($announcement)."', value='".intval($is_show)."' 
							WHERE name LIKE 'ANNOUNCEMENT' AND f_key LIKE 'content' " ) ;
		echo 'ok';
		getGlobalConfig();
		$this->session->set_flashdata('success', lang('templates.tmpl_save_success') );
		
		exit; 
	}
	
	function sendAnnouncementEmail(){
		//$qr = "SELECT u.id_user FROM ".TBL_USER." AS u INNER JOIN ".TBL_EMAILSETTING." AS es ON u.id_user=es.id_user ";
		//$qr .= " WHERE u.status=0 AND es.announcement=1";
		$qr = "SELECT id_user FROM ".TBL_USER." WHERE status=0";
		
		$rs = $this->db->query($qr)->result();
		
		$announcement = $this->db->query( " SELECT * FROM ".TBL_CONFIG." WHERE name LIKE 'ANNOUNCEMENT' AND f_key LIKE 'content'")->result();
			
		$slug = "JUZ_ADMIN_ANNOUNCEMENT";
		$template = $this->module_helper->getTemplateMail( $slug );
		
		foreach($rs as $item){
			$userdataobj = $this->user_io_m->init('id_user',$item->id_user);
			$useremailsetting = $this->email_setting_io_m->init($item->id_user);
			
			if($useremailsetting->announcement == 1){
				$arrayMaker = array( '$username1', '{announcement}' );
				$arrayReplace = array( $userdataobj->username, 
										$announcement[0]->f_value
									);
				$subject = str_replace( $arrayMaker, $arrayReplace, $template['subject'] );			
				$body = str_replace( $arrayMaker , $arrayReplace , $template['body'] );	
				
				$this->email_sender->setToEmail($userdataobj->email);
				$this->email_sender->setSubject($subject);
				$this->email_sender->setBody($body);
				
				if( SENDMAIL != 0 ) {							
					$this->email_sender->sendEmail();
				}
				if(ENVIRONMENT == 'development'){
					debug(
						'JUZ_ADMIN_ANNOUNCEMENT: subj:'.$subject.'|body:'.$body.'|to email:'.$userdataobj->email
					);
				}
			}
		}
		
		echo 'Sent email successfully.';
		exit;
	}
	
	
	function saveQuestionIdea(){
		$question = $this->input->post('question');
		$id_question = $this->input->post('id_question');
		
		if($id_question){
			$this->db->where('id_question',$id_question)->update(TBL_QUESTION_DEF,array('question'=>$question));
		}else{
			$this->db->insert(TBL_QUESTION_DEF,array('question'=>$question, 'add_date'=>mysqlDate(), 'ip'=>$this->geo_lib->getIpAddress())); 	
		}
		echo 'ok';
		
		$this->session->set_flashdata('success', lang('templates.tmpl_save_success') );
		exit;
	}
	
	function deleteQuestionIdea(){
		$id_question = $this->input->post('id_question');
		$this->db->where('id_question',$id_question)->delete(TBL_QUESTION_DEF);
		exit;
	}
	
	
	
	function toggleStatusLock(){
		$id_petlock = $this->input->post('id_petlock');
		$lockdata = $this->mod_io_m->init('id_petlock',$id_petlock,TBL_PETLOCK);
		
		if($lockdata->status == 1){
			$stt = 0;
			$this->db->where('id_petlock',$id_petlock)->update(TBL_PETLOCK, array('status'=>0));
		}else{
			$stt = 1;
			$this->db->where('id_petlock',$id_petlock)->update(TBL_PETLOCK, array('status'=>1));
		}
		$statusArr = adminStatusItemOptionData_ioc();
		echo $statusArr[$stt];
		exit;
	}
	
	function deleteLock(){
		$id_petlock = $this->input->post('id_petlock');
		$this->db->where('id_petlock',$id_petlock)->delete(TBL_PETLOCK);
		exit;
	}
	
	function savePetLock(){
		$id_petlock = intval( $this->input->post('id_petlock',0) );
		$lockdata = $this->mod_io_m->init('id_petlock',$id_petlock,TBL_PETLOCK);
		
		if($lockdata){
			$image = $lockdata->image;
		}else{
			$image = '';
		}
		
		$uploadDir  = APP_ROOT.$GLOBALS['global']['IMAGE']['image_orig'];
		$thumbnailDir = APP_ROOT.$GLOBALS['global']['IMAGE']['image_thumb'];
		$thumb_height = 60;
		$thumb_width = 60;
	
		if(isset($_FILES["image"]) AND !empty($_FILES["image"]['name'])) {
			if(($_FILES["image"]['size']/1000000) > allowMaxFileSize() ){
				$image = '';
			}else{
				$image = $this->module_helper->uploadFile( 
										$_FILES["image"]['tmp_name'],
										$_FILES["image"]['name'],
										$uploadDir,
										allowExtensionPictureUpload()
									);
			}	
		}
		
		if(!$image){
			echo 'Image must not empty';exit;
		}else{
			copy($uploadDir.$image, $thumbnailDir.$image);
			makeThumb($image,$thumbnailDir,$thumb_width,$thumb_height);
			
			$data['image'] = $image;
		}
		
		if(! $this->phpvalidator->is_numeric($this->input->post('price'))){
			echo 'Price must be numeric.';exit;
		}else{
			$data['price'] = $this->input->post('price');
		}
		
		if(! $this->phpvalidator->is_numeric($this->input->post('chargeperday'))){
			echo 'Charge per day must be numeric.';exit;
		}else{
			$data['chargeperday'] = $this->input->post('chargeperday');
		}
		
		if($this->input->post('name')){
			$data['name'] = $this->input->post('name');
			$data['code_lock'] = slugify( $this->input->post('name') );
		}
		$data['add_date'] = mysqlDate();
		$data['ip'] = $this->geo_lib->getIpAddress();
		
		if($lockdata){
			$this->mod_io_m->update_map($data, array('id_petlock'=>$id_petlock),TBL_PETLOCK);
		}else{
			$this->mod_io_m->insert_map($data, TBL_PETLOCK);
		}
		echo 'ok';
		$this->session->set_flashdata('success', lang('templates.tmpl_save_success') );
		exit;
	}
	
	
//endclass   
}
