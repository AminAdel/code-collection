//---> Create	:	1396.05.21
//---> Finish	:	1396.05.21
//---> Update	:	--
/*****************************/
$(document).ready(function () {
	html = new class_html();
});

function class_html() {
	
	this.escape = function(str) {
		return str
			.replace(/&/g, '&amp;')
			.replace(/"/g, '&quot;')
			.replace(/'/g, '&#39;')
			.replace(/</g, '&lt;')
			.replace(/>/g, '&gt;')
			.replace(/\//g, '&#x2F;');
	}
	
	this.unEscape = function(str) {
		return str
			.replace(/&quot;/g, '"')
			.replace(/&#39;/g, "'")
			.replace(/&lt;/g, '<')
			.replace(/&gt;/g, '>')
			.replace(/&amp;/g, '&');
	}
}
