<?php
//---> update   :   1400.01.25
//---> update   :   1400.03.20	->	"scssphp/scssphp" updated to version 1.5.2; so some codes changed accordingly;

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
	 * version 4.2.0	:	1400.03.20 = 2021.06.10
	 * 		-> scssphp/scssphp updated to 1.5.2
	 */
	
	private $subjects = [
		
		// theme_appco :
		[
			'master'  => '../resources/scss/master.scss',
			'target'  => 'assets/boomi/boomi_bundle.min.css',
			'root'    => '../resources/scss/',
		],
	
	];
	
	public function handle($request, Closure $next) {
		
		if (env('APP_ENV') != 'local') return $next($request);
		
		foreach ($this->subjects as $index => $subject) {
			$this->compile($subject['master'], $subject['target'], $subject['root']);
		}
		
		return $next($request);
	} //done
	
	public function compile($master_file, $target_file, $root) {
		// compile master Scss :
		$scss = new Compiler();
		$scss->setImportPaths($root);
		$scss->setOutputStyle(OutputStyle::COMPRESSED); // Expanded // Nested // Compressed // Compact // Crunched
		$content = file_get_contents($master_file);
		$content_compiled = $scss->compileString($content)->getCss();
		file_put_contents($target_file, $content_compiled);
	}
	
}
