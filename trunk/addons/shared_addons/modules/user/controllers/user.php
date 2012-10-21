<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
/**
* 
* @author DANG DINH HUNG
*
*/
class User extends Public_Controller
{
	
	public function __construct()
	{
		parent::__construct();
		$this->load->model( 'user_m' ); 
		$this->load->model( 'wall_m' );
		$this->load->model( 'qa_m' );
		$this->load->model( 'wallet_m' );
		$this->load->model( 'friend_m' );
		$this->load->model( 'pet_m' );
		$this->load->model( 'wishlist_m' );
		$this->load->model( 'lock_m' );
		$this->load->model( 'collection_m' );
		$this->load->model( 'photos_m' );
		$this->load->model( 'backstage_m' );
		$this->load->model( 'rate_m' );
		$this->load->model( 'gift_m' );
		//$this->load->model( 'flirt_m' );
		$this->load->model( 'mapflirt_m' );
		$this->load->model( 'peep_m' );
		$this->load->model( 'block_m' );
		$this->load->model( 'online_m' );
		$this->load->model( 'random_message_m' );
		$this->load->model( 'hentai_m' );
		$this->load->model( 'watching_video_m' );
		$this->load->model( 'peepbought_history_m' );
		$this->load->model( 'report_abuse_m' );
		$this->load->model( 'favourite_m' );
		$this->load->model( 'trialpay_m' );
        
		if(!isLogin()){ 
			$currenturl = fullURL();
			if(false !== strpos($currenturl,'/videos/')){
				$redr = str_replace( array('/user/videos/video/','/user/videos/series/'),
									 array('/videos/category/video/','/videos/category/series/'),
									 $currenturl
									);
				redirect($redr);
				die; 
			}
			//redirect("member");
		}	
		
		
		if(isLogin()){
			$userdata = getAccountUserDataObject(true);
			if($userdata->status != 0){
				//show_404();
				die("This account had been deactivated.");
			}	
			
			$facebookdata = $this->db->where('userid',getAccountUserId())->get(TBL_FACEBOOK_CONNECT)->result();
			$twitterdata = $this->db->where('userid',getAccountUserId())->get(TBL_TWITTER_CONNECT)->result();
			
			if(!$facebookdata AND !$twitterdata){
				//force connect page
				if(isset($_SESSION['admin_switch_user'])){
					
				}else{
					if($this->uri->segment(2) != 'connect'){
						redirect("user/connect");
					}
				}
			}
			
			/*****
			if($facebookdata ){ //AND !isset($_SESSION['facebookinvokedtime'])
				if(!isFacebookLogin()){
					$url = $this->facebookmodel->getLoginLogoutUrl();
					$_SESSION['facebookinvokedtime'] = 1;
					if(ENVIRONMENT != 'development'){
						redirect( $url );
					}
				}
			}
			***/
			
			if($twitterdata AND $twitterdata[0]->session_data){
				if(!isTwitterLogin()){
					$this->twittermodel->invokedSessionLogin($twitterdata[0]->session_data);
				}
			}
			 
			
			if(isset($_SESSION['reffer_video_url'])){
				$tmp = $_SESSION['reffer_video_url'];
				unset($_SESSION['reffer_video_url']);
				redirect($tmp);
			}
			
			$this->user_io_m->userSyncCashAndValue(getAccountUserId());
			
			
			$current_dbprefix = $this->db->dbprefix;
			$this->db->set_dbprefix('');
			$check = $this->db->where('userid',getAccountUserId())->get('cometchat_status')->result();
			if(empty($check)){
				$this->db->set('userid',getAccountUserId());
				$this->db->set('message',NULL); 	 	 	
				$this->db->set('status','available');
				$this->db->set('typingto',NULL);
				$this->db->set('typingtime',NULL);
				
				$this->db->insert('cometchat_status');
			}
			$this->db->set_dbprefix($current_dbprefix);
		}
		
		//$fb = site_url()."/media/js/fb.js";
		$this->template
			->append_metadata( '<script src="http://connect.facebook.net/en_US/all.js#xfbml=1"></script>' )
		//	->append_metadata ( "<script type='text/javascript' src='$fb'></script>" )
		;
	}
	
	function checkLogin(){
		if(!isLogin()){ 
			redirect("member");
		}
	}
	
	function reloadConfig(){
		getGlobalConfig();
		var_dump($GLOBALS['global']);
	}
	
	public function index()
	{
		if(isLogin()){
			$this->template
				->title($GLOBALS['global']['HOME_PAGE']['site_title'])
				->build('homepage');
		}else{
			redirect("member/login");
		}
	}
	
	function test(){
		//echo $this->facebookmodel->getinviteRequestDialog('abc.com');
		$this->email_sender->juzonSendEmail_RANDOMMESSAGEEMAIL(3799,'hahaha');
		//echo $this->hentai_m->getFacebookVideoSource(406);
		//echo $this->email_sender->test();
		//print_r(checkRealEmail('bryanlaukl88@gmail.com'));
        //$this->load->model('mod_io/crontab_io_m');
        //$this->crontab_io_m->_resizePhoto();
		
		//$this->email_sender->testSwiftMailer();
	}
/**************************************************WALL**************************************************/
	function wall(){
		$this->checkLogin();
		$this->template
		->title($GLOBALS['global']['HOME_PAGE']['site_title'])
		->build('homepage');
	}
	
	function wall_view(){
		$this->checkLogin();
		$this->template
		->title($GLOBALS['global']['HOME_PAGE']['site_title'])
		->build('wall/view_item');
	}
	
	function wall_func(){
		$this->checkLogin();
		$task = $this->uri->segment(3,'');
		switch($task){
			case 'callFuncShowDialogChangeFilterWall':
				$this->load->view('user/ui_dialog/wall/callFuncShowDialogChangeFilterWall');
				break;
			case 'loadAsyncFilterSplitPartial':
				$this->load->view('user/wall/filter_box');
				break;
			case 'loadAsyncWallFeed':
				$this->load->view('user/wall/feed',array('cat'=>$this->input->get('segment','')));
				break;
			case 'loadAsyncCommentFeed':
				$this->load->view('user/wall/feed_comment', array('contextcm'=>'all', 'id_wall'=>$this->input->get('id_wall',0)) );
				break;
			case 'callFuncReloadShareSection':
				$this->load->view("user/wall/share_box");
				break;
			case 'callFuncShowWebcamSnapshot':
				$this->load->view('user/ui_dialog/wall/callFuncShowWebcamSnapshot');
				break;
		}			
	}
/***************************************************END WALL ************************************************/
	
/**************************************************ASKME*****************************************************/
	function qa_func(){
		$this->checkLogin();
		$task = $this->uri->segment(3,'');
		switch($task){
			case 'callFuncShowDialogSubmitQuestion':
				$this->load->view('user/ui_dialog/qa/callFuncShowDialogSubmitQuestion');
				break;
			case 'callFuncAnswerQuestion':
				$this->load->view('user/ui_dialog/qa/callFuncAnswerQuestion');
				break;
			case 'callFuncShowQuestions':	
				$this->load->view('user/askme/question');
				break;
			case 'callFuncShowAnswers':
				$this->load->view('user/askme/answer');
				break;	
			case 'callFuncShowAksFriends':
				$this->load->view('user/askme/askFriends');
				break;	
			case 'callFuncShowLog':
				$this->load->view('user/ui_dialog/qa/callFuncShowLog');
				break;
			case 'callFuncShowQuestionIdea':
				$this->load->view('user/ui_dialog/qa/callFuncShowQuestionIdea');
				break;
		}
	}
	
	function askme(){
		$this->checkLogin();
		$this->template
		->title($GLOBALS['global']['HOME_PAGE']['site_title'])
		->build('askme/askme');
	}
/**************************************************END ASKME*****************************************************/
	
/***************************************************WALLET*******************************************************/
	function wallet(){
		$this->checkLogin();
		$this->template
		->title($GLOBALS['global']['HOME_PAGE']['site_title'])
		->build('wallet/wallet');
	}
	
	function wallet_func(){
		$this->checkLogin();
		$task = $this->uri->segment(3,'');
		switch($task){
			case 'callFuncShowEarningTransaction':
				$this->load->view('user/wallet/earning', array('trans_type'=>intval($this->input->get('trans_type',0))));
				break;
			case 'callFuncShowExpenseTransaction':
				$this->load->view('user/wallet/expense', array('trans_type'=>intval($this->input->get('trans_type',0))));
				break;
			case 'callFuncShowBalance':
				$this->load->view('user/wallet/balance');
				break;
		}		
	}
/*************************************************END WALLET*****************************************************/
	
/***************************************************DOCUMENT INFORMATION*****************************************/
	function information(){
		$this->checkLogin();
		$this->template
		->title($GLOBALS['global']['HOME_PAGE']['site_title'])
		->build('information/information');
	}
/***********************************************END DOCUMENT INFORMATION*****************************************/	
	
/*********************************************FRIENDS************************************************************/
	function friends(){
		$this->checkLogin();
		$this->template
		->title($GLOBALS['global']['HOME_PAGE']['site_title'])
		->build('friends/friends');
	}	
	
	function friends_func(){
		$this->checkLogin();
		$task = $this->uri->segment(3,'');
		switch($task){
			case 'callFuncShowFriendFilter':
				$this->load->view('user/friends/show');
				break;
			case 'callFuncPreviewInviteFriends':
				$invite_link = "{invite_link}";
				$userdataobj = getAccountUserDataObject();
				$message = $this->input->get('message');
				$this->load->view('member/email_templates/friend/invite_friend', 
									array('invite_link'=>$invite_link,'userdataobj'=>$userdataobj,'message'=>$message)
								);
				break;
			case 'show_report_abuse_dialog':
				$this->load->view('ui_dialog/friend/report_abuse');
				break;	
				
			case 'callFuncShowMyFacebookFriends':
				$this->load->view('ui_dialog/friend/callFuncShowMyFacebookFriends');
				break;
			case 'callFuncShowMyTwitterFriends':
				$this->load->view('ui_dialog/friend/callFuncShowMyTwitterFriends');
				break;
		}		
	}
	
	function friends_request(){
		$this->checkLogin();
		$this->template
		->title($GLOBALS['global']['HOME_PAGE']['site_title'])
		->build('friends/friends_request');
	}
	
	function invite_friends(){
		$this->checkLogin();
		$this->template
		->title($GLOBALS['global']['HOME_PAGE']['site_title'])
		->build('friends/invite_friends');
	}
	
	function birthdays(){
		$this->checkLogin();
		$this->template
		->title($GLOBALS['global']['HOME_PAGE']['site_title'])
		->build('friends/birthdays');
	}
/***********************************************END FRIENDS*****************************************************/	
	
/*********************************************PET***************************************************************/	
	function pets(){
		$this->checkLogin();
		$this->template
		->title($GLOBALS['global']['HOME_PAGE']['site_title'])
		->build('pet/pet');
	}
	
	function mypets(){
		$this->checkLogin();
		$this->template
		->title($GLOBALS['global']['HOME_PAGE']['site_title'])
		->build('pet/list_mypets');
	}
	
	function pets_func(){
		$this->checkLogin();
		$task = $this->uri->segment(3,'');
		switch($task){
			case 'callFuncSearchPetsDefault':
				$this->load->view('user/pet/showpets');
				break;
			case 'callFuncResetSearch':
				$this->load->view('user/pet/filter');
				break;
			case 'callFuncReloadWishList':
				$this->load->view("user/leftsite/wishlist_async");
				break;
			case 'callFuncChangeSearchMode':
				$this->load->view('user/pet/filter2');
				break;
			case 'callFuncBackToSearchDefault':
				$this->load->view('user/pet/filter');
				break;
			case 'callFuncSearchPets2':
				$this->load->view('user/pet/showpets2');
				break;
			case 'callFuncAddThisPet':
				$this->load->view('user/ui_dialog/pet/buypet');
				break;
			case 'callFuncSubmitInfoBuyPet':
				$this->pet_m->buyPet();
				break;
			case 'callFuncReloadPetList':
				$this->load->view("user/leftsite/pets_list");
				break;
			case 'callFuncDialogShowLockPet':
				$this->load->view("user/ui_dialog/pet/lockpet");
				break;
			case 'submitLockPet':
				$this->lock_m->submitLockPet();
				break;
			case 'callFuncShowUIPostToWall':
				$this->load->view("user/ui_dialog/pet/callFuncShowUIPostToWall_buyPet");
				break;
			case 'callFuncShowUIPostToWall_lockpet':
				$this->load->view("user/ui_dialog/pet/callFuncShowUIPostToWall_lockpet");
				break;
		}	
	}
/*********************************************END PET************************************************************/		
	
/*********************************************USER PROFILE*******************************************************/		
	function user_profile(){
		//$this->checkLogin();
		$username = $this->uri->segment(1,'');
		$task = $this->uri->segment(2,'');
		$is_async = $this->input->get('is_async','');
		
		$userdataobj = $this->user_io_m->init('username',$username);
		if(!$userdataobj){
			show_404();
		}
		
		if($userdataobj->id_user == getAccountUserId()){
			redirect(site_url("user/my_profile"));
		}
		if(isLogin()){
			switch($task){
				default:
					$this->template
							->title($GLOBALS['global']['HOME_PAGE']['site_title'])
							->build('user_profile/index', array('userdataobj'=>$userdataobj));
					break;
				case 'friends':
					if(!$is_async){
						$this->template
							->title($GLOBALS['global']['HOME_PAGE']['site_title'])
							->build('user_profile/friends_page', array('userdataobj'=>$userdataobj));
					}else{
						$this->load->view("user_profile/friendlist_async", array('userdataobj'=>$userdataobj));
					}
					break;
				case 'pet_list':
					if(!$is_async){
						$this->template
							->title($GLOBALS['global']['HOME_PAGE']['site_title'])
							->build('user_profile/petlist_page', array('userdataobj'=>$userdataobj));
					}else{
						$this->load->view("user_profile/petlist_async", array('userdataobj'=>$userdataobj));
					}
					break;
				case 'userChatterAsync':
					$this->load->view('user_profile/user_chatter', array('userdataobj'=>$userdataobj));
					break;	
				case 'gift_list':
					if(!$is_async){
						$this->template
							->title($GLOBALS['global']['HOME_PAGE']['site_title'])
							->build('user_profile/gift_page', array('userdataobj'=>$userdataobj));
					}else{
						$this->load->view("user_profile/gift_async", array('userdataobj'=>$userdataobj));
					}
					break;
				case 'info':
					$this->template
							->title($GLOBALS['global']['HOME_PAGE']['site_title'])
							->build('user_profile/info_page', array('userdataobj'=>$userdataobj));
					break;	
				case 'photos':		
					$this->template
							->title($GLOBALS['global']['HOME_PAGE']['site_title'])
							->build('user_profile/photo/list_page', array('userdataobj'=>$userdataobj));
					break;
				case 'photo':		
					$this->template
							->title($GLOBALS['global']['HOME_PAGE']['site_title'])
							->build('user_profile/photo/photo_page', array('userdataobj'=>$userdataobj, 'id_photo'=>$this->uri->segment(3,0)));
					break;	
				case 'backstages':
					$this->template
							->title($GLOBALS['global']['HOME_PAGE']['site_title'])
							->build('user_profile/backstage/list_page', array('userdataobj'=>$userdataobj));
					break;
				case 'backstage_photo':
					$this->template
							->title($GLOBALS['global']['HOME_PAGE']['site_title'])
							->build('user_profile/backstage/backstage_page', array('userdataobj'=>$userdataobj, 'id_photo'=>$this->uri->segment(3,0)));
					break;	
				case 'reload_userInfo':
					$this->load->view('user_profile/user_info', array('userdataobj'=>$userdataobj));
					break;
			}
		}else{
			switch($task){
				default:
					$this->template
							->title($GLOBALS['global']['HOME_PAGE']['site_title'])
							->build('user_profile/visitor/index', array('userdataobj'=>$userdataobj));
					break;
				case 'friends':
					if(!$is_async){
						$this->template
							->title($GLOBALS['global']['HOME_PAGE']['site_title'])
							->build('user_profile/visitor/friends_page', array('userdataobj'=>$userdataobj));
					}else{
						$this->load->view("user_profile/visitor/friendlist_async", array('userdataobj'=>$userdataobj));
					}
					break;
				case 'pet_list':
					if(!$is_async){
						$this->template
							->title($GLOBALS['global']['HOME_PAGE']['site_title'])
							->build('user_profile/visitor/petlist_page', array('userdataobj'=>$userdataobj));
					}else{
						$this->load->view("user_profile/visitor/petlist_async", array('userdataobj'=>$userdataobj));
					}
					break;
				case 'userChatterAsync':
					$this->load->view('user_profile/visitor/user_chatter', array('userdataobj'=>$userdataobj));
					break;	
				case 'gift_list':
					if(!$is_async){
						$this->template
							->title($GLOBALS['global']['HOME_PAGE']['site_title'])
							->build('user_profile/visitor/gift_page', array('userdataobj'=>$userdataobj));
					}else{
						$this->load->view("user_profile/visitor/gift_async", array('userdataobj'=>$userdataobj));
					}
					break;
				case 'info':
					$this->template
							->title($GLOBALS['global']['HOME_PAGE']['site_title'])
							->build('user_profile/visitor/info_page', array('userdataobj'=>$userdataobj));
					break;	
				case 'photos':		
					$this->template
							->title($GLOBALS['global']['HOME_PAGE']['site_title'])
							->build('user_profile/visitor/photo/list_page', array('userdataobj'=>$userdataobj));
					break;
				case 'photo':		
					$this->template
							->title($GLOBALS['global']['HOME_PAGE']['site_title'])
							->build('user_profile/visitor/photo/photo_page', array('userdataobj'=>$userdataobj, 'id_photo'=>$this->uri->segment(3,0)));
					break;	
				case 'backstages':
					$this->template
							->title($GLOBALS['global']['HOME_PAGE']['site_title'])
							->build('user_profile/visitor/backstage/list_page', array('userdataobj'=>$userdataobj));
					break;
				case 'backstage_photo':
					$this->template
							->title($GLOBALS['global']['HOME_PAGE']['site_title'])
							->build('user_profile/visitor/backstage/backstage_page', array('userdataobj'=>$userdataobj, 'id_photo'=>$this->uri->segment(3,0)));
					break;	
				case 'reload_userInfo':
					$this->load->view('user_profile/visitor/user_info', array('userdataobj'=>$userdataobj));
					break;
			}
		}
	}
	
	function my_profile(){
		$this->checkLogin();
		$task = $this->uri->segment(3,'');
		$is_async = $this->input->get('is_async','');
		
		$userdataobj = $this->user_io_m->init('id_user',getAccountUserId());
		if(!$userdataobj){
			show_404();
		}
		
		switch($task){
			default:
				$this->template
						->title($GLOBALS['global']['HOME_PAGE']['site_title'])
						->build('my_profile/index', array('userdataobj'=>$userdataobj));
				break;
			case 'friends':
				if(!$is_async){
					$this->template
						->title($GLOBALS['global']['HOME_PAGE']['site_title'])
						->build('my_profile/friends_page', array('userdataobj'=>$userdataobj));
				}else{
					$this->load->view("my_profile/friendlist_async", array('userdataobj'=>$userdataobj));
				}
				break;
			case 'pet_list':
				if(!$is_async){
					$this->template
						->title($GLOBALS['global']['HOME_PAGE']['site_title'])
						->build('my_profile/petlist_page', array('userdataobj'=>$userdataobj));
				}else{
					$this->load->view("my_profile/petlist_async", array('userdataobj'=>$userdataobj));
				}
				break;
			case 'myChatterAsync':
				$this->load->view('my_profile/user_chatter', array('userdataobj'=>$userdataobj));
				break;
			case 'gift_list':
				if(!$is_async){
					$this->template
						->title($GLOBALS['global']['HOME_PAGE']['site_title'])
						->build('my_profile/gift_page', array('userdataobj'=>$userdataobj));
				}else{
					$this->load->view("my_profile/gift_async", array('userdataobj'=>$userdataobj));
				}
				break;
			case 'info':
				$this->template
						->title($GLOBALS['global']['HOME_PAGE']['site_title'])
						->build('my_profile/edit_info_page', array('userdataobj'=>$userdataobj));
				break;		
		}
	}
/*********************************************END USER PROFILE**************************************************/	

/*********************************************ACCOUNT SETTING***************************************************/

	function account(){
		$this->checkLogin();
		$task = $this->uri->segment(3,'');
		$is_async = $this->input->get('is_async','');
		
		switch($task){
			default:
				$this->template
					->title($GLOBALS['global']['HOME_PAGE']['site_title'])
					->build('account/index');
				break;	
			case 'loadContactInfo':	
			case 'loadDefaultContactInfo':
				$this->load->view("account/contact_info");
				break;
			case 'loadChangePasswordContext':
			case 'loadDefaultPasswordContext':
				$this->load->view("account/password_info");
				break;
			case 'loadDefaultEmailSettingContext':
				$this->load->view("account/email_info");
				break;
			
			case 'reloadRightBarAsync':	
				$this->load->view("partial/right");
				break;
            case 'active_new_email':
                $this->load->model('mod_io/mod_io_account_m');
                $status = $this->mod_io_account_m->active_new_email();
                $this->template
					->title($GLOBALS['global']['HOME_PAGE']['site_title'])
					->build('account/index',array('active_email'=>$status));
				break;  
                
            case 'trialpay_status':
                $this->template
					->title($GLOBALS['global']['HOME_PAGE']['site_title'])
					->build('account/trialpay_status');
				break;	 
              
		}	
	}

/*********************************************END ACCOUNT*******************************************************/

/********************************************COLLECTION*********************************************************/

	function collection(){
		$this->checkLogin();
		$task = $this->uri->segment(3,'');
		$is_async = $this->input->get('is_async','');
		
		switch($task){
			default:
				$this->template
					->title($GLOBALS['global']['HOME_PAGE']['site_title'])
					->build('collection/index');
				break;	
			case 'loadPhotoCollection':
				$this->load->view('collection/photo_collection');
				break;
			case 'loadMyPhoto':	
				$this->load->view('collection/my_photo');
				break;
			case 'callFuncLoadUploadMyPhoto':
				$this->load->view('ui_dialog/collection/uploadMyPhoto');
				break;
			case 'callFuncLoadActionMyPhoto':
				$this->load->view('ui_dialog/collection/actionMyPhoto');
				break;
			case 'callFuncReloadMyProfileSection':	
				$this->load->view('leftsite/user_info');
				break;
			case 'callFuncLoadWebcamUI':
				$this->load->view('ui_dialog/collection/callFuncShowWebcamSnapshot');
				break;
		}		
	}
/*******************************************END COLLECTION******************************************************/

/********************************************PHOTOS*************************************************************/
	
	function photos(){
		$this->checkLogin();
		$task = $this->uri->segment(3,'');
		$is_async = $this->input->get('is_async','');
		
		switch($task){
			default:
				if(!$is_async){
					$this->template
					->title($GLOBALS['global']['HOME_PAGE']['site_title'])
					->build('photos/index');
				}else{
					$id_photo = intval( $this->uri->segment(3,0) );
					$this->load->view("photos/show_photo", array('id_photo'=>$id_photo));
				}	
				break;	
			case 'backstage':
				if(!$is_async){
					$this->template
					->title($GLOBALS['global']['HOME_PAGE']['site_title'])
					->build('photos/backstage/index');
				}else{
					$id_photo = intval( $this->uri->segment(4,0) );
					$this->load->view("photos/backstage/show_photo", array('id_photo'=>$id_photo));
				}	
				break;
			case 'load_rating':
				$this->load->view("photos/show_rating", array('id_photo'=>$this->input->get('id_photo')));
				break;
			case 'load_rating_backstage':
				$this->load->view("photos/backstage/show_rating", array('id_photo'=>$this->input->get('id_photo')));
				break;	
		}		
	}

/******************************************BACKSTAGE*************************************************************/

	function backstage(){
		$this->checkLogin();
		$task = $this->uri->segment(3,'');
		$is_async = $this->input->get('is_async','');
		
		switch($task){
			default:
				if(!$is_async){
					$this->template
					->title($GLOBALS['global']['HOME_PAGE']['site_title'])
					->build('backstage/index');
				}else{
					$this->load->view('backstage/show_backstage');
				}	
				break;	
			case 'callFuncShowLatestBackstage':
			case 'callFuncShowMostViewBackstage':
			case 'callFuncShowRandomBackstage':
			case 'callFuncSearchBackstage':
				$this->load->view('backstage/show_backstage');
				break;
			case 'callFuncShowAllCommentBackstagePhoto':
				$this->load->view('ui_dialog/backstage/show_comments');
				break;
			case 'callFuncBuyThisBackstagePhoto':
				$this->load->view('ui_dialog/backstage/buy_backstage');
				break;
			case 'callFuncShowMyBackstage':
				$this->load->view('backstage/my_backstage');
				break;
			case 'callFuncLoadUploadMyBackstagePhoto':
				$this->load->view('ui_dialog/backstage/upload_my_backstage');
				break;
			case 'show_my_backstage':
				if(!$is_async){
					$id_photo = intval( $this->uri->segment(4,0) );
					redirect("user/photos/backstage/$id_photo");
				}else{
					$this->load->view('backstage/show_my_backstage');
				}
				break;
			case 'callFuncEditMyBackstagePhoto':	
				$this->load->view('ui_dialog/backstage/editMyBackstagePhoto');
				break;
			case 'callFuncLoadWebcamUI':
				$this->load->view('ui_dialog/backstage/callFuncShowWebcamSnapshot');
				break;
			case 'callFuncShowUIPostToWall':
				$this->load->view('ui_dialog/backstage/callFuncShowUIPostToWall');
				break;
            case 'callFuncShowAllUsersViewedBackstagePhoto':
                $this->load->view('ui_dialog/backstage/callFuncShowAllUsersViewedBackstagePhoto');
				break;
		}	
	}

/******************************************END BACKSTAGE*********************************************************/

/*****************************************GIFT BOX***************************************************************/

	function giftbox(){
		$this->checkLogin();
		$task = $this->uri->segment(3,'');
		$is_async = $this->input->get('is_async','');
		
		switch($task){
			default:
				$this->template
					->title($GLOBALS['global']['HOME_PAGE']['site_title'])
					->build('giftbox/index');
				break;	
			case 'gift_category':
				$this->load->view('giftbox/category_gifts');
				break;
			case 'callFuncLoadSendGift':
				$this->load->view('giftbox/send_gifts');
				break;
			case 'callFuncShowDialogSendGift':
				$this->load->view('ui_dialog/giftbox/callFuncShowDialogSendGift', array('to_id_user'=>$this->input->get('id_user')));
				break;
		}	
	}

/******************************************END GIFT BOX**********************************************************/	

/*********************************************FLIRTS*************************************************************/
	/** deprecated
	function flirts(){
		$task = $this->uri->segment(3,'');
		$is_async = $this->input->get('is_async','');
		
		switch($task){
			default:
				$this->template
					->title($GLOBALS['global']['HOME_PAGE']['site_title'])
					->build('flirts/index');
				break;	
			case 'callFuncShowFlirtsReceived':
				$this->load->view('flirts/flirt_receive');
				break;
			case 'flirtGivenContextLoader':
				$this->load->view('flirts/flirt_given');
				break;
			case 'loadSendFlirtUI':
				$this->load->view('ui_dialog/flirts/loadSendFlirtUI');
				break;
		}	
	}
	**/
	
	function map_flirts(){
		$this->checkLogin();
		$task = $this->uri->segment(3,'');
		$is_async = $this->input->get('is_async','');
		
		switch($task){
			default:
				$this->template
					->title($GLOBALS['global']['HOME_PAGE']['site_title'])
					->build('map_flirt/index');
				break;	
			case 'callFuncSearchMapFlirts':
				$this->load->view('map_flirt/show_search');
				break;
			case 'callFuncShowGoogleMapFlirts':
				$this->load->view('ui_dialog/map_flirts/callFuncShowGoogleMapFlirts');
				break;
			case 'callFuncShowMapFlirts':
				$this->load->view("map_flirt/map_flirts");
				break;
			case 'callFuncShowHistory':	
				$this->load->view("map_flirt/history");
				break;
			case 'callFuncShowExtendAccessMapDialog':
				$this->load->view('ui_dialog/map_flirts/callFuncShowExtendAccessMapDialog');
				break;
			case 'callFuncShowHistory_YOUBOUGHTOTHER':
				$this->load->view("map_flirt/history_you_bought_other");
				break;
			case 'callFuncShowHistory_OTHERBOUGHTYOU':
				$this->load->view("map_flirt/history_other_bought_you");
				break;
			case 'callFuncShowAccessMap_SELLER':
				$this->load->view('ui_dialog/map_flirts/callFuncShowAccessMap_SELLER');
				break;
		}		
	}
/*********************************************END FLIRTS*********************************************************/	
	
/*********************************************PEEPS**************************************************************/	

	function peeps(){
		$this->checkLogin();
		$task = $this->uri->segment(3,'');
		$is_async = $this->input->get('is_async','');
		$id_user = $this->input->get('id_user','');
		$id_user = ($id_user) ? $id_user:getAccountUserId();
		
		switch($task){
			default:
				$this->template
					->title($GLOBALS['global']['HOME_PAGE']['site_title'])
					->build('peeps/index', array('id_user'=>$id_user));
				break;	
			case 'show':
				$this->load->view('peeps/show',array('id_user'=>$id_user));
				break;
			case 'callFuncShowWhoRatedPicture':
				$this->load->view('ui_dialog/peeps/callFuncShowWhoRatedPicture');
				break;
		}	
	}

/*********************************************END PEEPS**********************************************************/	

/*********************************************BLOCK**************************************************************/	

	function block(){
		$this->checkLogin();
		$task = $this->uri->segment(3,'');
		$is_async = $this->input->get('is_async','');
		
		switch($task){
			default:
				$this->template
					->title($GLOBALS['global']['HOME_PAGE']['site_title'])
					->build('block/index');
				break;	
			case 'toggleBlockStatusMapAccess':
				$this->block_m->toggleBlockStatusMapAccess();
				break;
			case 'callFuncShowAccessMapBlock':
				$this->load->view( 'block/accessMapBlock' );
				break;
			case 'callFuncShowChatBlock':
				$this->load->view( 'block/chatBlock' );
				break;
			case 'callFuncDeleteChatBlock':		
				$this->block_m->deleteChatBlock();
				break;
		}	
	}

/*********************************************END BLOCK*********************************************************/

/*********************************************RANDOM MESSAGE****************************************************/
	function random_message(){
		$this->checkLogin();
		$task = $this->uri->segment(3,'');
		$is_async = $this->input->get('is_async','');
		
		switch($task){
			default:
				$this->template
					->title($GLOBALS['global']['HOME_PAGE']['site_title'])
					->build('random_message/index');
				break;	
			case 'showHistory':
				$this->load->view( 'random_message/show_history' );
				break;
			case 'callFuncReloadUI':
				$this->load->view( 'leftsite/user_secret' );
				break;
		}	
	}
/*********************************************END RANDOM MESSAGE************************************************/

/*********************************************HENTAI************************************************************/
	function hentai(){
		$this->checkLogin();
		$task = $this->uri->segment(3,'');
		$is_async = $this->input->get('is_async','');
		
		if($GLOBALS['global']['HENTAI']['show'] != 1){
			show_404();
		}
		switch($task){
			default:
				$this->template
					->title($GLOBALS['global']['HOME_PAGE']['site_title'])
					->build('hentai/index');
				break;	
			case 'category':
				$this->load->view( 'hentai/show_categories' );
				break;
			case 'series':	
				$id_series = $this->uri->segment(4,0);
				$seriesdata = $this->mod_io_m->init('id_series',$id_series,TBL_SERIES);
				if(!$seriesdata){
					show_404();
					exit;
				}
				$this->template
					->title($seriesdata->name)
					->build('hentai/series');
				break;	
			case 'show_video_episode':
				$this->load->view( 'hentai/video_episode' );
				break;
			case 'video':
				$id_video = $this->uri->segment(4,0);
				$videodata = $this->mod_io_m->init('id_video',$id_video,TBL_VIDEO);
                //$id_video = $this->uri->segment(4,0);
                //$code_video = strtolower( str_replace(array('-','_'),array('',''),$this->uri->segment(5)) ); 
            	//$videodata = ( $this->mod_io_m->init('id_video',$id_video,TBL_VIDEO) ) ? $this->mod_io_m->init('id_video',$id_video,TBL_VIDEO) : $this->mod_io_m->init('code_video',$code_video,TBL_VIDEO) ;
            	
				if(!$videodata){
					show_404();
					exit;
				}
				$this->template
					->title($videodata->name)
					->build('hentai/video');
				break;
			case 'show_watching_video':	
				$this->load->view("hentai/show_user_watching_video", array('video_id'=>$this->input->get('id_video')));
				break; 
			case 'downloadVideoUIDialog':
				$this->load->view( "ui_dialog/hentai/downloadVideoUIDialog" );
				break; 
			case 'callFuncRateHentaiVideo':
				$id_video = $this->uri->segment(4,0);
				$this->load->view("hentai/show_rating_video", array('id_video'=>$id_video));
				break;
		}	
	}
	
	function videos(){
		$this->checkLogin();
		$task = $this->uri->segment(3,'');
		$is_async = $this->input->get('is_async','');
		
		if($GLOBALS['global']['HENTAI']['show'] != 1){
			show_404();
		}
		switch($task){
			default:
				$this->template
					->title($GLOBALS['global']['HOME_PAGE']['site_title'])
					->build('hentai/index');
				break;	
			case 'category':
				$this->load->view( 'hentai/show_categories' );
				break;
			case 'series':	
				$id_series = $this->uri->segment(4,0);
				$seriesdata = $this->mod_io_m->init('id_series',$id_series,TBL_SERIES);
				if(!$seriesdata){
					show_404();
					exit;
				}
				$this->template
					->title($seriesdata->name)
					->build('hentai/series');
				break;	
			case 'show_video_episode':
				$this->load->view( 'hentai/video_episode' );
				break;
			case 'video':
				$id_video = $this->uri->segment(4,0);
				$videodata = $this->mod_io_m->init('id_video',$id_video,TBL_VIDEO);
                //$id_video = $this->uri->segment(4,0);
                //$code_video = strtolower( str_replace(array('-','_'),array('',''),$this->uri->segment(5)) ); 
            	//$videodata = ( $this->mod_io_m->init('id_video',$id_video,TBL_VIDEO) ) ? $this->mod_io_m->init('id_video',$id_video,TBL_VIDEO) : $this->mod_io_m->init('code_video',$code_video,TBL_VIDEO) ;
            	
				if(!$videodata){
					show_404();
					exit;
				}
				$this->template
					->title($videodata->name)
					->build('hentai/video');
				break;
			case 'show_watching_video':	
				$this->load->view("hentai/show_user_watching_video", array('video_id'=>$this->input->get('id_video')));
				break; 
			case 'downloadVideoUIDialog':
				$this->load->view( "ui_dialog/hentai/downloadVideoUIDialog" );
				break; 
			case 'callFuncRateHentaiVideo':
				$id_video = $this->uri->segment(4,0);
				$this->load->view("hentai/show_rating_video", array('id_video'=>$id_video));
				break;
		}	
	}
	
/*********************************************END HENTAI********************************************************/	
	
/*********************************************PEEPED ACCESS*****************************************************/
	
	function peeped_access(){
		$this->checkLogin();
		$task = $this->uri->segment(3,'');
		
		switch($task){
			case 'callFuncBuyPeepAccess':
				$this->load->view( "ui_dialog/peeped_access/callFuncBuyPeepAccess" );
				break;
			case 'callFuncShowPeepedAccess':
				$this->load->view( "ui_dialog/peeped_access/callFuncShowPeepedAccess" );
				break;
		}		
	}
/*********************************************END PEEPED ACCESS*************************************************/	
	
/*********************************************CONNECT***********************************************************/	
	
	function connect(){
		$this->checkLogin();
		$task = $this->uri->segment(3,'');
		$is_async = $this->input->get('is_async','');
		
		switch($task){
			default:
				$this->template
					->title($GLOBALS['global']['HOME_PAGE']['site_title'])
					->build('connect/index');
				break;	
		}
	}	
/********************************************END CONNECT********************************************************/				
	
/*********************************************FAVOURITE*********************************************************/	
	
	function favourite(){
		$this->checkLogin();
		$task = $this->uri->segment(3,'');
		$is_async = $this->input->get('is_async','');
		
		switch($task){
			default:
				$this->template
					->title($GLOBALS['global']['HOME_PAGE']['site_title'])
					->build('favourite/index');
				break;	
		}
	}	
/********************************************END FAVOURITE*****************************************************/				
		
/*********************************************SEARCH***********************************************************/	
	function search(){
		$this->checkLogin();
		$this->template
				->title($GLOBALS['global']['HOME_PAGE']['site_title'])
				->build('search/index');
	}
/*********************************************END SEARCH*******************************************************/	
	
	function gotoid(){
		$id = $this->uri->segment(3,'');
		$task = $this->uri->segment(4,'');
		$userdata = $this->user_io_m->init('id_user',$id);
		if($userdata){
			redirect(site_url()."{$userdata->username}/$task");
		}
		show_404();
	}


	//end class
}