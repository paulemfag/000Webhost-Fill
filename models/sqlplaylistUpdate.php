<?php
//Vérifie si l'id n'est pas vide et si c'est un entier
if (!filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT)) {
    //redirection vers la page d'accueil
    header('location:accueil.php');
    exit();
} else {
    //récupération de la variable Get
    $idPlaylist = $_GET['id'];
}
//récupérations des infos, log BDD
require_once 'sqlparameters.php';
//récupération des infos de la playlist en BDD
try {
    $sth = $db->prepare('SELECT `title` FROM `playlists` WHERE `id` = :id');
    $sth->bindValue(':id', $idPlaylist, PDO::PARAM_INT);
    $sth->execute();
    $playlists = $sth->fetchAll(PDO::FETCH_ASSOC);
} catch (Exception $ex) {
    die('Connexion échoué');
}
foreach ($playlists as $rowInfo) {
    $playlistTitle = $rowInfo['title'];
}
//titre de l'onglet
$title = 'Fill changement du titre de la playlist | ' . $playlistTitle;
//si le tableau d'erreur est vide la variable changeTitle est définie à 'true' (form_validation ligne 145)
if ($changeTitle){
    //Update en BDD
    try {
        $sth = $db->prepare('UPDATE `playlists` SET title = :title WHERE `id` = :id');
        $sth->bindValue(':title', $playlistNewTitle, PDO::PARAM_STR);
        $sth->bindValue(':id', $idPlaylist, PDO::PARAM_INT);
        $sth->execute();
        header('location:playlist.php?id='. $idPlaylist);
        exit();
    } catch (PDOException $e) {
        $anErrorOccured = '<div class="alert alert-warning alert-dismissible fade show" role="alert">
    <p>Une erreur est survenue pendant la mise à jour du titre de la playlist <b>' .$playlistTitle. '</b>, merci de réessayer ultérieurement.</p>
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
    <span aria-hidden="true">&times;</span>
  </button>
</div>';
    }
}