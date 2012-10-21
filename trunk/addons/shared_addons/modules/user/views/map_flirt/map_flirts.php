<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>

<?php 
	$userdataobj = getAccountUserDataObject();
	
	$mymapflirtsearch = $this->db->where('id_user', getAccountUserId())->get(TBL_MAPFLIRT_SEARCH)->result();
	
	$mygender = $mymapflirtsearch ? $mymapflirtsearch[0]->gender : null;
	$myagefrom = $mymapflirtsearch ? $mymapflirtsearch[0]->age_from : 18;
	$myageto = $mymapflirtsearch ? $mymapflirtsearch[0]->age_to :100;	 	 	
	$mydistance = $mymapflirtsearch ? $mymapflirtsearch[0]->distance : null;
	$mycountry_name = $mymapflirtsearch ? $mymapflirtsearch[0]->country : null;
	$mystatus = $mymapflirtsearch ? $mymapflirtsearch[0]->status : null;
	$mymapvalue = $mymapflirtsearch ? $mymapflirtsearch[0]->map : null;
	$myphoto = $mymapflirtsearch ? $mymapflirtsearch[0]->photo : null;
?>

<div class="filter-split">
	Set <?php echo form_dropdown('mymapvalue',mapValueOptionData_ioc(), array($userdataobj->map_access ), 'id="mymapvalue" ');?>
	J$ per 24 hours for other flirts to access your location. <br/>
	You will earn <?php echo $GLOBALS['global']['MAP_PRICE']['user'];?>% from the total J$ revenue.
</div>

<div class="filter-split" style="border:1px solid #cfcfcf;padding-left:5px;">
	<div class="sep"></div>
	<div class="clear"></div>
	<label><strong>Gender:</strong></label>
	<?php echo form_dropdown("gen", genderOptionData_ioc(), array($mygender), "id='gen'");?>

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

	<label><strong>Map Value:</strong></label>
	<?php echo form_dropdown("mapstatus", mapSearchPetOptionData_ioc(), array(), "id='mapstatus'");?>
	<strong>OR Less than:</strong>
	<?php echo form_dropdown("mapvalue", mapValueOptionData_ioc(), array($mymapvalue), "id='mapvalue'");?>
	
	<div class="sep"></div>
	<div class="clear"></div>
	
	<label><strong>Photo:</strong></label>
	<?php echo form_dropdown("photo", photoSearchPetOptionData_ioc(), array($myphoto), "id='photo'");?>
	
	<div class="sep"></div>
	<div class="clear"></div>
	
	<div style="float:right;margin-right:10px;">
		<?php echo loader_image_s("id=\"searchMapFlirtsContextLoader\" class='hidden'");?> 
		
		<input type="button" value="Search" class="share-2" onclick="callFuncSearchMapFlirts();"/>
		<div class="clear"></div>
	</div>	
	<div class="clear"></div>
</div>

<script type="text/javascript">
	var search_context = 0;
	$(document).ready(function(){
		callFuncSearchMapFlirts();
	});
</script>


<div class="filter-split" id="mapFlirtAsyncDiv">
	
</div>


