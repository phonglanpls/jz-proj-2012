 <script type="text/javascript" src="<?php echo site_url();?>/media/js/random_message.js"></script> 
 
 <aside>
    <?php 
		$this->load->view("user/leftsite/user_info");
	?>    	
    
	<div class="clear"></div>
    
	<?php 
		$this->load->view("user/leftsite/user_nav");
	?>         
    
	<div class="clear"></div>
	
	<div id="randomMessageUIAsync">
		<?php 
			$this->load->view("user/leftsite/user_secret");
		?>   	
	</div>
    <div class="clear"></div>
	
	<?php 
		$this->load->view("user/leftsite/owner");
	?>    
	<div class="clear"></div>
	
    <?php 
		$this->load->view("user/leftsite/friends_list");
	?>    
	<div class="clear"></div>
	
	<div class="widget" style="position:relative;">
		<div id="petlistBoxAsync">
			<?php 
				$this->load->view("user/leftsite/pets_list");
			?> 
		</div>
	</div>

	<div class="clear"></div>	
    	
	<div class="widget">
		<h4><?php echo language_translate('left_menu_label_wishlist');?></h4>
		<div id="wishlistBoxAsync">
			<?php $this->load->view("user/leftsite/wishlist_async");?>
		</div>
	</div>	
         
            
</aside>