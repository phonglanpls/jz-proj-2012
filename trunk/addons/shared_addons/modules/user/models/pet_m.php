<?php defined('BASEPATH') or exit('No direct script access allowed');

class Pet_m extends MY_Model {
	function __construct(){
		parent::__construct();
	}
	
	function pet_list($user_id,$offset=0,$records_p_page=0){
		$sql="SELECT p.*,u.cur_value,u.username,u.id_user,u.photo,u.gender,u.cash,u.first_name,u.last_name ,u1.first_name as ownfname,u1.last_name as ownlname,u1.id_user as  ownid FROM 
				".TBL_USER." u left join ".TBL_USER." u1 on (u.owner=u1.id_user) ,".
				TBL_PET." p  WHERE u.id_user=p.id_user AND p.id_owner=".$user_id.
				" AND u.status=0 ORDER BY p.id_pet DESC";
		if($records_p_page){
			$sql .= " LIMIT ".$offset.",".$records_p_page."";
		}		
		return $this->db->query($sql)->result();
	}
	
	function isMyPet($id_user){
		$res = $this->db->where('id_owner',getAccountUserId())->where('id_user',$id_user)->get(TBL_PET)->result();
		return $res?true:false;	
	}
	
	function isMyOwner($id_user){
		$res = $this->db->where('id_owner',$id_user)->where('id_user',getAccountUserId())->get(TBL_PET)->result();
		return $res?true:false;	
	}
	
	function saveSearchInfo($arr){
		$mypetsearch = $this->db->where('id_user', getAccountUserId())->get(TBL_PETSEARCH)->result();
		
		$arr['id_user'] =  getAccountUserId();
		$arr['add_date'] = mysqlDate();
		$arr['ip'] = $this->geo_lib->getIpAddress();
		
		if($mypetsearch){
			$this->mod_io_m->update_map($arr, array('id_pet_search'=>$mypetsearch[0]->id_pet_search), TBL_PETSEARCH);
		}else{
			$this->mod_io_m->insert_map($arr, TBL_PETSEARCH);
		}
	}
	
	function defaultSearch($offset=0,$records_p_page=0){
		$mypetsearch = $this->db->where('id_user', getAccountUserId())->get(TBL_PETSEARCH)->result();
		$userdataobj = getAccountUserDataObject();
		
		$cond=" WHERE u.id_admin=0 AND u.id_user!=".getAccountUserId().
				" AND u.id_user!=(SELECT owner FROM ".TBL_USER.
				" WHERE id_user=".getAccountUserId().") AND u.id_user NOT IN(SELECT id_user FROM ".TBL_PET.
				" WHERE id_owner=".getAccountUserId().") AND u.random_num='0' AND u.status=0";
				
		if($gender = $mypetsearch[0]->gen){
			if( strtolower($gender) == 'both'){
				$cond .=" AND (u.gender='Male' OR u.gender='Female') ";
			}else{
				$cond .=" AND u.gender ='".$gender."' ";
			}
		}
		
		if($price = $mypetsearch[0]->pric ){
			if($price == 'allprices'){
				$cond .=" AND u.cash > 0 ";
			}else{
			    $x = $GLOBALS['global']['PET_VALUE']['pet_percentage']/100;
                //$y = $userdataobj->cur_value;
		        //$price = $x*$y + $y; 
                
				$cond .=" AND ($x*u.cur_value+u.cur_value) <= ".$GLOBALS['global']['AFFORDABLE']['min_price'];
			}
		}
		//Enhancement work for pet refine search dt:-30-05-11
		
		if($country_name = $mypetsearch[0]->country_name){
		    $cond .= " AND u.country='".$country_name."'";
		}
		
		if($agefrom = $mypetsearch[0]->agefrom){
		    $cond1 = " (f.cur_age BETWEEN ".$agefrom." AND ".$mypetsearch[0]->ageto.")";
		}
		
		if($distance = $mypetsearch[0]->distance){
		    $lat 	= 	$this->geo_lib->change_in_latitude($distance);
		    $long 	=	$this->geo_lib->change_in_longitude($_SESSION['lat'], $distance);
		    $latitude1 	= $userdataobj->lat + $lat;
		    $latitude2 	= $userdataobj->lat - $lat;
		    $longitude1 = $userdataobj->long + $long;
		    $longitude2 = $userdataobj->long - $long;
		    $cond .=	" AND u.latitude BETWEEN ".$latitude2." AND ".$latitude1.
						" AND u.longitude BETWEEN ".$longitude2." AND ".$longitude1;
		}
		
		/*
		if($mapvalue = $mypetsearch[0]->mapvalue){
		    $cond .= ' AND u.map_access <'.$mapvalue;
		}
		*/
		
		if($status = $mypetsearch[0]->status){
		    //$cond .=" AND u.id_user IN (SELECT id_user FROM ".TBL_ONLINE." WHERE 1 GROUP BY id_user)";
            $cond .=" AND ( u.lastactivity +60 >= UNIX_TIMESTAMP() ) ";
		}
		
		//if photo =1 select photos with value not null
		if($mypetsearch[0]->photo == 1)
		{
			$cond .= " AND ( u.photo IS NOT NULL AND u.photo != '' ) ";
		}
		
		//end......
        
		$sql = "SELECT f.*,p.lockstatus FROM (SELECT u.*,floor(DATEDIFF(NOW(),u.dob)/365) AS cur_age ,w.id_user as flg,u1.username as ownername,u1.id_user as idowner FROM "
				.TBL_USER." u LEFT JOIN ".TBL_USER." u1 ON(u.owner=u1.id_user)  
			LEFT JOIN ".TBL_WISHLIST." w   
			ON  (u.id_user=w.id_user and w.id_owner=".getAccountUserId().") ".
			$cond.") AS f LEFT JOIN ".TBL_PET." p ON f.id_user=p.id_user WHERE ".$cond1." GROUP BY(f.id_user)";
			
		if($sb = $mypetsearch[0]->sb){
			if($sb =='mostexp'){
				$sql .=" ORDER BY f.cur_value DESC ";
			}else{
				//$sql .=" ORDER BY idowner DESC ";
				$sql .=" ORDER BY id_user DESC ";
			}
		}
		
		if($records_p_page){
			$sql .= " LIMIT ".$offset.",".$records_p_page."";
		}
		 
		return $this->db->query($sql)->result();
	}
	
	function advanceSearch($name,$offset=0,$records_p_page=0){
		$cond	=" WHERE u.id_admin=0 AND u.id_user!=".getAccountUserId().
				" AND u.id_user!=(SELECT owner FROM ".TBL_USER." WHERE id_user=".getAccountUserId().
				") AND u.id_user NOT IN(SELECT id_user FROM ".TBL_PET.
				" WHERE id_owner=".getAccountUserId().") AND u.random_num='0' AND u.status=0";
				
		if($name){
			$cond .=" AND u.username LIKE '%".$name."%' ";
		}
		
		$sql ="SELECT f.*,p.lockstatus FROM (SELECT u.* ,floor(DATEDIFF(NOW(),u.dob)/365) AS cur_age ,w.id_user as flg,u1.username as ownername,u1.id_user as idowner 
			FROM ".TBL_USER." u LEFT JOIN ".TBL_USER." u1 ON(u.owner=u1.id_user)  
			LEFT JOIN ".TBL_WISHLIST." w   
			ON  (u.id_user=w.id_user and w.id_owner=".getAccountUserId().") ".$cond.") AS f 
			LEFT JOIN ".TBL_PET." p ON f.id_user=p.id_user GROUP BY f.id_user";
		$sql .=" ORDER BY f.id_user DESC ";	
		
		if($records_p_page){
			$sql .= " LIMIT ".$offset.",".$records_p_page."";
		}
		 
		return $this->db->query($sql)->result();
	}
	
	function buyPet(){
		$id_pet = $this->input->get('id_pet');
		$context = $this->input->get('context');
		
		if($this->isMyOwner($id_pet)){
			echo json_encode(
				array(
					'result' =>'ERROR',
					'message'=> "You can not buy your owner as pet."
				)
			);
			exit;
		}
		
		if($this->isMyPet($id_pet)){
			echo json_encode(
				array(
					'result' =>'ERROR',
					'message'=> "This user is already your pet."
				)
			);
			exit;
		}
		
		$ownerdataobj = $this->user_io_m->init('id_user',getAccountUserId());
		$petdataobj	  = $this->user_io_m->init('id_user', $id_pet);

		$uid = $id_pet;
		$curval = $this->user_m->calculatePetPrice($id_pet); //value which owner must pay
		$cash = $ownerdataobj->cash; // cash of owner
		$fval = $petdataobj->cur_value; // value of pet
		$username = $petdataobj->username; 
		$usercash = $petdataobj->cash; // cash of pet
		
		$_SESSION['PET_CUR_VAL'] = $curval;
		
		if($cash < $curval){
			echo json_encode(
				array(
					'result' =>'ERROR',
					'message'=> "Your J$ cash isn't enough to buy this pet."
				)
			);
			exit;
		}
		$pet_owner_sql = "SELECT ju.* FROM ".TBL_USER.
						" ju LEFT JOIN ".TBL_PET.
						" jp ON ju.id_user=jp.id_owner WHERE jp.id_user=".$uid." LIMIT 1";
						
		$pet_owner = $this->db->query($pet_owner_sql)->result();
		
		$this->addtrans($uid,$curval,$cash,$fval,$username);
		$this->wishlist_m->remove($id_pet);  
		
		$this->email_sender->juzonSendEmail_BUYPET($id_pet,$curval);
		$this->email_sender->juzonSendEmail_ALERTMEBUYPET($id_pet,$pet_owner[0]->id_user,$curval);
		
		if($context == 'CMCHAT'){
			$postCMCMSG = str_replace(array('$u1','$u2','$p3'), array($ownerdataobj->username,$petdataobj->username,$curval), language_translate('hook_chat_buy_as_pet'));
		}else{
			$postCMCMSG = '';
		}
		
		echo json_encode(
			array(
				'result' =>'ok',
				'message'=>'Buy pet successfully.',
				'CMCMSG' =>$postCMCMSG
			)
		);
		exit;
	}
	
	function addtrans($pet_uid,$curval,$cash,$fval,$pet_username){
		if( $this->pet_io_m->checkTransactionInput($pet_uid,$curval,$cash,$fval,$pet_username) ){
			//1. update pet record to  new owner
			$petdetailsarray=$this->pet_io_m->updatePetRecord($pet_uid);
			$taxdetailsarray=$this->pet_io_m->calculateTaxAndPetAmount($pet_uid,$curval,$fval,$cash);
			
			//2. insert pet buy in users transaction log
			$this->pet_io_m->updatePetboughtTransction($pet_uid,$fval,$curval,$taxdetailsarray['tax'],$taxdetailsarray['pet_amount']);
			
			//3.  add pet sold transaction
			$this->pet_io_m->updatePetSoldTransction($petdetailsarray['pet_id_owner'],$taxdetailsarray['pvowner_amount']);
			
			//4. update wall
			$this->pet_io_m->addPetTransactionToWallPost($taxdetailsarray['pet_username'],$curval);

			//5. add cash  pets account
			$this->pet_io_m->addCashToPetsAccount($pet_uid,$taxdetailsarray['pet_amount'],$curval);

			//6.  add cash to previous pet owner
			$this->pet_io_m->addCashToPreviousOwnersPetsAccount($petdetailsarray['pet_id_owner'],$taxdetailsarray['pvowner_amount']);

			//7.  add cash to admin user
			$this->pet_io_m->updateAdminCashForpet($taxdetailsarray['tax']);

			//8.  deduct cash from current user
			$this->pet_io_m->deductCashFromCurrentUser($curval);
			return true;
		}	
		return false;
	}	
	
	
	function postOnWall(){
		$message = $this->input->post('message');
		$userdataobj = getAccountUserDataObject();
		
		if(isFacebookLogin()){
			$this->facebookconnect_io_m->postOnUserWall($userdataobj->id_user,$message,$message,$url=$this->user_io_m->getInviteUrl($userdataobj->username));
		}
		if(isTwitterLogin()){
			$this->twittermodel->postOnWall($message,$url=$this->user_io_m->getInviteUrl($userdataobj->username)); 
		}
		
		echo json_encode(
			array('message'=>'Post on your wall successfully.')
		);
		exit;
	}

	
	
	
	
	
	
	
	
	
	
//endclass
}	