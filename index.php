<?php

include_once('connection_bdd.php');

$request = $bdd->query('SELECT * FROM articles ORDER BY date_time_publication DESC'); // On récupère tous les articles de la table.

?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8" />
        <title>Mon blog</title>
    	<link href="css/style.css" rel="stylesheet" /> 
    </head>
        
    <body>
        <h4>
            <a href="edition_article.php">Nouvel article !</a>
        </h4>
        <ul>
            <li><a href="inscription.php">S'inscire</a></li>
            <li><a href="connexion.php">Se connecter</a></li>
        </ul>
        <ul>
            <?php 
            while($a = $request->fetch()) { // On fait une boucle pour afficher chaque article
                $contentPart = substr($a['content'], 0, 150); // On voudra afficher seulement le début de l'article l'utilisateur devra cliquer pour lire la suite
            ?> 
                <li>
                    <h3>
                        <a href="article.php?id=<?= $a['id'] ?>">
                        <?= $a['title'] ?></a>
                    </h3>
                    <i>Publié le <?= $a['date_time_publication'] ?>. <br />
                    <?php if($a['date_time_update'] != NULL) { ?>
                    Dernière modification le <?= $a['date_time_update'] ?>
                    <?php } ?></i>
                    <p><?= $contentPart ?><?php if($contentPart != $a['content']) { echo '...'; } ?><br /><i><a href="article.php?id=<?= $a['id'] ?>">Lire la suite</a></i></p>
                    <p>
                        <a href="edition_article.php?edit=<?= $a['id'] ?>">Modifier | </a>
                        <a href="supprimer_article.php?id=<?= $a['id'] ?>">Supprimer</a>
                    </p>
                </li>
            <?php } ?>
        </ul>
	</body>
</html>