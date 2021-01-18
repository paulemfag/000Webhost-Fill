<?php
if (empty($_GET['id'])){
    header('location:forum.php');
}
//Récupération de la liste des publications que contient le sujet
try {
    $sth = $db->prepare('SELECT
    topics.id
    topics.title,
    publications.id,
    publications.message,
    DATE_FORMAT(publications.published_at, \'le %d/%m/%Y\ à %HH%i\') `published_at`,
    publications.id_users,
    users.pseudo
    FROM `topics`
    INNER JOIN `publications`
    ON topics.id = publications.id_topics
    INNER JOIN `users`
    ON publications.id_users = users.id
    WHERE topics.id = :id
    ORDER BY `published_at` ASC
    LIMIT ' .$start. ', ' .$limit);
    $sth->bindValue(':id', $_GET['id'], PDO::PARAM_INT);
    $sth->execute();
    $publicationsList = $sth->fetchAll(PDO::FETCH_ASSOC);
} catch (Exception $ex) {
    die('Connexion échoué !');
}
//Si il n'y pas d'erreurs (form_validation.php : ligne 264) réalise l'insertion du message dans la table publications en BDD
if ($insertMessage){
    try {
        $sth = $db->prepare('UPDATE `topics` SET updated_at = CURRENT_TIMESTAMP WHERE `id` = :id');
        $sth->bindValue(':id', $_GET['id'], PDO::PARAM_INT);
        $sth->execute();
    } catch (PDOException $e) {
        echo "Erreur : " . $e->getMessage();
    }
    try {
        $sth = $db->prepare('INSERT INTO `publications` (`message`, `published_at`, `id_topics`, `id_users`, `pseudo`) VALUES (:message, CURRENT_TIMESTAMP, `:id_topics`, `:id_user`, `:pseudo`)');
        $sth->bindValue(':message', $message, PDO::PARAM_STR);
        $sth->bindValue(':id_topics', $_GET['id'], PDO::PARAM_INT);
        $sth->bindValue(':id_user', $_SESSION['id'], PDO::PARAM_INT);
        $sth->bindValue(':pseudo', $_SESSION['pseudo'], PDO::PARAM_STR);
        $sth->execute();
        echo 'ok';
    } catch (PDOException $e) {
        echo "Erreur : " . $e->getMessage();
    }
}
//Si l'utilisateur souhaite supprimer son topic la variable GET ' delete ' est définie.
if (filter_input(INPUT_GET, 'delete', FILTER_SANITIZE_NUMBER_INT)){
    //Suppression des publications du topic.
    try {
        $sth = $db->prepare('DELETE FROM `publications` WHERE `id_topics` = :id_topics');
        $sth->bindValue(':id_topics', $_GET['id'], PDO::PARAM_INT);
        $sth->execute();
    } catch (PDOException $e) {
        echo '<div class="alert alert-warning alert-dismissible fade show" role="alert">
  <p>Une erreur est survenue pendant la suppression, merci de réessayer ultérieurement.</p>
  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
    <span aria-hidden="true">&times;</span>
  </button>
</div>';
    }
    //Suppression du topic.
    try {
        $sth = $db->prepare('DELETE FROM `topics` WHERE `id` = :id');
        $sth->bindValue(':id', $_GET['id'], PDO::PARAM_INT);
        $sth->execute();
        echo '<div class="alert alert-success alert-dismissible fade show" role="alert">
  <p>Le sujet a bien été supprimé.</p>
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
    }
}