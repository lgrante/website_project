<?php

include_once('inc/connection_bdd.php');

if(isset($_POST['email'], $_POST['username'], $_POST['password'], $_POST['password_check'])) {
	$email = htmlspecialchars($_POST['email']);
	$username = htmlspecialchars($_POST['username']);
	$password = htmlspecialchars($_POST['password']);
	$password_check = htmlspecialchars($_POST['password_check']);

	$usernamesTaken = $bdd->prepare('SELECT username, email FROM users WHERE username = :username OR email = :email');
	$usernamesTaken->execute(array('username' => $username, 'email' => $email));

	if($usernamesTaken->rowCount() == 0) {
		// On continue
		$hashedPassword = crypt($password, ',en*Kua#}KMm75RaDQ2gU(_hOb|pGN+ud2*>V|P/zL8si-jLre;wv<x)6K&-FKe1');

		$request = $bdd->prepare('INSERT INTO users (username, email, password, date_time_registration) VALUES(:username, :email, :password, NOW())');
		$request->execute(array('username' => $username, 'email' => $email, 'password' => $hashedPassword));

		header('Location: connection.php?first_connection');
	} else {

		$idTaken = $usernamesTaken->fetch();

		if($username == $idTaken['username'] && $email == $idTaken['email']) {

			$error = 'Le nom d\'utilisateur est l\'adresse email renseignés sont déjà utilisé';
		} else if($username == $idTaken['username']) {

			$error = 'Ce nom d\'utilisateur est déjà utilisé';
		} else {

			$error = 'Cette adresse email est déjà utilisée';
		}
	}
}

?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8" />
        <title>Mon blog</title>
    	<link href="css/style.css" rel="stylesheet" /> 
    </head>
        
    <body>
    	<h3>Inscrivez vous pour pouvoir rédiger vos propres articles pour la communauté !</h3>
	    <form method="post">
	    	<table>
	    		<tr>
	    			<td>Votre email :</td>
	    			<td><input type="text" name="email" placeholder="aa@aa.aa"></td>
	    		</tr>
	    		<tr>
	    			<td>Nom d'utilisateur</td>
	    			<td><input type="text" name="username" placeholder="Tesla"></td>
	    		</tr>
	    		<tr>
	    			<td>Mot de passe</td>
	    			<td><input type="password" name="password"></td>
	    		</tr>
	    		<tr>
	    			<td>Confirmation du mot de passe</td>
	    			<td><input type="password" name="password_check"></td>
	    		</tr>
	    		<tr>
	    			<td></td>
	    			<td><br />
	    				<input type="submit" value="Valider !">
	    			</td>
	    		</tr>
	    	</table>
	    	<div id="errorArea">
	    		<p style="color: red;"><?php if(isset($error)) { echo $error; } ?></p>
	    	</div>
    	</form>
	</body>
</html>