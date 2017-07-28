<?php

include('global/config.php');
include_once(DB_CONNECTION_PATH);

if(isset($_GET['id']) AND !empty('id')) { // Si l'utilisateur a bien renseigné l'id de l'article on a plus qu'à le supprimer de la table.
    $delId = htmlspecialchars($_GET['id']);
    $delId = (int) $delId;
    $currentPicturePath = ARTICLES_MINIATURES_PATH . $delId . '.jpg';
    
    include(MODEL_PATH . 'remove_article/remove_article.php');
    removeArticle($delId, $currentPicturePath);
    
    header('Location: index.php');
}