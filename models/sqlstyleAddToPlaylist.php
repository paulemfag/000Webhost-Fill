<?php
if (filter_input(INPUT_GET, 'idPlaylist', FILTER_SANITIZE_NUMBER_INT) && filter_input(INPUT_GET, 'idComposition', FILTER_SANITIZE_NUMBER_INT)) {
    //Si la playlist existe.
    try {
    $sth = $db->prepare('SELECT `title` FROM `playlists` WHERE `id` = :id');
    $sth->bindValue(':id', $_GET['idPlaylist'], PDO::PARAM_INT);
    $sth->execute();
    $playlistExist = $sth->fetchAll(PDO::FETCH_ASSOC);
        //Si la playlist existe.
        if ($playlistExist){
            try {
                $sth = $db->prepare('SELECT `id` FROM `compo_in_playlist` WHERE `id_playlists` = :id_playlists AND id_compositions = :id_compositions');
                $sth->bindValue(':id_playlists', $_GET['idPlaylist'], PDO::PARAM_INT);
                $sth->bindValue(':id_compositions', $_GET['idComposition'], PDO::PARAM_INT);
                $sth->execute();
                if($compoInDb = $sth->fetch()){
                    $addToPlaylistStatus = '
                    <div class="alert alert-warning alert-dismissible fade show" role="alert">
                        <p>La composition a déjà été ajoutée à votre playlist.</p>
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>';
                } else{
                    //Si la composition n'est pas déjà dans la playlist.
                    try {
                        $stmt = $db->prepare('INSERT INTO `compo_in_playlist` (`id_compositions`, `id_playlists`) VALUES (:idComposition, :idPlaylist)');
                        $stmt->bindParam(':idComposition', $_GET['idComposition'], PDO::PARAM_STR);
                        $stmt->bindParam(':idPlaylist', $_GET['idPlaylist'], PDO::PARAM_INT);
                        if($stmt->execute()){
                            $addToPlaylistStatus = '
                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                <p><i class="far fa-check-circle"></i> La composition a bien été ajoutée à la playlist.</p>
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>';
                        }
                    } catch (PDOException $e) {
                        $addToPlaylistStatus = '
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <p>Une erreur est survenue, merci de réessayer ultérieurement.</p>
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>';
                    }
                }
            } catch (Exception $ex) {
                $addToPlaylistStatus = '
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <p>Une erreur est survenue, merci de réessayer ultérieurement.</p>
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>';
            }
            //Si la composition n'est pas déjà dans la playlist.
        } else{
            $addToPlaylistStatus = '
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <p>Une erreur est survenue, merci de réessayer ultérieurement.</p>
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>';
        }
    } catch (Exception $ex) {
        $addToPlaylistStatus = '
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <p>Une erreur est survenue, merci de réessayer ultérieurement.</p>
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>';
    }
}