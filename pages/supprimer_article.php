<?php

include_once('inc/connection_bdd.php');

if(isset($_GET['id']) AND !empty('id')) { // Si l'utilisateur a bien renseigné l'id de l'article on a plus qu'à le supprimer de la table.
    $delId = htmlspecialchars($_GET['id']);
    $delId = (int) $delId;
    $currentPicturePath = 'pictures/articles_miniatures/' . $delId . '.jpg';
    
    $request = $bdd->prepare('DELETE FROM articles WHERE id = :id');
    $request->execute(array('id' => $delId));
    unlink($currentPicturePath);
    
    header('Location: index.php');
}
