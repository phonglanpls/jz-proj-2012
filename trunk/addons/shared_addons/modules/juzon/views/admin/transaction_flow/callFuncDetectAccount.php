<?php 
	$userlisting = $this->db->query("SELECT * FROM ".TBL_USER." WHERE status=0 AND id_admin=0")->result();
	foreach($userlisting as $item){
		$this->user_io_m->userSyncCashAndValue($item->id_user);
	}
	
	$userlistingabuse = $this->db->query("SELECT * FROM ".TBL_USER." WHERE status=0 AND id_admin=0 AND cash<0")->result();
?>

<div id="dialog-wrap">
	<table>
		<?php foreach($userlistingabuse as $item):?>	
			<tr>
				<td>
					<?php echo $item->username;?>
				</td>
				<td>
					<?php echo $item->cash;?>
				</td>
			</tr>
		<?php endforeach;?>
	</table>
</div>


<script type="text/javascript">
	jQuery(document).ready(function(){
	
	});
</script>