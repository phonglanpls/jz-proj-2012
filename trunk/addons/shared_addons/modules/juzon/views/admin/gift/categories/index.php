<section class="nav">
	<?php $this->load->view('juzon/admin/nav'); ?> 
</section>

<div class="clear"></div>

<section class="nav">
	<?php $this->load->view('juzon/admin/gift/top_nav'); ?>
</section>


<section class="title">
	<?php $this->load->view('juzon/admin/gift/categories/top'); ?> 
</section>

<?php 
	$record = $this->db->order_by('id_category')->get(TBL_CATEGORY)->result();
	$statusArr = adminStatusItemOptionData_ioc();	
?>

 
<section class="item">
	<table border="0" class="table-list clear-both">
		<thead>
			<tr>
				<th>Category</th>
				<th>Status</th>
				<th class="actions">Edit</th>
				<th class="actions">Delete</th>
			</tr>
		</thead>
		
		<tbody>
			<?php foreach($record as $item):?>
				<tr id="row_<?php echo $item->id_category;?>">
					<td><?php echo $item->cat_name;?></td>
					<td><?php echo $statusArr[$item->status];?></td>
					<td class="actions">
						<?php echo admin_load_edit( "onclick='callFuncEditCategory({$item->id_category});'" );?>
						<?php echo admin_loader_image_s("id='edit_pic_loader_{$item->id_category}'");?>
					</td>
					<td class="actions"><?php echo admin_load_delete( "onclick='callFuncDeleteCategory({$item->id_category});'" );?></td>
				</tr>
			<?php endforeach;?>
		</tbody>
		
	</table>
	
</section>



<script type="text/javascript">
	jQuery(document).ready(function(){
		$('#pic_loader').hide();
	});
	
	function callFuncEditCategory(id_category){
		$('#edit_pic_loader_'+id_category).show();
		$.get(BASE_URI+'admin/juzon/gift/callFuncEditCategory',{id_category:id_category},function(res){
			$('#edit_pic_loader_'+id_category).hide();
			$('#hiddenElement').html(res);
			$('#hiddenElement').dialog(
				{
					width: 550,
					height:250 ,
					//draggable: false,
					//resizable: false,
					buttons:{},
					title: 'Edit Category' 
				}
			);
		});
	}
	
	function callFuncAddNewCategory(){
		$.get(BASE_URI+'admin/juzon/gift/callFuncAddNewCategory',{},function(res){
			$('#hiddenElement').html(res);
			$('#hiddenElement').dialog(
				{
					width: 550,
					height:250 ,
					//draggable: false,
					//resizable: false,
					buttons:{},
					title: 'Add New Category' 
				}
			);
		});
	}
	
	function callFuncDeleteCategory(id_category){
		$('#row_'+id_category).fadeOut();
		$.post(BASE_URI+'admin/juzon/gift/callFuncDeleteCategory',{id_category:id_category},function(res){
					
		});
	}
</script>










