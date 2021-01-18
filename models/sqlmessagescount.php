<?php
require_once 'sqlparameters.php';
//Récupération du nombre de messages non lus de l'utilisateur.
try {
    $sth = $db->prepare('SELECT COUNT(`id`) FROM `messages` WHERE `recieverid` = :recieverid AND `alreadyread` = 0');
    $sth->bindValue(':recieverid', $_SESSION['id'], PDO::PARAM_INT);
    $sth->execute();
    $numberOfNewMessages = $sth->fetch();
} catch (Exception $ex) {
    die('Connexion échoué');
}
//Si l'utilisateur a des messages non lus.
if ($numberOfNewMessages['COUNT(`id`)'] != NULL && $numberOfNewMessages['COUNT(`id`)'] != '0'){
    //On affiche le nombre de messages non lus entre parenthèses.
    $numberOfNewMessages = ' ( ' .$numberOfNewMessages['COUNT(`id`)']. ' )';
} else{
    $numberOfNewMessages = '';
}
