<?php
require_once 'sqlparameters.php';
//Définition de la limit par rapport au select du form, si non définie prend 10 comme valeur.
$limit = 20;
$page = isset($_GET['page']) ? $_GET['page'] : 1;
$start = ($page - 1) * $limit;
$topicId = $_GET['id'];
try {
    //Calcul du nombre de topics.
    $publicationQueryOne = $db->prepare("SELECT count(`id`) AS `id` FROM `publications` WHERE `id_topics` = :id");
    $publicationQueryOne->bindValue(':id', $topicId, PDO::PARAM_INT);
    $publicationQueryOne->execute();
    $publicationCount = $publicationQueryOne->fetchAll(PDO::FETCH_ASSOC);
    //Stockage du nombre de topics dans la variable 'total'.
    $total = $publicationCount[0]['id'];
    //Calcul du nombre de pages.
    $pages = ceil( $total / $limit );
    //Définition du bouton page précédente.
    $previous = $page - 1;
    //Définition du bouton page suivante.
    $next = $page + 1;
} catch (Exception $ex) {
    die('Connexion échoué');
}
//Si la variable Get 'page' n'est pas définie.
/*if (!filter_input(INPUT_GET, 'page', FILTER_SANITIZE_NUMBER_INT) || $page < 1){
    //On redirige vers la page 1
    echo 'test1';
    header('location:topic.php?id=' .$_GET['id']. '&page=1');
    exit();
}
//Si la page demandée est inférieure à la première page
if ($page < 1){
    echo 'test3';
    header('location:topic.php?id=' .$_GET['id']. '&page=1');
    exit();
}
//Si la page demandée est supérieure à la dernière page
if ($page > $pages){
    //On redirige vers la dernière page
    echo 'test2';
    header('location:topic.php?id=' .$_GET['id']. '&page=' .$pages);
    exit();
}*/
