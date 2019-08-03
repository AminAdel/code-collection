//---> Create	:	1396.05.14
//---> Finish	:	1396.05.14
//---> Update	:	1396.05.23
//---> Update	:	1398.03.22
/*****************************/

function isEmpty(str) {
	
	if (typeof str == "undefined") return true;
	
	switch (str) {
		case "":
		case 0:
		case "0":
		case null:
		case false:
		case typeof this == "undefined": // this line is extra; but i didn't remove
		case str.trim === "" :
			return true;
		default:
			return false;
	}
}
