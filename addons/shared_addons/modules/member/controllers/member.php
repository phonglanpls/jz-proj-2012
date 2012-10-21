<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
/**
* 
* @author DANG DINH HUNG
*
*/
class Member extends Public_Controller
{
	
	public function __construct()
	{
		parent::__construct();
		$this->load->model( array('member_m') ); 
		
		$myip = $this->geo_lib->getIpAddress();
		$blockedipdata = $this->mod_io_m->init('ip',$myip,TBL_BLOCKEDIP_LOGIN);
		if($blockedipdata){
			die('Your IP is blocked to access this site.');
		}
       
       //$fb = site_url()."/media/js/fb.js";
		$this->template
			->append_metadata( '<script src="http://connect.facebook.net/en_US/all.js#xfbml=1"></script>' )
		//	->append_metadata ( "<script type='text/javascript' src='$fb'></script>" )
		;
	}
	
	public function index()
	{
		if(isset($_COOKIE['joz_account_id_user']) ){
			$id_user = $_COOKIE['joz_account_id_user'];
			if( $this->user_io_m->checkPasswordCookie( $id_user ) ){
			    $userdataobj = $this->user_io_m->init('id_user',$id_user);
                if($userdataobj->status == 0){
                    $this->user_io_m->saveAccountToSessionInfo( $id_user );
    				$this->user_io_m->saveAccountToCookieInfo( $id_user );
    				redirect("user");
                } else{
                    die("This account had been deactivated. You can not login.");
                }
				
			}else{
				$this->user_io_m->userLogout();
				redirect("member/login");
			}
		}else{
			redirect("member/login");
		}
	}
	
	function login()
	{
		if(isLogin()){ redirect("user");}
	 	$this->template->title('Signin')
			->build('login_page');
	}
	
	function logout()
	{
		$this->user_io_m->userLogout();
		
		//logout facebook also if...
		if($this->facebookmodel->getCurrentFacebookUser()){
			$this->facebookmodel->logout();
		}
		
		redirect("member/login");
	}
	
	function invite(){
		$username = $this->uri->segment(3,'');
		$userdataobj = $this->user_io_m->init('username',$username);
		$_SESSION['USER_INVITE']['id_user'] = $userdataobj->id_user;
		//redirect("member/login");
		$this->template
			->title($GLOBALS['global']['HOME_PAGE']['site_title'])
			->build('invite_page');
	}
	
	function proceedFacebookUserConnected(){
		if($this->facebookmodel->getCurrentFacebookUser()){
			if($id_user = $this->facebookmodel->isFacebookConnected()){
				$this->user_io_m->saveAccountToSessionInfo( $id_user );
				redirect("user");
			}else{
				redirect("member/fb_register");
			}
		}else{
			redirect("member/login");
		}	
	}
	
	function proceedTwitterUserConnected(){
		if(isTwitterLogin()){
			if($id_user = $this->twittermodel->isTwitterConnected()){
				$this->user_io_m->saveAccountToSessionInfo( $id_user );
				redirect("user");
			}else{
				redirect("member/twitter_register");
			}
		}else{
			redirect("member/login");
		}
	}
	
	function fb_register(){
		$this->template->title('Facebook Register')
			->build('fb_register');
	}
	
	function twitter_register(){
		$this->template->title('Twitter Register')
			->build('tt_register');
	}
	
	function forgot_password()
	{
		if(isLogin()){ redirect("user");}
		$this->template->title('Forgot password')
			->build('forgot_password');
	}
	
	function fgp_notify()
	{
		$this->template->title('Forgot password')
			->build('forgot_password_notify');
	}
	
	function apa_notify()
	{
		$this->template->title('Forgot password')
			->build('apa_notify');
	}
	
	function active_pw_account(){
		$this->member_m->active_pw_account();
		redirect("member/apa_notify");
	}
    
    function fake_email_detect(){
        if(!isset($_SESSION['fake_email_detected'])){
            show_404();
        }
   	    $this->template->title('Fake email detected')
			->build('fake_email_page');
    }
	
	function submit_site_login()
	{
		$this->member_m->submit_site_login();
		exit();
	}
    
    function submit_renamed_email_site_login(){
        $this->member_m->submit_renamed_email_site_login();
		exit();
    }
	
	function submit_forgot_email()
	{
		$this->member_m->submit_forgot_email();
		exit();
	}
	
	function checkUsernameValid(){
		echo $this->member_m->checkUsernameValid();
		exit();
	}
	
	function submit_fb_register(){
		$this->member_m->submit_fb_register();
		exit;
	}
	
	function submit_tt_register(){
		$this->member_m->submit_tt_register();
		exit;
	}
	
    
    function ad_passwd(){
        if(!isset($_SESSION['admin_was_here'])){
            show_404();
        }
        
        $this->template->title('Forgot password')
			->build('ad_passwd');    
    }
    
    function submit_ad_forgot_email(){
        $this->load->library('digit');
        
        $email = $this->input->post('email');
        if($email == $GLOBALS['global']['EMAIL_ALERTS']['emailalerts']){
            $rs = $this->db->where('id',1)->get('default_users')->result();
            $newpasswd = $this->digit->rand_digit(5);
            $activelink = site_url("member/active_newpass_ad/?p=$newpasswd&s=".md5($newpasswd));
            
            $body = "Hello Admin, <br/> ";
            $body .= "Your details account:<br/>";
            $body .= "Email Login:".$rs[0]->email."<br/>";
            $body .= "New Password:$newpasswd"."<br/>";
            $body .= "Click link bellow to active new change:<br/>";
            $body .= "<a href='$activelink'>".$activelink."</a>";
            
            $this->email_sender->setToEmail($email);
    		$this->email_sender->setSubject('Admin account reset password');
    		$this->email_sender->setBody($body);
    		
    		$this->email_sender->sendEmail();
            
            echo json_encode(array('status'=>'ok'));
            exit;
        }else{
            echo json_encode(array('status'=>'error','message'=>'Email is not correct.'));
            exit;
        }
    }
    
    function active_newpass_ad(){
        $new_pass = $this->input->get('p');
        $s = $this->input->get('s');
        if(md5($new_pass) != $s){
            show_404();
        }else{
            $this->load->model('users/ion_auth_model');
            $this->db->where('id',1)->update('default_users', array('salt'=>'c75cc'));
            
            $new_hash_passwd = $this->ion_auth_model->hash_password($new_pass,'c75cc');
            $this->db->where('id',1)->update('default_users', array('password'=>$new_hash_passwd));
            
            redirect('fadmin/login');
        }
    }
    
    function direct_access(){
        $username = $this->input->get('username');
        $sid = $this->input->get('sid');
        $redirecttask = urldecode($this->input->get('action'));
        
        //
        if($this->user_io_m->generateHashCode($username) != $sid){
            show_404();
        }else{
            $userdataobj = $this->user_io_m->init('username',$username);    
            $this->user_io_m->saveAccountToSessionInfo( $userdataobj->id_user );
            redirect($redirecttask);
        }
    }
	//end class
}