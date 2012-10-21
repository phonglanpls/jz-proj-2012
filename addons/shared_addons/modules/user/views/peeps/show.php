<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>

<?php 
	$search_type = $this->input->get('search_type');
	$sort_by = $this->input->get('sort_by');
	
	if(isset($_GET['per_page'])){
		$offset = intval($_GET['per_page']);
	}else{
		$offset = 0;
	}
	
	if(!isset($id_user)){
		$id_user = getAccountUserId();
	}
 
	$total = count($this->peep_m->showPeep($id_user, $search_type, $sort_by));
	$searchArray = $this->peep_m->showPeep($id_user, $search_type, $sort_by,$offset,$GLOBALS['global']['PAGINATE']['rec_per_page']);
	
	$pagination = create_pagination( 
					$uri = "user/peeps/show/?search_type=$search_type&sort_by=$sort_by", 
					$total_rows = $total , 
					$limit= $GLOBALS['global']['PAGINATE']['rec_per_page'],
					$uri_segment = 0,
					TRUE, TRUE 
				);
	$path = site_url()."image/thumb/photos/"; 
?>

<?php 
	if(!$total){
		echo "No Such Records Founds....";
		exit;
	}	
?>

<?php if($search_type == 'checked_me'):?>
	
	<table>
		<thead>
			<tr>
				<td width="150px" style="text-align:center;">Who Checked On</td> 
				<td width="150px" style="text-align:center;">How many times</td>
				<td width="150px" style="text-align:center;">Last Visit</td>			 	
			</tr>
		</thead>
		<?php foreach($searchArray as $item):?>
			<tr>
				<td style="text-align:center;">
					<div class="user-profile-username filter-split" style="padding: 3px;margin:0px;">
						<?php echo $this->user_m->getProfileDisplayName($item->id_visitor);?>
                        
                        <?php if($item->id_visitor != getAccountUserId() AND $item->id_visitor != 1): ?>
                            <br /><br />
                            <a class="button" id="sendGift" onclick="jqcc.cometchat.chatWith('<?php echo $item->id_visitor;?>');" href="javascript:void(0);">Chat</a>
					   <?php endif;?>
                    </div>
				</td> 
				<td style="text-align:center;">
					<?php echo $item->number_count;?>
				</td>
				
				<td style="text-align:center;">
					<?php echo juzTimeDisplay( $item->lvisit );?>
				</td>	
			</tr>
		<?php endforeach;?>
	</table>

<?php endif;?>


<?php if($search_type == 'normal_photo'):?>
	
	<table>
		<thead>
			<tr> 	
				<td width="150px" style="text-align:center;">Normal Photo</td> 
				<td width="150px" style="text-align:center;">Average Rating</td>
				<td width="150px" style="text-align:center;">How many people rate</td>			 	
			</tr>
		</thead>
		<?php foreach($searchArray as $item):?>
			<tr>
				<td style="text-align:center;">
					<div class="user-profile-avatar">
						<img src="<?php echo $path.$item->image;?>" />
					</div>
				</td> 
				<td style="text-align:center;">
					<?php echo $item->rating;?>
				</td>
				
				<td style="text-align:center;">
					<a href="javascript:void(0);" onclick="javascript:callFuncShowWhoRatedPicture(<?php echo $item->id_image;?>);"><?php echo $item->rate_num;?></a>
				</td>	
			</tr>
		<?php endforeach;?>
	</table>

<?php endif;?>


<?php if($search_type == 'backstage_photo'):?>
	
	<table>
		<thead>
			<tr> 	
				<td width="150px" style="text-align:center;">Backstage Photo</td> 
				<td width="150px" style="text-align:center;">Average Rating</td>
				<td width="150px" style="text-align:center;">How many people rate</td>			 	
			</tr>
		</thead>
		<?php foreach($searchArray as $item):?>
			<tr>
				<td style="text-align:center;">
					<div class="user-profile-avatar">
						<img src="<?php echo $path.$item->image;?>" />
					</div>
				</td> 
				<td style="text-align:center;">
					<?php echo $item->rating;?>
				</td>
				
				<td style="text-align:center;">
					<a href="javascript:void(0);" onclick="javascript:callFuncShowWhoRatedPicture(<?php echo $item->id_image;?>);"><?php echo $item->rate_num;?></a>
				</td>	
			</tr>
		<?php endforeach;?>
	</table>

<?php endif;?>


<div class="clear"></div>
<div class="pagination">
	<?php echo $pagination['links'];?>
	<?php echo loader_image_s("id=\"paginationContextLoader\" class='hidden'");?>
</div>	
