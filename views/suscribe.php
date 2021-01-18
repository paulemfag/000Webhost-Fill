<?php
session_start();
// si l'utilisateur n'est pas connecté
if (empty($_SESSION)) {
    header('location:index.php');
}
require_once '../controllers/form_validation.php';
?>
<!DOCTYPE html>
<html lang="fr" dir="ltr">
<head>
    <meta charset="utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Fill | Informations personnelles</title>
    <link rel="stylesheet" href="../vendor/mervick/emojionearea/dist/emojionearea.min.css"/>
    <link rel="stylesheet" href="../assets/css/style.css"/>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css"
          integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <!-- CDN font-awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.11.2/css/all.min.css">
    <!-- CDN google fonts -->
    <link href="https://fonts.googleapis.com/css?family=Odibee+Sans&display=swap" rel="stylesheet">
</head>
<!-- Navbar bootstrap -->
<nav class="navbar navbar-expand-lg navbar-light bg-secondary col-12-sm
">
    <img src="../assets/img/keyboards.png" alt="logo_clavier" height="40" width="60">
    <a id="FILL" class="navbar-brand text-light" style="font-weight: bold;">FILL</a>
</nav>
<div class="row">
    <h1 class="text-center bg-light col-10 opacity mt-2 ml-auto mr-auto">Informations personnelles :</h1>
</div>
<div class="text-center">
    <p class="text-light"><b>Type de compte :</b></p>
    <?php if ($_SESSION['accounttype'] == 'particular') { ?>
        <input id="particular" type="radio" name="accounttype" value="1" checked="checked">
        <label class="text-light" for="particular"><b>Particulier</b></label>
        <input id="compositor" type="radio" name="accounttype" value="2" disabled>
        <label class="text-light" for="compositor"><b>Compositeur</b></label>
    <?php } elseif ($_SESSION['accounttype'] == 'compositor') { ?>
        <input id="particular" type="radio" name="accounttype" value="1" disabled>
        <label class="text-light" for="particular"><b>Particulier</b></label>
        <input id="compositor" type="radio" name="accounttype" value="2" checked="checked">
        <label class="text-light" for="compositor"><b>Compositeur</b></label>
    <?php } ?>
</div>
<div id="compositorItems">
    <form id="compositorForm" class="container" action="#" method="post" novalidate>
        <div class="form-group">
            <label class="text-light" for="biography"><i class="fas fa-address-card"></i><b> Biographie :</b></label>
            <textarea style="resize: none;" maxlength="250" rows="4" cols="121" wrap="hard" id="biography" name="biography" class="col-12 mt-1" placeholder="Quelques mots sur vous, votre parcous, vos inspirations"><?= $biography ?></textarea>
        </div>
        <div class="form-group">
            <label class="text-light" for="instruments"><i class="fas fa-drum"></i><b> Instrument(s) :</b></label>
            <span class="text-dange float-right"></span>
            <input maxlength="250" id="instruments" class="col-12" name="instruments" type="text" value="<?= $instruments ?>">
        </div>
        <div class="form-group">
            <label class="text-light" for="software"><i class="fas fa-compact-disc"></i><b> Logiciel :</b></label>
            <span class="text-danger float-right"><?= $errors['software'] ?? '' ?></span>
            <select class="form-control col-12" name="software" id="software">
                <?php if (isset($_POST['software'])) { ?>
                    <option value="<?= $software ?>" selected><?= $_POST['software'] ?></option>
                <?php } else { ?>
                    <option value="" selected disabled>Sélectionner</option>
                <?php } ?>
                <option value="Aucun">Aucun</option>
                <option value="Ableton Live">Ableton Live</option>
                <option value="FL Studio">FL Studio</option>
                <option value="Logic Pro X">Logic Pro X</option>
                <option value="Garageband">Garageband</option>
                <option value="Avid Pro Tools">Avid Pro Tools</option>
                <option value="Steinberg Cubase">Steinberg Cubase</option>
                <option value="Cockos Reaper">Cockos Reaper</option>
                <option value="PreSonus Studio">PreSonus Studio</option>
                <option value="Acid Pro">Acid Pro</option>
                <option value="Propellerhead Reason">Propellerhead Reason</option>
                <option value="Autre">Autre</option>
            </select>
            <input maxlength="50" id="otherSoftware" class="col-12 inputColor" name="softwares" type="text"
                   value="<?= $software ?>" placeholder="Veuillez préciser">
        </div>
        <div class="form-group">
            <label class="text-light" for="tag1"><i class="fas fa-music"></i><b> Styles préférés (1 à 5) :</b></label>
            <span class="text-danger float-right"><?= $errors['tagOne'] ?? '' ?></span>
            <div>
                <div class="row">
                <?php for ($i = 0; $i < 5; $i++): ?>
                <select class="form-control col-2 mr-auto ml-auto" id="<?= $i ?>" name="tag<?= $i ?>" id="tag<?= $i ?>">
                    <option value="" selected disabled>Sélectionner</option>
                    <option value="Afro">Afro</option>
                    <option value="Blues">Blues</option>
                    <option value="Classique">Classique</option>
                    <option value="Disco">Disco</option>
                    <option value="Electro">Electro</option>
                    <option value="Funk">Funk</option>
                    <option value="Gospe">Gospel</option>
                    <option value="Kompa">Kompa</option>
                    <option value="Metal">Metal</option>
                    <option value="Pop">Pop</option>
                    <option value="Punk">Punk</option>
                    <option value="Raï">Raï</option>
                    <option value="Rap">Rap</option>
                    <option value="Reggae">Reggae</option>
                    <option value="R'n'B">R'n'B</option>
                    <option value="Rock">Rock</option>
                </select>
                <?php endfor; ?>
                </div>
            </div>
            <div class="form-group mt-1">
                <label class="text-light" for="facebookId"><i class="fab fa-facebook-square"></i><b> Url profil Facebook :</b></label>
                <span class="text-danger float-right"><?= $errors['facebookId'] ?? '' ?></span>
                <input maxlength="70" name="facebookId" id="facebookId" class="col-12" type="text"
                       value="<?= $facebook ?>">
            </div>
            <div class="form-group">
                <label class="text-light" for="twitterId"><i class="fab fa-twitter-square"></i><b> Url profil Twitter :</b></label>
                <span class="text-danger float-right"><?= $errors['twitterId'] ?? '' ?></span>
                <input maxlength="70" name="twitterId" id="twitterId" class="col-12" type="text"
                       value="<?= $twitter ?>">
            </div>
        </div>
        <div class="captcha">
            <div
                class="g-recaptcha"
                data-sitekey="6Lf-Dd8UAAAAAB6ROCZ8e2TWVp3-2PBzzz34y67X"
                style="display: inline-block;">
            </div>
        </div>
        <div class="row">
            <a href="accueil.php" class="btn btn-outline-secondary col-5 text-center ml-auto mr-auto">Ignorer pour le moment</a>
            <button id="submitSuscribeCompositor" name="submitSuscribeCompositor" class="btn btn-outline-success col-5 text-center ml-auto mr-auto" type="submit">Valider mes informations</button>
        </div>
    </form>
</div>
<div class="container" id="particularItems">
    <div id="styles" class="bg-secondary">
        <form action="#" method="post" novalidate>
            <label class="text-light" for="tagsParticular"><i class="fas fa-music"></i> Styles préférés :</label>
            <select class="form-control" name="tags" id="tagsParticular">
                <option value="Afro">Afro</option>
                <option value="Blues">Blues</option>
                <option value="Classique">Classique</option>
                <option value="Disco">Disco</option>
                <option value="Electro">Electro</option>
                <option value="Funk">Funk</option>
                <option value="Gospe">Gospel</option>
                <option value="Kompa">Kompa</option>
                <option value="Metal">Metal</option>
                <option value="Pop">Pop</option>
                <option value="Punk">Punk</option>
                <option value="Raï">Raï</option>
                <option value="Rap">Rap</option>
                <option value="Reggae">Reggae</option>
                <option value="R'n'B">R'n'B</option>
                <option value="Rock">Rock</option>
            </select>
        </form>
    </div>
    <div class="captcha">
        <div
            class="g-recaptcha"
            data-sitekey="6Lf-Dd8UAAAAAB6ROCZ8e2TWVp3-2PBzzz34y67X"
            style="display: inline-block;">
        </div>
    </div>
    <div class="row">
        <a href="accueil.php" class="btn btn-outline-secondary col-5 text-center ml-auto mr-auto">Ignorer pour le moment</a>
        <input value="Valider mes informations" name="submitSuscribeParticular" id="submitSuscribeParticular" class="btn btn-outline-success col-5 text-center ml-auto mr-auto" type="submit">
    </div>
</div>
<?php require_once 'require/footer.php'; ?>
<script src="https://www.google.com/recaptcha/api.js" async defer></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script src="../vendor/mervick/emojionearea/dist/emojionearea.min.js"></script>
<script src="../assets/js/suscribe_min.js"></script>
</body>
</html>