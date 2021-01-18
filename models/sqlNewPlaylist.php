<?php
require_once 'sqlparameters.php';
$id = $_SESSION['id'];
try {
    $sth = $db->prepare('SELECT `id`, `title` FROM `playlists` WHERE `id_users` = :id AND `title` = :title');
    $sth->bindValue(':id', $id, PDO::PARAM_INT);
    $sth->bindValue(':title', $playlistName, PDO::PARAM_STR);
    $sth->execute();
    $playlists = $sth->fetchAll(PDO::FETCH_ASSOC);
    if ($playlists){
        $creationStatus = '
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
          <p><i class="fas fa-exclamation-triangle"></i> La playlist <b>" '. $_POST['playlistName'] .' "</b> existe déjà.</p>
          <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>';
    }
    else{
        try {
            // insertion dans la base de donnée
            $sth = $db->prepare('INSERT INTO `playlists` (title, id_users)
VALUES (:title, :id)');
            $sth->bindValue(':title', $playlistName, PDO::PARAM_STR);
            $sth->bindValue(':id', $id, PDO::PARAM_INT);
            $sth->execute();
            $creationStatus = '
        <div class="alert alert-success alert-dismissible fade show" role="alert">
          <p><i class="far fa-check-circle"></i> La playlist <b>" '. $_POST['playlistName'] .' "</b> a bien été crée.</p>
          <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>';
        } catch (PDOException $e) {
            echo "Erreur : " . $e->getMessage();
        }
    }
} catch (Exception $ex) {
    die('Connexion échoué');
}