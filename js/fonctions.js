function emailValidate(email) {
	var regex = /^([0-9a-zA-Z]([-_\\.]*[0-9a-zA-Z]+)*)@([0-9a-zA-Z]([-_\\.]*[0-9a-zA-Z]+)*)[\\.]([a-zA-Z]{2,9})$/;

	return regex.test(email);
}

function ajaxGet(url, callback) {
	var request = new XMLHttpRequest();
	request.open("GET", url);
	request.addEventListener("load", function () {
		if(request.status >= 200 && request.status < 400) {
			callback(request.responseText);
		} else {
			console.error(request.status + " " + request.statusText + " " + url);
		}
	});
	request.addEventListener("error", function () {
		console.error('Erreur réseau');
	});
	request.send(null);
}