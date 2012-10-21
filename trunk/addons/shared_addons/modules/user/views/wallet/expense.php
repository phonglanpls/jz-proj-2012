<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<?php 
	if(!isset($trans_type)){
		$trans_type = 0;
	}
	if(isset($_GET['trans_type'])){
		$trans_type = intval($_GET['trans_type']);
	}
	
	$expenseWalletTransType = expenseWalletCategoriesOptionData_ioc();
	$expenseTransArray = $this->wallet_m->getExpenseWallet($trans_type);
	
	if(isset($_GET['per_page'])){
		$offset = intval($_GET['per_page']);
	}else{
		$offset = 0;
	}
	
	$pageArray = $this->wallet_m->getExpenseWallet($trans_type,$offset,$GLOBALS['global']['PAGINATE']['rec_per_page']);
	
	$pagination = create_pagination( 
					$uri = 'user/wallet_func/callFuncShowExpenseTransaction/?trans_type='.$trans_type, 
					$total_rows = count($expenseTransArray) , 
					$limit= $GLOBALS['global']['PAGINATE']['rec_per_page'],
					$uri_segment = 0,
					TRUE, TRUE 
				);
?>
<div class="category-item">
	<strong>J$ Expense Type:</strong>
	<?php echo form_dropdown( $name='expense_category', $expenseWalletTransType, array( $trans_type ), $extra=" id='expense_category' size='1' onchange='return callFuncChangeTransTypeWallExpense(this.value);' " );?>
	<?php echo loader_image_s("id=\"expenseCateContextLoader\" class='hidden'");?>
</div>

<div class="clear"></div>

<table>
	<thead>
		<td width="40%">Expense Type</td>
		<td width="25%">User</td>
		<td width="15%">Expense(J$)</td>
		<td width="20%">Date/Time</td>
	</thead>
	<tbody>
		<?php foreach($pageArray as $item):?>
			<tr>
				<td><?php if($item->trans_type) echo $expenseWalletTransType[$item->trans_type];?></td>
				<td><?php echo $this->user_m->buildNativeLink( $item->owner );?></td>
				<td><?php echo $item->amount;?></td>
				<td><?php echo juzTimeDisplay( $item->trans_date );?></td>
			</tr>
		<?php endforeach;?>
	</tbody>
</table>

<div class="clear"></div>

<div class="pagination">
	<?php echo $pagination['links'];?>
	<?php echo loader_image_s("id=\"paginationContextLoader\" class='hidden'");?>
</div>	

