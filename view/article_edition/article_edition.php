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