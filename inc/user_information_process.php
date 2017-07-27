<?php 

session_start();

header('Content-Type: text/plain');

include_once('connection_bdd.php');

$response = '';

if(isset($_GET['username']) || isset($_GET['newEmail'])) {

	if(isset($_GET['username'])) {

		if(isset($_SESSION['username'])) {

			if(htmlspecialchars($_GET['username']) != $_SESSION['username']) {

				$request = $bdd->prepare('SELECT * FROM users WHERE username = :username');
				$request->execute(array('username' => htmlspecialchars($_GET['username'])));
				$response = ($request->rowCount() == 1) ? '0' : '1';

			} else {

				$response = '1';

			}

		} else {

			$request = $bdd->prepare('SELECT * FROM users WHERE username = :username');
			$request->execute(array('username' => htmlspecialchars($_GET['username'])));
			$response = ($request->rowCount() == 1) ? '0' : '1';

		}

	} else {

		if(isset($_SESSION['email'])) {

			if(htmlspecialchars($_GET['newEmail']) != $_SESSION['email']) {

				$request = $bdd->prepare('SELECT * FROM users WHERE email = :email');
				$request->execute(array('email' => htmlspecialchars($_GET['newEmail'])));
				$response = ($request->rowCount() == 1) ? '0' : '1';

			} else {

				$response = '1';

			}

		} else {

			$request = $bdd->prepare('SELECT * FROM users WHERE email = :email');
			$request->execute(array('email' => htmlspecialchars($_GET['newEmail'])));
			$response = ($request->rowCount() == 1) ? '0' : '1';

		}

	}

} else if(isset($_GET['currentEmail']) || isset($_GET['formerPassword'])) {

	if(isset($_GET['currentEmail'])) {

		$request = $bdd->prepare('SELECT * FROM users WHERE email = :email AND username = :username');
		$request->execute(array('email' => htmlspecialchars($_GET['currentEmail']), 'username' => $_SESSION['username']));
		$response = ($request->rowCount() == 1) ? '1' : '0';		

	} else {
		$password = crypt(htmlspecialchars($_GET['formerPassword']), ',en*Kua#}KMm75RaDQ2gU(_hOb|pGN+ud2*>V|P/zL8si-jLre;wv<x)6K&-FKe1');
		$request = $bdd->prepare('SELECT * FROM users WHERE password = :password AND username = :username');
		$request->execute(array('password' => $password, 'username' => $_SESSION['username']));
		$response = ($request->rowCount() == 1) ? '1' : '0';

	}

}
echo $response;
