<?php

namespace App\Methods;

class Numbers
{
	public static function addZero($number, $length) {
		while (strlen((string) $number) < $length) {
			$number = '0' . $number;
		}
		return $number;
	}
	
	public static function convert_numbers($string, $to = 'fa') {
		$numbers_fa = ['۰', '۱', '۲', '۳', '۴', '۵', '۶', '۷', '۸', '۹'];
		$numbers_en = ['0', '1', '2', '3', '4', '5', '6', '7', '8', '9'];
		if ($to == 'fa') {
			$string = str_replace($numbers_en, $numbers_fa, $string);
		}
		elseif ($to == 'en') {
			$string = str_replace($numbers_fa, $numbers_en, $string);
		}
		return $string;
	}
	
	public static function remove_zeroes($number) {
		// 0055.0100 -> 55.01
		$number = trim($number, '0');
		$number = trim($number, '.');
		if (count(explode('.', $number)) > 1) return floatval($number);
		return intval($number);
	}
}
