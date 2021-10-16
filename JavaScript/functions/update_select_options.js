//---> Create	:	1400.07.24
//---> Finish	:	1400.07.24
//---> Update	:	--
/*****************************/
/*
 * this function requires jquery
 */
function update_select_options($target_id, $data, $value, $label, $selected_value = false, $keep_first = false) {
	let html = '';
	$data.forEach((item, index) => {
		html += '<option value="' + item[$value] + '">' + item[$label] + '</option>'
	});
	
	if ($keep_first === true) {
		let $first_one = $('#' + $target_id + ' option')[0].outerHTML; //console.log($first_one);
		html = $first_one + html;
	}
	
	$('#' + $target_id).html(html);
	
	if ($selected_value !== false) $('#' + $target_id).val($selected_value);
}
