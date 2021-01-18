<?php
$hashedPasswordAfterReset = password_hash($passwordAfterReset, PASSWORD_DEFAULT);
//changement du mot de passe dans la table utilisateur
try {
    $sth = $db->prepare('UPDATE `users` SET password = :password WHERE `mailBox` = :mailBox');
    $sth->bindValue(':mailBox', $mailBox, PDO::PARAM_STR);
    $sth->bindValue(':password', $hashedPasswordAfterReset, PDO::PARAM_STR);
    $sth->execute();
    $recuperationStatus = '
<div class="alert alert-success alert-dismissible fade show" role="alert">
  <p>Votre mot de passe a bien été modifié.</p>
  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
    <span aria-hidden="true">&times;</span>
  </button>
</div>';
} catch (PDOException $e) {
    echo "Erreur : " . $e->getMessage();
}
//suppression de la ligne concernée dans la table password_reset_temp
try {
    $sth = $db->prepare('DELETE FROM `password_reset_temp` WHERE `email` = :mailBox');
    $sth->bindValue(':mailBox', $mailBox, PDO::PARAM_STR);
    $sth->execute();
    sleep(2);
    header('location:../index.php?Connectme=isOk');
} catch (PDOException $e) {
    echo "Erreur : " . $e->getMessage();
}