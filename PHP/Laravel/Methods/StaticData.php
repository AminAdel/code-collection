<?php

namespace App\Methods;

class StaticData
{
	public static function get_static_data($name) {
		if (!file_exists(app_path('StaticData/' . $name . '.php'))) return [];
		return include app_path('StaticData/' . $name . '.php');
	} // (Adel:1403.06.13)
}
