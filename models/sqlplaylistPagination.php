<?php
require_once 'sqlparameters.php';
$idPlaylist = $_GET['id'];
//Définition de la limite de topics par page.
$limit = 20;
$page = isset($_GET['page']) ? $_GET['page'] : 1;
$start = ($page - 1) * $limit;
try {
    //Calcul du nombre de titres dans la playlist.
    $sth = $db->prepare("SELECT count(`id`) AS `id` FROM `compo_in_playlist` WHERE `id_playlists` = :id_playlist");
    $sth->bindValue(':id_playlist', $idPlaylist, PDO::PARAM_INT);
    $sth->execute();
    $compositionsCount = $sth->fetchAll(PDO::FETCH_ASSOC);
    //Stockage du nombre de titres dans la playlist dans la variable 'total'.
    $total = $compositionsCount[0]['id'];
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
if (!filter_input(INPUT_GET, 'page', FILTER_SANITIZE_NUMBER_INT)){
    //On redirige vers la page 1
    header('location:playlist.php?id=' .$idPlaylist. '&page=1');
    exit();
}
//Si la page demandée est supérieure à la dernière page
if ($page > $pages && $page > 1){
    //On redirige vers la dernière page
    header('location:playlist.php?id=' .$idPlaylist.'&page=' .$pages);
    exit();
}
//Si la page demandée est inférieure à la première page
elseif ($page < 0){
    header('location:playlist.php?id=' .$idPlaylist. '&page=1');
    exit();
}