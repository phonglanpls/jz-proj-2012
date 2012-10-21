<section class="nav">
	<?php $this->load->view('juzon/admin/nav'); ?> 
</section>

<div class="clear"></div>
  

<section class="title">
	<div class="top-left">
		<h4>Transaction Flow | Filter</h4> 
	</div>
	
	<div class="top-right">
		<ul>
			<li>
				<?php echo admin_loader_image_s("id='detect_pic_loader'");?>
				<a href="javascript:void(0);" onclick="callFuncDetectAccount();">Detect account</a>
			</li>
		</ul>
	</div>
</section>

<?php 
	$show_type = $this->input->get('show_type');
	$datefrom = $this->input->get('datefrom');
	$dateto = $this->input->get('dateto');
	
	if($show_type == 0){
		$cond = " 1 ";
        $trans_type_str = $GLOBALS['global']['TRANS_TYPE']['message'].','.
                    $GLOBALS['global']['TRANS_TYPE']['flirt'].','.
                    $GLOBALS['global']['TRANS_TYPE']['favourite'].','.
                    $GLOBALS['global']['TRANS_TYPE']['buy_peeped'].','.
                    $GLOBALS['global']['TRANS_TYPE']['download'].','.
                    $GLOBALS['global']['TRANS_TYPE']['pet_sold_cash'].','.
                    $GLOBALS['global']['TRANS_TYPE']['new_user_cash'].','.
                    $GLOBALS['global']['TRANS_TYPE']['referred_cash'].','.
                    $GLOBALS['global']['TRANS_TYPE']['convert_cash'].','.
                    $GLOBALS['global']['TRANS_TYPE']['admin_add_reduce'].','.
                    $GLOBALS['global']['TRANS_TYPE']['map'].','.
                    $GLOBALS['global']['TRANS_TYPE']['petlock'].','.
                    $GLOBALS['global']['TRANS_TYPE']['gift'].','.
                    $GLOBALS['global']['TRANS_TYPE']['pet'].','.
                    $GLOBALS['global']['TRANS_TYPE']['backstg_photo'].','.
                    $GLOBALS['global']['TRANS_TYPE']['backstg_video'];
                    
		if($datefrom AND $dateto){
			$cond .= " AND trans_date >='$datefrom' AND trans_date <='$dateto' ";
		}
		$qr = "SELECT SUM(amount) as total FROM ".TBL_TRANSACTION." WHERE $cond AND amount>0 "; 
		$rsq = $this->db->query($qr."AND trans_type IN ($trans_type_str)")->result();
		$total_cash = $rsq[0]->total;
         
		$rst_backstg_photo = $this->db->query($qr." AND trans_type=".$GLOBALS['global']['TRANS_TYPE']['backstg_photo'] )->result();
		$backstg_photo = $rst_backstg_photo[0]->total;
		
		$rst_pet = $this->db->query($qr." AND trans_type=".$GLOBALS['global']['TRANS_TYPE']['pet'] )->result();
		$pet = $rst_pet[0]->total;
		
		$rst_gift = $this->db->query($qr." AND trans_type=".$GLOBALS['global']['TRANS_TYPE']['gift'] )->result();
		$gift = $rst_gift[0]->total;
		
		$rst_petlock = $this->db->query($qr." AND trans_type=".$GLOBALS['global']['TRANS_TYPE']['petlock'] )->result();
		$petlock = $rst_petlock[0]->total;
		
		$rst_map = $this->db->query($qr." AND trans_type=".$GLOBALS['global']['TRANS_TYPE']['map'] )->result();
		$map = $rst_map[0]->total;
		
		$rst_admin_add_reduce = $this->db->query($qr." AND trans_type=".$GLOBALS['global']['TRANS_TYPE']['admin_add_reduce'] )->result();
		$admin_add_reduce = $rst_admin_add_reduce[0]->total;
		
		$rst_convert_cash = $this->db->query($qr." AND trans_type=".$GLOBALS['global']['TRANS_TYPE']['convert_cash'] )->result();
		$convert_cash = $rst_convert_cash[0]->total;
		
		$rst_referred_cash = $this->db->query($qr." AND trans_type=".$GLOBALS['global']['TRANS_TYPE']['referred_cash'] )->result();
		$referred_cash = $rst_referred_cash[0]->total;
		
		$rst_new_user_cash = $this->db->query($qr." AND trans_type=".$GLOBALS['global']['TRANS_TYPE']['new_user_cash'] )->result();
		$new_user_cash = $rst_new_user_cash[0]->total;
		
		$rst_pet_sold_cash = $this->db->query($qr." AND trans_type=".$GLOBALS['global']['TRANS_TYPE']['pet_sold_cash'] )->result();
		$pet_sold_cash = $rst_pet_sold_cash[0]->total;
		
		$rst_download = $this->db->query($qr." AND trans_type=".$GLOBALS['global']['TRANS_TYPE']['download'] )->result();
		$download = $rst_download[0]->total;
		
		$rst_buy_peeped = $this->db->query($qr." AND trans_type=".$GLOBALS['global']['TRANS_TYPE']['buy_peeped'] )->result();
		$buy_peeped = $rst_buy_peeped[0]->total;
		
		$rst_favourite = $this->db->query($qr." AND trans_type=".$GLOBALS['global']['TRANS_TYPE']['favourite'] )->result();
		$buy_favourite = $rst_favourite[0]->total;
		
        //flirst,message
        $rst_flirts = $this->db->query($qr." AND trans_type=".$GLOBALS['global']['TRANS_TYPE']['flirt'] )->result();
		$buy_flirts = $rst_flirts[0]->total;
        
        $rst_message = $this->db->query($qr." AND trans_type=".$GLOBALS['global']['TRANS_TYPE']['message'] )->result();
		$buy_message = $rst_message[0]->total;
        
        $rst_backstg_video = $this->db->query($qr." AND trans_type=".$GLOBALS['global']['TRANS_TYPE']['backstg_video'] )->result();
		$buy_backstg_video = $rst_backstg_video[0]->total;
        
       /* $other = $this->db
        ->query($qr." AND trans_type NOT IN(".$GLOBALS['global']['TRANS_TYPE']['message'].','.
                                            $GLOBALS['global']['TRANS_TYPE']['flirt'].','.
                                            $GLOBALS['global']['TRANS_TYPE']['favourite'].','.
                                            $GLOBALS['global']['TRANS_TYPE']['buy_peeped'].','.
                                            $GLOBALS['global']['TRANS_TYPE']['download'].','.
                                            $GLOBALS['global']['TRANS_TYPE']['pet_sold_cash'].','.
                                            $GLOBALS['global']['TRANS_TYPE']['new_user_cash'].','.
                                            $GLOBALS['global']['TRANS_TYPE']['referred_cash'].','.
                                            $GLOBALS['global']['TRANS_TYPE']['convert_cash'].','.
                                            $GLOBALS['global']['TRANS_TYPE']['admin_add_reduce'].','.
                                            $GLOBALS['global']['TRANS_TYPE']['map'].','.
                                            $GLOBALS['global']['TRANS_TYPE']['petlock'].','.
                                            $GLOBALS['global']['TRANS_TYPE']['gift'].','.
                                            $GLOBALS['global']['TRANS_TYPE']['pet'].','.
                                            $GLOBALS['global']['TRANS_TYPE']['backstg_photo'].','.
                                            $GLOBALS['global']['TRANS_TYPE']['backstg_video'].
                                            ")" )->result();
        echo $other[0]->total; */
	}
	 
	if($show_type == 1){
		$cond = " 1 ";
		if($datefrom AND $dateto){
			$cond .= " AND add_date >='$datefrom' AND add_date <='$dateto' ";
		}
		$query = "SELECT * FROM ".TBL_USER." WHERE $cond AND status=0 AND id_admin=0 "; 
		 
		$total = count( $this->db->query($query)->result() );
		if(isset($_GET['per_page'])){
			$offset = intval($_GET['per_page']);
		}else{
			$offset = 0;
		}
		
		$rec_per_page =  $GLOBALS['global']['PAGINATE_ADMIN']['rec_per_page'];
		
		$query .= " ORDER BY cash DESC LIMIT $offset,$rec_per_page";
		
		$record = $this->db->query($query)->result();
		
		$pagination = create_pagination( 
						$uri = "admin/juzon/transaction_flow/?show_type=$show_type", 
						$total_rows = $total , 
						$limit= $rec_per_page,
						$uri_segment = 0,
						TRUE, TRUE 
					);
	} 
	
	if($show_type == 2){
		$cond = " 1 ";
		if($datefrom AND $dateto){
			$cond .= " AND trans_date >='$datefrom' AND trans_date <='$dateto' ";
		}
		$query = "SELECT *, SUM(user_amt) AS earning FROM ".TBL_TRANSACTION." WHERE $cond AND id_user !=1 GROUP BY id_user"; 
		 
		$total = count( $this->db->query($query)->result() );
		if(isset($_GET['per_page'])){
			$offset = intval($_GET['per_page']);
		}else{
			$offset = 0;
		}
		
		$rec_per_page =  $GLOBALS['global']['PAGINATE_ADMIN']['rec_per_page'];
		
		$query .= " ORDER BY earning DESC LIMIT $offset,$rec_per_page";
		
		$record = $this->db->query($query)->result();
		
		$pagination = create_pagination( 
						$uri = "admin/juzon/transaction_flow/?show_type=$show_type", 
						$total_rows = $total , 
						$limit= $rec_per_page,
						$uri_segment = 0,
						TRUE, TRUE 
					);
	}
	
	if($show_type == 3){
		$cond = " 1 ";
		if($datefrom AND $dateto){
			$cond .= " AND trans_date >='$datefrom' AND trans_date <='$dateto' ";
		}
		$query =  "SELECT *,SUM(amount) as tot_expense from ".TBL_TRANSACTION." WHERE $cond AND id_owner !=1 ".
					" AND amount !=0 AND trans_type !=".$GLOBALS['global']['TRANS_TYPE']['pet_sold_cash'].
					" AND trans_type !=".$GLOBALS['global']['TRANS_TYPE']['message'].
					" AND trans_type !=".$GLOBALS['global']['TRANS_TYPE']['convert_cash'] 
					." GROUP BY id_owner";
					
		$total = count( $this->db->query($query)->result() );
		if(isset($_GET['per_page'])){
			$offset = intval($_GET['per_page']);
		}else{
			$offset = 0;
		}
		
		$rec_per_page =  $GLOBALS['global']['PAGINATE_ADMIN']['rec_per_page'];
		
		$query .= " ORDER BY tot_expense DESC LIMIT $offset,$rec_per_page";
		
		$record = $this->db->query($query)->result();
		
		$pagination = create_pagination( 
						$uri = "admin/juzon/transaction_flow/?show_type=$show_type", 
						$total_rows = $total , 
						$limit= $rec_per_page,
						$uri_segment = 0,
						TRUE, TRUE 
					);
	}
	
	function transactionTypeArr(){
		$arr[0]='-Select-';
		$arr[1]='Backstage Photo';
		$arr[2]='Backstage Video';
		$arr[3]='Pet';
        $arr[4]='Message';
	    $arr[5]='Flirts';
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
		$arr[16]='Favourite';
		return $arr;
	}	
	
	function showTypeArr(){
		$arr[0] = '-Select-';
		$arr[1] = 'Most money';
		$arr[2] = 'Most increase';
		$arr[3] = 'Most decrease';
		return $arr;
	}	
?>

 	 	 	 	 	
<form method='get' action=''>
						
	<section class="item">
		<fieldset>
			
			<div class="row-item">
				<label>Show type</label>
				<div class="input">
					<?php echo form_dropdown('show_type',showTypeArr(),array($show_type));?>
				</div>
			</div>
			
			<div class="row-item">
				<label>Date</label>
				<div class="input">
					From
					<input type="text" name="datefrom" id="datefrom" value="<?php echo $datefrom;?>" />
					to
					<input type="text" name="dateto" id="dateto" value="<?php echo $dateto;?>" />
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
	<h4></h4> 
</section>

<section class="item">
	<?php if($show_type == 0):?>
		<h4>Transaction Flow</h4>
		
		<table>
			<tr>
				<td>Total cash Transaction:</td>
				<td><?php echo $total_cash;?></td>
			</tr>
			
			<tr>
				<td>Total cash: Backstage Photo:</td>
				<td><?php echo $backstg_photo;?> </td>
			</tr>
			
			<tr>
				<td>Total cash: Pet:</td>
				<td> <?php echo $pet;?></td>
			</tr>
			
			<tr>
				<td>Total cash: Gift:</td>
				<td><?php echo $gift;?></td>
			</tr>
			
			<tr>
				<td>Total cash: PetLock:</td>
				<td><?php echo $petlock;?></td>
			</tr>
			
			<tr>
				<td>Total cash: Admin add/reduce:</td>
				<td>  <?php echo $admin_add_reduce;?> </td>
			</tr>
			
			<tr>
				<td>Total cash: Convert to J$:</td>
				<td> <?php echo $convert_cash;?></td>
			</tr>
			
			<tr>
				<td>Total cash: Reffered: </td>
				<td> <?php echo $referred_cash;?></td>
			</tr>
			
			<tr>
				<td>Total cash: New User Join:</td>
				<td> <?php echo $new_user_cash;?></td>
			</tr>
			
			<tr>
				<td>Total cash: Pet Sold:</td>
				<td> <?php echo $pet_sold_cash;?></td>
			</tr>
			
			<tr>
				<td>Total cash: Download:</td>
				<td> <?php echo $download;?></td>
			</tr>
			
			<tr>
				<td>Total cash: Peeped:</td>
				<td> <?php echo $buy_peeped;?></td>
			</tr>
			
			<tr>
				<td>Total cash: Favourite:</td>
				<td> <?php echo $buy_favourite;?></td>
			</tr>
            
            <tr>
				<td>Total cash: Flirts:</td>
				<td> <?php echo $buy_flirts;?></td>
			</tr>
            
            <tr>
				<td>Total cash: Message:</td>
				<td> <?php echo $buy_message;?></td>
			</tr>
            
            <tr>
				<td>Total cash: Backtage Video:</td>
				<td> <?php echo $buy_backstg_video;?></td>
			</tr>
            
             <tr>
				<td>Total cash: Map Flirts:</td>
				<td> <?php echo $map;?></td>
			</tr>
			
            <tr>
				<td>Total Balance:</td>
				<td> 
                    <?php echo ($buy_backstg_video+$buy_message+$map+$buy_flirts+$buy_favourite+$buy_peeped+$download+$pet_sold_cash+$new_user_cash+$referred_cash+$convert_cash+$admin_add_reduce+$petlock+$gift+$pet+$backstg_photo);?>
                </td>
			</tr>
		</table> 
	<?php endif;?>
	
	<?php if($show_type == 1):?>	
		<h4>Most cash users</h4>
	 
		<table border="0" cellpadding=0 class="table-list clear-both" width="100%">
			<thead>
				<tr> 	 	 	 	 	 	 	 	 	 	
					<th>User</th> 	 	 	
					<th>Amount</th>
				</tr>
			</thead>
			
			<tbody>
				<?php
					foreach($record as $item):
				?>
					<tr id="user_<?php echo $item->id_user;?>"> 	 	 	 	 	 	 	 	 	 	
						<td><?php echo $item->username;?></td>
						<td><?php echo $item->cash;?></td> 	 	
					</tr>
				<?php endforeach;?>
			</tbody>
			
			<tfoot>
				<td colspan=2>
					<?php echo $pagination['links'];?>
				</td>
			</tfoot>
		</table>	
	<?php endif;?>

	<?php if($show_type == 2):?>	
		<h4>Most cash users earning</h4>
	 
		<table border="0" cellpadding=0 class="table-list clear-both" width="100%">
			<thead>
				<tr> 	 	 	 	 	 	 	 	 	 	
					<th>User</th> 	 	 	
					<th>Amount</th>
				</tr>
			</thead>
			
			<tbody>
				<?php
					foreach($record as $item):
						$userdata = $this->user_io_m->init('id_user',$item->id_user);
				?>
					<?php if($userdata):?>
						<tr id="user_<?php echo $item->id_user;?>"> 	 	 	 	 	 	 	 	 	 	
							<td><?php echo $userdata->username;?></td>
							<td><?php echo $item->earning;?></td> 	 	
						</tr>
					<?php endif;?>	
				<?php endforeach;?>
			</tbody>
			
			<tfoot>
				<td colspan=2>
					<?php echo $pagination['links'];?>
				</td>
			</tfoot>
		</table>	
	<?php endif;?>
	
	<?php if($show_type == 3):?>	
		<h4>Most cash users expense</h4>
	 
		<table border="0" cellpadding=0 class="table-list clear-both" width="100%">
			<thead>
				<tr> 	 	 	 	 	 	 	 	 	 	
					<th>User</th> 	 	 	
					<th>Amount</th>
				</tr>
			</thead>
			
			<tbody>
				<?php
					foreach($record as $item):
						$userdata = $this->user_io_m->init('id_user',$item->id_owner);
				?>
					<?php if($userdata):?>
						<tr id="user_<?php echo $item->id_owner;?>"> 	 	 	 	 	 	 	 	 	 	
							<td><?php echo $userdata->username;?></td>
							<td><?php echo $item->tot_expense;?></td> 	 	
						</tr>
					<?php endif;?>
				<?php endforeach;?>
			</tbody>
			
			<tfoot>
				<td colspan=2>
					<?php echo $pagination['links'];?>
				</td>
			</tfoot>
		</table>	
	<?php endif;?>
	
</section>


<script type="text/javascript">
	$(document).ready(function(){
		$( "#datefrom,#dateto" ).datepicker(
			{
				dateFormat: 'yy-mm-dd 00:00:00',
				changeMonth: true,
				changeYear: true 
			}	
		);
	});
	
	function callFuncDetectAccount(){
		$('#detect_pic_loader').show();
		$.get(BASE_URI+'admin/juzon/transaction_flow/callFuncDetectAccount',{},function(res){
			$('#detect_pic_loader').hide();
			$('#hiddenElement').html(res);
			$('#hiddenElement').dialog(
				{
					width: 550,
					height:400 ,
					//draggable: false,
					//resizable: false,
					buttons:{},
					title: 'Detect account' 
				}
			);
		});
	}
</script>










