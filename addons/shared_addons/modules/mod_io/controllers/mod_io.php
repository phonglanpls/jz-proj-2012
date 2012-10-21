<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
/**
* 
* @author DANG DINH HUNG
*
*/
class Mod_io extends Public_Controller
{
	
	public function __construct()
	{
		parent::__construct();
		$this->load->model('mod_io_m'); 
		$this->load->model('mod_io_wall_m'); 
		$this->load->model('mod_io_qa_m'); 
		$this->load->model('crontab_io_m');
		$this->load->model('mod_io_friend_m');
		$this->load->model('mod_io_account_m');
		$this->load->model('collection_io_m');
		$this->load->model('backstage_io_m');
		$this->load->model('gift_io_m');
		//$this->load->model('flirts_io_m');
		$this->load->model('map_flirts_io_m');
		$this->load->model('random_message_io_m');
		$this->load->model('hentai_io_m');
		$this->load->model('xls_io_m');
		$this->load->model('peeped_access_io_m');
		$this->load->model('favourite_io_m');
        $this->load->model( 'user/trialpay_m' );
        //$this->load->model('jsonservices_io_m');
	}
	
	public function index()
	{		
		//$this->xls_io_m->toDb();
		//echo $this->xls_io_m->getThumbnail("http://www.dailymotion.com/video/k6q9itltth8qUU17qoM");
		//$this->xls_io_m->delete();
        //$this->xls_io_m->toDbFB();
	}
	
	function crontab(){
		$task = $this->uri->segment(3,'');
        //debug("CRONTAB:--$task",'crontab.txt');
		switch($task){
			case 'updatelockpet':
				$this->crontab_io_m->_cron_unlockpet();// 5mins/circle
				break;
			case 'birthday':
				$this->crontab_io_m->_cron_birthday(); // 1 day/circle
				break;
            case 'sendOfflineChat':
               $this->crontab_io_m->_sendOfflineChat(); // 15 seconds js
				break;    
            case 'resize_photo':
               $this->crontab_io_m->_resizePhoto(); // 15 seconds js
				break;       
		}
		exit;
	}
    /**
    function jsonservices(){
        $task = $this->uri->segment(3,'');
        switch($task){
			case 'user_status':
				$this->jsonservices_io_m->_user_status(); 
				break;
            case 'sendemail':
                $this->jsonservices_io_m->_sendemail(); 
				break;    
		}
		exit;
    }
    **/
	
	function wall_submit_async(){
		$task = $this->uri->segment(3,'');
		$this->load->model(array('user/wall_m','user/user_m'));
		
		switch($task){
			case 'submit_change_filter_options':
				$this->mod_io_wall_m->changeFilterOptions();
				break;
			case 'submitCommentWall':
				$id_wall = $this->input->get('id_wall',0);
				$comment = $this->input->get('comment','');
				$contextcmt	 = $this->input->get('contextcmt');
				
				$this->mod_io_wall_m->submitCommentWall($id_wall,$comment);
				echo $this->load->view('user/wall/feed_comment', array('contextcm'=>$contextcmt, 'id_wall'=>$id_wall), true );
				break;
			case 'submitShareStatus':
				$this->mod_io_wall_m->submitShareStatus();
				break;
			case 'submit_upload_photo':
				$this->mod_io_wall_m->submitPhotoUpload();
				break;
			case 'submitShareStatusSnapshotWC':
				$this->mod_io_wall_m->submitShareStatusSnapshotWC();
				break;
		}
		exit;
	}
	
	function wall_async(){
		$task = $this->uri->segment(3,'');
		$this->load->model(array('user/wall_m','user/user_m'));
		
		switch($task){
			case 'changeStateAsync':
				echo $this->mod_io_wall_m->changeStateAsync($this->input->get('id_country',0));
				break;
			case 'changeCityAsync':	
				echo $this->mod_io_wall_m->changeCityAsync($this->input->get('id_country',0), $this->input->get('id_state',0));
				break;
			case 'toggleLikeContext':	
				$this->mod_io_wall_m->toggleLikeContext();
				break;
			case 'deleteComment':
				$this->mod_io_wall_m->deleteComment();
				break;
			case 'deleteFeedWall':
				$this->mod_io_wall_m->deleteFeedWall();
				break;
		}
		exit;
	}
	
	function qa_submit_async(){
		$task = $this->uri->segment(3,'');
		$this->load->model('user/qa_m');
		switch($task){
			case 'submit_a_question':
				echo $this->mod_io_qa_m->submitAQuestion();
				break;
			case 'submit_answer_question':
				echo $this->mod_io_qa_m->submitAnswerQuestion();
				break;
			case 'deleteQuestion':
				$this->mod_io_qa_m->deleteQuestion();
				break;
		}		
	}
	
	function pet_submit_async(){
		$task = $this->uri->segment(3,'');
		$this->load->model('user/pet_m');
		$this->load->model('user/wishlist_m');
		 
		switch($task){
			case 'callFuncAddToWishListThisPet':
				$this->wishlist_m->addToWishList();
				break;
			case 'callFuncRemoveFromWishList':
				$this->wishlist_m->removeFromWishList();
				break;	
			case 'postOnWall':
				$this->pet_m->postOnWall();
				break;
		}
	}
	
	function friend_async(){
		$task = $this->uri->segment(3,'');	
		switch($task){
			case 'callFuncAddFriend':
				$this->mod_io_friend_m->addFriend();
				break;
			case 'callFuncAcceptFriendRequest':
				$this->mod_io_friend_m->acceptFriend();
				break;
			case 'callFuncRejectFriendRequest':	
				$this->mod_io_friend_m->rejectFriend();
				break;
			case 'callFuncBlockFriend':
				$this->mod_io_friend_m->blockFriend();
				break;
			case 'callFuncInviteFriends':	
				$this->mod_io_friend_m->inviteFriend();
				break;
			case 'submit_report_abuse':	
				$this->load->model('user/report_abuse_m');
				$this->report_abuse_m->submitReportAbuse();
				break;
			case 'submit_invite_facebook_friend':	
				$this->mod_io_friend_m->inviteFacebookFriend();
				break;
			case 'callFuncUnfriend':
				$this->mod_io_friend_m->unFriend();
				break;
			case 'submit_invite_twitter_friend':
				$this->mod_io_friend_m->inviteTwitterFriend();
				break;
		}
	}
	
	function account_func(){
		$task = $this->uri->segment(3,'');	
		switch($task){
			case 'submit_edit_account_info':
				$this->mod_io_account_m->editAccountInfo();
				break;
			case 'submit_change_password_info':
				$this->mod_io_account_m->changePassword();
				break;
			case 'submit_change_email_setting':
				$this->mod_io_account_m->changeEmailSeting();
				break;
			case 'submit_change_basic_info':
				$this->mod_io_account_m->changeBasicInfo();
				break;
			case 'submitChangePeepValue':
				$this->mod_io_account_m->changePeepValue();
				break;
            case 'submit_change_timeline_option':
                 $this->mod_io_account_m->changeTimelineOption();
				break;   
		}		
	}
	
	function collection_func(){
		$task = $this->uri->segment(3,'');	
		switch($task){
			case 'submit_my_photo':
				$this->collection_io_m->uploadMyPhoto();
				break;
			case 'edit_my_photo':
				$this->collection_io_m->editMyPhoto();
				break;
			case 'callFuncSubmitSnapshotWebcam':
				$this->collection_io_m->submitSnapshotWebcam();
				break;
		}		
	}
	
	function photos_func(){
		$task = $this->uri->segment(3,'');	
		$this->load->model( 'user/photos_m' );
		switch($task){
			case 'submitCommentPhoto':
				$id_photo = $this->input->get('id_photo');
				$this->photos_m->updateComment();
				$this->load->view('user/photos/show_comments',array('id_photo'=>$id_photo));
				break;
			case 'deleteComment':
				$this->photos_m->deleteComment();
				break;
		}		
	}
	
	function backstage_func(){
		$task = $this->uri->segment(3,'');	
		$this->load->model( 'user/backstage_m' );
		switch($task){
			case 'submitBuyBackstagePhoto':
				$this->backstage_m->buyBackstagePhoto();
				break;
			case 'submit_my_photo':
				$this->backstage_io_m->uploadMyPhoto();
				break;
			case 'submit_edit_my_photo':
				$this->backstage_io_m->editBackstagePhoto();
				break;
			case 'callFuncSubmitSnapshotWebcam':
				$this->backstage_io_m->submitSnapshotWebcam();
				break;
			case 'postOnWall':
				$this->backstage_io_m->postOnWall();
				break;
		}		
	}
	
	function giftbox_func(){
		$task = $this->uri->segment(3,'');	
		switch($task){
			case 'sendgift':
				$this->gift_io_m->sendgift();
				break;
			case 'sendgiftToUser':
				$this->gift_io_m->sendgiftToUser();
				break;
		}	
	}
	
	/*
	deprecated
	function flirts_func(){
		$task = $this->uri->segment(3,'');	
		switch($task){
			case 'deleteFlirt':
				$this->flirts_io_m->deleteFlirt();
				break;
		}	
	}
	*/
	function map_flirts_func(){
		$task = $this->uri->segment(3,'');	
		switch($task){
			case 'submitChangeMapValue':
				$this->map_flirts_io_m->submitChangeMapValue();
				break;
			case 'submitAccessMapFlirts':
				$this->map_flirts_io_m->submitAccessMapFlirts();
				break;
			case 'submitExtendAccessMapFlirts':
				$this->map_flirts_io_m->submitExtendAccessMapFlirts();
				break;
		}	
	}
	
	function random_message_func(){
		$task = $this->uri->segment(3,'');	
		switch($task){
			case 'sendMessage':
				$this->random_message_io_m->sendMessage();
				break;
		}		
	}
	
	function hentai_func(){
		$task = $this->uri->segment(3,'');	
		switch($task){
			case 'download_video':
				$this->hentai_io_m->downloadVideo();
				break;
		}	
	}
	
	function peeped_access_func(){
		$task = $this->uri->segment(3,'');	
		switch($task){
			case 'submitBuyPeepedAccess':
				$this->peeped_access_io_m->submitBuyPeepedAccess();
				break;
		}		
	}
	
	function favourite_func(){
		$task = $this->uri->segment(3,'');	
		switch($task){
			case 'addUserToMyFvList':
				$this->favourite_io_m->addUserToMyFvList();
				break;
			case 'deleteItem':
				$this->favourite_io_m->deleteItem();
				break;
			case 'callFuncBuyFavouriteAccessPackage':
				$this->favourite_io_m->buyFavouriteAccessPackage();
				break;
		}	
	}
    
    /*****************************************TRIAL PAY*************************************************************/
	function trialpay(){
	   $this->trialpay_m->process();
	}
    
    function end_trialpay(){
        $this->trialpay_m->end_process_trialpay();
    }
/*****************************************END TRIAL PAY*********************************************************/	
	
	function twitter_connection(){
		$oauth_token = $_GET['oauth_token'];
		$oauth_verifier = $_GET['oauth_verifier'];
		//debug($oauth_token, $oauth_verifier);
		//debug(fullURL());
		
		$this->twittermodel->setCurrentConnection( $oauth_token, $oauth_verifier);
		if(isLogin()){
			redirect("user/connect");
		}else{
			redirect("member/twitter_register");
		}
	}
	
	function disconnect(){
		$task = $this->uri->segment(3,'');	
		$uri = urldecode( $this->input->get('uri') );
		switch($task){
			case 'facebook':
				//$this->db->where('userid',getAccountUserId())->update(TBL_FACEBOOK_CONNECT, array('access_token'=>null));
                $this->db->where('userid',getAccountUserId())->delete(TBL_FACEBOOK_CONNECT);
				$this->facebookmodel->logout();
				if($uri){
					redirect($uri);
				}
				break;
			case 'twitter':
				//$this->db->where('userid',getAccountUserId())->update(TBL_TWITTER_CONNECT, array('session_data'=>null));
                $this->db->where('userid',getAccountUserId())->update(TBL_TWITTER_CONNECT);
				unset($_SESSION['twitterconnection']);
				if($uri){
					redirect($uri);
				}
				break;
		}	
	}
	
	function jsdetect(){
		$facebookconnected = $twitterconnected = 0;
		if(isFacebookLogin()){
			$facebookconnected = 1;
		}
		if(isTwitterLogin()){
			$twitterconnected = 1;
		}
		
		header("content-type:application/x-javascript");
		
		echo "var SYS_JS_SOCIAL = {};";
		echo "SYS_JS_SOCIAL.facebook = $facebookconnected;";
		echo "SYS_JS_SOCIAL.twitter = $twitterconnected;";
        echo "var USER_ID = ".getAccountUserId().";";
	}
	
	
	//end class
}