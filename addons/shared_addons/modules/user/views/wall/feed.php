<?php if (!defined('BASEPATH')) exit('No direct script access allowed'); ?>

<?php 
	if(!isset($cat)){
		$cat = $this->uri->segment(3,'');
	}
	
	if($this->input->get('task','') == 'qedit'){
		$data['gender'] = $this->input->get('gender','');
		$data['age_from'] = $this->input->get('age_from','');
		$data['age_to'] = $this->input->get('age_to','');
		$data['country'] = $this->input->get('country','');
		$this->load->model('mod_io/mod_io_wall_m');
		$this->mod_io_wall_m->quickEditUserFilter($data);
	}
	
	$id_user = getAccountUserId();	
	$userdataobj = $result = getAccountUserDataObject(true);
	
	$friend_ids = $city = $limit = $my_chat = $country = null;
	
	if($this->input->get('per_page') != ''){
		$limit = intval($this->input->get('per_page'))*15;
	}
	//$cat == '' OR $cat == 'friends' OR !in_array($cat, array('near_me', 'friends', 'everyone', 'my_chatter'))
	if($cat == 'friends'){
		$cond = "(id_user=".$id_user." AND request_type=0) OR (friend=".$id_user." AND request_type=0)";
		$friends = $this->db->query("SELECT * FROM ".TBL_FRIENDLIST." WHERE $cond")->result();
		$friend_ids = array();
		
		if($friends){
			foreach($friends as $k=>$v){
				if($v->friend== $id_user)
					$friend_ids[]=$v->id_user;
				else
					$friend_ids[]=$v->friend;
			}
			$friend_ids=implode(',',$friend_ids);
		}else {
			$friend_ids="No friends";
		}
	}else if($cat == 'near_me'){
		$my_city = $userdataobj->city;
		$city = $my_city?$my_city:"No city";
		
		if($city=='No city') {
			$country = $userdataobj->country;
		}else{
			$country ='';
		}
	}else if($cat == 'my_chatter' ){
		$my_chat = $id_user;
	}
	
	$sql_post = $this->wall_m->get_all_post($result,$friend_ids,$city,$limit,$my_chat,$country);
	$res = $this->db->query($sql_post)->result();
	
	$this->load->view( 'user/wall/feed_content', array('res'=>$res) );
?>
