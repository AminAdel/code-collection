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
		// keeps indexes even in children arrays, but replaces existing values; and removes duplicate items;
		foreach ($array2 as $index => $item) {
			if (empty($item)) continue;
			//==============================
			if (is_numeric($index)) {
				if (!in_array($item, $array1)) {
					$array1[] = $item;
				}
				continue;
			}
			if (!is_array($item)) {
				$array1[$index] = $item;
				continue;
			}
			$array1[$index] = self::merge_recursive_distinct2($array1[$index] ?? [], $item);
			//==============================
			/*if (!is_numeric($index) && empty($array1[$index])) {
				$array1[$index] = $item;
				continue;
			}
			if (is_numeric($index) && !in_array($item, $array1)) {
				$array1[] = $item;
				continue;
			}
			if (is_array($item)) {
				$array1[$index] = self::merge_recursive_distinct2($array1[$index], $item);
				continue;
			}*/
		}
		return $array1;
	} // done : 1400.12.29; 1401.01.05
	
	public static function push_after_index($array, $new_item, $after_index): array {
		$new_array = [];
		if ($after_index === 0) {
			$new_array[] = $new_item;
			$new_array = array_merge($new_array, $array);
		}
		else {
			foreach ($array as $index => $item) {
				$new_array[] = $item;
				if (++$index === $after_index) $new_array[] = $new_item;
			}
		}
		return $new_array;
	} // done : 1401.03.19
	
	public static function multiSort($key, $array, $order = SORT_DESC) {
		$keys = array_column($array, $key);
		array_multisort($keys, $order, $array);
		return $array;
	}
	
	public static function subCategorize(
		$array, $id_index = 'id', $parent_index = 'parent_id', $sub_index = 'sub',
		$sort = true, $sort_index = 'sort', $sort_direction = 'ASC') {
		foreach ($array as $i => $a) {
			$array[$i][$sub_index] = $array[$i][$sub_index] ?? [];
			$array[$i]['sub_count'] = 0;
			foreach ($array as $j => $b) {
				if ($a[$id_index] == $b[$parent_index]) ++$array[$i]['sub_count'];
			}
		}
		foreach ($array as $i => $a) {
			if ($a['sub_count'] == 0) {
				foreach ($array as $j => $b) {
					if ($a[$parent_index] == $b[$id_index]) {
						$array[$j][$sub_index][] = $a;
						unset($array[$i]);
					}
				}
			}
		}
		foreach ($array as $i => $a) {
			$array[$i]['sub_count'] = 0;
			$array[$i][$sub_index] = self::sortAssociativeArrayByKey($array, $sort_index, $sort_direction);
		}
		$array = array_values($array);
		$still_has_sub = false;
		foreach ($array as $i => $a) {
			foreach ($array as $j => $b) {
				if ($a[$id_index] == $b[$parent_index]) $still_has_sub = true;
			}
		}
		if ($still_has_sub) return self::subCategorize($array, $id_index, $parent_index, $sub_index, $sort, $sort_index, $sort_direction);
		return $array;
	} // done : 1401.06.07
	
	//==============================
	
	/**
	 * A method for sorting associative arrays by a key and a direction.
	 * Direction can be ASC or DESC.
	 *
	 * @param $array
	 * @param $key
	 * @param $direction
	 * @return mixed $array
	 */
	public static function sortAssociativeArrayByKey($array, $key, $direction) {
		
		switch ($direction) {
			case "ASC":
				usort($array, function ($first, $second) use ($key) {
					return $first[$key] <=> $second[$key];
				});
				break;
			case "DESC":
				usort($array, function ($first, $second) use ($key) {
					return $second[$key] <=> $first[$key];
				});
				break;
			default:
				break;
		}
		
		return $array;
	}
	
	//==============================
}
