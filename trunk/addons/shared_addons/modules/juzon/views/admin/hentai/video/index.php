<section class="nav">
	<?php $this->load->view('juzon/admin/nav'); ?> 
</section>

<div class="clear"></div>

<section class="nav">
	<?php $this->load->view('juzon/admin/hentai/top_nav'); ?>
</section>

<section class="title">
	<h4>Hentai | Video Filter</h4> 
</section>


<?php 
	$id_hentai_category = $this->input->get('id_hentai_category');
	$series = $this->input->get('series');
	
	$id_hentai_category = ($id_hentai_category>0)?$id_hentai_category:0;
	
	$query = "SELECT c.category_name,s.name as sname,v.* FROM ".TBL_HENTAI_CATEGORY." c ,".TBL_SERIES." s,".TBL_VIDEO." v WHERE c.id_hentai_category = s.id_hentai_category AND s.id_series=v.id_series";
	
	$cond = '';
	if($series){
		$cond .= " AND s.name LIKE '%$series%' ";
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
	
	$query .= " ORDER BY id_video DESC LIMIT $offset,$rec_per_page";
	
	$record = $this->db->query($query)->result();
	
	$pagination = create_pagination( 
					$uri = "admin/juzon/hentai/video/?series=$series&id_hentai_category=$id_hentai_category", 
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
				<label>Series</label>
				<div class="input">
					<input type="text" name="series" value="<?php echo $series;?>" />
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
	<?php $this->load->view('juzon/admin/hentai/video/top'); ?> 
</section>
 
<section class="item">
	<table border="0" cellpadding=0 class="table-list clear-both" width="100%">
		<thead>
			<tr> 	 	 	 	 	 	 	 	 	 	 	 	 	 	
				<th>Category</th> 	
				<th>Series Name</th> 
				<th>Video Name</th> 	
				<th class="actions">Edit</th> 	
				<th class="actions">Delete</th> 	
			</tr>
		</thead>
		
		<tbody>
			<?php
				foreach($record as $item):
			?>
				<tr id="row_<?php echo $item->id_video;?>"> 	 	 	 	 	 	 	 	 	 	
					<td><?php echo $item->category_name;?></td>
					<td><?php echo $item->sname;?></td>
					<td><?php echo $item->name;?></td>
					
					<td class="actions">
						<?php echo admin_load_edit( "onclick='callFuncEditVideo({$item->id_video});'" );?>
						<?php echo admin_loader_image_s("id='edit_pic_loader_{$item->id_video}'");?>
					</td>
					
					<td class="actions">
						<?php echo admin_load_delete( "onclick='callFuncDeleteVideo({$item->id_video});'" );?>
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
		
	function callFuncEditVideo(id_video){
		$('#edit_pic_loader_'+id_video).show();
		$.get(BASE_URI+'admin/juzon/hentai/callFuncEditVideo',{id_video:id_video},function(res){
			$('#edit_pic_loader_'+id_video).hide();
			$('#hiddenElement').html(res);
			$('#hiddenElement').dialog(
				{
					width: 550,
					height:350 ,
					//draggable: false,
					//resizable: false,
					buttons:{},
					title: 'Edit Item' 
				}
			);
		});
	}
	
	function callFuncAddNewVideo(){
		$.get(BASE_URI+'admin/juzon/hentai/callFuncAddNewVideo',{},function(res){
			$('#hiddenElement').html(res);
			$('#hiddenElement').dialog(
				{
					width: 550,
					height:350 ,
					//draggable: false,
					//resizable: false,
					buttons:{},
					title: 'Add Item' 
				}
			);
		});
	}
	
	function callFuncDeleteVideo(id_video){
		$('#row_'+id_video).fadeOut();
		$.post(BASE_URI+'admin/juzon/hentai/callFuncDeleteVideo',{id_video:id_video},function(res){
		});
	}
</script>
