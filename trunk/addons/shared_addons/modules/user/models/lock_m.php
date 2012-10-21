<?php defined('BASEPATH') or exit('No direct script access allowed');

class Lock_m extends MY_Model {
	function __construct(){
		parent::__construct();
	}
	
	function getLockRecord($id_lock){
		$rs = $this->db->where('id_petlock',$id_lock)->get(TBL_PETLOCK)->result();
		return $rs?$rs[0]:false;
	}	
	
	function getPetLockRecord($id_upet){
		$rs = $this->db->where('id_user',$id_upet)->where('id_owner',getAccountUserId())->get(TBL_PET)->result();
		return $rs?$rs[0]:false;
	}
	
	function submitLockPet(){
		$pet_id = $this->input->get('pet_id');
		$lock_id = $this->input->get('lock_id');
		$day = $this->input->get('day');
		
		$lockinfodata = $this->lock_m->getLockRecord($lock_id);
		$ownerdataobj = $this->user_io_m->init('id_user',getAccountUserId());
		$petdataobj = $this->user_io_m->init('id_user',$pet_id);
		
		$totalprice = $lockinfodata->price*$day*$lockinfodata->chargeperday;
		$mycash = $ownerdataobj->cash;
		
		$arr['totday'] = $day;
		$arr['lockid'] = $lock_id;
		$arr['totprice'] = $totalprice;
		$arr['iduser'] = $pet_id;
		$arr['petname'] = $petdataobj->username;
		$arr['lockname'] = $ownerdataobj->username;
		
		$_SESSION['PET_LOCK_VAL'] = $totalprice;
		
		$this->updpet_lock($arr);
		$this->email_sender->juzonSendEmail_ALERTMELOCKPET($pet_id,$ownerdataobj->id_user,$totalprice);
		
		$petlockdata = $this->getPetLockRecord($pet_id);
		
		echo json_encode(
			array(
				'result' => 'ok',
				'message'	=> 'Lock pet successfully.',
				'update'	=> 'Locked pet to: '.juzTimeDisplay( $petlockdata->lockexp_date )
			)
		);
		exit;
	}
	
	
	function updpet_lock($arr){
		$ownerdataobj = $this->user_io_m->init('id_user',getAccountUserId());
		//$expdate=date('Y-m-d H:i:s',strtotime('+'.$arr['totday']."days"));

		if($arr['totday']>1){
			$day="days";
		}else{
			$day='day';
		}
		
		$checkrecord = $this->getPetLockRecord($arr['iduser']);
		if( mysql_to_unix( $checkrecord->lockexp_date ) >  mysql_to_unix (mysqlDate()) ){
			//if this pet had locked and not expire date
			$sql=	"UPDATE ".TBL_PET." 
				SET lockstatus=1 ,id_petlock=".$arr['lockid'].
				",userprice=".$arr['totprice']."/2,
				addlock_date=NOW(),intr=".$arr['totday']."*24,
				lockexp_date=ADDDATE(lockexp_date,'".$arr['totday']."')
				WHERE id_user=".$arr['iduser']." AND id_owner=".getAccountUserId();
		}else{
			$sql=	"UPDATE ".TBL_PET." 
				SET lockstatus=1 ,id_petlock=".$arr['lockid'].
				",userprice=".$arr['totprice']."/2,
				addlock_date=NOW(),intr=".$arr['totday']."*24,
				lockexp_date=ADDDATE(NOW(),'".$arr['totday']."')
				WHERE id_user=".$arr['iduser']." AND id_owner=".getAccountUserId();
		}
		$this->db->query($sql);
		debug("update tbl pet");
		

		//For lock history added on dt-30-12-10
		$petinfo = $this->user_io_m->init('id_user',$arr['iduser']); 
		$lock_sql = "INSERT INTO ".TBL_LOCKHISTORY."
					(owner,pet,owner_email,pet_email,id_lock,pet_amount,owner_amount,lock_time,time_from,time_to,ip) 
					VALUES('".$ownerdataobj->username."','".$petinfo->username."','".$ownerdataobj->email."','".
							$petinfo->email."',".$arr['lockid'].",".$arr['totprice']."/2,".
							$arr['totprice']."/2,".$arr['totday']."*24,NOW(),ADDDATE(NOW(),'".
							$arr['totday']."'),'".$_SERVER['REMOTE_ADDR']."')";
		$this->db->query($lock_sql);
		debug("update lock history");
		
		//For lock history ended on dt-30-12-10
        $user_amount = $arr['totprice']*$GLOBALS['global']['LOCKPET']['user']/100;
        $site_amount = $arr['totprice']*$GLOBALS['global']['LOCKPET']['site']/100;
        
		$sql_trans = "INSERT INTO ".TBL_TRANSACTION." 
						(id_user,id_owner,facevalue,amount,trans_type,site_amt,user_amt,trans_date,ip) 
					VALUES
					(".$arr['iduser'].",".$ownerdataobj->id_user.",0,".$arr['totprice'].",".
						$GLOBALS['global']['TRANS_TYPE']['petlock'].",".$site_amount.",".
						$user_amount.",NOW(),'".$_SERVER['REMOTE_ADDR']."')";
						
		$this->db->query($sql_trans);
		debug("update transaction history");
		
		//update wall
		$sql_wall = "INSERT INTO ".TBL_WALL." 
			(id_user,action_to,trans_type,description,post_code,add_date_post) 
			VALUES
			(".$ownerdataobj->id_user.",'".$arr['petname']."',".
				$GLOBALS['global']['TRANS_TYPE']['petlock'].",'with ".$arr['lockname']." for ".$arr['totday']." $day','".
				$GLOBALS['global']['CHATTER_CODE']['pet_locked']."',NOW())";
				
		$this->db->query($sql_wall);
		
		$id_wall = $this->db->insert_id();
		$this->user_io_m->postItemOnFbTt($id_wall,TIMELINE_LOCKPET);
		
		debug("update wall");
		
		//update cash to pet	
		//$ucase = $arr['totprice']/2;
		$sql_updu = "UPDATE ".TBL_USER." SET cash= cash+".$user_amount. " WHERE id_user=".$arr['iduser'];
		$this->db->query($sql_updu);
		debug("update cash pet");
		
		//update cash to admin
		$sql_upda = "UPDATE ".TBL_USER." SET cash= cash+".$site_amount. " WHERE id_admin=1";
		$this->db->query($sql_upda);
		debug("update cash admin");
		
		//update cash to owner
		$sql_updo="UPDATE ".TBL_USER." SET cash=cash-".$arr['totprice']. " WHERE id_user=".getAccountUserId();
		$this->db->query($sql_updo);
		debug("update cash owner");
		
		return true;
	}
//endclass
}	