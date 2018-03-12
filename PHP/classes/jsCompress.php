<?php
//---> Create	:	1395.10.11
//---> Finish	:	1395.10.20
//---> Update	:	--
/*****************************/

// namespace App\Helpers\Classes;

class jsCompress {
	/**
	 * this function gets path to js classes, functions and scripts
	 * and join them together to one final file.
	 * it may compress final file;
	 * it may obfuscate final file;
	 */
	
	
	public function __construct($array_files, $compressType = 0, $target = '') {
		// you don't need to use construct; just call init();
		return self::init($array_files, $compressType, $target);
	}
	
	public static function init($array_files, $compressType = 0, $target = '') {
		foreach ($array_files as $key => $file) {
			if (!file_exists($file)) return -1; //file not found
		}
		
		$final = '';
		
		foreach ($array_files as $key => $file) {
			$file_content = read($file);
			if ($file_content == false) continue;
			$final .= $file_content . "\n\n\n";
		}
		
		if ($compressType > 0) $final = self::compress($final, $compressType);
		
		if ($target != '') {
			self::write($final, $target);
			return true;
		}
		
		return $final;
	}
	
	public static function read($file) {
		return file_get_contents($file);
	}
	
	public static function write($content, $fileTarget) {
		// target can not be empty;
		$file = fopen($fileTarget, 'w+');
		file_put_contents($fileTarget, $content);
		fclose($file);
	}
	
	public static function checkCodes($content) {
		// todo: complete this later;
		// check if there is semicolon after each statement;
		// check each line and try to find any error in codes;
		// if errors found -> get those lines of code as array;
	}
	
	public static function compress($content, $type) {
		/**
		 * type = 1 | 2 | 3
		 */
		$output = '';
		if ($content == '' || !($type >= 0)) return false;
		
		if ($type == 0) $output = $content;
		if ($type == 1) $output = self::compressType1($content); // safe compress
		if ($type == 2) $output = self::compressType2($content); // more compress
		if ($type == 3) $output = self::compressType3($content); // best compress + obfuscate
		
		return $output;
	}
	
	public static function compressType1($content) {
		// No Obfuscation; just removes comments, extra spaces & stuff like that;
		
		$output = $content;
		
		$output = explode("\n", $output); //print_r($output);
		foreach ($output as $key => $line) {
			$output[$key] = trim($line);
			if ($output[$key] == '') unset($output[$key]);
		}
		$output = array_values($output); //print_r($output);
		$output = implode("\n", $output);
		
		
		// removes single-line comments; even inside strings; will not remove http://...
		$output = preg_replace("/\s*?(?<!:)\/\/.*?\n/", "\n", $output);
		$output = preg_replace('/\/\*.*?\*\//s', "", $output); // removes block comments; even inside strings;
		
		$output = preg_replace("/\t+/s", " ", $output); // removes tabs; even inside strings;
		
		$output = preg_replace("/\s*\n*\s*{\s*\n+\s*/s", "{", $output); // removes extra space near { char;
		$output = preg_replace("/\s*\n+\s*}\s*\n*\s*/s", "}", $output); // removes extra space near } char;
		$output = preg_replace("/\s*\n*\s*}\s*\n+\s*/s", "}", $output); // removes extra space near } char;
		
		$output = preg_replace("/\s*\n*\s*\(\s*\n+\s*/s", "(", $output); // removes extra space near ( char;
		$output = preg_replace("/\s*\n+\s*\)\s*\n*\s*/s", ")", $output); // removes extra space near ) char;
		//$output = preg_replace("/\s*\n*\s*\)\s*\n+\s*/s", ")", $output); // removes extra space near ) char;
		
		$output = preg_replace("/\s*\n*\s*else\s*\n+\s*/s", " else ", $output); // removes extra space near else char;
		
		$output = preg_replace("/\s*:\s*\n+\s*/s", ":", $output); // removes extra space near ; char;
		$output = preg_replace("/\s*;\s*\n+\s*/s", ";", $output); // removes extra space near ; char;
		$output = preg_replace("/\s*,\s*\n+\s*/s", ",", $output); // removes extra space near , char;
		$output = preg_replace("/\s*\+\s*\n+\s*/s", "+", $output); // removes extra space near + char;
		$output = preg_replace("/\s*\|\|\s*\n+\s*/s", "||", $output); // removes extra space near || char;
		$output = preg_replace("/\s*&&\s*\n+\s*/s", "&&", $output); // removes extra space near && char;
		
		$output = trim($output);
		//echo $output;
		return $output;
	}
	
	public static function compressType2($content) {
		// No Obfuscation; but best compress;
		/**
		 * to use this compressType :
		 * do not use special chars inside any string. { like > < + - = * ; / () {} || \t }
		 */
		
		$output = self::compressType1($content);
		
		$output = preg_replace("/\s*{\s*/s", "{", $output); // removes extra spaces near { char;
		$output = preg_replace("/\s*}\s*/s", "}", $output); // removes extra spaces near } char;
		
		$output = preg_replace("/\s*\(\s*/s", "(", $output); // removes extra spaces near ( char;
		$output = preg_replace("/\s*\)\s*/s", ")", $output); // removes extra spaces near ) char;
		
		$output = preg_replace("/\s*=\s*/s", "=", $output); // removes extra spaces near = char;
		$output = preg_replace("/\s*<\s*/s", "<", $output); // removes extra spaces near < char;
		$output = preg_replace("/\s*;\s*/s", ";", $output); // removes extra spaces near : char;
		$output = preg_replace("/\s*:\s*/s", ":", $output); // removes extra spaces near : char;
		$output = preg_replace("/\s*\+=\s*/s", "+=", $output); // removes extra spaces near += char;
		$output = preg_replace("/\s*-=\s*/s", "-=", $output); // removes extra spaces near -= char;
		$output = preg_replace("/},\s+/s", "},", $output); // removes extra spaces near , char;
		
		$output = trim($output);
		//echo $output;
		return $output;
	}
	
	public static function compressType3($content) {
		// best compress plus obfuscation
		// use Packer
		
		/*
		 * https://github.com/tholu/php-packer
		 * ***************************
		 * params of the constructor :
		 * $script:           the JavaScript to pack, string.
		 * $encoding:         level of encoding, int or string :
		 *                    0,10,62,95 or 'None', 'Numeric', 'Normal', 'High ASCII'.
		 *                    default: 62 ('Normal').
		 * $fastDecode:       include the fast decoder in the packed result, boolean.
		 *                    default: true.
		 * $specialChars:     if you have flagged your private and local variables
		 *                    in the script, boolean.
		 *                    default: false.
		 * $removeSemicolons: whether to remove semicolons from the source script.
		 *                    default: true.
		 */
		$packer = new \Tholu\Packer\Packer($content, 'Normal', true, false, false);
		$packed_js = $packer->pack();
		return $packed_js;
	}
	
}
