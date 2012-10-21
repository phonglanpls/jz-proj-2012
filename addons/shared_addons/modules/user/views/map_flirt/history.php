<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>

<div class="filter-split">
	<a href="javascript:void(0);" onclick="callFuncShowHistory_YOUBOUGHTOTHER();">You bought others</a> 
		<?php echo loader_image_s("id='historyYOUBOUGHTOTHERcontextLoader' class='hidden'");?>
	|
	<a href="javascript:void(0);" onclick="callFuncShowHistory_OTHERBOUGHTYOU();">Others bought you</a>
		<?php echo loader_image_s("id='historyOTHERBOUGHTYOUcontextLoader' class='hidden'");?>
</div>

<?php 
    $section = $this->input->get('s');
?>

<div class="filter-split" id="historyAsyncDiv">
	<?php 
         
        if($section == 'spc1'){ // show other bought you section
            $this->load->view("map_flirt/history_other_bought_you");
        }else{
           $this->load->view("map_flirt/history_you_bought_other"); 
        }
    ?>
</div>

<script type="text/javascript">
</script>

