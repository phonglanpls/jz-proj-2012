<?php if (!defined('BASEPATH')) exit('No direct script access allowed'); ?>

<?php 
	$friend_ids = $city = $limit = $my_chat = $country = null;
	$my_chat = $userdataobj->id_user;
	$result = $userdataobj;
	
	if($this->input->get('per_page') != ''){
		$limit = intval($this->input->get('per_page'))*15;
	}
	
	$sql_post = $this->wall_m->get_all_post($result,$friend_ids,$city,$limit,$my_chat,$country);
	$res = $this->db->query($sql_post)->result();
	$this->load->view( 'user/wall/feed_content', array('res'=>$res) ); 
	$feed_count = count($res);
?>

<script type="text/javascript">
	var FEEDCOUNT = <?php echo $feed_count;?>;
</script>
 
