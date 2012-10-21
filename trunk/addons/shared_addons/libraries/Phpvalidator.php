<?php
/**
 * @author maheshchari.com
 * @date 11-11-2010
 * @version 1.0 beta
 * 
 * --------------------------------------------------------------------------
 * WARNING !
 * This is beta version, future versions might be incompatibile
 * stable relase planned shortly
 * Author doesn't take any responsibility for damage caused by this software.
 * This class provides non UTF-8 validation only,It planned for next version.
 * Please mail me at maheshchari@gmail.com for any suggestions ,bugs .etc 
 * --------------------------------------------------------------------------
 */
class CI_phpvalidator
{
    /**
     * Checks that a field is exactly the right length.
     * Constructer PHP4     
     */

    function __construct()
    {

    }
    /**
     * check a number optional -,+,. values
     * @param   string        
     * @return  boolean
     */
    function is_numeric($val)
    {
        return (bool)preg_match('/^[\-+]?[0-9]*\.?[0-9]+$/', $val);

    }
    /**
     * valid email     
     * @param   string   
     * @return  boolean
     */
    function is_email($val)
    {
        return (bool)(preg_match("/^([a-z0-9\+_\-]+)(\.[a-z0-9\+_\-]+)*@([a-z0-9\-]+\.)+[a-z]{2,6}$/i",
            $val));

    }
    /**
     * Valid URL or web address
     * @param   string      
     * @return  boolean
     */
    function is_url($val)
    {
        return (bool)preg_match("/^((((https?|ftps?|gopher|telnet|nntp):\/\/)|(mailto:|news:))(%[0-9A-Fa-f]{2}|[-()_.!~*';\/?:@&=+$,A-Za-z0-9])+)([).!';\/?:,][[:blank:]])?$/",
            $val);
    }
    /**
     * Valid IP address
     * @param   string   
     * @return  boolean
     */
    function is_ipaddress($val)
    {
        return (bool)preg_match("/^(25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)\.(25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)\.(25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)\.(25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)$/",
            $val);


    }
    /**
     * Matches only alpha letters
     * @param   string   
     * @return  boolean
     */
    function is_alpha($val)
    {
        return (bool)preg_match("/^([a-zA-Z])+$/i", $val);

    }
    /**
     * Matches alpha and numbers only
     * @param   string   
     * @return  boolean
     */
    function is_alphanumeric($val)
    {
        return (bool)preg_match("/^([a-zA-Z0-9])+$/i", $val);

    }
    /**
     * Matches alpha ,numbers,-,_ values
     * @param   string  
     * @return  boolean
     */
    function is_alphanumericdash($val)
    {
        return (bool)preg_match("/^([-a-zA-Z0-9_-])+$/i", $val);
    }
    /**
     * Matches alpha and dashes like -,_
     * @param   string  
     * @return  boolean
     */
    function is_alphadash($val)
    {
        return (bool)preg_match("/^([A-Za-z_-])+$/i", $val);

    }
    /**
     *Matches exactly number
     * @param   string   
     * @return  boolean
     */
    function is_integer($val)
    {
        return is_int($val);
	}
	
	function is_natural($val){
		return preg_match('/^[0-9]+$/', $val);
	}
    /**
     * Valid Credit Card
     * @param   string   
     * @return  boolean
     */
    function is_creditcard($val)
    {
        return (bool)preg_match("/^((4\d{3})|(5[1-5]\d{2})|(6011)|(7\d{3}))-?\d{4}-?\d{4}-?\d{4}|3[4,7]\d{13}$/",
            $val);

    }
    /**
     * check given string length is between given range 
     * @param   string   
     * @return  boolean
     */
    function is_rangelength($val, $min = '', $max = '')
    {
        return (strlen($val) >= $min and strlen($val) <= $max);
    }
    /**
     *Check the string length has minimum length
     * @param   string   
     * @return  boolean
     */
    function is_minlength($val, $min)
    {
        return (strlen($val) >= (int)$min);

    }
    /**
     * check string length exceeds maximum length     
     * @param   string   
     * @return  boolean
     */
    function is_maxlength($val, $max)
    {
        return (strlen($val) <= (int)$max);
    }
    /**
     * check given number exceeds max values   
     * @param   string   
     * @return  boolean
     */
    function is_maxvalue($number,$max)
    {
         return ($number >$max);

    }
    /**
     * check given number below value   
     * @param   string   
     * @return  boolean
     */
    function is_minvalue($number)
    {
        return ($number < $max);

    }
    /**
     * check given number between given values
     * @param   string   
     * @return  boolean
     */
    function is_rangevalue($number,$min,$max)
    {
        return ($number >$min and $number<$max);

    }
    /**
     * check for exactly length of string
     * @param   string  
     * @return  boolean
     */
    function is_length($val, $length)
    {
        return (strlen($val) == (int)$length);

    }
    /**
     * check decimal with . is optional and after decimal places up to 6th precision
     * @param   string   
     * @return  boolean
     */
    function is_decimal($val)
    {
		return (string)(float)$val === (string)$val;

    }
	 
    /**
     * Valid hexadecimal color ,that may have #,
     * @param   string   
     * @return  boolean
     */
    function is_hexcolor($color)
    {
        return (bool)preg_match('/^#?+[0-9a-f]{3}(?:[0-9a-f]{3})?$/i', $color);

    }
    /**
     * Matches  againest given regular expression ,including delimeters
     * @param   string   
     * @return  boolean
     */
    function is_regex($val, $expression)
    {
        return (bool)preg_match($expression, (string )$val);

    }
    /**
     * compares two any kind of values ,stictly
     * @param   string   
     * @return  boolean
     */
    function is_matches($val, $value)
    {
        return ($val === $value);

    }
    /**
     * check if field empty string ,orject,array
     * @param   string   
     * @return  boolean
     */
    function is_empty($val)
    {
        return in_array($val, array(null, false, '', array()), true);

    }
    /**
     * Check if given string matches any format date
     * @param   string   
     * @return  boolean
     */
    function is_date($val)
    {
        return (strtotime($val) !== false);

    }
    /**
     * check given string againest given array values
     * @param   string   
     * @return  boolean
     */
    function is_enum($val, $arr)
    {
        return in_array($val, $arr);

    }
    /**
     * Checks that a field matches a v2 md5 string
     * @param   string   
     * @return  boolean
     */
    function is_md5($val)
    {
        return (bool)preg_match("/[0-9a-f]{32}/i", $val);

    }
    /**
     * Matches base64 enoding string
     * @param   string   
     * @return  boolean
     */
    function is_base64($val)
    {
        return (bool)!preg_match('/[^a-zA-Z0-9\/\+=]/', $val);

    }
    /**
     * check if array has unique elements,it must have  minimum one element
     * @param   string   
     * @return  boolean
     */
    function is_unique($arr)
    {
        $arr = (array )$arr;
        $count1 = count($arr);
        $count2 = count(array_unique($arr));
        return (count1 != 0 and (count1 == $count2));
    }
    /**
     * Check is rgb color value
     * @param   string   
     * @return  boolean
     */
    function is_rgb($val)
    {
        return (bool)preg_match("/^(rgb\(\s*\b([0-9]|[1-9][0-9]|1[0-9][0-9]|2[0-4][0-9]|25[0-5])\b\s*,\s*\b([0-9]|[1-9][0-9]|1[0-9][0-9]|2[0-4][0-9]|25[0-5])\b\s*,\s*\b([0-9]|[1-9][0-9]|1[0-9][0-9]|2[0-4][0-9]|25[0-5])\b\s*\))|(rgb\(\s*(\d?\d%|100%)+\s*,\s*(\d?\d%|100%)+\s*,\s*(\d?\d%|100%)+\s*\))$/",
            $val);
    }
    /**
     * is given field is boolean value or not
     * @param   string   
     * @return  boolean
     */
    function is_boolean($val)
    {
        $booleans = array(1, 0, '1', '0', true, false, true, false);
        $literals = array('true', 'false', 'yes', 'no');
        foreach ($booleans as $bool) {
            if ($val === $bool)
                return true;
        }

        return in_array(strtolower($val), $literals);
    } 
    /**
     * A token that don't have any white space
     * @param   string   
     * @return  boolean
     */
    function is_token($val)
    {
        return (bool)!preg_match('/\s/', $val);

    }
    /**
     * Checks that a field is exactly the right length.
     * @param   string   value
     * @link  http://php.net/checkdnsrr  not added to Windows until PHP 5.3.0
     * @return  boolean
     */
    function is_emaildomain($email)
    {
        return (bool)checkdnsrr(preg_replace('/^[^@]++@/', '', $email), 'MX');

    }
    /**
     * Matches a phone number that length optional numbers 7,10,11
     * @param   string   
     * @return  boolean
     */
    function is_phone($number, $lengths = null)
    {
        if (!is_array($lengths)) {
            $lengths = array(7, 10, 11);
        }
        $number = preg_replace('/\D+/', '', $number);
        return in_array(strlen($number), $lengths);

    }
    /**
     * check given sting is UTF8 
     * @param   string  
     * @return  boolean
     */
    function is_utf8($val)
    {
        return preg_match('%(?:
        [\xC2-\xDF][\x80-\xBF]        
        |\xE0[\xA0-\xBF][\x80-\xBF]               
        |[\xE1-\xEC\xEE\xEF][\x80-\xBF]{2}     
        |\xED[\x80-\x9F][\x80-\xBF]               
        |\xF0[\x90-\xBF][\x80-\xBF]{2}   
        |[\xF1-\xF3][\x80-\xBF]{3}                  
        |\xF4[\x80-\x8F][\x80-\xBF]{2}    
        )+%xs', $val);

    }
    /**
     * Given sting is lower cased
     * @param   string   
     * @return  boolean
     */
    function is_lower($val)
    {
        return (bool)preg_match("/^[a-z]+$/", $val);

    }
    /**
     * Given string is upper cased?
     * @param   string   
     * @return  boolean
     */
    function is_upper($val)
    {
        return (bool)preg_match("/^[A-Z]+$/", $val);

    }
    /**
     * Checks that given value matches following country pin codes.     
     * at = austria
     * au = australia
     * ca = canada
     * de = german
     * ee = estonia
     * nl = netherlands
     * it = italy
     * pt = portugal
     * se = sweden
     * uk = united kingdom
     * us = united states
     * @param String   
     * @param String
     * @return  boolean
     */
    function is_pincode($val, $country = 'us')
    {
        $patterns = array('at' => '^[0-9]{4,4}$', 'au' => '^[2-9][0-9]{2,3}$', 'ca' =>
            '^[a-zA-Z].[0-9].[a-zA-Z].\s[0-9].[a-zA-Z].[0-9].', 'de' => '^[0-9]{5,5}$', 'ee' =>
            '^[0-9]{5,5}$', 'nl' => '^[0-9]{4,4}\s[a-zA-Z]{2,2}$', 'it' => '^[0-9]{5,5}$',
            'pt' => '^[0-9]{4,4}-[0-9]{3,3}$', 'se' => '^[0-9]{3,3}\s[0-9]{2,2}$', 'uk' =>
            '^([A-Z]{1,2}[0-9]{1}[0-9A-Z]{0,1}) ?([0-9]{1}[A-Z]{1,2})$', 'us' =>
            '^[0-9]{5,5}[\-]{0,1}[0-9]{4,4}$');
        if (!array_key_exists($country, $patterns))
            return false;
        return (bool)preg_match("/" . $patterns[$country] . "/", $val);


    }
    /**
     * Check given url really exists?
     * @param   string   
     * @return  boolean
     */
    function is_urlexists($link)
    {
        if (!$this->is_url($link))
            return false;
        return (bool)@fsockopen($link, 80, $errno, $errstr, 30);

    }

    /**
     * Check given sting has script tags
     * @param   string   
     * @return  boolean
     */
    function is_jssafe($val)
    {
        return (bool)(!preg_match("/<script[^>]*>[\s\r\n]*(<\!--)?|(-->)?[\s\r\n]*<\/script>/",
            $val));

    }
    /**
     * given sting has html tags?
     * @param   string   
     * @return  boolean
     */
    function is_htmlsafe($val)
    {
        return (bool)(!preg_match("/<(.*)>.*</$1>/", $val));

    }
    /**
     * check given sring has multilines 
     * @param   string   
     * @return  boolean
     */
    function is_multiline($val)
    {
        return (bool)preg_match("/[\n\r\t]+/", $val);

    }
    /**
     * check given array key element exists?
     * @param   string   
     * @return  boolean
     */

    function is_exists($val, $arr)
    {
        return isset($arr[$val]);

    }
    /**
     * is given string is ascii format?
     * @param   string        
     * @return  boolean
     */

    function is_ascii($val)
    {
        return !preg_match('/[^\x00-\x7F]/i', $val);
    }
    /**
     * Checks given value again MAC address of the computer
     * @param   string   value      
     * @return  boolean
     */
    function is_macaddress($val)
    {
        return (bool)preg_match('/^([0-9a-fA-F][0-9a-fA-F]:){5}([0-9a-fA-F][0-9a-fA-F])$/',
            $val);
    }
    /**
     * Checks given value matches us citizen social security number
     * @param   string         
     * @return  boolean
     */
    function is_usssn($val)
    {
        return (bool)preg_match("/^\d{3}-\d{2}-\d{4}$/", $val);
    }
    /**
     * Checks given value matches date de
     * @param   string         
     * @return  boolean
     */

    function is_dateDE($date)
    {
        return (bool)preg_match("/^\d\d?\.\d\d?\.\d\d\d?\d?$/", $date);
    }
    /**
     * Checks given value matches us citizen social security number
     * @param   string         
     * @return  boolean
     */
    function is_dateISO($date)
    {
        return (bool)preg_match("/^\d{4}[\/-]\d{1,2}[\/-]\d{1,2}$/", $date);
    }
    /**
     * Checks given value matches a time zone  
     * +00:00 | -05:00 
     * @param   string         
     * @return  boolean
     */
    function is_timezone($val)
    {
        return (bool)preg_match("/^[-+]((0[0-9]|1[0-3]):([03]0|45)|14:00)$/", $val);
    }
    /**
     * Time in 24 hours format with optional seconds
     * 12:15 | 10:26:59 | 22:01:15 
     * @param   string         
     * @return  boolean
     */

    function is_time24($val)
    {
        return (bool)preg_match("/^(([0-1]?[0-9])|([2][0-3])):([0-5]?[0-9])(:([0-5]?[0-9]))?$/",
            $val);
    }
    /**
     * Time in 12 hours format with optional seconds
     * 08:00AM | 10:00am | 7:00pm
     * @param   string         
     * @return  boolean
     */
    function is_time12($val)
    {
        return (bool)preg_match("/^([1-9]|1[0-2]|0[1-9]){1}(:[0-5][0-9][aApP][mM]){1}$/",
            $val);
    }

}
?>