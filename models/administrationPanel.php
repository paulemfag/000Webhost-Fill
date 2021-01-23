<?php
try {
    $query = $db->prepare('SELECT `role` FROM `users` WHERE `id` = :id');
    $query->bindValue(':id', $_SESSION['id'], PDO::PARAM_INT);
    $query->execute();
    $userList = $query->fetchAll(PDO::FETCH_ASSOC);
    foreach ($userList AS $user) {
        $role = $user['role'];
    }
} catch (Exception $ex) {
    die('Connexion échoué');
}
$usersQueryStat = $db->query("SELECT `id`, `pseudo`, `active`, `role`, `mailBox`, `accounttype` FROM `users` LIMIT $start , $limit");
$usersList = $usersQueryStat->fetchAll(PDO::FETCH_ASSOC);
//Récupération de l'id en GET quand on clique sur le bouton supprimmer l'utilisateur.
if (isset($_GET['id']) && filter_input(INPUT_GET,'id', FILTER_SANITIZE_NUMBER_INT)){
    //création d'une variable pour stocker la valeur
    $idGet = $_GET['id'];
    //Suppression de l'utilisateur dans la BDD.
    try {
        $sth = $db->prepare('DELETE FROM `users` WHERE `id` = ?');
        $sth->execute([$idGet]);
        //Message avertissant de la bonne suppression du compte et redirection vers la page d'administration pour vérifier les changements
        ?>
        <script>
            alert("L'utilisateur a bien été supprimé");
            function redir(){
                self.location.href="administrationPanel.php?page=1"
            }
            redir();
        </script><?php
    } catch (PDOException $e) {
        echo "Erreur : " . $e->getMessage();
    }
}
