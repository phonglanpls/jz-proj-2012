	<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
	
	<script type="text/javascript" src="<?php echo site_url();?>/media/js/qa.js"></script> 
	
	<div id="body-content">
       <?php 
			$this->load->view("user/partial/left");
	   ?>
        
        <div id="body">
        	<div class="body">
            	<div id="content">
                	<?php $this->load->view("user/partial/top"); ?>
					<div class="clear"></div>
					
					 <div class="filter-split">
						<a href="javascript:void(0);" onclick="callFuncShowQuestions();"><strong><?php echo language_translate('askme_menu_label_question');?></strong></a>
						<?php echo loader_image_s("id=\"questionContextLoader\" class='hidden'");?> 
						|
						<a href="javascript:void(0);" onclick="callFuncShowAnswers();"><strong><?php echo language_translate('askme_menu_label_answer');?></strong></a>
						<?php echo loader_image_s("id=\"answerContextLoader\" class='hidden'");?> 
						|
						<a href="javascript:void(0);" onclick="callFuncShowAksFriends();"><strong><?php echo language_translate('askme_menu_label_ask_friends');?></strong></a>
						<?php echo loader_image_s("id=\"askFriendsContextLoader\" class='hidden'");?> 
					 </div>
					 
					 <div class="clear"></div>
					 
					 <div class="filter-split">
						<div id="askmeAsyncDiv">
							<?php $this->load->view("user/askme/question");?>
						</div>
					 </div>
                </div>
            </div>
           <?php $this->load->view("user/partial/right");?>
        </div>
        <div class="clear"></div>
		
    </div>
    <?php 
        $section = $this->input->get('s');
        if($section == 'answer'){
            $jsFunc = 'callFuncShowAnswers()';
        }
        if($section == 'friend'){
            $jsFunc = 'callFuncShowAksFriends()';
        }
        if($section == 'question'){
            $jsFunc = 'callFuncShowQuestions()';
        }
        
        if(isset($jsFunc)):
    ?>
        <script type="text/javascript">
            $(function(){
                <?php echo $jsFunc;?>;
            });
        </script>
    <?php endif;?>