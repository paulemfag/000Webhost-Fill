<?php
$title = 'Fill | Nouvelle playlist';
require_once 'require/header.php';
require_once '../controllers/form_validation.php';
echo $creationStatus ?? '';
?>
<div class="row">
    <h1 class="text-center bg-light col-10 opacity mt-2 ml-auto mr-auto">Nouvelle Playlist :</h1>
</div>
<form class="container" action="#" method="post" novalidate>
    <div class="form-group">
        <label class="text-light" for="playlistName">Nom de la playlist :</label>
        <span class="text-danger float-right"><?= $errors['playlistName'] ?? '' ?></span>
        <input class="col-12" id="playlistName" name="playlistName" type="text" value="<?= $playlistName ?>" maxlength="50" required>
    </div>
    <div class="captcha">
        <div
            class="g-recaptcha"
            data-sitekey="6Lf-Dd8UAAAAAB6ROCZ8e2TWVp3-2PBzzz34y67X"
            style="display: inline-block;">
        </div>
    </div>
    <input name="submitPlaylist" value="Créer la playlist" class="btn btn-outline-success col-12" type="submit">
</form>
<?php require_once 'require/footer.php'; ?>
<script src="https://www.google.com/recaptcha/api.js" async defer></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script src="../vendor/mervick/emojionearea/dist/emojionearea.min.js"></script>
<script src="../assets/js/newplaylist_min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"
        integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1"
        crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"
        integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM"
        crossorigin="anonymous"></script>
</body>
</html>
