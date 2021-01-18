<?php
require_once '../models/sqlparameters.php';
//Définition fuseau horaire
date_default_timezone_set('Europe/Paris');
//Définition format de la date
$actualDatetime = date('Y-m-d H:i:s');
//vérifie que les paramètres GET sont valables
if (filter_input(INPUT_GET, 'email', FILTER_SANITIZE_STRING)
    && filter_input(INPUT_GET, 'key', FILTER_SANITIZE_STRING)) {
    $mailBox = $_GET['email'];
    $key = $_GET['key'];
    //récupère la longueur de la clé
    $keyLength = strlen($key);
    //si la clé ne fais pas 42 charactères
    if ($keyLength !== 42) {
        //redirige vers l'index
        header('location:../index.php');
        exit();
    }
    $stmt = $db->prepare('SELECT `key`, `expiration_date` FROM `password_reset_temp` WHERE `email` = :email ');
    if ($stmt->execute(array(':email' => $mailBox)) && $row = $stmt->fetchAll(PDO::FETCH_ASSOC)) {
        foreach ($row as $rowinfo) {
            $bddKey = $rowinfo['key'];
            $expirationDate = $rowinfo['expiration_date'];
        }
        //Si la date d'expiration est passée (comparaison de la date en BDD avec la date actuelle)
        if($actualDatetime > $expirationDate){
            header('location:../index.php');
            exit();
        }
        //Si la clé en BDD n'est pas égale à celle de l'url
        if ($bddKey !== $key) {
            header('location:../index.php');
            exit();
        }
    }
}
else {
    //Si les paramètres GET ne sont pas valables
    header('location:../index.php');
    exit();
}
require_once '../controllers/form_validation.php'; ?>
<!DOCTYPE html>
<html lang="fr" dir="ltr">
<head>
    <meta charset="utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Fill | Bienvenue</title>
    <link rel="stylesheet" href="../assets/css/style.css"/>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css"
          integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <!-- CDN font-awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.11.2/css/all.min.css">
    <!-- CDN google fonts -->
    <link href="https://fonts.googleapis.com/css?family=Odibee+Sans&display=swap" rel="stylesheet">
</head>
<body>
<!-- Navbar bootstrap -->
<nav class="navbar navbar-expand-lg navbar-light bg-secondary col-12">
    <img src="../assets/img/keyboards.png" alt="logo_clavier" height="40" width="60">
    <a id="FILL" class="navbar-brand text-light" style="font-weight: bold;">FILL</a>
</nav>
<?= $recuperationStatus ?? '' ?>
<div class="row">
    <h1 class="text-center bg-light col-10 opacity mt-2 ml-auto mr-auto">Récupération du mot de passe :</h1>
</div>
<form class="container" action="#" method="post" novalidate>
    <div class="form-group">
        <label class="text-light" for="passwordAfterReset">Nouveau mot de passe :</label>
        <span class="text-danger float-right"><?= ($errors['passwordAfterReset']) ?? '' ?></span>
        <input value="<?= $passwordAfterReset ?>" name="passwordAfterReset" id="passwordAfterReset"
               class="col-12 inputColor" type="password">
    </div>
    <div class="form-group">
        <label class="text-light" for="confirmPasswordAfterReset">Confirmation du nouveau mot de passe :</label>
        <span class="text-danger float-right"><?= ($errors['confirmPasswordAfterReset']) ?? '' ?></span>
        <input value="<?= $confirmPasswordAfterReset ?>" name="confirmPasswordAfterReset" id="confirmPasswordAfterReset"
               class="col-12 inputColor" type="password">
    </div>
    <input name="resetMyPassword" class="btn btn-outline-success col-12" value="Changer le mot de passe" type="submit">
</form>
<?php require_once 'require/footer.php' ?>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"
        integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1"
        crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"
        integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM"
        crossorigin="anonymous"></script>
</body>
</html>