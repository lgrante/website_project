<?php 

session_start();

include('global/config.php');
include(DB_CONNECTION_PATH);

if(!isset($_SESSION['id'], $_SESSION['username'], $_SESSION['email'])) {

	include_once(DB_CONNECTION_PATH);

	if(isset($_POST['login'], $_POST['password'])) {

		if(!empty($_POST['login']) && !empty($_POST['password'])) {

			$login = htmlspecialchars($_POST['login']);
			$password = htmlspecialchars($_POST['password']);
			$hashedPassword = crypt($password, ',en*Kua#}KMm75RaDQ2gU(_hOb|pGN+ud2*>V|P/zL8si-jLre;wv<x)6K&-FKe1');

			if(preg_match('#@#', $login)) {

				include(MODEL_PATH . 'loging_in/log_in_email.php');
				$userLogin = logInEmail($login, $hashedPassword);


			} else {

				include(MODEL_PATH . 'loging_in/log_in_username.php');
				$userLogin = logInUsername($login, $hashedPassword);

			}

			if($userLogin->rowCount() == 1) {

				$userInformation = $userLogin->fetch();
				session_start();
				$_SESSION['id'] = $userInformation['id'];
				$_SESSION['username'] = $userInformation['username'];
				$_SESSION['email'] = $userInformation['email'];
				header('Location: index.php?connected');

			} else {
				
				$error = 'Mot de passe ou identifiant incorrect(e)';

			}

		} else {

			$error = 'Veuillez remplir tous les champs';

		}

	}

} else {

	header('Location: index.php');
}

include(VIEW_PATH . 'loging_in/loging_in.php');

?>