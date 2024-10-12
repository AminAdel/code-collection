<?php

namespace App\Methods;

class Strings
{
	public static function isEmail($str) {
		if (filter_var($str, FILTER_VALIDATE_EMAIL) == false) return false;
		return true;
	}
	
	public static function is_json($string) {
		// php 5.3 or newer needed;
		json_decode($string);
		return (json_last_error() == JSON_ERROR_NONE);
	}
	
	public static function arabic2farsi($string_or_array) {
		$string = $string_or_array;
		if (is_array($string_or_array)) $string = json_encode_utf8($string_or_array);
		$string = Numbers::convert_numbers($string, 'en');
		//==============================
		/* change arabic chars with farsi chars */
		$string = str_ireplace('ك', 'ک', $string);
		$string = str_ireplace('ي', 'ی', $string);
		$string = str_ireplace('ة', 'ه', $string);
		$string = str_ireplace('ؤ', 'و', $string);
		$string = Numbers::convert_numbers($string, 'en');
		//==============================
		if (is_array($string_or_array)) return objectToArray($string);
		return $string;
	}
	
	public static function format_mobile($mobile_number) {
		$mobile_number = trim($mobile_number);
		$mobile_number = Numbers::convert_numbers($mobile_number, 'en');
		if (strlen($mobile_number) < 10) return null;
		$reverse = strrev($mobile_number);
		$reverse = substr($reverse, 0 , 10);
		$output = strrev($reverse);
		if (substr($output, 0, 1) != '9') return null;
		return (int) $output;
	}
}
