<?php

function updateArticle($title, $content, $id, $published) {

	include(DB_CONNECTION_PATH);

	if($published == 0) {

		$request = $bdd->prepare('UPDATE articles SET title = :title, content = :content, date_time_publication = NOW(), published = 1 WHERE id = :id');

	} else {

		$request = $bdd->prepare('UPDATE articles SET title = :title, content = :content, date_time_update = NOW() WHERE id = :id');

	}

	$request->execute(array('title' => $title, 'content' => $content, 'id' => $id));

}