<section class="nav">
	<?php $this->load->view('juzon/admin/nav'); ?> 
</section>

<div class="clear"></div>

<section class="nav">
	<?php $this->load->view('juzon/admin/report/top_nav'); ?>
</section>


<?php 
	$ip = $this->input->get('ip');
	
	$query = "SELECT * FROM ".TBL_BLOCKEDIP_LOGIN." WHERE 1" ;
	$cond = '';
	if($ip){
		$cond .= " AND ip LIKE '$ip' ";
	}
	
	$query .= $cond;
	
	$total = count( $this->db->query($query)->result() );
	if(isset($_GET['per_page'])){
		$offset = intval($_GET['per_page']);
	}else{
		$offset = 0;
	}
	
	$rec_per_page =  $GLOBALS['global']['PAGINATE_ADMIN']['rec_per_page'];
	
	$query .= " ORDER BY id_blockedip_login DESC LIMIT $offset,$rec_per_page";
	
	$record = $this->db->query($query)->result();
	
	$pagination = create_pagination( 
					$uri = "admin/juzon/report/blockedip/?ip=$ip", 
					$total_rows = $total , 
					$limit= $rec_per_page,
					$uri_segment = 0,
					TRUE, TRUE 
				);
	
?>

<section class="title">
	 <h4>IP Search </h4>
</section>
	 	 	
<form method='get' action=''>					
	<section class="item">
		<fieldset>
			
			<div class="row-item"> 
				<label> IP</label>
				<div class="input">
					<input type="text" name="ip" value="<?php echo $ip;?>" />
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
		<h4>Blocked IP </h4>
	</div>

	<div class="top-right">
		<ul>
			<li>
				<a href="javascript:void(0);" onclick="callFuncAddIP();">Add</a>
			</li>
		</ul>
	</div>	
</section>
 
<section class="item">
	
	 	 	 	 	
	<table border="0" cellpadding=0 class="table-list clear-both" width="100%">
		<thead>
			<tr>  	 	
				<th>IP</th> 
				<th class="actions">Delete </th> 
			</tr>
		</thead>
		
		<tbody>
			<?php
				foreach($record as $item):
			?> 	
				<tr id="row_<?php echo $item->id_blockedip_login;?>"> 	 
					<td><?php echo $item->ip;?></td>
					<td class="actions"><?php echo admin_load_delete( "onclick='callFuncDeleteIP({$item->id_blockedip_login});'" );?></td>
				</tr>
			<?php endforeach;?>
		</tbody>
		
		<tfoot>
			<td colspan=2>
				<?php echo $pagination['links'];?>
			</td>
		</tfoot>
		
	</table>	
</section>



<script type="text/javascript">
	function callFuncDeleteIP(id_blockedip_login){
		$('#row_'+id_blockedip_login).fadeOut();
		
		$.post(BASE_URI+'admin/juzon/report/callFuncDeleteIP',{id_blockedip_login:id_blockedip_login},function(res){
		});
	}	
	
	function callFuncAddIP(){
		$.get(BASE_URI+'admin/juzon/report/callFuncOpenDialogAddIP',{},function(res){
			$('#hiddenElement').html(res);
			$('#hiddenElement').dialog(
				{
					width: 550,
					height:150 ,
					//draggable: false,
					//resizable: false,
					buttons:{},
					title: 'Add New IP Blocked' 
				}
			);
		});
	}
	
</script>
