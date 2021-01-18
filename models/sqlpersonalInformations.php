<?php
require_once 'sqlparameters.php';
$pseudo = $_SESSION['pseudo'];
//Définition de la variable styles pour l'ajout en BDD
$styles = $tagOne;
if (!empty($tagTwo)){
    $styles = $styles .', '. $tagTwo;
}
if (!empty($tagThree)){
    $styles = $styles .', '. $tagThree;
}
if (!empty($tagFour)){
    $styles = $styles .', '. $tagFour;
}
if (!empty($tagFive)){
    $styles = $styles .', '. $tagFive;
}
try {
    $stmt = $db->prepare('UPDATE `users` SET `favoritesStyles` = :favoritesStyles, `biography` = :biography, `instruments` = :instruments, `facebookId` = :facebookId, `twitterId` = :twitterId, `software` = :software WHERE pseudo = :pseudo');
    $stmt->bindParam(':favoritesStyles', $styles, PDO::PARAM_STR);
    $stmt->bindParam(':biography', $biography, PDO::PARAM_STR);
    $stmt->bindParam(':instruments', $instruments, PDO::PARAM_STR);
    $stmt->bindParam(':facebookId', $facebook, PDO::PARAM_STR);
    $stmt->bindParam(':twitterId', $twitter, PDO::PARAM_STR);
    $stmt->bindParam(':software', $software, PDO::PARAM_STR);
    $stmt->bindParam(':pseudo', $pseudo, PDO::PARAM_STR);
    $stmt->execute();
    header('location:accueil.php');
    exit();
} catch (PDOException $e) {
    echo "Erreur : " . $e->getMessage();
}
