//---> Create	:	1396.05.14
//---> Finish	:	1396.05.14
//---> Update	:	1396.05.23
/*****************************/

function isEmpty(str) {
	
	if (typeof str == "undefined") return true;
	
	switch (str) {
		case "":
		case str.trim == "" :
		case 0:
		case "0":
		case null:
		case false:
		case typeof this == "undefined": // this line is extra; but i didn't remove
			return true;
		default:
			return false;
	}
}
