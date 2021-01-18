<?php
require_once 'sqlparameters.php';
//Définition de la limit par rapport au select du form, si non définie prend 10 comme valeur.
$limit = 20;
$page = isset($_GET['page']) ? $_GET['page'] : 1;
$start = ($page - 1) * $limit;
try {
    //Calcul du nombre de compositions.
    $styleQueryOne = $db->query("SELECT count(`id`) AS `id` FROM `compositions`");
    $styleCount = $styleQueryOne->fetchAll(PDO::FETCH_ASSOC);
    //Stockage du nombre de compositions dans la variable 'total'.
    $total = $styleCount[0]['id'];
    //Calcul du nombre de pages.
    $pages = ceil($total / $limit);
    //Définition du bouton page précédente.
    $previous = $page - 1;
    //Définition du bouton page suivante.
    $next = $page + 1;
} catch (Exception $ex) {
    die('Connexion échoué');
}
//Si la page sur laquelle on se trouve est supérieure à la dernière page
if ($page > $pages) {
    //On redirige vers la dernière page
    header('location:forum.php?page=' . $pages);
    exit();
} elseif ($page < 1) {
    header('location:forum.php?page=1');
    exit();
}