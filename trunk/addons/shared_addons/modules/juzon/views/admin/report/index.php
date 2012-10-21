<section class="nav">
	<?php $this->load->view('juzon/admin/nav'); ?> 
</section>

<div class="clear"></div>

<section class="nav">
	<?php $this->load->view('juzon/admin/report/top_nav'); ?>
</section>


<?php 
	$this->load->model('mod_io/crontab_io_m');
	$this->crontab_io_m->_cron_unlockpet();
	
	$lock_status = $this->input->get('lock_status');
	$ownerusername = $this->input->get('ownerusername');
	$petusername = $this->input->get('petusername');
	
	$query = "SELECT * FROM ".TBL_LOCKHISTORY." WHERE 1" ;
	$cond = '';
	if($ownerusername){
		$cond .= " AND owner LIKE '$ownerusername' ";
	}
	if($petusername){
		$cond .= " AND pet LIKE '$petusername' ";
	}
	if($lock_status == 1){
		$cond .= " AND time_to > NOW()";
	}
	if($lock_status == 2){
		$cond .= " AND time_to < NOW()";
	}
	$query .= $cond;
	
	$total = count( $this->db->query($query)->result() );
	if(isset($_GET['per_page'])){
		$offset = intval($_GET['per_page']);
	}else{
		$offset = 0;
	}
	
	$rec_per_page =  $GLOBALS['global']['PAGINATE_ADMIN']['rec_per_page'];
	
	$query .= " ORDER BY id_lockhistory DESC LIMIT $offset,$rec_per_page";
	
	$record = $this->db->query($query)->result();
	
	$pagination = create_pagination( 
					$uri = "admin/juzon/report/?lock_status=$lock_status&ownerusername=$ownerusername&petusername=$petusername", 
					$total_rows = $total , 
					$limit= $rec_per_page,
					$uri_segment = 0,
					TRUE, TRUE 
				);
	
	$arrLockStatus[0] =  '-Select-';
	$arrLockStatus[1] =  'Locked';
	$arrLockStatus[2] =  'Unlocked';
?>

<section class="title">
	 <h4>Lock Report Search </h4>
</section>
	 	 	
<form method='get' action=''>					
	<section class="item">
		<fieldset>
			
			<div class="row-item">
				<label>Lock Status</label>
				<div class="input">
					<?php echo form_dropdown('lock_status',$arrLockStatus,array($lock_status));?>
				</div>
			</div>
			
			<div class="row-item"> 
				<label>Owner Username</label>
				<div class="input">
					<input type="text" name="ownerusername" value="<?php echo $ownerusername;?>" />
				</div>
			</div>
			
			<div class="row-item"> 
				<label>Pet Username</label>
				<div class="input">
					<input type="text" name="petusername" value="<?php echo $petusername;?>" />
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


<section class="title">
	<?php $this->load->view('juzon/admin/report/top'); ?> 
</section>
 
<section class="item">
	
	
	<table border="0" cellpadding=0 class="table-list clear-both" width="100%">
		<thead>
			<tr>  	 	 	 		 	 	 		 	 	 	 	 	 	 	 	 	
				<th>Owner</th> 
				<th>Pet</th> 
				<th>Task</th> 
				<th>Pet Amount</th> 
				<th>Admin Amount </th> 
				<th>Lock Time</th> 
				<th>Time From</th> 
				<th>Time To</th> 				
				<th>Current Status</th>
			</tr>
		</thead>
		
		<tbody>
			<?php
				$path = site_url()."image/thumb/";
				foreach($record as $item):
					$lockdata = $this->mod_io_m->init('id_petlock',$item->id_lock,TBL_PETLOCK);
			?> 	
				<tr id="row_<?php echo $item->id_lockhistory;?>"> 	 	 	 	 	 	 	 	 	 	
					<td><?php echo $item->owner;?></td>
					<td><?php echo $item->pet;?></td>
					<td><img src="<?php echo $path.$lockdata->image;?>" /></td>
					<td><?php echo $item->pet_amount;?></td> 	 	
					<td><?php echo $item->owner_amount;?></td>
					<td><?php echo (int) ($item->lock_time/24);?>D</td>
					<td><?php echo $item->time_from;?></td>
					<td><?php echo $item->time_to;?></td>
					<td>
						<?php 
							if(mysql_to_unix($item->time_to) < time()){
								echo $arrLockStatus[2];
							}else{
								echo $arrLockStatus[1];
							}
						?>
					</td>
				</tr>
			<?php endforeach;?>
		</tbody>
		
		<tfoot>
			<td colspan=9>
				<?php echo $pagination['links'];?>
			</td>
		</tfoot>
		
	</table>	
</section>



<script type="text/javascript">
		
	
</script>
