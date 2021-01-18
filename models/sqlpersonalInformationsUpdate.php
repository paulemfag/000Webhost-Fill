<?php
require_once 'sqlparameters.php';
$id = $_SESSION['id'];
//récupération des informations utilisateur
try {
    $sth = $db->prepare('SELECT `pseudo`, `biography`, `instruments`, `software`, `facebookId`, `twitterId` FROM `users` WHERE `id` = :id');
    $sth->bindValue(':id', $id, PDO::PARAM_INT);
    $sth->execute();
    $userInformations = $sth->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    echo "Erreur : " . $e->getMessage();
}
//stockage des informations dans des variables
foreach ($userInformations as $row) {
    $pseudo = $row['pseudo'];
    $biographyInDb = $row['biography'];
    $instrumentsInDb = $row['instruments'];
    $softwareInDb = $row['software'];
    $facebookIdInDb = $row['facebookId'];
    $twitterIdInDb = $row['twitterId'];
}
if ($changePersonalInformations){
    //Update en BDD
    try {
        $sth = $db->prepare('UPDATE `users` SET `biography` = :biography, `instruments` = :instruments, `software` = :software, `facebookId` = :facebookId, `twitterId` = :twitterId WHERE `pseudo` = :pseudo');
        $sth->bindValue(':biography', $biography, PDO::PARAM_STR);
        $sth->bindValue(':instruments', $instruments, PDO::PARAM_STR);
        $sth->bindValue(':software', $software, PDO::PARAM_STR);
        $sth->bindValue(':facebookId', $facebook, PDO::PARAM_STR);
        $sth->bindValue(':twitterId', $twitter, PDO::PARAM_STR);
        $sth->execute();
    } catch (PDOException $e) {
        echo "Erreur : " . $e->getMessage();
    }
}