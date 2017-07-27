<?php

session_start();

include_once('inc/connection_bdd.php');

if(isset($_POST['changeUsername'])) {

    die('Hey');

}

if(isset($_GET['userid']) AND !empty($_GET['userid'])) {

    $userid = htmlspecialchars($_GET['userid']);

    $request = $bdd->prepare('SELECT * FROM users WHERE id = :userid');
    $request->execute(array('userid' => $userid));
    $user = $request->fetch();

    $currentProfilePicturePath = 'assets/pictures/profiles_pictures/' . $user['id'] . '.jpg';

} else {

    echo '<p>Utilisateur inconnu(e)</p><br>';
    die('<p><a href="index.php">Revenir sur la page principale</a></p>');

}

if(isset($_GET['publish']) AND !empty($_GET['publish'])) {

    $id = htmlspecialchars($_GET['publish']);
    $id = (int) $id;

    $request = $bdd->prepare('SELECT * FROM articles WHERE id = :id');
    $request->execute(array('id' => $id));
    $article = $request->fetch();

    $request = $bdd->prepare('UPDATE articles SET title = :title, author_id = :author_id, content = :content, date_time_publication = NOW(), published = 1 WHERE id = :id');
    $request->execute(array('title' => $article['title'], 'author_id' => $_SESSION['id'], 'content' => $article['content'], 'id' => $id));

    header('Location: index.php?p=profil&userid=' . $_SESSION['id']);

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
        <h2><?= $user['username'] ?></h2>
        <ul>
            <li>
                <h4><a href="index.php?p=profil&amp;&amp;userid=<?= $user['id'] ?>&amp;tab=profil">Profil</a></h4>
            </li>
            <li>
                <h4><a href="index.php?p=profil&amp;userid=<?= $user['id'] ?>&amp;tab=articles">Articles</a></h4>
            </li>
            <li>
                <h4><a href="index.php?p=profil&amp;userid=<?= $user['id'] ?>&amp;tab=settings">Paramètres</a></h4>
            </li>

        <?php if(isset($_GET['tab']) AND $_GET['tab'] == 'profil') { ?>

            <p>Informations sur l'utilisateur...</p>

        <?php } else if(isset($_GET['tab']) AND $_GET['tab'] == 'articles') {

            if(isset($_SESSION['id']) AND $user['id'] == $_SESSION['id']) {

                $request = $bdd->prepare('SELECT * FROM articles WHERE author_id = :author_id');

            } else {

                $request = $bdd->prepare('SELECT * FROM articles WHERE author_id = :author_id AND published = 1');

            }

            $request->execute(array('author_id' => $user['id'])); ?>

            <h4>
                <a href="index.php?p=edition_article">Nouvel article !</a>
            </h4>

            <ul>
                <?php while($article = $request->fetch()) { 

                    $contentPart = substr($article['content'], 0, 150); 
                    $currentPicturePath = 'assets/pictures/articles_miniatures/' . $article['id'] . '.jpg'; ?>

                    <li>
                        <h3>
                            <a href="index.php?p=article&amp;id=<?= $article['id'] ?>">
                            <?= $article['title'] ?></a>
                        </h3>

                        <?php if($article['published']) { ?>

                            <i>Publié le <?= $article['date_time_publication'] ?><br>
                            <?php if(!is_null($article['date_time_update'])) { ?>
                            Dernière modification le <?= $article['date_time_update'] ?><br>
                            <?php } ?></i><br>

                        <?php } else { ?>

                            <i>Non publié pour l'instant.<br>
                            <a href="index.php?p=profil&amp;userid=<?= $_GET['userid'] ?>&amp;publish=<?= $article['id'] ?>">Publier</a></i><br>

                        <?php } ?>

                        <img src="<?= $currentPicturePath ?>" width="200">

                        <p><?= $contentPart ?><?php if($contentPart != $article['content']) { echo '...'; } ?><br /><i><a href="index.php?p=article&amp;id=<?= $article['id'] ?>">Lire la suite</a></i></p>

                        <?php if(isset($_SESSION['id'], $_SESSION['username'], $_SESSION['email']) AND $article['author_id'] == $_SESSION['id']) { ?>

                            <p>
                                <a href="index.php?p=edition_article&amp;edit=<?= $article['id'] ?>">Modifier | </a>
                                <a href="index.php?p=supprimer_article&amp;id=<?= $article['id'] ?>">Supprimer</a>
                            </p>

                        <?php } ?>
                    </li>
                <?php } ?>
            </ul> 
        <?php } else if(isset($_GET['tab']) AND $_GET['tab'] == 'settings') { ?>

            <div class="changeUsername">
                <h3>Votre nom d'utilisateur</h3>
                <form method="post" id="formUsername">
                    <table>
                        <tr>
                            <td><label for="username">Nouveau nom d'utilisateur</label></td>
                            <td><input type="text" name="username" id="username"></td>
                            <td><span id="helpUsername"></span></td>
                        </tr>
                        <tr>
                            <td><br><input type="submit" name="changeUsername" value="Enregistrer les modifications" class="submitButton"></td>
                        </tr>
                    </table>
                </form>
            </div><br>

            <div class="changeEmail">
                <h3>Votre email</h3>
                <form method="post" id="formEmail">
                    <table>
                        <tr>
                            <td><label for="currentEmail">Adresse email actuelle</label></td>
                            <td><input type="text" name="currentEmail" id="currentEmail"></td>
                            <td><span id="helpCurrentEmail"></span></td>
                        </tr>
                        <tr>
                            <td><label for="newEmail">Nouvel email</label></td>
                            <td><input type="text" name="newEmail" id="newEmail"></td>
                            <td><span id="helpNewEmail"></span></td>
                        </tr>
                        <tr>
                            <td><br><input type="submit" name="changeEmail" value="Enregistrer les modifications" class="submitButton"></td>
                        </tr>
                    </table>
                </form>
            </div><br>

            <div class="changePassword">
                <h3>Changer votre mot de passe</h3>
                <form method="post" id="formPassword">
                    <table>
                        <tr>
                            <td><label for="formerPassword">Ancien mot de passe</label></td>
                            <td><input type="password" name="formerPassword" id="formerPassword"></td>
                            <td><span id="helpFormerPassword"></span></td>
                        </tr>
                        <tr>
                            <td><label for="newPassword">Nouveau mot de passe</label></td>
                            <td><input type="password" name="newPassword" id="newPassword"></td>
                            <td><span id="helpNewPassword"></span></td>
                        </tr>
                        <tr>
                            <td><label for="newPasswordConfirmation">Confirmation</label></td>
                            <td><input type="password" name="newPasswordConfirmation" id="newPasswordConfirmation"></td>
                            <td><span id="helpNewPasswordConfirmation"></span></td>
                        </tr>
                        <tr>
                            <td><br><input type="submit" name="changePassword" value="Enregistrer les modifications" class="submitButton"></td>
                        </tr>
                    </table>
                </form>
            </div><br>
        <?php } ?>
        </ul>
        <script type="text/javascript" src="assets/js/functions.js"></script>
        <script type="text/javascript" src="assets/js/profile_settings.js"></script>
	</body>
</html>