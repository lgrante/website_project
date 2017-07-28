<?php

function addUser($username, $email, $hashedPassword) {

	include(DB_CONNECTION_PATH);

	$request = $bdd->prepare('INSERT INTO users(username, email, password, date_time_registration) VALUES(:username, :email, :password, NOW())');
	$request->execute(array('username' => $username, 'email' => $email, 'password' => $hashedPassword));

}