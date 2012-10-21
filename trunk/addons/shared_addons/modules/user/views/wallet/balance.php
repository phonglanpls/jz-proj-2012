<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<?php 
	$balanceArray = $this->wallet_m->getBalance();
?>

<div class="clear"></div>

<table>
	<thead>
		<td width="30%">Total Earning(J$)</td>
		<td width="30%">Total Expense(J$)</td>
		<td width="40%">Total Balance(J$)</td>
	</thead>
	<tbody>
		<tr>
			<td><?php echo $balanceArray['total_earn'];?></td>
			<td><?php echo $balanceArray['total_expense'];?></td>
			<td><?php echo currencyDisplay( $balanceArray['total_earn'] - $balanceArray['total_expense'] );?></td>
		</tr>
	</tbody>
</table>	