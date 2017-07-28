<?php

function getUsersArticle($authorId) {

	include(DB_CONNECTION_PATH);
	
	$request = $bdd->prepare('SELECT username FROM users WHERE id = :author_id');
    $request->execute(array('author_id' => $authorId));
    $author = $request->fetch();

    return $author;

}