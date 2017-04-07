<?php 

include_once('inc/connection_bdd.php');

if(isset($_POST['login'], $_POST['password'])) {
	$login = htmlspecialchars($_POST['login']);
	$password = htmlspecialchars($_POST['password']);
	$hashedPassword = crypt($password, ',en*Kua#}KMm75RaDQ2gU(_hOb|pGN+ud2*>V|P/zL8si-jLre;wv<x)6K&-FKe1');

	$userLogin = $bdd->prepare('SELECT id, username, email, password FROM users WHERE username = :username OR email = :email AND password = :password');
	$userLogin->execute(array('username' => $login, 'email' => $login, 'password' => $hashedPassword));

	$resultat = $userLogin->fetch();

	if($resultat) {      

		session_start();
		$_SESSION['id'] = $resultat['id'];
		$_SESSION['username'] = $resultat['username'];
		$_SESSION['email'] = $resultat['email'];
		header('Location: index.php?connected');
	} else {
		$error = 'Mot de passe ou identifiant incorrect(e)';
	}
}

?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8" />
        <title>Mon blog</title>
    	<link href="style/style.css" rel="stylesheet" /> 
    </head>
        
    <body>
    	<h3>Connectez vous à votre compte pour rejoindre la communauté !</h3>
	    <form method="post">
	    	<table>
	    		<tr>
	    			<td><label for="login">Email ou nom d'utilisateur</label></td>
	    			<td><input type="text" name="login" placeholder="Tesla ou aa@aa.aa"></td>
	    		</tr>
	    		<tr>
	    			<td><label for="password">Mot de passe</label></td>
	    			<td><input type="password" name="password" placeholder="Tesla"></td>
	    		</tr>
	    		<tr>
	    			<td><a href="inscription.php">Je n'ai pas de compte</a></td>
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