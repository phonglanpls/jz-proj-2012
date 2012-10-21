<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

define('DATE_FORMAT','d-m-Y');
define('DATETIME', 'Y-m-d H:i:s');
define('DATETIMEEMAIL', 'Y-m-d H:i');

define('JUZDATETIMEFM', 'M d, Y H:i A');

function dayMonthYearSelectBox($intTime, $dayID='day', $monthID= 'month', $yearID= 'year', $arrayReturn = array('d','m','y','m_n'), $extra=''){
	if($intTime == 0){
		$date = $month = $year = 0;
		$date = date('d', time());
		$month = date ('F', time());
		$year = date ('Y', time());
	}else{
		$date = date('d', $intTime);
		$month = date ('F', $intTime);
		$year = date ('Y', $intTime);
	}
	 
	$d = "<select id='$dayID' name='$dayID' $extra>";
	for($i = 1; $i<=31 ;$i++){
		$today = date("d", mktime(0, 0, 0, 0, $i));
		$selected = ($date == $today) ? "selected = 'selected'":'';
        if($i<=9){
            $j= '0'.$i;
        }else{
            $j= $i;
        }
        
		$d .= "<option $selected value='$j'>$today</option>";
	}
	$d .="</select>";
	
	$m = "<select id='$monthID' name='$monthID' $extra>"; 
	for($i = 1; $i<=12 ;$i++){
		$month2 = date("F", mktime(0, 0, 0, $i, 1));
		$selected = ($month == $month2) ? "selected = 'selected'":'';
        if($i<=9){
            $j= '0'.$i;
        }else{
            $j= $i;
        }
        
		$m .= "<option $selected value='$j'>".language_translate("sys_datetime_$i")."</option>";
	}
	$m .="</select>";
	
	$y = "<select id='$yearID' name='$yearID' $extra>"; 
	$yearNow = date('Y',time());
	if($intTime == 0){
		$j = $yearNow;
	}else{
		$j = 2010;
	}
	for($i = $yearNow-18; $i>=$yearNow-18-72 ;$i--){
		$selected = ($year == $i) ? "selected = 'selected'":'';
		$y .= "<option $selected value='$i'>$i</option>";
	}
	$y .="</select>";
	
	$m_n = "<select id='$monthID' name='$monthID' $extra>"; 
	for($i = 1; $i<=12 ;$i++){
		$month2 = ($i<=9) ? '0'.$i : $i;
		$selected = ($month == $month2) ? "selected = 'selected'":'';
		$m_n .= "<option $selected value='$i'>$month2</option>";
	}
	$m_n .="</select>";
	
	$arrayUI = array();
	foreach($arrayReturn as $val){
		if(in_array($val, array('d','m','y','m_n'))){
			$arrayUI[] = ${$val};
		}
	}
	return implode('',$arrayUI);
}

function convertTimeEntity2Int($y,$m,$d,$h,$i){
	return mktime(intval($h), intval($i), 0, intval($m), intval($d), $y);//mktime(hour,minute,second,month,day,year,is_dst)
}

function convertToTimeStampFromFormat( $str, $format = "Y-m-d H:i"){
	$format = isset($format)? $format : "Y-m-d H:i";
	$date = DateTime::createFromFormat($format, $str);
	if(!$date) return 0;
	$date = $date->format('Y-m-d H:i');
	return intval( strtotime($date) );
}

function sysDateFormat($timeStamp, $format = "Y/m/d"){
	$format = isset($format) ? $format : 'Y/m/d';
	return date($format, $timeStamp);
}

function sysDateTimeFormat($timeStamp, $format = "Y-m-d H:i"){
	$format = isset($format) ? $format : 'Y-m-d H:i';
	return date($format, $timeStamp);
}

function juzTimeDisplay($mysql_time){
	if(!getAccountUserId()){
		$timestamp = mysql_to_unix($mysql_time);
		return sysDateTimeFormat($timestamp,JUZDATETIMEFM);
	}else{
		$userdataobj = getAccountUserDataObject(true);
		
		$timestamp = mysql_to_unix($mysql_time);	
		$gmtamount = time() - mysql_to_unix(mysqlDate());
		$gmtconvert = $timestamp + $gmtamount;
		 
		$localtime = $gmtconvert + parseGMTtime($userdataobj->timezone);
		return sysDateTimeFormat($localtime,JUZDATETIMEFM);
	}
}

function parseGMTtime($str){
	if(!$str) return 0;
	
	$str = (string) $str;
	
	if($str[0] == '+'){
		$multiply = 1;
	}else{
		$multiply = -1;
	}
	
	$retStr = substr($str,1,strlen($str)-1);
	$exp = explode(':',$retStr);
	
	$timeamount = intval($exp[0])*3600 + intval($exp[1])*60;
	return $timeamount*$multiply;
}

function juzAdminDate($mysql_time){
	$timestamp = mysql_to_unix($mysql_time);
	return sysDateTimeFormat($timestamp,'M d, Y');
}

function getTimeStampDateOfCurrentTime($timeStamp){
	$string = sysDateFormat($timeStamp, $format = "d-m-Y");
	//$a = strptime($string, '%d-%m-%Y');
	list($day, $month, $year) = explode('-', $string);
	return mktime(0, 0, 0, $month, $day, $year);
	//return mktime(0, 0, 0, $a['tm_mon']+1, $a['tm_mday'], $a['tm_year']+1900);	
}

function getTimeStampMonthOfCurrentTime($timeStamp){
	$string = sysDateFormat($timeStamp, $format = "d-m-Y");
	list($day, $month, $year) = explode('-', $string);
	$from = mktime(0, 0, 0, $month, 1, $year);
	
	$daysInMonth = daysInMonth($month, $year);
	$to = $daysInMonth*86400 + $from;
	
	return array('from'=>$from , 'to'=>$to);
}

function workingDaysTimeStamp($workDays = 2){
	$timestamp = time();
    while ($workDays>0) {
        $timestamp += 86400;
        if (date('N', $timestamp)<6) $workDays--;
    }
    return $timestamp;
}

function workingDaysTimeStamp2($workDays = 2, $fromTimeStamp=0){
	$timestamp = $fromTimeStamp;
    while ($workDays>0) {
        $timestamp += 86400;
        if (date('N', $timestamp)<6) $workDays--;
    }
    return $timestamp;
}

function daysInMonth($month, $year){
	return cal_days_in_month(CAL_GREGORIAN, $month, $year);
}

function getDayOfWeek($year, $month, $day){
	$dayNameArray = defineJldayOfWeek();
	$jd=cal_to_jd(CAL_GREGORIAN,$month,$day,$year);
	return $dayNameArray[jddayofweek($jd,0)];
}

function daysInMonthDataArray($month, $year){
	$array_return = array();
	for($i=1; $i<= daysInMonth($month, $year); $i++){
		$j = ($i <= 9) ? '0'.$i:$i;
		$array_return[$i] = $j.' '.getDayOfWeek($year, $month, $i);
	}
	return $array_return;
}

function convertAgeFromTimeStamp($time){
	return date('Y',time()) - date('Y',$time);
}

function defineJldayOfWeek(){
	return array(
		'0'	=> language_translate('jldayOfWeek_0'),
		'1' => language_translate('jldayOfWeek_1'),
		'2' => language_translate('jldayOfWeek_2'),
		'3' => language_translate('jldayOfWeek_3'),
		'4' => language_translate('jldayOfWeek_4'),
		'5' => language_translate('jldayOfWeek_5'),
		'6' => language_translate('jldayOfWeek_6')
	);
}

function defineJlMonth(){
	return array(
		'1'	=> array( language_translate('sys_datetime_1') , language_translate('sys_datetime_acrn_1') ),
		'2' => array( language_translate('sys_datetime_2') , language_translate('sys_datetime_acrn_2') ),
		'3' => array( language_translate('sys_datetime_3') , language_translate('sys_datetime_acrn_3') ),
		'4' => array( language_translate('sys_datetime_4') , language_translate('sys_datetime_acrn_4') ),
		'5' => array( language_translate('sys_datetime_5') , language_translate('sys_datetime_acrn_5') ),
		'6' => array( language_translate('sys_datetime_6'), language_translate('sys_datetime_acrn_6') ),
		'7' => array( language_translate('sys_datetime_7') , language_translate('sys_datetime_acrn_7') ),
		'8' => array( language_translate('sys_datetime_8'), language_translate('sys_datetime_acrn_8') ),
		'9' => array( language_translate('sys_datetime_9'), language_translate('sys_datetime_acrn_9') ),
		'10' => array( language_translate('sys_datetime_10'), language_translate('sys_datetime_acrn_10') ),
		'11' => array( language_translate('sys_datetime_11'), language_translate('sys_datetime_acrn_11') ),
		'12' => array( language_translate('sys_datetime_12'), language_translate('sys_datetime_acrn_12') )
	);
}

function firstDayOfMonthTimestamp($month = 0, $year = 0){
	if($month && $year){
		return strtotime(date(DATE_FORMAT, strtotime($month.'/01/'.$year.' 00:00:00')));
	}else{
		return strtotime(date(DATE_FORMAT, strtotime(date('m').'/01/'.date('Y').' 00:00:00')));
	}
}
function lastDayOfMonthTimestamp($month = 0, $year = 0){
	if($month && $year){
		return strtotime(date(DATE_FORMAT, strtotime('-1 second',strtotime('+1 month',strtotime($month.'/01/'.$year.' 00:00:00')))));
	}else{
		return strtotime(date(DATE_FORMAT, strtotime('-1 second',strtotime('+1 month',strtotime(date('m').'/01/'.date('Y').' 00:00:00')))));
	}
}

function calculateTimeBetweenTwoDay($date1, $date2){
	$diff = abs(strtotime($date2) - strtotime($date1));
	$result = array();
	$years = floor($diff / (365*60*60*24));
	$months = floor(($diff - $years * 365*60*60*24) / (30*60*60*24));
	$days = floor(($diff - $years * 365*60*60*24 - $months*30*60*60*24)/ (60*60*24));
	$result['years'] = $years;
	$result['months'] = $months;
	$result['days'] = $days;
	$result['diffDays'] = (strtotime($date2) - strtotime($date1)) / (60 * 60 * 24) +1;
	$result['diffMonths'] = $years * 12 + $months + 2;
	$result['diffYears'] =  intval(date('Y', strtotime($date2))) - intval(date('Y', strtotime($date1))) + 1;
	
	return $result;
}

function time_interval($days){
	$days[0]=ltrim($days[0],"0");
	$days[1]=ltrim($days[1],"0");
	$days[2]=ltrim($days[2],"0");
	 
	if($days[0]==0){
		if($days[1]==0){
			if($days[2]==1)
				$res1['diff']=$days[2]." sec";
			else if($days[2]>1)
				$res1['diff']=$days[2]." secs";
			else
				$res1['diff']= "a few sec";
		}else{
			if($days[1]==1)
				$res1['diff']=$days[1]." min";
			else
				$res1['diff']=$days[1]." mins";
		}
	}else{
		if($days[0]>=168){
			if((int)($days[0]/168) == 1)
				$res1['diff']="1 week";
			else
				$res1['diff']=(int)($days[0]/168)." weeks";
		}elseif($days[0]>=24){
			if((int)($days[0]/24) == 1)
				$res1['diff']=(int)($days[0]/24)." day";
			else
				$res1['diff']=floor($days[0]/24)." days";
		}else{
			if($days[0]==1)
				$res1['diff']=$days[0]." hour";
			else
				$res1['diff']=$days[0]." hours";
		}
	}
	
	return $res1['diff'].' ago';
}

function timeDiff($timestamp){
	$year = (int)( $timestamp/(365*86400) );
	$month = (int)( $timestamp/(30*86400) );
	$week = (int)( $timestamp/(7*86400) );
	$day = (int)( $timestamp/(86400) );
	$hour = (int)( $timestamp/(3600) );
	$minute = (int)( $timestamp/(60) );
	
	if($year >= 1){
		if($year == 1){
			$res['diff'] = "1 year";
		}else{
			$res['diff'] = "$year years";
		}
	}elseif($month >= 1){
		if($month == 1){
			$res['diff'] = "1 month";
		}else{
			$res['diff'] = "$month months";
		}
	}elseif($week >= 1){
		if($week == 1){
			$res['diff'] = "1 week";
		}else{
			$res['diff'] = "$week weeks";
		}
	}elseif($day >= 1){
		if($day == 1){
			$res['diff'] = "1 day";
		}else{
			$res['diff'] = "$day days";
		}
	}elseif($hour >= 1){
		if($hour == 1){
			$res['diff'] = "1 hour";
		}else{
			$res['diff'] = "$hour hours";
		}
	}elseif($minute>=1){
		if($minute == 1){
			$res['diff'] = "1 min";
		}else{
			$res['diff'] = "$minute mins";
		}
	}else{
		if($timestamp<10){
			$res['diff']= "a few sec";
		}else{
			$res['diff']= $timestamp." secs";
		}	
	}
	
	return $res['diff'].' ago';
}

function mysqlDate(){
	$ci = &get_instance();
	$rs = $ci->db->query("SELECT NOW() AS timenow")->result();
	return $rs[0]->timenow;
}

//YYYY-MM-DD
//to DD-MM-YYY
function birthDay($dob){
	$ex = explode('-',$dob);
	return $ex[2].'-'.$ex[1].'-'.$ex[0];
}

//DD-MM-YYYY
//to YYYY-MM-DD
function dbDay($date){
	$ex = explode('-',$date);
	return $ex[2].'-'.$ex[1].'-'.$ex[0];
}

//calculate age of user 
//format: YYYY-MM-DD HH:ii:ss
function cal_age($date=""){
	//var_dump($date); //check if dob is available
	if($date =="0000-00-00")
	{
		return "Age not available";
	}

	$date1 = strtotime("now");
	$date2 = strtotime($date);
	$age = floor(($date1-$date2)/31557600);
	return $age;
}