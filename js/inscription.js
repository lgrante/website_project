var form = document.querySelector('form');

var emailElt = form.elements.email;
var usernameElt = form.elements.username;
var passwordElt = form.elements.password;
var passwordCheckElt = form.elements.password_check;
var submitElt = document.getElementById("submitRegister");

var helpEmailElt = document.getElementById('helpEmail');
var helpUsernameElt = document.getElementById('helpUsername');
var passwordHelp = document.getElementById('helpPassword');

var correctFields = [false, false, false, false];

ajaxGet("http://localhost/website_project/json/users_list.json", function(response) {

	var results = JSON.parse(response);

	emailElt.addEventListener("input", function (e) { // TO DO : Remplacer ces morceaux de code par une fonction pour éviter les répétitions.

		helpEmailElt.textContent = '';
		var message = '';
		var email = e.target.value;
		var emailTaken;

		for(i = 0; i<results.length; i++) { // TO DO : mettre un ptn de while espèce d'abruti, afin que la boucle s'arrête lorsqu'on a trouvé un email ou un username égal à celui rentré.

			if(results[i].email === e.target.value) {

				correctFields[0] = false;

				message = 'Cette email est déjà utilisée';
			} else if (!emailValidate(email)) {

				if(email !== '') {

					correctFields[0] = false;

					message = 'Email non valide';
				}
			} else {

				correctFields[0] = true;
			}
		}

		helpEmailElt.textContent = message;
	});

	usernameElt.addEventListener("input", function (e) {

		helpUsernameElt.textContent = '';

		for(i = 0; i<results.length; i++) {

			if(results[i].username === e.target.value) {

				correctFields[1] = false;

				helpUsernameElt.textContent = 'Ce nom d\'utilisateur est déjà utilisé';
			} else {

				correctFields[1] = true;
			}
		}
	});
});

passwordElt.addEventListener("input", function (e) {

	var passwordLength = e.target.value.length;
	var message = '';

	if(passwordLength >= 0 && passwordLength < 6) {

		correctFields[2] = false;

		message = 'Très faible';
		passwordHelp.style.color = 'red';
	} else {

		correctFields[2] = true;

		if(passwordLength >= 6 && passwordLength < 8) {

			message = 'Moyen (nous vous conseillons un mot de passe plus long)';
			passwordHelp.style.color = 'orange';
		} else if(passwordLength >= 8 && passwordLength < 10) {

			message = 'Fort';
			passwordHelp.style.color = 'green';
		} else {

			message = 'Très fort';
		}
	}

	passwordHelp.textContent = 'Force du mot de passe : ' + message;
});

passwordCheckElt.addEventListener("input", function (e) {

	var helpPasswordCheck = document.getElementById('helpPasswordCheck');

	if(e.target.value != passwordElt.value) {

		correctFields[3] = false;

		helpPasswordCheck.textContent = 'Les deux mots de passe ne correspondent pas';
		helpPasswordCheck.style.color = 'red';
	} else {

		correctFields[3] = true;

		helpPasswordCheck.textContent = '';
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

		console.log('Champs incorrects');
	}
})