<?php 

//include_once('pages/header.php');

if(isset($_GET['p']) AND !empty($_GET['p'])) {

	switch ($_GET['p']) {
		case 'article':
			include('pages/article.php');
			break;
		
		case 'articleEdition':
			include('pages/articleEdition.php');
			break;

		case 'removeArticle':
			include('pages/removeArticle.php');
			break;

		case 'registration':
			include('pages/registration.php');
			break;

		case 'logingIn':
			include('pages/logingIn.php');
			break;

		case 'logingOut':
			include('pages/logingOut.php');
			break;

		case 'profile':
			include('pages/profile.php');
			break;

		default:
			include('pages/index.php');
			break;
			
	}

} else {

	include('pages/index.php');

}

//include_once('pages/footer.php');