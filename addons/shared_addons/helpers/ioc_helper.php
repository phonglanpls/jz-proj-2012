<?php  if (!defined('BASEPATH')) exit('No direct script access allowed');
global $global; 
$global = globalConfig_ioc();

function getGlobalConfig(){
	$ci = &get_instance();
	$array_config = array();
	
	$rs = $ci->db->get(TBL_CONFIG)->result();
	foreach($rs as $item){
		$array_config[$item->name][$item->ckey] = $item->value;
	}
	@unlink('./conf/globalArrayConfig.txt');
	file_put_contents( './conf/globalArrayConfig.txt', serialize($array_config) ); 	 
}

function globalConfig_ioc(){
	$ci = &get_instance();
	$array_config = array();
	$temp = read_file('./conf/globalArrayConfig.txt'); 
	if ( !$temp ){
		die('Config file need to create.');
		//getGlobalConfig();
	}
	return unserialize( $temp );
}

function genderOptionData_ioc(){
	return array(
		'Both'		=>  'Both',
		'Male'		=>	'Male',
		'Female'	=>  'Female'
	);
}

function rangeAgeOptionData_ioc(){
	$array = array();
	$array[''] = 'All';
	foreach($GLOBALS['global']['FRIEND_BYAGE'] as $k=>$v){
		$array[$v] = $v;
	}
	return $array;
}

function ageOptionData_ioc(){
	$array = array();
	for($i=18;$i<=100;$i++){
		$array[$i] = $i;
	}
	return $array;
}

function countryOptionData_ioc($country_id=0){
	$ci = &get_instance();
	if($country_id){
		$rs = $ci->db->where('id_country',$country_id)->order_by('country_name','ASC')->get(TBL_COUNTRY)->result();
		return array($rs[0]->id_country => $rs[0]->country_name);
	}else{
		$rs = $ci->db->order_by('country_name','ASC')->get(TBL_COUNTRY)->result();
		$array[0] = '-Select-';
		foreach($rs as $item){
			$array[$item->id_country] = $item->country_name;
		}
		return $array;
	}
}

function stateOptionData_ioc($country_id=0, $state_id=0){
	$ci = &get_instance();
	if(!$country_id){
		return array();
	}
	if($state_id){
		$rs = $ci->db->where('id_country',$country_id)->where('id_state',$state_id)->order_by('state_name','ASC')->get(TBL_STATE)->result();
		return array($rs[0]->id_state => $rs[0]->state_name);
	}
	
	$rs = $ci->db->where('id_country',$country_id)->order_by('state_name','ASC')->get(TBL_STATE)->result();
	$array[-1] = '-Select-';
	foreach($rs as $item){
		$array[$item->id_state] = $item->state_name;
	}
	return $array;
}

function cityOptionData_ioc($country_id=0, $state_id=0, $city_id=0){
	$ci = &get_instance();
	if(!$country_id OR !$state_id){
		return array();
	}
	if($city_id){
		$rs = $ci->db->where('id_state',$state_id)->where('id_city',$city_id)->order_by('city_name','ASC')->get(TBL_CITY)->result();
		return array($rs[0]->id_city => $rs[0]->city_name);
	}
	
	$rs = $ci->db->where('id_state',$state_id)->order_by('city_name','ASC')->get(TBL_CITY)->result();
	$array[-1] = '-Select-';
	foreach($rs as $item){
		$array[$item->id_city] = $item->city_name;
	}
	$array[-2] = 'Other';
	return $array;
}

function earningWalletCategoriesOptionData_ioc(){
	$arr[0]='-Select-';
	$arr[1]='Backstage Photo';
	$arr[2]='Backstage Video';
	$arr[3]='Pet';
	$arr[4]='Message';
	$arr[5]='Flirt';
	$arr[6]='Gift';
	$arr[7]='Pet Lock';
	$arr[8]='Map Flirts';
	$arr[9]='Admin Add/Reduce';
	$arr[10]='Cash Add';
	$arr[11]='Referrals Join';
	$arr[12]='New User Join';
	$arr[13]='Pet sold';
	$arr[14]='Download';
	$arr[15]='Peeped';
	$arr[16]='Favorite';
	return $arr;
} 

function expenseWalletCategoriesOptionData_ioc(){
	$arr[0]='-Select-';
	$arr[1]='Backstage Photo';
	$arr[2]='Backstage Video';
	$arr[3]='Pet';
	$arr[4]='Message';
	$arr[5]='Flirt';
	$arr[6]='Gift';
	$arr[7]='Pet Lock';
	$arr[8]='Map Flirts';
	$arr[9]='Admin Add/Reduce';
     
	if(getAccountUserId() == 1 ){			
		$arr[11]='Referrals Join';
		$arr[12]='New User Join';	
	}
	$arr[14]='Download';
	$arr[15]='Peeped';
	$arr[16]='Favorite';
	return $arr;
}

function friendByGroupOptionData_ioc(){
	$arr['all friends'] = 'All Friends';
	$arr['recently added'] = 'Recently Added';
	$arr['upcoming birthdays'] = 'Upcoming Birthdays';
	return $arr;
}

function timezoneDataOption_ioc(){
	$ci = &get_instance();
	$res = $ci->db->get(TBL_TIMEZONE)->result();
	$arr[''] 	= '-Select-';
	foreach($res as $item){
		$arr[$item->GMT] 	= $item->name;
	}
	return $arr;
}

function petPricesOptionData_ioc(){
	$arr['allprices']	=	'All Prices';
	$arr['afdprices']	=	'Affordable Prices';
	return $arr;
}

function petSearchSortByDataOption_ioc(){
	$arr['recentact'] = 'Recent Active';
	$arr['mostexp'] = 'Most Expensive';
	return $arr;
}

function distanceDataOption_ioc(){
	$arr['0'] 		= 'Don\'t Care';
	$arr['3000']	=	'3000 Km';
	$arr['1000']	=	'1000 Km';
	$arr['500']		=	'500 Km';
	$arr['300']		=	'300 Km';
	$arr['100']		=	'100 Km';
	return $arr;
}

function countrySearchPetOptionData_ioc(){
	$arr['0'] = 'Don\'t Care';
	foreach(countryOptionData_ioc() as $k=>$v){
		$arr[$v]	=	$v;
	}
	return $arr;
}

function statusSearchPetOptionData_ioc(){
	$arr['0'] = 'Don\'t Care';
	$arr['1'] = 'Online Only';
	return $arr;
}

function mapSearchPetOptionData_ioc(){
	$arr['0']	=	'Don\'t Care';
	return $arr;
}

function mapValueOptionData_ioc(){
	$arr[0] = 'Select';
	for($i=1;$i<=100;$i++){
		$arr[$i] = $i."J$";
	}
	return $arr;
}

function peepValueOptionData_ioc(){
	$arr[0] = 'Select';
	for($i=1;$i<=100;$i++){
		$arr[$i] = $i."J$";
	}
	return $arr;
}

function photoSearchPetOptionData_ioc(){
	$arr['0'] = 'Don\'t Care';
	$arr['1'] = 'With Photo ';
	return $arr;
}

function lockTypeOptionData_ioc($price){
	$arr[0] = "-Select-";
	$arr[1] = $price."J$ x 1 day";
	$arr[3] = $price."J$ x 3 days";
	$arr[5] = $price."J$ x 5 days";
	$arr[7] = $price."J$ x 7 days";
	return $arr;
}

function rateValueOptionData_ioc(){
	$arr[0] = 1;
	$arr[1] = 2;
	$arr[2] = 3;
	$arr[3] = 4;
	$arr[4] = 5;
	$arr[5] = 6;
	$arr[6] = 7;
	$arr[7] = 8;
	$arr[8] = 9;
	$arr[9] = 10;
	return $arr;
}

function extendDaysAccessMapOptionData_ioc(){
	$arr[0] = '-Select-';
	$arr[1] = '1 day';
	$arr[2] = '2 days';
	$arr[3] = '3 days';
	$arr[4] = '4 days';
	$arr[5] = '5 days';
	$arr[6] = '6 days';
	$arr[7] = '7 days';
	return $arr;
}

function peepSearchTypeOptionData_ioc(){
	$arr['checked_me'] = 'Checked Me';
	$arr['normal_photo'] = 'Photo Rating';
	$arr['backstage_photo'] = 'Backstage Photo Rating';
	return $arr;
}

function peepSortOptionData_ioc(){
	$arr['default'] = '-Select-';
	$arr['today'] = 'Day';
	$arr['yesterday'] = 'Yesterday';
	$arr['week'] = 'Week';
	$arr['month'] = 'Month';
	return $arr;
}

function sendRandomMessageOptionData_ioc(){
	$arr['no_friend'] = 'Non Friends';
	$arr['friend'] = 'My Friends';
	return $arr;
}

function relationshipOptionData_ioc(){
	return $GLOBALS['global']['REL_STATUS'];
}

function userGenderOptionData_ioc(){
	$arr['Male'] = 'Male';
	$arr['Female'] = 'Female';
	return $arr;
}

function interestedInOptionData_ioc(){
	$arr['Men'] = 'Men';
	$arr['Women'] = 'Women';
	return $arr;
}

function getAvailableLanguagesOptionData_ioc(){
	$ci = &get_instance();
	$rs = $ci->db->get('default_google_languages')->result();
	foreach($rs as $item){
		$arr[] = $item->language;
	}
	return $arr;
}


function adminStatusItemOptionData_ioc(){
	$arr[0] = 'Deactive';
	$arr[1] = 'Active';
	return $arr;
}

function restrictUserOptionData_ioc(){
    $restrict_user[] = 'user';
	$restrict_user[] = 'admin';
    $restrict_user[] = 'fadmin';
	$restrict_user[] = 'page';
	$restrict_user[] = 'member';
	$restrict_user[] = 'users';
	$restrict_user[] = 'members';
	$restrict_user[] = 'pages';
	$restrict_user[] = 'module';
	$restrict_user[] = 'modules';
	$restrict_user[] = 'mod_io';
	$restrict_user[] = 'blog';
	$restrict_user[] = 'comments';
	$restrict_user[] = 'contact';
	$restrict_user[] = 'files';
	$restrict_user[] = 'groups';
	$restrict_user[] = 'keywords';
	$restrict_user[] = 'newletters';
	$restrict_user[] = 'redirects';
	$restrict_user[] = 'settings';
	$restrict_user[] = 'variables';
	$restrict_user[] = 'widgets';
	$restrict_user[] = 'themes';
	$restrict_user[] = 'streams';
	$restrict_user[] = 'sitemap';
	$restrict_user[] = 'xml';
	$restrict_user[] = 'feed';
	$restrict_user[] = 'rss';
	$restrict_user[] = 'permissions';
	$restrict_user[] = 'anonymously';
	$restrict_user[] = 'anonymous';
    
    return $restrict_user;
}





