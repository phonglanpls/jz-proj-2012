<section class="nav">
	<?php $this->load->view('juzon/admin/nav'); ?> 
</section>

<div class="clear"></div>

<section class="nav">
	<?php $this->load->view('juzon/admin/hentai/top_nav'); ?>
</section>

<section class="title">
	<?php $this->load->view('juzon/admin/hentai/top'); ?> 
</section>

<?php 
	$record = $this->db->get(TBL_HENTAI_CATEGORY)->result();
	$statusArr = adminStatusItemOptionData_ioc();
?>
 
<section class="item">
	<fieldset>
		<legend>Enable Hentai</legend>	
		<div class="row-item">
			<label> Status</label>
			<div class="input">
				<a href="javascript:void(0);" id="hentai_status" onclick="callFuncToggleHentaiSection();"><?php echo $statusArr[$GLOBALS['global']['HENTAI']['show']];?></a>	
				<?php echo admin_loader_image_s("id='hentai_status_loader'");?>
			</div>
		</div>
	</fieldset>
	<div class="clear"></div>
	
	<table border="0" cellpadding=0 class="table-list clear-both" width="100%">
		<thead>
			<tr> 	 	 	 	 	 	 	 	 	 	
				<th>Category</th> 
				<th>Status</th> 	
				<th class="actions">Edit</th>
			</tr>
		</thead>
		
		<tbody>
			<?php
				foreach($record as $item):
			?>
				<tr id="row_<?php echo $item->id_hentai_category;?>"> 	 	 	 	 	 	 	 	 	 	
					<td><?php echo $item->category_name;?></td>
					<td><?php echo $statusArr[$item->status];?></td>
					<td class="actions">
						<?php echo admin_load_edit( "onclick='callFuncEditCategory({$item->id_hentai_category});'" );?>
						<?php echo admin_loader_image_s("id='edit_pic_loader_{$item->id_hentai_category}'");?>
					</td>
				</tr>
			<?php endforeach;?>
		</tbody>
		
	</table>	
</section>



<script type="text/javascript">
		
	function callFuncEditCategory(id_hentai_category){
		$('#edit_pic_loader_'+id_hentai_category).show();
		$.get(BASE_URI+'admin/juzon/hentai/callFuncEditCategory',{id_hentai_category:id_hentai_category},function(res){
			$('#edit_pic_loader_'+id_hentai_category).hide();
			$('#hiddenElement').html(res);
			$('#hiddenElement').dialog(
				{
					width: 550,
					height:230 ,
					//draggable: false,
					//resizable: false,
					buttons:{},
					title: 'Edit Category' 
				}
			);
		});
	}
	
	function callFuncToggleHentaiSection(){
		$('#hentai_status_loader').show();
		$.get(BASE_URI+'admin/juzon/config/callFuncToggleHentaiSection',{},function(res){
			$('#hentai_status_loader').hide();
			$('#hentai_status').text(res);
		});
	}
</script>
