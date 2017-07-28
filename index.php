<?php 

include_once('global/head.php');
include_once('global/header.php');

if(isset($_GET['p']) AND !empty($_GET['p'])) {

	switch ($_GET['p']) {
		case 'article':
			include('controller/article.php');
			break;
		
		case 'article_edition':
			include('controller/article_edition.php');
			break;

		case 'remove_article':
			include('controller/remove_article.php');
			break;

		case 'registration':
			include('controller/registration.php');
			break;

		case 'loging_in':
			include('controller/loging_in.php');
			break;

		case 'loging_out':
			include('controller/loging_out.php');
			break;

		case 'profile':
			include('controller/profile.php');
			break;

		default:
			include('controller/main.php');
			break;
			
	}

} else {

	include('controller/main.php');

}

include_once('global/footer.php');