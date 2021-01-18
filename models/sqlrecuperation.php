<?php
require_once 'sqlparameters.php';
//Vérification de l'existence du compte en BDD
try {
    $sth = $db->prepare('SELECT * FROM `users` WHERE `mailBox` = :mailBox');
    $sth->bindValue(':mailBox', $recuperationMailbox, PDO::PARAM_STR);
    $sth->execute();
    $userInformations = $sth->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    echo "Erreur : " . $e->getMessage();
}
//suprimme l'ancienne clé en BDD au cas ou une demande aurait déjà été effectué
try {
    $sth = $db->prepare('DELETE FROM `password_reset_temp` WHERE `email` = :mailBox');
    $sth->bindValue(':mailBox', $recuperationMailbox, PDO::PARAM_STR);
    $sth->execute();
} catch (PDOException $e) {
    echo "Erreur : " . $e->getMessage();
}
if (empty($userInformations)) {
    $errors['recuperationMailbox'] = 'Aucun compte n\'est associé à l\'adresse ' . $recuperationMailbox . '.';
} else {
    $expFormat = mktime(
        date("H"), date("i"), date("s"), date("m"), date("d") + 1, date("Y")
    );
    $expDate = date('Y-m-d H:i:s', $expFormat);
    $key = md5(microtime(TRUE) * 100000);
    $addKey = substr(md5(uniqid(rand(), 1)), 3, 10);
    $key = $key . $addKey;
    try {
        // Insertion dans la table temporaire
        $sth = $db->prepare('INSERT INTO `password_reset_temp` (`email`, `key`, `expiration_date`) VALUES (:mailBox, :recuperationKey, :expDate)');
        $sth->bindValue(':mailBox', $recuperationMailbox, PDO::PARAM_STR);
        $sth->bindValue(':recuperationKey', $key, PDO::PARAM_STR);
        $sth->bindValue(':expDate', $expDate, PDO::PARAM_STR);
        $sth->execute();
    } catch (PDOException $e){
        echo "Erreur : " . $e->getMessage();
    }
    //récupération du fichier requis
    require_once 'vendor/autoload.php';
    $messageToSend = 'Cher utilisateur,

Veuillez cliquer sur le lien suivant pour réinitialiser votre mot de passe.

https://filldemo.000webhostapp.com/views/reset-password.php?key=' . $key . '&email=' . $recuperationMailbox . ' ' .'

------------------------------------------------------------------------------
Merci de bien vouloir copier le lien entier dans votre navigateur.
Ce lien expirera après un jour pour des raisons de sécurité.

Si vous avez effectué plusieurs récupérations de mot de passe merci d\'effectuer la démarche avec le dernier lien reçu.

Si vous n\'êtes pas à l\'origine de cette demande, aucune action n\'est requise, votre mot de passe ne sera pas réinitialisé.
Cependant, vous devriez vous connecter à votre compte et changez votre mot de passe de sécurité car quelqu\'un l\'a peut-être deviné.

Cordialement, l\'équipe Fill.
------------------------------------------------------------------------------
Ceci est un mail automatique, Merci de ne pas y répondre.';

    //Requiert le fichier "smtpParameters.php" contenant les informations de connexion (constantes)
    require_once 'smtpParameters.php';
    $Name = 'Fill | Récupération Service';
    $email = 'fill@service.info';
    $header = 'De: '. $Name . ' <' . $email . '>\r\n';
    $mail = mail('' .$recuperationMailbox,'Fill | Récupération du mot de passe', $messageToSend, $header);
    if ($mail){
        $recuperationReturn = '
            <div class="alert alert-success alert-dismissible fade show" role="alert">
              <p>Un mail de récupération viens de vous être envoyé.</p>
              <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>';
    }
    else{
        $recuperationReturn = '
            <div class="alert alert-warning alert-dismissible fade show" role="alert">
              <p>Une erreur es survenue merci de réessayer ultérieurement.</p>
              <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>';
    }
}