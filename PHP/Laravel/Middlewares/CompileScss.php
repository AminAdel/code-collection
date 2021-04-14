<?php
//---> update   :   1400.01.25

namespace App\Http\Middleware;

use Closure;
use ScssPhp\ScssPhp\Compiler;
use ScssPhp\ScssPhp\OutputStyle;

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
	 * version 4.1.0	:	1400.01.25 = 2021.04.15
	 *      -> "$scss->setFormatter" changed to "$scss->setOutputStyle"
	 */
	
	private $subjects = [
		
		// theme_appco :
		[
			'master'  => '../resources/views/theme_appco/master.scss',
			'target'  => 'assets/theme_appco/css/theme_appco.css',
			'root'    => '../resources/views/theme_appco/',
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
		$scss->setOutputStyle(OutputStyle::COMPRESSED); // Expanded // Nested // Compressed // Compact // Crunched
		// $scss->setFormatter('ScssPhp\ScssPhp\Formatter\Compressed'); // Expanded // Nested // Compressed // Compact // Crunched
		$content = file_get_contents($master_file);
		$content_compiled = $scss->compile($content);
		file_put_contents($target_file, $content_compiled);
	}
	
}
