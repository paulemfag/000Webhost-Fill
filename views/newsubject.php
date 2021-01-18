<?php
$title = 'Fill | Nouveau Sujet';
require_once 'require/header.php';
require_once '../controllers/form_validation.php';
?>
<div class="container bg-light mt-2 opacity">
    <a title="Fill | Forum" href="forum.php?page=1"><i class="mt-2 fas fa-home"></i></a>
    <h1 class="text-center ml-auto mr-auto">Nouveau Sujet :</h1>
</div>
<form class="container mt-1" action="#" method="post" novalidate>
    <div class="form-group">
        <label class="text-light" for="subject">Sujet :</label>
        <span class="text-danger float-right"><?= $errors['subject'] ?? '' ?></span>
        <input minlength="4" maxlength="50" id="subject" name="subject" type="text" class="col-12" placeholder="Veuillez saisir un sujet" value="<?= $subject ?>" required>
    </div>
    <div class="form-group">
        <label class="text-light" for="message">Premier message :</label>
        <span class="text-danger float-right"><?= $errors['message'] ?? '' ?></span>
        <textarea style="resize: none; border: none;" minlength="4" maxlength="500" name="message" id="message" cols="121" rows="5" placeholder="Veuillez saisir un message" required><?= $message ?></textarea>
    </div>
    <div class="captcha">
        <div
            class="g-recaptcha"
            data-sitekey="6Lf-Dd8UAAAAAB6ROCZ8e2TWVp3-2PBzzz34y67X"
            style="display: inline-block;">
        </div>
    </div>
    <div class="form-group">
        <input name="submitsubject" class="btn btn-outline-success col-12 text-center mt-1" value="Créer le Sujet"
                type="submit">
    </div>
</form>
<?php require_once 'require/footer.php'; ?>
<script src="https://www.google.com/recaptcha/api.js" async defer></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script src="../vendor/mervick/emojionearea/dist/emojionearea.min.js"></script>
<script src="../assets/js/newsubject_min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"
        integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1"
        crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"
        integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM"
        crossorigin="anonymous"></script>
</body>
</html>
