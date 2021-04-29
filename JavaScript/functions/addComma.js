//---> Create	:	1396.08.25
//---> Finish	:	1396.08.25
//---> Update	:	--
/*****************************/
function addComma(num) {
	// return (new Intl.NumberFormat().format(num)); // this does not work good;
	let temp =  num.trim();
	temp = temp.replace(/\D/g,'');
	temp = temp.split("").reverse(); // array
	let output_num = '';
	for (let i = 1; i <= temp.length; i++) {
		output_num += temp[i-1];
		if (i % 3 === 0 && i < temp.length) output_num += ',';
	}
	output_num = output_num.split("").reverse().join("");
	return output_num;
}
