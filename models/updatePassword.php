<?php
require_once 'sqlparameters.php';
//récupération des valeurs dans des variables
$pseudo = $_SESSION['pseudo'];
$newPassword = password_hash($newPassword, PASSWORD_DEFAULT);
//récupération des colonnes en BDD
    try {
        $stmt = $db->prepare('SELECT pseudo, password FROM `users` WHERE `pseudo` LIKE :pseudo ');
        if ($stmt->execute(array(':pseudo' => $pseudo)) && $row = $stmt->fetch()) {
            $password = $row['password'];
            //comparaison du mot de passe saisi avec celui de la BDD
            if (password_verify($actualPassword, $password)) {
                //Update en BDD
                try {
                    $sth = $db->prepare('UPDATE `users` SET password = :password WHERE `pseudo` = :pseudo');
                    $sth->bindValue(':pseudo', $pseudo, PDO::PARAM_STR);
                    $sth->bindValue(':password', $newPassword, PDO::PARAM_STR);
                    $sth->execute();
                    $message = '
<div class="alert alert-success alert-dismissible fade show" role="alert">
  <p>Votre mot de passe a bien été modifié.</p>
  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
    <span aria-hidden="true">&times;</span>
  </button>
</div>';
                } catch (PDOException $e) {
                    echo "Erreur : " . $e->getMessage();
                }
            } else {
                $errors['actualPassword'] = 'Votre mot de passe est incorrect, merci de réessayer.';
            }
        }
    } catch (PDOException $e) {
        echo "Erreur : " . $e->getMessage();
    }
$newPassword = $_POST['newPassword'];