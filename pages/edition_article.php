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

    if(isset($_POST['title'], $_POST['content'])) { // Si on reçoit un requête post.

        $title = htmlspecialchars($_POST['title']);
        $content = htmlspecialchars($_POST['content']);

        if(isset($_POST['publish'])) { // On publie directement l'article.
                    
            if(!$editionMode) { // Si on est pas en mode édition on crée une nouvelle entrée dans la table correspondant à l'article.

                if(!empty($_POST['title']) AND !empty($_POST['content'])) { // Pour la publication directe d'un article l'utilisateur est obligé de remplir tous les champs.

                    $request = $bdd->prepare('INSERT INTO articles(title, author_id, content, date_time_publication, published) VALUES(:title, :author_id, :content, NOW(), 1)');
                    $request->execute(array('title' => $title, 'author_id' => $_SESSION['id'], 'content' => $content));

                    header('Location: index.php');

                } else {

                    $error = '<p style="color: red;">Veuille remplir tous les champs.</p>';

                }

            } else { // Si on est en mode édition on met à jour l'entrée correspondant à l'article.

                if($editArticle['published'] == 0) { // Si on publie un article qui était seulement un brouillon.

                    $request = $bdd->prepare('UPDATE articles SET title = :title, content = :content, date_time_publication = NOW(), published = 1 WHERE id = :id');
                                
                } else { // Si on édite un article qui est déjà publié.

                    $request = $bdd->prepare('UPDATE articles SET title = :title, content = :content, date_time_update = NOW() WHERE id = :id');

                }

                $request->execute(array('title' => $title, 'content' => $content, 'id' => $editId));

                header('Location: index.php?p=article&id=' . $editId);

            }

        } else if(isset($_POST['save'])) { // L'article est seulement sauvegardé pour l'utilisateur.

            if(!$editionMode) { // Si c'est la rédaction du brouillon.

                $request = $bdd->prepare('INSERT INTO articles(title, author_id, content, published) VALUES(:title, :author_id, :content, 0)');
                $request->execute(array('title' => $title, 'author_id' => $_SESSION['id'], 'content' => $content));

            } else { // Si on édite le brouillon sans pour autant le publier.

                $request = $bdd->prepare('UPDATE articles SET title = :title, content = :content WHERE id = :id');
                $request->execute(array('title' => $title, 'content' => $content, 'id' => $editId));

            }

        }

        if(isset($_FILES['miniature']) AND !empty($_FILES['miniature']['name'])) { // Si l'utilisateur veut ajouter une image de miniature à l'article ou la changer.

            if($editionMode) {  // S'il la remplace.

                $pictureId = $editId; 
                $path = 'assets/pictures/articles_miniatures/'. $pictureId . '.jpg';
                unlink($path);

            } else {  // S'il en ajoute une nouvelle.

                $pictureId = $bdd->lastInsertId(); 
                $path = 'assets/pictures/articles_miniatures/'. $pictureId . '.jpg';

            }

        }

        move_uploaded_file($_FILES['miniature']['tmp_name'], $path);

        header('Location: index.php');

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
        <?php if($editionMode) { // On adapte le code html en fonction de si on est en mode édition ou rédaction ?>

            <h3>Mode d'édition</h3>
            <p>Bienvenue dans le mode d'édition, modifier votre article comme bon vous semble !</p>

        <?php } else { ?>
        
            <h3>Mode de rédaction</h3>
            <p>Rédiger un article pour la communautée !</p>
            <p>Auteur : <?= $_SESSION['username'] ?></p>

        <?php } ?>

        <form method="post" enctype="multipart/form-data">
            <input type="text" placeholder="Titre de l'article" name="title" <?php if($editionMode) { ?> value="<?= $editArticle['title'] ?>" <?php } ?>><br>

            <textarea placeholder="Contenu de l'article" name="content" rows="8" cols="45"><?php if($editionMode) { echo $editArticle['content']; } ?></textarea><br> 

            <label for="miniature">
                <?php if(!$editionMode) { ?>

                    Ajouter une image de miniature pour votre article

                <?php } else { ?>

                    Vous pouvez toujours changer l'image de miniature de votre article

                <?php } ?>
            </label><br>
            <input type="file" name="miniature"><br>

            <?php if(isset($editArticle) AND $editArticle['published'] == 1) { ?>

                <input type="submit" name="publish" value="Enregistrer les modifications">

            <?php } else { ?>

                <input type="submit" name="publish" value="Publier">
                
                <?php if($editionMode) { ?>

                    <input type="submit" name="save" value="Enregistrer les modifications">

                <?php } else { ?> 

                    <input type="submit" name="save" value="Enregistrer comme brouillon">

                <?php } ?>

            <?php } ?>
        </form>

        <div id="errorArea">
            <p><?php if(isset($error)){ echo $error; } ?></p>
        </div>
	</body>
</html>