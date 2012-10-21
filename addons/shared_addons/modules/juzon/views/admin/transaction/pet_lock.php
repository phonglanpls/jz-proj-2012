

    <table border="0" cellpadding=0 class="table-list clear-both" width="100%">
		<thead>
			<tr> 	 	 	 	 	 	 	 	 	 	
				<th>Owner</th>
				<th>User</th> 	 	 	
				<th>Amount</th>
				<th>Admin Amount</th>
				<th>User Amount</th>
				<th>Date</th>
                 
			</tr>
		</thead>
		
		<tbody>
			<?php
				foreach($record as $item):
					$ownerdata = $this->user_io_m->init('id_user',$item->id_owner); 	
					$userdata = $this->user_io_m->init('id_user',$item->id_user); 
			?>
				<tr id="row_<?php echo $item->id_transaction;?>"> 	 	 	 	 	 	 	 	 	 	
					<td><?php echo $ownerdata->username;?></td>
					<td><?php echo $userdata->username;?></td>
					<td><?php echo $item->amount;?></td> 	 	
					<td><?php echo $item->site_amt;?></td>
					<td><?php echo $item->user_amt;?></td>
					<td><?php echo $item->trans_date;?></td>
              	</tr>
			<?php endforeach;?>
		</tbody>
		
		<tfoot>
			<td colspan=6>
				<?php echo $pagination['links'];?>
			</td>
		</tfoot>
	</table>
    
    
 <script type="text/javascript">
    
</script>