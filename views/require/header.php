<?php
session_start();
// si l'utilisateur n'est pas connecté
if (empty($_SESSION)) {
    header('location:../index.php');
}
?>
<!DOCTYPE html>
<html lang="fr" dir="ltr">
<head>
    <!-- Global site tag (gtag.js) - Google Analytics -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=UA-177227619-1"></script>
    <script>
        window.dataLayer = window.dataLayer || [];
        function gtag(){dataLayer.push(arguments);}
        gtag('js', new Date());
        gtag('config', 'UA-177227619-1');
    </script>
    <meta charset="utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title><?= $title ?></title>
    <link rel="stylesheet" href="../../assets/css/style.css"/>
    <link rel="stylesheet" href="../../vendor/mervick/emojionearea/dist/emojionearea.min.css"/>
    <!-- CDN Bootstrap -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css"
          integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <!-- CDN font-awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.11.2/css/all.min.css">
    <!-- CDN google fonts -->
    <link href="https://fonts.googleapis.com/css?family=Odibee+Sans&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.0.12/css/all.css"
          integrity="sha384-G0fIWCsCzJIMAVNQPfjH08cyYaUtMwjJwqiRKxxE/rx96Uroj1BtIQ6MLJuheaO9"
          crossorigin="anonymous">
    <script src='https://www.google.com/recaptcha/api.js'></script>
</head>
<body>
<?php
//Fichier sql qui compte le nombre de messages non lu dans la boite de réception
require_once '../models/sqlmessagescount.php';
//Chargement de la bonne navbar selon le type de compte
if ($_SESSION['accounttype'] === 'compositor'){ ?>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-light bg-secondary">
        <img src="../assets/img/keyboards.png" alt="logo_clavier" height="40" width="60">
        <a class="navbar-brand text-light"><b>FILL</b></a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav">
                <li class="nav-item active">
                    <a title="Accueil" class="nav-link text-light" href="accueil.php"><i class="fas fa-home fa-lg"></i> Accueil<span class="sr-only">(current)</span></a>
                </li>
                <li class="nav-item">
                    <a title="Ma page" class="nav-link text-light" href="mypage.php"><i class="far fa-address-card fa-lg"></i> Ma page</a>
                </li>
                <li class="nav-item">
                    <a title="Messagerie" class="nav-link text-light" href="messagerie.php?page=1"><i class="fas fa-mail-bulk fa-lg"></i> Messagerie <?= $numberOfNewMessages['COUNT(`id`)'] ?></a>
                </li>
                <li class="nav-item">
                    <a title="Ajouter une composition" class="nav-link text-light" href="addcomposition.php"><i class="fas fa-cloud-upload-alt fa-lg"></i> Ajouter une composition</a>
                </li>
                <li class="nav-item dropdown">
                    <a title="Liste des Playlists" class="nav-link dropdown-toggle text-light" href="#" id="navbarDropdownPlaylist" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fas fa-bars fa-lg"></i> Playlists</a>
                    <div class="dropdown-menu" aria-labelledby="navbarDropdownPlaylist">
                        <a title="Créer une nouvelle paylist" href="newplaylist.php" id="newplaylist" class="dropdown-item text-light"><i class="fas fa-plus"></i> Nouvelle playlist</a>
                        <?php require_once '../models/playlistList.php'?>
                    </div>
                </li>
                <!-- Menu Tags -->
                <li class="nav-item dropdown">
                    <a title="Tags" class="nav-link dropdown-toggle text-light" href="#" id="navbarDropdownTags" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fas fa-tags fa-lg"></i> Tags</a>
                    <div class="dropdown-menu" aria-labelledby="navbarDropdownTags">
                        <a title="Page style | Afro" class="dropdown-item" href="stylePage.php?style=Afro&page=1"><i class="fas fa-tag"></i> Afro</a>
                        <a title="Page style | Blues" class="dropdown-item" href="stylePage.php?style=Blues&page=1"><i class="fas fa-tag"></i> Blues</a>
                        <a title="Page style | Classique" class="dropdown-item" href="stylePage.php?style=Classique&page=1"><i class="fas fa-tag"></i> Classique</a>
                        <a title="Page style | Disco" class="dropdown-item" href="stylePage.php?style=Disco&page=1"><i class="fas fa-tag"></i> Disco</a>
                        <a title="Page style | Electro" class="dropdown-item" href="stylePage.php?style=Electro&page=1"><i class="fas fa-tag"></i> Electro</a>
                        <a title="Page style | Funk" class="dropdown-item" href="stylePage.php?style=Funk&page=1"><i class="fas fa-tag"></i> Funk</a>
                        <a title="Page style | Gospel" class="dropdown-item" href="stylePage.php?style=Gospel&page=1"><i class="fas fa-tag"></i> Gospel</a>
                        <a title="Page style | Kompa" class="dropdown-item" href="stylePage.php?style=Kompa&page=1"><i class="fas fa-tag"></i> Kompa</a>
                        <a title="Page style | Metal" class="dropdown-item" href="stylePage.php?style=Metal&page=1"><i class="fas fa-tag"></i> Metal</a>
                        <a title="Page style | Pop" class="dropdown-item" href="stylePage.php?style=Pop&page=1"><i class="fas fa-tag"></i> Pop</a>
                        <a title="Page style | Punk" class="dropdown-item" href="stylePage.php?style=Punk&page=1"><i class="fas fa-tag"></i> Punk</a>
                        <a title="Page style | Raï" class="dropdown-item" href="stylePage.php?style=Raï&page=1"><i class="fas fa-tag"></i> Raï</a>
                        <a title="Page style | Rap" class="dropdown-item" href="stylePage.php?style=Rap&page=1"><i class="fas fa-tag"></i> Rap</a>
                        <a title="Page style | Reggae" class="dropdown-item" href="stylePage.php?style=Reggae&page=1"><i class="fas fa-tag"></i> Reggae</a>
                        <a title="Page style | R'n'B" class="dropdown-item" href="stylePage.php?style=R'n'B&page=1"><i class="fas fa-tag"></i> R'n'B</a>
                        <a title="Page style | Rock" class="dropdown-item" href="stylePage.php?style=Rock&page=1"><i class="fas fa-tag"></i> Rock</a>
                    </div>
                </li>
            </ul>
            <ul class="navbar-nav ml-auto mr-4">
                <li class="nav-item dropdown">
                    <a title="Menu" class="nav-link dropdown-toggle text-light" href="#" id="navbarDropdownMenu" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Menu</a>
                    <div class="dropdown-menu" aria-labelledby="navbarDropdownMenu">
                        <a title="Paramètres" class="dropdown-item" href="parameters.php"><i class="fas fa-cogs"></i> Paramètres</a>
                        <a title="Conditions générales d'utilisation" class="dropdown-item" href="#"><i class="fas fa-info"></i> CGU</a>
                        <a title="Me déconnecter" class="dropdown-item text-danger" href="logout.php">Me déconnecter <i class="fas fa-sign-out-alt"></i></a>
                    </div>
                </li>
                <li>
                    <a title="Forum" class="btn btn-light text-dark" href="forum.php?page=1" role="button">Forum</a>
                </li>
            </ul>
        </div>
    </nav>
<?php }
elseif ($_SESSION['accounttype'] === 'particular'){ ?>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-light bg-secondary">
        <img src="../assets/img/keyboards.png" alt="logo_clavier" height="40" width="60">
        <a class="navbar-brand text-light"><b>FILL</b></a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav">
                <li class="nav-item active">
                    <a title="Accueil" class="nav-link text-light" href="accueil.php"><i class="fas fa-home fa-lg"></i> Accueil<span class="sr-only">(current)</span></a>
                </li>
                    <a title="Messagerie" class="nav-link text-light" href="messagerie.php?page=1"><i class="fas fa-mail-bulk fa-lg"></i> Messagerie <?= $numberOfNewMessages['COUNT(`id`)'] ?></a>
                </li>
                <li class="nav-item dropdown">
                    <a title="Liste des Playlists" class="nav-link dropdown-toggle text-light" href="#" id="navbarDropdownPlaylist" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fas fa-bars fa-lg"></i> Playlists</a>
                    <div class="dropdown-menu" aria-labelledby="navbarDropdownPlaylist">
                        <a title="Créer une nouvelle paylist" href="newplaylist.php" id="newplaylist" class="dropdown-item text-light"><i class="fas fa-plus"></i> Nouvelle playlist</a>
                        <?php require_once '../models/playlistList.php'?>
                    </div>
                </li>
                <!-- Menu Tags -->
                <li class="nav-item dropdown">
                    <a title="Tags" class="nav-link dropdown-toggle text-light" href="#" id="navbarDropdownTags" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fas fa-tags fa-lg"></i> Tags</a>
                    <div class="dropdown-menu" aria-labelledby="navbarDropdownTags">
                        <a title="Page style | Afro" class="dropdown-item" href="stylePage.php?style=Afro&page=1"><i class="fas fa-tag"></i> Afro</a>
                        <a title="Page style | Blues" class="dropdown-item" href="stylePage.php?style=Blues&page=1"><i class="fas fa-tag"></i> Blues</a>
                        <a title="Page style | Classique" class="dropdown-item" href="stylePage.php?style=Classique&page=1"><i class="fas fa-tag"></i> Classique</a>
                        <a title="Page style | Disco" class="dropdown-item" href="stylePage.php?style=Disco&page=1"><i class="fas fa-tag"></i> Disco</a>
                        <a title="Page style | Electro" class="dropdown-item" href="stylePage.php?style=Electro&page=1"><i class="fas fa-tag"></i> Electro</a>
                        <a title="Page style | Funk" class="dropdown-item" href="stylePage.php?style=Funk&page=1"><i class="fas fa-tag"></i> Funk</a>
                        <a title="Page style | Gospel" class="dropdown-item" href="stylePage.php?style=Gospel&page=1"><i class="fas fa-tag"></i> Gospel</a>
                        <a title="Page style | Kompa" class="dropdown-item" href="stylePage.php?style=Kompa&page=1"><i class="fas fa-tag"></i> Kompa</a>
                        <a title="Page style | Metal" class="dropdown-item" href="stylePage.php?style=Metal&page=1"><i class="fas fa-tag"></i> Metal</a>
                        <a title="Page style | Pop" class="dropdown-item" href="stylePage.php?style=Pop&page=1"><i class="fas fa-tag"></i> Pop</a>
                        <a title="Page style | Punk" class="dropdown-item" href="stylePage.php?style=Punk&page=1"><i class="fas fa-tag"></i> Punk</a>
                        <a title="Page style | Raï" class="dropdown-item" href="stylePage.php?style=Raï&page=1"><i class="fas fa-tag"></i> Raï</a>
                        <a title="Page style | Rap" class="dropdown-item" href="stylePage.php?style=Rap&page=1"><i class="fas fa-tag"></i> Rap</a>
                        <a title="Page style | Reggae" class="dropdown-item" href="stylePage.php?style=Reggae&page=1"><i class="fas fa-tag"></i> Reggae</a>
                        <a title="Page style | R'n'B" class="dropdown-item" href="stylePage.php?style=R'n'B&page=1"><i class="fas fa-tag"></i> R'n'B</a>
                        <a title="Page style | Rock" class="dropdown-item" href="stylePage.php?style=Rock&page=1"><i class="fas fa-tag"></i> Rock</a>
                    </div>
                </li>
                <li class="nav-item">
                    <a title="Modifier mes informations personnelles" class="nav-link text-light" href="personalInformationsUpdate.php"><i class="far fa-id-card fa-lg"></i> Modifier mes informations personnelles</a>
                </li>
            </ul>
            <ul class="navbar-nav ml-auto mr-4">
                <li class="nav-item dropdown">
                    <a title="Menu" class="nav-link dropdown-toggle text-light" href="#" id="navbarDropdownMenu" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Menu</a>
                    <div class="dropdown-menu" aria-labelledby="navbarDropdownMenu">
                        <a title="Paramètres" class="dropdown-item" href="parameters.php"><i class="fas fa-cogs"></i> Paramètres</a>
                        <a title="Conditions générales d'utilisation" class="dropdown-item" href="#"><i class="fas fa-info"></i> CGU</a>
                        <a title="Me déconnecter" class="dropdown-item text-danger" href="logout.php">Me déconnecter <i class="fas fa-sign-out-alt"></i></a>
                    </div>
                </li>
                <li>
                    <a title="Forum" class="btn btn-light text-dark" href="forum.php?page=1" role="button">Forum</a>
                </li>
            </ul>
        </div>
    </nav>
<?php } ?>