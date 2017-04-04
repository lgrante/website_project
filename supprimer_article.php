<?php

include_once('connection_bdd.php');

if(isset($_GET['id']) AND !empty('id')) {
    $del_id = htmlspecialchars($_GET['id']);
    $del_id = (int) $del_id;
    
    $request = $bdd->prepare('DELETE FROM articles WHERE id = :id');
    $request->execute(array('id' => $del_id));
    
    header('Location: index.php');
}

?>