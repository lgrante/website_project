<?php

session_start();

include_once('inc/connection_bdd.php');

$articles = $bdd->query('SELECT * FROM articles WHERE published = 1 ORDER BY date_time_publication DESC'); // On récupère tous les articles de la table qui sont publié.

?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8" />
        <title>Mon blog</title>
    	<link href="style/style.css" rel="stylesheet" /> 
    </head>
        
    <body>
        <h4>
            <a href="index.php?p=edition_article">Nouvel article !</a>
        </h4>

        <?php if(isset($_SESSION['id'])) {

            if(isset($_GET['connected'])) { ?>

                <p><i>Heureux de vous revoir <?= $_SESSION['username'] ?> !</i></p>  <!-- TO DO : Afficher ce message dans un boite en js. -->

            <?php } ?>
            <ul>
                <li><a href="index.php?p=profil&amp;userid=<?= $_SESSION['id'] ?>"><?= $_SESSION['username'] ?></a></li>
                <li><a href="index.php?p=deconnection">Se déconnecter</a></li>
            </ul>
        <?php } else { ?>

            <ul>
                <li><a href="index.php?p=inscription">S'inscire</a></li>
                <li><a href="index.php?p=connection">Se connecter</a></li>
            </ul>

        <?php } ?>

        <ul>
            <?php 
            while($article = $articles->fetch()) { // On fait une boucle pour afficher chaque article

                $contentPart = substr($article['content'], 0, 150); // On voudra afficher seulement le début de l'article l'utilisateur devra cliquer pour lire la suite.
                $author = $bdd->prepare('SELECT username FROM users WHERE id = :author_id');
                $author->execute(array('author_id' => $article['author_id']));
                $author_id = $author->fetch();

                $currentPicturePath = 'pictures/articles_miniatures/' . $article['id'] . '.jpg'; ?> 

                <li>
                    <h3>
                        <a href="index.php?p=article&amp;id=<?= $article['id'] ?>">
                        <?= $article['title'] ?></a>
                    </h3>

                    <i>Publié le <?= $article['date_time_publication'] ?> par <a href="index.php?p=profil&amp;userid=<?= $article['author_id'] ?>"><?= $author_id['username'] ?>.</a><br>
                    <?php if(!is_null($article['date_time_update'])) { ?>
                        Dernière modification le <?= $article['date_time_update'] ?><br>
                    <?php } ?></i><br>

                    <img src="<?= $currentPicturePath ?>" width="200">

                    <p><?= $contentPart ?>
                    <?php if($contentPart != $article['content']) { echo '...'; } ?><br><i><a href="index.php?p=article&amp;id=<?= $article['id'] ?>">Lire la suite</a></i></p>

                    <?php if(isset($_SESSION['id'], $_SESSION['username'], $_SESSION['email']) AND $article['author_id'] == $_SESSION['id']) { ?>

                        <p>
                            <a href="index.php?p=edition_article&amp;edit=<?= $article['id'] ?>">Modifier | </a>
                            <a href="index.php?p=supprimer_article&amp;id=<?= $article['id'] ?>">Supprimer</a>
                        </p>
                        
                    <?php } ?>
                </li>
            <?php } ?>
        </ul>
	</body>
</html>
