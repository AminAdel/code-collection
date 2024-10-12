<?php

namespace App\Methods;

// use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

class Configs
{
	public static function get($key, $default = false) {
		// $record = Cache::get('config_'.$key, function () use($key) {
		// 	return DB::table('configs')->where('key_', $key)->first();
		// });
		$record = DB::table('configs')->where('key_', $key)->first();
		if (empty($record)) return $default;
		return $record->value_;
	} // (Adel:1403.06.06)
	
	public static function create($key, $value) {
		DB::table('configs')->insert([
			'key_' => $key,
			'value_' => $value
		]);
	} // (Adel:1403.06.06)
	
	public static function update($key, $value) {
		DB::table('configs')->where('key_', $key)->update(['value_' => $value]);
	} // (Adel:1403.06.06)
}
