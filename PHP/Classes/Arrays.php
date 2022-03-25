<?php
namespace App\Methods;


class Arrays
{
	public static function remove_empty_items($array) {
		$array2 = [];
		foreach ($array as $index => $item) {
			if (!empty($item)) $array2[] = $item;
		}
		return $array2;
	} // done
	
	public static function merge_recursive_distinct2($array1, $array2) {
		// keeps indexes of children arrays, but replaces existing values; and removes duplicate items;
		foreach ($array2 as $index => $item) {
			if (empty($item)) continue;
			//==============================
			if (is_numeric($index)) {
				if (!in_array($item, $array1)) {
					$array1[] = $item;
				}
				continue;
			}
			if (empty($array1[$index]) || !is_array($item)) {
				$array1[$index] = $item;
				continue;
			}
			if (is_array($item)) {
				$array1[$index] = self::merge_recursive_distinct2($array1[$index], $item);
				continue;
			}
		}
		return $array1;
	} // done : 1400.12.29
}
