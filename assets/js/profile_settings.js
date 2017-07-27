var usernameForm = new Form(document.getElementById('formUsername'), 1);

usernameForm.fields.username.addEventListener('input', function (e) {

    usernameForm.isTaken('username', e.target.value, 0, function () {

        var message = (usernameForm.checks[0]) ? '' : 'Ce nom d\'utilisateur est déjà utilisé';
        var borderColor = (usernameForm.checks[0]) ? 'green' : 'red';
        usernameForm.displayMessage(document.getElementById('helpUsername'), message, 'red');
        usernameForm.fields.username.style.border = '2px solid ' + borderColor;
        usernameForm.formAction();

    });

});

var emailForm = new Form(document.getElementById('formEmail'), 3);

emailForm.fields.currentEmail.addEventListener('input', function (e) {

    emailForm.isTaken('currentEmail', e.target.value, 0, function() {

        var message = (emailForm.checks[0]) ? '' : 'Cet email ne correspond pas à votre email actuel';
        var borderColor = (emailForm.checks[0]) ? 'green' : 'red';
        emailForm.displayMessage(document.getElementById('helpCurrentEmail'), message, 'red');
        emailForm.fields.currentEmail.style.border = '2px solid ' + borderColor;
        emailForm.formAction();

    });

});

emailForm.fields.newEmail.addEventListener('input', function(e) {

    var helpNewEmail = document.getElementById('helpNewEmail');
    emailForm.isTaken('newEmail', e.target.value, 1, function() {

        emailForm.isMailCorrect(e.target.value, 2);
        if(!emailForm.checks[1] || !emailForm.checks[2]) {

            if(!emailForm.checks[1]) {

                emailForm.displayMessage(helpNewEmail, 'Cet email est déjà utilisé', 'red');
                emailForm.fields.newEmail.style.border = '2px solid red';

            } else {

                emailForm.displayMessage(helpNewEmail, 'Email invalide', 'red');
                emailForm.fields.newEmail.style.border = '2px solid red';

            }

        } else {

            emailForm.displayMessage(helpNewEmail, '');
            emailForm.fields.newEmail.style.border = '2px solid green';

        }

        emailForm.formAction();

    });

});

passwordForm = new Form(document.getElementById('formPassword'), 3);

passwordForm.fields.formerPassword.addEventListener('blur', function (e) {

    passwordForm.isTaken('formerPassword', e.target.value, 0, function() {

        var message = (passwordForm.checks[0]) ? '' : 'Mot de passe incorrect';
        var borderColor = (passwordForm.checks[0]) ? 'green' : 'red';
        passwordForm.displayMessage(document.getElementById('helpFormerPassword'), message, 'red');
        passwordForm.fields.formerPassword.style.border = '2px solid ' + borderColor;
        passwordForm.formAction();

    });

});

passwordForm.fields.newPassword.addEventListener('input', function (e) {

    passwordForm.isPasswordCorrect(e.target.value, 1);
    passwordForm.isSamePassword(e.target.value, passwordForm.fields['newPasswordConfirmation'].value, 2);
    var message = '';
    var color;
    var borderColor;
    if(passwordForm.checks[1]) {

        var passwordLength = e.target.value.length;
        borderColor = 'green';
        if(passwordLength >= 6 && passwordLength < 8) {

            message = 'Moyen (un mot de passe plus long est fortement recommandé)';
            color = 'orange';

        } else if(passwordLength >= 8 && passwordLength < 10) {

            message = 'Fort';
            color = 'green';

        } else if(passwordLength > 10) {

            message = 'Très fort';
            color = 'green';

        }

    } else {

        message = 'Très faible';
        borderColor = 'red';
        color = 'red'

    }
    passwordForm.displayMessage(document.getElementById('helpNewPassword'), message, color);
    passwordForm.fields.newPassword.style.border = '2px solid ' + borderColor;
    var message = (passwordForm.checks[2]) ? '' : 'Les deux mots de passe ne correspondent pas';
    passwordForm.displayMessage(document.getElementById('helpNewPasswordConfirmation'), message, 'red');

    passwordForm.formAction();

});

passwordForm.fields.newPasswordConfirmation.addEventListener('input', function(e) {

    passwordForm.isSamePassword(e.target.value, passwordForm.fields['newPassword'].value, 2);
    var message = (passwordForm.checks[2]) ? '' : 'Les deux mots de passe ne correspondent pas';
    var borderColor = (passwordForm.checks[2]) ? 'green' : 'red';
    passwordForm.displayMessage(document.getElementById('helpNewPasswordConfirmation'), message, 'red');
    passwordForm.fields.newPasswordConfirmation.style.border = '2px solid ' + borderColor; 
    passwordForm.formAction();

}); 