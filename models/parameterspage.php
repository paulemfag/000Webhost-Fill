<?php
require_once 'sqlparameters.php';
//récupération des valeurs dans des variables
$actualAccountType = $_SESSION['accounttype'];
$pseudo = $_SESSION['pseudo'];
$changeAccountPassword = $_POST['changeAccountPassword'];
if ($actualAccountType == 'compositor') {
    $accounttype = 'particular';
}
if ($actualAccountType == 'particular') {
    $accounttype = 'compositor';
}
//vérification de la valeur de l'input et conversion de la valeur si celle ci est bonne
if ($accounttype != $actualAccountType && $accounttype == 'compositor' || $accounttype == 'particular') {
    if ($accounttype == 'particulier') {
        $accounttype = 'particular';
    }
    if ($accounttype == 'compositeur') {
        $accounttype = 'compositor';
    }
//récupération des colonnes en BDD
    try {
        $stmt = $db->prepare('SELECT pseudo, password, accounttype FROM `users` WHERE `pseudo` LIKE :pseudo ');
        if ($stmt->execute(array(':pseudo' => $pseudo)) && $row = $stmt->fetch()) {
            $password = $row['password'];
            //comparaison du mot de passe saisi avec celui de la BDD
            if (password_verify($changeAccountPassword, $password)) {
                //Update en BDD
                try {
                    $sth = $db->prepare('UPDATE `users` SET accounttype = :accounttype WHERE `pseudo` = :pseudo');
                    $sth->bindValue(':pseudo', $pseudo, PDO::PARAM_STR);
                    $sth->bindValue(':accounttype', $accounttype, PDO::PARAM_STR);
                    $sth->execute();
                    $changeAccount = 'isOk';
                } catch (PDOException $e) {
                    echo "Erreur : " . $e->getMessage();
                }
            } else {
                $errors['changeAccountPassword'] = 'Votre mot de passe est incorrect, merci de réessayer.';
            }
        }
    } catch (PDOException $e) {
        echo "Erreur : " . $e->getMessage();
    }
} else {
    $errors['changeAccountPassword'] = 'Une erreur c\'est produite merci de réessayer ultérieurement.';
}
