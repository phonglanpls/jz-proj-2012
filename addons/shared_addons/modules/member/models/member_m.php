<?php defined('BASEPATH') or exit('No direct script access allowed');

class Member_m extends MY_Model {
	function __construct(){
		parent::__construct();
	}
	
	function submit_site_login(){
		$json_array = array();
		$email = $this->input->post('email');
		$password = $this->input->post('password');
		$rememberme = $this->input->post('remember');
		
		if(! $this->phpvalidator->is_email($email)){
			$json_array['status'] = 'error';
			$json_array['message'] = language_translate('member_login_email_format_error');
			echo json_encode($json_array);
			exit;
		}
		
		$checkBlackListEmail = $this->blacklistemail_io_m->init('email',$email);
		if($checkBlackListEmail){
			$json_array['status'] = 'error';
			$json_array['message'] = language_translate('member_login_email_blacklist_error');
			echo json_encode($json_array);
			exit;
		}
		
		$userWithEmail = $this->user_io_m->init('email',$email);
		if(!$userWithEmail){
			$numberFailureAttemp = $this->blockip_io_m->countFailureAttemp();
			if($numberFailureAttemp < $GLOBALS['global']['BLOCK_IP']['count']){
				$insertData['username'] = $email;
				$insertData['ipfailure'] = $numberFailureAttemp+1;
				$insertData['ipstatus'] = 2;
				$insertData['ip'] = $this->geo_lib->getIpAddress();
				$insertData['reason'] = 'Both Credentials are wrong';
                $insertData['time_fail'] = mysqlDate();//date("Y-m-d H:i:s",time());
				$this->blockip_io_m->insert_map($insertData);
				
				$json_array['status'] = 'error';
				$json_array['message'] = language_translate('member_login_email_not_existed');
				echo json_encode($json_array);
				exit;
			}else{
				$insertData['email'] = $email;
				$this->blacklistemail_io_m->insert_map($insertData);
			}
			
		}else{
			if(! $this->user_io_m->checkPassword($userWithEmail->id_user,$password)){
				$numberFailureAttemp = $this->blockip_io_m->countFailureAttemp();
				if($numberFailureAttemp < $GLOBALS['global']['BLOCK_IP']['count']){
					$insertData['username'] = $userWithEmail->username;
					$insertData['ipfailure'] = $numberFailureAttemp+1;
					$insertData['ipstatus'] = 2;
					$insertData['ip'] = $this->geo_lib->getIpAddress();
					$insertData['reason'] = 'Password is Wrong';
                    $insertData['time_fail'] = mysqlDate();//date("Y-m-d H:i:s",time());
					$this->blockip_io_m->insert_map($insertData);
					
					$json_array['status'] = 'error';
					$json_array['message'] = language_translate('member_login_password_error');
					echo json_encode($json_array);
					exit;
				}else{
					$insertData['email'] = $email;
					$this->blacklistemail_io_m->insert_map($insertData);
				}
				$this->insertIntoLogin($email,5,1);
			}else{	
			    if($userWithEmail->fake_email == 1){
			         $_SESSION['fake_email_detected'] = 1;
                    $json_array['status'] = 'fake_email';
					echo json_encode($json_array);
					exit;
			    }else{
			      	$this->blockip_io_m->deleteFailureAttemp();
                    
                    if($userWithEmail->status == 0){
                        $this->user_io_m->saveAccountToSessionInfo($userWithEmail->id_user);
        				if($rememberme == 1){
        					$this->user_io_m->saveAccountToCookieInfo($userWithEmail->id_user);
        				}
        				
        				$json_array['status'] = 'ok';
        				$json_array['message'] = language_translate('member_login_success');
        				echo json_encode($json_array);
                    } else{
                        //die("This account had been deactivated. You can not login.");
                        $json_array['status'] = 'error';
    					$json_array['message'] = 'This account had been deactivated. You can not login.';
    					echo json_encode($json_array);
    					exit;
                    }
                    
    				
                }
			}
		}
		
	}
    
    function submit_renamed_email_site_login(){
   	    $json_array = array();
		$old_email = $this->input->post('old_email');
        $new_email = $this->input->post('new_email');
		$password = $this->input->post('password');
	
		if(! $this->phpvalidator->is_email($old_email)){
			$json_array['status'] = 'error';
			$json_array['message'] = language_translate('member_login_old_email_format_error');
			echo json_encode($json_array);
			exit;
		}
		if(! $this->phpvalidator->is_email($new_email)){
			$json_array['status'] = 'error';
			$json_array['message'] = language_translate('member_login_new_email_format_error');
			echo json_encode($json_array);
			exit;
		}
        
		$checkBlackListEmail = $this->blacklistemail_io_m->init('email',$old_email);
		if($checkBlackListEmail){
			$json_array['status'] = 'error';
			$json_array['message'] = language_translate('member_login_email_blacklist_error');
			echo json_encode($json_array);
			exit;
		}
		
		$userWithEmail = $this->user_io_m->init('email',$old_email);
		if(!$userWithEmail){
			$numberFailureAttemp = $this->blockip_io_m->countFailureAttemp();
			if($numberFailureAttemp < $GLOBALS['global']['BLOCK_IP']['count']){
				$insertData['username'] = $old_email;
				$insertData['ipfailure'] = $numberFailureAttemp+1;
				$insertData['ipstatus'] = 2;
				$insertData['ip'] = $this->geo_lib->getIpAddress();
				$insertData['reason'] = 'Both Credentials are wrong';
                $insertData['time_fail'] = mysqlDate();//date("Y-m-d H:i:s",time());
				$this->blockip_io_m->insert_map($insertData);
				
				$json_array['status'] = 'error';
				$json_array['message'] = language_translate('member_login_email_not_existed');
				echo json_encode($json_array);
				exit;
			}else{
				$insertData['email'] = $old_email;
				$this->blacklistemail_io_m->insert_map($insertData);
			}
			
		}else{
			if(! $this->user_io_m->checkPassword($userWithEmail->id_user,$password)){
				$numberFailureAttemp = $this->blockip_io_m->countFailureAttemp();
				if($numberFailureAttemp < $GLOBALS['global']['BLOCK_IP']['count']){
					$insertData['username'] = $userWithEmail->username;
					$insertData['ipfailure'] = $numberFailureAttemp+1;
					$insertData['ipstatus'] = 2;
					$insertData['ip'] = $this->geo_lib->getIpAddress();
					$insertData['reason'] = 'Password is Wrong';
                    $insertData['time_fail'] = mysqlDate();//date("Y-m-d H:i:s",time());
					$this->blockip_io_m->insert_map($insertData);
					
					$json_array['status'] = 'error';
					$json_array['message'] = language_translate('member_login_password_error');
					echo json_encode($json_array);
					exit;
				}else{
					$insertData['email'] = $old_email;
					$this->blacklistemail_io_m->insert_map($insertData);
				}
				$this->insertIntoLogin($email,5,1);
			}else{	
                $checkNewEmailInSystem = $this->user_io_m->init('email',$new_email);
                if($checkNewEmailInSystem){
                    $json_array['status'] = 'error';
    				$json_array['message'] = language_translate('member_login_new_email_was_existed');
    				echo json_encode($json_array);  
                    exit;  
                } 
                //$status = $this->email_sender->juzonSendEmail_JUZ_WELCOME_EMAIL($userWithEmail->id_user,$new_email);
                $status = checkRealEmail($new_email);
			    if( !$status ){
			        $json_array['status'] = 'error';
    				$json_array['message'] = language_translate('member_login_new_email_not_valid');
    				echo json_encode($json_array);  
                    exit;  
			    }else{
			      	$this->blockip_io_m->deleteFailureAttemp();
    				$this->user_io_m->saveAccountToSessionInfo($userWithEmail->id_user);
    			    
                    $userdata['email']  =   $new_email;
                    $userdata['fake_email'] = 0;
                    $this->user_io_m->update_map($userdata,$userWithEmail->id_user);
                     
    				$json_array['status'] = 'ok';
    				$json_array['message'] = language_translate('member_login_success');
    				echo json_encode($json_array);
                }
			}
		}
    }
	
	function insertIntoLogin($email,$status,$failure_attemp){
		$userdata = $this->user_io_m->init('email',$email);
		if($userdata){
			$data['id_user'] =	$userdata->id_user; 
			$data['ip'] =	$this->geo_lib->getIpAddress();
			$data['date_login'] =	mysqlDate(); //date("Y-m-d H:i:s",time());
			$data['username'] =	$userdata->username; 
			$data['status'] =	$status; 
			$data['failure_attempt'] =	$failure_attemp; 
			$data['email'] =	$email;
			$this->mod_io_m->insert_map($data,TBL_LOGIN);
		}
		
	}
	
	function submit_forgot_email()
	{
		$json_array = array();
		$email = $this->input->post('email');
		
		if(! $this->phpvalidator->is_email($email)){
			$json_array['status'] = 'error';
			$json_array['message'] = language_translate('member_login_email_format_error');
			echo json_encode($json_array);
			exit;
		}
		
		$checkBlackListEmail = $this->blacklistemail_io_m->init('email',$email);
		if($checkBlackListEmail){
			$json_array['status'] = 'error';
			$json_array['message'] = language_translate('member_login_email_blacklist_error');
			echo json_encode($json_array);
			exit;
		}
		
		$userWithEmail = $this->user_io_m->init('email',$email);
		if(!$userWithEmail){
			$numberFailureAttemp = $this->blockip_io_m->countFailureAttemp();
			if($numberFailureAttemp < $GLOBALS['global']['BLOCK_IP']['count']){
				$insertData['username'] = $email;
				$insertData['ipfailure'] = $numberFailureAttemp+1;
				$insertData['ipstatus'] = 2;
				$insertData['ip'] = $this->geo_lib->getIpAddress();
				$insertData['reason'] = 'Both Credentials are wrong';
				$insertData['time_fail'] = mysqlDate();//date("Y-m-d H:i:s",time());
				
				$this->blockip_io_m->insert_map($insertData);
				
				$json_array['status'] = 'error';
				$json_array['message'] = language_translate('member_login_email_not_existed');
				echo json_encode($json_array);
				exit;
			}else{
				$insertData['email'] = $email;
				$this->blacklistemail_io_m->insert_map($insertData);
			}
		}else{
			$this->email_sender->juzonSendEmail_FORGOTPASSWORD($userWithEmail->id_user);
			$json_array['status'] = 'ok';
			$json_array['message'] = '';
			echo json_encode($json_array);
			exit;
		}
		
	}
		
	function active_pw_account(){
		$id_user = intval($_GET['uid']);
		$newpasswd = $_GET['np'];
		$hashing = $_GET['sid'];
		
		$userobjdata = $this->user_io_m->init('id_user',$id_user);
		if($hashing != md5($userobjdata->username.$newpasswd)){
			show_404();
		}else{
			$data['password'] = md5($newpasswd);
			$this->user_io_m->update_map($data,$id_user);
		}
	}	
		
	function checkUsernameValid(){
		$username = strtolower( $this->input->post('username','') );
		
		if(strlen($username) < 6 || strlen($username) > 30){
			return json_encode(
				array(
					'result'	=> 'ERROR',
					'message'	=> language_translate('member_fb_username_error_length')
				)
			);
		}
		if(! $this->phpvalidator->is_alphanumericdash($username)){
			return json_encode(
				array(
					'result'	=> 'ERROR',
					'message'	=> language_translate('member_fb_username_error_length')
				)
			);
		}
		
		$res = $this->db->get(TBL_USER)->result();
		
		$restrict_user[] = 'user';
		$restrict_user[] = 'admin';
        $restrict_user[] = 'fadmin';
		$restrict_user[] = 'page';
		$restrict_user[] = 'member';
		$restrict_user[] = 'users';
		$restrict_user[] = 'members';
		$restrict_user[] = 'pages';
		$restrict_user[] = 'module';
		$restrict_user[] = 'modules';
		$restrict_user[] = 'mod_io';
		$restrict_user[] = 'blog';
		$restrict_user[] = 'comments';
		$restrict_user[] = 'contact';
		$restrict_user[] = 'files';
		$restrict_user[] = 'groups';
		$restrict_user[] = 'keywords';
		$restrict_user[] = 'newletters';
		$restrict_user[] = 'redirects';
		$restrict_user[] = 'settings';
		$restrict_user[] = 'variables';
		$restrict_user[] = 'widgets';
		$restrict_user[] = 'themes';
		$restrict_user[] = 'streams';
		$restrict_user[] = 'sitemap';
		$restrict_user[] = 'xml';
		$restrict_user[] = 'feed';
		$restrict_user[] = 'rss';
		$restrict_user[] = 'permissions';
		$restrict_user[] = 'anonymously';
		$restrict_user[] = 'anonymous';
		$restrict_user[] = 'hentai';
		$restrict_user[] = 'videos';
		$restrict_user[] = 'video';
		
		foreach($res as $item){
			$restrict_user[] = $item->username;
		}
		
		if(in_array($username,$restrict_user)){
			return json_encode(
				array(
					'result'	=> 'ERROR',
					'message'	=> language_translate('member_fb_username_error_not_available')
				)
			); 
		}
		
		return json_encode(
				array(
					'result'	=> 'OK',
					'message'	=> language_translate('member_fb_username_available')
				)
			); 
	}	
		
	function submit_fb_register(){
		$fbDataArr = $this->facebookmodel->getCurrentFacebookUser();
		extract($_POST);
		
		/**
		//check facebook verified
		if(! $this->facebookmodel->isAccountVerified()){
			echo json_encode(
				array(
					'result'	=> 'ERROR',
					'message'	=> language_translate('member_fb_account_not_verified_error')
				)
			); 
			exit;
		}
		**/
		
		//check valid username
		$usernameStatus = json_decode($this->checkUsernameValid($username));
		if($usernameStatus->result == 'ERROR'){
			echo json_encode(
				array(
					'result'	=> 'ERROR',
					'message'	=> $usernameStatus->message
				)
			); 
			exit;
		}	
		
		//check valid password
		if(strlen($password) < 6 OR strlen($password) > 30){
			echo json_encode(
				array(
					'result'	=> 'ERROR',
					'message'	=> language_translate('member_fb_password_error')
				)
			); 
			exit;
		}
		
		//check valid email
		$res = $this->db->get(TBL_USER)->result();
		foreach($res as $item){
			$restrict_email[] = $item->email;
		}
		
		if(in_array($fbDataArr["email"],$restrict_email)){
			echo json_encode(
				array(
					'result'	=> 'ERROR',
					'message'	=> language_translate('member_fb_email_error')
				)
			); 
			exit;
		}
		
		if($this->facebookmodel->getTotalFriends() < $GLOBALS['global']['FACEBOOK']['MinFacebookFriendsRequired']){
			echo json_encode(
				array(
					'result'	=> 'ERROR',
					'message'	=> str_replace( '$s', $GLOBALS['global']['FACEBOOK']['MinFacebookFriendsRequired'] ,language_translate('member_fb_friend_request_error') )
				)
			); 
			exit;
		}
		
		if($this->facebookmodel->countPictures() < $GLOBALS['global']['FACEBOOK']['MinFacebookPhotosRequired']){
			echo json_encode(
				array(
					'result'	=> 'ERROR',
					'message'	=> str_replace( '$s', $GLOBALS['global']['FACEBOOK']['MinFacebookPhotosRequired'], language_translate('member_fb_photo_request_error') )
				)
			); 
			exit;
		}
		
		$dob = $this->facebookmodel->convertToJuzDateFormat( isset($fbDataArr["birthday"]) ? $fbDataArr["birthday"] : "10/10/2000"  );
		$user['dob'] = $dob;
		$user['age'] = floor((strtotime(date('Y-m-d')) - strtotime($user['dob'])) / (31557600));
		
		//check valid age
		if($user['age'] < 18){
			echo json_encode(
				array(
					'result'	=> 'ERROR',
					'message'	=> language_translate('member_fb_age_error')
				)
			); 
			exit;
		}
		
		//if not user invited, user default from config
		if(!isset($_SESSION['USER_INVITE'])){
			$email_invite_default = $GLOBALS['global']['HOME_PAGE']['defaultinviterforhomepage']; 
			$owner_id = $this->user_io_m->getUserIdFromEmail($email_invite_default);
		}else{
			$owner_id = $_SESSION['USER_INVITE']['id_user'];
		}
		
		$user['owner'] = $owner_id;
		$user['username'] = strtolower($username);
		$user['timezone'] = $timezone;
		$user['email']	=	$fbDataArr["email"];
		
		$geo_data = $this->geo_lib->getLocationInfoFromIP();
		if($geo_data){
			$countryData = $this->geo_lib->getCountryDataInfoFromCountryName($geo_data["country"]);
			if($countryData){
				$user['id_country'] = $countryData->id_country;
				$user['country']	= $countryData->country_name;
			}else{
				$user['id_country'] = 150;
				$user['country'] = 'Malaysia';
			}
		}else{
			$user['id_country'] = 150;
			$user['country'] = 'Malaysia';
		}
		
		$user['gender'] = ucfirst($fbDataArr["gender"]);
		$user['password'] = md5($password);
		$user['nickname'] = $user['username'];
		$user['random_num'] = 0;
		$user['map_access'] = $GLOBALS['global']['ADMIN_DEFAULT']['map'];
		$user['chat_access'] = $GLOBALS['global']['ADMIN_DEFAULT']['chat'];
		$user['peep_access'] = $GLOBALS['global']['ADMIN_DEFAULT']['peep'];
		$user['announce_flag'] = $user['age'] ;
		$user['first_name'] = $fbDataArr["first_name"];
		$user['last_name'] = $fbDataArr["middle_name"].' '.$fbDataArr["last_name"];
		$user['add_date']	= mysqlDate();
		$user['last_login'] = mysqlDate();
		
		if($latitude AND $longitude){
			$user['longitude'] = $longitude ;
			$user['latitude'] = $latitude ;
		}else{
			$geo = $this->geo_lib->getCoordinatesFromAddress($user['country']);
			$user['longitude'] = $geo['longitude'];
			$user['latitude']  = $geo['latitude'];
		}
		 	
		//insert user data into db
		$new_id_user = $this->user_io_m->insert_map($user);
		
		//update invited confirm
		if($new_id_user){
			$confirmID = $this->user_io_m->generateConfirmInviteId($owner_id,$user['email']);
			$invite['invite_confirm'] = '0';
			$invite['invite_join_date'] = mysqlDate();
			$this->mod_io_m->update_map($invite, array('invite_confirm'=>$confirmID), TBL_INVITATION);
			
			//add user to friend if have invite
			//$rec = $this->db->where("invited_email",$user['email'])->where("invite_id_user",$user['owner'])->get(TBL_INVITATION)->result();
			//if ($rec) {
				$friend['id_user'] = $new_id_user;
				$friend['friend'] = $user['owner'];
				$friend['request_type'] = $GLOBALS['global']['FRIEND_ACTION']['accept'];
				$friend['request_date'] = $rec[0]->invite_date;
				$this->mod_io_m->insert_map($friend,TBL_FRIENDLIST);
			//}
		}
		
		//update value and cash to new user
		$cash['cash'] = $GLOBALS['global']['USER_CASH']['invited_cash'];
		$cash['cur_value'] = $GLOBALS['global']['USER_CASH']['pet_start_value'];
		$this->user_io_m->update_map($cash,$new_id_user);
		
		//update invite cash for owner user
		$this->db->query( "UPDATE ".TBL_USER." SET cash=cash+".$GLOBALS['global']['USER_CASH']['invite_cash']." WHERE id_user=".$owner_id );
		
		//add new user is pet of owner user
		$this->db->query( "INSERT INTO ".TBL_PET." (id_user,id_owner,add_date,ip) VALUES(".$new_id_user.",".$owner_id.",NOW(),'".$_SERVER['REMOTE_ADDR']."')" );
		
		//Transaction for invite user
	    $this->db->query( "INSERT INTO ".TBL_TRANSACTION." (id_owner,id_user,amount,trans_type,user_amt,trans_date,ip) 
							VALUES( 1,'".$owner_id."','".$GLOBALS['global']['USER_CASH']['invite_cash'].
										"','".$GLOBALS['global']['TRANS_TYPE']['referred_cash'].
										"','".$GLOBALS['global']['USER_CASH']['invite_cash']."',NOW(),'".
										$_SERVER['REMOTE_ADDR']."')" );
	   //Transaction for invited user
	    $this->db->query(  "INSERT INTO ".TBL_TRANSACTION." (id_owner,id_user,amount,trans_type,user_amt,trans_date,ip) 
						VALUES( 1,'".$new_id_user."','".
						$GLOBALS['global']['USER_CASH']['invited_cash']."','".
						$GLOBALS['global']['TRANS_TYPE']['new_user_cash']."','".
						$GLOBALS['global']['USER_CASH']['invited_cash']."',NOW(),'".
						$_SERVER['REMOTE_ADDR']."')" );
		
		$FirstStatusMessage = $GLOBALS['global']['FACEBOOK']['FirstStatusMessage'];   
		$FirstStatusDescription = $GLOBALS['global']['FACEBOOK']['FirstStatusDescription'];   

        $invite_url=$this->user_io_m->getInviteUrl($user['username']);
			
       	$this->facebookmodel->postOnWall($FirstStatusMessage,$FirstStatusDescription,$invite_url);
					
		$this->facebookmodel->registerFacebookConnected($new_id_user);
		// $this->facebookmodel->transferPicturesFromFaceBookToJuzon($new_id_user);
		$this->facebookmodel->getProfilePicture($new_id_user);
		$this->facebookmodel->updateAboutMeCurrentCityJuz($new_id_user);
	/**	
		$friend['id_user'] = $new_id_user;
		$friend['friend'] = $user['owner'] ;
		$friend['request_type'] = $GLOBALS['global']['FRIEND_ACTION']['accept'];
		$friend['request_date'] = date("Y-m-d H:i:s",time());
		$this->mod_io->insert_map($friend,TBL_FRIENDLIST);
	**/	
        /**
        if(checkRealEmail($new_id_user)){
             $welcomeemail_status['fake_email'] = 0;
        }else{
            $welcomeemail_status['fake_email'] = 1;
        }
        $this->user_io_m->update_map($welcomeemail_status,$new_id_user);
        **/
        
		echo json_encode(
				array(
					'result'	=> 'ok',
					'message'	=> language_translate('member_fb_register_success')
				)
			); 
		exit;
		
	}	
	
	
	function submit_tt_register(){
		$dataarr = $this->twittermodel->getCurrentUserDetails();
		extract($_POST);
		
		//check valid username
		$usernameStatus = json_decode($this->checkUsernameValid($username));
		if($usernameStatus->result == 'ERROR'){
			echo json_encode(
				array(
					'result'	=> 'ERROR',
					'message'	=> $usernameStatus->message
				)
			); 
			exit;
		}	
		
		//check valid password
		if(strlen($password) < 6 OR strlen($password) > 30){
			echo json_encode(
				array(
					'result'	=> 'ERROR',
					'message'	=> language_translate('member_fb_password_error')
				)
			); 
			exit;
		}
		
		//check valid password
		if(! $this->phpvalidator->is_email($email)){
			echo json_encode(
				array(
					'result'	=> 'ERROR',
					'message'	=> language_translate('member_email_error')
				)
			); 
			exit;
		}
		
		//check valid email
		$res = $this->db->get(TBL_USER)->result();
		foreach($res as $item){
			$restrict_email[] = $item->email;
		}
		
		if(in_array($email,$restrict_email)){
			echo json_encode(
				array(
					'result'	=> 'ERROR',
					'message'	=> language_translate('member_fb_email_error')
				)
			); 
			exit;
		}
		
		if($this->twittermodel->getTotalFollowers() < $GLOBALS['global']['TWITTER']['MinFollowersRequired']){
			echo json_encode(
				array(
					'result'	=> 'ERROR',
					'message'	=> str_replace( '$s', $GLOBALS['global']['TWITTER']['MinFollowersRequired'], language_translate('member_tt_followers_request_error') )
				)
			); 
			exit;
		}
		
		if($this->twittermodel->getTotalTweets() < $GLOBALS['global']['TWITTER']['MinTweetsRequired']){
			echo json_encode(
				array(
					'result'	=> 'ERROR',
					'message'	=> str_replace( '$s', $GLOBALS['global']['TWITTER']['MinTweetsRequired'], language_translate('member_tt_mintweet_request_error') )
				)
			); 
			exit;
		}
		
		if($this->twittermodel->accountCreatedDaysBefore() < $GLOBALS['global']['TWITTER']['MinDaysOldAccountRequired']){
			echo json_encode(
				array(
					'result'	=> 'ERROR',
					'message'	=> str_replace( '$s', $GLOBALS['global']['TWITTER']['MinDaysOldAccountRequired'], language_translate('member_tt_mindays_request_error') )
				)
			); 
			exit;
		}
		
        $birthday = $day.'-'.$month.'-'.$year;
		if(! $birthday){
			echo json_encode(
				array(
					'result'	=> 'ERROR',
					'message'	=> language_translate('member_birthday_error')
				)
			); 
			exit;
		}
		
		
		$dob = $this->facebookmodel->convertToJuzDateFormat( isset($birthday) ? $birthday : "10/10/2000"  );
		$user['dob'] = $dob;
		$user['age'] = floor((strtotime(date('Y-m-d')) - strtotime($user['dob'])) / (31557600));
		
		//check valid age
		if($user['age'] < 18){
			echo json_encode(
				array(
					'result'	=> 'ERROR',
					'message'	=> language_translate('member_fb_age_error')
				)
			); 
			exit;
		}
		
		//if not user invited, user default from config
		if(!isset($_SESSION['USER_INVITE'])){
			$email_invite_default = $GLOBALS['global']['HOME_PAGE']['defaultinviterforhomepage']; 
			$owner_id = $this->user_io_m->getUserIdFromEmail($email_invite_default);
		}else{
			$owner_id = $_SESSION['USER_INVITE']['id_user'];
		}
		
		$user['owner'] = $owner_id;
		$user['username'] = strtolower($username);
		$user['timezone'] = $timezone;
		$user['email']	=	$email;
		$user['about_me'] = $dataarr['description'];
		
		$geo_data = $this->geo_lib->getLocationInfoFromIP();
		if($geo_data){
			$countryData = $this->geo_lib->getCountryDataInfoFromCountryName($geo_data["country"]);
			if($countryData){
				$user['id_country'] = $countryData->id_country;
				$user['country']	= $countryData->country_name;
			}else{
				$user['id_country'] = 150;
				$user['country'] = 'Malaysia';
			}
		}else{
			$user['id_country'] = 150;
			$user['country'] = 'Malaysia';
		}
		
		$user['gender'] = ucfirst($gender);
		$user['password'] = md5($password);
		$user['nickname'] = $user['username'];
		$user['random_num'] = 0;
		$user['map_access'] = $GLOBALS['global']['ADMIN_DEFAULT']['map'];
		$user['chat_access'] = $GLOBALS['global']['ADMIN_DEFAULT']['chat'];
		$user['peep_access'] = $GLOBALS['global']['ADMIN_DEFAULT']['peep'];
		$user['announce_flag'] = $user['age'] ;
		$user['first_name'] = $firstname;
		$user['last_name'] = $lastname;
		$user['add_date']	= mysqlDate();
		$user['last_login'] = mysqlDate();
		
		if($latitude AND $longitude){
			$user['longitude'] = $longitude ;
			$user['latitude'] = $latitude ;
		}else{
			$geo = $this->geo_lib->getCoordinatesFromAddress($user['country']);
			$user['longitude'] = $geo['longitude'];
			$user['latitude']  = $geo['latitude'];
		}
		 	
		//insert user data into db
		$new_id_user = $this->user_io_m->insert_map($user);
		
		//update invited confirm
		if($new_id_user){
			$confirmID = $this->user_io_m->generateConfirmInviteId($owner_id,$user['email']);
			$invite['invite_confirm'] = '0';
			$invite['invite_join_date'] = mysqlDate();
			$this->mod_io_m->update_map($invite, array('invite_confirm'=>$confirmID), TBL_INVITATION);
			
			//add user to friend if have invite
		//	$rec = $this->db->where("invited_email",$user['email'])->where("invite_id_user",$user['owner'])->get(TBL_INVITATION)->result();
		//	if ($rec) {
				$friend['id_user'] = $new_id_user;
				$friend['friend'] = $user['owner'];
				$friend['request_type'] = $GLOBALS['global']['FRIEND_ACTION']['accept'];
				$friend['request_date'] = mysqlDate();//$rec[0]->invite_date;
				$this->mod_io_m->insert_map($friend,TBL_FRIENDLIST);
		//	}
		}
		
		//update value and cash to new user
		$cash['cash'] = $GLOBALS['global']['USER_CASH']['invited_cash'];
		$cash['cur_value'] = $GLOBALS['global']['USER_CASH']['pet_start_value'];
		$this->user_io_m->update_map($cash,$new_id_user);
		
		//update invite cash for owner user
		$this->db->query( "UPDATE ".TBL_USER." SET cash=cash+".$GLOBALS['global']['USER_CASH']['invite_cash']." WHERE id_user=".$owner_id );
		
		//add new user is pet of owner user
		$this->db->query( "INSERT INTO ".TBL_PET." (id_user,id_owner,add_date,ip) VALUES(".$new_id_user.",".$owner_id.",NOW(),'".$_SERVER['REMOTE_ADDR']."')" );
		
		//Transaction for invite user
	    $this->db->query( "INSERT INTO ".TBL_TRANSACTION." (id_owner,id_user,amount,trans_type,user_amt,trans_date,ip) 
							VALUES( 1,'".$owner_id."','".$GLOBALS['global']['USER_CASH']['invite_cash'].
										"','".$GLOBALS['global']['TRANS_TYPE']['referred_cash'].
										"','".$GLOBALS['global']['USER_CASH']['invite_cash']."',NOW(),'".
										$_SERVER['REMOTE_ADDR']."')" );
	   //Transaction for invited user
	    $this->db->query(  "INSERT INTO ".TBL_TRANSACTION." (id_owner,id_user,amount,trans_type,user_amt,trans_date,ip) 
						VALUES( 1,'".$new_id_user."','".
						$GLOBALS['global']['USER_CASH']['invited_cash']."','".
						$GLOBALS['global']['TRANS_TYPE']['new_user_cash']."','".
						$GLOBALS['global']['USER_CASH']['invited_cash']."',NOW(),'".
						$_SERVER['REMOTE_ADDR']."')" );
		
		$FirstStatusMessage = $GLOBALS['global']['TWITTER']['FirstStatusMessage'];   
		//$FirstStatusDescription = $GLOBALS['global']['FACEBOOK']['FirstStatusDescription'];   
		//$FirstStatusMessage,$FirstStatusDescription,
		
        $invite_url=$this->user_io_m->getInviteUrl($user['username']);
			
       	$this->twittermodel->postInviteStatus($invite_url);
					
		$this->twittermodel->registerTwitterConnected($new_id_user);
		// $this->facebookmodel->transferPicturesFromFaceBookToJuzon($new_id_user);
		$this->twittermodel->changeProfileImage($new_id_user,$this->twittermodel->savePictureToJuz($new_id_user));
		//$this->twittermodel->updateAboutMeCurrentCityJuz($new_id_user);
	/**	
		$friend['id_user'] = $new_id_user;
		$friend['friend'] = $user['owner'] ;
		$friend['request_type'] = $GLOBALS['global']['FRIEND_ACTION']['accept'];
		$friend['request_date'] = date("Y-m-d H:i:s",time());
		$this->mod_io->insert_map($friend,TBL_FRIENDLIST);
	**/	
        if(checkRealEmail($email)){
             $welcomeemail_status['fake_email'] = 0;
        }else{
            $welcomeemail_status['fake_email'] = 1;
        }
       
        $this->user_io_m->update_map($welcomeemail_status,$new_id_user);
        
		echo json_encode(
				array(
					'result'	=> 'ok',
					'message'	=> language_translate('member_fb_register_success')
				)
			); 
		exit;
	}
	
	
	
	
	
	
	
	
	
	
	
//end class	 
}