<?php
require_once 'sqlparameters.php';
//Définition de la limite d'utilisateurs par page.
$limit = 20;
$page = isset($_GET['page']) ? $_GET['page'] : 1;
$start = ($page - 1) * $limit;
try {
    //Calcul du nombre de d'utilisateurs.
    $userQueryOne = $db->query("SELECT count(`id`) AS `id` FROM `users`");
    $userCount = $userQueryOne->fetchAll(PDO::FETCH_ASSOC);
    //Stockage du nombre d'utilisateurs dans la variable 'total'.
    $total = $userCount[0]['id'];
    //Calcul du nombre de pages.
    $pages = ceil($total / $limit);
    //Définition du bouton page précédente.
    $previous = $page - 1;
    //Définition du bouton page suivante.
    $next = $page + 1;
} catch (Exception $ex) {
    die('Connexion échoué');
}
//Si la variable Get 'page' n'est pas définie.
if (!filter_input(INPUT_GET, 'page', FILTER_SANITIZE_NUMBER_INT)) {
    //On redirige vers la page 1
    header('location:forum.php?page=1');
    exit();
}
//Si la page demandée est supérieure à la dernière page
if ($page > $pages) {
    //On redirige vers la dernière page
    header('location:forum.php?page=' . $pages);
    exit();
} //Si la page demandée est inférieure à la première page
elseif ($page < 1) {
    header('location:forum.php?page=1');
    exit();
}