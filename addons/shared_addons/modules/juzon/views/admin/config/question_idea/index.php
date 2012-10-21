<section class="nav">
	<?php $this->load->view('juzon/admin/nav'); ?> 
</section>

<div class="clear"></div>

<section class="nav">
	<?php $this->load->view('juzon/admin/config/top_nav'); ?>
</section>


<section class="title">
	<?php $this->load->view('juzon/admin/config/question_idea/top'); ?> 
</section>

<?php 
	$total = count( $this->db->get(TBL_QUESTION_DEF)->result() );
	if(isset($_GET['per_page'])){
		$offset = intval($_GET['per_page']);
	}else{
		$offset = 0;
	}
	
	$rec_per_page =  $GLOBALS['global']['PAGINATE_ADMIN']['rec_per_page'];
	
	$record = $this->db->order_by('id_question','desc')->limit($rec_per_page,$offset)->get(TBL_QUESTION_DEF)->result();
	
	$pagination = create_pagination( 
					$uri = 'admin/juzon/config/question_idea/?', 
					$total_rows = $total , 
					$limit= $rec_per_page,
					$uri_segment = 0,
					TRUE, TRUE 
				);
?>

 
<section class="item">
	<table border="0" class="table-list clear-both">
		<thead>
			<tr>
				<th>Question</th>
				<th class="actions">Edit</th>
				<th class="actions">Delete</th>
			</tr>
		</thead>
		
		<tbody>
			<?php foreach($record as $item):?>
				<tr id="row_<?php echo $item->id_question;?>">
					<td><?php echo $item->question;?></td>
					<td class="actions">
						<?php echo admin_load_edit( "onclick='callFuncEditQuestion({$item->id_question});'" );?>
						<?php echo admin_loader_image_s("id='pic_loader_{$item->id_question}'");?>
					</td>
					<td class="actions"><?php echo admin_load_delete( "onclick='callFuncDeleteQuestion({$item->id_question});'" );?></td>
				</tr>
			<?php endforeach;?>
		</tbody>
		
		<tfoot>
			<td colspan=3>
				<?php echo $pagination['links'];?>
			</td>
		</tfoot>
	</table>
	
</section>



<script type="text/javascript">
	jQuery(document).ready(function(){
		$('#pic_loader').hide();
	});
	
	function callFuncEditQuestion(id_ques){
		$('#pic_loader_'+id_ques).show();
		$.get(BASE_URI+'admin/juzon/config/callFuncOpenDialogEditQuestion',{id_ques:id_ques},function(res){
			$('#pic_loader_'+id_ques).hide();
			$('#hiddenElement').html(res);
			$('#hiddenElement').dialog(
				{
					width: 550,
					height:250 ,
					//draggable: false,
					//resizable: false,
					buttons:{},
					title: 'Edit Question Idea' 
				}
			);
		});
	}
	
	function callFuncAddNewQuestion(){
		$.get(BASE_URI+'admin/juzon/config/callFuncOpenDialogAddNewQuestion',{},function(res){
			$('#hiddenElement').html(res);
			$('#hiddenElement').dialog(
				{
					width: 550,
					height:250 ,
					//draggable: false,
					//resizable: false,
					buttons:{},
					title: 'Add New Question Idea' 
				}
			);
		});
	}
	
	function callFuncDeleteQuestion(id_question){
		$('#row_'+id_question).fadeOut();
		$.post(BASE_URI+'admin/juzon/config/callFuncDeleteQuestion',{id_question:id_question},function(res){
					
		});
	}
</script>










