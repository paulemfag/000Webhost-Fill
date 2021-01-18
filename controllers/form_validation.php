<?php
//requiert le fichier contenant le tableau contenant les insultes à filtrer.
require_once 'profanity.php';
//initialisations variables vides
//formulaire inscription
$accounttype = $_POST['typeOfAccount'] ?? NULL;
$suscribepseudo = $_POST['suscribepseudo'] ?? NULL;
$suscribemailbox = $_POST['suscribemailbox'] ?? NULL;
$suscribepassword = $_POST['suscribepassword'] ?? NULL;
$suscribepasswordconfirmation = $_POST['suscribepasswordconfirmation'] ?? NULL;
//formulaire login
$pseudo = $_POST['pseudo'] ?? NULL;
$password = $_POST['password'] ?? NULL;
//formulaire informations personnelles
$biography = $_POST['biography'] ?? NULL;
$instruments = $_POST['instruments'] ?? NULL;
$software = $_POST['software'] ?? $_POST['otherSoftware'] ?? NULL;
$tagOne = $_POST['tag0'] ?? NULL;
$tagTwo = $_POST['tag1'] ?? NULL;
$tagThree = $_POST['tag2'] ?? NULL;
$tagFour = $_POST['tag3'] ?? NULL;
$tagFive = $_POST['tag4'] ?? NULL;
$facebook = $_POST['facebookId'] ?? NULL;
$twitter = $_POST['twitterId'] ?? NULL;
//création de playlist
$playlistName = $_POST['playlistName'] ?? NULL;
//formumaire changement du titre de la playlist
$playlistNewTitle = $_POST['playlistNewTitle'] ?? NULL;
//Ajout d'une composition
$compositionStyle = $_POST['compositionStyle'] ?? NULL;
$compositionChords = trim(filter_input(INPUT_POST, 'chords', FILTER_SANITIZE_STRING)) ?? NULL;
$compositionInstruments = trim(filter_input(INPUT_POST, 'instruments', FILTER_SANITIZE_STRING)) ?? NULL;
//formulaire nouveau sujet Forum et ajout de message sur un topic
$subject = trim(filter_input(INPUT_POST, 'subject', FILTER_SANITIZE_STRING)) ?? NULL;
$message = trim(filter_input(INPUT_POST, 'message', FILTER_SANITIZE_STRING)) ?? NULL;
//formulaire récupération mot de passe
$recuperationMailbox = $_POST['recuperationMailbox'] ?? NULL;
//formulaire ajout de commentaire
$comment = $_POST['comment'] ?? NULL;
//formulaire envoi de message
//Si on viens de la page message et qu'on répond à un message.
if((filter_input(INPUT_GET, 'object', FILTER_SANITIZE_STRING))){
    $getObject = 'Re : ' .$_GET['object'];
}
$objet = $_POST['objet'] ?? $getObject ??  NULL;
$message = $_POST['message'] ?? NULL;
//formulaire reset password
$passwordAfterReset = $_POST['passwordAfterReset'] ?? NULL;
$confirmPasswordAfterReset = $_POST['confirmPasswordAfterReset'] ?? NULL;
//formulaire changement du type de compte
$changeAccountPassword = $_POST['changeAccountPassword'] ?? NULL;
//formulaire changement de mot de passe
$actualPassword = $_POST['actualPassword'] ?? NULL;
$newPassword = $_POST['newPassword'] ?? NULL;
$newPasswordConfirm = $_POST['newPasswordConfirm'] ?? NULL;
//formulaire supperession du compte
$removeMyAccountPassword = $_POST['Password'] ?? NULL;
//regex pour le contrôle des formulaires
$regexPseudo = "/^[A-Za-zéÉ][A-Za-záàâäãåçéèêëíìîïñóòôöõúùûüýÿæœ]+((-| )[A-Za-záàâäãåçéèêëíìîïñóòôöõúùûüýÿæœ]+)?$/";
$regexFacebook = '/^(https?:\/\/)?(www\.)?facebook.com\/[a-zA-Z0-9(\.\?)?]/';
$regexTwitter = '/^(?:http(s?):\/\/)?(?:www\.)?twitter\.com\/(?:(?:\w)*#!\/)?(?:pages\/)?(?:[\w\-]*\/)*([\w\-]*)$/';
$regexStyle = '/^(Afro|Blues|Classique|Disco|Electro|Funk|Gospel|Kompa|Metal|Pop|Punk|Raï|Rap|Reggae|R\'n\'B|Rock|)$/';
//initialisation tableau d'erreurs vide
$errors = [];
//Vérifications formulaire d'inscription
if (isset($_POST['suscribe'])) {
    //ajoute une value au bouton m'inscrire pour le réafficher en js
    $suscribe = 'alreadySubmittedOnce';
    //contrôle pseudo
    $suscribepseudo = trim(filter_input(INPUT_POST, 'suscribepseudo', FILTER_SANITIZE_STRING));
    if (empty($suscribepseudo)) {
        $errors['suscribepseudo'] = '<i class="fas fa-exclamation-triangle"></i> Veuillez renseigner votre pseudo.';
    } elseif (!preg_match($regexPseudo, $suscribepseudo)) {
        $errors['suscribepseudo'] = '<i class="fas fa-exclamation-triangle"></i> Votre pseudo contient des caractères non autorisés !';
    } elseif (strlen($suscribepseudo) > 50){
        $errors['suscribepseudo'] = '<i class="fas fa-exclamation-triangle"></i> Votre pseudo est trop long.(Max 50)';
    }
    //contrôle adresse mail
    $suscribemailbox = trim(htmlspecialchars($_POST['suscribemailbox']));
    if (empty($suscribemailbox)) {
        $errors['suscribemailbox'] = '<i class="fas fa-exclamation-triangle"></i> Veuillez renseigner votre adresse mail.';
    } elseif (!filter_var($suscribemailbox, FILTER_VALIDATE_EMAIL)) {
        $errors['suscribemailbox'] = '<i class="fas fa-exclamation-triangle"></i> Veuillez saisir une adresse mail valide.';
    } elseif (strlen($suscribemailbox) > 50){
        $errors['suscribemailbox'] = '<i class="fas fa-exclamation-triangle"></i> Votre adresse mail est trop longue.(Max 50)';
    }
    //contrôle mots de passe
    if (empty($suscribepassword)) {
        $errors['suscribepassword'] = '<i class="fas fa-exclamation-triangle"></i> Veuillez renseigner votre mot de passe.';
    } elseif (strlen($suscribepassword) > 60){
        $errors['suscribepassword'] = '<i class="fas fa-exclamation-triangle"></i> Votre mot de passe est trop long.(Max 60)';
    } elseif (isset($suscribepassword) && empty($suscribepasswordconfirmation)) {
        $errors['suscribepassword'] = '<i class="fas fa-exclamation-triangle"></i> Veuillez confirmer votre mot de passe';
    } elseif ($suscribepasswordconfirmation != $suscribepassword) {
        $errors['suscribepassword'] = '<i class="fas fa-exclamation-triangle"></i> Les mots de passe ne correspondent pas.';
    }
    //Si il n'y a pas d'erreurs execute l'insertion dans la BDD
    if (count($errors) == 0) {
        require_once 'models/sqlsuscribe.php';
    }
}
//Vérifications formulaire de connexion
if (isset($_POST['login'])) {
    //ajoute une value au bouton me connecter
    $login = 'alreadySubmittedOnce';
    if (empty($pseudo)) {
        $errors['pseudo'] = '<i class="fas fa-exclamation-triangle"></i> Veuillez renseigner votre pseudo.';
    }
    if (strlen($pseudo) > 50){
        $errors['pseudo'] = '<i class="fas fa-exclamation-triangle"></i> Votre pseudo est trop long.(Max 50)';
    }
    if (empty($password)) {
        $errors['password'] = '<i class="fas fa-exclamation-triangle"></i> Veuillez renseigner votre mot de passe.';
    }
    if (strlen($password) > 60){
        $errors['password'] = '<i class="fas fa-exclamation-triangle"></i> Votre mot de passe est trop long. (Max 60)';
    }
    //Si il n'y a pas d'erreurs execute les vérifications en BDD et renvoi vers la page 'accueil.php'
    if (count($errors) == 0) {
        require_once 'models/sqllogin.php';
        $_POST['password'] = NULL;
        $pseudo = NULL;
    }
}
// Si la personne viens de la page 'activation.php' donne une valeur au bouton / affiche le formulaire de connexion (js)
if (isset($_GET['connectMe'])) {
    $login = 'alreadySubmittedOnce';
}
// Vérifications formulaire informations personnelles, page 'suscribe.php
if (isset($_POST['submitSuscribeCompositor'])) {
    //ajoute une value au bouton submit
    if (empty($software)){
        $errors['software'] = '<i class="fas fa-exclamation-triangle"></i> Veuillez sélectionner un logiciel.';
    }
    //Vérifie qu'il y ai au moins 1 style préféré
    if (empty($tagOne)) {
        $errors['tagOne'] = '<i class="fas fa-exclamation-triangle"></i> Veuillez sélectionner au moins un style.';
    }
    //Vérifie que la valeur du select soit bonne si elle est définie
    if (!empty($tagOne) && !preg_match($regexStyle, $tagOne)) {
        $errors['tagOne'] = '<i class="fas fa-exclamation-triangle"></i> Veuillez sélectionner un style correct.';
        echo 'test1';
    }
    if (!empty($tagTwo) && !preg_match($regexStyle, $tagTwo)) {
        $errors['tagOne'] = '<i class="fas fa-exclamation-triangle"></i> Veuillez sélectionner un style correct.';
        echo 'test';
    }
    if (!empty($tagThree) && !preg_match($regexStyle, $tagThree)) {
        $errors['tagOne'] = '<i class="fas fa-exclamation-triangle"></i> Veuillez sélectionner un style correct.';
    }
    if (!empty($tagFour) && !preg_match($regexStyle, $tagFour)) {
        $errors['tagOne'] = '<i class="fas fa-exclamation-triangle"></i> Veuillez sélectionner un style correct.';
    }
    if (!empty($tagFive) && !preg_match($regexStyle, $tagFive)) {
        $errors['tagOne'] = '<i class="fas fa-exclamation-triangle"></i> Veuillez choisir un style correct.';
    }
    //Vérifications qu'un tag ne soit pas en doublon
    /*if ($tagOne === $tagTwo || $tagOne === $tagThree || $tagOne === $tagFour || $tagOne === $tagFive || $tagTwo === $tagThree || $tagTwo === $tagFour || $tagTwo === $tagFive || $tagThree === $tagFour || $tagThree === $tagFive || $tagFour === $tagFive){
        $errors['tagOne'] = '<i class="fas fa-exclamation-triangle"></i> Veuillez sélectionner des styles différents les uns des autres';
    }*/
    //si le champ facebook est rempli et que l'url fourni n'est pas bon
    if (!empty($facebook) && !preg_match($regexFacebook, $facebook)) {
        $errors['facebookId'] = '<i class="fas fa-exclamation-triangle"></i> Veuillez saisir un url correct.';
    }
    //si le champ twitter est rempli et que l'url fourni n'est pas bon
    if (!empty($twitter) && !preg_match($regexTwitter, $twitter)) {
        $errors['twitterId'] = '<i class="fas fa-exclamation-triangle"></i> Veuillez saisir un url correct.';
    }
    //si le tableau d'erreurs est vide, requiert le fichier qui fait l'insertion en BDD
    if (count($errors) == 0){
        require_once '../models/sqlpersonalInformations.php';
    }
}
//Vérifications modifications des informations personnelles page personalInformationsUpdate.php
if (isset($_POST['updatePersonalInformations'])){
    //si le champ facebook est rempli et que l'url fourni n'est pas bon
    if (!empty($facebook) && !preg_match($regexFacebook, $facebook)) {
        $errors['facebookId'] = '<i class="fas fa-exclamation-triangle"></i> Veuillez saisir un url correct.';
    }
    //si le champ twitter est rempli et que l'url fourni n'est pas bon
    if (!empty($twitter) && !preg_match($regexTwitter, $twitter)) {
        $errors['twitterId'] = '<i class="fas fa-exclamation-triangle"></i> Veuillez saisir un url correct.';
    }
    /*    //Vérifications Recaptcha
        function post_captcha($user_response) {
            $fields_string = '';
            $fields = array(
                'secret' => '6Lc2seAUAAAAABg_R6mlOzQuKOkLNxYkyQiRLf7x',
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
        }}*/
    if (count($errors) == 0){
        $changePersonalInformations = true;
    }
}
//Vérifications nouvelle playlist
if (isset($_POST['submitPlaylist'])) {
    if (empty($playlistName)){
        $errors['playlistName'] = '<i class="fas fa-exclamation-triangle"></i> Veuillez saisir le titre de la playlist.';
    }
    elseif (strlen($playlistName) > 50){
        $errors['playlistName'] = '<i class="fas fa-exclamation-triangle"></i> Le titre est trop long.(Max 50)';
    }
    elseif (!filter_input(INPUT_POST, 'playlistName', FILTER_SANITIZE_STRING)) {
        $errors['playlistName'] = '<i class="fas fa-exclamation-triangle"></i> Veuillez saisir un titre valide.';
    }
    //si le tableau d'erreurs est vide, requiert le fichier qui fait l'update en BDD
    if (count($errors) == 0) {
        require_once '../models/sqlNewPlaylist.php';
    }
}
//vérifications changement du titre de la playlist
if (isset($_POST['playlistTitleChange'])){
    //si le nouveau titre de la playlist n'est pas défini
    if (empty($playlistNewTitle)){
        $errors['playlistNewTitle'] = '<i class="fas fa-exclamation-triangle"></i> Veuillez saisir le nouveau titre de la playlist.';
    }
    elseif (strlen($playlistNewTitle) > 50){
        $errors['playlistNewTitle'] = '<i class="fas fa-exclamation-triangle"></i> Le titre est trop long.(Max 50)';
    }
    elseif (!filter_input(INPUT_POST, 'playlistNewTitle', FILTER_SANITIZE_STRING)) {
        $errors['playlistNewTitle'] = '<i class="fas fa-exclamation-triangle"></i> Veuillez saisir un titre valide.';
    }
    //si il n'y a pas d'erreurs
    if (count($errors) === 0){
        //définie la variable changeTitle à 'true' pour permettre l'update en base dans le fichier sqlplaylistUpdate
        $changeTitle = true;
    }
}
//option sélectionné page 'ajouter une composition'
$styleOption = '<option value="-- Sélectionner --" selected disabled>-- Sélectionner --</option>';
//Vérifications page 'ajouter une composition'
if (isset($_POST['newComposition'])) {
    //Si le champ ajouter un fichier n'est pas vide
    if (isset($_FILES['file'])) {
        $file = $_FILES['file'];
        //Nom du fichier
        $fileName = $_FILES['file']['name'];
        //lieu de stockage temporaire du fichier
        $fileTmpName = $_FILES['file']['tmp_name'];
        //taille du fichier
        $fileSize = $_FILES['file']['size'];
        //erreur, retourne un int (https://www.php.net/manual/fr/features.file-upload.errors.php)
        $fileError = $_FILES['file']['error'];
        //type de fichier
        $fileType = $_FILES['file']['type'];
        $fileExt = explode('.', $fileName);
        $fileActualExt = strtolower(end($fileExt));
        //extensions autorisées
        $allowed = array('mp3', 'm4a', 'm4b', 'aac', 'aax', 'mpc');
        //si l'extension est bonne
        if (in_array($fileActualExt, $allowed)) {
            //si il n'y a pas derreurs
            if ($fileError === 0) {
                //si la taille du fichier est inférieure à 20000000 octets / 20 méga
                if ($fileSize < 20000000) {
                    //option de desination définie dans 'sqlfile.php'
                    $target_path = Settings::$uploadFolder;
                    $target_path = $target_path . '_' . basename($_FILES['file']['name']);
                    //si le fichié est correctement uploadé dans le dossier
                    if (move_uploaded_file($_FILES['file']['tmp_name'], $target_path)) {
                        $compositionAdded = '';
                    } else {
                        $compositionAdded = '<div class="alert alert-warning alert-dismissible fade show" role="alert">
  <p>Une erreur s\'est produite durant l\'upload du fichier "' . basename($_FILES['file']['name']) . '" merci de réessayer.</p>
  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
    <span aria-hidden="true">&times;</span>
  </button>
</div>';
                    }
                } else {
                    $errors['file'] = '<i class="fas fa-exclamation-triangle"></i> La taille de votre fichier est trop grande.';
                }
            } else {
                $errors['file'] = '<i class="fas fa-exclamation-triangle"></i> Une erreur s\'est produite durant l\'upload de votre fichier merci de réessayer.';
            }
        } else {
            $errors['file'] = '<i class="fas fa-exclamation-triangle"></i> Le format de votre fichier n\'est pas valide.';
        }
    }
    //Si le message de validation du fichier n'est pas défini
    if (!isset($compositionAdded)) {
        $errors['file'] = '<i class="fas fa-exclamation-triangle"></i> Veuillez ajouter un fichier.';
    }
    if (empty($compositionStyle)) {
        $errors['compositionStyle'] = '<i class="fas fa-exclamation-triangle"></i> Veuillez choisir le style musical de la composition.';
    }
    // Si on choisi un style dans le select
    if (isset($compositionStyle)) {
        $styleOption = '<option value="' . $_POST['compositionStyle'] . '" selected>' . $_POST['compositionStyle'] . '</option>';
        // si l'option choisi est 'Autre'
        if ($compositionStyle == 'Autre') {
            // si le champ autre est vide
            if (empty($_POST['otherChoice'])) {
                $errors['otherChoice'] = '<i class="fas fa-exclamation-triangle"></i> Veuillez préciser le style musical de la composition.';
            }
        }
    }
    if (strlen($compositionChords) > 200){
        $errors['chords'] = '<i class="fas fa-exclamation-triangle"></i> Vous avez renseigné trop de caractères.(Max 200)';
    }
    if (strlen($compositionInstruments) > 200){
        $errors['instruments'] = '<i class="fas fa-exclamation-triangle"></i> Vous avez renseigné trop de caractères.(Max 200)';
    }
    //Si il n'y a pas d'erreurs requiert le fichier 'sqladdcomposition.php' qui fait l'ajout en BDD
    if (count($errors) == 0) {
        require_once '../models/sqladdcomposition.php';
    }
}
//Vérifification nouveau sujet
if (isset($_POST['submitsubject'])) {
    //vérification sujet
    if (empty($subject)) {
        $errors['subject'] = '<i class="fas fa-exclamation-triangle"></i> Veuillez renseigner le sujet.';
    }
    elseif (strlen($subject) < 4){
        $errors['subject'] = '<i class="fas fa-exclamation-triangle"></i> Le nom du sujet est trop court.';
    }
    if (strlen($subject) > 50){
        $errors['subject'] = '<i class="fas fa-exclamation-triangle"></i> Le nom du sujet est trop long.';
    }
    if (!empty($subject)){
        //Requiert le fichier sql qui vérifie si le nom du sujet n'existe pas déjà dans la table topics.
        require_once 'sqlnewsubjectverification.php';
    }
    if (empty($message)) {
        $errors['message'] = '<i class="fas fa-exclamation-triangle"></i> Veuillez renseigner un message.';
    }
    elseif (strlen($message) < 4){
        $errors['message'] = '<i class="fas fa-exclamation-triangle"></i> Le message est trop court.';
    }
    if (strlen($message) > 500){
        $errors['message'] = '<i class="fas fa-exclamation-triangle"></i> Le message est trop long.';
    }
    elseif (count($errors) == 0) {
        require_once '../models/sqlnewsubject.php';
    }
}
if (isset($_POST['topicMessageSubmit'])){
    if (empty($message)){
        $errors['message'] = '<i class="fas fa-exclamation-triangle"></i> Veuillez saisir votre message.';
    }
    elseif (strlen($message) > 500){
        $errors['message'] = '<i class="fas fa-exclamation-triangle"></i> Le message est trop long.(Max 500)';
    }
    if (count($errors) == 0){
        //Si il n'y pas d'erreurs initialise la variable insertMessage à true pour permettre l'insert en BDD
        $insertMessage = true;
    }
}
//Vérifications RECUPERATION MOT DE PASSE
if (isset ($_POST['recuperation'])) {
    //ajoute une value au bouton
    $recuperation = 'alreadySubmittedOnce';
    //déclaration variable
    $recuperationMailbox = trim(htmlspecialchars($recuperationMailbox));
    if (empty($recuperationMailbox)) {
        $errors['recuperationMailbox'] = '<i class="fas fa-exclamation-triangle"></i> Veuillez renseigner votre adresse mail.';
    } elseif (strlen($recuperationMailbox) > 50){
        $errors['recuperationMailbox'] = '<i class="fas fa-exclamation-triangle"></i> Votre adresse mail est trop longue.(Max 50)';
    } elseif (!filter_var($recuperationMailbox, FILTER_VALIDATE_EMAIL)) {
        $errors['recuperationMailbox'] = '<i class="fas fa-exclamation-triangle"></i> Veuillez saisir une adresse mail valide.';
    } elseif (count($errors) == 0){
        require_once 'models/sqlrecuperation.php';
    }
}
//Formulaire ajout de commentaire
if (isset($_POST['submitComment'])){
    if (empty($comment)){
        $errors['comment'] = '<i class="fas fa-exclamation-triangle"></i> Veuillez saisir un commentaire.';
    }
    elseif (strlen($comment) > 500){
        $errors['comment'] = '<i class="fas fa-exclamation-triangle"></i> Votre commentaire est trop long.(Max 500)';
    }
    elseif (!filter_input(INPUT_POST, 'comment', FILTER_SANITIZE_STRING)){
        $errors['comment'] = '<i class="fas fa-exclamation-triangle"></i> Votre commentaire contient des caractères non valides.';
    }
    $comment = htmlspecialchars($comment);
    //Récupération de la taille du commentaire
    $commentLength = strlen($comment);
    //Si le commentaire est trop long
    if (($commentLength) > 500){
        $errors['comment'] = '<i class="fas fa-exclamation-triangle"></i> Votre commentaire est trop long (Max 500)';
    }
    if (count($errors) == 0){
        require_once '../models/sqladdComment.php';
    }
}
//Formulaire envoi de message
if (isset($_POST['submitMessage'])){
    //Vérifications champ pseudo.
    if (empty($pseudo)){
        $errors['pseudo'] = '<i class="fas fa-exclamation-triangle"></i> Veuillez renseigner le pseudo du destinataire.';
    }
    elseif (strlen($pseudo) > 50){
        $errors['pseudo'] = '<i class="fas fa-exclamation-triangle"></i> Le pseudo est trop long (Max 50)';
    }
    elseif (!filter_input(INPUT_POST, 'pseudo', FILTER_SANITIZE_STRING)){
        $errors['pseudo'] = '<i class="fas fa-exclamation-triangle"></i> Le pseudo contient des caractères non valides.';
    }
    //Vérifications champ objet.
    if (empty($objet)){
        $errors['objet'] = '<i class="fas fa-exclamation-triangle"></i> Veuillez renseigner l\'objet du message.';
    }
    elseif (strlen($objet) > 20){
        $errors['objet'] = '<i class="fas fa-exclamation-triangle"></i> L\'objet est trop long (Max 20)';
    }
    elseif (!filter_input(INPUT_POST, 'objet', FILTER_SANITIZE_STRING)){
        $errors['objet'] = '<i class="fas fa-exclamation-triangle"></i> L\'objet contient des caractères non valides.';
    }
    //Vérifications champ message.
    if (empty($message)){
        $errors['message'] = '<i class="fas fa-exclamation-triangle"></i> Veuillez renseigner votre message.';
    }
    elseif (strlen($message) > 500){
        $errors['message'] = '<i class="fas fa-exclamation-triangle"></i> Le pseudo est trop long (Max 500)';
    }
    elseif (!filter_input(INPUT_POST, 'message', FILTER_SANITIZE_STRING)){
        $errors['message'] = '<i class="fas fa-exclamation-triangle"></i> Le message contient des caractères non valides.';
    }
    if (count($errors) === 0){
        require_once '../models/sqlnewmessage.php';
    }
}
//Formulaire reset mot de passe après récupération
if (isset($_POST['resetMyPassword'])){
    if (empty($passwordAfterReset)){
        $errors['passwordAfterReset'] = '<i class="fas fa-exclamation-triangle"></i> Veuillez renseigner votre nouveau mot de passe';
    }
    elseif (empty($confirmPasswordAfterReset)){
        $errors['confirmPasswordAfterReset'] = '<i class="fas fa-exclamation-triangle"></i> Veuillez confirmer votre nouveau mot de passe';
    }
    elseif($passwordAfterReset !== $confirmPasswordAfterReset){
        $errors['passwordAfterReset'] = '<i class="fas fa-exclamation-triangle"></i> Les mots de passe ne correspondent pas.';
        $errors['confirmPasswordAfterReset'] = '<i class="fas fa-exclamation-triangle"></i> Les mots de passe ne correspondent pas.';
    }
    elseif (count($errors) == 0) {
        require_once '../models/sqlreset-password.php';
    }
}
//Vérifications CHANGEMENT MOT DE PASSE
if (isset ($_POST['changeMyPassword'])) {
    //ajoute une value au bouton me connecter
    $changeMyPassword = 'alreadySubmittedOnce';
    if (empty($actualPassword)) {
        $errors['actualPassword'] = '<i class="fas fa-exclamation-triangle"></i> Veuillez saisir votre mot de passe.';
    }
    elseif (strlen($actualPassword) > 60){
        $errors['actualPassword'] = '<i class="fas fa-exclamation-triangle"></i> Votre mot de passe est trop long.(Max 60)';
    }
    elseif (empty ($newPassword)) {
        $errors['newPassword'] = '<i class="fas fa-exclamation-triangle"></i> Veuillez choisir un nouveau mot de passe.';
    }
    elseif ($actualPassword == $newPassword) {
        $errors['newPassword'] = '<i class="fas fa-exclamation-triangle"></i> Le nouveau mot de passe et l\'ancien ne peuvent être identiques';
    }
    elseif (strlen($newPassword) > 60){
        $errors['newPassword'] = '<i class="fas fa-exclamation-triangle"></i> Votre mot de passe est trop long.(Max 60)';
    }
    elseif (empty ($newPasswordConfirm)) {
        $errors['newPasswordConfirm'] = '<i class="fas fa-exclamation-triangle"></i> Veuillez confirmer votre nouveau mot de passe.';
    }
    elseif ($newPassword != $newPasswordConfirm) {
        $errors['newPassword'] = '<i class="fas fa-exclamation-triangle"></i> Les mots de passes ne correspondent pas.';
        $errors['newPasswordConfirm'] = '<i class="fas fa-exclamation-triangle"></i> Les mots de passes ne correspondent pas.';
    }
    elseif (count($errors) == 0) {
        require_once '../models/updatePassword.php';
        $errors['isok'] = 'Votre mot de passe à bien été changé.';
    }
}
//Vérification changement du type de compte
if (isset($_POST['changeAccountType'])) {
    //ajoute une valeur au bouton pour réafficher le formulaire grâce au JS
    $changeAccount = 'alreadySubmittedOnce';
    //vérification champ mot de passe
    if (!isset($changeAccountPassword)) {
        $errors['changeAccountPassword'] = '<i class="fas fa-exclamation-triangle"></i> Veuillez renseigner votre mot de passe.';
    }
    elseif (strlen($changeAccountPassword) > 60){
        $errors['changeAccountPassword'] = '<i class="fas fa-exclamation-triangle"></i> Votre mot de passe est trop long.(Max 60)';
    }
    //Si il n'y a pas d'erreurs requiert le fichier "parameterspage.php" qui compare le mot de passe de la BDD
    elseif (count($errors) == 0) {
        require_once '../models/parameterspage.php';
    }
}
//Vérifications suppression du compte
if (isset($_POST['removeMyAccount'])) {
    //ajoute une value au bouton me connecter
    $removeMyAccount = 'alreadySubmittedOnce';
    if (empty($removeMyAccountPassword)) {
        $errors['Password'] = '<i class="fas fa-exclamation-triangle"></i> Veuillez renseigner un mot de passe.';
    }
    elseif (strlen($removeMyAccountPassword) > 60){
        $errors['Password'] = '<i class="fas fa-exclamation-triangle"></i> Votre mot de passe est trop long.(Max 60)';
    }
    elseif (count($errors) == 0) {
        require_once '../models/sqldeleteaccount.php';
    }
}