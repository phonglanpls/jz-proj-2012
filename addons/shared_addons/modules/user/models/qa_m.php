<?php defined('BASEPATH') or exit('No direct script access allowed');

class Qa_m extends MY_Model {
	function __construct(){
		parent::__construct();
	}
	
	function getRecord_Question($question_id){
		$rs = $this->db->where('id_askmeq',$question_id)->get(TBL_ASK_QUESTION)->result();
		return $rs[0];
	}
	
	function getRecord_Answer($answer_id){
		$rs = $this->db->where('id_askmea',$answer_id)->get(TBL_ASK_ANSWER)->result();
		return $rs[0];
	}
	
	function getUnreadQuestion($id_user){
		$res = $this->db->where( array('asked_to'=>$id_user, 'q_status'=>0, 'flag'=>0) )->order_by('ques_date','desc')->get(TBL_ASK_QUESTION)->result();
		return $res;
	}
	
	function getAnswers($id_user){
		//$res = $this->db->where( array('ans_by'=>$id_user) )->order_by('ans_date','desc')->get(TBL_ASK_ANSWER)->result();
		$res = $this->db
				->query("SELECT * FROM ".TBL_ASK_ANSWER." AS tblA INNER JOIN ".TBL_ASK_QUESTION." AS tblQ 
						ON tblA.id_askmeq=tblQ.id_askmeq WHERE tblA.ans_by=$id_user AND tblQ.flag=0 ORDER BY tblA.ans_date DESC")
				->result();
		return $res;
	}
	
	function getLog($id_user){
		$res = $this->db
				->query("SELECT tblQ.*,tblA.answer AS answer FROM ".TBL_ASK_QUESTION." AS tblQ LEFT JOIN ".TBL_ASK_ANSWER." AS tblA 
						ON tblA.id_askmeq=tblQ.id_askmeq WHERE tblQ.asked_to=$id_user AND tblQ.asked_by = ".getAccountUserId()." AND tblQ.flag=0 ORDER BY tblQ.ques_date DESC")
				->result();
		return $res;
	}
	
	function getQuestionIdea($offset=0, $rec_per_page=0){
		$sql = "SELECT * FROM ".TBL_QUESTION_DEF." ";
		if($rec_per_page){
			$sql .= " LIMIT $offset, $rec_per_page";
		}
		return $this->db->query($sql)->result();
	}
	
	
	
//endclass	
}	