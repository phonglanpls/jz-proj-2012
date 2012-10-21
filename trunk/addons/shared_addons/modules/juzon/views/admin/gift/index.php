<section class="nav">
	<?php $this->load->view('juzon/admin/nav'); ?> 
</section>

<div class="clear"></div>

<section class="nav">
	<?php $this->load->view('juzon/admin/gift/top_nav'); ?>
</section>

<section class="title">
	<h4>Gift | Search</h4> 
</section>


<?php 
	$name = $this->input->get('name');
	$category = $this->input->get('category');
	
	$query = "SELECT c.cat_name,g.* FROM ".TBL_GIFT." g ,".TBL_CATEGORY." c WHERE (c.id_category=g.id_category) ";
	
	$cond = '';
	if($name){
		$cond .= " AND ( g.name_gift LIKE '%$name%' OR g.description LIKE '%$name%') ";
	}
	if($category){
		$cond .= " AND c.id_category = '$category' ";
	}
	
	$query .= $cond;
	 
	$total = count( $this->db->query($query)->result() );
	if(isset($_GET['per_page'])){
		$offset = intval($_GET['per_page']);
	}else{
		$offset = 0;
	}
	
	$rec_per_page = $GLOBALS['global']['PAGINATE_ADMIN']['rec_per_page'];
	
	$query .= " ORDER BY id_gift DESC LIMIT $offset,$rec_per_page";
	
	$record = $this->db->query($query)->result();
	
	$pagination = create_pagination( 
					$uri = "admin/juzon/gift/?name=$name&category=$category", 
					$total_rows = $total , 
					$limit= $rec_per_page,
					$uri_segment = 0,
					TRUE, TRUE 
				);
	$statusArr = adminStatusItemOptionData_ioc();	
	$path = site_url()."image/thumb/gift/";	 
?>

 	 	 	 	 	
<form method='get' action=''>
						
	<section class="item">
		<fieldset>
			
			<div class="row-item">
				<label>Category</label>
				<div class="input">
					<?php echo form_dropdown('category',$category_arr = $this->juzon_gift_m->getGiftCategoriesArray(),array($category));?>
				</div>
			</div>
			
			<div class="row-item">
				<label>Name</label>
				<div class="input">
					<input type="text" name="name" value="<?php echo $name;?>" />
				</div>
			</div>
			
			<div class="row-item">
				<label>&nbsp;</label>
				<div class="input">
					<input type="submit" value="Search" />
				</div>
			</div>
			
		</fieldset>	
	</section>

</form>


<div class="clear"></div>


<section class="title">
	<?php $this->load->view('juzon/admin/gift/top'); ?> 
</section>
 
<section class="item">
	<table border="0" cellpadding=0 class="table-list clear-both" width="100%">
		<thead>
			<tr> 	 	 	 	 	 	 	 	 	 	
				<th>Category</th> 	 	 	 	 	 	 	
				<th>Name</th> 	 	 	
				<th>Description</th>
				<th>Status</th>
				<th>Price</th>
				<th>Image</th>
				<th class="actions">Edit</th>
				<th class="actions">Delete</th>
			</tr>
		</thead>
		
		<tbody>
			<?php
				foreach($record as $item):
			?>
				<tr id="row_<?php echo $item->id_gift;?>"> 	 	 	 	 	 	 	 	 	 	
					<td><?php echo $item->cat_name;?></td>
					<td><?php echo $item->name_gift;?></td>
					<td><?php echo $item->description;?></td> 	 	
					<td><?php echo $statusArr[$item->status];?></td>
					<td><?php echo $item->price;?></td> 	
					<td><img src="<?php echo $path.$item->image;?>" /></td>
					
					<td class="actions">
						<?php echo admin_load_edit( "onclick='callFuncEditGift({$item->id_gift});'" );?>
						<?php echo admin_loader_image_s("id='edit_pic_loader_{$item->id_gift}'");?>
					</td>
					<td class="actions"><?php echo admin_load_delete( "onclick='callFuncDeleteGift({$item->id_gift});'" );?></td>
			
				</tr>
			<?php endforeach;?>
		</tbody>
		
		<tfoot>
			<td colspan=8>
				<?php echo $pagination['links'];?>
			</td>
		</tfoot>
	</table>	
</section>



<script type="text/javascript">
	jQuery(document).ready(function(){
		$('#pic_loader').hide();
	});
	
	function callFuncEditGift(id_gift){
		$('#edit_pic_loader_'+id_gift).show();
		$.get(BASE_URI+'admin/juzon/gift/callFuncEditGift',{id_gift:id_gift},function(res){
			$('#edit_pic_loader_'+id_gift).hide();
			$('#hiddenElement').html(res);
			$('#hiddenElement').dialog(
				{
					width: 550,
					height:400 ,
					//draggable: false,
					//resizable: false,
					buttons:{},
					title: 'Edit Gift' 
				}
			);
		});
	}
	
	function callFuncAddNewGift(){
		$.get(BASE_URI+'admin/juzon/gift/callFuncAddGift',{},function(res){
			$('#hiddenElement').html(res);
			$('#hiddenElement').dialog(
				{
					width: 550,
					height:400 ,
					//draggable: false,
					//resizable: false,
					buttons:{},
					title: 'Add Gift' 
				}
			);
		});
	}
	
	function callFuncDeleteGift(id_gift){
		$('#row_'+id_gift).fadeOut();
		$.post(BASE_URI+'admin/juzon/gift/callFuncDeleteGift',{id_gift:id_gift},function(res){});
	}
	
</script>
