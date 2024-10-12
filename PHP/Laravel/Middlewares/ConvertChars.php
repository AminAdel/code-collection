<?php

namespace App\Http\Middleware;

use App\Methods\Numbers;
use App\Methods\Strings;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ConvertChars
{
	public function handle(Request $request, Closure $next): Response {
		$inputs = $request->all();
		foreach ($inputs as $index => $input) {
			$request->merge([
				$index => Strings::arabic2farsi(Numbers::convert_numbers($input)),
			]);
		}
		//==============================
		return $next($request);
	} // 1403.07.20
}
