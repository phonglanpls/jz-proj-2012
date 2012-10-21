<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class CI_Geo_lib{
	
	function __construct() {
	}
	function __destruct() {
	}
	
	function getIpAddress(){
		return $_SERVER['REMOTE_ADDR'];
	}
	
	function getCountryDataInfoFromCountryName($countryName){
		$ci = &get_instance();
		$res = $ci->db->where('country_name',$countryName)->get(TBL_COUNTRY)->result();
		return $res?$res[0]:false;
	}
	
	function getCountryGeoLocation(){
		include_once('ip2locationlite.class.php');
		//Set geolocation cookie
		if(!isset($_COOKIE["geolocation_juzon"])){
		  $ipLite = new ip2location_lite;
		  $ipLite->setKey('06fc082707b16fc07af8082fdeceed43569eece7ad373b60b82a8870b0f555c6');
		  $visitorGeolocation = $ipLite->getCountry($_SERVER['REMOTE_ADDR']);
		  if ($visitorGeolocation['statusCode'] == 'OK') {
			$data = base64_encode(serialize($visitorGeolocation));
			setcookie("geolocation_juzon", $data, time()+3600*24*7); //set cookie for 1 week
		  }
		}else{
		  $visitorGeolocation = unserialize(base64_decode($_COOKIE["geolocation_juzon"]));
		}
		return $visitorGeolocation;
		//array(5) { ["statusCode"]=> string(2) "OK" ["statusMessage"]=> string(0) "" ["ipAddress"]=> string(14) "113.190.88.196" ["countryCode"]=> string(2) "VN" ["countryName"]=> string(8) "VIET NAM" }
	}
	
	function getCoordinatesFromAddress($address)
	{
		$api_key=$GLOBALS['global']['GOOGLE_MAP']['key'];  //get from config
		$address=urlencode($address);
		$url="http://maps.googleapis.com/maps/geo?q=".$address."&output=json&sensor=true_or_false&key=".$api_key;
		
		$response=file_get_contents($url);
		$responseobject=json_decode($response);
		$responsearray=(array)$responseobject;
		
		$location['latitude']=$responseobject->Placemark[0]->Point->coordinates[1];
		$location['longitude']=$responseobject->Placemark[0]->Point->coordinates[0];
		
		return $location;
	}
	
	function getLocationInfoFromIP(){
		$address = "http://api.ipinfodb.com/v2/ip_query.php?key=bb04b6a20dd3933ea750a08e3ff98c71060bc28b43d7273c2416dbdb2a75a3f7&ip=" . $_SERVER['REMOTE_ADDR'] . "&timezone=false";
		$page = file_get_contents($address);
		$response = @new SimpleXMLElement($page);
		foreach ($response as $field => $value) {
			$geo_ip_location[(string) $field] = (string) $value;
		}
		$arr['longitude'] = $geo_ip_location['Longitude'];
		$arr['latitude'] = $geo_ip_location['Latitude'];
		$arr['country'] = $geo_ip_location['CountryName'];
		return $arr;		
	}
	
	function distance($lat1, $lon1, $lat2, $lon2, $unit) { 
		$difference = 6370.99056 * acos(sin($lat1/57.2958) * sin($lat2/57.2958) + cos($lat1/57.2958) * cos($lat2/57.2958) * cos($lon2/57.2958 - $lon1/57.2958));
		return $difference;
    }
	
	function change_in_latitude($kms){
	    return ($kms/EARTH_RADIUS)*RADIANS_TO_DEGREES;
	}

	function change_in_longitude($latitude, $kms){
	    //"Given a latitude and a distance west, return the change in longitude."
	    //# Find the radius of a circle around the earth at given latitude.
	    $r = EARTH_RADIUS*cos($latitude*DEGREES_TO_RADIANS);
	    return ($kms/$r)*RADIANS_TO_DEGREES;
	}
	
	
	//end class
}	