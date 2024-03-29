<?php
$id = $_SESSION['id'];
//Récupération de la liste des playlists de l'utilisateur
try {
    $sth = $db->prepare('SELECT `id`, `title` FROM `playlists` WHERE `id_users` = :id ORDER BY `title` ASC');
    $sth->bindValue(':id', $id, PDO::PARAM_INT);
    $sth->execute();
    $playlists = $sth->fetchAll(PDO::FETCH_ASSOC);
} catch (Exception $ex) {
    die('Connexion échoué');
}
try {
    //Récupération des informations de la table composition selon le style
    $stmt = $db->prepare("SELECT 
compositions.id, 
compositions.title, 
compositions.file, 
compositions.id_users,
users.pseudo
FROM `compositions` 
JOIN `categories` 
ON compositions.title = categories.title
AND categories.style = :style 
JOIN `users`
ON compositions.id_users = users.id
ORDER BY title ASC 
LIMIT $start , $limit");
    if ($stmt->execute(array(':style' => $style)) && $row = $stmt->fetchAll(PDO::FETCH_ASSOC)) {
        ?>
        <table class="container compositionsTables mt-2 text-center">
            <thead>
            <tr>
                <th>Nom de la composition :</th>
                <th>Compositeur :</th>
                <th>Morceau :</th>
                <th>Ajouter à une Playlist :</th>
            </tr>
            </thead>
            <tbody>
        <?php
        //Pour chaque composition
        $i = 0;
        $playlistListIdNumber = 1;
        foreach ($row as $rowInfo) {
            $i++;
            $playlistListIdNumber++;
            //génération des cases du tableau
            $composition =
                '<tr>
            <td><a class="text-dark" title="Page composition | ' .$rowInfo['title']. '" href="composition.php?id=' .$rowInfo['id']. '">' .$rowInfo['title']. '</a></td>
            <td><a class="text-dark" title="Profil compositeur | ' .$rowInfo['pseudo']. '" href="compositor.php?id=' .$rowInfo['id_users']. '">' .$rowInfo['pseudo']. '</a></td>
            <td> 
            <audio class="Audio" preload="auto" controls controlsList="nodownload">
            <source src="' . $rowInfo['file'] . '" type="audio/mp3">
            </audio>
            </td>
            <td><a href="#" class="mt-1 dropdown-toggle mb-1 btn btn-sm btn-success" id="playlistList' .$playlistListIdNumber. '" data-toggle="dropdown"  aria-haspopup="true" aria-expanded="false">Ajouter a la playlist <i class="fas fa-plus"></i></a>
                        <div class="dropdown-menu" aria-labelledby="playlistList' .$playlistListIdNumber. '">';
            //déclaration d'une variable récupérant l'affichage pour chaque playlist
            foreach ($playlists as $playlist) {
                $composition = $composition .'<a class="dropdown-item" href="stylePage.php?style=' . $style . '&idPlaylist=' . $playlist['id'] . '&idComposition=' . $rowInfo['id'] . '">' . $playlist['title'] . '</a>';
            }
                $composition = $composition .'</div>
                        </td>
            </tr>';
            echo $composition;
        }
        ?>
            </tbody>
        </table>
        <?php
    }
    else{
        echo '<div class="row">
                <h1 class="text-center bg-light col-10 opacity mt-2 ml-auto mr-auto">Cette catégorie ne contient aucune compositions pour le moment.</h1>
              </div>';
    }
} catch (PDOException $e) {
    echo "Erreur : " . $e->getMessage();
}
if (filter_input(INPUT_GET, 'idPlaylist', FILTER_SANITIZE_NUMBER_INT) && filter_input(INPUT_GET, 'idComposition', FILTER_SANITIZE_NUMBER_INT)) {
    try {
        $sth = $db->prepare('SELECT `title` FROM `playlists` WHERE `id` = :id');
        $sth->bindValue(':id', $_GET['idPlaylist'], PDO::PARAM_INT);
        $sth->execute();
        $playlistExist = $sth->fetchAll(PDO::FETCH_ASSOC);
        $addToPlaylistStatus = '
        <div class="alert alert-success alert-dismissible fade show" role="alert">
          <p>La composition a bien été ajoutée à la playlist.</p>
          <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>';
    } catch (Exception $ex) {
        die('Connexion échoué');
    }
    if ($playlistExist){
        $addToPlaylistStatus = '
        <div class="alert alert-success alert-dismissible fade show" role="alert">
          <p>La composition a bien été ajoutée à la playlist.</p>
          <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>';
    }
   /* try {
        $stmt = $db->prepare('INSERT INTO `compo_in_playlist` (`id_compositions`, `id_playlists`) VALUES (:idComposition, :idPlaylist)');
        $stmt->bindParam(':idComposition', $_GET['idComposition'], PDO::PARAM_STR);
        $stmt->bindParam(':idPlaylist', $_GET['idPlaylist'], PDO::PARAM_INT);
        $stmt->execute();
    } catch (PDOException $e) {
        echo "Erreur : " . $e->getMessage();
    }*/
}