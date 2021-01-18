<?php
require_once 'sqlparameters.php';
$id = $_GET['id'];
//Récupération du pseudo du destinataire dans la table users.
try {
    $sth = $db->prepare('SELECT `pseudo` FROM `users` WHERE `id` = :id');
    $sth->bindValue(':id', $id, PDO::PARAM_INT);
    $sth->execute();
    $user = $sth->fetchAll(PDO::FETCH_ASSOC);
    foreach ($user as $row){
        //Stockage du pseudo du destinataire dans la variable $pseudo.
        $pseudo = $row['pseudo'];
    }
} catch (Exception $ex) {
    die('Connexion échoué');
}