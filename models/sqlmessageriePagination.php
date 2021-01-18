<?php
require_once 'sqlparameters.php';
//Définition de la limite de messages par page.
$limit = 20;
$page = isset($_GET['page']) ? $_GET['page'] : 1;
$start = ($page - 1) * $limit;
try {
    //Calcul du nombre de messages.
    $messageQueryOne = $db->prepare("SELECT COUNT(*) AS `id` FROM `messages` WHERE `recieverid` = :recieverid");
    $messageQueryOne->bindValue(':recieverid', $_SESSION['id'], PDO::PARAM_INT);
    $messageQueryOne->execute();
    $messagesCount = $messageQueryOne->fetchAll(PDO::FETCH_ASSOC);
    //Stockage du nombre de messages dans la variable 'total'.
    $total = $messagesCount[0]['id'];
    //Calcul du nombre de pages.
    $pages = ceil( $total / $limit );
    //Définition du bouton page précédente.
    $previous = $page - 1;
    //Définition du bouton page suivante.
    $next = $page + 1;
} catch (Exception $ex) {
    die('Connexion échoué');
}

