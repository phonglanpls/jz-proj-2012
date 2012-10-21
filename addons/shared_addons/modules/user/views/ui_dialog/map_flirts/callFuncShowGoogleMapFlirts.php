<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>

<script type="text/javascript" src="<?php echo site_url();?>/media/js/jquery.gmap.js"></script> 

<?php 
/*
<script src="https://www.google.com/jsapi?key=ABQIAAAAKNy9jiLs8gd-R75jb5PC5BTMNjZ5kIwLaBRsDZ8wTaOfjEA-AxQ34C53sb_x7AOjh0epJWs2x3G1bQ" type="text/javascript"></script>

<script type="text/javascript" src="http://maps.google.com/maps?file=api&amp;v=2&amp;key=AIzaSyA52J4wEK_WKx1FEm9R3z9M70_dFSabeMQ"></script>

*/
	$listMyMapFlists = $this->mapflirt_m->getListMyMapFlirts();
	
	$data = array();
	$i=$j=0;
	$min=10000000;
	
	$mydataobj = getAccountUserDataObject();
	foreach($listMyMapFlists as $item){
		$userdataobj = $this->user_io_m->init('id_user',$item->id_seller);
		
		$data[$i]['html'] = "<b>".$userdataobj->username."</b><br/>";
        $data[$i]['html'] .= "<b>".cal_age($userdataobj->dob).', '.$userdataobj->gender."</b><br/>";
        $data[$i]['html'] .= "<div class='filter-split'><a class=\"button\" onclick=\"jqcc.cometchat.chatWith('{$item->id_seller}');\" href=\"javascript:void(0);\">Chat</a></div>";
        /*
		if($userdataobj->address){
			$data[$i]['html'] .= mysql_real_escape_string( $userdataobj->address );
		}
		if($userdataobj->city){
			$data[$i]['html'] .= mysql_real_escape_string( $userdataobj->city ).'<br/>';
		}
		if($userdataobj->state){
			$data[$i]['html'] .= mysql_real_escape_string( $userdataobj->state ).'<br/>';
		}
		if($userdataobj->country){
			$data[$i]['html'] .= mysql_real_escape_string( $userdataobj->country ).'<br/>';
		}
        */
		$data[$i]['icon']['image'] = $this->user_m->getCommentAvatar($userdataobj->id_user);
		$data[$i]['icon']['iconsize'] = array(40,40);
		$data[$i]['icon']['iconanchor'] = array(12,46);
		$data[$i]['icon']['infowindowanchor'] = array(12,0);
		
		$data[$i]['longitude'] = $userdataobj->longitude; 	
		$data[$i]['latitude'] = $userdataobj->latitude;
		
		$distance[$i] = $this->geo_lib->distance($mydataobj->latitude, $mydataobj->longitude, $userdataobj->latitude, $userdataobj->longitude, 'K');
		if($distance[$i]<= $min){
			$min=$distance[$i];
			$j=$i;
		}					
		//$data[$i]['popup'] = true; 
		//$data[$i]['gender'] = $userdataobj->gender;
		//$data[$i]['dob'] = $userdataobj->dob;
		$i++;
	}
	
?>
 
<div class="wrap-dialog-box" id="gmap" style="width:800px;height:500px;">	
	
</div>	

<script type="text/javascript">
	<?php if(!empty($data)):?>
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
			zoom: 4,
			centerAt: { latitude: <?php echo $data[$j]['latitude'];?>, longitude: <?php echo $data[$j]['longitude'];?>, zoom: 4 }
		};
	<?php else:?>	
		var options = {};
	<?php endif;?>
</script>