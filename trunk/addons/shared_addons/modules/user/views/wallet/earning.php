<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<?php 
	if(!isset($trans_type)){
		$trans_type = 0;
	}
	if(isset($_GET['trans_type'])){
		$trans_type = intval($_GET['trans_type']);
	}
	
	$earningWalletTransType = earningWalletCategoriesOptionData_ioc();
	$earningTransArray = $this->wallet_m->getEarningWallet($trans_type);
	
	if(isset($_GET['per_page'])){
		$offset = intval($_GET['per_page']);
	}else{
		$offset = 0;
	}
	
	$pageArray = $this->wallet_m->getEarningWallet($trans_type,$offset,$GLOBALS['global']['PAGINATE']['rec_per_page']);
	
	$pagination = create_pagination( 
					$uri = 'user/wallet_func/callFuncShowEarningTransaction/?trans_type='.$trans_type, 
					$total_rows = count($earningTransArray) , 
					$limit= $GLOBALS['global']['PAGINATE']['rec_per_page'],
					$uri_segment = 0,
					TRUE, TRUE 
				);
?>
<div class="category-item">
	<strong>J$ Earn Type:</strong>
	<?php echo form_dropdown( $name='earning_category', $earningWalletTransType, array( $trans_type ), $extra=" id='earning_category' size='1' onchange='return callFuncChangeTransTypeWallEarning(this.value);' " );?>
	<?php echo loader_image_s("id=\"earningCateContextLoader\" class='hidden'");?>
</div>

<div class="clear"></div>

<table>
	<thead>
		<td width="40%">Earn Type</td>
		<td width="25%">User</td>
		<td width="15%">Earning(J$)</td>
		<td width="20%">Date/Time</td>
	</thead>
	<tbody>
		<?php foreach($pageArray as $item):?>
			<tr>
				<td><?php if($item->trans_type AND isset($earningWalletTransType[$item->trans_type])) echo $earningWalletTransType[$item->trans_type];?></td>
				<td><?php echo $this->user_m->buildNativeLink( $item->owner );?></td>
				<td><?php echo $item->user_amt;?></td>
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
	