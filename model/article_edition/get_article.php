<?php

function getArticle($editId) { 

	include(DB_CONNECTION_PATH);
        
	$request = $bdd->prepare('SELECT * FROM articles WHERE id = :id');
	$request->execute(array('id' => $editId));
	        
	if($request->rowCount() == 1) {
	            
	    $editArticle = $request->fetch();
	    return $editArticle;

	} else {
	            
	    die('Erreur : l\'article n\'existe pas...');

	}

}