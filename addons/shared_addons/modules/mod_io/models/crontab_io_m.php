<?php defined('BASEPATH') or exit('No direct script access allowed');

class Crontab_io_m extends MY_Model {
	function __construct(){
		parent::__construct();
        $this->load->model( 'user/online_m' );
	}
	
	function _cron_unlockpet(){
		$res=$this->db->where('lockstatus',1)->get(TBL_PET)->result();
		$unlockid = array(); 
		for($i=0;$i<count($res);$i++){
			if( mysql_to_unix( $res[$i]->lockexp_date ) < mysql_to_unix (mysqlDate()) ){
				$unlockid[]=$res[$i]->id_pet;
			}
		}
		if(count($unlockid)){
			for($i=0;$i<count($unlockid);$i++){
				$sql="UPDATE ".TBL_PET." SET lockstatus=0,addlock_date='0000-00-00 00:00:00',userprice=0,id_petlock=0,lockexp_date='0000-00-00 00:00:00',intr=0 WHERE id_pet=".$unlockid[$i];
				$this->db->query($sql);
			}
		}
	}			
	
	function _cron_birthday(){
		$this->load->model('user/friend_m');
		$this->load->model('user/user_m');
		$birthdayList = $this->friend_m->birthdayList();
		//print_r($birthdayList);
		$str = "";	
		
		$slug = "JUZ_ALERT_FRIEND_BIRTHDAY";
		$template = $this->module_helper->getTemplateMail( $slug );
		$array = array();
		foreach($birthdayList as $item){
			//$this->email_sender->juzonSendEmail_JUZ_ALERT_FRIEND_BIRTHDAY($item->id_user);
			$str .= $item->id_user.",";
			$userdataobj = $this->user_io_m->init('id_user', $item->id_user);
			$userFriends = $this->user_m->getListUserFriendsUserId($userdataobj->id_user);
			
			foreach($userFriends as $iduser){
				$alertuserdata = $this->user_io_m->init('id_user',$iduser);
				
				$arrayMaker = array( '$username1', '$username2','{$username}', '{$date}' ,'{$link}' );
				$arrayReplace = array( $alertuserdata->username, $userdataobj->username, 
										$this->user_m->buildNativeLink($userdataobj->username) ,birthDay($userdataobj->dob),
										$this->user_io_m->buildDirectAccessLink($alertuserdata->username,"user/birthdays")
									);
				$subject = str_replace( $arrayMaker, $arrayReplace, $template['subject'] );			
				$body = str_replace( $arrayMaker , $arrayReplace , $template['body'] );	
				
				$bodyTEMP = $this->load->view( "member/email_templates/common_temp", 
											array('username'=>$alertuserdata->username),
											true
										);
				$body = str_replace('{###BODY###}', $body, $bodyTEMP);
				
				$useremailsetting = $this->email_setting_io_m->init($alertuserdata->id_user);	
				if( $useremailsetting->bday_confirm == 1 AND SENDMAIL != 0 ) {							
					$array[] = array('to_email'=>$alertuserdata->email,'to_subject'=>$subject,'body'=>$body);
				}
				
			}
		}
		debug($str, "birthday_crontab_daily.txt");
		$this->email_sender->sendMultipleEmailsArray($array);
		
	}
	
    function _sendOfflineChat(){
        $data= '';
        if(is_file('./chat/chat_text.txt')){
            $data = read_file('./chat/chat_text.txt');
            unlink('./chat/chat_text.txt');
        }else{
            exit;
        }
        
        if(!strlen($data)){
            exit;
        }else{
            $data_array = explode(PHP_EOL, $data);
            $user_array = array();
            foreach($data_array as $rowdata){
                $rowexplode = explode('{|DELEMIT|}',$rowdata);
                //if(in_array($rowexplode[0],$user_array)){
                    $user_array[$rowexplode[0]][] = $rowexplode[1]; 
                //}
            }
            
            foreach($user_array as $key => $arrayvalue){
                $key_explode = explode('|',$key);
                $to_userid = $key_explode[1];
                $from_userid = $key_explode[0];
                if( ($to_userid AND $from_userid) AND ! $this->online_m->checkOnlineUser($to_userid) AND $GLOBALS['global']['OFFLINE_CHAT']['send_email'] == 1){
                    debug("send offline message to $to_userid: ".implode(PHP_EOL,$arrayvalue) , 'send_offline_chat_message.txt');
                    $message = implode('<br />',$arrayvalue);
                    if(strlen($message)){
                        $this->email_sender->juzonSendEmail_JUZ_SENDOFFLINECHATMESSAGEEMAIL($from_userid,$to_userid,$message);
                    }
                }
           }
        }
        exit;
    }
    
    function _resizePhoto(){
        //comment_thumb 40x40
        //post_thumb 50x50
        //profile_thumb 60x60
        //thumb/photos 60x60
        
        $arrayMIME = array('.jpg', '.png', '.jpeg');
        
        $dirPath = "./image/comment_thumb/";
        $i = 0;
        foreach(filesInDir($dirPath) as $file){
            $ext_name_array = explode_name($file);
            if(in_array($ext_name_array['ext'],$arrayMIME)) {
                //chmod($dirPath.$file,777);
                $size = getimagesize($dirPath.$file);
                if($size[0] > 40 OR $size[1] > 40){
                    makeThumb($file, $dirPath, 40, 40);
                    $i++;
                }
            }
        }
        echo "resize comment_thumb:$i items<br/>";
        
        
        $dirPath = "./image/post_thumb/";
        $i = 0;
        foreach(filesInDir($dirPath) as $file){
            $ext_name_array = explode_name($file);
            if(in_array($ext_name_array['ext'],$arrayMIME)) {
                //chmod($dirPath.$file,777);
                $size = getimagesize($dirPath.$file);
                if($size[0] > 50 OR $size[1] > 50){
                    makeThumb($file, $dirPath, 50, 50);
                    $i++;
                }
            }
        }
        echo "resize post_thumb:$i items<br/>";
        
        
        $dirPath = "./image/profile_thumb/";
        $i = 0;
        foreach(filesInDir($dirPath) as $file){
            $ext_name_array = explode_name($file);
            if(in_array($ext_name_array['ext'],$arrayMIME)) {
                //chmod($dirPath.$file,777);
                $size = getimagesize($dirPath.$file);
                if($size[0] > 60 OR $size[1] > 60){
                    makeThumb($file, $dirPath, 60, 60);
                    $i++;
                }
            }
        }
        echo "resize profile_thumb:$i items<br/>";
        
        $dirPath = "./image/thumb/photos/";
        $i = 0;
        foreach(filesInDir($dirPath) as $file){
            $ext_name_array = explode_name($file);
            if(in_array($ext_name_array['ext'],$arrayMIME)) {
                //chmod($dirPath.$file,777);
                $size = getimagesize($dirPath.$file);
                if($size[0] > 60 OR $size[1] > 60){
                    makeThumb($file, $dirPath, 60, 60);
                    $i++;
                }
            }
        }
        echo "resize thumb/photos:$i items<br/>";
    }
    
    
    
//endclass
}	