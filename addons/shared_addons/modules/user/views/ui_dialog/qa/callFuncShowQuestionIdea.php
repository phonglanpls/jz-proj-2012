<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>

<?php 
	$questionIdea = $this->qa_m->getQuestionIdea();
?>


<div id="wrap-dialog-box">	
	
		
	<table>
		<thead>
			<td width="100%">Click to choose one item...</td>
		</thead>
		<tbody>
			<?php foreach($questionIdea as $item):?>
				<?php $ques = mysql_real_escape_string($item->question);?>
				<tr>
					<td>
						<a href="javascript:void(0);" onclick="callFuncInsertIntoQuestionArea('<?php echo $ques;?>')"><?php echo $item->question;?></a>
					</td>
				</tr>
			<?php endforeach;?>
		</tbody>
	</table>
	
</div>	