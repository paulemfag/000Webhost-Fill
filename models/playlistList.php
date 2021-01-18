<?php
require_once 'sqlparameters.php';
$id = $_SESSION['id'];
try {
    $sth = $db->prepare('SELECT `id`, `title` FROM `playlists` WHERE `id_users` = :id ORDER BY `title` ASC');
    $sth->bindValue(':id', $id, PDO::PARAM_INT);
    $sth->execute();
    $playlists = $sth->fetchAll(PDO::FETCH_ASSOC);
} catch (Exception $ex) {
    die('Connexion échoué');
}
foreach ($playlists as $playlist){
    echo '<a class="dropdown-item" target="_blank" rel="noopener noreferrer" href="playlist.php?id='. $playlist['id'] .'&page=1">'. $playlist['title'] .'</a>';
}