<?php 

session_start();

if(isset($_SESSION['id'], $_SESSION['username'], $_SESSION['email'])) {

    include_once('inc/connection_bdd.php');
    $editionMode = false;

    if(isset($_GET['edit']) AND !empty($_GET['edit'])) { // Si l'utilisateur veut modifier l'article on récupère l'article de la bdd afin qu'il puisse le modifier.
        
        $editionMode = true;
        $editId = htmlspecialchars($_GET['edit']);
        $editId = (int) $editId;
        
        $request = $bdd->prepare('SELECT * FROM articles WHERE id = :id');
        $request->execute(array('id' => $editId));
        
        if($request->rowCount() == 1) {
            
            $editArticle = $request->fetch();
        } else {
            
            die('Erreur : l\'article n\'existe pas...');
        }
    }
    if(isset($_POST['title']) && isset($_POST['content'])) { // Si l'utilisateur à bien envoyer les informations du formulaire.
        
        $title = htmlspecialchars($_POST['title']);
        $content = htmlspecialchars($_POST['content']);
        
        if(!$editionMode) { // Si on est pas en mode édition on crée une nouvelle entrée dans la table correspondant à l'article.

            if(isset($_FILES) AND !empty($_FILES['miniature']['name'])) {
                
                //if(exif_imagetype($_FILES['miniature']['tmp_name']) == 2) {

                    $request = $bdd->prepare('INSERT INTO articles(title, author_id, content, date_time_publication) VALUES(:title, :author_id, :content, NOW())');
                    $request->execute(array('title' => $title, 'author_id' => $_SESSION['id'], 'content' => $content));
                    $lastId = $bdd->lastInsertId();
                    $path = 'pictures/articles_miniatures/'. $lastId . '.jpg';
                    move_uploaded_file($_FILES['miniature']['tmp_name'], $path);
                    header('Location: index.php');
                /*} else {

                    $error = 'Votre image doit être au format jpg';
                }*/
            }
        } else { // Si on est en mode édition on met à jour l'entrée correspondant à l'article.

            $request = $bdd->prepare('UPDATE articles SET title = :title, content = :content, date_time_update = NOW() WHERE id = :id');
            $request->execute(array('title' => $title, 'content' => $content, 'id' => $editId));
            header('Location: index.php?p=article&id='.$editId);
        }
    }
} else {

    header('Location: index.php?p=inscription');
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
        <a href="index.php">Annuler</a>
        <?php
        if($editionMode) { // On adapte le code html en fonction de si on est en mode édition ou rédaction ?>
            
            <h3>Mode d'édition</h3>
            <p>Bienvenue dans le mode d'édition, modifier votre article comme bon vous semble !</p>
            <?php } else { ?>
        
            <h3>Mode de rédaction</h3>
            <p>Rédiger un article pour la communautée !</p>
            <p>Auteur : <?= $_SESSION['username'] ?></p>
            <?php
        }?>
        <form method="post" enctype="multipart/form-data">
            <input type="text" placeholder="Titre de l'article" name="title" <?php if($editionMode) { ?> value="<?= $editArticle['title'] ?>" <?php } ?></inpu><br />
            <textarea placeholder="Contenu de l'article" name="content" rows="8" cols="45"><?php if($editionMode) { ?> <?= $editArticle['content'] ?> <?php } ?></textarea><br />
            <?php if(!$editionMode) { ?>
            <input type="file" name="miniature"><br />
            <?php } ?>
            <input type="submit" value="Enregistrer">
        </form>
        <div id="errorArea">
            <p><?php if(isset($error)){ echo $error; } ?></p>
        </div>
	</body>
</html>
