<style>
    .cometchat_userscontentdot {
        background-position: 0 2px;
        background-repeat: no-repeat;
        float: left;
        height: 16px;
        margin-top: 2px;
        width: 20px;
    }

    .cometchat_offline {
        background-attachment: scroll;
        background-clip: border-box;
        background-color: transparent;
        background-image: url("<?php echo base_url()?>cometchat/themes/default/images/cometchat.png");
        background-origin: padding-box;
        background-position: 0 -1088px !important;
        background-repeat: no-repeat;
        background-size: auto auto;
    }
    
    .cometchat_available {
        background-attachment: scroll;
        background-clip: border-box;
        background-color: transparent;
        background-image: url("<?php echo base_url()?>cometchat/themes/default/images/cometchat.png");
        background-origin: padding-box;
        background-position: 0 -129px !important;
        background-repeat: no-repeat;
        background-size: auto auto;
    }
</style>

<section class="nav">
	<?php $this->load->view('juzon/admin/nav'); ?> 
</section>

<div class="clear"></div>
  

<section class="title">
	<h4>User | Search</h4> 
</section>

<?php 
	$username = $this->input->get('username');
	$name = $this->input->get('name');
	$email = $this->input->get('email');
	$country = $this->input->get('country');
	$age_from = $this->input->get('age_from');
	$age_to = (isset($_GET['age_to']))?intval($_GET['age_to']):100;//$this->input->get('age_to');
	$gender = $this->input->get('gender');
	$join_date_from = $this->input->get('join_date_from');
    $join_date_to = $this->input->get('join_date_to');
    $last_login_from = $this->input->get('last_login_from');
    $last_login_to = $this->input->get('last_login_to');
    
	$query = "SELECT *,floor(datediff(now(),dob)/365.25) as cal_age, CONCAT(first_name,' ',last_name) as fullname,last_login FROM ".TBL_USER." WHERE 1";
	
	$cond = '';
	if($username){
		$cond .= " AND username LIKE '%$username%' ";
	}
	if($name){
		$cond .= " AND CONCAT(first_name,' ',last_name) LIKE '%$name%' ";
	}
	if($email){
		$cond .= " AND email LIKE '$email' ";
	}
	if($country){
		$cond .= " AND id_country = '$country' ";
	}
	if($age_from AND $age_to){
		$cond .= " AND ( floor(datediff(now(),dob)/365.25) >= $age_from AND floor(datediff(now(),dob)/365.25) <= $age_to ) ";
	}
	if( strtolower($gender) == 'male' OR strtolower($gender) == 'female' ){
		$cond .= " AND gender LIKE '$gender' ";
	}
	if($join_date_from AND $join_date_to){
	   $cond .= " AND ( add_date > '$join_date_from' AND add_date < '$join_date_to' ) ";
	}
    if($last_login_from AND $last_login_to){
	   $cond .= " AND ( last_login > '$last_login_from' AND last_login < '$last_login_to' ) ";
	}
	$query .= $cond;
	
	$total = count( $this->db->query($query)->result() );
	if(isset($_GET['per_page'])){
		$offset = intval($_GET['per_page']);
	}else{
		$offset = 0;
	}
	
	$rec_per_page =  $GLOBALS['global']['PAGINATE_ADMIN']['rec_per_page'];
	
	$query .= " ORDER BY id_user DESC LIMIT $offset,$rec_per_page";
	
	$record = $this->db->query($query)->result();
	
	$pagination = create_pagination( 
					$uri = "admin/juzon/user/?username=$username&name=$name&email=$email&country=$country&age_from=$age_from&age_to=$age_to&gender=$gender&join_date_from=$join_date_from&join_date_to=$join_date_to&last_login_from=$last_login_from&last_login_to=$last_login_to", 
					$total_rows = $total , 
					$limit= $rec_per_page,
					$uri_segment = 0,
					TRUE, TRUE 
				);
		
?>

<script type="text/javascript">
    	
	$(function(){
	    $( "#join_date_from,#join_date_to,#last_login_from,#last_login_to" ).datepicker(
			{
				dateFormat: 'yy-mm-dd 00:00:00',
				changeMonth: true,
				changeYear: true ,
		      }	
		);   
      
	});
</script>
 	 	 	 	 	
<form method='get' action=''>
						
	<section class="item">
		<fieldset>
			<div class="row-item">
				<label>Username</label>
				<div class="input">
					<input type="text" name="username" value="<?php echo $username;?>" />
				</div>
			</div>
			
			<div class="row-item">
				<label>Name</label>
				<div class="input">
					<input type="text" name="name" value="<?php echo $name;?>" />
				</div>
			</div>
			
			<div class="row-item">
				<label>Email</label>
				<div class="input">
					<input type="text" name="email" value="<?php echo $email;?>" />
				</div>
			</div>
			
			<div class="row-item">
				<label>Country</label>
				<div class="input">
					<?php echo form_dropdown('country',countryOptionData_ioc(),array($country));?>
				</div>
			</div>
			
			<div class="row-item">
				<label>Age</label>
				<div class="input">
					From
					<?php echo form_dropdown('age_from',ageOptionData_ioc(),array($age_from));?>
					
					&nbsp;&nbsp;
					To
					<?php echo form_dropdown('age_to',ageOptionData_ioc(),array($age_to));?>
				</div>
			</div>
			
			<div class="row-item">
				<label>Gender</label>
				<div class="input">
					<?php echo form_dropdown('gender',genderOptionData_ioc(),array($gender));?>
				</div>
			</div>
            
            <div class="row-item">
				<label>Join date</label>
				<div class="input">
					From 
                    <input type="text" name="join_date_from" id="join_date_from" value="<?php echo $join_date_from;?>" />
                    To
                    <input type="text" name="join_date_to" id="join_date_to" value="<?php echo $join_date_to;?>" />
				</div>
			</div>
			
             <div class="row-item">
				<label>Last Login</label>
				<div class="input">
					From 
                    <input type="text" name="last_login_from" id="last_login_from" value="<?php echo $last_login_from;?>" />
                    To
                    <input type="text" name="last_login_to" id="last_login_to" value="<?php echo $last_login_to;?>" />
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
	<h4>User | List</h4> 
</section>

<section class="item">
	<table border="0" cellpadding=0 class="table-list clear-both" width="100%">
		<thead>
			<tr> 	 	 	 	 	 	 	 	 	 	
				<th>#</th>
				<th>Name</th>
				<th>Username</th>
				<th>Email</th>
				<th>Gender</th>
				<th>Status</th>
				<th>Country</th>
				<th>Cash(J$)</th>
				<th>Dob</th>
				<th>Join Date</th>
				<th>Account</th>				
			</tr>
		</thead>
		
		<tbody>
			<?php
				$iBegin=1+$offset;
				foreach($record as $item):
					$facebookdata = $this->db->where('userid',$item->id_user)->get(TBL_FACEBOOK_CONNECT)->result();
					$twitterdata = $this->db->where('userid',$item->id_user)->get(TBL_TWITTER_CONNECT)->result();
			?>
				<tr id="row_<?php echo $item->id_user;?>"> 	 	 	 	 	 	 	 	 	 	
					<td><?php echo $iBegin++;?></td>
					<td><?php echo $item->fullname;?></td>
					<td>
						<a target="_blank" href="<?php echo site_url("admin/juzon/user/switch_user?username={$item->username}")?>" title="Login site as <?php echo $item->username;?>">
							<?php echo $item->username;?>
						</a>
						
					</td>
					<td>
						<?php echo $item->email;?>
						<?php if($facebookdata):?>
							<br/>
							Facebook connect: 
                            <a target="_blank" href="<?php echo site_url("admin/juzon/user/switch_user_fb?id=".$facebookdata[0]->facebookid)?>">
                                 <?php echo $facebookdata[0]->facebookid;?>
                            </a>
                           
						<?php endif;?>
						
						<?php if($twitterdata):?>
							<br/>
							Twitter connect: 
                            <a target="_blank" href="<?php echo site_url("admin/juzon/user/switch_user_tt?id=".$twitterdata[0]->twitterid)?>">
                                 <?php echo $twitterdata[0]->twitterid;?>
                            </a>
						<?php endif;?>
					</td>
					<td><?php echo $item->gender;?></td>
					<td><?php 
                            if($this->online_m->checkOnlineUser($item->id_user)){
                                echo '<span class="cometchat_userscontentdot cometchat_available"></span>Online';
                            }else{
                                echo $item->last_login;
                            }
                        ?>
                    </td>
					<td>
                        <a href="javascript:void(0);" onclick="callFuncShowGoogleMapUser(<?php echo $item->id_user;?>);"><?php echo $item->country;?></a>
                        <?php echo admin_loader_image_s("id='pic_loader_googlemap_{$item->id_user}'");?>
                    </td>
					<td>
						<a href="javascript:void(0);" onclick="callFuncManageCashUser(<?php echo $item->id_user;?>);">
						<?php echo $item->cash;?>
						</a>
						<?php echo admin_loader_image_s("id='pic_loader_{$item->id_user}'");?>
					</td>
					<td><?php echo birthDay($item->dob);?></td>
					<td><?php echo juzAdminDate($item->add_date);?></td>
					<td>
						<?php 
							if( $item->status == 0){
								$stt = 'Active';
							}else{
								$stt = 'Dective';
							}
						?>
						<a href="javascript:void(0);" onclick="callFuncToggleStatusLock(<?php echo $item->id_user;?>)" id="link_stt_<?php echo $item->id_user;?>"><?php echo $stt;?></a>
						<?php echo admin_loader_image_s("id='link_pic_loader_{$item->id_user}'");?>
					</td>				
				</tr>
			<?php endforeach;?>
		</tbody>
		
		<tfoot>
			<td colspan=13>
				<?php echo $pagination['links'];?>
			</td>
		</tfoot>
	</table>	
</div>


<script type="text/javascript">
	function callFuncToggleStatusLock(id_user){
		$('#link_pic_loader_'+id_user).show();
		$.post(BASE_URI+'admin/juzon/user/callFuncToggleStatusLock',{id_user:id_user},function(res){
			$('#link_pic_loader_'+id_user).hide();
			$('#link_stt_'+id_user).text(res);
		});
	}
	
	function callFuncManageCashUser(id_user){
		$('#pic_loader_'+id_user).show();
		$.get(BASE_URI+'admin/juzon/user/callFuncManageCashUser',{id_user:id_user},function(res){
			$('#pic_loader_'+id_user).hide();
			$('#hiddenElement').html(res);
			$('#hiddenElement').dialog(
				{
					width: 550,
					height:200 ,
					//draggable: false,
					//resizable: false,
					buttons:{},
					title: 'Cash Management ' 
				}
			);
		});
	}
    
    function callFuncShowGoogleMapUser($user_id){
        $('#pic_loader_googlemap_'+$user_id).show();
        $.get(BASE_URI+'admin/juzon/user/callFuncShowGoogleMapUser',{user_id:$user_id},function(res){
			$('#pic_loader_googlemap_'+$user_id).hide();
			$('#hiddenElement').html(res);
			$('#hiddenElement').dialog(
				{
					width: 800,
					height:500 ,
					//draggable: false,
					//resizable: false,
					buttons:{},
					title: 'Google map' 
				}
			);
            $("#gmap").gMap(options);	
		});
    }
</script>










