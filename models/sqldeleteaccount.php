<?php
require_once 'sqlparameters.php';
try {
    $sth = $db->prepare('SELECT `password` FROM `users` WHERE `id` = :id');
    $sth->bindValue(':id', $_SESSION['id'], PDO::PARAM_INT);
    $sth->execute();
    $user = $sth->fetch();
} catch (Exception $ex) {
    die('Connexion échoué !');
}
//comparaison du mot de passe saisi avec celui en BDD
if (password_verify($removeMyAccountPassword, $user['password'])) {
    //stockage de la valeur 0 dans une variable pour changer la colonne `active`
    $active = 0;
    try {
        $sth = $db->prepare('UPDATE `users` SET `active` = :active WHERE id = :id');
        $sth->bindValue(':id', $_SESSION['id'], PDO::PARAM_INT);
        $sth->bindValue(':active', $active, PDO::PARAM_INT);
        $sth->execute();
        //redirection vers l'index(déconnexion)
        require_once '../views/logout.php';
    } catch (PDOException $e) {
        echo "Erreur : " . $e->getMessage();
    }
  //si le mot de passe est incorrect on avertit l'utilisateur
} else {
    $errors['Password'] = 'Votre mot de passe est incorrect merci de réessayer.';
}