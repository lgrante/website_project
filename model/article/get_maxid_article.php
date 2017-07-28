<?php
function getMaxId() {

	include(DB_CONNECTION_PATH);

	$request = $bdd->query('SELECT MAX(id) AS max_id FROM articles');
	$maxId = $request->fetch();

	return $maxId;

}