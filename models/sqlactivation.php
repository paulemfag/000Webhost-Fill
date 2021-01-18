<?php
require_once 'sqlparameters.php';
// récupère la taille de la clé
$keylength = strlen($_GET['cle']);
// Si les variables ne sont pas définies dans l'url ou que la clé n'est pas de 32 charactères, renvoie vers la page 'index.php'
if (empty($_GET['log']) || empty($_GET['cle']) || $keylength < 32 || $keylength > 32) {
    header('location:index.php');
    exit();
}
// Récupération des variables nécessaires à l'activation
$pseudo = $_GET['log'];
$activationkey = $_GET['cle'];

// Récupération de la clé correspondant au $login dans la base de données
$stmt = $db->prepare('SELECT activationkey ,active FROM `users` WHERE pseudo like :pseudo ');
if ($stmt->execute(array(':pseudo' => $pseudo)) && $row = $stmt->fetch()) {
    $activationkeybdd = $row['activationkey'];    // Récupération de la clé
    $active = $row['active']; // récupération de la colonne active qui contiendra alors 0 ou 1
}
// On teste la valeur de la variable $active récupérée dans la BDD
if ($active == '1') {
    // Si le compte est déjà actif on prévient
    echo '
<div class="alert alert-success alert-dismissible fade show text-center" role="alert">
  <p>Votre compte a déjà été activé.</p>
  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
    <span aria-hidden="true">&times;</span>
  </button>
</div>';
} // Si ce n'est pas le cas on passe aux comparaisons
else {
    if ($activationkey == $activationkeybdd) // On compare nos deux clés
    {
        // Si elles correspondent on active le compte !
        echo '
<div class="alert alert-success alert-dismissible fade show text-center" role="alert">
  <p>Votre compte a bien été activé.</p>
  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
    <span aria-hidden="true">&times;</span>
  </button>
</div>';

        // La requête qui va passer notre champ actif de 0 à 1
        $stmt = $db->prepare('UPDATE `users` SET active = 1 WHERE pseudo like :pseudo ');
        $stmt->bindParam(':pseudo', $pseudo);
        $stmt->execute();
    }
    // Si les deux clés sont différentes l'utilisateur est redirigé vers la page 'index.php'
    else {
        header('location:index.php');
        exit();
    }
}
