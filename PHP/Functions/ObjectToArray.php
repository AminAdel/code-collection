<?php

function objectToArray($objectOrArray) {
	/*
	 * version 3.0.0
	****************/
	
	// if is_json -> decode :
	if (is_string($objectOrArray)  &&  is_json($objectOrArray)) $objectOrArray = json_decode($objectOrArray);
	
	// if object -> convert to array :
	if (is_object($objectOrArray)) $objectOrArray = (array) $objectOrArray;
	
	// if not array -> just return it (probably string or number) :
	if (!is_array($objectOrArray)) return $objectOrArray;
	
	// if empty array -> return [] :
	if (count($objectOrArray) == 0) return [];
	
	// repeat tasks for each item :
	$output = [];
	foreach ($objectOrArray as $key => $o_a) {
		$output[$key] = objectToArray($o_a);
	}
	return $output;
}
