<?php

session_start();

if(!isset($_SESSION['id'], $_SESSION['username'], $_SESSION['email'])) {

	include_once('inc/connection_bdd.php');

	if(isset($_POST['email'], $_POST['username'], $_POST['password'], $_POST['passwordConfirm'])) {
		$email = htmlspecialchars($_POST['email']);
		$username = htmlspecialchars($_POST['username']);
		$password = htmlspecialchars($_POST['password']);
		$password_check = htmlspecialchars($_POST['password_check']);

		$hashedPassword = crypt($password, ',en*Kua#}KMm75RaDQ2gU(_hOb|pGN+ud2*>V|P/zL8si-jLre;wv<x)6K&-FKe1');

		$request = $bdd->prepare('INSERT INTO users (username, email, password, date_time_registration) VALUES(:username, :email, :password, NOW())');
		$request->execute(array('username' => $username, 'email' => $email, 'password' => $hashedPassword));

		header('Location: index.php?p=logingIn&first_connection');
	}
} else {

	header('Location: index.php');
}

?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8" />
        <title>Mon blog</title> 
    </head>
        
    <body>
    	<h3>Inscrivez vous pour pouvoir rédiger vos propres articles pour la communauté !</h3>
	    <form method="post">
	    	<table>
	    		<tr>
	    			<td><label for="email">Votre email :</label></td>
	    			<td><input type="text" name="email" placeholder="aa@aa.aa"></td>
	    			<td><span id="helpEmail"></span></td>
	    		</tr>
	    		<tr>
	    			<td><label for="username">Nom d'utilisateur :</label></td>
	    			<td><input type="text" name="username" placeholder="Tesla"></td>
	    			<td><span id="helpUsername"></span></td>
	    		</tr>
	    		<tr>
	    			<td><label for="password">Mot de passe :</label></td>
	    			<td><input type="password" name="password"></td>
	    			<td><span id="helpPassword"></span></td>
	    		</tr>
	    		<tr>
	    			<td><label for="passwordConfirm">Confirmation du mot de passe :</label></td>
	    			<td><input type="password" name="passwordConfirm"></td>
	    			<td><span id="helpPasswordConfirm"></span></td>
	    		</tr>
	    		<tr>
	    			<td></td>
	    			<td><br />
	    				<input id="submitRegister" type="submit" value="Valider !">
	    			</td>
	    		</tr>
	    	</table>
	    	<div id="errorArea">
	    	</div>
    	</form>
    	<script type="text/javascript" src="assets/js/functions.js"></script>
    	<script type="text/javascript" src="assets/js/registration.js"></script>
	</body>
</html>
