<?php
require_once 'sqlparameters.php';
if (!filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT)) {
    header('location:accueil.php');
    exit();
} else {
    $id = $_GET['id'];
}
//récupération des infos de la table compositions en BDD
$stmt = $db->prepare('SELECT compositions.id, compositions.title, compositions.file, compositions.chords, compositions.instrumentsUsed, compositions.id_users, categories.style FROM compositions INNER JOIN categories ON compositions.id = :id AND compositions.title = categories.title ');
if ($stmt->execute(array(':id' => $id)) && $row = $stmt->fetchAll(PDO::FETCH_ASSOC)) {
    $display = true;
    echo $display;
    //stockage des informations dans des variables
    foreach ($row as $rowInfo) {
        $title = $rowInfo['title'];
        $file = $rowInfo['file'];
        $idUser = $rowInfo['id_users'];
        $chords = $rowInfo['chords'];
        $instrumentsUsed = $rowInfo['instrumentsUsed'];
        $style = $rowInfo['style'];
    }
    //Récupération de la liste des playlist au cas ou l'utilisateur veux ajouter le titre à une playlist.
    try {
        $sth = $db->prepare('SELECT `id`, `title` FROM `playlists` WHERE `id_users` = :id ORDER BY `title` ASC');
        $sth->bindValue(':id', $_SESSION['id'], PDO::PARAM_INT);
        $sth->execute();
        $playlists = $sth->fetchAll(PDO::FETCH_ASSOC);
    } catch (Exception $ex) {
        die('Connexion échoué');
    }
    //Si l'utilisateur souhaite ajouter le titre à une playlist / que la variable $_GET['playlistId'] est définie.
    if (filter_input(INPUT_GET, 'playlistId', FILTER_SANITIZE_NUMBER_INT)){
        //On vérifie que le titre ne soit pas déjà dans la playlist.
        try {
            $sth = $db->prepare('SELECT `id` FROM `compo_in_playlist` WHERE `id_playlists` = :id_playlists AND id_compositions = :id_compositions');
            $sth->bindValue(':id_playlists', $_GET['playlistId'], PDO::PARAM_INT);
            $sth->bindValue(':id_compositions', $_GET['id'], PDO::PARAM_INT);
            $sth->execute();
            $compoInDb = $sth->fetch();
            $addToPlaylistStatus = '
<div class="alert alert-warning alert-dismissible fade show" role="alert">
    <p>La composition "<b>' .$title. '</b>" a déjà été ajoutée à votre playlist.</p>
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
    <span aria-hidden="true">&times;</span>
  </button>
</div>';
        } catch (PDOException $e) {
            echo "Erreur : " . $e->getMessage();
        }
        //Si le titre n'est pas déjà dans la playlist.
        if (!$compoInDb){
            try {
                //Insertion du titre en BDD, table compo_in_playlist.
                $sth = $db->prepare('INSERT INTO `compo_in_playlist` (added_at, id_playlists, id_compositions)
VALUES (current_timestamp, :id_playlists, :id_compositions)');
                $sth->bindValue(':id_playlists', $_GET['playlistId'], PDO::PARAM_INT);
                $sth->bindValue(':id_compositions', $_GET['id'], PDO::PARAM_INT);
                $sth->execute();
                $addToPlaylistStatus = '
<div class="alert alert-success alert-dismissible fade show" role="alert">
    <p><i class="far fa-check-circle"></i> La composition "<b>' .$title. '</b>" a bien été ajoutée à votre playlist.</p>
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
    <span aria-hidden="true">&times;</span>
  </button>
</div>';
            } catch (PDOException $e) {
                $addToPlaylistStatus = '
<div class="alert alert-danger alert-dismissible fade show" role="alert">
    <p>Une erreur est survenue, merci de réessayer ultérieurement.</p>
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
    <span aria-hidden="true">&times;</span>
  </button>
</div>';
            }
        }
    }
    if (!empty($chords) && $chords !== NULL){
        $chords = '<br>Instruments employés : '. $chords;
    }
    if (!empty($instrumentsUsed) && $instrumentsUsed !== NULL){
        $instrumentsUsed = '<br>Accords employés : '. $instrumentsUsed;
    }
    //Définition du titre de l'onglet / du <h1>
    $title = 'Page composition | ' . $title;
    //récupération pseudo du compositeur
    try {
        $sth = $db->prepare('SELECT `pseudo` FROM `users` WHERE `id` = :id');
        $sth->bindValue(':id', $idUser, PDO::PARAM_INT);
        $sth->execute();
        $user = $sth->fetch();
    } catch (Exception $ex) {
        die('Connexion échoué 1!');
    }
    $compositorPseudo = $user['pseudo'];
    //récupération des commentaires de la composition (dans l'ordre de publication)
    try {
        $sth = $db->prepare('SELECT comments.id, comments.comment, DATE_FORMAT(comments.published_at, \'le %d/%m/%Y\ à %HH%i\') as published_at_formatted, users.pseudo FROM `comments`
     JOIN users ON comments.id_users = users.id
     WHERE comments.id_compositions = :id_composition');
        $sth->bindValue(':id_composition', $id, PDO::PARAM_INT);
        $sth->execute();
        $commentList = $sth->fetchAll(PDO::FETCH_ASSOC);
    } catch (Exception $ex) {}
    if ($commentList){
        $commentsAnnouncement = '<div class="row">
        <h2 class="text-center bg-light col-10 opacity mt-2 ml-auto mr-auto">Commentaires :</h2>
    </div>
    <div class="container mt-1">';
    }
    if (filter_input(INPUT_GET, 'idComment', FILTER_SANITIZE_NUMBER_INT)) {
    //Suppression du commentaire dans la table comments.
        $idComment = $_GET['idComment'];
        try {
            $sth = $db->prepare('DELETE FROM `comments` WHERE `id_users` = :id_user AND `id` = :idComment');
            $sth->bindValue(':id_user', $_SESSION['id'], PDO::PARAM_INT);
            $sth->bindValue(':idComment', $idComment, PDO::PARAM_INT);
            $sth->execute();
            echo '<div class="alert alert-success alert-dismissible fade show" role="alert">
      <p>Votre commentaire a bien été suprimmé.</p>
      <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span>
      </button>
    </div>';
        } catch (PDOException $e) {
            echo '<div class="alert alert-warning alert-dismissible fade show" role="alert">
      <p>Une erreur est survenue pendant la suppression, merci de réessayer ultérieurement.</p>
      <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span>
      </button>
    </div>';
            exit();
        }
    }
}