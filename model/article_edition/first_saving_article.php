<?php

function saveArticle($title, $authorId, $content) {

	include(DB_CONNECTION_PATH);

	$request = $bdd->prepare('INSERT INTO articles(title, author_id, content, published) VALUES(:title, :author_id, :content, 0)');
    $request->execute(array('title' => $title, 'author_id' => $authorId, 'content' => $content));

}