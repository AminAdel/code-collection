<?php

namespace App\Methods;

use Illuminate\Support\Facades\DB;

class ErrorLogs
{
	public static function store($subject, $info) {
		$info = [
			'message' => $info->getMessage() ?? '',
			'code' => $info->getCode() ?? '',
			'file' => $info->getFile() ?? '',
			'line' => $info->getLine() ?? '',
			'trace' => $info->getTraceAsString() ?? ''
		];
		DB::table('error_logs')->insert([
			'subject' => $subject,
			'error' => json_encode($info),
			'inputs' => json_encode_utf8(request()->all()),
			'date' => date("Y-m-d H:i:s") 
		]);
	} // (Adel:1403.06.29)
}
