<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>

<?php 
	
?>

	<label><strong>User name:</strong></label>
	<input type="text" name="name" id="name" maxlength="45" />

	<div class="sep"></div>
	<div class="clear"></div>

	<div style="float:right;margin-right:10px;">
		<?php echo loader_image_s("id=\"searchPetsContextLoader\" class='hidden'");?> 
		
		<input type="button" value="Search" class="share-2" onclick="callFuncSearchPets2();"/>
		<div class="clear"></div>
		
		<div class="sep"></div>
		<a href="javascript:void(0);" onclick="callFuncBackToSearchDefault();" >Default search</a>
		
	</div>	
	<div class="clear"></div>