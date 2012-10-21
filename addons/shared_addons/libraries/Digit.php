<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class CI_Digit{
	function __construct() {
	}
	function __destruct() {
	}
	
	function rand_digit($len, $chars = '0123456789')
	{
		$string = '';
		for ($i = 0; $i < $len; $i++)
		{
			$pos = rand(0, strlen($chars)-1);
			$string .= $chars{$pos};
		}
		return $string;
	}
	
	function rand_string($len, $chars = 'abcdefghiklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789')
	{
		$string = '';
		for ($i = 0; $i < $len; $i++)
		{
			$pos = rand(0, strlen($chars)-1);
			$string .= $chars{$pos};
		}
		return $string;
	}
	
	//end class
}	