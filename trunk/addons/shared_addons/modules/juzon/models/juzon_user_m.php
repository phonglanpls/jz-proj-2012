<?php defined('BASEPATH') or exit('No direct script access allowed');
/**
 * @package 	PyroCMS
 * @subpackage  Templates Module
 * @category	Module
 */
class Juzon_user_m extends MY_Model {
	
	function __construct()
    {
        parent::__construct();
    }
	
	function toggleStatusLock(){
		$id_user = $this->input->post('id_user');
		$userdata = $this->mod_io_m->init('id_user',$id_user,TBL_USER);
		
		if($userdata->status == 0){
			$stt = 'Deactive';
			$this->db->where('id_user',$id_user)->update(TBL_USER, array('status'=>1));
		}else{
			$stt = 'Active';
			$this->db->where('id_user',$id_user)->update(TBL_USER, array('status'=>0));
		}
		echo $stt;
		exit;
	}
	
	function switchUser(){
		$username = $this->input->get('username');
		$userdata = $this->user_io_m->init('username',$username);
		
		if($userdata){
		    unset($_SESSION['twitterconnection']);
	        unset($_SESSION['facebookinvokedtime']);  
			$_SESSION['admin_switch_user'] = 1; 
			$this->user_io_m->saveAccountToSessionInfo($userdata->id_user);
			redirect('user');
		}
	}
	
    function switchUserFB(){
        $id = $this->input->get('id');
        redirect("http://facebook.com/$id");
    }
    
    function switchUserTT(){
        $id = $this->input->get('id');
        $dataobj = json_decode(file_get_contents("https://api.twitter.com/1/users/lookup.json?user_id=$id&include_entities=true"));
        $username = $dataobj[0]->screen_name;
        redirect("http://twitter.com/$username");
    }
    
	function saveCashUser(){
		extract($_POST);
		
		$userdata = $this->mod_io_m->init('id_user',$id_user,TBL_USER);
		
		if(! $this->phpvalidator->is_numeric($cash)){
			echo 'Cash must be numeric.';exit;
		}else{
			if($action == 'add'){
				$data['cash'] = $userdata->cash + $cash;
			}else{
				$data['cash'] = $userdata->cash - $cash;
			}
			$this->mod_io_m->update_map($data, array('id_user'=>$id_user), TBL_USER);
			
			$transtype = $GLOBALS['global']['TRANS_TYPE']['admin_add_reduce'];
			
			if($action == 'add'){
				$sql = "INSERT INTO ".TBL_TRANSACTION." (id_owner,id_user,amount,trans_type,user_amt,trans_date,ip) VALUES('1','".$id_user."','".$cash."','".$transtype."','".$cash."',NOW(),'".$_SERVER['REMOTE_ADDR']."')";
			}else{
				$sql = "INSERT INTO ".TBL_TRANSACTION." (id_owner,id_user,amount,trans_type,site_amt,trans_date,ip) VALUES('".$id_user."','1','".$cash."','".$transtype."','".$cash."',NOW(),'".$_SERVER['REMOTE_ADDR']."')";
			}
			$this->db->query($sql);
		}
		echo 'ok';
		exit;
	}
	
	
//endclass
}	