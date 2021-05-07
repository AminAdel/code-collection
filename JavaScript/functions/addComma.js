//---> Create	:	1396.08.25
//---> Finish	:	1400.02.17
//---> Update	:	--
/*****************************/
function add_comma(num) {
	num =  num.trim();
	let num_split = num.split('.');
	num_split[0] = num_split[0].replace(/\D/g,'');
	if (num_split[0].length === 0) { num_split[0] = '0'; }
	let num1 = num_split[0];
	num1 = num1.split("").reverse(); // array
	let output_num = '';
	for (let i = 1; i <= num1.length; i++) {
		output_num += num1[i-1];
		if (i % 3 === 0 && i < num1.length) output_num += ',';
	}
	output_num = output_num.split("").reverse().join("");
	if (num_split.length > 1 && parseInt(num_split[1]) > 0) {
		num_split[1] = num_split[1].replace(/\D/g,'');
		output_num += '.' + num_split[1];
	}
	return output_num;
}
