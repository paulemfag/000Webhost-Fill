<?php
$title = 'Fill | Panel d\'administration';
require_once 'require/header.php';
require_once '../models/sqladministrationPanelPagination.php';
require_once '../models/administrationPanel.php';
$title = 'Fill | Administration Panel';
session_start();
if ($_SESSION['pseudo'] === 'paulemfag'){
?>
<div class="container text-center bg-light mt-2 opacity">
    <h1>Panel d'administration :</h1>
</div>
<table class="mt-2 table-striped compositionsTables container">
    <thead class="text-center">
    <th>ID :</th>
    <th>Pseudo :</th>
    <th>Actif :</th>
    <th>Rôle :</th>
    <th>Adresse mail :</th>
    <th>Type de compte :</th>
    <th>Nombre de messages publiés :</th>
    <th>Suprimmer :</th>
    </thead>
    <tbody>
    <?php foreach } ($usersList AS $user):
    if($user['rôle'] === 1){ $user['rôle'] === 'Admin' }?>
        <tr class="text-center">
            <td><?= $user['id'] ?></td>
            <td><a class="text-dark" href="compositor.php?id=<?= $user['id'] ?>"><?= $user['pseudo'] ?></a></td>
            <td><?= $user['active'] ?></td>
            <td><?= $user['rôle'] ?></td>
            <td><?= $user['mailBox'] ?></td>
            <td><?= $user['accounttype'] ?></td>
            <td><?= $user['number_of_messages'] ?></td>
            <td><a name="submit" href="<?= '?id='. $user['id'] ?>&page=<?= $_GET['page'] ?>" class="btn btn-sm btn-danger mt-1 mb-1 delete" type="submit"><i class="fas fa-user-times"></i></a></td>
        </tr>
    <?php endforeach; ?>
    </tbody>
</table>
    <div class="row bg-info" id="audioPlayer">
        <div id="audioVolDiv">
            <input id="audioVol" type="text" name="audioVol" value="1">
        </div>
        <div id="audioProgDiv">
            <input id="audioProg" type="text" name="audioProg">
        </div>
        <div id="audioProgStyleDiv">
            <input id="audioProgStyle" type="text" name="audioProg-style">
        </div>
        <div id="controls">
            <div id="repeatButton" data-repeat="none"><img src="img/repeat/repeat-none.svg"></div>
            <div id="backButton" class="disabled"><i class="fas fa-step-backward"></i></div>
            <div id="playButton"><i class="fas fa-play"></i></div>
            <div id="pauseButton"><i class="fas fa-pause"></i></div>
            <div id="skipButton"><i class="fas fa-step-forward"></i></div>
        </div>
        <div id="loadingDiv">
            <img id="loadingAnim" src="img/loading.gif" alt="Loading">
        </div>
        <div id="playlistControl">
            <div id="audioInputDiv">
                <input id="audioInput" type="text" name="audioInput" placeholder="Direct Audio Stream URL (Direct URL to file download). mp3fiber.com can be used to get such a URL">
                <div id="audioInputBtn"><i class="fas fa-plus"></i></div>
            </div>
            <div id="playlistView"></div>
        </div>
    </div>

    <?php //Pagination si il n'y a pas qu'une seule page
if ($pages > 1) : ?>
    <nav class="col-md-12 mt-2 d-flex justify-content-center">
        <ul class="pagination custom-pagination">
            <?php //Si on ne se trouve pas sur la première page.
            if ($page != 1) : ?>
                <li class="page-item"><a class="page-link" href="administrationPanel.php?page=1" aria-label="Previous"><span aria-hidden="true">&laquo;&laquo; Première page</span></a></li>
                <li class="page-item"><a class="page-link" href="administrationPanel.php?page=<?= $previous; ?>" aria-label="Previous"><span aria-hidden="true">&laquo; Page précédenter</span></a></li>
            <?php endif; ?>
            <li>
                <select class="form-control" onchange="location = this.value;">
                    <?php for($i = 1; $i<= $page - 1; $i++) : ?>
                        <option value="administrationPanel.php?page=<?= $i ?>"><?= $i ?></option>
                    <?php endfor; ?>
                    <option value="administrationPanel.php?page=<?= $page ?>" disabled selected><?= $page ?></option>
                    <?php for($i = $page + 1; $i<= $pages; $i++) : ?>
                        <option value="administrationPanel.php?page=<?= $i ?>"><?= $i ?></option>
                    <?php endfor; ?>
                </select>
            </li>
            <?php //Si on ne se trouve pas sur la dernière page.
            if ($pages != $page) : ?>
                <li class="page-item"><a class="page-link" href="administrationPanel.php?page=<?= $next; ?>" aria-label="Next"><span aria-hidden="true">Page suivante &raquo;</span></a></li>
                <li class="page-item"><a class="page-link" href="administrationPanel.php?page=<?= $pages; ?>" aria-label="Next"><span aria-hidden="true">Dernière page &raquo;&raquo;</span></a></li>
            <?php endif; ?>
        </ul>
    </nav>
<?php endif; ?>
<?php require_once 'require/footer.php'; ?>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script src="/../audio-player-master/assets/js/jquery-ui.min.js"></script>
<script src="/path/to/jquery.knob.min.js"></script>
<script src="js/audioPlayer.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"
        integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1"
        crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"
        integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM"
        crossorigin="anonymous"></script>

    <script>
        playlist:[
    {
    localFile:"_EnV_ - Heaven.mp3",
    hostedFile:"https://dl.dropboxusercontent.com/s/9pamibo40ycabe1/_EnV_%20-%20Heaven.mp3"
    },
    {
    localFile:"ｉ ｎ ｔ ｅ ｒ ｓ ｐ ａ ｃ ｅ.mp3",
    hostedFile:"https://dl.dropboxusercontent.com/s/p07gh6bur678t5t/%EF%BD%89%20%EF%BD%8E%20%EF%BD%94%20%EF%BD%85%20%EF%BD%92%20%EF%BD%93%20%EF%BD%90%20%EF%BD%81%20%EF%BD%83%20%EF%BD%85.mp3"
    },
    {
    localFile:"Getting Stronger - Michelle Creber Black Gryph0n Baasik.mp3",
    hostedFile:"https://dl.dropboxusercontent.com/s/mw28fr4lt64mhzt/Getting%20Stronger%20-%20Michelle%20Creber%20Black%20Gryph0n%20Baasik.mp3"
    },  333333333333333333333333333333333333333333333333333333333333333333333333333333333333333333333333333333333333333333333333333333333333333333333333333333333333333333333333333333333333333333333333333333333333333333333333333333333333333333333333333333333333333333333333333333333333333333333333333333333333333333333333333333333333333333333333333333333333333333333333333333333333333333333333333333333333333333333333333333333333333333333333
    ...
    ],
</script>
    </body>
</html>
<?php
else{
    header('location:../views/accueil.php');
    exit();
}
