<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>

<?php 
	$questionArray = $this->qa_m->getUnreadQuestion(getAccountUserId());
?>

<table>
	<thead>
		<td width="50%"><?php echo language_translate('question_table_head_questions');?></td>
		<td width="15%"><?php echo language_translate('question_table_head_askby');?></td>
		<td width="15%"><?php echo language_translate('question_table_head_datetime');?></td>
		<td width="10%"><?php echo language_translate('question_table_head_answer');?></td>
		<td width="10%"><?php echo language_translate('question_table_head_delete');?></td>
	</thead>
	<tbody>
		<?php foreach($questionArray as $item):?>
			<tr id="askmeQuestionItem_<?php echo $item->id_askmeq;?>">
				<td><?php echo maintainHtmlBreakLine($item->question);?></td>
				<td>
					<?php 
						if($item->asked_by){
							echo $this->user_m->getProfileDisplayName($item->asked_by);
						}else{
							echo "Anonymous";
						}		
					?>
				</td>
				<td><?php echo juzTimeDisplay($item->ques_date);?></td>
				<td><a href="javascript:void(0);" onclick="callFuncAnswerQuestion(<?php echo $item->id_askmeq;?>)"><?php echo language_translate('question_button_answer');?></a></td>
				<td><a href="javascript:void(0);" onclick="callFuncDeleteQuestion(<?php echo $item->id_askmeq;?>)"><?php echo language_translate('question_button_delete');?></a></td>
			</tr>
		<?php endforeach;?>
	</tbody>
</table>