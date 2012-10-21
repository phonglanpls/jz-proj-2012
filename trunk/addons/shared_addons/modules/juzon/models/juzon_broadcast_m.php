<?php defined('BASEPATH') or exit('No direct script access allowed');
/**
 * @package 	PyroCMS
 * @subpackage  Templates Module
 * @category	Module
 */
class Juzon_broadcast_m extends MY_Model {
	
	function __construct()
    {
        parent::__construct();
    }

	function getListUsername(){
		$arr = array();
		$rs  = $this->db->get(TBL_USER)->result();
		foreach($rs as $item){
			if($item->username != 'admin'){
				$arr[] = $item->username;
			}
		}
		return $arr;
	}	
		
	
	function sendemail(){
		$sender_name = $this->input->post('sender_name');
		$sender_email = $this->input->post('sender_email');
		$to_users = $this->input->post('to_users');
		$countries = isset($_POST['countries'])?$_POST['countries']:null;
		$age_from = $this->input->post('age_from');
		$age_to = $this->input->post('age_to');
		$gender = $this->input->post('gender');
		$subject = ($this->input->post('subject'));
		$body = ($this->input->post('body'));
		$date_from = $this->input->post('date_from');
        $date_to = $this->input->post('date_to');
        $last_login_from = $this->input->post('last_login_from');
        $last_login_to = $this->input->post('last_login_to');
		$action = $this->input->post('action');
		
		
		$query = "SELECT * FROM ".TBL_USER." WHERE floor(datediff(now(),dob)/365.25) >= $age_from AND floor(datediff(now(),dob)/365.25) <= $age_to AND status=0 ";
		$cond = '';
		
		if(strtolower($gender) != 'both'){
			$cond .= " AND gender LIKE '$gender' ";	
		}
        if($date_from AND $date_to){
            $cond .= " AND ( add_date < '$date_to' AND add_date > '$date_from') ";	
        }
        if($last_login_from AND $last_login_to){
    	   $cond .= " AND ( last_login > '$last_login_from' AND last_login < '$last_login_to' ) ";
    	}
		
		$listUser = $this->getListUsername();
		$userArr = explode(',',$to_users);
		array_walk_recursive($userArr, 'trim_all');
		
		$arrayusername = array();
		foreach($userArr as $username){
			if($username){
				$arrayusername[] = "'".mysql_real_escape_string($username)."'"; 
			}
		}
		
		if(!empty($arrayusername)){
			$cond .= " AND username IN(".implode(',',$arrayusername).") ";	
		}
		
		if(!empty($countries)){
			$cond .= " AND id_country IN(".implode(',',$countries).") ";	
		}
		
		$query .= $cond;
		$rs = $this->db->query($query)->result();
		
		$from_email = "$sender_name <$sender_email>";
		$iS = 0;
         
		if($action == 'Send'){
			$array = array(); 
			foreach($rs as $item){
				$arrayMaker = array( '{$firstname}', '{$lastname}', '{$username}', '{$country}', '{$age}', '{$invite_url}' );
				$arrayReplace = array( $item->first_name, $item->last_name, $item->username, $item->country, cal_age($item->dob),
										"<a href='".$this->user_io_m->getInviteUrl($item->username)."'>".$this->user_io_m->getInviteUrl($item->username)."</a>"	
									);
				$subject_replace = str_replace( $arrayMaker, $arrayReplace, $subject );			
				$body_replace = str_replace( $arrayMaker , $arrayReplace , $body );	
					
				//debug($body);
				//if( $this->phpmail($from_email,$item->email,$subject,$body) ){
				//	$iS ++;
				//}
				$array[] = array('to_email'=>$item->email,'to_subject'=>$subject_replace,'body'=>$body_replace);
				 
			}
			
			if( SENDMAIL != 0 ) {	
				$this->email_sender->sendSMTPMultiEmail($sender_email,$sender_name,$array);
				$iS = count($array);
				$this->session->set_flashdata('success', "Sent email to $iS users" );
			}else{
				$this->session->set_flashdata('error', 'Email send status is disable' );
			}
			redirect("admin/juzon/broadcast");  
			exit;
		}
		
		if($action == 'Preview'){
			$_SESSION['var_store'] = array(
				'sender_name'	=> $sender_name,
				'sender_email'	=> $sender_email,
				'to_users'		=> $to_users,
				'countries'		=> $countries,
				'age_from'		=> $age_from,
				'age_to'		=> $age_to,
				'gender'		=> $gender,
				'subject'		=> htmlentities($subject),
				'body'			=> $body,
				'date_from'		=> $date_from,
				'date_to'		=> $date_to,
				'last_login_from' => $last_login_from,
				'last_login_to'	=> $last_login_to
			);
			$html = "Sender Name: $from_email <br/>";
			$html .= "Subject:". htmlentities($subject)." <br/>";
			$html .= "Body:".html_entity_decode(($body))."<br/>";
			$html .= "To Users: <br/>";
			$html .= "<table><tr><td>Username</td><td>Join date</td><td>Email</td></tr>";
			foreach($rs as $item){
				$html .= "<tr><td>{$item->username}</td><td>{$item->add_date}</td><td>{$item->email}</td></tr>";
			}	
			$html .= "</table>";
			
			$_SESSION['previewBROADCAST'] = $html;
			redirect("admin/juzon/broadcast");  
			//echo $html;
			exit;
		}
		
	}
	
	
	
	function phpmail($from_email,$to_email,$subject,$body){
		$headers   = array();
		$headers[] = "MIME-Version: 1.0";
		$headers[] = "Content-type: text/html; charset=utf-8";
		$headers[] = "From: ".$from_email;
		//$headers[] = "Subject: {$subject}";
		$headers[] = "X-Mailer: PHP/".phpversion();
	
		$m=mail($to_email, $subject, $body,  implode("\r\n", $headers));
		return $m;
	}
	
//endclass
}	