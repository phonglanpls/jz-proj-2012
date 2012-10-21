<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>

<?php 
	$this->load->model('user/user_m');
    
	$userdataobj = $this->user_io_m->init('id_user',$this->input->get('user_id'));
	
	$data[0]['html'] = "<b>".$userdataobj->username."</b><br/>";
   
	if($userdataobj->address){
		$data[0]['html'] .= mysql_real_escape_string( $userdataobj->address );
	}
	if($userdataobj->city){
		$data[0]['html'] .= mysql_real_escape_string( $userdataobj->city ).'<br/>';
	}
	if($userdataobj->state){
		$data[0]['html'] .= mysql_real_escape_string( $userdataobj->state ).'<br/>';
	}
	if($userdataobj->country){
		$data[0]['html'] .= mysql_real_escape_string( $userdataobj->country ).'<br/>';
	}
 
	$data[0]['icon']['image'] = $this->user_m->getCommentAvatar($userdataobj->id_user);
	$data[0]['icon']['iconsize'] = array(40,40);
	$data[0]['icon']['iconanchor'] = array(12,46);
	$data[0]['icon']['infowindowanchor'] = array(12,0);
	
	$data[0]['longitude'] = $userdataobj->longitude; 	
	$data[0]['latitude'] = $userdataobj->latitude;
	
	//$data[$i]['popup'] = true; 
	//$data[$i]['gender'] = $userdataobj->gender;
	//$data[$i]['dob'] = $userdataobj->dob;
	
?>
 
<div class="wrap-dialog-box" id="gmap" style="width:800px;height:500px;">	
	
</div>	

<script type="text/javascript">
	var options = {
			controls: {
				   panControl: true,
				   zoomControl: true,
				   mapTypeControl: true,
				   scaleControl: true,
				   streetViewControl: true,
				   overviewMapControl: true
			   },
			scrollwheel: true,
			maptype: 'TERRAIN',
			markers: <?php echo json_encode($data);?>,
			zoom: 9,
			centerAt: { latitude: <?php echo $data[0]['latitude'];?>, longitude: <?php echo $data[0]['longitude'];?>, zoom: 9 }
		};
		
	$(document).ready(function() {
		//$("#gmap").gMap(options);		
	});

</script>