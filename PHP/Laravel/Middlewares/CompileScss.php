<?php
//---> update   :   1396.02.19

namespace App\Http\Middleware;

use Closure;
use Leafo\ScssPhp\Server;
use Leafo\ScssPhp\Compiler; // composer require "Leafo/ScssPhp"

class CompileScss {
	/**
	 * @param $request
	 * @param callable $next
	 * @return mixed
	 * ***********************
	 * Overall Duty :
	 * Checks and Compiles Project SCSS Files
	 * - Recommended to run on localhost
	 * ***********************
	 * version 1.0.0    :   1396.01.09
	 * version 2.0.0    :   1396.02.19
	 *		-> conditions for running localy removed; always runs; control other place;
	 *		-> removed "if required" condition;
	 */
	
	public function handle($request, Closure $next) {
		/**
		 * later : take this to a class with namespace;
		 */
		
		// Desktop Master SCSS :
		$desktop_master_file = '../resources/assets/desktop/scss/master.scss';
		$desktop_target_file = 'template/desktop/css/master.css';
		$desktop_root = '../resources/assets/desktop/scss/';
		
		$this->compile($desktop_master_file, $desktop_target_file, $desktop_root);
		
		/**********************************/
		
		return $next($request);
	}
	
	public function compile($master_file, $target_file, $root) {
		// compile master Scss :
		$scss = new Compiler();
		$scss->setImportPaths($root);
		$scss->setFormatter('Leafo\ScssPhp\Formatter\Expanded'); // Expanded // Nested // Compressed // Compact // Crunched
		$content = file_get_contents($master_file);
		$content_compiled = $scss->compile($content);
		// todo: if compressed -> remove extra spaces near '>' & '+' char;
		file_put_contents($target_file, $content_compiled);
	}
	
}
