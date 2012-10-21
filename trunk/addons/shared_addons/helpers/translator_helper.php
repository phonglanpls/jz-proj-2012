<?php  if (!defined('BASEPATH')) exit('No direct script access allowed');

function get_site_id(){
	$ci = &get_instance();
	$current_dbprefix = $ci->db->dbprefix;
	$ci->db->set_dbprefix('');
	$rs = $ci->db->where('ref',SITE_REF)->get('core_sites')->result();
	$ci->db->set_dbprefix($current_dbprefix);
	return $rs ? $rs[0]->id:0;
}

function get_language_code(){
	$code = isset($_SESSION['sys_lang_code']) ? $_SESSION['sys_lang_code'] : 'en';
	return $code;
}

function set_language_code($code){
	$_SESSION['sys_lang_code'] = $code;
}
	
function language_translate($slug=''){
	$code = get_language_code();
	$lang_file_dir = "./languages/$code.php";
	if(!is_file($lang_file_dir)){
		$lang_file_dir = "./languages/en.php";
	}
	require($lang_file_dir);
	
	if(!isset($lang[$slug])){
		require("./languages/en.php");
		if(!isset($lang[$slug])){
			return $slug;
		}
		return $lang[$slug];
	}else{
		return $lang[$slug];
	}
}


define('BING_API', 'YOUR_API_KEY');
define('GOOGLE_KEY', 'AIzaSyB6tJGirUabr5fey-yFbLx_WauYX0E1bbk');
 
function google_translate($from_lan, $to_lan, $text){
	$response = file_get_contents('https://www.googleapis.com/language/translate/v2?key='.GOOGLE_KEY.'&q=' . urlencode($text) . "&source=$from_lan&target=$to_lan");
	$json = json_decode($response); 
    $translated_text = $json->data->translations[0]->translatedText;

    return $translated_text;
}

function bing_loadData($url, $ref = false) {
	$chImg = curl_init($url);
	curl_setopt($chImg, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($chImg, CURLOPT_USERAGENT, "Mozilla/5.0 (Macintosh; Intel Mac OS X 10.6; rv:2.0) Gecko/20100101 Firefox/4.0");
	if ($ref) {
		curl_setopt($chImg, CURLOPT_REFERER, $ref);
	}
	$curl_scraped_data = curl_exec($chImg);
	curl_close($chImg);
	return $curl_scraped_data;
}
 
function bing_translate($text, $from = 'en', $to = 'fr') {
	$data = bing_loadData('http://api.bing.net/json.aspx?AppId=' . BING_API . '&Sources=Translation&Version=2.2&Translation.SourceLanguage=' . $from . '&Translation.TargetLanguage=' . $to . '&Query=' . urlencode($text));
	$translated = json_decode($data);
	if (sizeof($translated) > 0) {
		if (isset($translated->SearchResponse->Translation->Results[0]->TranslatedTerm)) {
			return $translated->SearchResponse->Translation->Results[0]->TranslatedTerm;
		} else {
			return false;
		}
	} else {
		return false;
	}
}

class AccessTokenAuthentication {
    /*
     * Get the access token.
     *
     * @param string $grantType    Grant type.
     * @param string $scopeUrl     Application Scope URL.
     * @param string $clientID     Application client ID.
     * @param string $clientSecret Application client ID.
     * @param string $authUrl      Oauth Url.
     *
     * @return string.
     */
    function getTokens($grantType, $scopeUrl, $clientID, $clientSecret, $authUrl){
        try {
            //Initialize the Curl Session.
            $ch = curl_init();
            //Create the request Array.
            $paramArr = array (
                 'grant_type'    => $grantType,
                 'scope'         => $scopeUrl,
                 'client_id'     => $clientID,
                 'client_secret' => $clientSecret
            );
            //Create an Http Query.//
            $paramArr = http_build_query($paramArr);
            //Set the Curl URL.
            curl_setopt($ch, CURLOPT_URL, $authUrl);
            //Set HTTP POST Request.
            curl_setopt($ch, CURLOPT_POST, TRUE);
            //Set data to POST in HTTP "POST" Operation.
            curl_setopt($ch, CURLOPT_POSTFIELDS, $paramArr);
            //CURLOPT_RETURNTRANSFER- TRUE to return the transfer as a string of the return value of curl_exec().
            curl_setopt ($ch, CURLOPT_RETURNTRANSFER, TRUE);
            //CURLOPT_SSL_VERIFYPEER- Set FALSE to stop cURL from verifying the peer's certificate.
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
            //Execute the  cURL session.
            $strResponse = curl_exec($ch);
            //Get the Error Code returned by Curl.
            $curlErrno = curl_errno($ch);
            if($curlErrno){
                $curlError = curl_error($ch);
                throw new Exception($curlError);
            }
            //Close the Curl Session.
            curl_close($ch);
            //Decode the returned JSON string.
            $objResponse = json_decode($strResponse);
            if ($objResponse->error){
                throw new Exception($objResponse->error_description);
            }
            return $objResponse->access_token;
        } catch (Exception $e) {
            echo "Exception-".$e->getMessage();
        }
    }
}

/*
 * Class:HTTPTranslator
 * 
 * Processing the translator request.
 */
Class HTTPTranslator {
    /*
     * Create and execute the HTTP CURL request.
     *
     * @param string $url        HTTP Url.
     * @param string $authHeader Authorization Header string.
     * @param string $postData   Data to post.
     *
     * @return string.
     *
     */
    function curlRequest($url, $authHeader, $postData=''){
        //Initialize the Curl Session.
        $ch = curl_init();
        //Set the Curl url.
        curl_setopt ($ch, CURLOPT_URL, $url);
        //Set the HTTP HEADER Fields.
        curl_setopt ($ch, CURLOPT_HTTPHEADER, array($authHeader,"Content-Type: text/xml"));
        //CURLOPT_RETURNTRANSFER- TRUE to return the transfer as a string of the return value of curl_exec().
        curl_setopt ($ch, CURLOPT_RETURNTRANSFER, TRUE);
        //CURLOPT_SSL_VERIFYPEER- Set FALSE to stop cURL from verifying the peer's certificate.
        curl_setopt ($ch, CURLOPT_SSL_VERIFYPEER, False);
        if($postData) {
            //Set HTTP POST Request.
            curl_setopt($ch, CURLOPT_POST, TRUE);
            //Set data to POST in HTTP "POST" Operation.
            curl_setopt($ch, CURLOPT_POSTFIELDS, $postData);
        }
        //Execute the  cURL session.
        $curlResponse = curl_exec($ch);
        //Get the Error Code returned by Curl.
        $curlErrno = curl_errno($ch);
        if ($curlErrno) {
            $curlError = curl_error($ch);
            throw new Exception($curlError);
        }
        //Close a cURL session.
        curl_close($ch);
        return $curlResponse;
    }

    /*
     * Create Request XML Format.
     *
     * @param string $languageCode  Language code
     *
     * @return string.
     */
    function createReqXML($languageCode) {
        //Create the Request XML.
        $requestXml = '<ArrayOfstring xmlns="http://schemas.microsoft.com/2003/10/Serialization/Arrays" xmlns:i="http://www.w3.org/2001/XMLSchema-instance">';
        if($languageCode) {
            $requestXml .= "<string>$languageCode</string>";
        } else {
            throw new Exception('Language Code is empty.');
        }
        $requestXml .= '</ArrayOfstring>';
        return $requestXml;
    }
}

function testTranslate(){
	try {
		//Client ID of the application.
		$clientID       = "0f442800-138b-4f8d-b1c6-706cea5924d5";
		//Client Secret key of the application.
		$clientSecret = "H+Lj+Wwbp+T+vRtve/+lcKSO+6a70nSPPwElnI7jgKE=";
		//OAuth Url.
		$authUrl      = "https://datamarket.accesscontrol.windows.net/v2/OAuth2-13/";
		//Application Scope Url
		$scopeUrl     = "http://api.microsofttranslator.com";
		//Application grant type
		$grantType    = "client_credentials";

		//Create the AccessTokenAuthentication object.
		$authObj      = new AccessTokenAuthentication();
		//Get the Access token.
		$accessToken  = $authObj->getTokens($grantType, $scopeUrl, $clientID, $clientSecret, $authUrl);
		//Create the authorization Header string.
		$authHeader = "Authorization: Bearer ". $accessToken;
		
		//Create the Translator Object.
		$translatorObj = new HTTPTranslator();
		
		//Input String.
		$inputStr = 'This is the sample string.';
		//HTTP Detect Method URL.
		$detectMethodUrl = "http://api.microsofttranslator.com/V2/Http.svc/Detect?text=".urlencode($inputStr);
		//Call the curlRequest.
		$strResponse = $translatorObj->curlRequest($detectMethodUrl, $authHeader);
		//Interprets a string of XML into an object.
		$xmlObj = simplexml_load_string($strResponse);
		foreach((array)$xmlObj[0] as $val){
			$languageCode = $val;
		}

		/*
		 * Get the language Names from languageCodes.
		 */
		$locale = 'en';
		$getLanguageNamesurl = "http://api.microsofttranslator.com/V2/Http.svc/GetLanguageNames?locale=$locale";
		//Create the Request XML format.
		$requestXml = $translatorObj->createReqXML($languageCode);
		//Call the curlRequest.
		$curlResponse = $translatorObj->curlRequest($getLanguageNamesurl, $authHeader, $requestXml);

		//Interprets a string of XML into an object.
		$xmlObj = simplexml_load_string($curlResponse);
		echo "<table border=2px>";
		echo "<tr>";
		echo "<td><b>LanguageCodes</b></td><td><b>Language Names</b></td>";
		echo "</tr>";
		foreach($xmlObj->string as $language){
			echo "<tr><td>".$inputStr."</td><td>". $languageCode."(".$language.")"."</td></tr>";
		}
		echo "</table>";
	} catch (Exception $e) {
		echo "Exception: " . $e->getMessage() . PHP_EOL;
	}
}
