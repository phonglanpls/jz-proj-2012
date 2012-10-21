<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>

<?php 
	$current_dbprefix = $this->db->dbprefix;
	$this->db->set_dbprefix('');
	 
	$listBlockChat = $this->db->where('fromid',getAccountUserId())->get('cometchat_block')->result();
	
	$this->db->set_dbprefix($current_dbprefix);
?>

<table>
	<thead>
		<td><?php echo language_translate('chat_block_label_username');?></td>
		<td width="70px;"><?php echo language_translate('accessmap_label_thead_action');?></td>
	</thead>
	
		<?php foreach($listBlockChat as $item):?>
			<tr id="id_<?php echo $item->toid;?>">
				<td>
					<div class="user-profile-username">
						<?php echo $this->user_m->getProfileDisplayName($item->toid);?>
					</div>
				</td>	
			
				<td>
					<a href="javascript:void(0);" onclick="sysConfirm('<?php echo language_translate('sys_button_delete_confirm');?>','callFuncDeleteChatBlock(<?php echo $item->toid;?>)');" ><?php echo language_translate('sys_button_title_delete');?></a>
				</td>
			</tr>	
		<?php endforeach;?>
	</table>	