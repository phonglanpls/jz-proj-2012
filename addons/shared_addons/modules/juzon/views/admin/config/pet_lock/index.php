<section class="nav">
	<?php $this->load->view('juzon/admin/nav'); ?> 
</section>

<div class="clear"></div>

<section class="nav">
	<?php $this->load->view('juzon/admin/config/top_nav'); ?>
</section>


<section class="title">
	<?php $this->load->view('juzon/admin/config/pet_lock/top'); ?> 
</section>

<?php 
	$total = count( $this->db->get(TBL_PETLOCK)->result() );
	if(isset($_GET['per_page'])){
		$offset = intval($_GET['per_page']);
	}else{
		$offset = 0;
	}
	
	$rec_per_page =  $GLOBALS['global']['PAGINATE_ADMIN']['rec_per_page'];
	
	$record = $this->db->order_by('id_petlock','desc')->limit($rec_per_page,$offset)->get(TBL_PETLOCK)->result();
	
	$pagination = create_pagination( 
					$uri = 'admin/juzon/config/pet_lock/?', 
					$total_rows = $total , 
					$limit= $rec_per_page,
					$uri_segment = 0,
					TRUE, TRUE 
				);
	$path = site_url()."image/thumb/";
	$statusArr = adminStatusItemOptionData_ioc();
?>

 	 	 	 	 	
 
<section class="item">
	<table border="0" class="table-list clear-both">
		<thead>
			<tr>
				<th>Name</th>
				<th>Image</th>
				<th>Price(J$)</th>
				<th>Charge per day(J$)</th>
				<th>Status</th>
				<th class="actions">Edit</th>
				<th class="actions">Delete</th>
			</tr>
		</thead>
		
		<tbody>
			<?php foreach($record as $item):?>
				<tr id="row_<?php echo $item->id_petlock;?>">
					<td><?php echo $item->name;?></td>
					<td><img src="<?php echo $path.$item->image;?>" /></td>
					<td><?php echo $item->price;?></td>
					<td><?php echo $item->chargeperday ;?></td>
					<td>
						<?php 
							if( $item->status == 1){
								$stt = 'Deactive';
							}else{
								$stt = 'Active';
							}
							$stt = $statusArr[$item->status];
						?>
						<a href="javascript:void(0);" onclick="callFuncToggleStatusLock(<?php echo $item->id_petlock;?>)" id="link_stt_<?php echo $item->id_petlock;?>"><?php echo $stt;?></a>
						<?php echo admin_loader_image_s("id='link_pic_loader_{$item->id_petlock}'");?>
					</td>
					<td class="actions">
						<?php echo admin_load_edit( "onclick='callFuncEditLock({$item->id_petlock});'" );?>
						<?php echo admin_loader_image_s("id='pic_loader_{$item->id_petlock}'");?>
					</td>
					<td class="actions"><?php echo admin_load_delete( "onclick='callFuncDeleteLock({$item->id_petlock});'" );?></td>
				</tr>
			<?php endforeach;?>
		</tbody>
		
		<tfoot>
			<td colspan=7>
				<?php echo $pagination['links'];?>
			</td>
		</tfoot>
	</table>
	
</section>



<script type="text/javascript">
	
	function callFuncEditLock(id_petlock){
		$('#pic_loader_'+id_petlock).show();
		$.get(BASE_URI+'admin/juzon/config/callFuncOpenDialogEditLock',{id_petlock:id_petlock},function(res){
			$('#pic_loader_'+id_petlock).hide();
			$('#hiddenElement').html(res);
			$('#hiddenElement').dialog(
				{
					width: 550,
					height:350 ,
					//draggable: false,
					//resizable: false,
					buttons:{},
					title: 'Edit Lock Pet' 
				}
			);
		});
	}
	
	function callFuncAddNewPetLock(){
		$.get(BASE_URI+'admin/juzon/config/callFuncOpenDialogAddNewLock',{},function(res){
			$('#hiddenElement').html(res);
			$('#hiddenElement').dialog(
				{
					width: 550,
					height:350 ,
					//draggable: false,
					//resizable: false,
					buttons:{},
					title: 'Add New Lock Pet' 
				}
			);
		});
	}
	
	function callFuncDeleteLock(id_petlock){
		$('#row_'+id_petlock).fadeOut();
		$.post(BASE_URI+'admin/juzon/config/callFuncDeleteLock',{id_petlock:id_petlock},function(res){
					
		});
	}
	
	function callFuncToggleStatusLock(id_lock){
		$('#link_pic_loader_'+id_lock).show();
		$.post(BASE_URI+'admin/juzon/config/callFuncToggleStatusLock',{id_petlock:id_lock},function(res){
			$('#link_pic_loader_'+id_lock).hide();
			$('#link_stt_'+id_lock).text(res);
		});
	}
</script>










