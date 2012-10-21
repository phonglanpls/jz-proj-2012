	<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
	
	<script type="text/javascript" src="<?php echo site_url();?>/media/js/wall.js"></script> 
	
	<?php 
		$id_wall = intval($this->uri->segment(3,0));
		
		$friend_ids = $city = $limit = $my_chat = $country = null;
		$result = getAccountUserDataObject(true);
		$sql_post = $this->wall_m->get_all_post($result,$friend_ids,$city,$limit,$my_chat,$country,$id_wall);
		$res = $this->db->query($sql_post)->result();
	?>
	
	<div id="body-content">
       <?php 
			$this->load->view("user/partial/left");
	   ?>
        
        <div id="body">
        	<div class="body">
            	<div id="content">
                	<?php $this->load->view("user/partial/top"); ?>
					<div class="clear"></div>
					
					<div id="asyncSectionFeed">
						<?php $this->load->view( 'user/wall/feed_content', array('res'=>$res, 'contextcm'=>'all') ); ?> 
					</div>	
                </div>
            </div>
           <?php $this->load->view("user/partial/right");?>
        </div>
        <div class="clear"></div>
		
    </div>