<?php defined('BASEPATH') or exit('No direct script access allowed');

class User_io_m extends MY_Model {
	function __construct(){
		parent::__construct();
	}
	
	function init($cmd, $value){
		if($cmd == 'id_user'){
			$result = $this->db->where('id_user',$value)->get(TBL_USER)->result();
			return $result?$result[0]:false;
		}else if($cmd == 'email'){
			$result = $this->db->where('email',$value)->get(TBL_USER)->result();
			return $result?$result[0]:false;
		}else if($cmd == 'username'){
			$result = $this->db->where('username',$value)->get(TBL_USER)->result();
			return $result?$result[0]:false;
		}else{
			return false;
		}
	}
	
	function getUserIdFromEmail($email){
		$userdata = $this->init('email',$email);
		return $userdata->id_user;
	}
	
	function insert_map($array_key_value){
		foreach($array_key_value as $key=>$value){
			$this->db->set($key,$value);
		}
		$this->db->insert(TBL_USER);
		return $this->db->insert_id();
	}
	
	function update_map($array_key_value,$id_user){
		foreach($array_key_value as $key=>$value){
			$this->db->set($key,$value);
		}
		$this->db->where('id_user',$id_user)->update(TBL_USER);
	}
		
	function checkPassword($id_user, $passwd){
		$dataobj = $this->init('id_user',$id_user);
		if(md5($passwd) == $dataobj->password){
			return true;
		}
		return false;
	}	
	
	function checkPasswordCookie($id_user){
		$dataobj = $this->init('id_user',$id_user);
		$hashing = md5($dataobj->username.$dataobj->password);
		if(isset($_COOKIE['joz_account_id_user']) AND $_COOKIE['joz_account_id_user'] == $id_user){
			$cookiePasswd = isset($_COOKIE['joz_account_password'])?$_COOKIE['joz_account_password']:'';
			if($hashing == $cookiePasswd){
				return true;
			}
		}
		return false;
	}
	
	function saveAccountToSessionInfo($id_user){
		$dataobj = $this->init('id_user',$id_user);
		$_SESSION['joz_account']['id_user'] = $id_user;
		$_SESSION['joz_account']['dataobj'] = $dataobj;
		$user['last_login'] = mysqlDate();
		$this->update_map($user,$id_user);
		
		if($dataobj){
			$data['id_user'] =	$dataobj->id_user; 
			$data['ip'] =	$this->geo_lib->getIpAddress();
			$data['date_login'] =	mysqlDate(); 
			$data['username'] =	$dataobj->username; 
			$data['status'] =	1; 
			$data['failure_attempt'] =	0; 
			$data['email'] = $dataobj->email;
			
			$this->mod_io_m->insert_map($data,TBL_LOGIN);
		}
	}
	
	function saveAccountToCookieInfo($id_user){
		$dataobj = $this->init('id_user',$id_user);
		setcookie("joz_account_id_user", $id_user, time()+ 60*60*24*365 , '/');
		setcookie("joz_account_password", md5($dataobj->username.$dataobj->password), time()+ 60*60*24*365, '/');
	}
		
	function userLogout(){
		unset($_SESSION['joz_account']);
		setcookie("joz_account_id_user", "", -60000 , '/');  
		setcookie("joz_account_password", "", -60000, '/');  
		unset($_SESSION['twitterconnection']);
		unset($_SESSION['admin_switch_user']);
		unset($_SESSION['facebookinvokedtime']);
		if($this->facebookmodel->getCurrentFacebookUser()){
			$this->facebookmodel->logout();
		}
	}	
	
    function generateHashCode($username){
        $userdata = $this->init('username',$username);
        return md5('ciu34#%@!'.$username.'hash'.$userdata->id_user);
    }
    
    function buildDirectAccessLink($username, $taskuri){
        return site_url("member/direct_access")."/?username={$username}&sid=".$this->generateHashCode($username)."&action=".urlencode($taskuri);
    }
    
	function userSyncCashAndValue($user_id){
	    if(!isset($_SESSION['user_do_sync_'.$user_id])){
            $_SESSION['user_do_sync_'.$user_id] = time();    
        }else{
            if(time() - $_SESSION['user_do_sync_'.$user_id] < 30 ){
                return;
            }else{
                $_SESSION['user_do_sync_'.$user_id] = time();
            }
        }
        //debug("userSyncCashAndValue | id_user:$user_id | debug time:".date('Y-m-d H:i:s',time()));
        
		$earn = $this->db->query("SELECT SUM(user_amt) as tot_earning from ".TBL_TRANSACTION." WHERE id_user=".$user_id." AND user_amt !=0")->result();
	    $tot_earn = $earn[0]->tot_earning;
		
	    $expense = $this->db->query( 
			"SELECT SUM(amount) as tot_expense from ".TBL_TRANSACTION." WHERE id_owner=".$user_id.
			" AND amount !=0 AND trans_type !=".$GLOBALS['global']['TRANS_TYPE']['pet_sold_cash'].
			" AND trans_type !=".$GLOBALS['global']['TRANS_TYPE']['message'].
			" AND trans_type !=".$GLOBALS['global']['TRANS_TYPE']['convert_cash']
		)->result();
	    $tot_expense = $expense[0]->tot_expense;
	  
	    $current_cash=$tot_earn -$tot_expense;
		
		/**
		//update value transction ,how many times the user has been bougth
		$value = $this->db->query( 
			"SELECT COUNT(id_transaction) as boughttimes FROM  ".TBL_TRANSACTION." WHERE  id_user =".$user_id.
			"  AND  trans_type  = ".$GLOBALS['global']['TRANS_TYPE']['pet']
		)->result();
	    $boughttimes=$value[0]->boughttimes;
		
		//calculate current value
		
		$pet_percentage=(int)$GLOBALS['global']['PET_VALUE']['pet_percentage'];
		
		$x=0;
		$petvalue=(int)$GLOBALS['global']['USER_CASH']['pet_start_value'];
		while( $x < $boughttimes)
		{
			$petvalue=$petvalue + ($petvalue * ($pet_percentage/100));
			$x++;
		}
		**/
	   //update to user cash
	   
	  //$this->db->query( "UPDATE ".TBL_USER." SET cash=".$current_cash. ",cur_value=".$petvalue. " WHERE id_user=".$user_id;
		$this->db->query( "UPDATE ".TBL_USER." SET cash=".$current_cash." WHERE id_user=".$user_id );			
	}	
	
	function generateConfirmInviteId($owner_id,$email_invite){
		return md5($owner_id.'-AND-'.$email_invite.'#$#$%CCFF@@#^^');
	} 
	
	function getInviteUrl($username){
		return site_url("member/invite/$username");
	}
	
	function postItemOnFbTt($id_wall,$context=''){
		$this->load->model('user/wall_m');
 	    $this->load->model('mod_io/timeline_setting_io_m');
        $timeline_setting  = $this->timeline_setting_io_m->init(getAccountUserId());
        
		$sql= $this->wall_m->get_all_post($result='',$friend='',$city='',$limit='',$my_chat="",$country='',$id_wall);
		$walldataarr = $this->db->query($sql)->result(); 
		$walldata = $this->wall_m->commentAccordingType( $walldataarr[0] );
		$walldata = stripAllLinks($walldata);
		
		$userdataobj = getAccountUserDataObject();
		
		if(isFacebookLogin()){
			//$this->facebookmodel->postOnWall($walldata ,$walldata ,$url=$this->user_io_m->getInviteUrl($userdataobj->username));
			if($context){
			   if($context == TIMELINE_BACKSTAGE_PHOTO AND $timeline_setting->fb_backstage_photo == 1){
			      $this->facebookconnect_io_m->postOnUserWall($id_user=getAccountUserId(),$walldata ,$walldata,$this->user_io_m->getInviteUrl($userdataobj->username));
                  debug( 'TIMELINE_BACKSTAGE_PHOTO post on FACEBOOK wall :'. $walldata);   
			   }  
               if($context == TIMELINE_AKSME_ANSWER AND $timeline_setting->fb_askme_answer == 1){
                  $this->facebookconnect_io_m->postOnUserWall($id_user=getAccountUserId(),$walldata ,$walldata,$this->user_io_m->getInviteUrl($userdataobj->username));
                  debug( 'TIMELINE_AKSME_ANSWER post on FACEBOOK wall :'. $walldata);  
               }
               if($context == TIMELINE_STATUS_UPDATE AND $timeline_setting->fb_status_update == 1){
			      $this->facebookconnect_io_m->postOnUserWall($id_user=getAccountUserId(),$walldata ,$walldata,$this->user_io_m->getInviteUrl($userdataobj->username));
                  debug( 'TIMELINE_STATUS_UPDATE post on FACEBOOK wall :'. $walldata);   
			   } 
               if($context == TIMELINE_BUY_PET AND $timeline_setting->fb_buy_pet  == 1){
			      $this->facebookconnect_io_m->postOnUserWall($id_user=getAccountUserId(),$walldata ,$walldata,$this->user_io_m->getInviteUrl($userdataobj->username));
                  debug( 'TIMELINE_BUY_PET post on FACEBOOK wall :'. $walldata);   
			   }  
               if($context == TIMELINE_LOCKPET AND $timeline_setting->fb_lock_pet == 1){
			      $this->facebookconnect_io_m->postOnUserWall($id_user=getAccountUserId(),$walldata ,$walldata,$this->user_io_m->getInviteUrl($userdataobj->username));
                  debug( 'TIMELINE_LOCKPET post on FACEBOOK wall :'. $walldata);   
			   }  
               if($context == TIMELINE_RATE_VIDEO AND $timeline_setting->fb_rate_video == 1){
			      $this->facebookconnect_io_m->postOnUserWall($id_user=getAccountUserId(),$walldata ,$walldata,$this->user_io_m->getInviteUrl($userdataobj->username));
                  debug( 'TIMELINE_RATE_VIDEO post on FACEBOOK wall :'. $walldata);   
			   } 
			}else{
                $this->facebookconnect_io_m->postOnUserWall($id_user=getAccountUserId(),$walldata ,$walldata,$this->user_io_m->getInviteUrl($userdataobj->username));
                  debug( ' post on FACEBOOK wall :'. $walldata);   
            }
		}
		if(isTwitterLogin()){
		    if($context){
			   if($context == TIMELINE_BACKSTAGE_PHOTO AND $timeline_setting->tt_backstage_photo == 1){
			      $this->twittermodel->postOnWall($walldata ,$url=$this->user_io_m->getInviteUrl($userdataobj->username));
                  debug( 'TIMELINE_BACKSTAGE_PHOTO post on TWITTER wall :'. $walldata);   
			   }  
               if($context == TIMELINE_AKSME_ANSWER AND $timeline_setting->tt_askme_answer == 1){
                  $this->twittermodel->postOnWall($walldata ,$url=$this->user_io_m->getInviteUrl($userdataobj->username));
                  debug( 'TIMELINE_AKSME_ANSWER post on TWITTER wall :'. $walldata);  
               }
               if($context == TIMELINE_STATUS_UPDATE AND $timeline_setting->tt_status_update == 1){
			      $this->twittermodel->postOnWall($walldata ,$url=$this->user_io_m->getInviteUrl($userdataobj->username));
                  debug( 'TIMELINE_STATUS_UPDATE post on TWITTER wall :'. $walldata);   
			   } 
               if($context == TIMELINE_BUY_PET AND $timeline_setting->tt_buy_pet  == 1){
			      $this->twittermodel->postOnWall($walldata ,$url=$this->user_io_m->getInviteUrl($userdataobj->username));
                  debug( 'TIMELINE_BUY_PET post on TWITTER wall :'. $walldata);   
			   }  
               if($context == TIMELINE_LOCKPET AND $timeline_setting->tt_lock_pet == 1){
			      $this->twittermodel->postOnWall($walldata ,$url=$this->user_io_m->getInviteUrl($userdataobj->username));
                  debug( 'TIMELINE_LOCKPET post on TWITTER wall :'. $walldata);   
			   }  
               if($context == TIMELINE_RATE_VIDEO AND $timeline_setting->tt_rate_video == 1){
			      $this->twittermodel->postOnWall($walldata ,$url=$this->user_io_m->getInviteUrl($userdataobj->username)); 
                  debug( 'TIMELINE_RATE_VIDEO post on TWITTER wall :'. $walldata);   
			   } 
			}else{
                $this->twittermodel->postOnWall($walldata ,$url=$this->user_io_m->getInviteUrl($userdataobj->username)); 
                debug( 'post on TWITTER wall :'. $walldata);
            }  
        	
		}
		
	}
	
//end class	 
}