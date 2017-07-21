var formUsername = document.getElementById('formUsername');
var formEmail = document.getElementById('formEmail');
var formPassword = document.getElementById('formPassword');

var currentUsernameElt = formUsername.elements.currentUsername;
var currentEmailElt = formEmail.elements.currentEmail;
var newEmailElt = formEmail.elements.newEmail;
var formerPasswordElt = formPassword.elements.formerPassword;
var newPassword = formPassword.elements.newPassword;

var preventForm = function(e) {

	e.preventDefault();

};

ajaxGet("json/users_list.json", function(response) {

	var results = JSON.parse(response);

	var correctEmailFormFields = [false, false];
	var correctPasswordFormFields = [false, false];

	currentUsernameElt.addEventListener("input", function(e) {

		var helpCurrentUsernameElt = document.getElementById('helpCurrentUsername');
		helpCurrentUsernameElt.textContent = '';

		var usernameTaken = false;

		for(i = 0; i<results.length; i++) {

			if(results[i].username === e.target.value) {

				usernameTaken = true;

			}
		}

		if(usernameTaken) {

			helpCurrentUsernameElt.textContent = 'Nom d\'utilisateur déjà utilisé';
			formUsername.addEventListener("submit", preventForm);

		} else {

			formUsername.removeEventListener("submit", preventForm);

		}

	});

	var helpCurrentEmailElt = document.getElementById('helpCurrentEmail');
	var helpNewEmailElt = document.getElementById('helpNewEmail');

	currentEmailElt.addEventListener("input", function(e) {

		helpCurrentEmailElt.textContent = '';
		helpCurrentEmailElt.style.fontWeight = 'normal';

		if(e.target.value !== currentUserEmail) {

			helpCurrentEmailElt.textContent = 'Cet email ne correspond pas au votre';
			correctEmailFormFields[0] = false;

		} else {

			correctEmailFormFields[0] = true;

		}

	});

	newEmailElt.addEventListener("input", function(e) {

		helpNewEmailElt.textContent = '';
		helpCurrentEmailElt.style.fontWeight = 'normal';
		var emailTaken = false;

		for (var i = 0; i < results.length; i++) {
			
			if(results[i].email === e.target.value) {

				emailTaken = true;

			}

		}

		if(emailTaken) {

			helpNewEmailElt.textContent = 'Cet email est déjà utilisé';
			correctEmailFormFields[1] = false

		} else {

			correctEmailFormFields[0] = true;

		}

	});

	formEmail.addEventListener("submit", function(e) {

		var checkedFields = 0;

		correctEmailFormFields.forEach(function (correctEmailFormField) {

			if(correctEmailFormField) {

				checkedFields++;

			}

		});

		if(checkedFields !== correctEmailFormFields.length) {

			e.preventDefault();
			helpCurrentEmailElt.style.fontWeight = 'bold';
			helpNewEmailElt.style.fontWeight = 'bold';

		}

	});

});

