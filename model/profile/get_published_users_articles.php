<?php

function getPublishedUsersArticle($authorId) {

	include(DB_CONNECTION_PATH);

	$request = $bdd->prepare('SELECT * FROM articles WHERE author_id = :author_id AND published = 1');
	$request->execute(array('author_id' => $authorId));

	return $request;

}