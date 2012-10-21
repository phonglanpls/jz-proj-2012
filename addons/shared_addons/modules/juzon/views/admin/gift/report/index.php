<section class="nav">
	<?php $this->load->view('juzon/admin/nav'); ?> 
</section>

<div class="clear"></div>

<section class="nav">
	<?php $this->load->view('juzon/admin/gift/top_nav'); ?>
</section>

<section class="title">
	<h4>Gift Report | Search</h4> 
</section>


<?php 
	$username = $this->input->get('username');
	
	$query = "SELECT * FROM ".TBL_GIFTBOX." WHERE 1 ";
	
	$cond = '';
	if($username){
		$userdata = $this->user_io_m->init('username',$username);
		if($userdata){
			$id_user = $userdata->id_user;
			$cond .= " AND ( id_reciever=$id_user OR id_sender=$id_user ) "; 	 	 	
		}
	}
	
	$query .= $cond;
	 
	$total = count( $this->db->query($query)->result() );
	if(isset($_GET['per_page'])){
		$offset = intval($_GET['per_page']);
	}else{
		$offset = 0;
	}
	
	$rec_per_page = $GLOBALS['global']['PAGINATE_ADMIN']['rec_per_page'];
	
	$query .= " ORDER BY id_giftbox DESC LIMIT $offset,$rec_per_page";
	
	$record = $this->db->query($query)->result();
	
	$pagination = create_pagination( 
					$uri = "admin/juzon/gift/report?username=$username", 
					$total_rows = $total , 
					$limit= $rec_per_page,
					$uri_segment = 0,
					TRUE, TRUE 
				);
?>

 	 	 	 	 	
<form method='get' action=''>
						
	<section class="item">
		<fieldset>
			
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
				</div>
			</div>
			
		</fieldset>	
	</section>

</form>


<div class="clear"></div>


<section class="title">
	<div class="top-left">
		<h4>Gift Reports</h4> 	 	 	 	
	</div>
</section>
 
<section class="item">
	<table border="0" cellpadding=0 class="table-list clear-both" width="100%">
		<thead>
			<tr> 	 	 	 	 	 	 	 	 	 	
				<th>From</th> 	 	 	 	 	 	 	
				<th>To</th> 	 	 	
				<th>Gift Name</th>
				<th>Price</th>
				<th>Date</th>
			</tr>
		</thead>
		
		<tbody>
			<?php
				foreach($record as $item):
					$fromuserdata = $this->user_io_m->init('id_user',$item->id_sender);  
					$touserdata = $this->user_io_m->init('id_user',$item->id_reciever);	
					$giftdata = $this->mod_io_m->init('id_gift',$item->id_gift, TBL_GIFT);	
			?>
				<tr id="row_<?php echo $item->id_giftbox;?>"> 	 	 	 	 	 	 	 	 	 	
					<td><?php if($fromuserdata) echo $fromuserdata->username;?></td>
					<td><?php if($touserdata) echo $touserdata->username;?></td>
					<td><?php if($giftdata) echo $giftdata->name_gift;?></td> 	 	
					<td><?php echo $giftdata->price;?></td>
					<td><?php echo $item->add_date;?></td> 	
				</tr>
			<?php endforeach;?>
		</tbody>
		
		<tfoot>
			<td colspan=5>
				<?php echo $pagination['links'];?>
			</td>
		</tfoot>
	</table>	
</section>



<script type="text/javascript">
	
</script>
