<?php

function saveMiniature($editionMode) {

	include(DB_CONNECTION_PATH);

	if($editionMode) {  // S'il la remplace.

	    $pictureId = $editId; 
	    $path = ARTICLES_MINIATURES_PATH . $pictureId . '.jpg';
	    unlink($path);

	} else {  // S'il en ajoute une nouvelle.

	    $pictureId = $bdd->lastInsertId(); 
	    $path = ARTICLES_MINIATURES_PATH . $pictureId . '.jpg';

	}

	move_uploaded_file($_FILES['miniature']['tmp_name'], $path);

}