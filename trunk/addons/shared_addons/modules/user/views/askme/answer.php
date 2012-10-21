<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>

<?php 
	$answerArray = $this->qa_m->getAnswers(getAccountUserId());
?>

<table>
	<thead>
		<td width="60%"><?php echo language_translate('answer_table_head_questions');?></td>
		<td width="15%"><?php echo language_translate('answer_table_head_askby');?></td>
		<td width="15%"><?php echo language_translate('question_table_head_datetime');?></td>
		<td width="10%"><?php echo language_translate('question_table_head_delete');?></td>
	</thead>
	<tbody>
		<?php foreach($answerArray as $item):?>
			<?php $questionRecord = $this->qa_m->getRecord_Question($item->id_askmeq);?>
			<tr id="askmeQuestionItem_<?php echo $item->id_askmeq;?>">
				<td>
					<strong><?php echo language_translate('answer_acr_question');?></strong> <?php echo maintainHtmlBreakLine($questionRecord->question);?>
					<div class="clear"></div>
					<div class="borderSep"></div>
					<div class="clear"></div>
					<strong><?php echo language_translate('answer_acr_answer');?></strong> <?php echo maintainHtmlBreakLine($item->answer);?>
				</td>
				<td>
					<?php 
						if($item->asked_by){
							echo $this->user_m->getProfileDisplayName($item->asked_by);
						}else{
							echo language_translate("answer_acr_anonymous");
						}		
					?>
				</td>
				<td><?php echo juzTimeDisplay($item->ans_date);?></td>
				<td><a href="javascript:void(0);" onclick="callFuncDeleteQuestion(<?php echo $item->id_askmeq;?>)"><?php echo language_translate('question_button_delete');?></a></td>
			</tr>
		<?php endforeach;?>
	</tbody>
</table>