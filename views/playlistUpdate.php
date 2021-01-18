<?php
require_once '../controllers/form_validation.php';
require_once '../models/sqlplaylistUpdate.php';
require_once 'require/header.php';
//On avertit l'utilisateur si l'update s'est mal passé
echo $anErrorOccured ?? '';
?>
<div class="row">
    <h1 class="text-center bg-light col-10 opacity mt-3 ml-auto mr-auto">Changer le titre de la playlist | <?= $playlistTitle ?> :</h1>
</div>
<div class="container">
    <form action="#" method="post" novalidate>
        <div class="form-group">
            <label class="text-light" for="originalTitle">Titre d'origine</label>
            <input name="originalTitle" id="originalTitle" class="col-12" type="text" value="<?= $playlistTitle ?>" maxlength="50" disabled>
        </div>
        <div class="form-group">
            <label class="text-light" for="playlistNewTitle">Nouveau titre :</label>
            <span class="text-danger float-right"><?= $errors['playlistNewTitle'] ?? '' ?></span>
            <input name="playlistNewTitle" id="playlistNewTitle" class="col-12" type="text" placeholder="Veuillez saisir le nouvea titre de la playlist" value="<?= $playlistNewTitle ?>" maxlength="50" required>
        </div>
        <div class="captcha">
            <div
                class="g-recaptcha"
                data-sitekey="6Lf-Dd8UAAAAAB6ROCZ8e2TWVp3-2PBzzz34y67X"
                style="display: inline-block;">
            </div>
        </div>
        <div class="form-group">
            <input class="btn btn-outline-success col-12" name="playlistTitleChange" id="playlistTitleChange" type="submit" value="Changer le titre de la playlist">
        </div>
    </form>
</div>
<?php require_once 'require/footer.php'; ?>
<script src="https://www.google.com/recaptcha/api.js" async defer></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script src="../vendor/mervick/emojionearea/dist/emojionearea.min.js"></script>
<script src="../assets/js/playlistUpdate_min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"
        integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1"
        crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"
        integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM"
        crossorigin="anonymous"></script>
</body>
</html>
