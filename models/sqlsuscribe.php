<?php
require_once 'sqlparameters.php';
$Url = "https://www.google.com/recaptcha/api/siteverify";
$SecretKey = "----Secret Key----";
$Response = file_get_contents($Url."?secret=".$SecretKey."&response=".$_POST['Response']);
$Robot = json_decode($Response);
// récupération des valeurs du formulaire dans des variables
$pseudo = $_POST['suscribepseudo'];
$mailbox = $_POST['suscribemailbox'];
$password = password_hash($_POST['suscribepassword'], PASSWORD_DEFAULT);
$accountType = $_POST['typeOfAccount'];
//Vérification si le pseudo existe déjà en base.
try {
    $sth = $db->prepare('SELECT `pseudo` FROM `users` WHERE `pseudo` = :pseudo');
    $sth->bindValue(':pseudo', $pseudo, PDO::PARAM_STR);
    $sth->execute();
    $pseudoInDb = $sth->fetch();
    if ($pseudoInDb){
        $errors['suscribepseudo'] = '<i class="fas fa-exclamation-triangle"></i> Un compte est déjà enregistré avec ce pseudo ou cette adresse mail.';
        $errors['suscribemailbox'] = '<i class="fas fa-exclamation-triangle"></i> Un compte est déjà enregistré avec ce pseudo ou cette adresse mail.';
        //Variable permettant de réafficher le formulaire.
        $suscribe = 'alreadySubmittedOnce';
        $suscribeStatus = NULL;
    }
    else{
        $suscribeStatus = 'ok';
    }
} catch (Exception $ex) {
    die('Connexion échoué');
}
//Vérification si l'adresse mail existe déjà en base.
try {
    $sth = $db->prepare('SELECT `mailBox` FROM `users` WHERE `mailBox` = :mailbox');
    $sth->bindValue(':mailbox', $mailbox, PDO::PARAM_STR);
    $sth->execute();
    $mailInDb = $sth->fetch();
    if ($mailInDb){
        $errors['suscribepseudo'] = '<i class="fas fa-exclamation-triangle"></i> Un compte est déjà enregistré avec ce pseudo ou cette adresse mail.';
        $errors['suscribemailbox'] = '<i class="fas fa-exclamation-triangle"></i> Un compte est déjà enregistré avec ce pseudo ou cette adresse mail.';
        //Variable permettant de réafficher le formulaire.
        $suscribe = 'alreadySubmittedOnce';
        $suscribeStatus = NULL;
    }
    else{
        $suscribeStatus = 'ok';
    }
} catch (Exception $ex) {
    die('Connexion échoué');
}
//Si l'adresse mail et le pseudo n'existent pas en base, définit la variable suscribeStatus à true pour permettre l'insertion en BDD...
if ($suscribeStatus) {
    try {
        // insertion dans la base de donnée
        $sth = $db->prepare('INSERT INTO `users` (pseudo, mailbox, password, accounttype)
VALUES (:pseudo, :mailbox, :password, :accountType)');
        $sth->bindValue(':pseudo', $pseudo, PDO::PARAM_STR);
        $sth->bindValue(':mailbox', $mailbox, PDO::PARAM_STR);
        $sth->bindValue(':password', $password, PDO::PARAM_STR);
        $sth->bindValue(':accountType', $accountType, PDO::PARAM_STR);
        $sth->execute();
        //Fichier vérifiant le type d'adresse mail
        require_once 'controllers/mailboxhost.php';
        // si l'extension mail match avec une des regex le text mail est un href redirigeant vers la boite mail correspondante
        if (isset($mailhref)) {
            $activeYourAccount = '
<div class="alert alert-success alert-dismissible fade show" role="alert">
    <p>Votre compte a bien été créé, pour finaliser votre inscription merci de valider votre boite mail à l\'aide de <a href="' . $mailhref . '" target="_blank" class="alert-link">l\'email</a> d\'activation qui viens de vous être envoyé.</p>
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
    <span aria-hidden="true">&times;</span>
  </button>
</div>';
        } //sinon
        else {
            $activeYourAccount = '
<div class="alert alert-success alert-dismissible fade show" role="alert">
  <p>Votre compte a bien été créé, pour finaliser votre inscription merci de valider votre boite mail à l\'aide de l\'email d\'activation qui viens de vous être envoyé.</p>
  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
    <span aria-hidden="true">&times;</span>
  </button>
</div>';
        }
        //vidage des champs du formulaire
        $suscribepseudo = $suscribemailbox = $suscribepassword = $suscribepasswordconfirmation = $accountType = '';
    } catch (PDOException $e) {
        echo "Erreur : " . $e->getMessage();
    }

// Génération aléatoire d'une clé
    $key = md5(microtime(TRUE) * 100000);

// Insertion de la clé dans la base de données
    try {
        $stmt = $db->prepare('UPDATE `users` SET activationkey = :cle WHERE pseudo = :pseudo');
        $stmt->bindValue(':cle', $key, PDO::PARAM_STR);
        $stmt->bindValue(':pseudo', $pseudo, PDO::PARAM_STR);
        $stmt->execute();
    } catch (PDOException $e) {
        echo "Erreur : " . $e->getMessage();
    }
//récupération du fichier requis
    require_once 'vendor/autoload.php';
    $messageToSend = 'Bienvenue sur Fill ' . $pseudo . ',
 
Pour activer votre compte, veuillez cliquer sur le lien ci-dessous
ou le copier/coller dans votre navigateur Internet.
 
https://filldemo.000webhostapp.com/views/activation.php?log=' . urlencode($pseudo) . '&cle=' . urlencode($key) . '
 
Cordialement, l\'équipe Fill.
------------------------------------------------------------------------------
Ceci est un mail automatique, Merci de ne pas y répondre.';

//Requiert le fichier "smtpParameters.php" contenant les informations de connexion (constantes)
    require_once 'smtpParameters.php';
// Création du message
    $Name = 'Fill | Suscribe Service';
    $email = 'fill@service.info';
    $header = 'De: ' . $Name . ' <' . $email . '>\r\n';
    $mail = mail('' . $mailbox, 'Fill | Activation de votre compte', $messageToSend, $header);
}