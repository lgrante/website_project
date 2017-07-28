<?php

function getArticles() {

	include(DB_CONNECTION_PATH);

	$request = $bdd->query('SELECT * FROM articles WHERE published = 1 ORDER BY date_time_publication DESC');

	return $request;

}