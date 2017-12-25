//---> Create	:	1396.10.04
//---> Finish	:	1396.10.04
//---> Update	:	--
/*****************************/
$(document).ready(function () {
	if ($('.toggleSubContent').length === 0) return;
	
	$('.toggleSubContent').click(function(e) {
		if (e.which !== 1) return;
		
		if ($(this).hasClass('open')) {
			$(this).find('> .subContent').fadeOut(100);
		} else {
			$(this).find('> .subContent').fadeIn(200);
		}
		$(this).toggleClass('open');
	});
});
