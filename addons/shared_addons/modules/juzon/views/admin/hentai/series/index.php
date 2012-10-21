<section class="nav">
	<?php $this->load->view('juzon/admin/nav'); ?> 
</section>

<div class="clear"></div>

<section class="nav">
	<?php $this->load->view('juzon/admin/hentai/top_nav'); ?>
</section>

<section class="title">
	<h4>Hentai | Series Filter</h4> 
</section>


<?php 
	$id_hentai_category = $this->input->get('id_hentai_category');
	$name = $this->input->get('name');
	
	$id_hentai_category = ($id_hentai_category>0)?$id_hentai_category:0;
	
	$query = "SELECT c.category_name,s.* FROM ".TBL_HENTAI_CATEGORY." c ,".TBL_SERIES." s WHERE c.id_hentai_category = s.id_hentai_category ";
	
	$cond = '';
	if($name){
		$cond .= " AND s.name LIKE '%$name%' ";
	}
	if($id_hentai_category){
		$cond .= " AND s.id_hentai_category = '$id_hentai_category' ";
	}
	
	$query .= $cond;
	 
	$total = count( $this->db->query($query)->result() );
	if(isset($_GET['per_page'])){
		$offset = intval($_GET['per_page']);
	}else{
		$offset = 0;
	}
	
	$rec_per_page =  $GLOBALS['global']['PAGINATE_ADMIN']['rec_per_page'];
	
	$query .= " ORDER BY id_series DESC LIMIT $offset,$rec_per_page";
	
	$record = $this->db->query($query)->result();
	
	$pagination = create_pagination( 
					$uri = "admin/juzon/hentai/series/?name=$name&id_hentai_category=$id_hentai_category", 
					$total_rows = $total , 
					$limit= $rec_per_page,
					$uri_segment = 0,
					TRUE, TRUE 
				);
			
?>
	 	 	 	 	
<form method='get' action=''>
						
	<section class="item">
		<fieldset>
			
			<div class="row-item">
				<label>Category</label>
				<div class="input">
					<?php echo form_dropdown('id_hentai_category',$this->juzon_hentai_m->getHentaiCategoriesArray(),array($id_hentai_category));?>
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
					<input type="reset" value="Reset" />
				</div>
			</div>
			
		</fieldset>	
	</section>

</form>

<div class="clear"></div>

<section class="title">
	<?php $this->load->view('juzon/admin/hentai/series/top'); ?> 
</section>
 
<section class="item">
	<table border="0" cellpadding=0 class="table-list clear-both" width="100%">
		<thead>
			<tr> 	 	 	 	 	 	 	 	 	 	 	 	 	 	
				<th>Category</th> 	
				<th>Series Name</th> 
				<th>Image</th> 	
				<th class="actions">Edit</th> 	
				<th class="actions">Delete</th> 	
			</tr>
		</thead>
		
		<tbody>
			<?php
				foreach($record as $item):
					if($item->id_hentai_category == 4){
						$thumbPath = site_url().'image/thumb/hentai/dailymotion/'.$item->image.'.jpg';
					}else{
						$thumbPath = $item->img_url;
					}	
			?>
				<tr id="row_<?php echo $item->id_series;?>"> 	 	 	 	 	 	 	 	 	 	
					<td><?php echo $item->category_name;?></td>
					<td><?php echo $item->name;?></td>
					<td><img src="<?php echo $thumbPath;?>" /></td>
					
					<td class="actions">
						<?php echo admin_load_edit( "onclick='callFuncEditSeries({$item->id_series});'" );?>
						<?php echo admin_loader_image_s("id='edit_pic_loader_{$item->id_series}'");?>
					</td>
					
					<td class="actions">
						<?php echo admin_load_delete( "onclick='callFuncDeleteSeries({$item->id_series});'" );?>
					</td>
				</tr>
			<?php endforeach;?>
		</tbody>
		
		<tfoot>
			<td colspan=5>
				<?php echo $pagination['links'];?>
			</td>
		</tfoot>
		
	</table>	
</section>


<script type="text/javascript">
		
	function callFuncEditSeries(id_series){
		$('#edit_pic_loader_'+id_series).show();
		$.get(BASE_URI+'admin/juzon/hentai/callFuncEditSeries',{id_series:id_series},function(res){
			$('#edit_pic_loader_'+id_series).hide();
			$('#hiddenElement').html(res);
			$('#hiddenElement').dialog(
				{
					width: 550,
					height:400 ,
					//draggable: false,
					//resizable: false,
					buttons:{},
					title: 'Edit Item' 
				}
			);
		});
	}
	
	function callFuncAddNewSeries(){
		$.get(BASE_URI+'admin/juzon/hentai/callFuncAddNewSeries',{},function(res){
			$('#hiddenElement').html(res);
			$('#hiddenElement').dialog(
				{
					width: 550,
					height:400 ,
					//draggable: false,
					//resizable: false,
					buttons:{},
					title: 'Add Item' 
				}
			);
		});
	}
	
	function callFuncDeleteSeries(id_series){
		$('#row_'+id_series).fadeOut();
		$.post(BASE_URI+'admin/juzon/hentai/callFuncDeleteSeries',{id_series:id_series},function(res){
		});
	}
</script>
