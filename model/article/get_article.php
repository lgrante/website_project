<?php

function getArticle($articleId) {

	include(DB_CONNECTION_PATH);

	$request = $bdd->prepare('SELECT * FROM articles WHERE id = :id');
	$request->execute(array('id' => $articleId));
	$article = $request->fetch();

	$request = $bdd->prepare('SELECT id, username FROM users WHERE id = :author_id');
	$request->execute(array('author_id' => $article['author_id']));
	$author = $request->fetch();

	$informations = array('article_informations' => $article, 'user_informations' => $author);

	return $informations;

}