<section class="nav">
	<?php $this->load->view('juzon/admin/nav'); ?> 
</section>

<div class="clear"></div>

<section class="nav">
	<?php $this->load->view('juzon/admin/report/top_nav'); ?>
</section>


<?php 
	$username = $this->input->get('username');
	
	$query = "SELECT * FROM ".TBL_LOGIN." WHERE 1" ;
	$cond = '';
	if($username){
		$cond .= " AND username LIKE '$username' ";
	}
	
	$query .= $cond;
	
	$total = count( $this->db->query($query)->result() );
	if(isset($_GET['per_page'])){
		$offset = intval($_GET['per_page']);
	}else{
		$offset = 0;
	}
	
	$rec_per_page =  $GLOBALS['global']['PAGINATE_ADMIN']['rec_per_page'];
	
	$query .= " ORDER BY id_login DESC LIMIT $offset,$rec_per_page";
	
	$record = $this->db->query($query)->result();
	
	$pagination = create_pagination( 
					$uri = "admin/juzon/report/login/?username=$username", 
					$total_rows = $total , 
					$limit= $rec_per_page,
					$uri_segment = 0,
					TRUE, TRUE 
				);
	
?>

<section class="title">
	 <h4>Login User Search </h4>
</section>
	 	 	
<form method='get' action=''>					
	<section class="item">
		<fieldset>
			
			<div class="row-item"> 
				<label> Username</label>
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


<section class="title">
	<div class="top-left">
		<h4>Login User Details </h4>
	</div>

	<div class="top-right">
		<ul>
			<li>
				<a href="javascript:void(0);" onclick="callFuncDeleteLoginItem();">Delete</a>
			</li>
		</ul>
	</div>	
</section>
 
<section class="item">
	
	 	 	 	 	
	<table border="0" cellpadding=0 class="table-list clear-both" width="100%">
		<thead>
			<tr>  	 	
				<th><?php echo form_checkbox(array('name' => 'action_to_all', 'class' => 'check-all'));?></th>
				<th>Username</th> 
				<th>IP Address</th> 
				<th>Date</th> 
				<th>Email</th> 
				<th>Status </th> 
			</tr>
		</thead>
		
		<tbody>
			<?php
				foreach($record as $item):
			?> 	
				<tr id="row_<?php echo $item->id_login;?>"> 	 
					<td><?php echo form_checkbox('action_to[]', $item->id_login);?></td>
					<td><?php echo $item->username;?></td>
					<td><?php echo $item->ip;?></td>
					<td><?php echo $item->date_login;?></td> 	 	
					<td><?php echo $item->email;?></td>
					<td>
						<?php 
							if( $item->status == 1){
								echo 'Logged In';
							}else{
								echo 'Failure login';
							}
						?>
					</td>
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
	function callFuncDeleteLoginItem(){
		var arr = getMultiCheckbox('action_to');
		var str = arr.join(',');
		
		for(var i=0;i<arr.length;i++){
			$('#row_'+arr[i]).fadeOut();
		}
		
		if(arr.length <1){
			return false;
		}
		
		$.post(BASE_URI+'admin/juzon/report/callFuncDeleteLoginItem',{id_str:str},function(res){
					
		});
	}	
	
</script>
