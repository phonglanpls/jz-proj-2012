<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>

<?php 
	$listLock = $this->db->where('status',1)->get(TBL_PETLOCK)->result();
	$imagePath = site_url()."image/thumb/";
?>

<?php $i=1; foreach($listLock as $item):?>
	<div class="pet-lock-item">
		<div class="user-profile-avatar">
			<img src="<?php echo $imagePath.$item->image;?>" />
		</div>
		
		<div class="user-profile-username">
			<?php echo $item->name;?>
		</div>
		
		<div class="user-profile-username">
			<strong>Price:</strong> <?php echo currencyDisplay($item->price);?>J$
		</div>
		
		<div class="user-profile-username">
			Duration Charge per day: <?php echo currencyDisplay($item->chargeperday);?>J$
		</div>
		
		<div class="user-profile-username">
			Lock type:
			<div class="clear"></div>
			<?php echo form_dropdown("lock_type_{$item->id_petlock}", lockTypeOptionData_ioc($item->price),
										array(), "id='lock_type_ID_{$item->id_petlock}' onchange='callFuncCalTotalPrice({$item->price},{$item->chargeperday},this.value,{$item->id_petlock});' " ); ?>
		</div>
		
		<div class="user-profile-username">
			<input type="radio" name="locktype" value="<?php echo $item->id_petlock;?>" />
			<div class="clear"></div>
			<span id="totalPrice_<?php echo $item->id_petlock;?>"></span>
		</div>
	</div>
	
	<?php if( $i%4 == 0 ):?>
		<div class="clear"></div>
	<?php endif;?>	
	
	<?php $i++;?>
<?php endforeach ;?>