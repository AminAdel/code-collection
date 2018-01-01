<?php
//---> Update	:	1396.05.23  -> using without helper variable;
/*****************************/


namespace App\Http\Middleware;

use Closure;

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
	 */
	
	const path2cache = '../resources/assets/_cache/';
	
	public function handle($request, Closure $next) {
		
		if (env('APP_ENV') != 'local') {
			return $next($request);
		}
		
		// Common -> classes.js File
		$this->init(
			'template/common/js/classes.js',
			[
				'../resources/assets/common/js/class/class_element.js',
			],
			0
		);
		
		return $next($request);
	} //handle
	
	
	public static function init($file_target, $array_files, $compressType = 0) {
		
		// target file must exist already; { to avoid file creation in wrong destinations }
		
		/****************************/
		
		if (!file_exists($file_target) || count($array_files) == 0) {
			return false;
		}
		
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
		
		//require_once "../app/helpers/class/jsCompress.php"; // already included with composer;
		
		// recompile updated files and write to cache
		foreach ($files2update as $key => $filename) {
			$file_content = file_get_contents($filename);
			$compressed_content = \jsCompress::compress($file_content, $compressType);
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
