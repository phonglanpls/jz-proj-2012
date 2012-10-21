<?php defined('BASEPATH') or exit('No direct script access allowed');

class Pet_io_m extends MY_Model {
	function __construct(){
		parent::__construct();
	}
	
	function fetchRecord($pet_uid){
		$petrecord= $this->db->where('id_user',$pet_uid)->get(TBL_PET)->result();
		return $petrecord[0];
	}
	
	function updatePetRecord($pet_uid){
		//get the records for the pet
		$petrecord= $this->db->where('id_user',$pet_uid)->get(TBL_PET)->result();
		//insert or update pet record to the current owner id
		
		if($petrecord){
			$this->db->query( "UPDATE ".TBL_PET." SET id_owner=".getAccountUserId().",add_date=NOW() WHERE id_user=".$pet_uid );
			$petdetailsarray['pet_id_owner']=$petrecord[0]->id_owner;
		}else{		
			$arr['id_user'] = $pet_uid;
			$arr['id_owner'] = getAccountUserId();
			$arr['add_date'] = mysqlDate();
			$arr['ip'] = $this->geo_lib->getIpAddress();
			
			//get the id of the new pet
			$petid = $this->mod_io->insert_map($arr, TBL_PET);

			$petdetailsarray['petid'] = $petid;
		}
		
		debug("updatePetRecord with uid=".$pet_uid);
		
		return $petdetailsarray;
	}
	
	function calculateTaxAndPetAmount($pet_uid,$curval,$fval,$cash){
		//get the details of the user
		$wall_user = $this->user_io_m->init('id_user',$pet_uid);
		$pet_username = $wall_user->username;

		//$cash=$cash-$curval;
		//calculation for transaction

		$pf  = $curval - $fval;
		$tax = ($GLOBALS['global']['PET_VALUE']['tax_trans']/100)*$pf;
		$pf  = $pf-$tax;

		$pvowner_amount = $fval + ($pf/2);
		$pet_amount = $pf/2;

		$detailsarray['pf']=$pf;
		$detailsarray['tax']=$tax;
		$detailsarray['pvowner_amount']=$pvowner_amount;
		$detailsarray['pet_amount']=$pet_amount;
		$detailsarray['pet_username']=$pet_username;
		$detailsarray['cash']=$wall_user->cash;
		
		debug("calculateTaxAndPetAmount with uid=".$pet_uid);
		
		return $detailsarray;
	}
	
	function updatePetboughtTransction($pet_uid,$fval,$curval,$tax,$pet_amount){
		$sql="INSERT INTO ".TBL_TRANSACTION."
				(id_user,id_owner,facevalue,amount,trans_type,site_amt,user_amt,trans_date,ip) 
					VALUES
				(".$pet_uid.",".getAccountUserId().",".$fval.",".$curval.",".$GLOBALS['global']['TRANS_TYPE']['pet'].",".$tax.",".$pet_amount.",NOW(),'".$_SERVER['REMOTE_ADDR']."')";
		
		$this->db->query($sql);
		
		debug("updatePetboughtTransction with uid=".$pet_uid);
	}
	
	function updatePetSoldTransction($pet_id_owner,$pvowner_amount){
		$sql_petsold ="INSERT INTO ".TBL_TRANSACTION."
				(id_user,id_owner,amount,trans_type,user_amt,trans_date,ip) 
					VALUES
				(".$pet_id_owner.",".getAccountUserId().",".$pvowner_amount.",".$GLOBALS['global']['TRANS_TYPE']['pet_sold_cash'].",".$pvowner_amount.",NOW(),'".$_SERVER['REMOTE_ADDR']."')";
		
		$this->db->query($sql_petsold);
		
		debug("updatePetSoldTransction with uid=".$pet_id_owner);
	}
	
	function addPetTransactionToWallPost($pet_username,$curval){
		$sql_wall ="INSERT INTO ".TBL_WALL." 
				(id_user,action_to,trans_type,description,post_code,add_date_post) 
				VALUES
				(".getAccountUserId().",'".$pet_username."',".$GLOBALS['global']['TRANS_TYPE']['pet'].",'as a pet for j$ ".$curval."','".$GLOBALS['global']['CHATTER_CODE']['pet_store']."',NOW())";
		
		$this->db->query($sql_wall);
		
		$id_wall = $this->db->insert_id();
		$this->user_io_m->postItemOnFbTt($id_wall,TIMELINE_BUY_PET);
		
		debug("addPetTransactionToWallPost with curval=".$curval);
	}
	
	function addCashToPetsAccount($pet_uid,$pet_amount,$curval){
		//removed duplicate update of owner,  current value is updated in profile_menu
		$sql_updu="UPDATE ".TBL_USER." SET cash=cash+".$pet_amount.",cur_value=".$curval.",owner=".getAccountUserId().
					" WHERE id_user=".$pet_uid;
		$this->db->query($sql_updu);
		
		debug("addCashToPetsAccount with pet amount=".$pet_amount);
	}
	
	function addCashToPreviousOwnersPetsAccount($id_owner,$pvowner_amount){
		$sql_pvowner="UPDATE ".TBL_USER." SET cash=cash+".$pvowner_amount. " WHERE id_user=".$id_owner;
		$this->db->query($sql_pvowner);
		
		debug("addCashToPreviousOwnersPetsAccount with pvowner_amount=".$pvowner_amount);
	}
	
	function updateAdminCashForpet($tax){
		$sql_admin="UPDATE ".TBL_USER." SET cash=cash+".$tax. " WHERE id_admin=1";
		$this->db->query($sql_admin);
		
		debug("updateAdminCashForpet with tax=".$tax);
	}
	
	function deductCashFromCurrentUser($curval){
		$sql_updo="UPDATE ".TBL_USER." SET cash=cash-".$curval. " WHERE id_user=".getAccountUserId();
		$this->db->query($sql_updo);
		
		debug("deductCashFromCurrentUser with curval=".$curval);
	}

	function checkTransactionInput($pet_uid,$curval,$cash,$fval,$pet_username){
		//check if none of them is blank
		if(	
			$pet_uid=='' or $curval=='' or $cash=='' or $fval=='' or 
			$pet_username=='' or getAccountUserId() =='' or $_SERVER['REMOTE_ADDR']=='' 
			or $GLOBALS['global']['PET_VALUE']['tax_trans']=='' or $GLOBALS['global']['TRANS_TYPE']['pet']=='' 
			or $GLOBALS['global']['TRANS_TYPE']['pet_sold_cash']==''  
			or $GLOBALS['global']['CHATTER_CODE']['pet_store']=='' 
		)
		{
			return false;
		}
		
		//check if none of them is null
		if(
			$pet_uid==NULL or $curval==NULL or $cash==NULL or $fval==NULL or $pet_username==NULL 
			or getAccountUserId() == NULL or $_SERVER['REMOTE_ADDR']==NULL or 
			$GLOBALS['global']['PET_VALUE']['tax_trans']==NULL 
			or $GLOBALS['global']['TRANS_TYPE']['pet']==NULL 
			or $GLOBALS['global']['TRANS_TYPE']['pet_sold_cash']==NULL  
			or $GLOBALS['global']['CHATTER_CODE']['pet_store']==NULL 
		)
		{
			return false;
		}
		
		//check if numbers are numeric
		if( 
			!is_numeric ($pet_uid) or !is_numeric ($curval) or !is_numeric ($cash)or !is_numeric($fval) or 
			!is_numeric(getAccountUserId()) or !is_numeric($GLOBALS['global']['PET_VALUE']['tax_trans']) 
			or !is_numeric($GLOBALS['global']['TRANS_TYPE']['pet']) or  
			!is_numeric($GLOBALS['global']['TRANS_TYPE']['pet_sold_cash']) or 
			!is_numeric($GLOBALS['global']['CHATTER_CODE']['pet_store'])  
		)
		{
			return false;
		}
		
		return true;
	}

	
	
	
	
	
	
	
	
	
	
	
//endclass
}	