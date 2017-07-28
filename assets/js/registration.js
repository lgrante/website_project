var form = new Form(document.querySelector('form'), 5);

form.fields.email.addEventListener('input', function(e) {

    var helpEmail = document.getElementById('helpEmail');
    form.isTaken('newEmail', e.target.value, 0, function() {

        form.isMailCorrect(e.target.value, 1);
        if(!form.checks[0] || !form.checks[1]) {

            if(!form.checks[0]) {

                form.displayMessage(helpEmail, 'Cet email est déjà utilisé', 'red');
                form.fields.email.style.border = '2px solid red';

            } else {

                form.displayMessage(helpEmail, 'Email invalide', 'red');
                form.fields.email.style.border = '2px solid red';

            }

        } else {

            form.displayMessage(helpEmail, '');
            form.fields.email.style.border = '2px solid green';

        }

        form.formAction();

    });

});

form.fields.username.addEventListener('input', function (e) {

    form.isTaken('username', e.target.value, 2, function () {

        var message = (form.checks[2]) ? '' : 'Ce nom d\'utilisateur est déjà utilisé';
        var borderColor = (form.checks[2]) ? 'green' : 'red';
        form.displayMessage(document.getElementById('helpUsername'), message, 'red');
        form.fields.username.style.border = '2px solid ' + borderColor;
        form.formAction();

    });

});

form.fields.password.addEventListener('input', function (e) {

    form.isPasswordCorrect(e.target.value, 3);
    form.isSamePassword(e.target.value, form.fields['password_confirm'].value, 4);
    var message = '';
    var color;
    var borderColor;
    if(form.checks[3]) {

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
    form.displayMessage(document.getElementById('helpPassword'), message, color);
    form.fields.password.style.border = '2px solid ' + borderColor;
    var message = (form.checks[4]) ? '' : 'Les deux mots de passe ne correspondent pas';
    form.displayMessage(document.getElementById('helpPasswordConfirm'), message, 'red');

    form.formAction();

});

form.fields.password_confirm.addEventListener('input', function(e) {

    form.isSamePassword(e.target.value, form.fields['password'].value, 4);
    var message = (form.checks[4]) ? '' : 'Les deux mots de passe ne correspondent pas';
    var borderColor = (form.checks[4]) ? 'green' : 'red';
    form.displayMessage(document.getElementById('helpPasswordConfirm'), message, 'red');
    form.fields.password_confirm.style.border = '2px solid ' + borderColor; 
    form.formAction();

}); 