<?php

function logInUsername($login, $hashedPassword) {

	include(DB_CONNECTION_PATH);

	$request = $bdd->prepare('SELECT id, username, email, password FROM users WHERE username = :username AND password = :password');
	$request->execute(array('username' => $login, 'password' => $hashedPassword));

	return $request;

}