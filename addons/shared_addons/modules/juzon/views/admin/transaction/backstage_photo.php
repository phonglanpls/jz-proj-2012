 
<?php 
    $path = site_url().'image/orig/photos/';
?>

    <table border="0" cellpadding=0 class="table-list clear-both" width="100%">
		<thead>
			<tr> 	 	 	 	 	 	 	 	 	 	
				<th>Owner</th>
				<th>User</th> 	 	 	
				<th>Amount</th>
				<th>Admin Amount</th>
				<th>Owner Amount</th>
				<th>Date</th>
                <th>URL</th>
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
                    <td><a href="javascript:void(0);" onclick="viewBackstagePhoto('<?php echo $path.$item->image;?>');">Photo</a></td>
				</tr>
			<?php endforeach;?>
		</tbody>
		
		<tfoot>
			<td colspan=7>
				<?php echo $pagination['links'];?>
			</td>
		</tfoot>
	</table>
    
    
 <script type="text/javascript">
    function viewBackstagePhoto($image){
         //$('#pic_loader_googlemap_'+$user_id).show();
        //$.get(BASE_URI+'admin/juzon/user/callFuncShowGoogleMapUser',{user_id:$user_id},function(res){
			//$('#pic_loader_googlemap_'+$user_id).hide();
			$('#hiddenElement').html("<img src='"+$image+"' />");
			$('#hiddenElement').dialog(
				{
					width: 800,
					height:500 ,
					//draggable: false,
					//resizable: false,
					buttons:{},
					title: 'Backstage Photo' 
				}
			);
             
		//});
    }
</script>