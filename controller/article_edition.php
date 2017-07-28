<?php 

session_start();

include('global/config.php');
include_once(DB_CONNECTION_PATH);

if(isset($_SESSION['id'], $_SESSION['username'], $_SESSION['email'])) {

    $editionMode = false;

    if(isset($_GET['edit']) AND !empty($_GET['edit'])) { // Si l'utilisateur veut modifier l'article on récupère l'article de la bdd afin qu'il puisse le modifier.
        
        $editionMode = true;
        $editId = htmlspecialchars($_GET['edit']);
        $editId = (int) $editId;

        include(MODEL_PATH . 'article_edition/get_article.php');
        $editArticle = getArticle($editId);

    }

    if(isset($_POST['title'], $_POST['content'])) { // Si on reçoit un requête post.

        $title = htmlspecialchars($_POST['title']);
        $content = htmlspecialchars($_POST['content']);

        if(isset($_POST['publish'])) { // On publie directement l'article.
                    
            if(!$editionMode) { // Si on est pas en mode édition on crée une nouvelle entrée dans la table correspondant à l'article.

                if(!empty($_POST['title']) AND !empty($_POST['content'])) { // Pour la publication directe d'un article l'utilisateur est obligé de remplir tous les champs.

                    include(MODEL_PATH . 'article_edition/publish_article.php');
                    publishArticle($title, $_SESSION['id'], $content);

                    header('Location: index.php');

                } else {

                    $error = '<p style="color: red;">Veuille remplir tous les champs.</p>';

                }

            } else { // Si on est en mode édition on met à jour l'entrée correspondant à l'article.

                include(MODEL_PATH . 'article_edition/update_article.php');
                updateArticle($title, $content, $editId, $editArticle['published']);

                header('Location: index.php?p=article&id=' . $editId);

            }

        } else if(isset($_POST['save'])) { // L'article est seulement sauvegardé pour l'utilisateur.

            if($editionMode) {

                include(MODEL_PATH . 'article_edition/save_article.php');
                saveArticle($title, $content, $editId);

            } else {

                include(MODEL_PATH . 'article_edition/first_saving_article.php');
                saveArticle($title, $_SESSION['id'], $content);

            }

        }

        if(isset($_FILES['miniature']) AND !empty($_FILES['miniature']['name'])) { // Si l'utilisateur veut ajouter une image de miniature à l'article ou la changer.

            include(MODEL_PATH . 'article_edition/save_miniature.php');
            saveMiniature($editionMode);

        }   

        header('Location: index.php');

    }

} else {

    header('Location: index.php?p=registration');

}

include(VIEW_PATH . 'article_edition/article_edition.php');

?>