<?php

function publishArticle($articleId) {

	include(DB_CONNECTION_PATH);

	$request = $bdd->prepare('SELECT * FROM articles WHERE id = :id');
    $request->execute(array('id' => $articleId));
    $article = $request->fetch();

    $request = $bdd->prepare('UPDATE articles SET title = :title, author_id = :author_id, content = :content, date_time_publication = NOW(), published = 1 WHERE id = :id');
    $request->execute(array('title' => $article['title'], 'author_id' => $_SESSION['id'], 'content' => $article['content'], 'id' => $articleId));

}