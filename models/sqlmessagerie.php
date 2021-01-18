<?php
require_once 'sqlparameters.php';
try {
    //Récupération des informations de la table messages.
    $messageQueryStat = $db->prepare("SELECT `id`, `expeditorid`, `object`, DATE_FORMAT(`sended_at`, 'le %d/%m/%Y\ à %HH%i') `sended_at_formatted`, `alreadyread` FROM `messages` WHERE `recieverid` = :sessionid ORDER BY `alreadyread`, `sended_at` DESC LIMIT $start, $limit");;
    $messageQueryStat->bindValue(':sessionid', $_SESSION['id'], PDO::PARAM_INT);
    $messageQueryStat->execute();
    $messageList = $messageQueryStat->fetchAll(PDO::FETCH_ASSOC);
} catch (Exception $ex) {
    die('Connexion échoué');
}
//Si l'utilisateur n'a aucun message, on l'avertit.
if (!$messageList){
    echo '<h1 class="bg-light text-center opacity">Vous n\'avez aucun message.</h1>';
}
//Sinon on affiche la liste des messages
else{
?>
<div class="row" style="justify-content: center">
    <table class="table table-border table-striped table-sm bg-info p-0 m-0 mt-2 col-12">
        <thead class="text-light">
            <tr>
                <th>Objet :</th>
                <th>Expéditeur :</th>
                <th>Date d'envoi :</th>
            </tr>
        </thead>
        <tbody>
<?php
foreach ($messageList AS $message):
    //Si c'est un message non lu affiche une petite cloche rouge à côté
    if ($message['alreadyread'] === '0'){
        $message['object'] = '<a title="' .$message['object']. '" href="message.php?id=' .$message['id']. '"><i class="fa fa-bell" style="color: darkred" aria-hidden="true"></i> ' .$message['object']. '</a>';
    }
    else{
        $message['object'] = '<a title="' .$message['object']. '" href="message.php?id=' .$message['id']. '">' .$message['object']. '</a>';
    }
    try {
        $query = 'SELECT `pseudo`, `accounttype` FROM `users` WHERE id =' . $message['expeditorid'];
        $userQueryStat = $db->query($query);
        $userList = $userQueryStat->fetchAll(PDO::FETCH_ASSOC);
        foreach ($userList AS $user) {
            $id = $message['expeditorid'];
            $pseudo = $user['pseudo'];
            //Si l'expéditeur est un compositeur on met le lien vers sa page.
            if ($user['accounttype'] === 'compositor'){
                $sender = '<a title="Profil compositeur | ' .$pseudo. '" href="compositor.php?id=' .$id. '">' .$pseudo. '</a>';
            }
            else{
                $sender = $pseudo;
            }
        }
    } catch (Exception $ex) {
        die('Connexion échoué');
    }
    if($message['alreadyread'] === '1'):
    ?>
    <tr class="bg-light">
        <td><?= $message['object'] ?></td>
        <td><?= $sender ?></td>
        <td><i><?= $message['sended_at_formatted'] ?></i></td>
    </tr>
<?php endif;
if ($message['alreadyread'] === '0'): ?>
    <tr class="shadow">
        <td><?= $message['object'] ?></td>
        <td><?= $sender ?></td>
        <td><i><?= $message['sended_at_formatted'] ?></i></td>
    </tr>
<?php
endif;
endforeach;
?>
</tbody>
</table>
</div>
<?php
}
