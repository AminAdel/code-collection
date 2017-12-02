$(document).ready(function () {
	// usage :
	// <i>aaa</i> : $('i').toggleText('aaa', 'bbb');
	$.fn.extend({
		toggleText: function(a, b) {
			return this.text(this.text() == b ? a : b);
		}
	})
});
