    <div class="changeUsername">
        <h3>Votre nom d'utilisateur</h3>
        <form method="post" id="formUsername">
            <table>
                <tr>
                    <td><label for="username">Nouveau nom d'utilisateur</label></td>
                    <td><input type="text" name="username" id="username"></td>
                    <td><span id="helpUsername"></span></td>
                </tr>
                <tr>
                    <td><br><input type="submit" name="changeUsername" value="Enregistrer les modifications" class="submitButton"></td>
                </tr>
            </table>
        </form>
    </div><br>

    <div class="changeEmail">
        <h3>Votre email</h3>
        <form method="post" id="formEmail">
            <table>
                <tr>
                    <td><label for="currentEmail">Adresse email actuelle</label></td>
                    <td><input type="text" name="currentEmail" id="currentEmail"></td>
                    <td><span id="helpCurrentEmail"></span></td>
                </tr>
                <tr>
                    <td><label for="newEmail">Nouvel email</label></td>
                    <td><input type="text" name="newEmail" id="newEmail"></td>
                    <td><span id="helpNewEmail"></span></td>
                </tr>
                <tr>
                    <td><br><input type="submit" name="changeEmail" value="Enregistrer les modifications" class="submitButton"></td>
                </tr>
            </table>
        </form>
    </div><br>

    <div class="changePassword">
        <h3>Changer votre mot de passe</h3>
        <form method="post" id="formPassword">
            <table>
                <tr>
                    <td><label for="formerPassword">Ancien mot de passe</label></td>
                    <td><input type="password" name="formerPassword" id="formerPassword"></td>
                    <td><span id="helpFormerPassword"></span></td>
                </tr>
                <tr>
                    <td><label for="newPassword">Nouveau mot de passe</label></td>
                    <td><input type="password" name="newPassword" id="newPassword"></td>
                    <td><span id="helpNewPassword"></span></td>
                </tr>
                <tr>
                    <td><label for="newPasswordConfirmation">Confirmation</label></td>
                    <td><input type="password" name="newPasswordConfirmation" id="newPasswordConfirmation"></td>
                    <td><span id="helpNewPasswordConfirmation"></span></td>
                </tr>
                <tr>
                    <td><br><input type="submit" name="changePassword" value="Enregistrer les modifications" class="submitButton"></td>
                </tr>
            </table>
        </form>
    </div><br>
</ul>
<script type="text/javascript" src="assets/js/functions.js"></script>
<script type="text/javascript" src="assets/js/profile_settings.js"></script>