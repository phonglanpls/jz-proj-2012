<?php defined('BASEPATH') or exit('No direct script access allowed');

class Mod_io_account_m extends MY_Model {
	function __construct(){
		parent::__construct();
	}
	
	function editAccountInfo(){
		$userdataobj = getAccountUserDataObject(true);
		 
		if(!$this->phpvalidator->is_email($this->input->post('email'))){
			echo json_encode(
				array(
					'result' => 'ERROR',
					'message' => 'Email is not valid format'
				)
			);	
			exit;
		}
        
       	if(! checkRealEmail($this->input->post('email'))){
			echo json_encode(
				array(
					'result' => 'ERROR',
					'message' => 'Email is not real'
				)
			);	
			exit;
		}
        
		$usercheckobj = $this->user_io_m->init('email',$this->input->post('email'));
		
		if($usercheckobj AND $userdataobj->id_user != $usercheckobj->id_user){
			echo json_encode(
				array(
					'result' => 'ERROR',
					'message' => 'Email is used by other account.'
				)
			);	
			exit;
		}
        
		$new_email =  $this->input->post('email');
        
		$country_id = $this->input->post('country_id',0);
		$state_id = $this->input->post('state_id',0);
		$city_id = $this->input->post('city_id',0);
		
		if($country_id>0){
			$update['id_country'] = $country_id;
			$update['country'] = getValueOfArray(countryOptionData_ioc($country_id));
			
			if($state_id>0){
				$update['id_state'] = $state_id;
				$update['state'] = getValueOfArray(stateOptionData_ioc($country_id,$state_id));
				
				if($city_id>0){
					$update['id_city'] = $city_id;
					$update['city'] = getValueOfArray(cityOptionData_ioc($country_id,$state_id,$city_id));
					
					$geo = $this->geo_lib->getCoordinatesFromAddress($update['city']);
					$update['longitude'] = $geo['longitude'];
					$update['latitude'] = $geo['latitude'];
				}else{
					$update['id_city'] = 0;
					$update['city'] = null;
					
					$geo = $this->geo_lib->getCoordinatesFromAddress($update['state']);
					$update['longitude'] = $geo['longitude'];
					$update['latitude'] = $geo['latitude'];
				}
			}else{
				$update['id_state'] = 0;
				$update['state'] = null;
				$update['id_city'] = 0;
				$update['city'] = null;
				
				$geo = $this->geo_lib->getCoordinatesFromAddress($update['country']);
				$update['longitude'] = $geo['longitude'];
				$update['latitude'] = $geo['latitude'];
			}
		}/*
		else{
			$update['id_country'] = 0;
			$update['country'] = null;
			$update['id_state'] = 0;
			$update['state'] = null;
			$update['id_city'] = 0;
			$update['city'] = null;
			$update['longitude'] = null;
			$update['latitude'] = null;
		}*/
		
		$update['first_name'] = $this->input->post('first_name');
		$update['last_name'] = $this->input->post('last_name');
		//$update['email'] = $this->input->post('email');
		$update['cell_no'] = $this->input->post('cell_no');
		$update['address'] = $this->input->post('address');
		$update['postal_code'] = $this->input->post('postal_code');
		$update['timezone'] = $this->input->post('timezone');
		$update['dob'] = dbDay($this->input->post('birthday'));
		
		$this->user_io_m->update_map($update,$userdataobj->id_user);
        
        if($new_email != $userdataobj->email){
            $checkemail = "<br/>You have changed email account, please go to your email inbox and click on the link to active new email.";
            $this->email_sender->juzonSendEmail_JUZ_ACCOUNT_CHANGED_EMAIL($userdataobj->id_user, $new_email);
        }else{
            $checkemail = '';
        }
        
		echo json_encode(
				array(
					'result' => 'ok',
					'message' => 'Update successfully.'.$checkemail
				)
			);	
		exit;
	}	
	
	function changePassword(){
		$userdataobj = getAccountUserDataObject(true);
		
		$old_passwd = $this->input->post('old_passwd');
		$new_passwd = $this->input->post('new_passwd');
		$new_passwd2 = $this->input->post('new_passwd2');
		
		if(md5($old_passwd) != $userdataobj->password){
			echo json_encode(
				array(
					'result' => 'ERROR',
					'message' => 'Old password is not correct.'
				)
			);	
			exit;
		}
		
		if(strlen($new_passwd) <6){
			echo json_encode(
				array(
					'result' => 'ERROR',
					'message' => 'New password must be greater than 6 characters.'
				)
			);	
			exit;	
		}
		
		if($new_passwd != $new_passwd2){
			echo json_encode(
				array(
					'result' => 'ERROR',
					'message' => 'New password not match.'
				)
			);	
			exit;	
		}
		
		$update['password'] = md5($new_passwd);
		$this->user_io_m->update_map($update,$userdataobj->id_user);
		echo json_encode(
				array(
					'result' => 'ok',
					'message' => 'Update successfully.'
				)
			);	
			exit;		
	}
	
	function changeEmailSeting(){
		$userdataobj = getAccountUserDataObject(true);
		$emailSetting = $this->email_setting_io_m->init($userdataobj->id_user);
	
		foreach($_POST as $k=>$v){
			$update[$k] = $v;
		}
		unset($update['submit']);
		
		$this->mod_io_m->update_map($update, array('id'=>$emailSetting->id),TBL_EMAILSETTING);
		
		echo json_encode(
				array(
					'result' => 'ok',
					'message' => 'Update successfully.'
				)
			);	
			exit;		
	}
	
	function increaseNumberChecked($id_user){
		$res = $this->db->where('id_user',$id_user)->where('id_visitor',getAccountUserId())->get(TBL_CHECKED)->result();	
		if($res){
			$update['num_count'] = $res[0]->num_count + 1;
			$update['last_visit'] = mysqlDate();
			$this->mod_io_m->update_map($update, array('id_checked'=>$res[0]->id_checked), TBL_CHECKED);
		}else{
			$data['id_user'] = $id_user;
			$data['id_visitor'] = getAccountUserId();
			$data['num_count'] = 1;
			$data['last_visit'] = mysqlDate();
			$this->mod_io_m->insert_map($data, TBL_CHECKED); 	 	
		}	
	}
	
	function changeBasicInfo(){
		$fav['language']= rtrim( $this->input->post('languages'), ', ' );
		$fav['interested_in'] = $this->input->post('interested_in');
		$fav['music'] = $this->input->post('music');
		$fav['book'] = $this->input->post('book');
		$fav['tvshow'] = $this->input->post('tvshow');
		$fav['videogame'] = $this->input->post('videogame');
		$fav['activity'] = $this->input->post('activity');
		$fav['interests'] = $this->input->post('interests');
		$fav['id_user']	= getAccountUserId();
		
		$user['about_me']	= $this->input->post('about_me');
		$user['gender']	=	$this->input->post('gender');
		$user['rel_status'] = $this->input->post('relationship');
		
		$this->user_io_m->update_map($user,getAccountUserId());
		
		$userfavoritedata = $this->mod_io_m->init('id_user',getAccountUserId(),TBL_FAVORITE);
		
		if($userfavoritedata){
			$this->mod_io_m->update_map($fav,array('id_favorite'=>$userfavoritedata->id_favorite),TBL_FAVORITE);
		}else{
			$this->mod_io_m->insert_map($fav,TBL_FAVORITE);
		}
		echo 'ok';
		exit;
	}
	
	function changePeepValue(){
		$peepvalue = $this->input->post('peepvalue');
		$user['peep_access'] = $peepvalue;
		
		$this->user_io_m->update_map($user,getAccountUserId());
		exit;
	}
	
	function active_new_email(){
	   $new_email = $this->input->get('new_email');
       $sc = $this->input->get('sc');
       
       $userdataobj = getAccountUserDataObject(true);
		if(md5($new_email.$userdataobj->id_user.'-salt') != $sc){
		    return json_encode(
				array(
					'result' => 'ERROR',
					'message' => 'Email is not correct'
				)
			);	
			exit;
		} 
        
		if(!$this->phpvalidator->is_email($new_email)){
			return json_encode(
				array(
					'result' => 'ERROR',
					'message' => 'Email is not valid format'
				)
			);	
			exit;
		}
        
       	if(! checkRealEmail($new_email)){
			return json_encode(
				array(
					'result' => 'ERROR',
					'message' => 'Email is not real'
				)
			);	
			exit;
		}
        
		$usercheckobj = $this->user_io_m->init('email',$new_email);
		
		if($usercheckobj AND $userdataobj->id_user != $usercheckobj->id_user){
			return json_encode(
				array(
					'result' => 'ERROR',
					'message' => 'Email is used by other account.'
				)
			);	
			exit;
		}
        
		$update['email'] = $new_email;
        $this->user_io_m->update_map($update,$userdataobj->id_user);
        return json_encode(
				array(
					'result' => 'ok',
					'message' => 'Activated new email successfully.'
				)
			);	
		exit;
	}
	
    function changeTimelineOption(){
        //print_r($_POST);
        $array = array( 'fb_status_update','tt_status_update', 
                        'fb_askme_answer','tt_askme_answer',
                        'fb_backstage_photo', 'tt_backstage_photo',
                        'fb_buy_pet','tt_buy_pet',
                        'fb_lock_pet','tt_lock_pet',
                        'fb_rate_video','tt_rate_video'
                    );
         $update = array();           
         foreach($array as $key){
            $update[$key] = intval($this->input->post($key));
         }           
         $this->mod_io_m->update_map($update,array('id_user'=>getAccountUserId()),TBL_TIMELINE_OPTION);
         echo json_encode(
				array(
					'result' => 'ok',
					'message' => 'Update successfully.'
				)
			);	
		exit;
    }
    
    
    
    
    
//endclass
}	