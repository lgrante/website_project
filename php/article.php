<?php

include_once('inc/connection_bdd.php');

if(isset($_GET['id']) AND !empty($_GET['id'])) { // Si on a bien l'id de l'article qui a été envoyé on récupère toute ses informations pour les afficher ensuite.
    
    $idArticle = htmlspecialchars($_GET['id']);
    $idArticle = (int) $idArticle;

    $request = $bdd->prepare('SELECT * FROM articles WHERE id = :id');
    $request->execute(array('id' => $idArticle));
    $article = $request->fetch();
} else {
    
    die('Erreur : l\'article n\'existe pas...');
}

?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8" />
        <title>Mon blog</title>
    	<link href="style/style.css" rel="stylesheet" /> 
    </head>
        
    <body>
        <a href="../index.php">Retour à la page d'acceuil</a>
        <div>
            <ul>
                <li>
                    <a href="edition_article.php?edit=<?= $article['id'] ?>">Modifier</a>
                </li>
                <li>
                    <a href="supprimer_article.php?id=<?= $article['id'] ?>">Supprimer</a>
                </li>
            </ul>
            <h3><?= $article['title'] ?></h3>
        </div>
        <div>
            <p><?= $article['content'] ?></p>
        </div>
	</body>
</html>