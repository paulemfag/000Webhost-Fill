<?php
if (!filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT)){
    header('location:accueil.php');
    exit();
}
require_once '../models/sqlplaylistPagination.php';
require_once '../models/sqlplaylist.php';
//Si la playlist n'existe pas (récupération du titre) redirige vers l'accueil
if ($playlistTitle == NULL){
    header('location:accueil.php');
    exit();
}
require_once 'require/header.php';
echo $successfulDelete ?? '';
?>
<div class="row">
    <h1 class="text-center bg-light col-10 opacity mt-3 ml-auto mr-auto">Playlist | <?= $playlistTitle ?> :</h1>
</div>
<div class="container text-light text-center">
    <a title="Changer le titre de la playlist <?= $playlistTitle ?>" class="col-12 btn btn-success" href="playlistUpdate.php?id=<?= $_GET['id'] ?>">Changer le titre de la playlist</a>
    <a title="Suprimmer la playlist <?= $playlistTitle ?>" class="col-12 mt-2 btn btn-danger" data-toggle="modal" data-target="#deletePlaylist">
        Suprimmer la playlist
    </a>
    <?php //Pagination si il n'y a pas qu'une seule page
    if ($pages > 1) : ?>
        <nav class="col-md-12 mt-2 d-flex justify-content-center">
            <ul class="pagination custom-pagination">
                <?php //Si on ne se trouve pas sur la première page.
                if ($page != 1) : ?>
                    <li class="page-item"><a class="page-link" href="playlist.php?id=<?= $idPlaylist ?>&page=1" aria-label="Previous"><span aria-hidden="true">&laquo;&laquo; Première page</span></a></li>
                    <li class="page-item"><a class="page-link" href="playlist.php?id=<?= $idPlaylist ?>&page=<?= $previous; ?>" aria-label="Previous"><span aria-hidden="true">&laquo; Page précédenter</span></a></li>
                <?php endif; ?>
                <li>
                    <select class="form-control" onchange="location = this.value;">
                        <?php for($i = 1; $i<= $page - 1; $i++) : ?>
                            <option value="playlist.php?id=<?= $idPlaylist ?>&page=<?= $i ?>"><?= $i ?></option>
                        <?php endfor; ?>
                        <option value="playlist.php?id=<?= $idPlaylist ?>&page=<?= $page ?>" disabled selected><?= $page ?></option>
                        <?php for($i = $page + 1; $i<= $pages; $i++) : ?>
                            <option value="playlist.php?id=<?= $idPlaylist ?>&page=<?= $i ?>"><?= $i ?></option>
                        <?php endfor; ?>
                    </select>
                </li>
                <?php //Si on ne se trouve pas sur la dernière page.
                if ($pages != $page) : ?>
                    <li class="page-item"><a class="page-link" href="playlist.php?id=<?= $idPlaylist ?>&page=<?= $next; ?>" aria-label="Next"><span aria-hidden="true">Page suivante &raquo;</span></a></li>
                    <li class="page-item"><a class="page-link" href="playlist.php?id=<?= $idPlaylist ?>&page=<?= $pages; ?>" aria-label="Next"><span aria-hidden="true">Dernière page &raquo;&raquo;</span></a></li>
                <?php endif; ?>
            </ul>
        </nav>
    <?php endif; ?>
    <!--Modal Suprimmer la playlist-->
    <div class="modal fade" id="deletePlaylist" tabindex="-1" role="dialog" aria-labelledby="deletePlaylist" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h3 class="modal-title text-center">Êtes vous sur de vouloir suprimmer la playlist <?= $playlistTitle ?> ?</h3>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-footer">
                    <button type="button" class="mr-auto ml-auto btn btn-danger" data-dismiss="modal">Annuler la suppression</button>
                    <a href="playlist.php?id=<?= $_GET['id'] ?>&page=<?= $_GET['page'] ?>&playlistDelete=1" class="mr-auto ml-auto btn btn-success">Suprimmer la playlist</a>
                </div>
            </div>
        </div>
    </div>
    <?php if(empty($compositionsList)): ?>
<div class="row">
    <h1 class="text-center bg-light col-10 opacity mt-3 ml-auto mr-auto">Cette playlist ne contient aucun titre pour le moment.</h1>
</div>
<?php endif; ?>
</div>
<?php if(!empty($compositionsList)): ?>
<table class="table-striped container mt-2 compositionsTables">
        <thead class="text-center">
        <tr>
        <th class="col-2 float-left">Titre :</th>
        <th class="col-2 float-left">Pseudo du compositeur:</th>
        <th class="col-2 float-left">Style :</th>
        <th class="col-3 float-left">Fichier :</th>
        <th class="col-3 float-left">Supprimer :</th>
        </tr>
        </thead>
        <tbody class="text-center">
        <?php foreach ($compositionsList as $value):?>
            <tr>
                <td class="col-2 float-left"><a rel="noopener" class="text-dark" target="_blank" title="Page composition | <?= $value['title'] ?>" href="composition.php?id=<?= $value['compositionid'] ?>"><?= $value['title'] ?></a></td>
                <td class="col-2 float-left"><a rel="noopener" class="text-dark" target="_blank" title="Page compositeur | <?= $value['pseudo'] ?>" href="compositor.php?id=<?= $value['id'] ?>"><?= $value['pseudo'] ?></a></td>
                <td class="col-2 float-left"><a rel="noopener" class="text-dark" target="_blank" title="Page style | <?= $value['style'] ?>" href="stylePage.php?style=<?= $value['style'] ?>"><?= $value['style'] ?></a></td>
                <td class="col-3 float-left"><audio style="height: 20px;" controls controlsList="nodownload">
                        <source src="<?= $value['file'] ?>">
                    </audio>
                </td>
                <td class="col-3 float-left"><a title="Suprimmer la composition : <?= $value['title'] ?>" class="col-3 mr-auto btn-sm btn-outline-danger text-center" href="playlist.php?id=<?= $_GET['id'] ?>&page=<?= $_GET['page'] ?>&idcomposition=<?= $value['compositionid'] ?>"><i class="col-3 fas fa-trash-alt"></i></a></td>
            </tr>
        <?php endforeach; ?>
        </tbody>
</table>
<!--Modal Suprimmer la composition-->
<div class="modal fade" id="deleteComposition" tabindex="-1" role="dialog" aria-labelledby="deleteComposition" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title text-center">Êtes vous sur de vouloir suprimmer la composition de la playlist ?</h3>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-footer">
                <button type="button" class="mr-auto ml-auto btn btn-danger" data-dismiss="modal">Annuler la suppression</button>
                <a href="playlist.php?id=<?= $_GET['id'] ?>&page=<?= $_GET['page'] ?>&idcomposition=<?= $_GET['idcomposition'] ?>&delete=1" id="<?= $_GET['idcomposition'] ?>" class="text-light mr-auto ml-auto btn btn-success">Suprimmer la composition</a>
            </div>
        </div>
    </div>
</div>
<div class="container">
    <?php //Pagination si il n'y a pas qu'une seule page
    if ($pages > 1) : ?>
        <nav class="col-md-12 mt-2 d-flex justify-content-center">
            <ul class="pagination custom-pagination">
                <?php //Si on ne se trouve pas sur la première page.
                if ($page != 1) : ?>
                    <li class="page-item"><a class="page-link" href="playlist.php?id=<?= $idPlaylist ?>&page=1" aria-label="Previous"><span aria-hidden="true">&laquo;&laquo; Première page</span></a></li>
                    <li class="page-item"><a class="page-link" href="playlist.php?id=<?= $idPlaylist ?>&page=<?= $previous; ?>" aria-label="Previous"><span aria-hidden="true">&laquo; Page précédenter</span></a></li>
                <?php endif; ?>
                <li>
                    <select class="form-control" onchange="location = this.value;">
                        <?php for($i = 1; $i<= $page - 1; $i++) : ?>
                            <option value="playlist.php?id=<?= $idPlaylist ?>&page=<?= $i ?>"><?= $i ?></option>
                        <?php endfor; ?>
                        <option value="playlist.php?id=<?= $idPlaylist ?>&page=<?= $page ?>" disabled selected><?= $page ?></option>
                        <?php for($i = $page + 1; $i<= $pages; $i++) : ?>
                            <option value="playlist.php?id=<?= $idPlaylist ?>&page=<?= $i ?>"><?= $i ?></option>
                        <?php endfor; ?>
                    </select>
                </li>
                <?php //Si on ne se trouve pas sur la dernière page.
                if ($pages != $page) : ?>
                    <li class="page-item"><a class="page-link" href="playlist.php?id=<?= $idPlaylist ?>&page=<?= $next; ?>" aria-label="Next"><span aria-hidden="true">Page suivante &raquo;</span></a></li>
                    <li class="page-item"><a class="page-link" href="playlist.php?id=<?= $idPlaylist ?>&page=<?= $pages; ?>" aria-label="Next"><span aria-hidden="true">Dernière page &raquo;&raquo;</span></a></li>
                <?php endif; ?>
            </ul>
        </nav>
    <?php endif; ?>
</div>
<?php endif;
require_once 'require/footer.php'; ?>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<?php if($show_modal_composition):?>
    <script src="../assets/js/playlist_min.js"></script>
<?php endif; ?>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"
        integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1"
        crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"
        integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM"
        crossorigin="anonymous"></script>
</body>
</html>