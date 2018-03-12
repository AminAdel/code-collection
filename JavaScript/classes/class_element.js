//---> Create	:	1395.11.11
//---> Finish	:	--
//---> Update	:	--
/*****************************/
$(document).ready(function () {
	element = new class_element();
});


function class_element () {
	
	this.clicked = function(e, elementAccess) {
		/**
		 * checks if clicked inside an element area or not
		 * ***********************************************/
		if ($(elementAccess).is(':visible') == false) return false;
		
		var click_x = e.pageX;
		var click_y = e.pageY;
		var frame_left = $(elementAccess).offset().left; //console.log(frame_x);
		var frame_top = $(elementAccess).offset().top; //console.log(frame_x);
		var frame_width = $(elementAccess).width();
		var frame_height = $(elementAccess).height();
		
		if (click_x < frame_left) { return false; }
		if (click_y < frame_top) { return false; }
		if (click_x > frame_left + frame_width) { return false; }
		if (click_y > frame_top + frame_height) { return false; }
		
		return true;
	};
	
	this.visible = function(elementAccess, visibleValue) {
		/**
		 * Is the element on the window visible area?
		 * how much?
		 * ****************
		 * checks if an element is as visible as at least visibleValue;
		 */

		if ($(elementAccess).is(':visible') == false) return false;
		
		var window_height = $(window).height();
		var scroll_top = $(document).scrollTop();
		
		var offset_top = $(elementAccess).offset().top;
		var element_height = $(elementAccess).height();
		if (((scroll_top + window_height) > (offset_top + visibleValue)) && ((offset_top + element_height - visibleValue)) > scroll_top) {
			return true;
		}
		else {
			return false;
		}
	};
	
	this.getPositionRight = function(element) {
		var parent_width = $(element).parent().width();
		var element_width = $(element).width();
		
		return parent_width - $(element).position().left - element_width;
	}
	
}
