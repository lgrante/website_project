<?php

session_start();

include('global/config.php');
include_once(DB_CONNECTION_PATH);

include(MODEL_PATH . 'article/get_maxid_article.php');
$maxId = getMaxId();

if(isset($_GET['id']) AND !empty($_GET['id']) AND $_GET['id'] <= $maxId['max_id']) { // Si on a bien l'id de l'article qui a été envoyé on récupère toute ses informations pour les afficher ensuite.
	$idArticle = htmlspecialchars($_GET['id']);
	$idArticle = (int) $idArticle;

    include(MODEL_PATH . 'article/get_article.php');
    $informations = getArticle($idArticle);

    $article = $informations['article_informations'];
    $author = $informations['user_informations'];

    $currentPicturePath = ARTICLES_MINIATURES_PATH . $article['id'] . '.jpg';

} else {
    
    header('Location: index.php');

}

include(VIEW_PATH . 'article/article.php');

?>