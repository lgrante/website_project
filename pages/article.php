<?php

session_start();

include_once('inc/connection_bdd.php');

$request = $bdd->query('SELECT MAX(id) AS max_id FROM articles');
$maxId = $request->fetch();

if(isset($_GET['id']) AND !empty($_GET['id']) AND $_GET['id'] <= $maxId['max_id']) { // Si on a bien l'id de l'article qui a été envoyé on récupère toute ses informations pour les afficher ensuite.
    $idArticle = htmlspecialchars($_GET['id']);
    $idArticle = (int) $idArticle;

    $request = $bdd->prepare('SELECT * FROM articles WHERE id = :id');
    $request->execute(array('id' => $idArticle));
    $article = $request->fetch();

    $author = $bdd->prepare('SELECT username FROM users WHERE id = :author_id');
    $author->execute(array('author_id' => $article['id']));
    $author_username = $author->fetch();
} else {
    
    header('Location: index.php');
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
        <a href="index.php">Retour à la page d'acceuil</a>
        <div>
            <?php if(isset($_SESSION['id'], $_SESSION['username'], $_SESSION['email'])) { 
            if($article['author_id'] == $_SESSION['id']) { ?>
            <ul>
                <li>
                    <a href="index.php?p=edition_article&amp;edit=<?= $article['id'] ?>">Modifier</a>
                </li>
                <li>
                    <a href="index.php?p=supprimer_article&amp;id=<?= $article['id'] ?>">Supprimer</a>
                </li>
            </ul>
            <?php }} ?>
            <img src="pictures/articles_miniatures/<?= $article['id'] ?>.jpg" width="200">
            <h3><?= $article['title'] ?></h3>
            <h4>Auteur : <?= $author_username['username'] ?></h4>
        </div>
        <div>
            <p><?= nl2br($article['content']) ?></p>
        </div>
	</body>
</html>
