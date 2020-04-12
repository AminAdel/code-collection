//---> Create	:	1396.05.14
//---> Finish	:	1396.05.14
//---> Update	:	1396.05.23
//---> Update	:	1398.03.22
/*****************************/

function isEmpty(str) {
	if (typeof str == "undefined")      return true;
        if (str === null || str === false)  return true;
        if (str === 0 || str === "0")       return true;
        if (str.trim() === "")              return true;
        
        return false;
}
