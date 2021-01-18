<?php
session_start();
$title = $_SESSION['pseudo'] .'| Mise à jour des informations personnelles';
require_once 'require/header.php';
require_once '../controllers/form_validation.php';
require_once '../models/sqlpersonalInformationsUpdate.php';
?>
<div class="row">
    <h1 class="text-center bg-light col-10 opacity mt-2 ml-auto mr-auto"><?= $_SESSION['pseudo'] ?> | Mise à jour des informations personnelles :</h1>
</div>
<?php // Checks if form has been submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    function post_captcha($user_response) {
        $fields_string = '';
        $fields = array(
            'secret' => '_______________PRIVATE_KEY_______________',
            'response' => $user_response
        );
        foreach($fields as $key=>$value)
            $fields_string .= $key . '=' . $value . '&';
        $fields_string = rtrim($fields_string, '&');

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, 'https://www.google.com/recaptcha/api/siteverify');
        curl_setopt($ch, CURLOPT_POST, count($fields));
        curl_setopt($ch, CURLOPT_POSTFIELDS, $fields_string);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, True);

        $result = curl_exec($ch);
        curl_close($ch);

        return json_decode($result, true);
    }

    // Call the function post_captcha
    $res = post_captcha($_POST['g-recaptcha-response']);

    if (!$res['success']) {
        // What happens when the CAPTCHA wasn't checked
        echo '<p>Please go back and make sure you check the security CAPTCHA box.</p><br>';
    } else {
        // If CAPTCHA is successfully completed...

        // Paste mail function or whatever else you want to happen here!
        echo '<br><p>CAPTCHA was completed successfully!</p><br>';
    }
} else { ?>

    <!-- FORM GOES HERE -->
    <form></form>

<?php } ?>
<div class="container">
    <form action="#" method="post" novalidate>
        <div class="form-group">
            <label class="text-light" for="biography"><i class="fas fa-address-card"></i> <b>Biographie :</b></label>
            <span class="float-right text-danger"></span>
            <textarea maxlength="250" style="resize: none;" cols="121" rows="4" name="biography" id="biography"><?= $biography ?? $biographyInDb ?></textarea>
        </div>
        <div class="form-group">
            <label class="text-light" for="instruments"><i class="fas fa-drum"></i> <b>Instruments :</b></label>
            <span class="float-right text-danger"></span>
            <input maxlength="250" class="col-12" name="instruments" id="instruments" type="text" value="<?= $instruments ?? $instrumentsInDb ?>">
        </div>
        <div class="form-group">
            <label class="text-light" for="software"><i class="fas fa-compact-disc"></i> <b>Logiciel :</b></label>
            <span class="float-right text-danger"></span>
            <input maxlength="50" class="col-12" name="software" id="software" type="text" value="<?= $software ?? $softwareInDb ?>">
        </div>
        <div class="form-group">
            <label class="text-light" for="facebookId"><i class="fab fa-facebook-square"></i><b> Url profil Facebook :</b></label>
            <span class="float-right text-danger"><?= $errors['facebookId'] ?? '' ?></span>
            <input maxlength="70" class="col-12" name="facebookId" id="facebookId" type="text" value="<?= $facebook ?? $facebookIdInDb ?>">
        </div>
        <div class="form-group">
            <label class="text-light" for="twitterId"><i class="fab fa-twitter-square"></i><b> Url profil Twitter :</b></label>
            <span class="float-right text-danger"><?= $errors['twitterId'] ?? '' ?></span>
            <input maxlength="70" class="col-12" name="twitterId" id="twitterId" type="text" value="<?= $twitter ?? $twitterIdInDb ?>">
        </div>
        <div class="captcha">
            <label for="googleCaptch"></label>
            <div
                class="g-recaptcha"
                id="googleCaptch"
                name="googleCaptch"
                data-sitekey="6Lf-Dd8UAAAAAB6ROCZ8e2TWVp3-2PBzzz34y67X"
                style="display: inline-block;">
            </div>
        </div>
        <div class="form-group">
            <input class="btn btn-outline-success col-12" name="updatePersonalInformations" id="updatePersonalInformations" type="submit" value="Modifier mes informations personnelles">
        </div>
    </form>
</div>
<?php require_once 'require/footer.php'?>
<script src="https://www.google.com/recaptcha/api.js" async defer></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script src="../vendor/mervick/emojionearea/dist/emojionearea.min.js"></script>
<script src="../assets/js/personalInformationsUpdate_min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"
        integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1"
        crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"
        integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM"
        crossorigin="anonymous"></script>
</body>
</html>

