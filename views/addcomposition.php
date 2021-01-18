<?php
$title = 'Fill | Ajout Composition';
require_once 'require/header.php';
//Si l'utilisateur est un particulier et qu'il n'est pas administrateur.
if($_SESSION['accounttype'] === 'particular' && $_SESSION['role'] === '0'){
    header('location:accueil.php');
    /*exit();*/
}
require_once '../models/sqlfile.php';
require_once '../controllers/form_validation.php';
?>
<div class="row">
    <h1 class="text-center bg-light col-10 opacity mt-2 ml-auto mr-auto">Ajouter une composition :</h1>
</div>
<form class="container" method="post" action="#" novalidate enctype="multipart/form-data">
    <div class="form-group">
        <label class="text-light float-left" for="fileInput">Veuillez ajouter un fichier ( format mp3, m4a, m4b, aac, aax, mpc) :</label>
        <span class="text-danger float-right"><?= $errors['file'] ?? '' ?></span>
        <input id="fileInput" class="bg-light col-12" type="file" name="file" accept="audio/*">
    </div>
    <div class="form-group">
        <p class="text-light col-12"><i>Le titre du fichier mp3 sera pris comme titre officiel.</i></p>
    </div>
    <div class="form-group">
        <label class="text-light" for="compositionStyle"><i class="fas fa-music"></i> Style musical :</label>
        <span class="float-right text-danger"><?= $errors['compositionStyle'] ?? '' ?></span>
        <select class="col-12" name="compositionStyle" id="compositionStyle">
            <?= $styleOption ?>
            <option value="Afro">Afro</option>
            <option value="Blues">Blues</option>
            <option value="Classique">Classique</option>
            <option value="Disco">Disco</option>
            <option value="Electro">Electro</option>
            <option value="Funk">Funk</option>
            <option value="Gospel">Gospel</option>
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
    </div>
    <div class="form-group">
        <label class="text-light" for="instruments"><i class="fas fa-drum"></i> Instrument(s) employé(s) : ( facultatif )</label>
        <span class="text-danger float-right"><?= $errors['instruments'] ?? '' ?></span>
        <input id="instruments" class="col-12 inputColor" name="instruments" type="text" value="<?= $_POST['instruments'] ?? '' ?>" maxlength="200" required>
    </div>
    <div class="form-group">
        <label class="text-light" for="chords">Accords employés : ( facultatif )</label>
        <span class="text-danger float-right"><?= $errors['chords'] ?? '' ?></span>
        <input id="chords" class="col-12 inputColor" name="chords" type="text" value="<?= $_POST['chords'] ?? '' ?>" maxlength="200" required>
    </div>
    <div class="captcha">
        <div
            class="g-recaptcha"
            data-sitekey="6Lf-Dd8UAAAAAB6ROCZ8e2TWVp3-2PBzzz34y67X"
            style="display: inline-block;">
        </div>
    </div>
    <div class="form-group">
        <button id="newComposition" name="newComposition" value="<?= $isOk ?? '' ?>" class="btn btn-success col-12" type="submit"><i class="fas fa-cloud-upload-alt"></i> Ajouter la composition</button>
    </div>
</form>
<?php require_once 'require/footer.php'; ?>
<script src="https://www.google.com/recaptcha/api.js" async defer></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"
        integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1"
        crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"
        integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM"
        crossorigin="anonymous"></script>
</body>
</html>
