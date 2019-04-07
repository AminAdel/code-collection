<?php

namespace App\Http\Middleware;

use Closure;
use App\Helpers\Classes\jsCompress;

class MakeJSBundle {
	/**
	 * Handle an incoming request.
	 *
	 * @param  \Illuminate\Http\Request $request
	 * @param  \Closure $next
	 * @return mixed
	 * ***********************
	 * Overall Duty :
	 * join array of js files to one target file;
	 * - Recommended to run locally
	 * ***********************
	 * version 1.0.1    :   1396.01.09
	 * version 1.0.2    :   1396.05.23
	 * version 1.1.0    :   1396.10.11  ->  added if env local;
	 * version 2.0.0    :   1396.12.21 = 2018.03.12  ->  renamed method; added $subjects. (and foreach loop for it)
	 * version 2.0.1    :   1398.01.18 = 2019.04.07  ->  if `path2cache` doesn't exist -> mkdir
	 */
	
	const path2cache = '../resources/assets/_cache/';
	
	private $subjects = [
		
		// Common -> Classes :
		[
			'file_target' => 'template/common/js/classes.js',
			'files' => [
				'../resources/assets/common/js/class/class_element.js',
			],
			'compressType' => 0
		],
		
	];
	
	public function handle($request, Closure $next) {
		
		if (env('APP_ENV') == 'local') {
			foreach ($this->subjects as $index => $subject) {
				self::makeBundle($subject['file_target'], $subject['files'], $subject['compressType']);
			}
		}
		
		return $next($request);
	} //handle
	
	
	public static function makeBundle($file_target, $array_files, $compressType = 0) {
		
		// target file must exist already; { to avoid file creation in wrong destinations }
		
		/****************************/
		
		if (count($array_files) == 0) {
			return false;
		}
		
		if (!file_exists($file_target)) {
			return false;
			//$fp_temp = fopen($file_target, 'w+');
			//fclose($fp_temp);
		}
		
		if (!file_exists(self::path2cache)) { mkdir(self::path2cache); }
		
		/****************************/
		
		$target_mtime = filemtime($file_target);
		$files2update = []; // files need to be updated;
		
		/****************************/
		
		// get & compare files mtime;
		foreach ($array_files as $key => $filename) {
			if (filemtime($filename) > $target_mtime || !file_exists(self::path2cache . md5($filename))) {
				$files2update[] = $filename;
			}
		}
		
		/****************************/
		
		/**
		 * this part is for detecting if list of files changed or not.
		 * some files can be old but newly added to list;
		 * so ... we update everything;
		 */
		$list_name = self::path2cache . '_list_' . md5($file_target);
		if (!file_exists($list_name)) {
			$files2update = $array_files;
			$fp_temp = fopen($list_name, 'w+');
			fclose($fp_temp);
		}
		
		
		$list_content = file_get_contents($list_name);
		
		$files_string = '';
		foreach ($array_files as $key => $filename) {
			$files_string .= $filename . "\n";
		}
		
		if ($list_content != $files_string) { // very sensitive
			$files2update = $array_files;
			file_put_contents($list_name, $files_string);
		}
		
		/****************************/
		
		// check existence of new updated files :
		if (count($files2update) <= 0) {
			return false;
		} // do not continue;
		
		/****************************/
		
		// recompile updated files and write to cache
		foreach ($files2update as $key => $filename) {
			$file_content = file_get_contents($filename);
			$compressed_content = jsCompress::compress($file_content, $compressType);
			self::cache_write($filename, $compressed_content);
		}
		
		
		// join cached files to target file :
		// if any error -> filename will appear inside html comment with false flag;
		$target_content = '';
		foreach ($array_files as $key => $filename) {
			$target_content .= self::cache_read($filename, '/* ' . $filename . ' = false */') . "\n";
		}
		file_put_contents($file_target, $target_content);
		
	} //init
	
	public static function cache_write($filename, $content = '') {
		if ($filename == '') {
			return false;
		}
		$filename_new = self::path2cache . md5($filename);
		$file = fopen($filename_new, 'w+');
		fwrite($file, $content);
		fclose($file);
	} //cache_write
	
	public static function cache_read($filename, $default = false) {
		$filename_new = self::path2cache . md5($filename);
		if (file_exists($filename_new)) {
			return file_get_contents($filename_new);
		}
		
		return $default;
	} //cache_read
	
}
