//---> Create	:	1395.11.11
//---> Finish	:	--
//---> Update	:	--
/*****************************/
$(document).ready(function () {
	form = new class_form();
});
function class_form () {
	
	this.isInt = function (value) {
		if(Math.floor(id) == id && $.isNumeric(id)) return true;
		return false;
	}
	
	this.isEmail = function (email) {
		var re = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
		return re.test(email);
	}
}
