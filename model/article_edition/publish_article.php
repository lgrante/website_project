<?php

function publishArticle($title, $author_id, $content) {

	include(DB_CONNECTION_PATH);

	$request = $bdd->prepare('INSERT INTO articles(title, author_id, content, date_time_publication, published) VALUES(:title, :author_id, :content, NOW(), 1)');
	$request->execute(array('title' => $title, 'author_id' => $author_id, 'content' => $content));

}