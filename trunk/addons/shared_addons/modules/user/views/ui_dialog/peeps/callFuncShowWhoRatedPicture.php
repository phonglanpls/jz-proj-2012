<?php defined('BASEPATH') or exit('No direct script access allowed');?>

<?php 
	$id_photo = $this->input->get('id_photo');
	$ratedArray = $this->rate_m->getPhotoRatedRecord($id_photo);
?>

<table>
	<thead>
		<td style="width:40%;text-align:center;">Who rated</td>
		<td style="width:20%;text-align:center;">Rated</td>
		<td style="width:40%;text-align:center;">Date/time</td>
	</thead>
	<?php foreach($ratedArray as $item):?>
		<tr>
			<td style="text-align:center;"><?php echo $this->user_m->getProfileDisplayName($item->rate_by);?></td>
			<td style="text-align:center;"><?php echo $item->rate ;?></td>
			<td style="text-align:center;"><?php echo juzTimeDisplay($item->rate_date) ;?></td>
		</tr>
	<?php endforeach;?>
</table>

