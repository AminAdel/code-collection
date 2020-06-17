<?php
//---> update   :   1399.03.28

namespace App\Http\Middleware;

use Closure;
use ScssPhp\ScssPhp\Compiler;

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
	 * version 3.1.0    :   1396.12.15 = 2018.03.06
	 *      -> added automatic compile ability with array of files;
	 * version 4.0.0    :   1399.03.28 = 2020.06.17
	 *      -> "leafo/scssphp" changed to "scssphp/scssphp";
	 */
	
	private $subjects = [
		
		// desktop :
		[
			'master'  => '../resources/assets/desktop/scss/master.scss',
			'target'  => 'template/desktop/css/master.css',
			'root'    => '../resources/assets/desktop/scss/',
			'compile' => true
		],
		
		// Admin :
		[
			'master'  => '../resources/assets/admin/scss/master.scss',
			'target'  => 'template/admin/css/master.css',
			'root'    => '../resources/assets/admin/scss/',
			'compile' => true
		],
		
	];
	
	public function handle($request, Closure $next) {
		
		if (env('APP_ENV') != 'local') return $next($request);
		
		foreach ($this->subjects as $index => $subject) {
			if ($subject['compile'] == true) {
				$this->compile($subject['master'], $subject['target'], $subject['root']);
			}
		}
		
		return $next($request);
	} //done
	
	public function compile($master_file, $target_file, $root) {
		// compile master Scss :
		$scss = new Compiler();
		$scss->setImportPaths($root);
		$scss->setFormatter('ScssPhp\ScssPhp\Formatter\Compressed'); // Expanded // Nested // Compressed // Compact // Crunched
		$content = file_get_contents($master_file);
		$content_compiled = $scss->compile($content);
		// todo: if compressed -> remove extra spaces near '>' & '+' char;
		file_put_contents($target_file, $content_compiled);
	}
	
}
