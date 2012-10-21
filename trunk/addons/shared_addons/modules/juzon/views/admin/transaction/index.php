<section class="nav">
	<?php $this->load->view('juzon/admin/nav'); ?> 
</section>

<div class="clear"></div>
  

<section class="title">
	<h4>Transaction | Search</h4> 
</section>

<?php 
	$trans_type = $this->input->get('trans_type');
	$username = $this->input->get('username');
	
	$trans_type = ($trans_type>0)?$trans_type:1;
	
	$query = "SELECT u.username,t.* FROM ".TBL_USER." u ,".TBL_TRANSACTION." t WHERE (t.id_owner=u.id_user) ";
	
	$cond = '';
	if($username){
		$cond .= " AND u.username LIKE '%$username%' ";
	}
	if($trans_type){
		$cond .= " AND t.trans_type = '$trans_type' ";
	}
	
	$query .= $cond;
	 
	$total = count( $this->db->query($query)->result() );
	if(isset($_GET['per_page'])){
		$offset = intval($_GET['per_page']);
	}else{
		$offset = 0;
	}
	
	$rec_per_page =  $GLOBALS['global']['PAGINATE_ADMIN']['rec_per_page'];
	
	$query .= " ORDER BY id_transaction DESC LIMIT $offset,$rec_per_page";
	
	$record = $this->db->query($query)->result();
	
	$pagination = create_pagination( 
					$uri = "admin/juzon/transaction/?username=$username&trans_type=$trans_type", 
					$total_rows = $total , 
					$limit= $rec_per_page,
					$uri_segment = 0,
					TRUE, TRUE 
				);
				
				
	function transactionTypeArr(){
		$arr[0]='-Select-';
		$arr[1]='Backstage Photo';
		//$arr[2]='Backstage Video';
		$arr[3]='Pet';
		$arr[6]='Gift';
		$arr[7]='Pet Lock';
		$arr[8]='Map';
		$arr[9]='Admin Add/Reduce';
		$arr[10]='Cash Add';
		$arr[11]='Referrals Join';
		$arr[12]='New User Join';
		$arr[13]='Pet sold';
		$arr[14]='Download';
		$arr[15]='Peeped';
		$arr[16]='Favorite';
		return $arr;
	}	
			
?>

 	 	 	 	 	
<form method='get' action=''>
						
	<section class="item">
		<fieldset>
			
			<div class="row-item">
				<label>Transaction type</label>
				<div class="input">
					<?php echo form_dropdown('trans_type',$trans_type_arr = transactionTypeArr(),array($trans_type));?>
				</div>
			</div>
			
			<div class="row-item">
				<label>Username</label>
				<div class="input">
					<input type="text" name="username" value="<?php echo $username;?>" />
				</div>
			</div>
			
			<div class="row-item">
				<label>&nbsp;</label>
				<div class="input">
					<input type="submit" value="Search" />
					<input type="reset" value="Reset" />
				</div>
			</div>
			
		</fieldset>	
	</section>

</form>



<div class="clear"></div>
  

<section class="title">
	<h4>User | List Transaction For <?php echo $trans_type_arr[$trans_type];?></h4> 
</section>

<section class="item">
    <?php 
        if($trans_type == 1){
            $this->load->view("juzon/admin/transaction/backstage_photo",array('record'=>$record,'pagination'=>$pagination));
        }
        if($trans_type == 3){
            $this->load->view("juzon/admin/transaction/pet",array('record'=>$record,'pagination'=>$pagination));
        }
        if($trans_type == 6){
            $this->load->view("juzon/admin/transaction/gift",array('record'=>$record,'pagination'=>$pagination));
        }
        if($trans_type == 7){
            $this->load->view("juzon/admin/transaction/pet_lock",array('record'=>$record,'pagination'=>$pagination));
        }
        if($trans_type == 8){
            $this->load->view("juzon/admin/transaction/map",array('record'=>$record,'pagination'=>$pagination));
        }
        if($trans_type == 9){
            $this->load->view("juzon/admin/transaction/add_reduce",array('record'=>$record,'pagination'=>$pagination));
        }
        if($trans_type == 10){
            $this->load->view("juzon/admin/transaction/add_cash",array('record'=>$record,'pagination'=>$pagination));
        }
        if($trans_type == 11){
            $this->load->view("juzon/admin/transaction/reffer_join",array('record'=>$record,'pagination'=>$pagination));
        }
        if($trans_type == 12){
            $this->load->view("juzon/admin/transaction/user_join",array('record'=>$record,'pagination'=>$pagination));
        }
        if($trans_type == 13){
            $this->load->view("juzon/admin/transaction/pet_sold",array('record'=>$record,'pagination'=>$pagination));
        }
        if($trans_type == 14){
            $this->load->view("juzon/admin/transaction/download",array('record'=>$record,'pagination'=>$pagination));
        }
        if($trans_type == 15){
            $this->load->view("juzon/admin/transaction/peeped",array('record'=>$record,'pagination'=>$pagination));
        }
        if($trans_type == 16){
            $this->load->view("juzon/admin/transaction/favorite",array('record'=>$record,'pagination'=>$pagination)); 
        }
    ?>
		
</section>


<script type="text/javascript">
	
</script>










