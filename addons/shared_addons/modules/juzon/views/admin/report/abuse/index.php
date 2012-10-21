<section class="nav">
	<?php $this->load->view('juzon/admin/nav'); ?> 
</section>

<div class="clear"></div>

<section class="nav">
	<?php $this->load->view('juzon/admin/report/top_nav'); ?>
</section>


<?php 
	$reporter = $this->input->get('reporter');
	$to_user = $this->input->get('to_user');
	
	$query = "SELECT * FROM ".TBL_REPORT_ABUSE." WHERE 1" ;
	$cond = '';
	if($reporter){
		$reportdata = $this->user_io_m->init('username',$reporter);
		if($reportdata){	 	 	
			$cond .= " AND id_reporter='".$reportdata->id_user."'";
		}
	}
	
	if($to_user){
		$userdata = $this->user_io_m->init('username',$to_user);
		if($userdata){	 	 	
			$cond .= " AND id_user='".$userdata->id_user."'";
		}
	}
	
	$query .= $cond;
	
	$total = count( $this->db->query($query)->result() );
	if(isset($_GET['per_page'])){
		$offset = intval($_GET['per_page']);
	}else{
		$offset = 0;
	}
	
	$rec_per_page =  $GLOBALS['global']['PAGINATE_ADMIN']['rec_per_page'];
	
	$query .= " ORDER BY id_report_abuse DESC LIMIT $offset,$rec_per_page";
	
	$record = $this->db->query($query)->result();
	
	$pagination = create_pagination( 
					$uri = "admin/juzon/report/abuse/?reporter=$reporter&to_user=$to_user", 
					$total_rows = $total , 
					$limit= $rec_per_page,
					$uri_segment = 0,
					TRUE, TRUE 
				);
	
?>

<section class="title">
	 <h4>Report Abuse Search </h4>
</section>
	 	 	
<form method='get' action=''>					
	<section class="item">
		<fieldset>
			
			<div class="row-item"> 
				<label> Reporter</label>
				<div class="input">
					<input type="text" name="reporter" value="<?php echo $reporter;?>" />
				</div>
			</div>
			
			<div class="row-item"> 
				<label> To User</label>
				<div class="input">
					<input type="text" name="to_user" value="<?php echo $to_user;?>" />
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
	<div class="top-left">
		<h4>Report Abuse List </h4>
	</div>
	<div class="top-right">
		<ul>
			<li>
				<a href="javascript:void(0);" onclick="callFuncDeleteItem();">Delete</a>
			</li>
		</ul>
	</div>	
</section>
 
<section class="item">
	
	 	 	 	 	
	<table border="0" cellpadding=0 class="table-list clear-both" width="100%">
		<thead>
			<tr>  
				<th><?php echo form_checkbox(array('name' => 'action_to_all', 'class' => 'check-all'));?></th>
				<th>Reporter</th> 
				<th>To User</th>
				<th>Message</th> 
				<th>Date</th> 	
				 
			</tr>
		</thead>
		
		<tbody>
			<?php
				foreach($record as $item):
					$reportdata = $this->user_io_m->init('id_user',$item->id_reporter); 	 	
					$userdata = $this->user_io_m->init('id_user',$item->id_user);
			?> 	
				<tr id="row_<?php echo $item->id_report_abuse;?>"> 	 
					<td><?php echo form_checkbox('action_to[]', $item->id_report_abuse);?></td>
					<td><?php echo $reportdata->username;?></td>
					<td><?php echo $userdata->username;?></td>
					<td><?php echo $item->message;?></td>
					<td><?php echo $item->datetime;?></td>
					
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
	
	function callFuncDeleteItem(){
		var arr = getMultiCheckbox('action_to');
		var str = arr.join(',');
		
		for(var i=0;i<arr.length;i++){
			$('#row_'+arr[i]).fadeOut();
		}
		
		if(arr.length <1){
			return false;
		}
		
		$.post(BASE_URI+'admin/juzon/report/callFuncDeleteReportAbuseItem',{id_str:str},function(res){
					
		});
	}	
</script>
