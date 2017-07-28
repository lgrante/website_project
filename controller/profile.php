<?php

session_start();

include('global/config.php');
include_once(DB_CONNECTION_PATH);

if(isset($_GET['userid']) AND !empty($_GET['userid'])) {

    $userId = htmlspecialchars($_GET['userid']);

    include(MODEL_PATH . 'profile/get_user_info.php');
    $user = getUserInfo($userId);

    //$currentProfilePicturePath = PROFILES_PICTURES_PATH . $user['id'] . '.jpg';

} else {

    echo '<p>Utilisateur inconnu(e)</p><br>';
    die('<p><a href="index.php">Revenir sur la page principale</a></p>');

}

if(isset($_GET['publish']) AND !empty($_GET['publish'])) {

    $id = htmlspecialchars($_GET['publish']);
    $id = (int) $id;

    include(MODEL_PATH . 'profile/publish_article.php');
    publishArticle($id);

    header('Location: index.php?p=profile&userid=' . $_SESSION['id']);

}

include(VIEW_PATH . 'profile/profile_menu.php');

if(isset($_GET['tab']) AND $_GET['tab'] == 'profile') { 

    echo 'Rien pour l\'instant';

} else if(isset($_GET['tab']) AND $_GET['tab'] == 'articles') {

    if(isset($_SESSION['id']) AND $user['id'] == $_SESSION['id']) {

        include(MODEL_PATH . 'profile/get_all_users_articles.php');
        $request = getAllUsersArticles($user['id']);

    } else {

        include(MODEL_PATH . 'profile/get_published_users_articles.php');
        $request = getPublishedUsersArticle($user['id']);

    }

    include(VIEW_PATH . 'profile/user_articles.php');

} else if(isset($_GET['tab']) AND $_GET['tab'] == 'settings') { 

    include(VIEW_PATH . 'profile/form_update_user_info.php');
            
} 