<?php
//Quand on arrive sur la page vérifie qu'une session n'est pas en cours
session_start();
//si c'est le cas détruit toutes les données enregistrées dans la session
session_destroy();
require_once 'controllers/form_validation.php';
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
    <meta name="description" content="Crée en 2019 par Monsieur FAGOT, FILL est un site d'écoute et de publication musicale
        développé dans l'optique d'offrir aux auteurs un endroit ou partager leur compositions ' To fill ' et au grand
    public de découvrir de nouveaux horizons ' To feel '." />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Fill | Bienvenue</title>
    <link rel="stylesheet" href="assets/css/style.css"/>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css"
          integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <!-- CDN font-awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.11.2/css/all.min.css">
    <!-- CDN google fonts -->
    <link href="https://fonts.googleapis.com/css?family=Odibee+Sans&display=swap" rel="stylesheet">
</head>
<body>
<!-- Navbar bootstrap -->
<nav class="navbar navbar-expand-lg navbar-light bg-secondary col-12-sm">
    <img src="assets/img/keyboards.png" alt="logo_clavier" height="40" width="60">
    <a id="FILL" class="navbar-brand text-light" style="font-weight: bold;">FILL</a>
    <!-- boutons inscription et connexion -->
    <div class="ml-auto">
        <p class="text-light" style="font-family: 'Odibee Sans', cursive; font-size: 20px;"><i>make it feel</i></p>
    </div>
    <div class="ml-auto">
        <button id="suscribebtn" class="btn btn-outline-primary my-2 my-sm-0">Inscription</button>
        <button id="connectbtn" class="btn btn-outline-success ml-1">Connexion</button>
    </div>
</nav>
<?= $notConfirmetYet ?? '' ?>
<!--        // Modal Cookies -->
<div id="userAuthorizationModal" class="modal" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"><i class="fas fa-cookie"></i> Utilisation des cookies :</h5>
            </div>
            <div class="modal-body">
                <p>En poursuivant votre navigation sur FILL, vous acceptez l’utilisation de cookies et du stockage local
                    de votre navigateur pour vous proposer le contrôle des informations générales associées à votre
                    compte personnel.</p>
                <p>Vous pouvez refuser ces conditions en cliquant sur le bouton "Refuser". Pour vous assurer la
                    meilleure utilisation de FILL, le refus du stockage local de vos informations nous amènerons à
                    limiter votre accès à notre site.</p>
                <div>
                    <input class="col-2 mt-1 float-left" type="checkbox" id="analytics" name="analytics" value="newsletter">
                    <label class="col-10 float-left" id="analyticsLabel" for="analytics">J'accepte l'utilisation des services d'analyse google ( analytics, optimize, surveys ).</label>
                    <input class="col-2 mt-1 float-left" type="checkbox" id="storage" name="storage" value="newsletter">
                    <label class="col-10 float-left" id="storageLabel" for="storage">J'accepte le stockage de mes informations* :<br>- Adresse mail<br>- Pseudo <br>- Mot de passe</label>
                    <p>*Ces informations sont collectés afin de permettre un bon fonctionnement du site et ne seront pas communiqués à des tierces.</p>
                </div>
            </div>
            <div class="modal-footer">
                <button id="storageDecline" type="button" class="btn btn-block btn-danger my-0 mx-5"
                        data-dismiss="modal">Refuser
                </button>
                <button id="storageAllow" type="button" class="btn btn-block btn-success my-0 mx-5"
                        data-dismiss="modal">Autoriser
                </button>
            </div>
        </div>
    </div>
</div>
<?php //Message d'alerte informant que le compte a bien été crée
echo $activeYourAccount ?? '' ?>
<div class="opacity bg-light" id="presentationText">
    <p class="text-center" id="introduction"><i>Crée en 2019 par Monsieur FAGOT, FILL est un site d'écoute et de publication musicale
        développé dans l'optique d'offrir aux auteurs un endroit ou partager leur compositions " To fill " et au grand
        public de découvrir de nouveaux horizons " To feel ".<br>
        Les membres disposent également d'un espace Forum ou ils peuvent débattre sur des sujets qui leurs tiennent à
        coeur.
        </i><p>
</div>
<div id="suscribeItems">
    <div id="scroll">
        <div class="container text-center bg-light mt-2 opacity">
            <h1 class="text-primary ml-auto mr-auto">Fill | Inscription :</h1>
        </div>
        <!-- form Inscription -->
        <form class="container" id="suscribers" method="post" action="#" novalidate>
            <div class="form-group">
                <label class="text-light" for="typeOfAccount">Type de compte :</label>
                <select class="form-control col-12" name="typeOfAccount" id="typeOfAccount">
                    <option value="particular">Particulier</option>
                    <option value="compositor">Compositeur</option>
                </select>
            </div>
            <div class="form-group">
                <label class="text-light" for="suscribepseudo">Pseudo :</label>
                <span class="text-danger float-right"><?= ($errors['suscribepseudo']) ?? '' ?></span>
                <input id="suscribepseudo" name="suscribepseudo" class="col-12 mt-1 inputColor" type="text" placeholder="Pseudo" value="<?= $suscribepseudo ?>" autocomplete="off" maxlength="50" required>
            </div>
            <div class="form-group">
                <label class="text-light" for="suscribemailbox">Adresse mail :</label>
                <span class="text-danger float-right"><?= ($errors['suscribemailbox']) ?? '' ?></span>
                <input id="suscribemailbox" name="suscribemailbox" class="col-12 mt-1 inputColor" type="email" placeholder="exemple@mail.com" value="<?= $suscribemailbox ?>" autocomplete="off" maxlength="50" required>
            </div>
            <div class="form-group">
                <label class="text-light" for="suscribepassword">Mot de passe :</label>
                <span class="text-danger float-right"><?= ($errors['suscribepassword']) ?? '' ?></span>
                <input id="suscribepassword" name="suscribepassword" class="col-12 mt-1 inputColor" type="password" placeholder="*****" value="<?= $suscribepassword ?>" autocomplete="off" maxlength="60" required>
            </div>
            <div class="form-group">
                <input id="suscribepasswordconfirmation" name="suscribepasswordconfirmation" class="col-12 mt-1 inputColor" type="password" placeholder="Confirmation du mot de passe" value="<?= $suscribepasswordconfirmation ?>" autocomplete="off" maxlength="60" required>
            </div>
            <div class="captcha">
                <div
                    class="g-recaptcha"
                    data-sitekey="6Lc2seAUAAAAABg_R6mlOzQuKOkLNxYkyQiRLf7x"
                    style="display: inline-block;">
                </div>
            </div>
            <button id="suscribe" name="suscribe" class="btn btn-outline-primary col-12 mt-1"
                    type="submit" value="<?= $suscribe ?? '' ?>">M'inscrire
            </button>
            <span class="text-success float-right"><?= ($errors['isok']) ?? '' ?></span>
        </form>
    </div>
</div>
<div id="connectItems">
    <div class="container text-center bg-light mt-2 opacity">
        <h1 class="text-primary ml-auto mr-auto">Fill | Connexion :</h1>
    </div>
    <!-- Form Connexion -->
    <form class="container" action="#" method="post" novalidate>
        <div class="form-group">
            <label class="text-light" for="pseudo">Pseudo :</label>
            <span class="text-danger float-right"><?= ($errors['pseudo']) ?? '' ?></span>
            <input id="pseudo" name="pseudo" class="col-12 mt-1 inputColor" type="text" placeholder="Pseudo" value="<?= $pseudo ?>" autocomplete="off" maxlength="50" required>
        </div>
        <div class="form-group">
            <label class="text-light" for="password">Mot de passe :</label>
            <span class="text-danger float-right"><?= ($errors['password']) ?? '' ?></span>
            <input id="password" name="password" class="col-12 mt-1 inputColor" type="password" placeholder="Mot de passe" value="<?= $_POST['password'] ?? '' ?>" autocomplete="off" maxlength="60" required>
        </div>
        <div class="row text-center">
            <a class="col-12 indexhref" title="Créer un compte" id="noAccount" href="#">Je n'ai pas encore de compte</a>
            <a class="col-12 indexhref" title="Récupérer mon mot de passe" id="lostPassword" href="#">Mot de passe oublié</a>
        </div>
        <div class="captcha">
            <div
                class="g-recaptcha"
                data-sitekey="6Lc2seAUAAAAABg_R6mlOzQuKOkLNxYkyQiRLf7x"
                style="display: inline-block;">
            </div>
        </div>
        <span class="text-danger float-right"><?= $errors['login'] ?? '' ?></span>
        <button id="login" name="login" class="btn btn-outline-primary col-12 text-center mt-1"
                type="submit" value="<?= $login ?? '' ?>">Me connecter
        </button>
    </form>
</div>
<form class="container" id='forgottenPassword' method="post" novalidate>
    <?= $recuperationReturn ?? '' ?>
    <div class="container text-center bg-light mt-2 opacity">
        <h1 class="text-primary ml-auto mr-auto">Récupération du mot de passe :</h1>
    </div>
    <div class="form-group">
        <label class="text-light" for="recuperationMailbox">Adresse mail :</label>
        <span class="text-danger float-right"><?= ($errors['recuperationMailbox']) ?? '' ?></span>
        <input id="recuperationMailbox" class="col-12 inputColor" name="recuperationMailbox" type="text" value="<?= $recuperationMailbox ?>" autocomplete="off" maxlength="50" required>
    </div>
    <div class="captcha">
        <div
            class="g-recaptcha"
            data-sitekey="6Lc2seAUAAAAABg_R6mlOzQuKOkLNxYkyQiRLf7x"
            style="display: inline-block;">
        </div>
    </div>
    <button id="recuperation" name="recuperation" class="btn btn-outline-success col-12 text-center mt-1" type="submit"
            value="<?= $recuperation ?? '' ?>">Récupérer mon mot de passe
    </button>
</form>
<div class="content">
    <p><br><br><br><br></p>
</div>
<?php require_once 'views/require/footer.php';?>
<script src="https://www.google.com/recaptcha/api.js" async defer></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script src="assets/js/home_min.js"></script>
<?php
//Si on viens d'arriver sur le site / qu'aucun formulaire n'as été envoyé, on affiche la modal de cookies.
if (empty($_POST)): ?>
<script src="assets/js/home_cookie_modal_min.js"></script>
<?php endif; ?>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"
        integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1"
        crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"
        integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM"
        crossorigin="anonymous"></script>
</body>
</html>
