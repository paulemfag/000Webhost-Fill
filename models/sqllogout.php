<?php
require_once 'sqlparameters.php';
try {
    $sth = $db->prepare('UPDATE `users` SET `connected` = :connected WHERE `pseudo` = :pseudo');
    $sth->bindValue(':connected', '0', PDO::PARAM_INT);
    $sth->bindValue(':pseudo', $_SESSION['pseudo'], PDO::PARAM_STR);
    $sth->execute();
} catch (PDOException $e) {
    echo "Erreur : " . $e->getMessage();
}