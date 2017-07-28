<?php

function getUserInfo($userId) {

	include(DB_CONNECTION_PATH);

	$request = $bdd->prepare('SELECT * FROM users WHERE id = :userid');
	$request->execute(array('userid' => $userId));
	$user = $request->fetch();

	return $user;

}