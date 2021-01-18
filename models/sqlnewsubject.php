<?php
require_once 'sqlparameters.php';
try {
    //Insertion en BDD.
    $sth = $db->prepare('INSERT INTO `topics` ( `title`, `created_at`, `id_users`) VALUES ( :subject, CURRENT_TIMESTAMP, :id_user)');
    $sth->bindValue(':subject', $subject, PDO::PARAM_STR);
    $sth->bindValue(':id_user', $_SESSION['id'], PDO::PARAM_INT);
    $sth->execute();
    //Récupération de l'id du topic pour rediriger l'utilisateur vers la page topic.
    try {
        $sth = $db->prepare('SELECT `id` FROM `topics` WHERE `title` = :subject AND `id_users` = :id_user');
        $sth->bindValue(':subject', $subject, PDO::PARAM_STR);
        $sth->bindValue(':id_user', $_SESSION['id'], PDO::PARAM_INT);
        $sth->execute();
        $topicId = $sth->fetch();
        try {
            $sth = $db->prepare('INSERT INTO `publications` ( `message`, `published_at`, `id_topics`, `id_users`, `pseudo`) VALUES ( :message, CURRENT_TIMESTAMP, :id_topic, :id_user, :pseudo)');
            $sth->bindValue(':message', $message, PDO::PARAM_STR);
            $sth->bindValue(':id_topic', $topicId['id'], PDO::PARAM_INT);
            $sth->bindValue(':id_user', $_SESSION['id'], PDO::PARAM_INT);
            $sth->bindValue(':pseudo', $_SESSION['pseudo'], PDO::PARAM_STR);
            $sth->execute();
            /*        header('location:topic.php?id=' .$topicId);
                    exit();*/
            echo '
<div class="alert alert-success alert-dismissible fade show text-center" role="alert">
<p>Votre topic " <a href="topic.php?id=' .$topicId['id']. '&page=1"><b>' .$subject. '</b></a> " a bien été crée.</p>
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
    <span aria-hidden="true">&times;</span>
  </button>
</div>';
        } catch (PDOException $e) {
            echo "Erreur : " . $e->getMessage();
        }
    } catch (PDOException $e) {
        echo "Erreur : " . $e->getMessage();
    }
} catch (PDOException $e) {
    echo "Erreur : " . $e->getMessage();
}