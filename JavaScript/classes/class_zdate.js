//---> Create	:	1398.01.24
//---> Finish	:	1398.01.25
//---> Update	:	--
/*****************************/
$(document).ready(function () {
	zdate = new class_zdate();
});

// requires persian-date : https://github.com/babakhani/PersianDate
function class_zdate () {
	
	this.unix_explode = function(unix_time) {
		var day = new persianDate(parseInt(unix_time + '000')); //console.log(day);
		// return '';
		return day.format('YYYY') + '/' + day.format('MM') + '/' + day.format('DD');
	}
	
}
