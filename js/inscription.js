var form = document.querySelector('form');

var emailElt = form.elements.email;
var usernameElt = form.elements.username;
var passwordElt = form.elements.password;
var passwordCheckElt = form.elements.password_check;
var submitElt = document.getElementById("submitRegister");

var helpEmailElt = document.getElementById('helpEmail');
var helpUsernameElt = document.getElementById('helpUsername');
var helpPasswordElt = document.getElementById('helpPassword');
var helpPasswordCheckElt = document.getElementById('helpPasswordCheck');

var correctFields = [false, false, false, false];
var message = '';

helpEmailElt.style.color = 'red';
helpUsernameElt.style.color = 'red';

ajaxGet("http://localhost/website_project/json/users_list.json", function(response) {

	var results = JSON.parse(response);

	emailElt.addEventListener("input", function (e) { // TO DO : Remplacer ces morceaux de code par une fonction pour éviter les répétitions.

		helpEmailElt.textContent = '';
		message = '';
		helpEmailElt.style.fontWeight = 'normal';

		var email = e.target.value;
		var emailTaken = false;

		for(i = 0; i<results.length; i++) {

			if(results[i].email === email) {

				emailTaken = true;
			}
		}
		if(!emailTaken && emailValidate(email)) {

			correctFields[0] = true;

			emailElt.style.border = '2px solid green'; 
		} else {

			correctFields[0] = false;
			emailElt.style.border = '2px solid red';

			if(emailTaken) {

				message = 'Cette email est déjà utilisée';
			} else {

				message = 'Email non valide';
			}
		}

		helpEmailElt.textContent = message;
	});

	usernameElt.addEventListener("input", function (e) {

		helpUsernameElt.textContent = '';
		helpUsernameElt.style.fontWeight = 'normal';
		var usernameTaken = false;

		for(i = 0; i<results.length; i++) {

			if(results[i].username === e.target.value) {

				usernameTaken = true;
			}
		}
		if(!usernameTaken) {

			correctFields[1] = true;

			usernameElt.style.border = '2px solid green';
		} else {

			correctFields[1] = false;

			helpUsernameElt.textContent = 'Ce nom d\'utilisateur est déjà utilisé';
			usernameElt.style.border = '2px solid red';
		}
	});
});

passwordElt.addEventListener("input", function (e) {

	var passwordLength = e.target.value.length;
	helpPasswordElt.textContent = '';
	message = '';
	helpPasswordElt.style.fontWeight = 'normal';

	if(passwordLength >= 0 && passwordLength < 6) {

		correctFields[2] = false;

		passwordElt.style.border = '2px solid red';
		message = 'Très faible';
		helpPasswordElt.style.color = 'red';
	} else {

		correctFields[2] = true;
		
		passwordElt.style.border = '2px solid green';

		if(passwordLength >= 6 && passwordLength < 8) {

			message = 'Moyen (nous vous conseillons un mot de passe plus long)';
			helpPasswordElt.style.color = 'orange';
		} else if(passwordLength >= 8 && passwordLength < 10) {

			message = 'Fort';
			helpPasswordElt.style.color = 'green';
		} else {

			message = 'Très fort';
		}
	}

	if(passwordCheckElt.value !== '') {

		if(e.target.value !== passwordCheckElt.value) {

			helpPasswordCheckElt.textContent = 'Les deux mots de passe ne correspondent pas';
		}
	}

	helpPasswordElt.textContent = 'Force du mot de passe : ' + message;
});

passwordCheckElt.addEventListener("input", function (e) {

	var passwordCheck = e.target.value;
	helpPasswordCheckElt.textContent = '';
	helpPasswordCheckElt.style.fontWeight = 'normal';

	if(passwordCheck !== passwordElt.value || passwordElt.value.length < 6) {

		correctFields[3] = false;

		passwordCheckElt.style.border = '2px solid red';
		if(passwordCheck !== passwordElt.value) {

			helpPasswordCheckElt.textContent = 'Les deux mots de passe ne correspondent pas';
			helpPasswordCheckElt.style.color = 'red';
		}
	} else {

		correctFields[3] = true;

		passwordCheckElt.style.border = '2px solid green';
		helpPasswordCheckElt.textContent = '';
	}
});

form.addEventListener("submit", function(e) {

	var checkedFields = 0;

	correctFields.forEach(function (correctField) {

		if(correctField) {

			checkedFields++;
		}  
	});
	if(checkedFields === correctFields.length) {

		console.log('Tous les champs sont corrects');
	} else {

		e.preventDefault();

		helpEmailElt.style.fontWeight = 'bold';
		helpUsernameElt.style.fontWeight = 'bold';
		helpPasswordCheckElt.style.fontWeight = 'bold';
		if(passwordElt.value.length < 6) {
			helpPasswordElt.style.fontWeight = 'bold';
		}
	}
});