<?php
require_once 'sqlparameters.php';
//Déclaration variable
$id_composition = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT);
try {
    $sth = $db->prepare('INSERT INTO `comments` (`published_at`, `comment`, `id_compositions`, `id_users`) VALUES (CURRENT_TIMESTAMP, :comment, :id_composition, :id_users)');
    $sth->bindValue(':comment', $comment, PDO::PARAM_STR);
    $sth->bindValue(':id_composition', $id_composition, PDO::PARAM_INT);
    $sth->bindValue(':id_users', $_SESSION['id'], PDO::PARAM_INT);
    $sth->execute();
    $successfullCommented = true;
    $commentReturn = '<div class="alert alert-success alert-dismissible fade show" role="alert">
          <p>Votre commentaire a bien été publié.</p>
          <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>';
} catch (PDOException $e) {
    $commentReturn = '<div class="alert alert-danger alert-dismissible fade show" role="alert">
          <p>Une erreur est survenue, merci de réessayer ultérieurement.</p>
          <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>';
}
