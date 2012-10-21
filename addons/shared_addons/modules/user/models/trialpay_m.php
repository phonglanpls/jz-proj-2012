<?php defined('BASEPATH') or exit('No direct script access allowed');

class Trialpay_m extends MY_Model {
	function __construct(){
		parent::__construct();
	}
	
	function process(){
	    // Optionally verify HMAC signature
		// Optionally verify sender's IP address
		// If all is ok, now respond to the notification:
		// read whatever parameters you need from the request
		// TrialPay provides this signature for the message
		$message_signature = $_SERVER['HTTP_TRIALPAY_HMAC_MD5'];
		// Recalculate the signature locally
		$key = 'fed7ee9f94';
		//$handle = fopen("./logs/file1.txt", "a+");		
		//fwrite($handle,"\n".date("d-m-Y h:i:s")."\n");	
		//fwrite($handle,"\n".$message_signature.":::".$key."\n");
        
        debug($message_signature.":::".$key, "file1.txt"); 
		if ($_SERVER['REQUEST_METHOD'] == 'POST') {
		 
			// the following is for POST notification
			if (empty($HTTP_RAW_POST_DATA)) {
				$recalculated_message_signature = hash_hmac('md5', file_get_contents('php://input'), $key);
			} else {
				$recalculated_message_signature = hash_hmac('md5', $HTTP_RAW_POST_DATA, $key);
			}
		} else {
			 
			// the following is for GET notification
			$recalculated_message_signature = hash_hmac('md5', $_SERVER['QUERY_STRING'], $key);
		}
		//fwrite($handle,$message_signature.":::recalculate:-".$recalculated_message_signature."--".$_REQUEST['reward_amount']."\n");
        debug($message_signature.":::recalculate:-".$recalculated_message_signature."--".$_REQUEST['reward_amount'], "file1.txt"); 
		if ($message_signature == $recalculated_message_signature) {
		    // the message is authentic
		    //Code will be here for update user J$ value
            /*
		    $sql = "UPDATE ".TABLE_PREFIX."user SET cash = cash+".$_REQUEST['reward_amount']." WHERE username='".$_REQUEST['sid']."'";
		    $id  = mysql_query($sql);
			$sql_user = "SELECT id_user FROM ".TABLE_PREFIX."user WHERE username='".$_REQUEST['sid']."'";
			$res = mysql_fetch_assoc(mysql_query($sql_user));
		    $sql_trans = "INSERT INTO ".TABLE_PREFIX."transaction (id_owner,id_user,amount,trans_type,transaction_for,user_amt,trans_date,ip) VALUES('".$res['id_user']."','".$res['id_user']."','".$_REQUEST['reward_amount']."','".$GLOBALS['conf']['TRANS_TYPE']['convert_cash']."','".$_REQUEST['campaign']."','".$_REQUEST['reward_amount']."',NOW(),'".$_SERVER['REMOTE_ADDR']."')";
		    $trans_id  = mysql_query($sql_trans);
            */
            $sql = "UPDATE ".TBL_USER." SET cash = cash+".$_REQUEST['reward_amount']." WHERE username='".$_REQUEST['sid']."'";
		    $this->db->query($sql);
            
			$sql_user = "SELECT id_user FROM ".TBL_USER." WHERE username='".$_REQUEST['sid']."'";
			$res = $this->db->query($sql_user)->result();
            
		    $sql_trans = "INSERT INTO ".TBL_TRANSACTION." (id_owner,id_user,amount,trans_type,transaction_for,user_amt,trans_date,ip) VALUES('".$res[0]->id_user."','".$res[0]->id_user."','".$_REQUEST['reward_amount']."','".$GLOBALS['global']['TRANS_TYPE']['convert_cash']."','".$_REQUEST['campaign']."','".$_REQUEST['reward_amount']."',NOW(),'".$_SERVER['REMOTE_ADDR']."')";
		    $this->db->query($sql_trans);
            
            $_SESSION['trialpay']['cash_added'] = $_REQUEST['reward_amount'];
		} else {
		    // the message is not authentic
		    print "The specified sid is invalid";
		}
		//$handle = fopen("./logs/file.txt", "a+");		
		//fwrite($handle,"\n".date("d-m-Y h:i:s")."\n");	
		//fwrite($handle,$_SERVER['HTTP_TRIALPAY_HMAC_MD5']);	
		//fwrite($handle,"-----------------------------\n");	
        debug($_SERVER['HTTP_TRIALPAY_HMAC_MD5'], "file.txt");
		foreach($_REQUEST as $key => $value){
			//fwrite($handle,$key."::".$value."\n");
            debug($key."::".$value, "file.txt");
		}
		//fclose($handle);
		$trialpay_order_id = $_REQUEST['oid']; // optional
		$sid = $_REQUEST['sid']; // optional
		 
		if ($errors) { // example of how to report an error
		  // This will alert TrialPay Customer Service automatically:
		  header("HTTP/1.0 400 Bad Request");
		  // Also return this human-readable error message
		  // so that TrialPay Customer Service can track down the issue:
		  echo "The specified sid is invalid"; // example error message
		  exit;
		}
		// no errors. so activate the customer at your end
		// Now let TrialPay know that everything is ok.
		// Must return a non-empty response. 
		// Otherwise, TrialPay will treat this notification as an error:
		echo "1";exit; // Alternatively, you may return your unlock code, or activation code here
		// if you returned your unlock code above, it will be delivered to your customer
	}
	
	function end_process_trialpay(){
	    //$handle = fopen("./logs/respfile.txt", "a+");		
		//fwrite($handle,"\n".date("d-m-Y h:i:s")."\n");	
		//fwrite($handle,"-----------------------------\n");	
		foreach($_REQUEST as $key => $value){
			//fwrite($handle,$key."::".$value."\n");
            debug($key."::".$value, "respfile.txt");
		}
		//fclose($handle);
        
        redirect(site_url("user/account/trialpay_status"));
	}
	
	
	
	
	
	
	
	
//endclass
}	