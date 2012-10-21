<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Email_sender extends MY_Email {
	var $CI;
	var $fromEmail = "";
	var $toEmail = "";
	var $subject = "";
	var $body = "";
	var $emailTitle = "";
	
	function __construct( $config = array() ){
		parent::__construct($config);
		$this->CI = & get_instance();
		$this->setFromEmail(Settings_class::get('server_email'));
		$this->setEmailTitle($GLOBALS['global']['SITE_ADMIN']['email']);
	}	
	
	function setFromEmail($input){$this->fromEmail = $input;}
	function setToEmail($input){$this->toEmail = $input;}
	function setSubject($input){$this->subject = $input;}
	function setBody($input){$this->body = $input;}
	function setEmailTitle($input){$this->emailTitle = $input;}
	
	function sendMultipleEmailsArray($array){
		$this->sendSMTPMultiEmail($this->fromEmail, $this->emailTitle,$array);
	}
	
	function sendEmail(){
		$this->from($this->fromEmail, $this->emailTitle);
		$this->to($this->toEmail);
		$this->subject($this->subject);
		$this->message($this->body);
		
		if( ENVIRONMENT == 'development' ){
			return $this->sendEmail2();
		}else{
			//$this->send();
			//return $this->phpmail();
			return $this->sendEmail2();
		}	
		
	}
	
	function phpmail(){
		$headers   = array();
		$headers[] = "MIME-Version: 1.0";
		$headers[] = "Content-type: text/html; charset=utf-8";
		$headers[] = "From: ".$GLOBALS['global']['SITE_ADMIN']['email'];
		//$headers[] = "Subject: {$this->subject}";
		$headers[] = "X-Mailer: PHP/".phpversion();
	
		$m=mail($this->toEmail, $this->subject, $this->body,  implode("\r\n", $headers));
		return $m;
	}
	
	function sendEmail2(){
		require_once("PHPMailer/class.phpmailer.php");
		
		try {
			$mail = new PHPMailer(true); 
			
			$mail->IsSMTP(); // telling the class to use SMTP
			$mail->SMTPDebug  = 0; // enables SMTP debug information (for testing)               
			
			if( ENVIRONMENT == 'development' ){
				$mail->SMTPAuth   = true;                  // enable SMTP authentication
				$mail->SMTPSecure = "ssl";                 // sets the prefix to the servier
				$mail->Host       = "smtp.gmail.com";      // sets GMAIL as the SMTP server
				$mail->Port       = 465;   
				$mail->Username   = "auto.email.sender.gate2@gmail.com";  // SMTP server username
				$mail->Password   = "admine2#";            // SMTP server password
			}else{
				$mail->SMTPAuth   = true;                  // enable SMTP authentication
				$mail->SMTPSecure = "ssl";
				$mail->Host       = "server1.juzonmail.com";
				$mail->Port       = 465;  
				$mail->Username   = "juzon@juzon.com";
				$mail->Password   = "qwer7890";
			}

			//$mail->From       = $this->fromEmail;
			//$mail->FromName   = $this->emailTitle;
			$mail->CharSet ="UTF-8";
			
			$mail->AddReplyTo($this->fromEmail,$this->emailTitle);
			$mail->SetFrom($this->fromEmail,$this->emailTitle);
			
			$to = $this->toEmail;
			$mail->AddAddress($to);

			$mail->Subject  = $this->subject;
			$body = $this->body;
			$mail->MsgHTML($body);

			$mail->IsHTML(true); // send as HTML

			$mail->Send();
            return true;
			//echo 'Message has been sent.';
		} catch (phpmailerException $e) {
		    return false;  
			//echo $e->errorMessage();
		}
	}
	
	function testSwiftMailer(){
		require_once 'swiftmailer/lib/swift_required.php';
		// Create the Transport
		$transport = Swift_SmtpTransport::newInstance('smtp.gmail.com', 465, 'ssl')
				->setUsername('auto.email.sender.gate2@gmail.com')
				->setPassword('admine2#');
		  
		$mailer = Swift_Mailer::newInstance($transport);

		// Create a message
		$message = Swift_Message::newInstance('Wonderful Subject')
		  ->setFrom(array('john@doe.com' => 'John Doe'))
		  ->setTo(array( 'joss3js@gmail.com' => 'Dang Hung'))
		  ->setBody('Here is the message itself')
		  ;

		// Send the message
		$result = $mailer->send($message);
	}
	
	function sendMultiEmailCI($from_email,$from_name,$data_array){
		$this->from($from_email,$from_name);
		
		foreach($data_array as $k=>$item){
			$this->clear();
			$to = $item['to_email'];
			
			$this->to($to);
			$this->subject($item['to_subject']);
			$this->message($item['body']);
			$this->send();
		}
	}
	
	function sendSMTPMultiEmail($from_email,$from_name,$data_array){
		//$this->sendMultiEmailCI($from_email,$from_name,$data_array);
		 
		require_once("PHPMailer/class.phpmailer.php");
		
		try {
			$mail = new PHPMailer(true); 
			$mail->IsSMTP(); // telling the class to use SMTP
			$mail->SMTPDebug  = 0; // enables SMTP debug information (for testing)       
			
			if( ENVIRONMENT == 'development' ){
				$mail->SMTPAuth   = true;                  // enable SMTP authentication
				$mail->SMTPSecure = "ssl";                 // sets the prefix to the servier
				$mail->Host       = "smtp.gmail.com";      // sets GMAIL as the SMTP server
				$mail->Port       = 465;   
				$mail->Username   = "auto.email.sender.gate2@gmail.com";  // SMTP server username
				$mail->Password   = "admine2#";            // SMTP server password
			}else{
				$mail->SMTPAuth   = true;                  // enable SMTP authentication
				$mail->SMTPSecure = "ssl";
				$mail->Host       = "server1.juzonmail.com";
				$mail->Port       = 465;  
				$mail->Username   = "juzon@juzon.com";
				$mail->Password   = "qwer7890";
			}
			//$mail->From       = $from_email;
			//$mail->FromName   = "$from_name <$from_email>";//$from_name;
			$mail->CharSet ="UTF-8";
			
			$mail->AddReplyTo($from_email,$from_name);
			$mail->SetFrom($from_email,$from_name);
			
			
			foreach($data_array as $k=>$item){
				$to = $item['to_email'];
				$mail->AddAddress($to,$item['to_subject']);
				//$mail->AddCC($to);
				
				$mail->Subject  = $item['to_subject']; debug($item['to_subject'],"subj.txt");
				$body = $item['body'];
				$mail->MsgHTML($body);
				$mail->IsHTML(true); // send as HTML
				$mail->Send();
				
				$mail ->clearAddresses();
				$mail->ClearAttachments();
			}
			
            return true;
			//echo 'Message has been sent.';
		} catch (phpmailerException $e) {
		    return false;  
			//echo $e->errorMessage();
		}
		 
	}
	
	function juzonSendEmail_FORGOTPASSWORD($id_user){
		$userdataobj = $this->CI->user_io_m->init('id_user',$id_user);
		$slug = "JUZON_PASSWORD_RESET_TEMP";
		
		$template = $this->CI->module_helper->getTemplateMail( $slug );
		$orgArr = array( "{###PASSWORD###}", "{###LINK###}" );
		
		$newpasswd = $this->CI->digit->rand_digit(6);
		
		$activated_link = site_url("member/active_pw_account/?uid=".$id_user."&np=$newpasswd&sid=".md5($userdataobj->username.$newpasswd));
		$link = "<a href='$activated_link'>$activated_link</a>";
		
		$rplArr = array( $newpasswd, $link );
		
		$body = str_replace( $orgArr , $rplArr , $template['body'] );
		$subject = $template['subject'];
		
		$this->setToEmail($userdataobj->email);
		$this->setSubject($subject);
		$this->setBody($body);
		
		$this->sendEmail();
	}
	
	function juzonSendEmail_BUYPET($pet_user_id, $value){
		/**
		$userdata = $this->CI->user_io_m->init( 'id_user',$pet_user_id );
		$buyerdata = $this->CI->user_io_m->init( 'id_user',$userdata->owner );
		
		$subject = $userdata->username.",".$buyerdata->username." has bought you as pet!";
		$body = $this->CI->load->view( "member/email_templates/pet/buypet", 
										array('buyer_id'=>$userdata->owner, 'value'=>$value) ,
										true
									);
		if( (int)$userdata->email_setting && (int)$GLOBALS['global']['EMAIL_SETTING']['buy_pet']) {							
			$this->setToEmail($userdata->email);
			$this->setSubject($subject);
			$this->setBody($body);
			if( SENDMAIL != 0 ){
				$this->sendEmail();
			}	
		} 			
		**/
		$this->CI->load->model('user/user_m');
		$userdata = $this->CI->user_io_m->init('id_user',$pet_user_id);
		$buyerdata = $this->CI->user_io_m->init('id_user',$userdata->owner);
		
		$slug = "JUZ_BUY_PET";
		$template = $this->CI->module_helper->getTemplateMail( $slug );
		
		$arrayMaker = array( '$username1','$username2','{$buyer}','{$amount}','{$date}','{$link}' );
		$arrayReplace = array(   $userdata->username, $buyerdata->username,  
							     $this->CI->user_m->buildNativeLink($buyerdata->username),$value,date(DATETIMEEMAIL,time()) ,
                            	 $this->CI->user_io_m->buildDirectAccessLink($userdata->username,"user/wallet")
							);
		$subject = str_replace( $arrayMaker, $arrayReplace, $template['subject'] );			
		$body = str_replace( $arrayMaker , $arrayReplace , $template['body'] );	
		
        $bodyTEMP = $this->CI->load->view( "member/email_templates/common_temp", 
										array('username'=>$userdata->username) ,
										true
									);
        $body = str_replace('{###BODY###}', $body, $bodyTEMP);
        
		$this->setToEmail($userdata->email);
		$this->setSubject($subject);
		$this->setBody($body);
		
		$useremailsetting = $this->CI->email_setting_io_m->init($userdata->id_user);	
		if( $useremailsetting->buy_pet == 1 AND SENDMAIL != 0 ) {							
			$this->sendEmail();
		}
		if(ENVIRONMENT == 'development'){
			debug(
				'JUZ_BUY_PET: subj:'.$subject.'|body:'.$body.'|to email:'.$userdata->email
			);
		}	
			
	}
	
	function juzonSendEmail_ALERTMEBUYPET($pet_user_id,$old_owner_id, $value){
		/**
		$userdata = $this->CI->user_io_m->init( 'id_user',$pet_user_id );
		$buyerdata = $this->CI->user_io_m->init( 'id_user',$userdata->owner );
		$oldonwerdata = $this->CI->user_io_m->init( 'id_user',$old_owner_id );
		
		$subject = $userdata->username.",".$buyerdata->username." has bought you as pet!";
		$body = $this->CI->load->view( "member/email_templates/pet/alertbuypet", 
										array('buyer_id'=>$userdata->owner, 'value'=>$value, 'user_id'=>$pet_user_id) ,
										true
									);
									
		if( (int)$userdata->email_setting && (int)$GLOBALS['global']['EMAIL_SETTING']['alertme_buymypet']) {							
			$this->setToEmail($oldonwerdata->email);
			$this->setSubject($subject);
			$this->setBody($body);
			if( SENDMAIL != 0 ){
				$this->sendEmail();
			}	
		} 	
		**/
		$this->CI->load->model('user/user_m');
		$userdata = $this->CI->user_io_m->init('id_user',$pet_user_id);
		$buyerdata = $this->CI->user_io_m->init('id_user',$userdata->owner);
		$oldonwerdata = $this->CI->user_io_m->init( 'id_user',$old_owner_id );
		
		$slug = "JUZ_ALERT_ME_WHEN_OTHER_BUY_MY_PET";
		$template = $this->CI->module_helper->getTemplateMail( $slug );
		
		$arrayMaker = array( '$username1','$username2','{$buyer}','{$amount}','{$date}','{$petusername}', '{$link}' );
		$arrayReplace = array( $oldonwerdata->username, $buyerdata->username,  
								$this->CI->user_m->buildNativeLink($buyerdata->username),$value,date(DATETIMEEMAIL,time()) ,
								$this->CI->user_m->buildNativeLink($userdata->username),
                                $this->CI->user_io_m->buildDirectAccessLink($oldonwerdata->username,"user/wallet")	
							);
		$subject = str_replace( $arrayMaker, $arrayReplace, $template['subject'] );			
		$body = str_replace( $arrayMaker , $arrayReplace , $template['body'] );	
		
        $bodyTEMP = $this->CI->load->view( "member/email_templates/common_temp", 
										array('username'=>$oldonwerdata->username) ,
										true
									);
        $body = str_replace('{###BODY###}', $body, $bodyTEMP);
        
		$this->setToEmail($oldonwerdata->email);
		$this->setSubject($subject);
		$this->setBody($body);
		
		$useremailsetting = $this->CI->email_setting_io_m->init($oldonwerdata->id_user);	
		if( $useremailsetting->alertme_buymypet == 1 AND SENDMAIL != 0 ) {							
			$this->sendEmail();
		}
		if(ENVIRONMENT == 'development'){
			debug(
				'JUZ_ALERT_ME_WHEN_OTHER_BUY_MY_PET: subj:'.$subject.'|body:'.$body.'|to email:'.$oldonwerdata->email
			);
		}	
	}
	
	function juzonSendEmail_ALERTMELOCKPET($id_pet, $id_owner, $value){
		/*
		$userdata = $this->CI->user_io_m->init( 'id_user',$id_pet );
		$ownerdata = $this->CI->user_io_m->init( 'id_user',$id_owner );
		
		$subject = $userdata->username.",".$ownerdata->username." has locked you as pet!";
		$body = $this->CI->load->view( "member/email_templates/pet/alertlockpet", 
										array('userdata'=>$userdata, 'value'=>$value, 'ownerdata'=>$ownerdata) ,
										true
									);
									
		if( (int)$userdata->email_setting && (int)$GLOBALS['global']['EMAIL_SETTING']['lock_pet']) {							
			$this->setToEmail($userdata->email);
			$this->setSubject($subject);
			$this->setBody($body);
			if( SENDMAIL != 0 ){
				$this->sendEmail();
			}	
		} 		
		*/
		$this->CI->load->model('user/user_m');
		$userdata = $this->CI->user_io_m->init('id_user',$id_pet);
		$ownerdata = $this->CI->user_io_m->init('id_user',$id_owner);
		
		$slug = "JUZ_LOCK_PET";
		$template = $this->CI->module_helper->getTemplateMail( $slug );
		
		$arrayMaker = array( '$username1','$username2','{$buyer}','{$amount}', '{$link}');
		$arrayReplace = array( $userdata->username, $ownerdata->username,  
								$this->CI->user_m->buildNativeLink($ownerdata->username),$value,
                                $this->CI->user_io_m->buildDirectAccessLink($userdata->username,"user/wallet")		
							);
		$subject = str_replace( $arrayMaker, $arrayReplace, $template['subject'] );			
		$body = str_replace( $arrayMaker , $arrayReplace , $template['body'] );	
		
        $bodyTEMP = $this->CI->load->view( "member/email_templates/common_temp", 
										array('username'=>$userdata->username) ,
										true
									);
        $body = str_replace('{###BODY###}', $body, $bodyTEMP);
        
		$this->setToEmail($userdata->email);
		$this->setSubject($subject);
		$this->setBody($body);
		
		$useremailsetting = $this->CI->email_setting_io_m->init($userdata->id_user);	
		if( $useremailsetting->lock_pet == 1 AND SENDMAIL != 0 ) {							
			$this->sendEmail();
		}
		if(ENVIRONMENT == 'development'){
			debug(
				'JUZ_BUY_PET: subj:'.$subject.'|body:'.$body.'|to email:'.$userdata->email
			);
		}	
			
	}
	
	function juzonSendEmail_RANDOMMESSAGEEMAIL($id_user,$message){
		/*
		$sendtouserdata = $this->CI->user_io_m->init( 'id_user',$id_user );
		$ownerdata = $this->CI->user_io_m->init( 'id_user',getAccountUserId() );
		
		$subject = $sendtouserdata->username.",".$ownerdata->username." sent you a message!";
		$body = $this->CI->load->view( "member/email_templates/random_message/send_message", 
										array('ownerdata'=>$ownerdata, 'message'=>$message) ,
										true
									);
									
		$useremailsetting = $this->CI->email_setting_io_m->init($id_user);							
		if( (int)$sendtouserdata->email_setting && (int)$GLOBALS['global']['EMAIL_SETTING']['offline_chat'] && $useremailsetting->offline_chat ) {							
			$this->setToEmail($sendtouserdata->email);
			$this->setSubject($subject);
			$this->setBody($body);
			if( SENDMAIL != 0 ){
				$this->sendEmail();
			}	
		} 		
		*/
		$sendtouserdata = $this->CI->user_io_m->init( 'id_user',$id_user );
		$ownerdata = $this->CI->user_io_m->init( 'id_user',getAccountUserId() );
		
		$slug = "JUZ_OFFLINE_CHAT";
		$template = $this->CI->module_helper->getTemplateMail( $slug );
		
		$arrayMaker = array( '$username1', '$username2','{$message}','{$username}' );
		$arrayReplace = array( $sendtouserdata->username, $ownerdata->username, $message,
                               $this->CI->user_m->buildNativeLink($ownerdata->username) 
								 );
							
		$subject = str_replace( $arrayMaker, $arrayReplace, $template['subject'] );			
		$body = str_replace( $arrayMaker , $arrayReplace , $template['body'] );	
		
        $bodyTEMP = $this->CI->load->view( "member/email_templates/common_temp", 
										array('username'=>$sendtouserdata->username) ,
										true
									);
        $body = str_replace('{###BODY###}', $body, $bodyTEMP);
        
		$this->setToEmail($sendtouserdata->email);
		$this->setSubject($subject);
		$this->setBody($body);
		
		$useremailsetting = $this->CI->email_setting_io_m->init($sendtouserdata->id_user);	
		if( $useremailsetting->offline_chat == 1 AND SENDMAIL != 0 ) {							
			$this->sendEmail();
		}
		if(ENVIRONMENT == 'development'){
			debug(
				'JUZ_OFFLINE_CHAT: subj:'.$subject.'|body:'.$body.'|to email:'.$sendtouserdata->email
			);
		}
	}
	
	function juzonSendEmail_JUZ_CHATTER_COMMENT($id_user,$id_wall,$comment){
		$this->CI->load->model('user/wall_m');
		
		$res = $this->CI->db->query("SELECT * FROM ".TBL_WALL." WHERE ( id_wall=$id_wall OR id_parent=$id_wall) AND id_user!= $id_user GROUP BY id_user")->result();
		 
		$sql= $this->CI->wall_m->get_all_post($result='',$friend='',$city='',$limit='',$my_chat="",$country='',$id_wall);
		$walldataarr = $this->CI->db->query($sql)->result(); 
		$walldata = $walldataarr[0];
		
		$result = $this->CI->db->query($sql)->result();
		$commentuserdataobj = $this->CI->user_io_m->init('id_user',$id_user);
		$slug = "JUZ_CHATTER_COMMENT";
		$template = $this->CI->module_helper->getTemplateMail( $slug );
		
		foreach($res as $item){
			$userdataobj = $this->CI->user_io_m->init('id_user',$item->id_user);
			$arrayMaker = array( '$username1', '$username2', '{$wall_status}', '{$comment}', '{$link_view}' );
			$arrayReplace = array( $userdataobj->username, $commentuserdataobj->username, 
									$this->CI->wall_m->commentAccordingType($walldata), $comment,
									//site_url("user/wall_view/$id_wall")
                                    $this->CI->user_io_m->buildDirectAccessLink($userdataobj->username,"user/wall_view/$id_wall")
								);
			$subject = str_replace( $arrayMaker, $arrayReplace, $template['subject'] );			
			$body = str_replace( $arrayMaker , $arrayReplace , $template['body'] );	
			
            $bodyTEMP = $this->CI->load->view( "member/email_templates/common_temp", 
										array('username'=>$userdataobj->username) ,
										true
									);
            $body = str_replace('{###BODY###}', $body, $bodyTEMP);
            
			$this->setToEmail($userdataobj->email);
			$this->setSubject($subject);
			$this->setBody($body);
			
			$useremailsetting = $this->CI->email_setting_io_m->init($item->id_user);	
			if( $useremailsetting->chatter_comment == 1 AND SENDMAIL != 0 ) {							
				$this->sendEmail();
			}
			if(ENVIRONMENT == 'development'){
				debug(
					'JUZ_CHATTER_COMMENT: subj:'.$subject.'|body:'.$body.'|to email:'.$userdataobj->email
				);
			}	
		}
	
	}
	
	function juzonSendEmail_JUZ_ASKME_A_QUESTION($id_ask_from, $id_ask_to, $question){
		$slug = "JUZ_ASKME_A_QUESTION";
		$template = $this->CI->module_helper->getTemplateMail( $slug );
		
		if($id_ask_from){
			$fromuserdata = $this->CI->user_io_m->init('id_user',$id_ask_from);
			$fromusername = $fromuserdata->username;
            $fromLink = $this->CI->user_m->buildNativeLink($fromuserdata->username);
		}else{
			$fromusername = 'Anonymously';
            $fromLink = 'Anonymously';
		}
		
		$touserdata = $this->CI->user_io_m->init('id_user',$id_ask_to);
		
		$arrayMaker = array( '$username1', '$username2', '{$question}', '{$link}','{$username}' );
		$arrayReplace = array( $touserdata->username, $fromusername, $question,  
                                $this->CI->user_io_m->buildDirectAccessLink($touserdata->username,"user/askme"),
                                $fromLink
                        );
								
		$subject = str_replace( $arrayMaker, $arrayReplace, $template['subject'] );			
		$body = str_replace( $arrayMaker , $arrayReplace , $template['body'] );	
        
		$bodyTEMP = $this->CI->load->view( "member/email_templates/common_temp", 
										array('username'=>$touserdata->username) ,
										true
									);
        $body = str_replace('{###BODY###}', $body, $bodyTEMP);
        
		$this->setToEmail($touserdata->email);
		$this->setSubject($subject);
		$this->setBody($body);
		
		$useremailsetting = $this->CI->email_setting_io_m->init($touserdata->id_user);	
		if( $useremailsetting->askme_question == 1 AND SENDMAIL != 0 ) {							
			$this->sendEmail();
		}
		if(ENVIRONMENT == 'development'){
			debug(
				'JUZ_ASKME_A_QUESTION: subj:'.$subject.'|body:'.$body.'|to email:'.$touserdata->email
			);
		}						
	}
	
	
	function juzonSendEmail_JUZ_ASKME_ANSWER($id_ask_by, $id_ans_by, $answer){
		if($id_ask_by == 0){
			debug('JUZ_ASKME_ANSWER:no mail');
			return;
		}
		
		$slug = "JUZ_ASKME_ANSWER";
		$template = $this->CI->module_helper->getTemplateMail( $slug );
		
		if($id_ask_by){
			$fromuserdata = $this->CI->user_io_m->init('id_user',$id_ask_by);
			$fromusername = $fromuserdata->username;
		}
		
		$touserdata = $this->CI->user_io_m->init('id_user',$id_ans_by);
		
		$arrayMaker = array( '$username1', '$username2', '{$answer}', '{$username}', '{$link}' );
		$arrayReplace = array( $fromusername, $touserdata->username, $answer,
                                $this->CI->user_m->buildNativeLink($fromuserdata->username),
                                $this->CI->user_io_m->buildDirectAccessLink($touserdata->username,"user/askme/?s=answer")
                        );
								
		$subject = str_replace( $arrayMaker, $arrayReplace, $template['subject'] );			
		$body = str_replace( $arrayMaker , $arrayReplace , $template['body'] );	
		
        $bodyTEMP = $this->CI->load->view( "member/email_templates/common_temp", 
										array('username'=>$touserdata->username) ,
										true
									);
        $body = str_replace('{###BODY###}', $body, $bodyTEMP);
        
		$this->setToEmail($fromuserdata->email);
		$this->setSubject($subject);
		$this->setBody($body);
		
		$useremailsetting = $this->CI->email_setting_io_m->init($fromuserdata->id_user);	
		if( $useremailsetting->askme_answer == 1 AND SENDMAIL != 0 ) {							
			$this->sendEmail();
		}
		if(ENVIRONMENT == 'development'){
			debug(
				'JUZ_ASKME_ANSWER: subj:'.$subject.'|body:'.$body.'|to email:'.$fromuserdata->email
			);
		}
	}
	
	function juzonSendEmail_JUZ_PHOTO_COMMENT($user_comment, $id_photo, $comment){
		$res = $this->CI->db->query("SELECT * FROM ".TBL_PHOTO_COMMENT." WHERE id_wall=$id_photo AND comment_by != $user_comment GROUP BY comment_by ")->result();
		
		$slug = "JUZ_PHOTO_COMMENT";
		$template = $this->CI->module_helper->getTemplateMail( $slug );
		$commentuserdataobj = $this->CI->user_io_m->init('id_user',$user_comment);
		
		$gallerydata = $this->CI->gallery_io_m->init('id_image', $id_photo);
		$path = site_url().$GLOBALS['global']['IMAGE']['image_orig']."photos/";
		$imageLink = "<img src='".$path.$gallerydata->image."' /> <br/>".$gallerydata->comment;
		
		$idUserSendMailArr = array();
		foreach($res as $item){
			$userdataobj = $this->CI->user_io_m->init('id_user',$item->comment_by);
			$idUserSendMailArr[] = $userdataobj->id_user;
			$arrayMaker = array( '$username1', '$username2', '{$photo}', '{$comment}', '{$link_view}', '{$username}' );
			$arrayReplace = array( $userdataobj->username, $commentuserdataobj->username, 
									$imageLink, $comment,
									//site_url("user/photos/$id_photo"),
                                    $this->CI->user_io_m->buildDirectAccessLink($userdataobj->username,"user/photos/$id_photo"),
                                    $this->CI->user_m->buildNativeLink($userdataobj->username)
								);
			$subject = str_replace( $arrayMaker, $arrayReplace, $template['subject'] );			
			$body = str_replace( $arrayMaker , $arrayReplace , $template['body'] );	
			
            $bodyTEMP = $this->CI->load->view( "member/email_templates/common_temp", 
										array('username'=>$userdataobj->username) ,
										true
									);
            $body = str_replace('{###BODY###}', $body, $bodyTEMP);
            
			$this->setToEmail($userdataobj->email);
			$this->setSubject($subject);
			$this->setBody($body);
			
			$useremailsetting = $this->CI->email_setting_io_m->init($item->comment_by);	
			if( $useremailsetting->photo_comment == 1 AND SENDMAIL != 0 ) {							
				$this->sendEmail();
			}
			if(ENVIRONMENT == 'development'){
				debug(
					'JUZ_CHATTER_COMMENT: subj:'.$subject.'|body:'.$body.'|to email:'.$userdataobj->email
				);
			}	
		}
		
		
		if( !in_array($gallerydata->id_user,$idUserSendMailArr) AND $gallerydata->id_user != $user_comment ){
			$userdataobj = $this->CI->user_io_m->init('id_user',$gallerydata->id_user);
			$arrayMaker = array( '$username1', '$username2', '{$photo}', '{$comment}', '{$link_view}', '{$username}' );
			$arrayReplace = array( $userdataobj->username, $commentuserdataobj->username, 
									$imageLink, $comment,
									//site_url("user/photos/$id_photo")
                                    $this->CI->user_io_m->buildDirectAccessLink($userdataobj->username,"user/photos/$id_photo"),
                                    $this->CI->user_m->buildNativeLink($userdataobj->username)
								);
			$subject = str_replace( $arrayMaker, $arrayReplace, $template['subject'] );			
			$body = str_replace( $arrayMaker , $arrayReplace , $template['body'] );	
			
            $bodyTEMP = $this->CI->load->view( "member/email_templates/common_temp", 
										array('username'=>$userdataobj->username) ,
										true
									);
            $body = str_replace('{###BODY###}', $body, $bodyTEMP);
            
			$this->setToEmail($userdataobj->email);
			$this->setSubject($subject);
			$this->setBody($body);
			
			$useremailsetting = $this->CI->email_setting_io_m->init($userdataobj->id_user);	
			if( $useremailsetting->photo_comment == 1 AND SENDMAIL != 0 ) {							
				$this->sendEmail();
			}
			if(ENVIRONMENT == 'development'){
				debug(
					'JUZ_CHATTER_COMMENT: subj:'.$subject.'|body:'.$body.'|to email:'.$userdataobj->email
				);
			}	
		}
		
	}
	
	function juzonSendEmail_JUZ_LIKE_CHATTER($id_user,$id_wall){
		$this->CI->load->model('user/wall_m');
		$sql= $this->CI->wall_m->get_all_post($result='',$friend='',$city='',$limit='',$my_chat="",$country='',$id_wall);
		$walldataarr = $this->CI->db->query($sql)->result(); 
		$walldata = $walldataarr[0];
		
		$likeuserdataobj = $this->CI->user_io_m->init('id_user',$id_user);
		$slug = "JUZ_LIKE_CHATTER";
		$template = $this->CI->module_helper->getTemplateMail( $slug );
		
		if($id_user != $walldata->id_user){
			$userdataobj = $this->CI->user_io_m->init('id_user',$walldata->id_user);
			$arrayMaker = array( '$username1', '$username2', '{$wall_status}', '{$username}', '{$link}' );
			$arrayReplace = array( $userdataobj->username, $likeuserdataobj->username, 
									$this->CI->wall_m->commentAccordingType($walldata),  
                                    $this->CI->user_m->buildNativeLink($userdataobj->username),
                                    $this->CI->user_io_m->buildDirectAccessLink($userdataobj->username,"user/wall_view/$id_wall")
									//site_url("user/wall_view/$id_wall")
								);
			$subject = str_replace( $arrayMaker, $arrayReplace, $template['subject'] );			
			$body = str_replace( $arrayMaker , $arrayReplace , $template['body'] );	
			
            $bodyTEMP = $this->CI->load->view( "member/email_templates/common_temp", 
										array('username'=>$userdataobj->username) ,
										true
									);
            $body = str_replace('{###BODY###}', $body, $bodyTEMP);
            
			$this->setToEmail($userdataobj->email);
			$this->setSubject($subject);
			$this->setBody($body);
			
			$useremailsetting = $this->CI->email_setting_io_m->init($walldata->id_user);	
			if( $useremailsetting->like_chatter == 1 AND SENDMAIL != 0 ) {							
				$this->sendEmail();
			}
			if(ENVIRONMENT == 'development'){
				debug(
					'JUZ_LIKE_CHATTER: subj:'.$subject.'|body:'.$body.'|to email:'.$userdataobj->email
				);
			}	
		}
	}
	
	function juzonSendEmail_JUZ_PHOTO_RATING($rate_by, $rate_to, $id_photo, $rate){
		if($rate_by == $rate_to){
			return;
		}
		
		$ratebyuserdata = $this->CI->user_io_m->init('id_user',$rate_by);
		$ratetouserdata = $this->CI->user_io_m->init('id_user',$rate_to);
		
		$gallerydata = $this->CI->gallery_io_m->init('id_image', $id_photo);
		$path = site_url().$GLOBALS['global']['IMAGE']['image_orig']."photos/";
		$imageLink = "<img src='".$path.$gallerydata->image."' /> <br/>".$gallerydata->comment;
		
		$slug = "JUZ_PHOTO_RATING";
		$template = $this->CI->module_helper->getTemplateMail( $slug );
		
		$arrayMaker = array( '$username1', '$username2', '{$photo}', '{$link_view}','{$rate}', '{$username}' );
		$arrayReplace = array( $ratetouserdata->username, $ratebyuserdata->username, $imageLink,
							    //site_url("user/photos/$id_photo"), 
                                $this->CI->user_io_m->buildDirectAccessLink($ratetouserdata->username,"user/photos/$id_photo"),
								$rate,
                                $this->CI->user_m->buildNativeLink($ratebyuserdata->username)
                            );
		$subject = str_replace( $arrayMaker, $arrayReplace, $template['subject'] );			
		$body = str_replace( $arrayMaker , $arrayReplace , $template['body'] );	
        
        $bodyTEMP = $this->CI->load->view( "member/email_templates/common_temp", 
										array('username'=>$ratetouserdata->username) ,
										true
									);
        $body = str_replace('{###BODY###}', $body, $bodyTEMP);
		
		$this->setToEmail($ratetouserdata->email);
		$this->setSubject($subject);
		$this->setBody($body);
		
		$useremailsetting = $this->CI->email_setting_io_m->init($ratetouserdata->id_user);	
		if( $useremailsetting->photo_rating == 1 AND SENDMAIL != 0 ) {							
			$this->sendEmail();
		}
		if(ENVIRONMENT == 'development'){
			debug(
				'JUZ_PHOTO_RATING: subj:'.$subject.'|body:'.$body.'|to email:'.$ratetouserdata->email
			);
		}	
	}
	
	function juzonSendEmail_JUZ_FRIEND_REQUEST($who_add, $add_user){
		$whoadduserdata = $this->CI->user_io_m->init('id_user',$who_add);
		$adduserdata = $this->CI->user_io_m->init('id_user',$add_user);
		
		$slug = "JUZ_FRIEND_REQUEST";
		$template = $this->CI->module_helper->getTemplateMail( $slug );
		
		$arrayMaker = array( '$username1', '$username2', '{$link_view}', '{$username}' );
		$arrayReplace = array( $adduserdata->username, $whoadduserdata->username, 
								//site_url("user/friends_request"),
                                $this->CI->user_io_m->buildDirectAccessLink($adduserdata->username,"user/friends_request"),
							    $this->CI->user_m->buildNativeLink($whoadduserdata->username)
							);
		$subject = str_replace( $arrayMaker, $arrayReplace, $template['subject'] );			
		$body = str_replace( $arrayMaker , $arrayReplace , $template['body'] );	
		
        $bodyTEMP = $this->CI->load->view( "member/email_templates/common_temp", 
										array('username'=>$adduserdata->username),
										true
									);
        $body = str_replace('{###BODY###}', $body, $bodyTEMP);
        
		$this->setToEmail($adduserdata->email);
		$this->setSubject($subject);
		$this->setBody($body);
		
		$useremailsetting = $this->CI->email_setting_io_m->init($adduserdata->id_user);	
		if( $useremailsetting->friend_request == 1 AND SENDMAIL != 0 ) {							
			$this->sendEmail();
		}
		if(ENVIRONMENT == 'development'){
			debug(
				'JUZ_FRIEND_REQUEST: subj:'.$subject.'|body:'.$body.'|to email:'.$adduserdata->email
			);
		}	
	}
	
	function juzonSendEmail_JUZ_FRIEND_CONFIRM($who_add, $add_user){
		$whoadduserdata = $this->CI->user_io_m->init('id_user',$who_add);
		$adduserdata = $this->CI->user_io_m->init('id_user',$add_user);
		
		$slug = "JUZ_FRIEND_CONFIRM";
		$template = $this->CI->module_helper->getTemplateMail( $slug );
		
		$arrayMaker = array( '$username1', '$username2', '{$username}' , '{$link}' );
		$arrayReplace = array( $whoadduserdata->username, $adduserdata->username, 
                               $this->CI->user_m->buildNativeLink($adduserdata->username),
                               $this->CI->user_io_m->buildDirectAccessLink($whoadduserdata->username,"user/friends") 
							);
		$subject = str_replace( $arrayMaker, $arrayReplace, $template['subject'] );			
		$body = str_replace( $arrayMaker , $arrayReplace , $template['body'] );	
		
        $bodyTEMP = $this->CI->load->view( "member/email_templates/common_temp", 
										array('username'=>$whoadduserdata->username),
										true
									);
        $body = str_replace('{###BODY###}', $body, $bodyTEMP);
        
		$this->setToEmail($whoadduserdata->email);
		$this->setSubject($subject);
		$this->setBody($body);
		
		$useremailsetting = $this->CI->email_setting_io_m->init($whoadduserdata->id_user);	
		if( $useremailsetting->friend_confirm == 1 AND SENDMAIL != 0 ) {							
			$this->sendEmail();
		}
		if(ENVIRONMENT == 'development'){
			debug(
				'JUZ_FRIEND_CONFIRM: subj:'.$subject.'|body:'.$body.'|to email:'.$whoadduserdata->email
			);
		}	
	}
	
	function juzonSendEmail_JUZ_SEND_GIFT($id_sender, $id_receiver, $id_gift,$message){
		$senderuserdata = $this->CI->user_io_m->init('id_user',$id_sender);
		$receiveruserdata = $this->CI->user_io_m->init('id_user',$id_receiver);
		$giftdataobj = $this->CI->mod_io_m->init('id_gift',$id_gift,TBL_GIFT);
		$path = site_url()."image/thumb/gift/";	
		$gift = "<img src='".$path.$giftdataobj->image."' /><br/>";
		$gift .= currencyDisplay($giftdataobj->price).JC;
		
		$slug = "JUZ_SEND_GIFT";
		$template = $this->CI->module_helper->getTemplateMail( $slug );
		
		$arrayMaker = array( '$username1', '$username2','{$gift}','{$message}','{$link_view}', '{$username}' );
		$arrayReplace = array( $receiveruserdata->username, $senderuserdata->username, 
		                       $gift, $message, 
                               //site_url("user/my_profile/gift_list"),
                               $this->CI->user_io_m->buildDirectAccessLink($receiveruserdata->username,"user/my_profile/gift_list"),
                               $this->CI->user_m->buildNativeLink($senderuserdata->username) 
							);
		$subject = str_replace( $arrayMaker, $arrayReplace, $template['subject'] );			
		$body = str_replace( $arrayMaker , $arrayReplace , $template['body'] );	
		
        $bodyTEMP = $this->CI->load->view( "member/email_templates/common_temp", 
										array('username'=>$receiveruserdata->username),
										true
									);
        $body = str_replace('{###BODY###}', $body, $bodyTEMP);
        
		$this->setToEmail($receiveruserdata->email);
		$this->setSubject($subject);
		$this->setBody($body);
		
		$useremailsetting = $this->CI->email_setting_io_m->init($receiveruserdata->id_user);	
		if( $useremailsetting->send_gift == 1 AND SENDMAIL != 0 ) {							
			$this->sendEmail();
		}
		if(ENVIRONMENT == 'development'){
			debug(
				'JUZ_SEND_GIFT: subj:'.$subject.'|body:'.$body.'|to email:'.$receiveruserdata->email
			);
		}	
	}
	
	function juzonSendEmail_JUZ_WHO_CHECK_ME($id_user_profile, $id_visitor){
		$userdataobj = $this->CI->user_io_m->init('id_user',$id_user_profile);
		$visitordataobj = $this->CI->user_io_m->init('id_user',$id_visitor);
		
		$this->CI->load->model('user/user_m');
		
		$slug = "JUZ_WHO_CHECK_ME";
		$template = $this->CI->module_helper->getTemplateMail( $slug );
		
		$arrayMaker = array( '$username1', '$username2', '{$visitor}', '{$link}' );
		$arrayReplace = array( $userdataobj->username, $visitordataobj->username, 
		                       $this->CI->user_m->buildNativeLink($visitordataobj->username) ,
                               $this->CI->user_io_m->buildDirectAccessLink($userdataobj->username,"user/peeps")
                          	);
		$subject = str_replace( $arrayMaker, $arrayReplace, $template['subject'] );			
		$body = str_replace( $arrayMaker , $arrayReplace , $template['body'] );	
		
        $bodyTEMP = $this->CI->load->view( "member/email_templates/common_temp", 
										array('username'=>$userdataobj->username),
										true
									);
        $body = str_replace('{###BODY###}', $body, $bodyTEMP);
        
		$this->setToEmail($userdataobj->email);
		$this->setSubject($subject);
		$this->setBody($body);
		
		$useremailsetting = $this->CI->email_setting_io_m->init($userdataobj->id_user);	
		if( $useremailsetting->who_checked_me == 1 AND SENDMAIL != 0 ) {							
			$this->sendEmail();
		}
		if(ENVIRONMENT == 'development'){
			debug(
				'JUZ_WHO_CHECK_ME: subj:'.$subject.'|body:'.$body.'|to email:'.$userdataobj->email
			);
		}	
	}
	
	function juzonSendEmail_JUZ_WHO_BOUGHT_MY_MAPFLIRTS($id_buyer, $id_user, $value){
		$userdataobj = $this->CI->user_io_m->init('id_user',$id_user);
		$buyerdataobj = $this->CI->user_io_m->init('id_user',$id_buyer);
		
		$this->CI->load->model('user/user_m');
		
		$slug = "JUZ_WHO_BOUGHT_MY_MAPFLIRTS";
		$template = $this->CI->module_helper->getTemplateMail( $slug );
		
		$arrayMaker = array( '$username1', '$username2','{$buyer}', '{$amount}', '{$link}' );
		$arrayReplace = array( $userdataobj->username, $buyerdataobj->username, 
								$this->CI->user_m->buildNativeLink($buyerdataobj->username) ,$value,
								$this->CI->user_io_m->buildDirectAccessLink($userdataobj->username,"user/map_flirts/?s=spc1")
							);
		$subject = str_replace( $arrayMaker, $arrayReplace, $template['subject'] );			
		$body = str_replace( $arrayMaker , $arrayReplace , $template['body'] );	
		
        $bodyTEMP = $this->CI->load->view( "member/email_templates/common_temp", 
										array('username'=>$userdataobj->username),
										true
									);
        $body = str_replace('{###BODY###}', $body, $bodyTEMP);
        
		$this->setToEmail($userdataobj->email);
		$this->setSubject($subject);
		$this->setBody($body);
		
		$useremailsetting = $this->CI->email_setting_io_m->init($userdataobj->id_user);	
		if( $useremailsetting->who_bought_map_location == 1 AND SENDMAIL != 0 ) {							
			$this->sendEmail();
		}
		if(ENVIRONMENT == 'development'){
			debug(
				'JUZ_WHO_BOUGHT_MY_MAPFLIRTS: subj:'.$subject.'|body:'.$body.'|to email:'.$userdataobj->email
			);
		}
	}
	
	function juzonSendEmail_JUZ_WHO_BOUGHT_MY_BACKSTAGE_PHOTO($id_buyer, $id_seller, $id_photo, $value){
		$userdataobj = $this->CI->user_io_m->init('id_user',$id_seller);
		$buyerdataobj = $this->CI->user_io_m->init('id_user',$id_buyer);
		
		$this->CI->load->model('user/user_m');
		$slug = "JUZ_WHO_BOUGHT_MY_BACKSTAGE_PHOTO";
		$template = $this->CI->module_helper->getTemplateMail( $slug );
		
		$gallerydata = $this->CI->gallery_io_m->init('id_image', $id_photo);
		$path = site_url().$GLOBALS['global']['IMAGE']['image_orig']."photos/";
		$imageLink = "<img src='".$path.$gallerydata->image."' /> <br/>".$gallerydata->comment;
		
		$arrayMaker = array( '$username1', '$username2','{$buyer}', '{$amount}', '{$photo}','{$link}' );
		$arrayReplace = array( $userdataobj->username, $buyerdataobj->username, 
								$this->CI->user_m->buildNativeLink($buyerdataobj->username) ,
								$value,$imageLink,
                                $this->CI->user_io_m->buildDirectAccessLink($userdataobj->username,"user/backstage/?s=spc1")
							);
		$subject = str_replace( $arrayMaker, $arrayReplace, $template['subject'] );			
		$body = str_replace( $arrayMaker , $arrayReplace , $template['body'] );	
		
        $bodyTEMP = $this->CI->load->view( "member/email_templates/common_temp", 
										array('username'=>$userdataobj->username),
										true
									);
        $body = str_replace('{###BODY###}', $body, $bodyTEMP);
        
		$this->setToEmail($userdataobj->email);
		$this->setSubject($subject);
		$this->setBody($body);
		
		$useremailsetting = $this->CI->email_setting_io_m->init($userdataobj->id_user);	
		if( $useremailsetting->bought_backstage_photo == 1 AND SENDMAIL != 0 ) {							
			$this->sendEmail();
		}
		if(ENVIRONMENT == 'development'){
			debug(
				'JUZ_WHO_BOUGHT_MY_BACKSTAGE_PHOTO: subj:'.$subject.'|body:'.$body.'|to email:'.$userdataobj->email
			);
		}
	}
	
	function juzonSendEmail_JUZ_WHO_BOUGHT_WHO_PEEPED_ME($id_buyer, $id_user, $value){
		$userdataobj = $this->CI->user_io_m->init('id_user',$id_user);
		$buyerdataobj = $this->CI->user_io_m->init('id_user',$id_buyer);
		
		$this->CI->load->model('user/user_m');
		$slug = "JUZ_WHO_BOUGHT_WHO_PEEPED_ME";
		$template = $this->CI->module_helper->getTemplateMail( $slug );
		
		$arrayMaker = array( '$username1', '$username2', '{$buyer}', '{$amount}', '{$link}' );
		$arrayReplace = array( $userdataobj->username, $buyerdataobj->username, 
								$this->CI->user_m->buildNativeLink($buyerdataobj->username) ,$value ,
								$this->CI->user_io_m->buildDirectAccessLink($userdataobj->username,"user/wallet")
							);
		$subject = str_replace( $arrayMaker, $arrayReplace, $template['subject'] );			
		$body = str_replace( $arrayMaker , $arrayReplace , $template['body'] );	
		
        $bodyTEMP = $this->CI->load->view( "member/email_templates/common_temp", 
										array('username'=>$userdataobj->username),
										true
									);
        $body = str_replace('{###BODY###}', $body, $bodyTEMP);
        
		$this->setToEmail($userdataobj->email);
		$this->setSubject($subject);
		$this->setBody($body);
		
		$useremailsetting = $this->CI->email_setting_io_m->init($userdataobj->id_user);	
		if( $useremailsetting->bought_who_peeped_me == 1 AND SENDMAIL != 0 ) {							
			$this->sendEmail();
		}
		if(ENVIRONMENT == 'development'){
			debug(
				'JUZ_WHO_BOUGHT_MY_BACKSTAGE_PHOTO: subj:'.$subject.'|body:'.$body.'|to email:'.$userdataobj->email
			);
		}
	}
	
	/**
	
	function juzonSendEmail_JUZ_ALERT_FRIEND_BIRTHDAY($id_user_birthday){
		$userdataobj = $this->CI->user_io_m->init('id_user',$id_user_birthday);
		$this->CI->load->model('user/user_m');
		$slug = "JUZ_ALERT_FRIEND_BIRTHDAY";
		$template = $this->CI->module_helper->getTemplateMail( $slug );
		
		$userFriends = $this->CI->user_m->getListUserFriendsUserId($id_user_birthday);
		
		$array = array();
		foreach($userFriends as $iduser){
			$alertuserdata = $this->CI->user_io_m->init('id_user',$iduser);
			
			$arrayMaker = array( '$username1', '$username2','{$username}', '{$date}' ,'{$link}' );
			$arrayReplace = array( $alertuserdata->username, $userdataobj->username, 
									$this->CI->user_m->buildNativeLink($userdataobj->username) ,birthDay($userdataobj->dob),
									$this->CI->user_io_m->buildDirectAccessLink($alertuserdata->username,"user/birthdays")
								);
			$subject = str_replace( $arrayMaker, $arrayReplace, $template['subject'] );			
			$body = str_replace( $arrayMaker , $arrayReplace , $template['body'] );	
			
            $bodyTEMP = $this->CI->load->view( "member/email_templates/common_temp", 
										array('username'=>$alertuserdata->username),
										true
									);
            $body = str_replace('{###BODY###}', $body, $bodyTEMP);
            
			//$this->setToEmail($alertuserdata->email);
			//$this->setSubject($subject);
			//$this->setBody($body);
			
			$useremailsetting = $this->CI->email_setting_io_m->init($alertuserdata->id_user);	
			if( $useremailsetting->bday_confirm == 1 AND SENDMAIL != 0 ) {							
				//$this->sendEmail();
				$array[] = array('to_email'=>$alertuserdata->email,'to_subject'=>$subject,'body'=>$body);
			}
			
		}
		$this->sendSMTPMultiEmail($this->fromEmail, $this->emailTitle,$array);
		debug(
				'JUZ_ALERT_FRIEND_BIRTHDAY: SENT TO:'.count($array)
			);
	}
	
	**/
	
	
	function juzonSendEmail_JUZ_ADMIN_ANNOUNCEMENT($id_user){
		$useremailsetting = $this->CI->email_setting_io_m->init($id_user);
		if($useremailsetting->announcement != 1){
			return ;
		}
		
		$userdataobj = $this->CI->user_io_m->init('id_user',$id_user);
		$announcement = $this->CI->db->query( " SELECT * FROM ".TBL_CONFIG." WHERE name LIKE 'ANNOUNCEMENT' AND f_key LIKE 'content'")->result();
			
		$slug = "JUZ_ADMIN_ANNOUNCEMENT";
		$template = $this->CI->module_helper->getTemplateMail( $slug );
		
		$arrayMaker = array( '$username1', '{announcement}' );
		$arrayReplace = array( $userdataobj->username, 
								$announcement[0]->f_value
							);
		$subject = str_replace( $arrayMaker, $arrayReplace, $template['subject'] );			
		$body = str_replace( $arrayMaker , $arrayReplace , $template['body'] );	
		
		$this->setToEmail($userdataobj->email);
		$this->setSubject($subject);
		$this->setBody($body);
		
		if( SENDMAIL != 0 ) {							
			//$this->sendEmail();
		}
		if(ENVIRONMENT == 'development'){
			debug(
				'JUZ_ADMIN_ANNOUNCEMENT: subj:'.$subject.'|body:'.$body.'|to email:'.$userdataobj->email
			);
		}
	}
	
	function juzonSendEmail_JUZ_SENDOFFLINECHATMESSAGEEMAIL($from_id_user,$to_id_user,$message){
	     $userdataobj = $this->CI->user_io_m->init('id_user',$to_id_user);
         $senderdataobj = $this->CI->user_io_m->init('id_user', $from_id_user);
         
        $slug = "JUZ_SENDOFFLINECHATMESSAGEEMAIL";
		$template = $this->CI->module_helper->getTemplateMail( $slug );
		
		$arrayMaker = array( '$username1','$username2', '{$chat_message}', '{$username}' );
		$arrayReplace = array( $userdataobj->username, $senderdataobj->username, $message,
                            $this->CI->user_m->buildNativeLink($senderdataobj->username)
                         );
							
		$subject = str_replace( $arrayMaker, $arrayReplace, $template['subject'] );			
		$body = str_replace( $arrayMaker , $arrayReplace , $template['body'] );	
		
        $bodyTEMP = $this->CI->load->view( "member/email_templates/common_temp", 
										array('username'=>$userdataobj->username),
										true
									);
        $body = str_replace('{###BODY###}', $body, $bodyTEMP);
            
		$this->setToEmail($userdataobj->email);
		$this->setSubject($subject);
		$this->setBody($body);
		
		$useremailsetting = $this->CI->email_setting_io_m->init($to_id_user);	
        if( $useremailsetting->offline_chat == 1 AND SENDMAIL != 0 ) {							
			$this->sendEmail();
		}
		
		if(ENVIRONMENT == 'development'){
			debug(
				'JUZ_SENDOFFLINECHATMESSAGEEMAIL: subj:'.$subject.'|body:'.$body.'|to email:'.$userdataobj->email
			);
		}
	}
    
    function juzonSendEmail_JUZ_WELCOME_EMAIL($id_user,$new_email=''){
        $userdataobj = $this->CI->user_io_m->init('id_user',$id_user);
        
        $slug = "JUZ_WELCOME_EMAIL";
		$template = $this->CI->module_helper->getTemplateMail( $slug );
		
		$arrayMaker = array( '$username');
		$arrayReplace = array( $userdataobj->username);
        $subject = str_replace( $arrayMaker, $arrayReplace, $template['subject'] );			
		$body = str_replace( $arrayMaker , $arrayReplace , $template['body'] );	
		
        if(!$new_email){
            $email = $userdataobj->email;    
        }else{
            $email = $new_email;
        }
        
		$this->setToEmail($email);
		$this->setSubject($subject);
		$this->setBody($body);
		
        if(ENVIRONMENT == 'development'){
			debug(
				'JUZ_WELCOME_EMAIL: subj:'.$subject.'|body:'.$body.'|to email:'.$email
			);
		}
        
		if( SENDMAIL != 0 ) {							
			return $this->sendEmail();
		}
	}
    
    function juzonSendEmail_JUZ_ACCOUNT_CHANGED_EMAIL($id_user, $new_email){
        $userdataobj = $this->CI->user_io_m->init('id_user',$id_user);
        
        $slug = "JUZ_ACCOUNT_CHANGED_EMAIL";
		$template = $this->CI->module_helper->getTemplateMail( $slug );
		
        $link_action = $this->CI->user_io_m->buildDirectAccessLink($userdataobj->username, "user/account/active_new_email/?new_email=$new_email&sc=".md5($new_email.$id_user.'-salt'));
		$link = "<a href='$link_action'>$link_action</a>";
        
        $arrayMaker = array( '{$username}' ,'{$link}');
		$arrayReplace = array( $userdataobj->username, $link);
        $subject = str_replace( $arrayMaker, $arrayReplace, $template['subject'] );			
		$body = str_replace( $arrayMaker , $arrayReplace , $template['body'] );	
	 
        $email = $userdataobj->email;    
        
		$this->setToEmail($email);
		$this->setSubject($subject);
		$this->setBody($body);
		
        if(ENVIRONMENT == 'development'){
			debug(
				'JUZ_ACCOUNT_CHANGED_EMAIL: subj:'.$subject.'|body:'.$body.'|to email:'.$email
			);
		}
        
		if( SENDMAIL != 0 ) {							
			return $this->sendEmail();
		}
    }
    
    
    
    
    
	//end class
}	

