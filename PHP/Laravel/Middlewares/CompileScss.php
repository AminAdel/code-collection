<?php
//---> update   :   1396.09.19

namespace App\Http\Middleware;

use Closure;
use Leafo\ScssPhp\Server;
use Leafo\ScssPhp\Compiler;

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
	 *		-> conditions for running locally removed; always runs; control other place;
	 *		-> removed "if required" condition;
	 * version 3.0.0    :   1396.09.19
	 *      -> env variable used to detect the environment; only runs locally now
	 */
	
	public function handle($request, Closure $next) {
		
		if (env('APP_ENV') == 'local') {
			$this->init();
		}
		
		return $next($request);
	} //done
	
	public function init() {
		
		// Admin Master SCSS :
		$admin_master_file = '../resources/assets/admin/scss/master.scss';
		$admin_target_file = 'template/admin/css/master.css';
		$admin_root = '../resources/assets/admin/scss/';
		$this->compile($admin_master_file, $admin_target_file, $admin_root);
		
		//==================================================
		
		// Auth Master SCSS :
		$auth_master_file = '../resources/assets/auth/scss/master.scss';
		$auth_target_file = 'template/auth/css/styles.css';
		$auth_root = '../resources/assets/auth/scss/';
		$this->compile($auth_master_file, $auth_target_file, $auth_root);
		
		//==================================================
	}
	
	public function compile($master_file, $target_file, $root) {
		// compile master Scss :
		$scss = new Compiler();
		$scss->setImportPaths($root);
		$scss->setFormatter('Leafo\ScssPhp\Formatter\Compressed'); // Expanded // Nested // Compressed // Compact // Crunched
		$content = file_get_contents($master_file);
		$content_compiled = $scss->compile($content);
		// todo: if compressed -> remove extra spaces near '>' & '+' char;
		file_put_contents($target_file, $content_compiled);
	}
	
}
