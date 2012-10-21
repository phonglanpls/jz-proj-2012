<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>

<?php 
	$mypetsearch = $this->db->where('id_user', getAccountUserId())->get(TBL_PETSEARCH)->result();
	
	$myprice = $mypetsearch ? $mypetsearch[0]->pric : null;
	$mygender = $mypetsearch ? $mypetsearch[0]->gen : null;
	$mysortby = $mypetsearch ? $mypetsearch[0]->sb : null;
	$myagefrom = $mypetsearch ? $mypetsearch[0]->agefrom : 18;
	$myageto = $mypetsearch ? $mypetsearch[0]->ageto :100;	 	 	
	$mydistance = $mypetsearch ? $mypetsearch[0]->distance : null;
	$mycountry_name = $mypetsearch ? $mypetsearch[0]->country_name : null;
	$mystatus = $mypetsearch ? $mypetsearch[0]->status : null;
	//$mymapvalue = $mypetsearch ? $mypetsearch[0]->mapvalue : null;
	$myphoto = $mypetsearch ? $mypetsearch[0]->photo : null;
?>

	<label><strong>Pet Prices:</strong></label>
	<?php echo form_dropdown("pric", petPricesOptionData_ioc(), array($myprice), "id='pric'");?>

	<div class="sep"></div>
	<div class="clear"></div>
	<label><strong>Gender:</strong></label>
	<?php echo form_dropdown("gen", genderOptionData_ioc(), array($mygender), "id='gen'");?>

	<div class="sep"></div>
	<div class="clear"></div>
	<label><strong>Sort By:</strong></label>
	<?php echo form_dropdown("sb", petSearchSortByDataOption_ioc(), array($mysortby), "id='sb'");?>

	<div class="sep"></div>
	<div class="clear"></div>
	<label><strong>Age Range:</strong></label>
	From 
	<?php echo form_dropdown("agefrom", ageOptionData_ioc(), array($myagefrom), "id='agefrom'");?>
	To 
	<?php echo form_dropdown("ageto", ageOptionData_ioc(), array($myageto), "id='ageto'");?>

	<div class="sep"></div>
	<div class="clear"></div>
	<label><strong>Distance From Me:</strong></label>
	<?php echo form_dropdown("distance", distanceDataOption_ioc(), array($mydistance), "id='distance'");?>

	<strong>OR Country:</strong>	
	<?php echo form_dropdown("country_name", countrySearchPetOptionData_ioc(), array($mycountry_name), "id='country_name'");?>
	<div class="sep"></div>
	<div class="clear"></div>

	<label><strong>Status:</strong></label>
	<?php echo form_dropdown("status", statusSearchPetOptionData_ioc(), array($mystatus), "id='status'");?>
	<div class="sep"></div>
	<div class="clear"></div>
<!--
	<label><strong>Map Value:</strong></label>
	<?php //echo form_dropdown("mapstatus", mapSearchPetOptionData_ioc(), array(), "id='mapstatus'");?>
	<strong>OR Less than:</strong>
	<?php //echo form_dropdown("mapvalue", mapValueOptionData_ioc(), array($mymapvalue), "id='mapvalue'");?>
-->
	<div class="sep"></div>
	<div class="clear"></div>
	<label><strong>Photo:</strong></label>
	<?php echo form_dropdown("photo", photoSearchPetOptionData_ioc(), array($myphoto), "id='photo'");?>

	<div class="sep"></div>
	<div class="clear"></div>

	<div style="float:right;margin-right:10px;">
		<?php echo loader_image_s("id=\"searchPetsContextLoader\" class='hidden'");?> 
		
		<input type="button" value="Search" class="share-2" onclick="callFuncSearchPets();"/>
		<input type="button" value="Reset"  class="share-2" onclick="callFuncResetSearch();"/>
		
		<div class="clear"></div>
		
		<div class="sep"></div>
		<a href="javascript:void(0);" onclick="callFuncChangeSearchMode();" >Change search</a>
		
	</div>	
	<div class="clear"></div>