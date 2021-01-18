<?php
require_once 'sqlparameters.php';
//Récupération de l'id du destinataire dans la table users.
try {
    $sth = $db->prepare('SELECT `id` FROM `users` WHERE `pseudo` = :pseudo');
    $sth->bindValue(':pseudo', $pseudo, PDO::PARAM_STR);
    $sth->execute();
    $user = $sth->fetchAll(PDO::FETCH_ASSOC);
    foreach ($user as $row){
        //Stockage de l'id du destinataire dans la variable recieverid.
        $recieverid = $row['id'];
    }
    try {
        //Insertion en BDD.
        $sth = $db->prepare('INSERT INTO `messages` ( `expeditorid`, `sended_at`, `recieverid`, `object`, `message`) VALUES ( :expeditorid, CURRENT_TIMESTAMP, :recieverid, :object, :message)');
        $sth->bindValue(':expeditorid', $_SESSION['id'], PDO::PARAM_STR);
        $sth->bindValue(':recieverid', $recieverid, PDO::PARAM_INT);
        $sth->bindValue(':object', $objet, PDO::PARAM_STR);
        $sth->bindValue(':message', $message, PDO::PARAM_STR);
        $sth->execute();
        $sendingStatus = '
<div class="alert alert-success alert-dismissible fade show" role="alert">
    <p><i class="far fa-check-circle"></i> Votre message a bien été envoyé à <b>' .$pseudo. '</b>.</p>
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
    <span aria-hidden="true">&times;</span>
  </button>
</div>';
        $pseudo = NULL;
        $objet = NULL;
        $message = NULL;
    } catch (PDOException $e) {
        $sendingStatus = '
<div class="alert alert-danger alert-dismissible fade show" role="alert">
    <p>Le destinataire n\'existe pas.</p>
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
    <span aria-hidden="true">&times;</span>
  </button>
</div>';
    }
} catch (Exception $ex) {
    $sendingStatus = '
<div class="alert alert-danger alert-dismissible fade show" role="alert">
    <p>Une erreur est survenue merci de réessayer ultérieurement.</p>
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
    <span aria-hidden="true">&times;</span>
  </button>
</div>';
}
