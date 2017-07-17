<?php 

//include_once('pages/header.php');

if(isset($_GET['p']) AND !empty($_GET['p'])) {

	switch ($_GET['p']) {
		case 'article':
			include('pages/article.php');
			break;
		
		case 'edition_article':
			include('pages/edition_article.php');
			break;

		case 'supprimer_article':
			include('pages/supprimer_article.php');
			break;

		case 'inscription':
			include('pages/inscription.php');
			break;

		case 'connection':
			include('pages/connection.php');
			break;

		case 'deconnection':
			include('pages/deconnection.php');
			break;

		case 'profil':
			include('pages/profil.php');
			break;

		default:
			include('pages/index.php');
			break;
			
	}

} else {

	include('pages/index.php');

}

//include_once('pages/footer.php');