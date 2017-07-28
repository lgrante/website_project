<?php

function removeArticle($id, $miniaturePath) {

	include(DB_CONNECTION_PATH);

	$request = $bdd->prepare('DELETE FROM articles WHERE id = :id');
    $request->execute(array('id' => $id));
    unlink($miniaturePath);

}