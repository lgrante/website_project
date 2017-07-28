<?php
function logInEmail($login, $hashedPassword) {

	include(DB_CONNECTION_PATH);

	$request = $bdd->prepare('SELECT id, username, email, password FROM users WHERE email = :email AND password = :password');
	$request->execute(array('email' => $login, 'password' => $hashedPassword));	

	return $request;

}