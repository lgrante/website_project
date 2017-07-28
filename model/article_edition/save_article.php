<?php

function saveArticle($title, $content, $id) {

	include(DB_CONNECTION_PATH);

	$request = $bdd->prepare('UPDATE articles SET title = :title, content = :content WHERE id = :id');
    $request->execute(array('title' => $title, 'content' => $content, 'id' => $id));

}