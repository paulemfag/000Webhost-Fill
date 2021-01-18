<?php
require_once 'sqlparameters.php';
//récupère les informations du topic grace à l'id
$messageId = $_GET['id'];
//Récupération du titre du sujet.
try {
    $sth = $db->prepare("SELECT `id`, `recieverid`, `expeditorid`, DATE_FORMAT(`sended_at`, 'le %d/%m/%Y\ à %HH%i') `sended_at_formatted`, `alreadyread`, `object`, `message` FROM `messages` WHERE `id` = :id");
    $sth->bindValue(':id', $messageId, PDO::PARAM_INT);
    $sth->execute();
    $messageFetch = $sth->fetchAll(PDO::FETCH_ASSOC);
    //Si on ne trouve pas le message / qu'il n'existe pas, redirige vers la messagerie.
    if (!$messageFetch){
        header('location:messagerie.php?page=1');
        exit();
    }
    foreach ($messageFetch as $message) {
        $date = $message['sended_at_formatted'];
        $idmessage = $message['id'];
        $object = $message['object'];
        $Message = $message['message'];
        $expeditorId = $message['expeditorid'];
        $recieverid = $message['recieverid'];
        $alreadyread = $message['alreadyread'];
    }
    //Si le message ne nous est pas destiné on redirige vers la messagerie.
    session_start();
    if ($_SESSION['id'] !== $recieverid) {
        header('location:messagerie.php?page=1');
        exit();
    }
    session_abort();
    //Si c'est la première fois que l'utilisateur lis le message le définit comme lu.
    if ($alreadyread === '0'){
        try {
            $sth = $db->prepare('UPDATE `messages` SET `alreadyread` = 1 WHERE `id` = :id');
            $sth->bindValue(':id', $idmessage, PDO::PARAM_INT);
            $sth->execute();
        } catch (PDOException $e) {
            echo "Erreur : " . $e->getMessage();
        }
    }
    //Si l'utilisateur a confirmé la suppression du message à l'aide de la modal.
    if($_GET['delete'] === 'ok'){
        $sth = $db->prepare('DELETE FROM messages WHERE `id` = :idmessage');
        $sth->bindValue(':idmessage', $_GET['id'], PDO::PARAM_INT);
        $sth->execute();
        header('location:messagerie.php?page=1&success=1&objet='. $object);
        exit();
    }
    try {
        $sth = $db->prepare('SELECT `pseudo`, `accounttype` FROM `users` WHERE `id` = :id');
        $sth->bindValue(':id', $expeditorId, PDO::PARAM_INT);
        $sth->execute();
        $userList = $sth->fetchAll(PDO::FETCH_ASSOC);
        foreach ($userList as $user) {
            $pseudo = $user['pseudo'];
            //Si l'expéditeur est un compositeur on met le lien vers sa page.
            if ($user['accounttype'] === 'compositor') {
                $sender = '<a title="Profil compositeur | ' . $pseudo . '" href="compositor.php?id=' . $expeditorId . '">' . $pseudo . '</a>';
            } else {
                $sender = $pseudo;
            }
        }
    } catch (Exception $ex) {
        die('Connexion échoué');
    }
} catch (Exception $ex) {
    die('Connexion échoué !');
}
