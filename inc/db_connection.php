<?php

try
{
    $bdd = new PDO(SQL_DNS, SQL_USERNAME, SQL_PASSWORD, array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
}
catch(Exception $e)
{
    die('Erreur : '.$e->getMessage());
}