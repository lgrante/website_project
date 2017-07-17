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

            if(!empty($_POST['title']) AND !empty($_POST['content'])) {
                
                if(!$editionMode) { // Si on est pas en mode édition on crée une nouvelle entrée dans la table correspondant à l'article.

                    if(isset($_FILES['miniature']) AND !empty($_FILES['miniature']['name'])) {

                        $request = $bdd->prepare('INSERT INTO articles(title, author_id, content, date_time_publication, published) VALUES(:title, :author_id, :content, NOW(), 1)');
                        $request->execute(array('title' => $title, 'author_id' => $_SESSION['id'], 'content' => $content));
                        $pictureId = $bdd->lastInsertId();
                        $path = 'pictures/articles_miniatures/'. $pictureId . '.jpg';
                        move_uploaded_file($_FILES['miniature']['tmp_name'], $path);
                        header('Location: index.php');
                    }
                } else { // Si on est en mode édition on met à jour l'entrée correspondant à l'article.

                    //die('Hey you');
                    if(isset($_FILES['miniature']) AND !empty($_FILES['miniature']['name'])) { // Si jamais l'utilisateur choisi une nouvelle image de miniature on supprime l'ancienne et on upload la nouvelle sur le serveur à la place.
                        
                        $pictureId = $editId; 
                        $path = 'pictures/articles_miniatures/'. $pictureId . '.jpg';
                        unlink($path);
                        move_uploaded_file($_FILES['miniature']['tmp_name'], $path);
                        $request = $bdd->prepare('UPDATE articles SET title = :title, content = :content, date_time_update = NOW() WHERE id = :id');
                        $request->execute(array('title' => $title, 'content' => $content, 'id' => $editId));
                        header('Location: index.php?p=article&id=' . $editId);
                    }
                    $request = $bdd->prepare('UPDATE articles SET title = :title, content = :content, date_time_update = NOW() WHERE id = :id');
                    $request->execute(array('title' => $title, 'content' => $content, 'id' => $editId));
                }
            } else {

                $error = '<p style="color : red;">Veuillez remplir tous les champs avant d\'enregistrer votre article.</p>';
            }
        } else if(isset($_POST['save'])) { // L'article est seulement sauvegardé pour l'utilsateur.

            $request = $bdd->prepare('INSERT INTO articles(title, author_id, content, published) VALUES(:title, :author_id, :content, 0)');
            $request->execute(array('title' => $title, 'author_id' => $_SESSION['id'], 'content' => $content));
            header('Location: index.php');
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
        <?php if($editionMode) { // On adapte le code html en fonction de si on est en mode édition ou rédaction ?>

            <h3>Mode d'édition</h3>
            <p>Bienvenue dans le mode d'édition, modifier votre article comme bon vous semble !</p>

        <?php } else { ?>
        
            <h3>Mode de rédaction</h3>
            <p>Rédiger un article pour la communautée !</p>
            <p>Auteur : <?= $_SESSION['username'] ?></p>

        <?php } ?>

        <form method="post" enctype="multipart/form-data">
            <input type="text" placeholder="Titre de l'article" name="title" <?php if($editionMode) { ?> value="<?= $editArticle['title'] ?>" <?php } ?>><br />
            <textarea placeholder="Contenu de l'article" name="content" rows="8" cols="45"><?php if($editionMode) { echo $editArticle['content']; } ?></textarea><br /> 
            <input type="file" name="miniature"><br />
            <input type="submit" name="publish" value="<?php if($editionMode) { echo 'Enregistrer les modifications'; } else { echo 'Publier'; } ?>">
            <?php if(!$editionMode) { ?>
            <input type="submit" name="save" value="Enregistrer comme brouillon">
            <?php } ?>
        </form>

        <div id="errorArea">
            <p><?php if(isset($error)){ echo $error; } ?></p>
        </div>
	</body>
</html>