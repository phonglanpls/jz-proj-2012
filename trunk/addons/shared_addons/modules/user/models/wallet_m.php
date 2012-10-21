<?php defined('BASEPATH') or exit('No direct script access allowed');

class Wallet_m extends MY_Model {
	function __construct(){
		parent::__construct();
	}
	
	function getEarningWallet($trans_type=0,$offset=0,$records_p_page=0){
		$cond=" WHERE t.id_user=".getAccountUserId()." AND user_amt !=0";
		if($trans_type){
		    $cond .=" AND trans_type=".$trans_type;
		}
		$sql="SELECT t.*,u1.username as owner from ".TBL_TRANSACTION." t LEFT JOIN ".TBL_USER." u1 on t.id_owner=u1.id_user";
		$sql=$sql.$cond." ORDER BY id_transaction DESC";
		
		if($records_p_page){
			$sql .= " LIMIT ".$offset.",".$records_p_page."";
		}
		return $this->db->query($sql)->result();
	}
	
	function getExpenseWallet($trans_type=0,$offset=0,$records_p_page=0){
		$cond=" WHERE t.id_owner=".getAccountUserId()." AND amount !=0";
		if($trans_type){
			$cond .=" AND trans_type=".$trans_type;
		}else{
			$cond .=" AND trans_type !=".$GLOBALS['global']['TRANS_TYPE']['pet_sold_cash']." AND trans_type !=".$GLOBALS['global']['TRANS_TYPE']['message']." AND trans_type !=".$GLOBALS['global']['TRANS_TYPE']['convert_cash'];
		}
		$sql="SELECT t.*,u1.username as owner from ".TBL_TRANSACTION." t LEFT JOIN ".TBL_USER." u1 on t.id_user=u1.id_user";
		$sql=$sql.$cond." ORDER BY id_transaction DESC";
		
		if($records_p_page){
			$sql .= " LIMIT ".$offset.",".$records_p_page."";
		}
		return $this->db->query($sql)->result();
	}
	
	function getBalance(){
		$earn= $this->db->query( "SELECT SUM(user_amt) as tot_earning from ".TBL_TRANSACTION." WHERE id_user=".getAccountUserId()." AND user_amt !=0")->result();
	    $tot_earn = $earn[0]->tot_earning;
		
	    $expense= $this->db->query( 
									"SELECT SUM(amount) as tot_expense from ".TBL_TRANSACTION." WHERE id_owner=".getAccountUserId()." AND amount !=0 
									AND trans_type !=".$GLOBALS['global']['TRANS_TYPE']['pet_sold_cash'].
									" AND trans_type !=".$GLOBALS['global']['TRANS_TYPE']['message'].
									" AND trans_type !=".$GLOBALS['global']['TRANS_TYPE']['convert_cash']
								)->result();
									
	    //excluding pet_sold_cash becoz its already calculated in pet_buy for expense
	    $tot_expense= $expense[0]->tot_expense;
		
		return array('total_earn'=>$tot_earn, 'total_expense'=> $tot_expense);
	}
	
	
	
	
//endclass
}	