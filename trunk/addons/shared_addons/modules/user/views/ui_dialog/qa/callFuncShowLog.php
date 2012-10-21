<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>

<?php 
	$id_user = $this->input->get('id_user');
	$logArr = $this->qa_m->getLog($id_user);
?>


<div id="wrap-dialog-box">	
	
		
	<table>
		<thead>
			<td width="100%">Questions/Answers</td>
		</thead>
		<tbody>
			<?php foreach($logArr as $item):?>
				<tr>
					<td>
						<strong>Q:</strong> <?php echo $item->question;?>
						<div class="clear"></div>
						<div class="borderSep"></div>
						<div class="clear"></div>
						<strong>A:</strong> <?php echo $item->answer;?>
					</td>
				
				</tr>
			<?php endforeach;?>
		</tbody>
	</table>
	
</div>	