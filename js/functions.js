// gets a query string variable
function getQueryVariable(variable) {
	var query = window.location.search.substring(1);
	var vars = query.split("&");
	for (var i = 0; i < vars.length; i++) {
		var pair = vars[i].split("=");
		if (pair[0] == variable) {
			return pair[1];
		}
	}
}

// returns integer value
function intVal(v) {
	v = parseInt(v);
	return isNaN(v) ? 0 : v;
}

// returns last number of an ID
function getNumById(id) {
	var num = id.substring(id.lastIndexOf("-") + 1)
	return num;
}

// forwards to a URL
// setTimeout("autoForward('/')", 3000);
function autoForward(url) {
	window.location = document.location.protocol + '//' + document.domain + url;
}