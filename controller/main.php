<?php

session_start();

include('global/config.php');
include(DB_CONNECTION_PATH);

include(MODEL_PATH . 'main/get_articles.php'); // On récupère tous les articles de la table qui sont publié.
$request = getArticles($bdd);

include(VIEW_PATH . 'main/main_menu.php');

echo '<ul>';

while($article = $request->fetch()) { // On fait une boucle pour afficher chaque article

    $contentPart = substr($article['content'], 0, 150); // On voudra afficher seulement le début de l'article l'utilisateur devra cliquer pour lire la suite.

    include_once(MODEL_PATH . 'main/get_users_article.php'); // On récupère le nom d'utilisateur de l'auteur de l'article.
    $author = getUsersArticle($article['author_id']);

    $currentPicturePath = ARTICLES_MINIATURES_PATH . $article['id'] . '.jpg';  

    include(VIEW_PATH . 'main/articles.php');

} 

echo '</ul>';