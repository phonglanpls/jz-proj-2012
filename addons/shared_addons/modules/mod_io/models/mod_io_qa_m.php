<?php defined('BASEPATH') or exit('No direct script access allowed');

class Mod_io_qa_m extends MY_Model {
	function __construct(){
		parent::__construct();
		$this->load->model('user/wall_m');
	}
	
	function submitAQuestion(){
		$question = $this->input->post("question");
		$anonymous = $this->input->post("anonymous",0);
		$id_user = $this->input->post("id_user");
		
		$array['question'] = substr($question,0,$GLOBALS['global']['INPUT_LIMIT']['askmeq']);
		$array['asked_to'] = $id_user;
		$array['ques_date'] = mysqlDate();
		$array['q_status'] = 0; // unread
		$array['flag'] = 0; // undelete
		if($anonymous == 1){
			$array['asked_by'] = 0;
		}else{
			$array['asked_by'] = getAccountUserId();
		}
		$this->mod_io_m->insert_map($array,TBL_ASK_QUESTION);
		echo 'ok';
		
		$this->email_sender->juzonSendEmail_JUZ_ASKME_A_QUESTION($array['asked_by'], $array['asked_to'] , $array['question']);
		
		exit;
	}
	
	function submitAnswerQuestion(){
		$id_question = $this->input->post("id_question");
		$answer = $this->input->post("answer");
		
		$questionRecord 	= $this->qa_m->getRecord_Question($id_question);
		$array['answer'] 	= substr($answer,0,$GLOBALS['global']['INPUT_LIMIT']['askme_answer']);
		$array['id_askmeq'] = $id_question;
		$array['asked_by'] 	= $questionRecord->asked_by;
		$array['ans_by'] 	= getAccountUserId();
		$array['ans_date'] 	= mysqlDate();
		$this->mod_io_m->insert_map($array,TBL_ASK_ANSWER);
		
		//update question status
		$update['q_status'] = 1;
		$this->mod_io_m->update_map($update,array('id_askmeq'=>$id_question),TBL_ASK_QUESTION);
		
		//also insert into wall feed
		$wall['id_parent'] 		= 0;
		$wall['id_user']		= getAccountUserId();
		$wall['description']	= $array['answer'];
		$wall['add_date_post']  = mysqlDate(); 
		$wall['post_id']		=	0;	
		$wall['id_ques']		=	$id_question;	
		$id_wall = $this->mod_io_m->insert_map( $wall, TBL_WALL );
		
		echo 'ok';
		
		$this->email_sender->juzonSendEmail_JUZ_ASKME_ANSWER($array['asked_by'], $array['ans_by'] , $array['answer']);
		
		$this->user_io_m->postItemOnFbTt($id_wall, TIMELINE_AKSME_ANSWER);
		exit;
	}
	
	function deleteQuestion(){
		$id_question = $this->input->post('id_question',0);
		$update['flag'] = 1;
		$this->mod_io_m->update_map($update,array('id_askmeq'=>$id_question),TBL_ASK_QUESTION);
		echo json_encode(array('result'=>'OK'));
		exit;
	}
	
//endclass
}	