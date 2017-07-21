function emailValidate(email) {
	var regex = /^([0-9a-zA-Z]([-_\\.]*[0-9a-zA-Z]+)*)@([0-9a-zA-Z]([-_\\.]*[0-9a-zA-Z]+)*)[\\.]([a-zA-Z]{2,9})$/;

	return regex.test(email);
}

function getXMLHttpRequest() {

	var xhr = null;

	if(window.getXMLHttpRequest || window.ActiveXObject) {

		if(window.ActiveXObject) {

			try {

				xhr = new ActiveXObject('Msxml2.XMLHTTP');

			} catch(e) {

				xhr = new ActiveXObject('Microsoft.XMLHTTP');

			}

		} else {

			console.log('Your browser don\' support XMLHttpRequest object...');
			return null;

		}

		return xhr;

	}

}