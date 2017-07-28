<?php

function getAllUsersArticles($authorId) {

	include(DB_CONNECTION_PATH);

	$request = $bdd->prepare('SELECT * FROM articles WHERE author_id = :author_id');
	$request->execute(array('author_id' => $authorId));

	return $request;

}