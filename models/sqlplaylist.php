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
    $sth = $db->prepare('SELECT * FROM `playlists` WHERE `id` = :id');
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
$title = 'Fill | ' . $playlistTitle;
//récupératioon de toutes les informations des titres de la playlist dans les tables
try {
    $sth = $db->prepare(
        "SELECT compositions.id as compositionid, compositions.title, compositions.file, categories.style, users.id, users.pseudo  FROM `compo_in_playlist` 
JOIN compositions ON compositions.id = compo_in_playlist.id_compositions
JOIN categories ON categories.title = compositions.title
JOIN users ON compositions.id_users = users.id
JOIN playlists ON playlists.id = compo_in_playlist.id_playlists 
WHERE playlists.id = :id
ORDER BY `added_at` DESC
LIMIT $start, $limit"
    );
    $sth->bindValue(':id', $idPlaylist, PDO::PARAM_INT);
    $sth->execute();
    $compositionsList = $sth->fetchAll(PDO::FETCH_ASSOC);
} catch (Exception $ex) {
    die('Connexion échoué');
}
//Si on clique sur le bouton "suprimmer la composition" requiert le fichier playlist.js (view : ligne 79) qui affiche la modal de confiramation
if (filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT) && filter_input(INPUT_GET, 'idcomposition', FILTER_SANITIZE_NUMBER_INT)) {
    $show_modal_composition = true;
}
else{
    $show_modal_composition = false;
}
//Si les paramètres d'url sont définis (id playlist, id composition) et que la suppression a été confirmée.
if (filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT) && filter_input(INPUT_GET, 'idcomposition', FILTER_SANITIZE_NUMBER_INT) && filter_input(INPUT_GET, 'delete', FILTER_SANITIZE_NUMBER_INT) == 1) {
    //N'affiche pas la modal de confirmation
    $show_modal_composition = false;
    //Stocakge de l'id récupéré en GET dans une variable
    $idcomposition = $_GET['idcomposition'];
    //suppression dans la table compo_in_playlist
    try {
        $sth = $db->prepare('DELETE FROM compo_in_playlist WHERE `id_playlists` = :idplaylist AND `id_compositions` = :idcomposition');
        $sth->bindValue(':idplaylist', $idPlaylist, PDO::PARAM_INT);
        $sth->bindValue(':idcomposition', $idcomposition, PDO::PARAM_INT);
        $sth->execute();
        header('location:playlist.php?id='. $_GET['id'] .'&page=1&success=1');
        exit();
    }
    catch (Exception $ex) {
        die('Connexion échoué');
    }
}
//Si la suppression de la composition s'est bien passée affiche une alert bootstrap pour prévenir l'utilisateur
if (filter_input(INPUT_GET, 'success', FILTER_SANITIZE_NUMBER_INT) == 1){
    $successfulDelete = '
        <div class="alert alert-success alert-dismissible fade show" role="alert">
          <p>La composition a bien été suprimmée de la playlist.</p>
          <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>';
}
//Si les paramètres d'url sont définis (id playlist et que la suppression a été confirmée)
if (filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT) && filter_input(INPUT_GET, 'playlistDelete', FILTER_SANITIZE_NUMBER_INT) == 1) {
    //suppression des compositions dans la table compo_in_playlist
    try {
        $sth = $db->prepare('DELETE FROM compo_in_playlist WHERE `id_playlists` = :idplaylist');
        $sth->bindValue(':idplaylist', $idPlaylist, PDO::PARAM_INT);
        $sth->execute();
    }
    catch (Exception $ex) {
        die('Connexion échoué');
    }
    //suppression de la playlist dans la table playlists
    try {
        $sth = $db->prepare('DELETE FROM playlists WHERE `id` = :idplaylist');
        $sth->bindValue(':idplaylist', $idPlaylist, PDO::PARAM_INT);
        $sth->execute();
        $successfulDelete = '
        <div class="alert alert-success alert-dismissible fade show" role="alert">
          <p>La playlist '. $playlistTitle .' a bien été suprimmée.</p>
          <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>';
    }
    catch (Exception $ex) {
        die('suppresion de la playlist échoué');
    }
}