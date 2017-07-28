<?php

session_start();
include('global/config.php');

if(!isset($_SESSION['id'], $_SESSION['username'], $_SESSION['email'])) {

	include_once(DB_CONNECTION_PATH);

	if(isset($_POST['email'], $_POST['username'], $_POST['password'], $_POST['password_confirm'])) {
		$email = htmlspecialchars($_POST['email']);
		$username = htmlspecialchars($_POST['username']);
		$password = htmlspecialchars($_POST['password']);
		$password_check = htmlspecialchars($_POST['password_confirm']);

		$hashedPassword = crypt($password, ',en*Kua#}KMm75RaDQ2gU(_hOb|pGN+ud2*>V|P/zL8si-jLre;wv<x)6K&-FKe1');

		include(MODEL_PATH . 'registration/add_user.php');
		addUser($username, $email, $hashedPassword);

		header('Location: index.php?p=loging_in&first_connection');
	}
} else {

	header('Location: index.php');
}

include(VIEW_PATH . 'registration/registration.php');

?>