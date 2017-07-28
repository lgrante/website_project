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

			xhr = new XMLHttpRequest();

		}
		return xhr;

	} else {

		console.log('Your browser doesn\'t support XMLHttpRequest object');
		return null;
	}

}

function Form(form, checksNumber) {

	this.form = form;
	this.fields = {};
	this.submitButton;
	for(var i = 0, c = this.form.elements.length; i < c; i++) {

		this.fields[this.form.elements[i].name] = this.form.elements[i];

		if(this.form.elements[i].type === 'submit') {

			this.submitButton = this.form.elements[i];

		}

	}
	this.checks = [];
	this.checks.length = checksNumber;
	for(var i = 0, c = this.checks.length; i < c; i++) {

		this.checks[i] = false;

	}
	this.allCorrect = false;

	this.isTaken = function(field, fieldValue, checkNumber, callback) {

		var that = this;
		var xhr = getXMLHttpRequest();
		xhr.onreadystatechange = function() {

            if(xhr.readyState === 4 && (xhr.status === 0 || xhr.status === 200)) {

                that.checks[checkNumber] = xhr.responseText === '1'; // Si le test est positif checks est vrai.
                callback();

            }

        }
        xhr.open('GET', 'inc/user_information_process.php?' + field + '=' + fieldValue, true);
        xhr.send(null);

	};
	this.isMailCorrect = function(fieldValue, checkNumber) {

		var regex = /^([0-9a-zA-Z]([-_\\.]*[0-9a-zA-Z]+)*)@([0-9a-zA-Z]([-_\\.]*[0-9a-zA-Z]+)*)[\\.]([a-zA-Z]{2,9})$/;
    	this.checks[checkNumber] = regex.test(fieldValue);

	};
	this.isPasswordCorrect = function(fieldValue, checkNumber) {

		var passwordLength = fieldValue.length;
		this.checks[checkNumber] = !(passwordLength > 0 && passwordLength < 6);

	};
	this.isSamePassword = function(firstFieldValue, secondFieldValue, checkNumber) {

		this.checks[checkNumber] = firstFieldValue === secondFieldValue;

	};
	this.displayMessage = function(helpField, helpMessage, messageColor) {

		helpField.style.color = messageColor;
		helpField.textContent = helpMessage;

	};
	this.disableForm = function(e) {

		e.preventDefault();

	}
	this.formAction = function() {

		function checkTrue(field) {

			return field === true;

		}
		function isNotEmpty(fields) {

			var notEmpty = true;
			for(var field in fields) {

				if(fields[field].value === '') {

					notEmpty = false;

				}

			}
			return notEmpty;

		}
		var fieldsCorrect = this.checks.every(checkTrue);
		var fieldsNotEmpty = isNotEmpty(this.fields);

		this.allCorrect = fieldsCorrect && fieldsNotEmpty;

		if(!this.allCorrect) {

			this.form.addEventListener('submit', this.disableForm);
			this.submitButton.disabled = true;

		} else {

			this.form.removeEventListener('submit', this.disableForm);
			this.submitButton.disabled = false;

		}

	};

}