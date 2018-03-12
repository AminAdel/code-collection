//---> Create	:	1396.05.29
//---> Finish	:	1396.05.29
//---> Update	:	--
/*****************************/
function getPersianMonth(number) {
	if (typeof number != 'number') return false;
	if (number <= 0  || number > 12) return false;
	
	var persianMonths = [
		'فروردین',
		'اردیبهشت',
		'خرداد',
		'تیر',
		'مرداد',
		'شهریور',
		'مهر',
		'آبان',
		'آذر',
		'دی',
		'بهمن',
		'اسفند'
	];
	return persianMonths[number - 1];
}
